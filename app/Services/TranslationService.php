<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $client;
    protected $baseUrl;
    protected $timeout;

    public function __construct()
    {
        $this->client = new Client();
        // Using LibreTranslate as free alternative (you can also use Google Translate API)
        $this->baseUrl = config('services.translation.base_url', 'https://libretranslate.com/api/v1');
        $this->timeout = 30;
    }

    /**
     * Detect the language of given text
     *
     * @param string $text
     * @return string|null Language code (e.g., 'en', 'es', 'fr') or null if detection fails
     */
    public function detectLanguage(string $text): ?string
    {
        try {
            // Cache key for language detection
            $cacheKey = 'lang_detect_' . md5($text);
            
            return Cache::remember($cacheKey, now()->addHours(24), function () use ($text) {
                try {
                    $response = $this->client->post($this->baseUrl . '/detect', [
                        'timeout' => 5, // Reduced timeout to 5 seconds
                        'form_params' => [
                            'q' => $text,
                        ],
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                        ],
                    ]);

                    $result = json_decode($response->getBody()->getContents(), true);
                    
                    if (isset($result[0]['language'])) {
                        return $result[0]['language'];
                    }

                    // If API response is invalid, fallback to pattern detection
                    return $this->fallbackLanguageDetection($text);
                } catch (\Exception $e) {
                    // If API fails, fallback to pattern detection
                    return $this->fallbackLanguageDetection($text);
                }
            });
        } catch (RequestException $e) {
            Log::error('Language detection failed: ' . $e->getMessage());
            
            // Fallback: Simple language detection based on character patterns
            return $this->fallbackLanguageDetection($text);
        } catch (\Exception $e) {
            Log::error('Language detection error: ' . $e->getMessage());
            
            // Fallback: Simple language detection based on character patterns
            return $this->fallbackLanguageDetection($text);
        }
    }

    /**
     * Translate text from source language to target language
     *
     * @param string $text
     * @param string $targetLang
     * @param string|null $sourceLang
     * @return array|null ['translatedText' => string, 'sourceLang' => string, 'targetLang' => string]
     */
    public function translateText(string $text, string $targetLang, ?string $sourceLang = null): ?array
    {
        try {
            // Detect source language if not provided
            if (!$sourceLang) {
                $sourceLang = $this->detectLanguage($text);
                if (!$sourceLang) {
                    return null;
                }
            }

            // Don't translate if source and target are the same
            if ($sourceLang === $targetLang) {
                return [
                    'translatedText' => $text,
                    'sourceLang' => $sourceLang,
                    'targetLang' => $targetLang,
                    'isOriginal' => true
                ];
            }

            // Cache key for translation
            $cacheKey = 'translation_' . md5($text . $sourceLang . $targetLang);
            
            return Cache::remember($cacheKey, now()->addDays(7), function () use ($text, $sourceLang, $targetLang) {
                $response = $this->client->post($this->baseUrl . '/translate', [
                    'timeout' => $this->timeout,
                    'form_params' => [
                        'q' => $text,
                        'source' => $sourceLang,
                        'target' => $targetLang,
                        'format' => 'text',
                    ],
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                ]);

                $result = json_decode($response->getBody()->getContents(), true);
                
                if (isset($result['translatedText'])) {
                    return [
                        'translatedText' => $result['translatedText'],
                        'sourceLang' => $sourceLang,
                        'targetLang' => $targetLang,
                        'isOriginal' => false
                    ];
                }

                return null;
            });
        } catch (RequestException $e) {
            Log::error('Translation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get supported languages
     *
     * @return array
     */
    public function getSupportedLanguages(): array
    {
        try {
            return Cache::remember('supported_languages', now()->addDays(1), function () {
                $response = $this->client->get($this->baseUrl . '/languages');
                $languages = json_decode($response->getBody()->getContents(), true);
                
                return collect($languages)->mapWithKeys(function ($lang) {
                    return [$lang['code'] => $lang['name']];
                })->toArray();
            });
        } catch (RequestException $e) {
            Log::error('Failed to get supported languages: ' . $e->getMessage());
            
            // Fallback to common languages
            return $this->getCommonLanguages();
        }
    }

    /**
     * Check if translation is needed based on user's preferred language
     *
     * @param string $messageLanguage
     * @param string $userPreferredLanguage
     * @return bool
     */
    public function needsTranslation(string $messageLanguage, string $userPreferredLanguage): bool
    {
        return $messageLanguage !== $userPreferredLanguage;
    }

    /**
     * Get language name from code
     *
     * @param string $code
     * @return string
     */
    public function getLanguageName(string $code): string
    {
        $languages = $this->getCommonLanguages();
        return $languages[$code] ?? strtoupper($code);
    }

    /**
     * Fallback language detection using character patterns
     *
     * @param string $text
     * @return string
     */
    protected function fallbackLanguageDetection(string $text): string
    {
        // Simple character-based detection
        if (preg_match('/[\x{4e00}-\x{9fff}]/u', $text)) {
            return 'zh'; // Chinese
        }
        
        if (preg_match('/[\x{3040}-\x{309f}\x{30a0}-\x{30ff}]/u', $text)) {
            return 'ja'; // Japanese
        }
        
        if (preg_match('/[\x{0400}-\x{04ff}]/u', $text)) {
            return 'ru'; // Russian
        }
        
        if (preg_match('/[\x{0590}-\x{05ff}]/u', $text)) {
            return 'he'; // Hebrew
        }
        
        if (preg_match('/[\x{0600}-\x{06ff}]/u', $text)) {
            return 'ar'; // Arabic
        }
        
        // Default to English for Latin scripts
        return 'en';
    }

    /**
     * Get common languages as fallback
     *
     * @return array
     */
    protected function getCommonLanguages(): array
    {
        return [
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'zh' => 'Chinese',
            'ar' => 'Arabic',
            'hi' => 'Hindi',
            'tr' => 'Turkish',
            'pl' => 'Polish',
            'nl' => 'Dutch',
            'sv' => 'Swedish',
            'da' => 'Danish',
            'no' => 'Norwegian',
            'fi' => 'Finnish',
            'th' => 'Thai',
            'vi' => 'Vietnamese',
            'id' => 'Indonesian',
            'ms' => 'Malay',
            'tl' => 'Filipino',
            'he' => 'Hebrew',
            'fa' => 'Persian',
            'ur' => 'Urdu',
            'bn' => 'Bengali',
            'ta' => 'Tamil',
            'te' => 'Telugu',
            'mr' => 'Marathi',
            'gu' => 'Gujarati',
            'kn' => 'Kannada',
            'ml' => 'Malayalam',
            'pa' => 'Punjabi',
            'ne' => 'Nepali',
            'si' => 'Sinhala',
            'my' => 'Myanmar',
            'km' => 'Khmer',
            'lo' => 'Lao',
            'ka' => 'Georgian',
            'am' => 'Amharic',
            'sw' => 'Swahili',
            'zu' => 'Zulu',
            'af' => 'Afrikaans',
        ];
    }
} 
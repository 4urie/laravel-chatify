<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Translation Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the translation service for automatic language detection
    | and translation. Supports LibreTranslate (free) and Google Translate.
    |
    */

    'translation' => [
        'driver' => env('TRANSLATION_DRIVER', 'libretranslate'), // libretranslate, google
        'base_url' => env('TRANSLATION_BASE_URL', 'https://translate.argosopentech.com/translate'),
        'api_key' => env('TRANSLATION_API_KEY'), // Required for Google Translate
        'timeout' => env('TRANSLATION_TIMEOUT', 30),
        'cache_ttl' => env('TRANSLATION_CACHE_TTL', 3600), // Cache translations for 1 hour
    ],

];

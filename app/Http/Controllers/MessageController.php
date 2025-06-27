<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }
    /**
     * Display a listing of users to chat with.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all users except the current user
        $users = User::where('id', '!=', Auth::id())
            ->withCount(['receivedMessages' => function ($query) {
                $query->where('sender_id', Auth::id())->where('is_read', false);
            }])
            ->get();

        // Get users with recent conversations
        $recentChats = collect();
        foreach ($users as $user) {
            $latestMessage = Auth::user()->latestMessageWith($user);
            if ($latestMessage) {
                $user->latest_message = $latestMessage;
                $user->unread_count = Auth::user()->unreadMessagesFrom($user);
                $recentChats->push($user);
            }
        }

        // Sort by latest message timestamp
        $recentChats = $recentChats->sortByDesc(function ($user) {
            return $user->latest_message->created_at ?? null;
        });

        return view('chat.index', compact('users', 'recentChats'));
    }

    /**
     * Show the conversation between logged-in user and selected user.
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        // Prevent users from chatting with themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('chat.index')->with('error', 'You cannot chat with yourself.');
        }

        // Get all users for sidebar
        $users = User::where('id', '!=', Auth::id())->get();

        // Get messages between current user and selected user
        $messages = Message::betweenUsers(Auth::id(), $user->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages from the selected user as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.show', compact('user', 'users', 'messages'));
    }

    /**
     * Send a message to another user.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id|different:' . Auth::id(),
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Detect the language of the message with fallback
        try {
            $detectedLanguage = $this->translationService->detectLanguage($request->message);
        } catch (\Exception $e) {
            \Log::error('Language detection failed in message sending: ' . $e->getMessage());
            $detectedLanguage = 'en'; // Default to English if detection fails
        }
        
        // Ensure we have a language code
        if (!$detectedLanguage) {
            $detectedLanguage = 'en';
        }

        // Create the message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'detected_language' => $detectedLanguage,
            'is_read' => false,
        ]);

        // Load the sender relationship for response
        $message->load('sender');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'formatted_time' => $message->created_at->format('M j, Y g:i A')
            ]);
        }

        return back()->with('success', 'Message sent successfully!');
    }

    /**
     * Get new messages for a conversation (AJAX endpoint).
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNewMessages(Request $request, User $user)
    {
        $lastMessageId = $request->get('last_message_id', 0);

        $newMessages = Message::betweenUsers(Auth::id(), $user->id)
            ->where('id', '>', $lastMessageId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark new messages from the user as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('id', '>', $lastMessageId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $newMessages->map(function ($message) {
                $currentUser = Auth::user();
                $needsTranslation = $message->detected_language && 
                                  $this->translationService->needsTranslation(
                                      $message->detected_language, 
                                      $currentUser->preferred_language
                                  );

                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->name,
                    'created_at' => $message->created_at->format('M j, Y g:i A'),
                    'is_current_user' => $message->sender_id === Auth::id(),
                    'detected_language' => $message->detected_language,
                    'needs_translation' => $needsTranslation,
                    'language_name' => $message->detected_language ? 
                                     $this->translationService->getLanguageName($message->detected_language) : null
                ];
            })
        ]);
    }

    /**
     * Translate a specific message
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function translateMessage(Request $request, Message $message)
    {
        // Check if user has access to this message (sender or receiver)
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $targetLang = $request->get('target_lang', Auth::user()->preferred_language);
        
        // If no detected language, try to detect it first
        if (!$message->detected_language) {
            $detectedLang = $this->translationService->detectLanguage($message->message);
            if ($detectedLang) {
                $message->update(['detected_language' => $detectedLang]);
            }
        }

        $translation = $this->translationService->translateText(
            $message->message,
            $targetLang,
            $message->detected_language
        );

        if (!$translation) {
            return response()->json(['error' => 'Translation failed'], 500);
        }

        return response()->json([
            'success' => true,
            'original_text' => $message->message,
            'translated_text' => $translation['translatedText'],
            'source_language' => $translation['sourceLang'],
            'target_language' => $translation['targetLang'],
            'source_language_name' => $this->translationService->getLanguageName($translation['sourceLang']),
            'target_language_name' => $this->translationService->getLanguageName($translation['targetLang']),
            'is_original' => $translation['isOriginal'] ?? false
        ]);
    }

    /**
     * Update user's preferred language
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePreferredLanguage(Request $request)
    {
        $request->validate([
            'preferred_language' => 'required|string|size:2'
        ]);

        Auth::user()->update([
            'preferred_language' => $request->preferred_language
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Preferred language updated successfully'
        ]);
    }


    /**
     * Get supported languages
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSupportedLanguages()
    {
        $languages = $this->translationService->getSupportedLanguages();
        
        return response()->json([
            'languages' => $languages
        ]);
    }
} 
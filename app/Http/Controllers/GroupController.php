<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Display list of groups for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's groups with latest message and member count
        $groups = $user->groups()
            ->with(['latestMessage.sender', 'members'])
            ->withCount('members')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get all users (for potential group creation)
        $users = User::where('id', '!=', $user->id)->get();

        return view('groups.index', compact('groups', 'users'));
    }

    /**
     * Show group chat.
     */
    public function show(Group $group)
    {
        $user = Auth::user();

        // Check if user is a member of the group
        if (!$group->hasMember($user)) {
            return redirect()->route('groups.index')->with('error', 'You are not a member of this group.');
        }

        // Get group messages with sender information
        $messages = $group->messages()->with('sender')->get();

        // Get all group members
        $members = $group->members()->get();

        // Get all users for adding new members (excluding current members)
        $availableUsers = User::whereNotIn('id', $members->pluck('id'))->get();

        // Check if current user is admin or creator
        $isAdmin = $group->isAdmin($user) || $group->isCreator($user);

        return view('groups.show', compact('group', 'messages', 'members', 'availableUsers', 'isAdmin'));
    }

    /**
     * Create a new group.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'members' => 'array',
            'members.*' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('group-images', 'public');
        }

        // Create the group
        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'created_by' => $user->id,
        ]);

        // Add creator as admin member
        $group->addMember($user, true);

        // Add selected members
        if ($request->has('members')) {
            foreach ($request->members as $memberId) {
                $member = User::find($memberId);
                if ($member) {
                    $group->addMember($member, false);
                }
            }
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Group created successfully!',
                'redirect' => route('groups.show', $group)
            ]);
        }
        
        return redirect()->route('groups.show', $group)
            ->with('success', 'Group created successfully!');
    }

    /**
     * Send a message to the group.
     */
    public function sendMessage(Request $request, Group $group)
    {
        $user = Auth::user();

        // Check if user is a member of the group
        if (!$group->hasMember($user)) {
            return response()->json(['success' => false, 'message' => 'You are not a member of this group.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required_without:file|string|max:1000',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $messageType = 'text';
        $filePath = null;
        $fileName = null;
        $messageContent = $request->message ?? '';

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('group-files', 'public');
            $fileName = $file->getClientOriginalName();
            
            // Determine message type
            if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $messageType = 'image';
            } else {
                $messageType = 'file';
            }

            if (empty($messageContent)) {
                $messageContent = $messageType === 'image' ? 'Sent an image' : 'Sent a file: ' . $fileName;
            }
        }

        // Detect language for text messages
        $detectedLanguage = null;
        if ($messageType === 'text' && $messageContent) {
            $detectedLanguage = $this->translationService->detectLanguage($messageContent);
        }

        // Create the message
        $groupMessage = GroupMessage::create([
            'group_id' => $group->id,
            'sender_id' => $user->id,
            'message' => $messageContent,
            'message_type' => $messageType,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'detected_language' => $detectedLanguage,
        ]);

        // Load sender relationship
        $groupMessage->load('sender');

        return response()->json([
            'success' => true,
            'message' => $groupMessage,
            'formatted_time' => $groupMessage->created_at->format('M j, Y g:i A'),
            'file_url' => $groupMessage->getFileUrl(),
        ]);
    }

    /**
     * Get new messages for a group (AJAX endpoint).
     */
    public function getNewMessages(Request $request, Group $group)
    {
        $user = Auth::user();

        // Check if user is a member of the group
        if (!$group->hasMember($user)) {
            return response()->json(['success' => false, 'message' => 'You are not a member of this group.'], 403);
        }

        $lastMessageId = $request->get('last_message_id', 0);

        $newMessages = $group->messages()
            ->with('sender')
            ->where('id', '>', $lastMessageId)
            ->get();

        $formattedMessages = $newMessages->map(function ($message) use ($user) {
            $needsTranslation = $message->detected_language && 
                              $this->translationService->needsTranslation(
                                  $message->detected_language, 
                                  $user->preferred_language
                              );
            
            return [
                'id' => $message->id,
                'message' => $message->message,
                'sender_name' => $message->sender->name,
                'sender_id' => $message->sender_id,
                'message_type' => $message->message_type,
                'file_url' => $message->getFileUrl(),
                'file_name' => $message->file_name,
                'formatted_time' => $message->created_at->format('M j, Y g:i A'),
                'detected_language' => $message->detected_language,
                'needs_translation' => $needsTranslation && $message->sender_id !== $user->id,
                'language_name' => $message->detected_language ? 
                                $this->translationService->getLanguageName($message->detected_language) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $formattedMessages,
            'last_message_id' => $newMessages->last()->id ?? $lastMessageId,
        ]);
    }

    /**
     * Add a member to the group.
     */
    public function addMember(Request $request, Group $group)
    {
        $user = Auth::user();

        // Check if user is admin or creator
        if (!$group->isAdmin($user) && !$group->isCreator($user)) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to add members.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $newMember = User::find($request->user_id);

        if ($group->hasMember($newMember)) {
            return response()->json(['success' => false, 'message' => 'User is already a member of this group.'], 400);
        }

        $group->addMember($newMember, false);

        return response()->json([
            'success' => true,
            'message' => 'Member added successfully!',
            'member' => [
                'id' => $newMember->id,
                'name' => $newMember->name,
                'email' => $newMember->email,
                'is_admin' => false,
            ]
        ]);
    }

    /**
     * Remove a member from the group.
     */
    public function removeMember(Request $request, Group $group, User $member)
    {
        $user = Auth::user();

        // Check if user is admin or creator
        if (!$group->isAdmin($user) && !$group->isCreator($user)) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to remove members.'], 403);
        }

        // Cannot remove the creator
        if ($group->isCreator($member)) {
            return response()->json(['success' => false, 'message' => 'Cannot remove the group creator.'], 400);
        }

        if (!$group->hasMember($member)) {
            return response()->json(['success' => false, 'message' => 'User is not a member of this group.'], 400);
        }

        $group->removeMember($member);

        return response()->json([
            'success' => true,
            'message' => 'Member removed successfully!'
        ]);
    }

    /**
     * Update group details.
     */
    public function update(Request $request, Group $group)
    {
        $user = Auth::user();

        // Check if user is admin or creator
        if (!$group->isAdmin($user) && !$group->isCreator($user)) {
            return redirect()->back()->with('error', 'You do not have permission to update this group.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
            $updateData['image'] = $request->file('image')->store('group-images', 'public');
        }

        $group->update($updateData);

        return redirect()->back()->with('success', 'Group updated successfully!');
    }

    /**
     * Delete the group.
     */
    public function destroy(Group $group)
    {
        $user = Auth::user();

        // Only creator can delete the group
        if (!$group->isCreator($user)) {
            return redirect()->back()->with('error', 'Only the group creator can delete this group.');
        }

        // Delete group image if exists
        if ($group->image) {
            Storage::disk('public')->delete($group->image);
        }

        // Delete all group files
        $groupMessages = $group->messages()->whereNotNull('file_path')->get();
        foreach ($groupMessages as $message) {
            if ($message->file_path) {
                Storage::disk('public')->delete($message->file_path);
            }
        }

        // Delete the group (cascades will handle messages and members)
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully!');
    }

    /**
     * Leave the group.
     */
    public function leave(Group $group)
    {
        $user = Auth::user();

        // Creator cannot leave the group
        if ($group->isCreator($user)) {
            return redirect()->back()->with('error', 'Group creator cannot leave the group. Transfer ownership or delete the group.');
        }

        if (!$group->hasMember($user)) {
            return redirect()->back()->with('error', 'You are not a member of this group.');
        }

        $group->removeMember($user);

        return redirect()->route('groups.index')->with('success', 'You have left the group successfully!');
    }

    /**
     * Translate a group message.
     */
    public function translateMessage(GroupMessage $message)
    {
        $user = Auth::user();

        // Check if user is a member of the group
        if (!$message->group->hasMember($user)) {
            return response()->json(['success' => false, 'message' => 'You are not a member of this group.'], 403);
        }

        if (!$message->detected_language) {
            return response()->json(['success' => false, 'message' => 'No language detected for this message.'], 400);
        }

        $targetLanguage = $user->preferred_language ?? 'en';

        if ($message->detected_language === $targetLanguage) {
            return response()->json(['success' => false, 'message' => 'Message is already in your preferred language.'], 400);
        }

        try {
            $translatedText = $this->translationService->translateText(
                $message->message,
                $message->detected_language,
                $targetLanguage
            );

            $sourceLangName = $this->translationService->getLanguageName($message->detected_language);
            $targetLangName = $this->translationService->getLanguageName($targetLanguage);

            return response()->json([
                'success' => true,
                'translated_text' => $translatedText,
                'source_language' => $sourceLangName,
                'target_language' => $targetLangName,
                'original_text' => $message->message,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Translation failed: ' . $e->getMessage()], 500);
        }
    }
} 
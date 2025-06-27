@extends('layouts.chat')

@section('title', 'Group: ' . $group->name)

@section('sidebar')
    <div class="p-4">
        <div class="mb-4">
            <a href="{{ route('groups.index') }}" class="text-sm text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Groups
            </a>
        </div>

        <!-- Group Info -->
        <div class="mb-6">
            <div class="flex items-center space-x-3 mb-3">
                @if($group->image)
                    <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}" class="w-12 h-12 rounded-full object-cover">
                @else
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($group->name, 0, 2)) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-semibold">{{ $group->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $members->count() }} members</p>
                </div>
            </div>
            @if($group->description)
                <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded">{{ $group->description }}</p>
            @endif
        </div>

        <!-- Group Members -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm font-medium text-gray-700">Members</h4>
                @if($isAdmin)
                    <button id="add-member-btn" class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">
                        + Add
                    </button>
                @endif
            </div>
            <div class="max-h-40 overflow-y-auto">
                @foreach($members as $member)
                    <div class="member-item flex items-center justify-between space-x-2 mb-2 p-2 rounded bg-gray-50">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded-full bg-gray-500 flex items-center justify-center text-white text-xs">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $member->name }}</p>
                                @if($group->isCreator($member))
                                    <span class="text-xs text-blue-600">Creator</span>
                                @elseif($member->pivot->is_admin)
                                    <span class="text-xs text-green-600">Admin</span>
                                @endif
                            </div>
                        </div>
                        @if($isAdmin && !$group->isCreator($member) && $member->id !== Auth::id())
                            <button class="remove-member-btn text-xs text-red-500 hover:text-red-700" data-member-id="{{ $member->id }}">
                                Remove
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Group Actions -->
        @if($isAdmin)
            <div class="mb-4">
                <button id="edit-group-btn" class="w-full text-sm bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded mb-2">
                    Edit Group
                </button>
                @if($group->isCreator(Auth::user()))
                    <button id="delete-group-btn" class="w-full text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
                        Delete Group
                    </button>
                @endif
            </div>
        @else
            <div class="mb-4">
                <button id="leave-group-btn" class="w-full text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
                    Leave Group
                </button>
            </div>
        @endif

        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('chat.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                💬 Private Chats
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Group Chat Header -->
    <div class="bg-white border-b border-gray-200 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                @if($group->image)
                    <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}" class="w-12 h-12 rounded-full object-cover">
                @else
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($group->name, 0, 2)) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $group->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $members->count() }} members</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="language-selector">
                    <select id="preferred-language" class="bg-gray-100 border-0 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" title="Your preferred language">
                        <option value="en" {{ Auth::user()->preferred_language === 'en' ? 'selected' : '' }}>🇺🇸 English</option>
                        <option value="es" {{ Auth::user()->preferred_language === 'es' ? 'selected' : '' }}>🇪🇸 Español</option>
                        <option value="fr" {{ Auth::user()->preferred_language === 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                        <option value="de" {{ Auth::user()->preferred_language === 'de' ? 'selected' : '' }}>🇩🇪 Deutsch</option>
                        <option value="it" {{ Auth::user()->preferred_language === 'it' ? 'selected' : '' }}>🇮🇹 Italiano</option>
                        <option value="pt" {{ Auth::user()->preferred_language === 'pt' ? 'selected' : '' }}>🇵🇹 Português</option>
                        <option value="ru" {{ Auth::user()->preferred_language === 'ru' ? 'selected' : '' }}>🇷🇺 Русский</option>
                        <option value="ja" {{ Auth::user()->preferred_language === 'ja' ? 'selected' : '' }}>🇯🇵 日本語</option>
                        <option value="ko" {{ Auth::user()->preferred_language === 'ko' ? 'selected' : '' }}>🇰🇷 한국어</option>
                        <option value="zh" {{ Auth::user()->preferred_language === 'zh' ? 'selected' : '' }}>🇨🇳 中文</option>
                        <option value="ar" {{ Auth::user()->preferred_language === 'ar' ? 'selected' : '' }}>🇸🇦 العربية</option>
                        <option value="hi" {{ Auth::user()->preferred_language === 'hi' ? 'selected' : '' }}>🇮🇳 हिन्दी</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="flex-1 p-6 bg-gray-100 overflow-auto chat-messages" id="messages-container" style="height: calc(100vh - 200px);">
        @forelse($messages as $message)
            @php
                $currentUser = Auth::user();
                $needsTranslation = $message->detected_language && 
                                  app(\App\Services\TranslationService::class)->needsTranslation(
                                      $message->detected_language, 
                                      $currentUser->preferred_language
                                  );
                $languageName = $message->detected_language ? 
                               app(\App\Services\TranslationService::class)->getLanguageName($message->detected_language) : null;
            @endphp
            <div class="mb-6 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}" data-message-id="{{ $message->id }}">
                <div class="inline-block p-4 rounded-2xl shadow-sm max-w-xs md:max-w-md lg:max-w-lg {{ $message->sender_id === Auth::id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-900' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium {{ $message->sender_id === Auth::id() ? 'text-blue-200' : 'text-gray-600' }}">{{ $message->sender->name }}</span>
                        @if($needsTranslation && $message->sender_id !== Auth::id())
                            <div class="flex items-center gap-2">
                                <span class="text-xs opacity-75">🌐 {{ $languageName }}</span>
                                <button class="translate-btn text-xs underline opacity-75 hover:opacity-100 transition-all" 
                                        data-message-id="{{ $message->id }}"
                                        data-original-text="{{ $message->message }}"
                                        data-source-lang="{{ $message->detected_language }}">
                                    Translate
                                </button>
                            </div>
                        @endif
                    </div>
                    
                    @if($message->message_type === 'image')
                        <div class="mb-2">
                            <img src="{{ $message->getFileUrl() }}" alt="Shared image" class="max-w-xs rounded-lg cursor-pointer" onclick="window.open(this.src, '_blank')">
                        </div>
                    @elseif($message->message_type === 'file')
                        <div class="mb-2 p-2 bg-gray-100 rounded flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 18h12V6l-4-4H4v16zm1-1V3h6l3 3v11H5z"/>
                            </svg>
                            <a href="{{ $message->getFileUrl() }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                {{ $message->file_name }}
                            </a>
                        </div>
                    @endif
                    
                    @if($message->message !== 'Sent an image' && $message->message !== 'Sent a file: ' . $message->file_name)
                        <p class="original-message">{{ $message->message }}</p>
                    @endif
                    
                    <div class="translated-content hidden">
                        <p class="translated-text text-sm opacity-75 mt-3 italic"></p>
                        <p class="translation-info text-xs opacity-50 mt-1"></p>
                    </div>
                </div>
                <div class="text-xs text-gray-500 mt-2 {{ $message->sender_id === Auth::id() ? 'text-right' : '' }}">
                    {{ $message->created_at->format('M j, Y g:i A') }}
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-blue-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                    </svg>
                </div>
                <h5 class="text-xl font-semibold text-gray-700 mb-2">No messages yet</h5>
                <p class="text-gray-500">Start the conversation by sending a message below!</p>
            </div>
        @endforelse
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t border-gray-200 p-6 shadow-sm">
        <form id="message-form" class="flex gap-4" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="group_id" value="{{ $group->id }}">
            <div class="flex-1 flex gap-2">
                <input 
                    type="text" 
                    name="message" 
                    id="message-input"
                    class="flex-1 border-2 border-gray-200 rounded-full px-6 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition-all"
                    placeholder="Type your message..."
                    maxlength="1000"
                >
                <input type="file" name="file" id="file-input" class="hidden" accept="image/*,.pdf,.doc,.docx">
                <button type="button" id="file-button" class="border-2 border-gray-200 rounded-full px-4 py-3 hover:bg-gray-50 transition-colors" title="Attach file">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                </button>
            </div>
            <button 
                type="submit" 
                id="send-button"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition-all duration-200 transform hover:scale-105 flex items-center gap-2 btn-ripple"
            >
                <span>Send</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <div class="hidden animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full" id="loading-spinner"></div>
            </button>
        </form>
        <div id="file-preview" class="hidden mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 18h12V6l-4-4H4v16zm1-1V3h6l3 3v11H5z"/>
                </svg>
                <div>
                    <span id="file-name" class="text-sm font-medium text-blue-900"></span>
                    <span id="file-size" class="text-xs text-blue-600 ml-2"></span>
                </div>
            </div>
            <button type="button" id="remove-file" class="text-red-500 hover:text-red-700 text-xl font-bold">×</button>
        </div>
    </div>

    <!-- Add Member Modal -->
    @if($isAdmin)
        <div id="add-member-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Add Member</h3>
                    <form id="add-member-form">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select User</label>
                            <select id="user-select" name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Choose a user...</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium">
                                Add Member
                            </button>
                            <button type="button" id="cancel-add-member" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg font-medium">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Group Modal -->
    @if($isAdmin)
        <div id="edit-group-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Group</h3>
                    <form id="edit-group-form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="edit-group-name" class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
                            <input type="text" 
                                   id="edit-group-name" 
                                   name="name" 
                                   value="{{ $group->name }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="edit-group-description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="edit-group-description" 
                                      name="description" 
                                      rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $group->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="edit-group-image" class="block text-sm font-medium text-gray-700 mb-2">Group Image</label>
                            <input type="file" 
                                   id="edit-group-image" 
                                   name="image" 
                                   accept="image/*"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if($group->image)
                                <p class="text-xs text-gray-500 mt-1">Current image will be replaced if you upload a new one</p>
                            @endif
                        </div>

                        <div class="flex space-x-3">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium">
                                Update Group
                            </button>
                            <button type="button" id="cancel-edit-group" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg font-medium">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let lastMessageId = {{ $messages->last()->id ?? 0 }};
            let isPolling = true;
            let selectedFile = null;

            // Auto-scroll to bottom
            function scrollToBottom() {
                const container = $('#messages-container');
                container.scrollTop(container[0].scrollHeight);
            }

            // Initial scroll to bottom
            scrollToBottom();

            // File attachment handling
            $('#file-button').on('click', function() {
                $('#file-input').click();
            });

            $('#file-input').on('change', function() {
                const file = this.files[0];
                if (file) {
                    selectedFile = file;
                    $('#file-name').text(file.name);
                    $('#file-size').text((file.size / 1024).toFixed(1) + ' KB');
                    $('#file-preview').removeClass('hidden');
                }
            });

            $('#remove-file').on('click', function() {
                selectedFile = null;
                $('#file-input').val('');
                $('#file-preview').addClass('hidden');
            });

            // Handle form submission
            $('#message-form').on('submit', function(e) {
                e.preventDefault();
                
                const messageInput = $('#message-input');
                const message = messageInput.val().trim();
                
                if (!message && !selectedFile) return;

                // Disable form while sending
                $('#send-button').prop('disabled', true);
                $('#loading-spinner').removeClass('hidden');
                messageInput.prop('disabled', true);

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('message', message);
                if (selectedFile) {
                    formData.append('file', selectedFile);
                }

                $.ajax({
                    url: '{{ route("groups.send-message", $group) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Clear input and file
                            messageInput.val('');
                            selectedFile = null;
                            $('#file-input').val('');
                            $('#file-preview').addClass('hidden');
                            
                            // Add message to UI
                            addMessageToUI(response.message, response.formatted_time, response.file_url, true);
                            lastMessageId = response.message.id;
                            scrollToBottom();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error sending message:', xhr);
                        if (typeof window.showToast === 'function') {
                            window.showToast('Failed to send message. Please try again.', 'error');
                        } else {
                            alert('Failed to send message. Please try again.');
                        }
                    },
                    complete: function() {
                        $('#send-button').prop('disabled', false);
                        $('#loading-spinner').addClass('hidden');
                        messageInput.prop('disabled', false).focus();
                    }
                });
            });

            // Function to add message to UI
            function addMessageToUI(message, formattedTime, fileUrl, isSent = false) {
                let messageHtml = `
                    <div class="mb-6 ${isSent ? 'text-right' : 'text-left'}" data-message-id="${message.id}">
                        <div class="inline-block p-4 rounded-2xl shadow-sm max-w-xs md:max-w-md lg:max-w-lg ${isSent ? 'bg-blue-600 text-white' : 'bg-white text-gray-900'}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium ${isSent ? 'text-blue-200' : 'text-gray-600'}">${message.sender.name}</span>
                            </div>
                `;

                if (message.message_type === 'image') {
                    messageHtml += `
                        <div class="mb-2">
                            <img src="${fileUrl}" alt="Shared image" class="max-w-xs rounded-lg cursor-pointer" onclick="window.open(this.src, '_blank')">
                        </div>
                    `;
                } else if (message.message_type === 'file') {
                    messageHtml += `
                        <div class="mb-2 p-2 ${isSent ? 'bg-blue-500' : 'bg-gray-100'} rounded flex items-center gap-2">
                            <svg class="w-4 h-4 ${isSent ? 'text-white' : 'text-gray-600'}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 18h12V6l-4-4H4v16zm1-1V3h6l3 3v11H5z"/>
                            </svg>
                            <a href="${fileUrl}" target="_blank" class="${isSent ? 'text-blue-100 hover:text-white' : 'text-blue-600 hover:underline'} text-sm">
                                ${message.file_name}
                            </a>
                        </div>
                    `;
                }

                if (message.message && message.message !== 'Sent an image' && !message.message.startsWith('Sent a file:')) {
                    messageHtml += `<p class="original-message">${message.message}</p>`;
                }

                messageHtml += `
                            <div class="translated-content hidden">
                                <p class="translated-text text-sm opacity-75 mt-3 italic"></p>
                                <p class="translation-info text-xs opacity-50 mt-1"></p>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-2 ${isSent ? 'text-right' : ''}">
                            ${formattedTime}
                        </div>
                    </div>
                `;

                $('#messages-container').append(messageHtml);
            }

            // Poll for new messages
            function pollMessages() {
                if (!isPolling) return;

                $.ajax({
                    url: '{{ route("groups.get-messages", $group) }}',
                    method: 'GET',
                    data: { last_message_id: lastMessageId },
                    success: function(response) {
                        if (response.success && response.messages.length > 0) {
                            response.messages.forEach(function(message) {
                                addMessageToUI(message, message.formatted_time, message.file_url, false);
                            });
                            lastMessageId = response.last_message_id;
                            scrollToBottom();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error polling messages:', xhr);
                    },
                    complete: function() {
                        setTimeout(pollMessages, 2000); // Poll every 2 seconds
                    }
                });
            }

            // Start polling
            setTimeout(pollMessages, 2000);

            // Handle language preference change
            $('#preferred-language').on('change', function() {
                const language = $(this).val();
                
                $.ajax({
                    url: '{{ route("chat.update-language") }}',
                    method: 'POST',
                    data: {
                        language: language,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload(); // Reload to update translation needs
                        }
                    }
                });
            });

            // Handle translation
            $(document).on('click', '.translate-btn', function() {
                const button = $(this);
                const messageId = button.data('message-id');
                const originalText = button.data('original-text');
                const sourceLang = button.data('source-lang');
                const messageContainer = button.closest('.mb-6');
                const translatedContent = messageContainer.find('.translated-content');

                if (button.text() === 'Translate') {
                    button.text('Translating...');
                    button.prop('disabled', true);
                    
                    $.ajax({
                        url: '{{ route("groups.translate-message", ":id") }}'.replace(':id', messageId),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                if (response.is_original) {
                                    button.text('Already in your language');
                                    button.prop('disabled', true);
                                } else {
                                    translatedContent.find('.translated-text').text(response.translated_text);
                                    translatedContent.find('.translation-info').text(
                                        `Translated from ${response.source_language_name}`
                                    );
                                    translatedContent.removeClass('hidden');
                                    button.text('Hide Translation');
                                }
                            } else {
                                if (typeof window.showToast === 'function') {
                                    window.showToast('Translation failed: ' + response.message, 'error');
                                } else {
                                    alert('Translation failed: ' + response.message);
                                }
                                button.text('Translate');
                            }
                        },
                        error: function() {
                            if (typeof window.showToast === 'function') {
                                window.showToast('Translation service unavailable. Please try again later.', 'error');
                            } else {
                                alert('Translation failed. Please try again.');
                            }
                            button.text('Translate');
                        },
                        complete: function() {
                            button.prop('disabled', false);
                            if (button.text() === 'Translating...') {
                                button.text('Translate');
                            }
                        }
                    });
                } else {
                    translatedContent.addClass('hidden');
                    button.text('Translate');
                }
            });

            // Modal handlers
            $('#add-member-btn').on('click', function() {
                $('#add-member-modal').removeClass('hidden');
            });

            $('#cancel-add-member').on('click', function() {
                $('#add-member-modal').addClass('hidden');
            });

            $('#add-member-form').on('submit', function(e) {
                e.preventDefault();
                
                const userId = $('#user-select').val();
                if (!userId) return;

                $.ajax({
                    url: '{{ route("groups.add-member", $group) }}',
                    method: 'POST',
                    data: {
                        user_id: userId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Failed to add member. Please try again.');
                    }
                });
            });

            // Remove member
            $(document).on('click', '.remove-member-btn', function() {
                const memberId = $(this).data('member-id');
                
                if (confirm('Are you sure you want to remove this member?')) {
                    $.ajax({
                        url: '{{ route("groups.remove-member", [$group, ":id"]) }}'.replace(':id', memberId),
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert('Failed to remove member. Please try again.');
                        }
                    });
                }
            });

            // Edit group modal
            $('#edit-group-btn').on('click', function() {
                $('#edit-group-modal').removeClass('hidden');
            });

            $('#cancel-edit-group').on('click', function() {
                $('#edit-group-modal').addClass('hidden');
            });

            $('#edit-group-form').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                $.ajax({
                    url: '{{ route("groups.update", $group) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error updating group:', xhr);
                        alert('Failed to update group. Please try again.');
                    }
                });
            });

            // Delete group
            $('#delete-group-btn').on('click', function() {
                if (confirm('Are you sure you want to delete this group? This action cannot be undone.')) {
                    $.ajax({
                        url: '{{ route("groups.destroy", $group) }}',
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            window.location.href = '{{ route("groups.index") }}';
                        },
                        error: function() {
                            alert('Failed to delete group. Please try again.');
                        }
                    });
                }
            });

            // Leave group
            $('#leave-group-btn').on('click', function() {
                if (confirm('Are you sure you want to leave this group?')) {
                    $.ajax({
                        url: '{{ route("groups.leave", $group) }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            window.location.href = '{{ route("groups.index") }}';
                        },
                        error: function() {
                            alert('Failed to leave group. Please try again.');
                        }
                    });
                }
            });

            // Close modals when clicking outside
            $('.fixed').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });
        });
    </script>
@endsection 
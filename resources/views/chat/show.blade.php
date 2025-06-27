@extends('layouts.chat')

@section('title', 'Chat with ' . $user->name)
<style>
    input {
        color: black !important;
        background-color: white !important;
    }
</style>
@section('sidebar')
    <div class="p-6" data-aos="fade-right">
        <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
            </svg>
            Users
        </h3>

        @foreach($users as $index => $chatUser)
            <a href="{{ route('chat.show', $chatUser) }}"
                class="flex items-center p-4 mb-3 rounded-xl transition-all duration-200 hover-lift {{ $chatUser->id === $user->id ? 'bg-blue-600 text-white' : 'bg-gray-50 hover:bg-blue-50 text-gray-900' }}"
                data-aos="fade-left" data-aos-delay="{{ ($index + 1) * 50 }}">
                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center font-bold mr-4 {{ $chatUser->id === $user->id ? 'bg-white text-blue-600' : 'bg-gray-600 text-white' }}">
                    {{ strtoupper(substr($chatUser->name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <p class="font-semibold mb-1">{{ $chatUser->name }}</p>
                    <p class="text-sm opacity-75 flex items-center">
                        @if($chatUser->id === $user->id)
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Currently chatting
                        @else
                            {{ $chatUser->email }}
                        @endif
                    </p>
                </div>
            </a>
        @endforeach

        <div class="mt-6 pt-6 border-t border-gray-200" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('chat.index') }}"
                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to all users
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Chat Header -->
    <div class="bg-white border-b border-gray-200 p-6 shadow-sm" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $user->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="language-selector">
                    <select id="preferred-language"
                        class="bg-gray-100 border-0 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all"
                        title="Your preferred language">
                        <option value="en" {{ Auth::user()->preferred_language === 'en' ? 'selected' : '' }}>🇺🇸 English
                        </option>
                        <option value="es" {{ Auth::user()->preferred_language === 'es' ? 'selected' : '' }}>🇪🇸 Español
                        </option>
                        <option value="fr" {{ Auth::user()->preferred_language === 'fr' ? 'selected' : '' }}>🇫🇷 Français
                        </option>
                        <option value="de" {{ Auth::user()->preferred_language === 'de' ? 'selected' : '' }}>🇩🇪 Deutsch
                        </option>
                        <option value="it" {{ Auth::user()->preferred_language === 'it' ? 'selected' : '' }}>🇮🇹 Italiano
                        </option>
                        <option value="pt" {{ Auth::user()->preferred_language === 'pt' ? 'selected' : '' }}>🇵🇹 Português
                        </option>
                        <option value="ru" {{ Auth::user()->preferred_language === 'ru' ? 'selected' : '' }}>🇷🇺 Русский
                        </option>
                        <option value="ja" {{ Auth::user()->preferred_language === 'ja' ? 'selected' : '' }}>🇯🇵 日本語</option>
                        <option value="ko" {{ Auth::user()->preferred_language === 'ko' ? 'selected' : '' }}>🇰🇷 한국어</option>
                        <option value="zh" {{ Auth::user()->preferred_language === 'zh' ? 'selected' : '' }}>🇨🇳 中文</option>
                        <option value="ar" {{ Auth::user()->preferred_language === 'ar' ? 'selected' : '' }}>🇸🇦 العربية
                        </option>
                        <option value="hi" {{ Auth::user()->preferred_language === 'hi' ? 'selected' : '' }}>🇮🇳 हिन्दी
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="flex-1 p-6 bg-gray-100 overflow-auto chat-messages" id="messages-container"
        style="height: calc(100vh - 200px);">
        @forelse($messages as $index => $message)
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
            <div class="mb-6 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}"
                data-message-id="{{ $message->id }}" data-aos="fade-{{ $message->sender_id === Auth::id() ? 'left' : 'right' }}"
                data-aos-delay="{{ $index * 50 }}">
                <div
                    class="inline-block p-4 rounded-2xl shadow-sm max-w-xs md:max-w-md lg:max-w-lg {{ $message->sender_id === Auth::id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-900' }}">
                    @if($needsTranslation && $message->sender_id !== Auth::id())
                        <div class="flex items-center gap-2 mb-3 text-xs opacity-75">
                            <span>🌐 {{ $languageName }}</span>
                            <button class="translate-btn underline hover:no-underline transition-all"
                                data-message-id="{{ $message->id }}" data-original-text="{{ $message->message }}"
                                data-source-lang="{{ $message->detected_language }}">
                                Translate
                            </button>
                        </div>
                    @endif
                    <p class="original-message">{{ $message->message }}</p>
                    <div class="translated-content hidden">
                        <p class="translated-text text-sm opacity-75 mt-3 italic"></p>
                        <p class="translation-info text-xs opacity-50 mt-1"></p>
                    </div>
                </div>
                <div class="text-xs text-gray-500 mt-2">
                    {{ $message->created_at->format('M j, Y g:i A') }}
                    @if($message->sender_id === Auth::id())
                        • <span
                            class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">{{ $message->is_read ? 'Read' : 'Delivered' }}</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12" data-aos="fade-up">
                <div class="w-20 h-20 bg-blue-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h5 class="text-xl font-semibold text-gray-700 mb-2">No messages yet</h5>
                <p class="text-gray-500">Start the conversation by sending a message below!</p>
            </div>
        @endforelse
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t border-gray-200 p-6 shadow-sm" data-aos="fade-up">
        <form id="message-form" class="flex gap-4">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <input type="text" name="message" id="message-input"
                class="flex-1 border-2 border-gray-200 rounded-full px-6 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition-all"
                placeholder="Type your message..." maxlength="1000" required>
            <button type="submit" id="send-button"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition-all duration-200 transform hover:scale-105 flex items-center gap-2 btn-ripple">
                <span>Send</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <div class="hidden animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"
                    id="loading-spinner"></div>
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let lastMessageId = {{ $messages->last()->id ?? 0 }};
            let isPolling = true;

            // Auto-scroll to bottom
            function scrollToBottom() {
                const container = $('#messages-container');
                container.scrollTop(container[0].scrollHeight);
            }

            // Initial scroll to bottom
            scrollToBottom();

            // Handle form submission
            $('#message-form').on('submit', function (e) {
                e.preventDefault();

                const messageInput = $('#message-input');
                const message = messageInput.val().trim();

                if (!message) return;

                // Disable form while sending
                $('#send-button').prop('disabled', true);
                $('#loading-spinner').removeClass('hidden');
                messageInput.prop('disabled', true);

                $.ajax({
                    url: '{{ route("chat.send") }}',
                    method: 'POST',
                    data: {
                        receiver_id: {{ $user->id }},
                        message: message,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            // Clear input
                            messageInput.val('');

                            // Add message to UI
                            const messageHtml = `
                                            <div class="mb-6 text-right" data-message-id="${response.message.id}">
                                                <div class="inline-block p-4 rounded-2xl shadow-sm max-w-xs md:max-w-md lg:max-w-lg bg-blue-600 text-white">
                                                    <p>${response.message.message}</p>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-2">
                                                    ${response.formatted_time} • <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Delivered</span>
                                                </div>
                                            </div>
                                        `;
                            $('#messages-container').append(messageHtml);
                            lastMessageId = response.message.id;
                            scrollToBottom();
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'Failed to send message. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join(' ');
                        }
                        // Show error using our custom toast system
                        if (typeof window.showToast === 'function') {
                            window.showToast(errorMessage, 'error');
                        } else {
                            alert(errorMessage);
                        }
                    },
                    complete: function () {
                        // Re-enable form
                        $('#send-button').prop('disabled', false);
                        $('#loading-spinner').addClass('hidden');
                        messageInput.prop('disabled', false).focus();
                    }
                });
            });

            // Enter key to send message
            $('#message-input').on('keypress', function (e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    $('#message-form').submit();
                }
            });

            // Poll for new messages every 2 seconds
            function pollForNewMessages() {
                if (!isPolling) return;

                $.ajax({
                    url: '{{ route("chat.messages", $user) }}',
                    method: 'GET',
                    data: {
                        last_message_id: lastMessageId
                    },
                    success: function (response) {
                        if (response.messages && response.messages.length > 0) {
                            response.messages.forEach(function (message) {
                                const messageClass = message.is_current_user ? 'text-right' : 'text-left';
                                const bubbleClass = message.is_current_user ? 'bg-blue-600 text-white' : 'bg-white text-gray-900';
                                const readStatus = message.is_current_user ? ` • <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Delivered</span>` : '';

                                // Build translation UI for foreign language messages
                                let translationUI = '';
                                if (message.needs_translation && !message.is_current_user) {
                                    translationUI = `
                                                    <div class="flex items-center gap-2 mb-3 text-xs opacity-75">
                                                        <span>🌐 ${message.language_name || 'Unknown'}</span>
                                                        <button class="translate-btn underline hover:no-underline transition-all" 
                                                                data-message-id="${message.id}"
                                                                data-original-text="${message.message}"
                                                                data-source-lang="${message.detected_language}">
                                                            Translate
                                                        </button>
                                                    </div>
                                                `;
                                }

                                const messageHtml = `
                                                <div class="mb-6 ${messageClass}" data-message-id="${message.id}">
                                                    <div class="inline-block p-4 rounded-2xl shadow-sm max-w-xs md:max-w-md lg:max-w-lg ${bubbleClass}">
                                                        ${translationUI}
                                                        <p class="original-message">${message.message}</p>
                                                        <div class="translated-content hidden">
                                                            <p class="translated-text text-sm opacity-75 mt-3 italic"></p>
                                                            <p class="translation-info text-xs opacity-50 mt-1"></p>
                                                        </div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2">
                                                        ${message.created_at}${readStatus}
                                                    </div>
                                                </div>
                                            `;
                                $('#messages-container').append(messageHtml);
                                lastMessageId = message.id;
                            });
                            scrollToBottom();
                        }
                    },
                    error: function () {
                        // Silently fail for polling requests
                    },
                    complete: function () {
                        // Schedule next poll
                        setTimeout(pollForNewMessages, 2000);
                    }
                });
            }

            // Start polling for new messages
            setTimeout(pollForNewMessages, 2000);

            // Stop polling when user leaves the page
            $(window).on('beforeunload', function () {
                isPolling = false;
            });

            // Handle translation button clicks
            $(document).on('click', '.translate-btn', function () {
                const $btn = $(this);
                const messageId = $btn.data('message-id');
                const originalText = $btn.data('original-text');
                const sourceLang = $btn.data('source-lang');
                const $messageDiv = $btn.closest('.mb-6');
                const $translatedContent = $messageDiv.find('.translated-content');

                // If already translated, toggle visibility
                if (!$translatedContent.hasClass('hidden')) {
                    $translatedContent.addClass('hidden');
                    $btn.text('Translate');
                    return;
                }

                // Show loading state
                $btn.text('Translating...');
                $btn.prop('disabled', true);

                $.ajax({
                    url: `/chat/message/${messageId}/translate`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.is_original) {
                                $btn.text('Already in your language');
                                $btn.prop('disabled', true);
                            } else {
                                $translatedContent.find('.translated-text').text(response.translated_text);
                                $translatedContent.find('.translation-info').text(
                                    `Translated from ${response.source_language_name}`
                                );
                                $translatedContent.removeClass('hidden');
                                $btn.text('Hide Translation');
                            }
                        } else {
                            if (typeof window.showToast === 'function') {
                                window.showToast('Translation failed. Please try again.', 'error');
                            }
                        }
                    },
                    error: function () {
                        if (typeof window.showToast === 'function') {
                            window.showToast('Translation service unavailable. Please try again later.', 'error');
                        }
                    },
                    complete: function () {
                        $btn.prop('disabled', false);
                        if ($btn.text() === 'Translating...') {
                            $btn.text('Translate');
                        }
                    }
                });
            });

            // Handle preferred language changes
            $('#preferred-language').on('change', function () {
                const newLanguage = $(this).val();

                $.ajax({
                    url: '{{ route("chat.update-language") }}',
                    method: 'POST',
                    data: {
                        preferred_language: newLanguage,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            if (typeof window.showToast === 'function') {
                                window.showToast('Language preference updated!', 'success');
                            }

                            // Refresh the page to update translation buttons
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function () {
                        if (typeof window.showToast === 'function') {
                            window.showToast('Failed to update language preference', 'error');
                        }
                    }
                });
            });

            // Focus on message input
            $('#message-input').focus();
        });
    </script>
@endsection
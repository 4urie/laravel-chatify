@extends('layouts.chat')

@section('title', 'Chat with ' . $user->name)

@section('sidebar')
    @include('chat.partials.chat-list')
@endsection

@section('main-content')
    <!-- Chat Header -->
    <div class="chat-header flex items-center justify-between p-6">
        <div class="flex items-center space-x-4">
            <div class="user-avatar w-12 h-12 rounded-full flex items-center justify-center">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div>
                <h2 class="text-lg font-semibold text-primary-apple">{{ $user->name }}</h2>
                <p class="text-sm text-secondary-apple">{{ $user->email }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <button class="w-10 h-10 rounded-full bg-secondary-apple hover:bg-gray-200 flex items-center justify-center transition-all duration-150">
                <svg class="w-5 h-5 text-secondary-apple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </button>
            <button class="w-10 h-10 rounded-full bg-secondary-apple hover:bg-gray-200 flex items-center justify-center transition-all duration-150">
                <svg class="w-5 h-5 text-secondary-apple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto px-6 py-4" id="messages-container" style="background: linear-gradient(180deg, #fbfbfd 0%, #f5f5f7 100%);">
        @forelse($messages as $message)
            <div class="mb-6 flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="flex {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : 'flex-row' }} items-end max-w-[75%] space-x-3">
                    @if($message->sender_id !== auth()->id())
                        <div class="user-avatar w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-sm">
                            {{ substr($message->sender->name, 0, 2) }}
                        </div>
                    @endif
                    
                    <div class="space-y-1 {{ $message->sender_id === auth()->id() ? 'mr-3' : 'ml-3' }}">
                        @if($message->sender_id !== auth()->id())
                            <p class="text-xs font-medium text-secondary-apple ml-4">{{ $message->sender->name }}</p>
                        @endif
                        <div class="message-bubble {{ $message->sender_id === auth()->id() ? 'sent' : '' }} rounded-2xl px-4 py-3 max-w-sm">
                            <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                        </div>
                        <p class="text-xs text-tertiary-apple {{ $message->sender_id === auth()->id() ? 'text-right mr-4' : 'ml-4' }}">
                            {{ $message->created_at->format('g:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <div class="w-20 h-20 bg-secondary-apple rounded-full mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-10 h-10 text-secondary-apple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-apple mb-3">No messages yet</h3>
                    <p class="text-sm text-secondary-apple max-w-xs">Send a message to start your conversation with {{ $user->name }}</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Message Input -->
    <div class="p-6 border-t" style="border-color: var(--border-light); background-color: var(--bg-primary);">
        <form id="message-form" class="flex items-center space-x-4">
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <div class="flex-1 relative">
                <input type="text" 
                    id="message-input"
                    name="message"
                    class="message-input w-full rounded-full px-6 py-4 pr-12 text-sm focus:outline-none focus:ring-0" 
                    placeholder="Type a message..."
                    autocomplete="off">
                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-8 h-8 rounded-full bg-secondary-apple hover:bg-gray-200 flex items-center justify-center transition-all duration-150">
                    <svg class="w-5 h-5 text-secondary-apple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </div>
            <button type="submit" class="btn-primary w-12 h-12 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const messagesContainer = document.getElementById('messages-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const userId = {{ auth()->id() }};

    // Scroll to bottom of messages
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    scrollToBottom();

    // Handle form submission
    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(messageForm);
        
        // Don't send empty messages
        if (!messageInput.value.trim()) return;
        
        try {
            const response = await fetch('{{ route("chat.send") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (!response.ok) throw new Error('Failed to send message');

            const data = await response.json();
            if (data.success) {
                messageInput.value = '';
                // The message will be added via polling
            }
        } catch (error) {
            console.error('Error:', error);
            // Show a subtle error indication
            messageInput.style.borderColor = 'var(--accent-red)';
            setTimeout(() => {
                messageInput.style.borderColor = 'var(--border-light)';
            }, 2000);
        }
    });

    // Auto-resize input on Enter key
    messageInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm.dispatchEvent(new Event('submit'));
        }
    });

    // Poll for new messages
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    
    function pollMessages() {
        fetch(`{{ route('chat.messages', $user->id) }}?last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(message => {
                        const isCurrentUser = message.sender_id === userId;
                        const html = `
                            <div class="mb-6 flex ${isCurrentUser ? 'justify-end' : 'justify-start'}">
                                <div class="flex ${isCurrentUser ? 'flex-row-reverse' : 'flex-row'} items-end max-w-[75%] space-x-3">
                                    ${!isCurrentUser ? `
                                        <div class="user-avatar w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-sm">
                                            ${message.sender_name.substring(0, 2)}
                                        </div>
                                    ` : ''}
                                    
                                    <div class="space-y-1 ${isCurrentUser ? 'mr-3' : 'ml-3'}">
                                        ${!isCurrentUser ? `
                                            <p class="text-xs font-medium text-secondary-apple ml-4">${message.sender_name}</p>
                                        ` : ''}
                                        <div class="message-bubble ${isCurrentUser ? 'sent' : ''} rounded-2xl px-4 py-3 max-w-sm">
                                            <p class="text-sm leading-relaxed">${message.message}</p>
                                        </div>
                                        <p class="text-xs text-tertiary-apple ${isCurrentUser ? 'text-right mr-4' : 'ml-4'}">
                                            ${message.created_at}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        `;
                        messagesContainer.insertAdjacentHTML('beforeend', html);
                        lastMessageId = message.id;
                    });
                    scrollToBottom();
                }
            })
            .catch(error => {
                console.error('Polling error:', error);
            })
            .finally(() => {
                setTimeout(pollMessages, 3000);
            });
    }
    
    // Start polling
    pollMessages();

    // Focus input on load
    messageInput.focus();
</script>
@endpush
@extends('layouts.chat')

@section('title', $group->name)

@section('sidebar')
    @foreach($group->members as $member)
        <div class="flex items-center px-2 py-2 mx-2 rounded-lg bg-gray-100">
            <div class="relative">
                <div class="w-14 h-14 rounded-full flex items-center justify-center font-bold mr-3 bg-blue-100 text-blue-800">
                    {{ strtoupper(substr($member->name, 0, 2)) }}
                </div>
                @if($member->is_online)
                    <div class="absolute bottom-0 right-3 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <p class="font-semibold truncate text-gray-900">{{ $member->name }}</p>
                            </div>
                <p class="text-sm text-gray-600">
                    @if($member->id === $group->creator_id)
                        Group Creator
                    @else
                        Member
                                @endif
                </p>
            </div>
        </div>
    @endforeach
@endsection

@section('main-content')
    <!-- Chat Header -->
    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200 bg-white">
        <div class="flex items-center">
            <div class="relative">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold mr-3 bg-blue-100 text-blue-800">
                        {{ strtoupper(substr($group->name, 0, 2)) }}
                </div>
            </div>
            <div>
                <h2 class="font-semibold text-gray-900">{{ $group->name }}</h2>
                <p class="text-xs text-gray-600">{{ $group->members_count }} members</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" id="add-members-btn" class="p-2 hover:bg-gray-100 rounded-full text-gray-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H9zm-3-3v-3h3v-2H6V7H4v3H1v2h3v3z"></path>
                </svg>
            </button>
            <button type="button" id="view-members-btn" class="p-2 hover:bg-gray-100 rounded-full text-gray-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="flex-1 overflow-y-auto p-4 bg-gray-50" id="messages-container">
        @forelse($messages as $message)
            <div class="message mb-4 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}" data-message-id="{{ $message->id }}">
                <div class="flex items-end {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }} gap-2">
                    @if($message->sender_id !== Auth::id())
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-blue-100 text-blue-800 text-sm">
                            {{ strtoupper(substr($message->sender->name, 0, 2)) }}
                            </div>
                    @endif
                    <div class="max-w-[60%]">
                        @if($message->sender_id !== Auth::id())
                            <p class="text-xs text-gray-600 mb-1">{{ $message->sender->name }}</p>
                        @endif
                        <div class="inline-block rounded-lg px-4 py-2 {{ $message->sender_id === Auth::id() ? 'bg-blue-500 text-white' : 'bg-white text-gray-900' }} shadow">
                            <p>{{ $message->message }}</p>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                            {{ $message->created_at->format('g:i A') }}
                            @if($message->sender_id === Auth::id())
                                • {{ $message->is_read ? 'Seen' : 'Sent' }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex items-center justify-center h-full text-gray-600">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"></path>
                    </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">No messages yet</h3>
                    <p class="text-sm text-gray-600">Start the conversation!</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Message Input -->
    <div class="p-4 bg-white border-t border-gray-200">
        <form id="message-form" class="flex items-center gap-2">
            @csrf
            <input type="hidden" name="group_id" value="{{ $group->id }}">
            <div class="flex-1">
                <input type="text" name="message" id="message-input"
                    class="w-full border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:border-blue-500 text-gray-900"
                    placeholder="Type a message..." required>
            </div>
            <button type="submit" id="send-button" class="p-2 text-blue-500 hover:bg-gray-100 rounded-full">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                </svg>
            </button>
        </form>
                </div>

    <!-- Add Members Modal -->
    <div id="add-members-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Add Members</h3>
            </div>
            <form id="add-members-form" class="p-4">
                        @csrf
                <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($availableUsers as $user)
                        <label class="flex items-center p-2 hover:bg-gray-100 rounded-lg">
                            <input type="checkbox" name="members[]" value="{{ $user->id }}"
                                class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                            <span class="ml-3 text-gray-700">{{ $user->name }}</span>
                        </label>
                                @endforeach
                        </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-add-members"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium rounded-lg">
                                Cancel
                            </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg">
                        Add Members
                    </button>
                        </div>
                    </form>
                </div>
            </div>

    <!-- View Members Modal -->
    <div id="view-members-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Group Members</h3>
        </div>
            <div class="p-4">
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach($group->members as $member)
                        <div class="flex items-center justify-between p-2 hover:bg-gray-100 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-blue-100 text-blue-800 text-sm mr-3">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                        </div>
                                <span class="text-gray-900">{{ $member->name }}</span>
                        </div>
                            @if($member->id === $group->creator_id)
                                <span class="text-xs text-gray-500">Creator</span>
                            @elseif(Auth::id() === $group->creator_id && $member->id !== Auth::id())
                                <button type="button" class="text-red-500 hover:text-red-600 text-sm"
                                    onclick="removeMember({{ $member->id }})">
                                    Remove
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end pt-4 border-t border-gray-200 mt-4">
                    <button type="button" id="close-view-members"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium rounded-lg">
                        Close
                            </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const messagesContainer = document.getElementById('messages-container');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const addMembersModal = document.getElementById('add-members-modal');
        const viewMembersModal = document.getElementById('view-members-modal');
            let lastMessageId = {{ $messages->last()->id ?? 0 }};
            let isPolling = true;

        // Scroll to bottom initially
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

            // Handle form submission
        messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
            const formData = new FormData(this);
            fetch('{{ route("groups.messages.store", $group) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    group_id: formData.get('group_id'),
                    message: formData.get('message')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageForm.reset();
                    lastMessageId = data.message.id;
                    messageInput.focus();
                }
            });
        });

            // Poll for new messages
            function pollMessages() {
                if (!isPolling) return;

            fetch(`{{ route('groups.messages.index', $group) }}?last_message_id=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(message => {
                            const isCurrentUser = message.sender_id === {{ Auth::id() }};
                            const html = `
                                <div class="message mb-4 ${isCurrentUser ? 'text-right' : 'text-left'}" data-message-id="${message.id}">
                                    <div class="flex items-end ${isCurrentUser ? 'justify-end' : 'justify-start'} gap-2">
                                        ${!isCurrentUser ? `
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-blue-100 text-blue-800 text-sm">
                                                ${message.sender.name.substring(0, 2).toUpperCase()}
                                            </div>
                                        ` : ''}
                                        <div class="max-w-[60%]">
                                            ${!isCurrentUser ? `
                                                <p class="text-xs text-gray-600 mb-1">${message.sender.name}</p>
                                            ` : ''}
                                            <div class="inline-block rounded-lg px-4 py-2 ${isCurrentUser ? 'bg-blue-500 text-white' : 'bg-white text-gray-900'} shadow">
                                                <p>${message.message}</p>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 ${isCurrentUser ? 'text-right' : 'text-left'}">
                                                ${message.created_at}
                                                ${isCurrentUser ? `• ${message.is_read ? 'Seen' : 'Sent'}` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            messagesContainer.insertAdjacentHTML('beforeend', html);
                            lastMessageId = message.id;
                        });
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                })
                .finally(() => {
                    setTimeout(pollMessages, 3000);
                });
            }

            // Start polling
        pollMessages();

        // Modal handlers
        document.getElementById('add-members-btn').addEventListener('click', () => {
            addMembersModal.classList.remove('hidden');
        });

        document.getElementById('cancel-add-members').addEventListener('click', () => {
            addMembersModal.classList.add('hidden');
        });

        document.getElementById('view-members-btn').addEventListener('click', () => {
            viewMembersModal.classList.remove('hidden');
        });

        document.getElementById('close-view-members').addEventListener('click', () => {
            viewMembersModal.classList.add('hidden');
        });

        // Handle add members form submission
        document.getElementById('add-members-form').addEventListener('submit', function(e) {
                e.preventDefault();
            const formData = new FormData(this);
            
            fetch('{{ route("groups.members.store", $group) }}', {
                    method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    members: Array.from(formData.getAll('members[]'))
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        });

        // Clean up
        window.addEventListener('beforeunload', () => {
            isPolling = false;
        });

        // Focus input on load
        messageInput.focus();
    });

    // Remove member function
    function removeMember(memberId) {
        if (confirm('Are you sure you want to remove this member?')) {
            fetch('{{ route("groups.members.destroy", $group) }}', {
                        method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    member_id: memberId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                        }
                    });
                }
    }
    </script>
@endpush 
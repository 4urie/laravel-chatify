@extends('layouts.chat')

@section('title', 'Groups')

@section('sidebar')
    @foreach($groups as $group)
        <a href="{{ route('groups.show', $group) }}" 
            class="flex items-center px-2 py-2 mx-2 rounded-lg hover:bg-gray-100">
            <div class="relative">
                <div class="w-14 h-14 rounded-full flex items-center justify-center font-bold mr-3 bg-blue-100 text-blue-800">
                    {{ strtoupper(substr($group->name, 0, 2)) }}
                </div>
                @if($group->active_members_count > 0)
                    <div class="absolute bottom-0 right-3 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <p class="font-semibold truncate text-gray-900">{{ $group->name }}</p>
                    @if($group->unread_count > 0)
                        <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full ml-2">{{ $group->unread_count }}</span>
                    @endif
                </div>
                <p class="text-sm text-gray-600">{{ $group->members_count }} members</p>
                @if(isset($group->latest_message))
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="font-medium truncate">{{ $group->latest_message->sender->name }}:</span>
                        <span class="truncate ml-1">{{ Str::limit($group->latest_message->message, 30) }}</span>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $group->latest_message->created_at->diffForHumans() }}
                    </p>
                @endif
            </div>
        </a>
    @endforeach
@endsection

@section('main-content')
    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200 bg-white">
        <h2 class="text-xl font-semibold text-gray-900">Groups</h2>
        <button type="button" id="create-group-btn" class="p-2 hover:bg-gray-100 rounded-full text-gray-600">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 7c.55 0 1 .45 1 1v3h3c.55 0 1 .45 1 1s-.45 1-1 1h-3v3c0 .55-.45 1-1 1s-1-.45-1-1v-3H8c-.55 0-1-.45-1-1s.45-1 1-1h3V8c0-.55.45-1 1-1zm0-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path>
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto p-4 bg-gray-50">
        @if($groups->isEmpty())
            <div class="flex items-center justify-center h-full text-gray-600">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12.75c1.63 0 3.07.39 4.24.9 1.08.48 1.76 1.56 1.76 2.73V18H6v-1.61c0-1.18.68-2.26 1.76-2.73 1.17-.52 2.61-.91 4.24-.91zM4 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm1.13 1.1c-.37-.06-.74-.1-1.13-.1-.99 0-1.93.21-2.78.58A2.01 2.01 0 0 0 0 16.43V18h4.5v-1.61c0-.83.23-1.61.63-2.29zM20 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm4 3.43c0-.81-.48-1.53-1.22-1.85A6.95 6.95 0 0 0 20 14c-.39 0-.76.04-1.13.1.4.68.63 1.46.63 2.29V18H24v-1.57zM12 6c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">No Groups Yet</h3>
                    <p class="text-sm text-gray-600">Create a group to start chatting with multiple people.</p>
                    <button type="button" id="create-first-group-btn"
                        class="mt-4 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg">
                        Create Group
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Create Group Modal -->
    <div id="create-group-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Create New Group</h3>
            </div>
            <form id="create-group-form" class="p-4">
                @csrf
                <div class="mb-4">
                    <label for="group-name" class="block text-sm font-medium text-gray-700 mb-1">Group Name</label>
                    <input type="text" id="group-name" name="name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 text-gray-900"
                        placeholder="Enter group name">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Add Members</label>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($users as $user)
                            @if($user->id !== Auth::id())
                                <label class="flex items-center p-2 hover:bg-gray-100 rounded-lg">
                                    <input type="checkbox" name="members[]" value="{{ $user->id }}"
                                        class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700">{{ $user->name }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-create-group"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium rounded-lg">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg">
                        Create Group
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createGroupModal = document.getElementById('create-group-modal');
        const createGroupForm = document.getElementById('create-group-form');
        const createGroupBtn = document.getElementById('create-group-btn');
        const createFirstGroupBtn = document.getElementById('create-first-group-btn');
        const cancelCreateGroupBtn = document.getElementById('cancel-create-group');

        function showModal() {
            createGroupModal.classList.remove('hidden');
        }

        function hideModal() {
            createGroupModal.classList.add('hidden');
            createGroupForm.reset();
        }

        createGroupBtn?.addEventListener('click', showModal);
        createFirstGroupBtn?.addEventListener('click', showModal);
        cancelCreateGroupBtn.addEventListener('click', hideModal);

        createGroupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const members = Array.from(formData.getAll('members[]'));
            
            if (members.length === 0) {
                alert('Please select at least one member for the group.');
                return;
            }

            fetch('{{ route("groups.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    members: members
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                }
            });
        });
    });
</script>
@endpush 
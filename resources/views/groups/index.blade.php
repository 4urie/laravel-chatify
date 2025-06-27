@extends('layouts.chat')

@section('title', 'Groups')

@section('sidebar')
    <div class="p-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Groups</h3>
            <button id="create-group-btn" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                + New Group
            </button>
        </div>
        
        <!-- My Groups -->
        @if($groups->count() > 0)
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">My Groups</h4>
                @foreach($groups as $group)
                    <a href="{{ route('groups.show', $group) }}" class="group-item flex items-center space-x-3 no-underline text-inherit">
                        <div class="group-avatar">
                            @if($group->image)
                                <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($group->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium truncate">{{ $group->name }}</p>
                                <span class="text-xs text-gray-500">{{ $group->members_count }} members</span>
                            </div>
                            @if($group->latestMessage->first())
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $group->latestMessage->first()->sender->name }}: 
                                    {{ Str::limit($group->latestMessage->first()->message, 30) }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $group->latestMessage->first()->created_at->diffForHumans() }}
                                </p>
                            @else
                                <p class="text-xs text-gray-500">No messages yet</p>
                            @endif
                        </div>
                    </a>
                @endforeach
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
    <div class="flex items-center justify-center h-full bg-gray-50">
        <div class="text-center">
            <div class="mb-4">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome to Group Chats</h3>
            <p class="text-sm text-gray-500 mb-4">
                @if($groups->count() === 0)
                    Create your first group to start collaborating with your team
                @else
                    Select a group from the sidebar to continue the conversation
                @endif
            </p>
            
            @if($groups->count() === 0)
                <button id="create-first-group-btn" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium">
                    Create Your First Group
                </button>
            @endif
        </div>
    </div>

    <!-- Create Group Modal -->
    <div id="create-group-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Create New Group</h3>
                <form id="create-group-form" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="group-name" class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
                        <input type="text" 
                               id="group-name" 
                               name="name" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter group name"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="group-description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                        <textarea id="group-description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Enter group description"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="group-image" class="block text-sm font-medium text-gray-700 mb-2">Group Image (Optional)</label>
                        <input type="file" 
                               id="group-image" 
                               name="image" 
                               accept="image/*"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Add Members (Optional)</label>
                        <div class="max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-2">
                            @foreach($users as $user)
                                <label class="flex items-center space-x-2 mb-1">
                                    <input type="checkbox" name="members[]" value="{{ $user->id }}" class="rounded">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-500 flex items-center justify-center text-white text-xs">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm">{{ $user->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium">
                            Create Group
                        </button>
                        <button type="button" id="cancel-create-group" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show create group modal
            $('#create-group-btn, #create-first-group-btn').on('click', function() {
                $('#create-group-modal').removeClass('hidden');
            });

            // Hide create group modal
            $('#cancel-create-group').on('click', function() {
                $('#create-group-modal').addClass('hidden');
                $('#create-group-form')[0].reset();
            });

            // Hide modal when clicking outside
            $('#create-group-modal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                    $('#create-group-form')[0].reset();
                }
            });

            // Handle form submission
            $('#create-group-form').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                $.ajax({
                    url: '{{ route("groups.store") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.href = response.redirect || '{{ route("groups.index") }}';
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = 'Please correct the following errors:\n';
                            for (const field in errors) {
                                errorMessage += '- ' + errors[field][0] + '\n';
                            }
                            alert(errorMessage);
                        } else {
                            alert('An error occurred while creating the group. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
@endsection 
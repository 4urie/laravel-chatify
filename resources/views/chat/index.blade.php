@extends('layouts.chat')

@section('title', 'Select a User to Chat')

@section('sidebar')
    <div class="p-6" data-aos="fade-right">
        <h3 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-200 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
            </svg>
            Users
        </h3>
        
        <!-- Recent Chats -->
        @if($recentChats->count() > 0)
            <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Recent Chats
                </h4>
                @foreach($recentChats as $index => $user)
                    <a href="{{ route('chat.show', $user) }}" 
                       class="flex items-center p-4 mb-3 bg-gray-50 dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-gray-600 rounded-xl transition-all duration-200 hover-lift group"
                       data-aos="fade-left" 
                       data-aos-delay="{{ ($index + 1) * 50 }}">
                        <div class="w-12 h-12 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4 group-hover:bg-blue-700 dark:group-hover:bg-blue-400 transition-colors">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $user->name }}</p>
                                @if($user->unread_count > 0)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $user->unread_count }}</span>
                                @endif
                            </div>
                            @if(isset($user->latest_message))
                                <p class="text-sm text-gray-600 dark:text-gray-300 truncate mb-1">
                                    {{ Str::limit($user->latest_message->message, 30) }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $user->latest_message->created_at->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- All Users -->
        <div data-aos="fade-up" data-aos-delay="200">
            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                All Users
            </h4>
            @forelse($users as $index => $user)
                <a href="{{ route('chat.show', $user) }}" 
                   class="flex items-center p-4 mb-3 bg-gray-50 dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-gray-600 rounded-xl transition-all duration-200 hover-lift group"
                   data-aos="fade-left" 
                   data-aos-delay="{{ ($index + 1) * 50 + 200 }}">
                    <div class="w-12 h-12 bg-gray-600 dark:bg-gray-500 text-white rounded-full flex items-center justify-center font-bold mr-4 group-hover:bg-gray-700 dark:group-hover:bg-gray-400 transition-colors">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</p>
                    </div>
                </a>
            @empty
                <div class="text-center py-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3 text-left">
                                <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-300 mb-2">No users available</h3>
                                <p class="text-yellow-700 dark:text-yellow-400 text-sm">No other users are available to chat with at the moment.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-center h-full bg-gray-100 dark:bg-gray-900">
        <div class="text-center max-w-md" data-aos="zoom-in" data-aos-duration="800">
            <div class="mb-8" data-aos="fade-down" data-aos-delay="200">
                <div class="w-32 h-32 bg-blue-600 dark:bg-blue-500 rounded-full mx-auto mb-6 flex items-center justify-center animate-pulse-custom shadow-lg">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Welcome to Chatify</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">Select a user from the sidebar to start a conversation</p>
            </div>
            
            @if($users->count() === 0)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 max-w-sm mx-auto" data-aos="fade-up" data-aos-delay="600">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500 dark:bg-yellow-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 text-left">
                            <h5 class="text-lg font-bold text-yellow-600 dark:text-yellow-400 mb-2">No Users Available</h5>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                There are no other users registered yet. Create some test users to start chatting!
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8" data-aos="fade-up" data-aos-delay="600">
                    <div class="hover-scale cursor-pointer p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                        <svg class="w-12 h-12 mx-auto mb-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Fast & Secure</p>
                    </div>
                    <div class="hover-scale cursor-pointer p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                        <svg class="w-12 h-12 mx-auto mb-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Group Chats</p>
                    </div>
                    <div class="hover-scale cursor-pointer p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                        <svg class="w-12 h-12 mx-auto mb-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Multi-language</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection 
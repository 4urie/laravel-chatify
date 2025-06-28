<!-- Chat List -->
<div class="px-2 pb-4">
    @foreach($users as $chatUser)
        <a href="{{ route('chat.show', $chatUser) }}" 
            class="chat-item flex items-center px-4 py-3 {{ request()->route('user') && request()->route('user')->id === $chatUser->id ? 'bg-secondary-apple' : '' }}">
            <div class="user-avatar w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                {{ substr($chatUser->name, 0, 2) }}
            </div>
            <div class="ml-4 flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="text-sm font-semibold text-primary-apple truncate">{{ $chatUser->name }}</h3>
                    @if(isset($chatUser->unread_count) && $chatUser->unread_count > 0)
                        <div class="w-5 h-5 bg-blue-500 text-white text-xs font-medium rounded-full flex items-center justify-center">
                            {{ $chatUser->unread_count }}
                        </div>
                    @endif
                </div>
                @if(isset($chatUser->latest_message))
                    <p class="text-sm text-secondary-apple truncate mb-1">
                        {{ Str::limit($chatUser->latest_message->message, 35) }}
                    </p>
                    <p class="text-xs text-tertiary-apple">
                        {{ $chatUser->latest_message->created_at->diffForHumans() }}
                    </p>
                @else
                    <p class="text-sm text-secondary-apple">{{ $chatUser->email }}</p>
                @endif
            </div>
        </a>
    @endforeach

    @if($users->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 px-4">
            <div class="w-16 h-16 bg-secondary-apple rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-secondary-apple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-primary-apple mb-2">No conversations yet</h3>
            <p class="text-sm text-secondary-apple text-center">Start a conversation with someone to see your messages here</p>
        </div>
    @endif
</div> 
@extends('layouts.chat')

@section('title', 'Chats')

@section('sidebar')
    @foreach($recentChats as $chat)
        <a href="{{ route('chat.show', $chat->id) }}" 
            class="flex items-center px-2 py-2 mx-2 rounded-lg hover:bg-gray-100">
            <div class="relative">
                <div class="w-14 h-14 rounded-full flex items-center justify-center font-bold mr-3 bg-blue-100 text-blue-800">
                    {{ strtoupper(substr($chat->name, 0, 2)) }}
                </div>
                @if($chat->is_online)
                    <div class="absolute bottom-0 right-3 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <p class="font-semibold truncate text-gray-900">{{ $chat->name }}</p>
                    @if($chat->unread_count > 0)
                        <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full ml-2">{{ $chat->unread_count }}</span>
                    @endif
                </div>
                @if(isset($chat->latest_message))
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="font-medium truncate">{{ $chat->latest_message->sender->name === Auth::user()->name ? 'You' : $chat->latest_message->sender->name }}:</span>
                        <span class="truncate ml-1">{{ Str::limit($chat->latest_message->message, 30) }}</span>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $chat->latest_message->created_at->diffForHumans() }}
                    </p>
                @endif
            </div>
        </a>
    @endforeach
@endsection

@section('main-content')
    <div class="flex items-center justify-center h-full text-gray-600">
        <div class="text-center">
            <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2 text-gray-900">Select a chat</h3>
            <p class="text-sm text-gray-600">Choose from your existing conversations or start a new one</p>
        </div>
    </div>
@endsection 
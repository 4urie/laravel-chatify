<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ Auth::user()->dark_mode ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chatify') }} - @yield('title', 'Chat')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom chat-specific styles that complement Tailwind */
        .chat-messages {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        
        .dark .chat-messages {
            scrollbar-color: #6b7280 #374151;
        }
        
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }
        
        .chat-messages::-webkit-scrollbar-track {
            background: #f7fafc;
        }
        
        .dark .chat-messages::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .chat-messages::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .dark .chat-messages::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        .dark .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        .message-bubble {
            word-wrap: break-word;
            word-break: break-word;
        }
        
        /* Animation for new messages */
        .message-enter {
            opacity: 0;
            transform: translateY(20px);
            animation: messageEnter 0.3s ease-out forwards;
        }
        
        @keyframes messageEnter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="h-screen overflow-hidden">
        <div class="flex h-full">
            <!-- Sidebar -->
            <div class="w-80 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col transition-colors duration-300">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-8 h-8 mr-2 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                            </svg>
                            Chatify
                        </h2>
                        <div class="flex items-center space-x-3">
                            <!-- Dark Mode Toggle -->
                            <button id="dark-mode-toggle" 
                                    class="dark-mode-toggle {{ Auth::user()->dark_mode ? 'active' : '' }}"
                                    title="Toggle dark mode">
                                <span class="toggle-icon sun-icon">☀️</span>
                                <span class="toggle-icon moon-icon">🌙</span>
                            </button>
                            
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Online</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Navigation Tabs -->
                    <div class="flex space-x-1 bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                        <a href="{{ route('chat.index') }}" 
                           class="flex-1 text-center py-2 px-3 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('chat.*') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-600' }}">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                            </svg>
                            Private Chats
                        </a>
                        <a href="{{ route('groups.index') }}" 
                           class="flex-1 text-center py-2 px-3 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('groups.*') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-600' }}">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            Groups
                        </a>
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto bg-white dark:bg-gray-800">
                    @yield('sidebar')
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="flex-1 flex flex-col bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Set up CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
        
        // Add CSRF token to all AJAX requests
        if (typeof $ !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        
        // Dark mode toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const html = document.documentElement;
            
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function() {
                    // Toggle the active class on the button
                    this.classList.toggle('active');
                    
                    // Toggle dark class on html element
                    html.classList.toggle('dark');
                    
                    // Get current state
                    const isDarkMode = html.classList.contains('dark');
                    
                    // Send AJAX request to save preference
                    fetch('{{ route("preferences.dark-mode.update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            dark_mode: isDarkMode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show toast notification if available
                            if (typeof window.showToast === 'function') {
                                window.showToast(data.message, 'success');
                            }
                        } else {
                            // Revert the toggle if the request failed
                            this.classList.toggle('active');
                            html.classList.toggle('dark');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating dark mode preference:', error);
                        // Revert the toggle if the request failed
                        this.classList.toggle('active');
                        html.classList.toggle('dark');
                    });
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
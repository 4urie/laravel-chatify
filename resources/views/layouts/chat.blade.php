<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Apple-Inspired Theme -->
    <style>
        /* Apple-Inspired Design System */
        :root {
            /* Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f5f5f7;
            --bg-tertiary: #fbfbfd;
            --text-primary: #1d1d1f;
            --text-secondary: #86868b;
            --text-tertiary: #515154;
            --border-light: #d2d2d7;
            --border-medium: #a1a1a6;
            --accent-blue: #007aff;
            --accent-blue-hover: #0056cc;
            --accent-green: #30d158;
            --accent-red: #ff3b30;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --shadow-medium: rgba(0, 0, 0, 0.15);
            --shadow-heavy: rgba(0, 0, 0, 0.25);
            
            /* Typography */
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-weight-light: 300;
            --font-weight-regular: 400;
            --font-weight-medium: 500;
            --font-weight-semibold: 600;
            --font-weight-bold: 700;
            
            /* Spacing */
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;
            --spacing-2xl: 48px;
            
            /* Border Radius */
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-full: 50%;
            
            /* Transitions */
            --transition-fast: 0.15s ease-out;
            --transition-medium: 0.25s ease-out;
            --transition-slow: 0.35s ease-out;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.47059;
            font-weight: var(--font-weight-regular);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .chat-sidebar {
            background-color: var(--bg-primary);
            border-right: 1px solid var(--border-light);
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .chat-main {
            background-color: var(--bg-primary);
        }

        .message-input {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            border: 1px solid var(--border-light);
            transition: all var(--transition-fast);
            font-family: var(--font-family);
        }

        .message-input:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
        }

        .message-bubble {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-light);
            box-shadow: 0 1px 2px var(--shadow-light);
        }

        .message-bubble.sent {
            background: linear-gradient(135deg, var(--accent-blue) 0%, #5ac8fa 100%);
            color: white;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 122, 255, 0.2);
        }

        .chat-header {
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--border-light);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .nav-bar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-light);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue) 0%, #5ac8fa 100%);
            color: white;
            border: none;
            transition: all var(--transition-fast);
            font-weight: var(--font-weight-medium);
            box-shadow: 0 2px 4px rgba(0, 122, 255, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-blue-hover) 0%, #4fb3e1 100%);
            box-shadow: 0 4px 8px rgba(0, 122, 255, 0.3);
            transform: translateY(-1px);
        }

        .user-avatar {
            background: linear-gradient(135deg, var(--accent-blue) 0%, #5ac8fa 100%);
            color: white;
            font-weight: var(--font-weight-semibold);
            border: 2px solid var(--bg-primary);
            box-shadow: 0 2px 8px var(--shadow-light);
        }

        .chat-item {
            transition: all var(--transition-fast);
            border-radius: var(--radius-md);
            margin: 0 var(--spacing-sm);
        }

        .chat-item:hover {
            background-color: var(--bg-secondary);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px var(--shadow-light);
        }

        .search-input {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-light);
            color: var(--text-primary);
            transition: all var(--transition-fast);
        }

        .search-input:focus {
            background-color: var(--bg-primary);
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
        }

        .dropdown-menu {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 30px var(--shadow-medium);
        }

        .text-primary-apple { color: var(--text-primary); }
        .text-secondary-apple { color: var(--text-secondary); }
        .text-tertiary-apple { color: var(--text-tertiary); }
        .bg-primary-apple { background-color: var(--bg-primary); }
        .bg-secondary-apple { background-color: var(--bg-secondary); }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="nav-bar">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('chat.index') }}" class="text-xl font-bold text-primary-apple">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('chat.index') }}" 
                                class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('chat.*') ? 'border-blue-500 text-primary-apple' : 'border-transparent text-secondary-apple hover:text-primary-apple hover:border-gray-300' }} text-sm font-medium transition-all duration-150">
                                Messages
                            </a>
                            <a href="{{ route('groups.index') }}" 
                                class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('groups.*') ? 'border-blue-500 text-primary-apple' : 'border-transparent text-secondary-apple hover:text-primary-apple hover:border-gray-300' }} text-sm font-medium transition-all duration-150">
                                Groups
                            </a>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                            <div @click="open = ! open">
                                <button class="flex items-center text-sm font-medium text-primary-apple hover:text-secondary-apple focus:outline-none transition duration-150 ease-in-out">
                                    <div class="user-avatar w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                        {{ substr(Auth::user()->name, 0, 2) }}
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </div>

                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-50 mt-2 w-48 origin-top-right right-0"
                                style="display: none;">
                                <div class="dropdown-menu py-1">
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm leading-5 text-primary-apple hover:bg-secondary-apple focus:outline-none transition duration-150 ease-in-out">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Chat Layout -->
        <div class="flex h-[calc(100vh-4rem)]">
            <!-- Sidebar -->
            <div class="w-[360px] chat-sidebar overflow-y-auto">
                <!-- Search -->
                <div class="p-4">
                    <div class="relative">
                        <input type="text" class="search-input w-full rounded-full pl-10 pr-4 py-3 focus:outline-none focus:ring-0 text-sm" 
                            placeholder="Search messages">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-apple" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                @yield('sidebar')
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col chat-main">
                @yield('main-content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
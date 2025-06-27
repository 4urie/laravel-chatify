@extends('layouts.tailwind')

@section('title', 'Login')
@section('description', 'Sign in to your account')
@section('body-class', 'bg-gradient-to-br from-blue-600 via-purple-600 to-purple-800 min-h-screen')

@push('styles')
    <style>
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
         input {
        color: black !important;
        background-color: white !important;
    }
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            top: 10%;
            left: 20%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            top: 20%;
            right: 20%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            bottom: 20%;
            left: 10%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            bottom: 10%;
            right: 30%;
            animation-delay: 1s;
        }
    </style>
@endpush

@section('navigation')
    <nav class="fixed top-0 left-0 right-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold text-white hover-scale" href="/" data-aos="fade-right">
                <svg class="w-8 h-8 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ config('app.name', 'Chatify') }}
            </a>
            <div class="hidden md:block">
                <a class="text-white hover:text-gray-200 transition-colors" href="{{ route('register') }}"
                    data-aos="fade-left">
                    Need an account?
                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative">
        <!-- Floating Background Shapes -->
        <div class="floating-shapes">
            <svg class="shape w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                    clip-rule="evenodd"></path>
            </svg>
            <svg class="shape w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
            </svg>
            <svg class="shape w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
            </svg>
            <svg class="shape w-14 h-14 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>

        <div class="max-w-md w-full space-y-8 relative z-10">
            <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20 hover-lift"
                data-aos="zoom-in" data-aos-duration="800">
                <!-- Header -->
                <div class="text-center mb-8" data-aos="fade-down" data-aos-delay="200">
                    <div
                        class="w-20 h-20 bg-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center animate-pulse-custom">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back!</h2>
                    <p class="text-gray-600">Sign in to continue to your dashboard</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg animate-fade-in-up" role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-green-800">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6" data-aos="fade-up" data-aos-delay="400">
                    @csrf

                    <!-- Email Field -->
                    <div class="relative" data-aos="fade-right" data-aos-delay="500">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                            Email Address
                        </label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                              text-black bg-white
                              focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                              transition-all duration-200 
                              @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Enter your email" required autocomplete="username" autofocus>

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="relative" data-aos="fade-left" data-aos-delay="600">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg 
                   text-black bg-white
                   focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                   transition-all duration-200 
                   @error('password') border-red-500 @enderror" id="password" name="password"
                                placeholder="Enter your password" required autocomplete="current-password">

                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                id="togglePassword">
                                <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="700">
                        <div class="flex items-center">
                            <input
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="ml-2 text-sm text-gray-700" for="remember">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-blue-600 hover:text-blue-500 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 btn-ripple"
                        data-aos="zoom-in" data-aos-delay="800">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sign In
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6" data-aos="fade-up" data-aos-delay="900">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            class="text-blue-600 hover:text-blue-500 font-semibold transition-colors">
                            Create one here
                        </a>
                    </p>
                </div>

                <!-- Test Accounts Info -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg" data-aos="fade-up" data-aos-delay="1000">
                    <h6 class="font-semibold text-blue-800 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Test Accounts
                    </h6>
                    <div class="text-sm text-blue-700 space-y-1">
                        <p><strong>john@example.com</strong> / password</p>
                        <p><strong>jane@example.com</strong> / password</p>
                        <p><strong>mike@example.com</strong> / password</p>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="text-center mt-8" data-aos="fade-up" data-aos-delay="1200">
                <div class="grid grid-cols-3 gap-8 text-white">
                    <div class="hover-scale cursor-pointer">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm">Fast & Secure</p>
                    </div>
                    <div class="hover-scale cursor-pointer">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z">
                            </path>
                        </svg>
                        <p class="text-sm">Group Chats</p>
                    </div>
                    <div class="hover-scale cursor-pointer">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                            </path>
                        </svg>
                        <p class="text-sm">Multi-language</p>
                    </div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="1300">
                <p class="text-white/80 text-sm flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Your data is secure and encrypted
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password visibility toggle
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');

            if (toggleIcon) {
                toggleIcon.addEventListener('click', function () {
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);

                    // Update icon
                    const icon = this.querySelector('svg');
                    if (type === 'password') {
                        icon.innerHTML = `
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                `;
                    } else {
                        icon.innerHTML = `
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                `;
                    }
                });
            }
        });
    </script>
@endpush
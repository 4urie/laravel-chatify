<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Modern Laravel application with Bootstrap 5 and animations')">

    <title>@yield('title', config('app.name', 'Laravel')) - {{ config('app.name', 'Laravel') }}</title>

    <!-- Preload critical fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }
    </style>
</head>
<body class="@yield('body-class', '')">
    <!-- Loading Screen -->
    <div id="loading-screen" class="position-fixed top-0 start-0 w-100 h-100 bg-white d-flex align-items-center justify-content-center" style="z-index: 9999;">
        <div class="text-center">
            <div class="spinner-custom mb-3"></div>
            <p class="text-muted">Loading...</p>
        </div>
    </div>

    <!-- Navigation -->
    @hasSection('navigation')
        @yield('navigation')
    @else
        @include('components.navbar')
    @endif

    <!-- Main Content -->
    <main class="@yield('main-class', '')">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-fade-in-up" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show animate-fade-in-up" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show animate-fade-in-up" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show animate-fade-in-up" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    @hasSection('footer')
        @yield('footer')
    @else
        @include('components.footer')
    @endif

    <!-- Scroll to Top Button -->
    <button id="scroll-to-top" class="btn btn-primary position-fixed bottom-0 end-0 m-4 rounded-circle d-none" style="width: 50px; height: 50px; z-index: 1000;">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Additional Scripts -->
    @stack('scripts')

    <!-- Global JavaScript -->
    <script>
        // Hide loading screen
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 300);
            }
        });

        // Scroll to top functionality
        const scrollToTopBtn = document.getElementById('scroll-to-top');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('d-none');
                scrollToTopBtn.classList.add('animate-fade-in-up');
            } else {
                scrollToTopBtn.classList.add('d-none');
                scrollToTopBtn.classList.remove('animate-fade-in-up');
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Global error handling
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
        });

        // Performance monitoring
        if ('performance' in window) {
            window.addEventListener('load', function() {
                setTimeout(() => {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    console.log('Page Load Time:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
                }, 0);
            });
        }
    </script>
</body>
</html> 
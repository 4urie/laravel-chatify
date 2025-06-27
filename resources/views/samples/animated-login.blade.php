@extends('layouts.bootstrap')

@section('title', 'Animated Login')
@section('description', 'Beautiful animated login page with Bootstrap 5')
@section('body-class', 'bg-gradient-primary')

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .login-card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
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
    <!-- Custom minimal navbar for login page -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100" style="z-index: 1000;">
        <div class="container">
            <a class="navbar-brand fw-bold hover-scale" href="/" data-aos="fade-right">
                <i class="bi bi-chat-dots-fill me-2"></i>
                {{ config('app.name', 'Chatify') }}
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="#" data-aos="fade-left">
                    Need help? <i class="bi bi-question-circle ms-1"></i>
                </a>
            </div>
        </div>
    </nav>
@endsection

@section('content')
<div class="login-container position-relative">
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <i class="bi bi-chat-dots shape fs-1"></i>
        <i class="bi bi-people shape fs-2"></i>
        <i class="bi bi-envelope shape fs-3"></i>
        <i class="bi bi-heart shape fs-2"></i>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <!-- Login Card -->
                <div class="card login-card border-0 rounded-4 hover-lift" data-aos="zoom-in" data-aos-duration="800">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4" data-aos="fade-down" data-aos-delay="200">
                            <div class="avatar-lg mx-auto mb-3 bg-primary rounded-circle d-flex align-items-center justify-content-center animate-pulse">
                                <i class="bi bi-person-circle fs-1 text-white"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-2">Welcome Back!</h2>
                            <p class="text-muted">Sign in to continue to your dashboard</p>
                        </div>

                        <!-- Login Form -->
                        <form class="needs-validation" novalidate data-aos="fade-up" data-aos-delay="400">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="form-floating mb-3" data-aos="fade-right" data-aos-delay="500">
                                <input type="email" 
                                       class="form-control border-0 bg-light" 
                                       id="email" 
                                       name="email"
                                       placeholder="Enter your email" 
                                       required>
                                <label for="email">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-floating mb-3" data-aos="fade-left" data-aos-delay="600">
                                <input type="password" 
                                       class="form-control border-0 bg-light" 
                                       id="password" 
                                       name="password"
                                       placeholder="Enter your password" 
                                       required>
                                <label for="password">
                                    <i class="bi bi-lock me-2"></i>Password
                                </label>
                                <div class="invalid-feedback">
                                    Please enter your password.
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up" data-aos-delay="700">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label text-muted" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#" class="text-primary text-decoration-none hover-glow">
                                    Forgot password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="btn btn-primary btn-lg w-100 mb-3 hover-lift" 
                                    data-aos="zoom-in" 
                                    data-aos-delay="800">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Sign In
                                <div class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>

                            <!-- Social Login -->
                            <div class="text-center mb-3" data-aos="fade-up" data-aos-delay="900">
                                <p class="text-muted mb-3">Or continue with</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button" class="btn btn-outline-danger hover-scale flex-fill">
                                        <i class="bi bi-google"></i>
                                        Google
                                    </button>
                                    <button type="button" class="btn btn-outline-primary hover-scale flex-fill">
                                        <i class="bi bi-facebook"></i>
                                        Facebook
                                    </button>
                                    <button type="button" class="btn btn-outline-dark hover-scale flex-fill">
                                        <i class="bi bi-github"></i>
                                        GitHub
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Register Link -->
                        <div class="text-center" data-aos="fade-up" data-aos-delay="1000">
                            <p class="text-muted mb-0">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none hover-glow">
                                    Create one here
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-transparent border-0 text-center py-3" data-aos="fade-up" data-aos-delay="1100">
                        <small class="text-muted">
                            <i class="bi bi-shield-check text-success me-1"></i>
                            Your data is secure and encrypted
                        </small>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="1200">
                    <div class="row text-white">
                        <div class="col-4">
                            <div class="hover-scale cursor-pointer">
                                <i class="bi bi-lightning-charge fs-2 mb-2"></i>
                                <p class="small mb-0">Fast & Secure</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hover-scale cursor-pointer">
                                <i class="bi bi-people fs-2 mb-2"></i>
                                <p class="small mb-0">10k+ Users</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hover-scale cursor-pointer">
                                <i class="bi bi-award fs-2 mb-2"></i>
                                <p class="small mb-0">Award Winning</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <!-- No footer for login page -->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced form submission with loading state
    const form = document.querySelector('.needs-validation');
    const submitBtn = form.querySelector('button[type="submit"]');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (form.checkValidity()) {
            // Show loading state
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            
            // Simulate API call
            setTimeout(() => {
                // Reset form state
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
                
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success animate-fade-in-up';
                alert.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Login successful! Redirecting...';
                form.parentNode.insertBefore(alert, form);
                
                // Simulate redirect
                setTimeout(() => {
                    window.location.href = '{{ route("chat.index") }}';
                }, 1500);
            }, 2000);
        }
    });
    
    // Add floating animation to shapes
    const shapes = document.querySelectorAll('.shape');
    shapes.forEach((shape, index) => {
        shape.style.animationDelay = `${index * 0.5}s`;
    });
    
    // Password visibility toggle
    const passwordField = document.getElementById('password');
    const toggleIcon = document.createElement('i');
    toggleIcon.className = 'bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer';
    toggleIcon.style.zIndex = '10';
    
    passwordField.parentNode.style.position = 'relative';
    passwordField.parentNode.appendChild(toggleIcon);
    
    toggleIcon.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.className = type === 'password' ? 'bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer' : 'bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer';
    });
});
</script>
@endpush 
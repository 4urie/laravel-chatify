@extends('layouts.bootstrap')

@section('title', 'Animated Dashboard')
@section('description', 'Modern dashboard with Bootstrap 5 and smooth animations')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0 50px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }
    
    .stats-card:hover::before {
        transform: translateX(100%);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin: 0 auto 1rem;
    }
    
    .progress-animated {
        height: 8px;
        border-radius: 10px;
        overflow: hidden;
        background: #e9ecef;
    }
    
    .progress-bar-animated {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transition: width 2s ease-in-out;
        width: 0;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        background: #f8f9fa;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">
                    Welcome to Your Dashboard
                </h1>
                <p class="lead mb-4">
                    Monitor your chat activity, manage groups, and stay connected with your team 
                    through our beautiful and intuitive interface.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('chat.index') }}" class="btn btn-light btn-lg hover-lift">
                        <i class="bi bi-chat-dots me-2"></i>
                        Start Chatting
                    </a>
                    <a href="{{ route('groups.index') }}" class="btn btn-outline-light btn-lg hover-lift">
                        <i class="bi bi-people me-2"></i>
                        View Groups
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        <img src="https://via.placeholder.com/400x300/667eea/ffffff?text=Dashboard+Preview" 
                             alt="Dashboard Preview" 
                             class="img-fluid rounded-4 shadow-lg hover-scale">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-10 rounded-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -1;">
        <div class="position-absolute animate-float" style="top: 20%; left: 10%; opacity: 0.1;">
            <i class="bi bi-chat-dots fs-1"></i>
        </div>
        <div class="position-absolute animate-float" style="top: 60%; right: 15%; opacity: 0.1; animation-delay: 1s;">
            <i class="bi bi-people fs-2"></i>
        </div>
        <div class="position-absolute animate-float" style="bottom: 20%; left: 20%; opacity: 0.1; animation-delay: 2s;">
            <i class="bi bi-envelope fs-3"></i>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 stagger-animation">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center hover-lift">
                    <i class="bi bi-chat-dots fs-1 mb-3"></i>
                    <h3 class="fw-bold mb-2">1,234</h3>
                    <p class="mb-0 opacity-75">Total Messages</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center hover-lift">
                    <i class="bi bi-people fs-1 mb-3"></i>
                    <h3 class="fw-bold mb-2">56</h3>
                    <p class="mb-0 opacity-75">Active Groups</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center hover-lift">
                    <i class="bi bi-person-check fs-1 mb-3"></i>
                    <h3 class="fw-bold mb-2">89</h3>
                    <p class="mb-0 opacity-75">Online Users</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center hover-lift">
                    <i class="bi bi-file-earmark fs-1 mb-3"></i>
                    <h3 class="fw-bold mb-2">234</h3>
                    <p class="mb-0 opacity-75">Files Shared</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Powerful Features</h2>
            <p class="lead text-muted">Everything you need for seamless communication</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon animate-pulse">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Real-time Messaging</h5>
                        <p class="text-muted">
                            Instant message delivery with live typing indicators and read receipts.
                        </p>
                        <div class="progress-animated mt-3">
                            <div class="progress-bar-animated" data-width="95"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">95% Uptime</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon animate-pulse" style="animation-delay: 0.5s;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Secure & Private</h5>
                        <p class="text-muted">
                            End-to-end encryption ensures your conversations remain private and secure.
                        </p>
                        <div class="progress-animated mt-3">
                            <div class="progress-bar-animated" data-width="100"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">100% Secure</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon animate-pulse" style="animation-delay: 1s;">
                            <i class="bi bi-translate"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Multi-language</h5>
                        <p class="text-muted">
                            Automatic language detection and translation for global communication.
                        </p>
                        <div class="progress-animated mt-3">
                            <div class="progress-bar-animated" data-width="87"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">50+ Languages</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon animate-pulse" style="animation-delay: 1.5s;">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        <h5 class="fw-bold mb-3">File Sharing</h5>
                        <p class="text-muted">
                            Share images, documents, and files up to 10MB with ease.
                        </p>
                        <div class="progress-animated mt-3">
                            <div class="progress-bar-animated" data-width="92"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">10MB Limit</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon animate-pulse" style="animation-delay: 2s;">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Group Management</h5>
                        <p class="text-muted">
                            Create and manage groups with admin controls and member permissions.
                        </p>
                        <div class="progress-animated mt-3">
                            <div class="progress-bar-animated" data-width="88"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">Unlimited Groups</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon animate-pulse" style="animation-delay: 2.5s;">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Mobile Responsive</h5>
                        <p class="text-muted">
                            Perfect experience across all devices with responsive design.
                        </p>
                        <div class="progress-animated mt-3">
                            <div class="progress-bar-animated" data-width="96"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">All Devices</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Analytics Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="display-6 fw-bold mb-4">Real-time Analytics</h2>
                <p class="lead text-muted mb-4">
                    Track your communication patterns and team engagement with detailed analytics.
                </p>
                
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Messages</h6>
                                <small class="text-muted">+24% this week</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle p-2 me-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Users</h6>
                                <small class="text-muted">+12% this week</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="#" class="btn btn-primary btn-lg hover-lift">
                    <i class="bi bi-bar-chart me-2"></i>
                    View Full Analytics
                </a>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="chart-container">
                    <div class="text-center">
                        <i class="bi bi-bar-chart fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Interactive Chart</h5>
                        <p class="text-muted">Chart.js integration would go here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="display-6 fw-bold mb-3">Ready to Get Started?</h2>
        <p class="lead mb-4">Join thousands of users already using our platform</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg hover-lift">
                <i class="bi bi-person-plus me-2"></i>
                Create Account
            </a>
            <a href="{{ route('chat.index') }}" class="btn btn-outline-light btn-lg hover-lift">
                <i class="bi bi-chat-dots me-2"></i>
                Start Chatting
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars when they come into view
    const progressBars = document.querySelectorAll('.progress-bar-animated');
    
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                const width = progressBar.getAttribute('data-width');
                setTimeout(() => {
                    progressBar.style.width = width + '%';
                }, 500);
                progressObserver.unobserve(progressBar);
            }
        });
    });
    
    progressBars.forEach(bar => progressObserver.observe(bar));
    
    // Add counter animation for stats
    const statsNumbers = document.querySelectorAll('.stats-card h3');
    
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const numberElement = entry.target;
                const finalNumber = parseInt(numberElement.textContent.replace(/,/g, ''));
                let currentNumber = 0;
                const increment = finalNumber / 100;
                
                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= finalNumber) {
                        numberElement.textContent = finalNumber.toLocaleString();
                        clearInterval(timer);
                    } else {
                        numberElement.textContent = Math.floor(currentNumber).toLocaleString();
                    }
                }, 20);
                
                statsObserver.unobserve(numberElement);
            }
        });
    });
    
    statsNumbers.forEach(num => statsObserver.observe(num));
});
</script>
@endpush 
<footer class="bg-dark text-light mt-5" data-aos="fade-up">
    <div class="container py-5">
        <div class="row">
            <!-- Brand Section -->
            <div class="col-lg-4 mb-4" data-aos="fade-right" data-aos-delay="100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-chat-dots-fill text-primary me-2"></i>
                    {{ config('app.name', 'Chatify') }}
                </h5>
                <p class="text-muted mb-3">
                    A modern real-time chat application built with Laravel 12 and Bootstrap 5, 
                    featuring group chats, multilingual support, and beautiful animations.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-light hover-scale">
                        <i class="bi bi-github fs-4"></i>
                    </a>
                    <a href="#" class="text-light hover-scale">
                        <i class="bi bi-twitter fs-4"></i>
                    </a>
                    <a href="#" class="text-light hover-scale">
                        <i class="bi bi-linkedin fs-4"></i>
                    </a>
                    <a href="#" class="text-light hover-scale">
                        <i class="bi bi-envelope fs-4"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    @auth
                        <li class="mb-2">
                            <a href="{{ route('chat.index') }}" class="text-muted text-decoration-none hover-glow">
                                <i class="bi bi-chat-left-text me-2"></i>Private Chats
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('groups.index') }}" class="text-muted text-decoration-none hover-glow">
                                <i class="bi bi-people me-2"></i>Groups
                            </a>
                        </li>
                    @endauth
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-glow">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-glow">
                            <i class="bi bi-question-circle me-2"></i>Help
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Features -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <h6 class="fw-bold mb-3">Features</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <span class="text-muted">
                            <i class="bi bi-check-circle text-success me-2"></i>Real-time Messaging
                        </span>
                    </li>
                    <li class="mb-2">
                        <span class="text-muted">
                            <i class="bi bi-check-circle text-success me-2"></i>Group Chats
                        </span>
                    </li>
                    <li class="mb-2">
                        <span class="text-muted">
                            <i class="bi bi-check-circle text-success me-2"></i>File Sharing
                        </span>
                    </li>
                    <li class="mb-2">
                        <span class="text-muted">
                            <i class="bi bi-check-circle text-success me-2"></i>Multi-language Support
                        </span>
                    </li>
                    <li class="mb-2">
                        <span class="text-muted">
                            <i class="bi bi-check-circle text-success me-2"></i>Modern UI/UX
                        </span>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 mb-4" data-aos="fade-left" data-aos-delay="400">
                <h6 class="fw-bold mb-3">Get in Touch</h6>
                <div class="mb-2">
                    <i class="bi bi-envelope text-primary me-2"></i>
                    <span class="text-muted">support@chatify.com</span>
                </div>
                <div class="mb-2">
                    <i class="bi bi-telephone text-primary me-2"></i>
                    <span class="text-muted">+1 (555) 123-4567</span>
                </div>
                <div class="mb-3">
                    <i class="bi bi-geo-alt text-primary me-2"></i>
                    <span class="text-muted">San Francisco, CA</span>
                </div>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <!-- Bottom Section -->
        <div class="row align-items-center" data-aos="fade-up" data-aos-delay="500">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Chatify') }}. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex justify-content-md-end gap-3 mt-3 mt-md-0">
                    <a href="#" class="text-muted text-decoration-none hover-glow">Privacy Policy</a>
                    <a href="#" class="text-muted text-decoration-none hover-glow">Terms of Service</a>
                    <a href="#" class="text-muted text-decoration-none hover-glow">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Animated Background Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: -1;">
        <div class="position-absolute animate-float" style="top: 10%; left: 10%; width: 20px; height: 20px; background: rgba(0, 123, 255, 0.1); border-radius: 50%; animation-delay: 0s;"></div>
        <div class="position-absolute animate-float" style="top: 20%; right: 15%; width: 15px; height: 15px; background: rgba(40, 167, 69, 0.1); border-radius: 50%; animation-delay: 1s;"></div>
        <div class="position-absolute animate-float" style="bottom: 30%; left: 20%; width: 25px; height: 25px; background: rgba(255, 193, 7, 0.1); border-radius: 50%; animation-delay: 2s;"></div>
        <div class="position-absolute animate-float" style="bottom: 20%; right: 10%; width: 18px; height: 18px; background: rgba(220, 53, 69, 0.1); border-radius: 50%; animation-delay: 3s;"></div>
    </div>
</footer> 
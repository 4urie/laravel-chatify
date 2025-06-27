<nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top animate-slide-in-down">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold fs-3 hover-scale" href="{{ route('chat.index') }}" data-aos="fade-right">
            <i class="bi bi-chat-dots-fill text-primary me-2"></i>
            {{ config('app.name', 'Chatify') }}
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <!-- Chat Links -->
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="100">
                        <a class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}" href="{{ route('chat.index') }}">
                            <i class="bi bi-chat-left-text me-1"></i>
                            Private Chats
                        </a>
                    </li>
                    
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="200">
                        <a class="nav-link {{ request()->routeIs('groups.*') ? 'active' : '' }}" href="{{ route('groups.index') }}">
                            <i class="bi bi-people me-1"></i>
                            Groups
                        </a>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown" data-aos="fade-down" data-aos-delay="300">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end animate-fade-in-up" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear me-2"></i>
                                    Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Guest Links -->
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="100">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login
                        </a>
                    </li>
                    
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="200">
                        <a class="btn btn-primary ms-2 hover-lift" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i>
                            Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Add spacing for fixed navbar -->
<div style="height: 80px;"></div> 
# Bootstrap 5 + Animations Implementation Guide

## 🎨 **Overview**
This guide shows you how to implement Bootstrap 5 with beautiful animations in Laravel 12 using Vite, including AOS (Animate On Scroll), custom CSS animations, and performance optimizations.

## 📦 **Installation Complete**

### Dependencies Installed:
- ✅ **Bootstrap 5.3.2** - Latest stable version
- ✅ **@popperjs/core** - Required for Bootstrap dropdowns/tooltips
- ✅ **Sass** - For custom styling and Bootstrap customization
- ✅ **Animate.css** - CSS animation library
- ✅ **AOS** - Animate On Scroll library
- ✅ **Bootstrap Icons** - Official Bootstrap icon library

## ⚙️ **Configuration**

### 1. Vite Configuration (`vite.config.js`)
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', 
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "bootstrap/scss/functions"; @import "bootstrap/scss/variables";`
            }
        }
    }
});
```

### 2. Sass Configuration (`resources/sass/app.scss`)
- **Custom Bootstrap Variables** - Override colors, spacing, borders
- **Animation Keyframes** - fadeInUp, slideInDown, pulse, float
- **Utility Classes** - hover-lift, hover-scale, hover-glow
- **Component Animations** - buttons, cards, modals, navbar
- **Performance Optimizations** - reduced motion support

### 3. JavaScript Setup (`resources/js/app.js`)
- **AOS Initialization** - Scroll animations
- **Bootstrap JS** - Interactive components
- **Custom Interactions** - button ripples, smooth scrolling
- **Form Enhancements** - validation animations
- **Performance Features** - lazy loading, error handling

## 🎭 **Animation Classes Available**

### Basic Animations
```html
<!-- Fade Animations -->
<div class="animate-fade-in-up">Content</div>
<div class="animate-fade-in-left">Content</div>
<div class="animate-fade-in-right">Content</div>

<!-- Slide Animations -->
<div class="animate-slide-in-down">Content</div>

<!-- Continuous Animations -->
<div class="animate-pulse">Pulsing content</div>
<div class="animate-float">Floating content</div>
```

### Hover Effects
```html
<!-- Hover Transformations -->
<div class="hover-lift">Lifts on hover</div>
<div class="hover-scale">Scales on hover</div>
<div class="hover-rotate">Rotates on hover</div>
<div class="hover-glow">Glows on hover</div>
```

### AOS (Animate On Scroll) Attributes
```html
<!-- Basic AOS -->
<div data-aos="fade-up">Animates when scrolled into view</div>
<div data-aos="fade-left" data-aos-delay="200">Delayed animation</div>
<div data-aos="zoom-in" data-aos-duration="800">Custom duration</div>

<!-- Available AOS Animations -->
data-aos="fade-up"
data-aos="fade-down"
data-aos="fade-left"
data-aos="fade-right"
data-aos="zoom-in"
data-aos="zoom-out"
data-aos="slide-up"
data-aos="slide-down"
data-aos="flip-left"
data-aos="flip-right"
```

### Stagger Animations for Lists
```html
<div class="stagger-animation">
    <div>Item 1 - animates first</div>
    <div>Item 2 - animates second</div>
    <div>Item 3 - animates third</div>
    <!-- Automatically staggers with 0.1s delay between items -->
</div>
```

## 🏗️ **Component Examples**

### 1. Animated Buttons
```html
<!-- Basic animated button -->
<button class="btn btn-primary hover-lift">
    <i class="bi bi-download me-2"></i>
    Download
</button>

<!-- Button with ripple effect (automatic) -->
<button class="btn btn-success">
    Click me for ripple effect
</button>

<!-- Floating action button -->
<button class="btn btn-primary rounded-circle animate-float" style="width: 60px; height: 60px;">
    <i class="bi bi-plus fs-4"></i>
</button>
```

### 2. Animated Cards
```html
<!-- Card with hover animation -->
<div class="card hover-lift" data-aos="fade-up">
    <div class="card-body">
        <h5 class="card-title">Animated Card</h5>
        <p class="card-text">This card lifts on hover and fades in on scroll.</p>
        <a href="#" class="btn btn-primary hover-scale">Learn More</a>
    </div>
</div>

<!-- Card with stagger animation -->
<div class="row stagger-animation">
    <div class="col-md-4">
        <div class="card card-animated">Card 1</div>
    </div>
    <div class="col-md-4">
        <div class="card card-animated">Card 2</div>
    </div>
    <div class="col-md-4">
        <div class="card card-animated">Card 3</div>
    </div>
</div>
```

### 3. Animated Modals
```html
<!-- Modal with enhanced animations -->
<div class="modal fade" id="animatedModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" data-aos="zoom-in">
            <div class="modal-header">
                <h5 class="modal-title">Animated Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p data-aos="fade-up" data-aos-delay="200">Content with staggered animation</p>
                <p data-aos="fade-up" data-aos-delay="400">More content</p>
            </div>
        </div>
    </div>
</div>
```

### 4. Animated Forms
```html
<!-- Form with floating labels and animations -->
<form class="needs-validation" novalidate>
    <div class="form-floating mb-3" data-aos="fade-right">
        <input type="email" class="form-control" id="email" placeholder="Email" required>
        <label for="email">
            <i class="bi bi-envelope me-2"></i>Email Address
        </label>
    </div>
    
    <div class="form-floating mb-3" data-aos="fade-left" data-aos-delay="100">
        <input type="password" class="form-control" id="password" placeholder="Password" required>
        <label for="password">
            <i class="bi bi-lock me-2"></i>Password
        </label>
    </div>
    
    <button type="submit" class="btn btn-primary btn-lg w-100 hover-lift" data-aos="zoom-in" data-aos-delay="200">
        Submit
    </button>
</form>
```

### 5. Animated Navigation
```html
<!-- Navbar with scroll effects and animated links -->
<nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top">
    <div class="container">
        <a class="navbar-brand hover-scale" href="#" data-aos="fade-right">
            <i class="bi bi-chat-dots-fill text-primary me-2"></i>
            Brand
        </a>
        
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="#" data-aos="fade-down" data-aos-delay="100">Home</a>
            <a class="nav-link" href="#" data-aos="fade-down" data-aos-delay="200">About</a>
            <a class="nav-link" href="#" data-aos="fade-down" data-aos-delay="300">Contact</a>
        </div>
    </div>
</nav>
```

## 🎯 **Sample Templates Created**

### 1. Bootstrap Layout (`layouts/bootstrap.blade.php`)
- **Loading screen** with spinner
- **Automatic alert handling** with animations
- **Scroll-to-top button** with fade effects
- **Performance monitoring** built-in
- **Error handling** and debugging

### 2. Animated Login Page (`samples/animated-login.blade.php`)
- **Gradient background** with floating shapes
- **Glass morphism card** design
- **Form validation** with shake animations
- **Social login buttons** with hover effects
- **Loading states** and transitions

### 3. Animated Dashboard (`samples/animated-dashboard.blade.php`)
- **Hero section** with parallax elements
- **Animated statistics** with counters
- **Feature cards** with staggered animations
- **Progress bars** that animate on scroll
- **Interactive elements** throughout

## 🚀 **Performance Optimizations**

### 1. Reduced Motion Support
```scss
@media (prefers-reduced-motion: reduce) {
    *,
    ::before,
    ::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```

### 2. Lazy Loading
```javascript
// Automatic lazy loading for images
const images = document.querySelectorAll('img[data-src]');
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            imageObserver.unobserve(img);
        }
    });
});
```

### 3. Efficient Animations
- **GPU acceleration** using `transform` and `opacity`
- **IntersectionObserver** for scroll-triggered animations
- **RequestAnimationFrame** for smooth animations
- **Debounced scroll events** for performance

## 🎨 **Custom Animation Examples**

### 1. Button Ripple Effect
```javascript
// Automatic ripple effect on all buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});
```

### 2. Scroll-triggered Navbar
```javascript
// Navbar changes appearance on scroll
const navbar = document.querySelector('.navbar');
window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
```

### 3. Counter Animation
```javascript
// Animate numbers counting up
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
```

## 🛠️ **Usage Instructions**

### 1. Build Assets
```bash
npm run build          # Production build
npm run dev           # Development build
npm run dev --watch   # Watch for changes
```

### 2. Using the Bootstrap Layout
```php
@extends('layouts.bootstrap')

@section('title', 'Page Title')
@section('description', 'Page description for SEO')

@push('styles')
<style>
    /* Custom page styles */
</style>
@endpush

@section('content')
    <!-- Your animated content here -->
@endsection

@push('scripts')
<script>
    // Custom page JavaScript
</script>
@endpush
```

### 3. Adding Custom Animations
```scss
// In your Sass file
@keyframes customAnimation {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}

.custom-animate {
    animation: customAnimation 0.6s ease-out;
}
```

## 📱 **Responsive Considerations**

### 1. Mobile Performance
- Animations are **automatically reduced** on mobile devices
- **Touch-friendly** button sizes (minimum 44px)
- **Reduced motion** support for accessibility

### 2. Breakpoint-specific Animations
```scss
// Different animations for different screen sizes
@media (max-width: 768px) {
    .hover-lift:hover {
        transform: none; // Disable hover effects on mobile
    }
}
```

## 🎯 **Best Practices**

### 1. Animation Performance
- ✅ Use `transform` and `opacity` for smooth animations
- ✅ Avoid animating `width`, `height`, `top`, `left`
- ✅ Use `will-change` sparingly and remove after animation
- ✅ Prefer CSS animations over JavaScript when possible

### 2. User Experience
- ✅ Keep animations **subtle and purposeful**
- ✅ Respect `prefers-reduced-motion` setting
- ✅ Don't animate everything at once
- ✅ Use consistent timing and easing

### 3. Accessibility
- ✅ Provide alternatives for motion-sensitive users
- ✅ Ensure animations don't interfere with screen readers
- ✅ Maintain focus management during animations
- ✅ Use appropriate ARIA labels

## 🚀 **Next Steps**

1. **Explore the sample templates** in `resources/views/samples/`
2. **Customize the animations** in `resources/sass/app.scss`
3. **Add more AOS effects** throughout your application
4. **Create custom animation components** for reusability
5. **Test performance** on various devices and browsers

## 🔧 **Troubleshooting**

### Common Issues:
1. **Animations not working**: Check if `npm run build` was executed
2. **AOS not initializing**: Ensure JavaScript is loaded after DOM
3. **Bootstrap components not working**: Verify Bootstrap JS is imported
4. **Sass compilation errors**: Check Bootstrap variable imports

### Debug Commands:
```bash
npm run build --verbose    # Detailed build output
php artisan route:list     # Check routes
npm list                   # Verify package installation
```

---

Your **Bootstrap 5 + Animations** setup is now complete! 🎉

The system provides:
- ✅ **Modern responsive design** with Bootstrap 5
- ✅ **Beautiful animations** with AOS and custom CSS
- ✅ **Performance optimizations** for smooth experience
- ✅ **Accessibility features** for all users
- ✅ **Sample templates** to get you started quickly 
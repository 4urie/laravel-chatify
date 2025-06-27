# Chatify - Laravel Messaging System

A modern, real-time messaging application built with Laravel 12, similar to Facebook Messenger. Features include user authentication, real-time messaging, message status tracking, and a beautiful responsive UI.

## 🚀 Features

- **User Authentication**: Registration and login system using Laravel Breeze
- **Real-time Messaging**: Send and receive messages instantly with AJAX polling
- **Message Status**: Track read/unread status and delivery confirmation
- **Modern UI**: Clean, responsive design with intuitive user experience
- **User Management**: Browse and search users to start conversations
- **Conversation History**: View and manage chat history with multiple users
- **Security**: CSRF protection, rate limiting, and secure authentication

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL/PostgreSQL/SQLite database
- Laravel 12

## 🛠️ Installation & Setup

### 1. Clone the Repository
```bash
git clone <your-repo-url>
cd chatify
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chatify
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Database Migrations and Seeders
```bash
# Run migrations
php artisan migrate

# Seed test users
php artisan db:seed
```

### 6. Build Assets
```bash
# Compile CSS and JavaScript
npm run build

# Or for development with hot reloading
npm run dev
```

### 7. Start the Application
```bash
# Start Laravel development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 👥 Test Accounts

The seeder creates the following test accounts (password: `password`):

- **john@example.com** / password
- **jane@example.com** / password  
- **mike@example.com** / password
- **sarah@example.com** / password
- **david@example.com** / password

## 🏗️ Project Structure

### Models
- **User**: Default Laravel user model with message relationships
- **Message**: Handles message data with sender/receiver relationships

### Controllers
- **MessageController**: Manages chat functionality (index, show, send, getNewMessages)
- **Auth Controllers**: Handle authentication (login, register, logout)

### Database Schema

#### Messages Table
```sql
CREATE TABLE messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    sender_id BIGINT NOT NULL,
    receiver_id BIGINT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX (sender_id, receiver_id),
    INDEX (receiver_id, is_read)
);
```

### Routes
```php
// Authentication routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Chat routes (authenticated)
Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
Route::get('/chat/{user}', [MessageController::class, 'show'])->name('chat.show');
Route::post('/chat/send', [MessageController::class, 'send'])->name('chat.send');
Route::get('/chat/{user}/messages', [MessageController::class, 'getNewMessages'])->name('chat.messages');
```

## 💻 Usage

### 1. Registration/Login
- Visit the application
- Register a new account or login with test credentials
- You'll be redirected to the chat interface

### 2. Starting a Conversation
- Select a user from the sidebar
- Type your message in the input field
- Press Enter or click Send

### 3. Real-time Updates
- Messages appear instantly without page refresh
- Message status shows "Delivered" or "Read"
- New messages are polled every 2 seconds

### 4. Navigation
- Switch between conversations by clicking users in sidebar
- Recent chats appear at the top with unread counts
- Return to user list anytime

## 🎨 Features Overview

### Authentication System
- Secure login/logout functionality
- User registration with validation
- Session management and CSRF protection
- Rate limiting on login attempts

### Messaging Features
- **Real-time messaging**: AJAX-based sending and receiving
- **Message status**: Track delivery and read status
- **Conversation history**: Persistent message storage
- **User presence**: See active conversations
- **Unread counts**: Visual indicators for new messages

### User Interface
- **Responsive design**: Works on desktop and mobile
- **Modern styling**: Clean, intuitive interface
- **Real-time updates**: No page refreshes needed
- **Message bubbles**: Distinct styling for sent/received messages
- **User avatars**: Initials-based avatar system

## 🔧 Customization

### Adding Features
1. **File uploads**: Extend Message model to support file attachments
2. **Group chats**: Add group functionality with multiple participants
3. **Message reactions**: Add emoji reactions to messages
4. **Typing indicators**: Show when users are typing
5. **Push notifications**: Real-time browser notifications

### Styling
- Edit `resources/views/layouts/chat.blade.php` for layout changes
- Modify CSS in the style section or create separate stylesheet
- Customize colors, fonts, and spacing as needed

### Performance Optimization
- Implement WebSockets (Laravel Echo + Pusher) for true real-time updates
- Add message pagination for large conversation histories
- Implement message caching for faster loading
- Add database indexing for better query performance

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter MessageTest
```

### Creating Test Data
```bash
# Create additional test users
php artisan tinker
>>> User::factory(10)->create()

# Create test messages
>>> Message::factory(50)->create()
```

## 🚀 Deployment

### Production Setup
1. Configure production environment variables
2. Set up proper web server (nginx/Apache)
3. Configure SSL certificates
4. Set up database with proper credentials
5. Configure caching and session storage
6. Set up queue workers for background jobs

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-secure-password

# Cache & Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🐛 Troubleshooting

### Common Issues

1. **Messages not sending**: Check CSRF token and ensure user is authenticated
2. **Real-time updates not working**: Verify AJAX polling is active and no JavaScript errors
3. **Database errors**: Ensure migrations are run and database credentials are correct
4. **CSS not loading**: Run `npm run build` and check for compile errors

### Getting Help

- Check Laravel documentation: https://laravel.com/docs
- Review error logs in `storage/logs/laravel.log`
- Enable debug mode in development: `APP_DEBUG=true`

---

**Chatify** - Built with ❤️ using Laravel 12 
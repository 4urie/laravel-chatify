# Dark Mode Implementation Guide

## Overview

This Laravel chat application now includes a fully functional dark mode toggle that stores user preferences in the database. The dark mode implementation uses Tailwind CSS's built-in dark mode support with a class-based strategy.

## Features

- **User-specific preferences**: Each user's dark mode preference is stored in the database
- **Persistent across sessions**: Dark mode preference is remembered when users log back in
- **Smooth transitions**: All elements transition smoothly between light and dark modes
- **Comprehensive styling**: All pages (chat, groups, login) support dark mode
- **Modern toggle UI**: Beautiful animated toggle button with sun/moon icons

## Database Schema

### Migration Added
```php
// Migration: add_dark_mode_to_users_table
Schema::table('users', function (Blueprint $table) {
    $table->boolean('dark_mode')->default(false)->after('preferred_language');
});
```

### User Model Updates
```php
// Added to fillable array
'dark_mode'

// Added to casts
'dark_mode' => 'boolean'
```

## Backend Implementation

### Controller: UserPreferencesController

**Routes Available:**
- `GET /preferences` - Get current user preferences
- `POST /preferences/dark-mode/toggle` - Toggle dark mode on/off
- `POST /preferences/dark-mode` - Set specific dark mode value
- `POST /preferences/language` - Update language preference

**Key Methods:**
```php
// Toggle dark mode
public function toggleDarkMode(Request $request): JsonResponse

// Update dark mode with specific value
public function updateDarkMode(Request $request): JsonResponse

// Get all preferences
public function getPreferences(): JsonResponse
```

## Frontend Implementation

### CSS Classes Structure

**Light Mode (default):**
```css
.bg-white .text-gray-900 .border-gray-200
```

**Dark Mode:**
```css
.dark:bg-gray-800 .dark:text-gray-100 .dark:border-gray-700
```

### Key CSS Features

1. **Smooth Transitions**: All elements have `transition-colors duration-300`
2. **Custom Scrollbars**: Dark mode scrollbars with appropriate colors
3. **Form Elements**: Proper contrast and focus states
4. **Hover Effects**: Adjusted hover effects for dark mode
5. **Custom Toggle Button**: Animated toggle with sun/moon icons

### JavaScript Implementation

**Toggle Functionality:**
```javascript
// Dark mode toggle in chat layout
document.getElementById('dark-mode-toggle').addEventListener('click', function() {
    // Toggle classes
    this.classList.toggle('active');
    document.documentElement.classList.toggle('dark');
    
    // Save to database via AJAX
    fetch('/preferences/dark-mode', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            dark_mode: document.documentElement.classList.contains('dark')
        })
    });
});
```

## Usage Instructions

### For Users

1. **Access Dark Mode Toggle**: 
   - Look for the toggle button in the top-right area of the chat interface
   - The button shows a sun icon (☀️) in light mode and moon icon (🌙) in dark mode

2. **Toggle Dark Mode**:
   - Click the toggle button to switch between light and dark modes
   - The change is instant and affects the entire interface
   - Your preference is automatically saved

3. **Persistent Preference**:
   - Your dark mode preference is remembered across sessions
   - When you log back in, your preferred mode will be active

### For Developers

#### Adding Dark Mode to New Components

When creating new UI components, follow this pattern:

```html
<!-- Background colors -->
<div class="bg-white dark:bg-gray-800">

<!-- Text colors -->
<p class="text-gray-900 dark:text-gray-100">

<!-- Border colors -->
<div class="border-gray-200 dark:border-gray-700">

<!-- Button states -->
<button class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-400">
```

#### Color Palette Used

**Light Mode:**
- Background: `bg-white`, `bg-gray-50`, `bg-gray-100`
- Text: `text-gray-900`, `text-gray-700`, `text-gray-600`
- Borders: `border-gray-200`, `border-gray-300`

**Dark Mode:**
- Background: `dark:bg-gray-800`, `dark:bg-gray-900`, `dark:bg-gray-700`
- Text: `dark:text-white`, `dark:text-gray-100`, `dark:text-gray-300`
- Borders: `dark:border-gray-700`, `dark:border-gray-600`

## API Endpoints

### Get User Preferences
```http
GET /preferences
Authorization: Bearer {token}

Response:
{
    "success": true,
    "preferences": {
        "dark_mode": true,
        "preferred_language": "en"
    }
}
```

### Toggle Dark Mode
```http
POST /preferences/dark-mode/toggle
Authorization: Bearer {token}

Response:
{
    "success": true,
    "dark_mode": true,
    "message": "Dark mode enabled"
}
```

### Update Dark Mode
```http
POST /preferences/dark-mode
Content-Type: application/json
Authorization: Bearer {token}

{
    "dark_mode": true
}

Response:
{
    "success": true,
    "dark_mode": true,
    "message": "Dark mode enabled"
}
```

## File Structure

```
app/
├── Http/Controllers/
│   └── UserPreferencesController.php
├── Models/
│   └── User.php (updated)
database/migrations/
└── 2025_06_21_050736_add_dark_mode_to_users_table.php
resources/
├── css/
│   └── app.css (dark mode styles)
├── js/
│   └── app.js
└── views/
    ├── layouts/
    │   └── chat.blade.php (updated with toggle)
    ├── chat/
    │   ├── index.blade.php (dark mode support)
    │   └── show.blade.php (dark mode support)
    └── groups/
        └── show.blade.php (dark mode support)
routes/
└── web.php (preferences routes)
```

## Browser Support

- **Modern Browsers**: Full support (Chrome 76+, Firefox 67+, Safari 12.1+)
- **CSS Custom Properties**: Used for smooth transitions
- **Flexbox/Grid**: Used for toggle button layout
- **Fetch API**: Used for AJAX requests

## Performance Considerations

1. **CSS Transitions**: Limited to `background-color`, `border-color`, and `color` only
2. **Reduced Motion**: Respects `prefers-reduced-motion` media query
3. **Database Queries**: Single update query per preference change
4. **JavaScript**: Minimal overhead, event-driven

## Troubleshooting

### Common Issues

1. **Toggle not working**: Check browser console for JavaScript errors
2. **Styles not applying**: Ensure Tailwind CSS is properly compiled
3. **Preference not saving**: Verify CSRF token and authentication
4. **Inconsistent colors**: Check if all components use the dark: prefix

### Debug Commands

```bash
# Rebuild CSS with dark mode classes
npm run build

# Check route registration
php artisan route:list --path=preferences

# Clear cache if needed
php artisan config:clear
php artisan view:clear
```

## Future Enhancements

Potential improvements for the dark mode feature:

1. **System Preference Detection**: Auto-detect OS dark mode preference
2. **Scheduled Mode**: Automatic switching based on time of day
3. **Theme Customization**: Multiple color themes beyond light/dark
4. **Accessibility**: Enhanced high contrast mode
5. **Animation Options**: More transition effects and customization

---

**Last Updated**: June 21, 2025
**Version**: 1.0.0 
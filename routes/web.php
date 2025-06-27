<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserPreferencesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('chat.index') : redirect()->route('login');
});

// Sample Bootstrap Animation Pages
Route::get('/samples/login', function () {
    return view('samples.animated-login');
})->name('samples.login');

Route::get('/samples/dashboard', function () {
    return view('samples.animated-dashboard');
})->name('samples.dashboard');

// Authentication routes will be added by Laravel Breeze
require __DIR__.'/auth.php';

// Chat routes (protected by authentication)
Route::middleware('auth')->group(function () {
    // Chat index - list all users
    Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
    
    // Show conversation with specific user
    Route::get('/chat/{user}', [MessageController::class, 'show'])->name('chat.show');
    
    // Send message
    Route::post('/chat/send', [MessageController::class, 'send'])->name('chat.send');
    
    // Get new messages (AJAX endpoint)
    Route::get('/chat/{user}/messages', [MessageController::class, 'getNewMessages'])->name('chat.messages');
    
        // Translation endpoints
    Route::post('/chat/message/{message}/translate', [MessageController::class, 'translateMessage'])->name('chat.translate');
    Route::post('/chat/update-language', [MessageController::class, 'updatePreferredLanguage'])->name('chat.update-language');
    Route::get('/chat/supported-languages', [MessageController::class, 'getSupportedLanguages'])->name('chat.supported-languages');
    
    // User Preferences routes
    Route::get('/preferences', [UserPreferencesController::class, 'getPreferences'])->name('preferences.get');
    Route::post('/preferences/dark-mode/toggle', [UserPreferencesController::class, 'toggleDarkMode'])->name('preferences.dark-mode.toggle');
    Route::post('/preferences/dark-mode', [UserPreferencesController::class, 'updateDarkMode'])->name('preferences.dark-mode.update');
    Route::post('/preferences/language', [UserPreferencesController::class, 'updateLanguage'])->name('preferences.language.update');
    
    // Group routes
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
    
    // Group messaging
    Route::post('/groups/{group}/messages', [GroupController::class, 'sendMessage'])->name('groups.send-message');
    Route::get('/groups/{group}/messages', [GroupController::class, 'getNewMessages'])->name('groups.get-messages');
    
    // Group membership
    Route::post('/groups/{group}/members', [GroupController::class, 'addMember'])->name('groups.add-member');
    Route::delete('/groups/{group}/members/{member}', [GroupController::class, 'removeMember'])->name('groups.remove-member');
    Route::post('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    
    // Group message translation
    Route::post('/groups/messages/{message}/translate', [GroupController::class, 'translateMessage'])->name('groups.translate-message');
});

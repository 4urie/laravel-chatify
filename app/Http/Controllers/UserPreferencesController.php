<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserPreferencesController extends Controller
{
    /**
     * Toggle dark mode preference for the authenticated user.
     */
    public function toggleDarkMode(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        // Toggle the dark mode preference
        $user->dark_mode = !$user->dark_mode;
        $user->save();
        
        return response()->json([
            'success' => true,
            'dark_mode' => $user->dark_mode,
            'message' => $user->dark_mode ? 'Dark mode enabled' : 'Light mode enabled'
        ]);
    }
    
    /**
     * Update dark mode preference for the authenticated user.
     */
    public function updateDarkMode(Request $request): JsonResponse
    {
        $request->validate([
            'dark_mode' => 'required|boolean'
        ]);
        
        $user = Auth::user();
        $user->dark_mode = $request->dark_mode;
        $user->save();
        
        return response()->json([
            'success' => true,
            'dark_mode' => $user->dark_mode,
            'message' => $user->dark_mode ? 'Dark mode enabled' : 'Light mode enabled'
        ]);
    }
    
    /**
     * Update language preference for the authenticated user.
     */
    public function updateLanguage(Request $request): JsonResponse
    {
        $request->validate([
            'preferred_language' => 'required|string|max:10'
        ]);
        
        $user = Auth::user();
        $user->preferred_language = $request->preferred_language;
        $user->save();
        
        return response()->json([
            'success' => true,
            'preferred_language' => $user->preferred_language,
            'message' => 'Language preference updated successfully'
        ]);
    }
    
    /**
     * Get current user preferences.
     */
    public function getPreferences(): JsonResponse
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'preferences' => [
                'dark_mode' => $user->dark_mode,
                'preferred_language' => $user->preferred_language,
            ]
        ]);
    }
}

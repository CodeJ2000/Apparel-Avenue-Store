<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    // Method to handle user logout     
    public function logout(Request $request)
    {
        Auth::logout();  // Logout the currently authenticated user

        $request->session()->invalidate(); // Invalidate the user's session

        $request->session()->regenerateToken(); // Regenerate the CSRF token for security

        return redirect()->route('login.form'); // Redirect to the 'home' route (you can replace 'home' with the desired route)
    }
}
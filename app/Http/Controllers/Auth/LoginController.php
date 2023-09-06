<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// The LoginController class extends the base Controller class
class LoginController extends Controller
{
    // Method to display the login view
    public function index()
    {
        return view('auth.login'); // Return the 'auth.login' view
    }

     // Method to authenticate user login
    public function authenticate(Request $request)
    {
        // Validate the user's input credentials
        $credentials = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

         // If validation fails, return validation error messages
        if($credentials->fails()){
        return response()->json(['errors' => $credentials->errors()], 422);
        }

        // Attempt to authenticate the user with provided credentials
        if((Auth::attempt($credentials->validated()))){
            $request->session()->regenerate(); // Regenerate session to prevent session fixation
            $user = Auth::user(); // Get the authenticated user

            // Check if the user has the 'admin' role
            if($user->hasRole('admin')){
                return response()->json(['redirect' => route('admin.index')]); // Redirect to admin dashboard

            } else {
                return response()->json(['redirect' => route('home')]); // Redirect to welcome page
            }
        } else {
            return response()->json(['error' => 'The provided credentials do not match our records.'], 401);
        }
        
    }
}
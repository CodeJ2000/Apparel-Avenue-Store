<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if($credentials->fails()){
        return response()->json(['errors' => $credentials->errors()], 422);
        }

        if((Auth::attempt($credentials->validated()))){
            $request->session()->regenerate();
            return response()->json(['redirect' => route('home')]);
        } 
        if(auth()->user()->isAdmin()){
            
        }
        return response()->json(['error' => 'The provided credentials do not match our records.']);
        
    }
}
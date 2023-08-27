<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\View\Components\Alert;

class SignupController extends Controller
{
    
    public function index()
    {
        //render the signup form
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        try {

            //Validate the request data
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed'
            ]);
            
            //check if fails the validation return the errors in json into the signup form
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422); 
            }
            
            //if not fails  the credentials will be save to the database
            $user =   User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            $user->assignRole('customer');
            
            $user->cart()->save(new Cart);
            //return a success message with sweat alert
            return response()->json(['message' => 'Account created successfuly!']);
            
        } catch (QueryException $e) {
            // Handle database query exceptions
            return response()->json(['message' => 'Failed to create user'], 500);
        } catch (\Exception $e) {
            // Handle other exception
            return response()->json(['message' => 'An error occurred'], 500);
        }
                
    }

    
}
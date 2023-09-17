<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\View\Components\Alert;

class SignupController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        //render the signup form
        return view('auth.signup');
    }

    //Create the customer user
    public function signup(Request $request)
    {
        return $this->userService->createUser($request);
    }

    
}
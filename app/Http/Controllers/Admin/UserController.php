<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
 
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('admin.pages.users'); //render the user page
    }

    public function displayUsers()
    {
        return $this->userService->UserInDataTable(); //Display the user data in data table
    }

    public function add(Request $request)
    {
        return $this->userService->createUser($request); //Adding new user
    }

    public function edit(User $user)
    {
        return $this->userService->editUser($user); //edit the existing user   
    }

    public function update(User $user, UserRequest $request)
    {
        $validated = $request->validated();
        return $this->userService->updateUser($user, $validated);
    }

    public function destroy(User $user)
    {
        return $this->userService->destroyUser($user); //Delete the selected user
    }
}
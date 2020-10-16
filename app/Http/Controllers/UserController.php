<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;


use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        // return view('users.show', compact('user'));

        return UserResource::make($user);
    }
}

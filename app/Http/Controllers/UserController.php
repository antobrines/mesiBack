<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserByRequest(Request $request)
    {
        return $request->user();
    }

    public function create(Request $request)
    {
        //dd($request);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now()
        ]);

        return $user;
    }
}

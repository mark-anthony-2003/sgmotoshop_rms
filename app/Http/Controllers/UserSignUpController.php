<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSignUpController extends Controller
{
    public function showCustomerSignUpForm()
    {
        $userType = 'customer';
        return view('pages.auth.customer.sign_up', compact('userType'));
    }

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6'
        ]);

        User::create([
            'first_name'            => $validated['first_name'],
            'last_name'             => $validated['last_name'],
            'email'                 => $validated['email'],
            'password'              => Hash::make($validated['password']),
            'user_status'           => 'active',
            'user_type'             => 'customer',
            'email_verified_at'     => now(),
            'remember_token'        => Str::random(10)
        ]);

        return redirect()->route('sign-in.customer')->with('success', 'Account created successfully');
    }
}

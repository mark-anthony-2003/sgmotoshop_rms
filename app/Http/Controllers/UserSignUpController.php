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
            'user_first_name'   => 'required|string|max:100',
            'user_last_name'    => 'required|string|max:100',
            'user_email'        => 'required|email|unique:users,user_email',
            'user_password'     => 'required|string|min:6'
        ]);

        User::create([
            'user_first_name'       => $validated['user_first_name'],
            'user_last_name'        => $validated['user_last_name'],
            'user_email'            => $validated['user_email'],
            'user_password'         => Hash::make($validated['user_password']),
            'user_account_status'   => 'active',
            'user_type'             => 'customer',
            'email_verified_at'     => now(),
            'remember_token'        => Str::random(10),
        ]);

        return redirect()->route('sign-in.customer')->with('success', 'Account created successfully');
    }
}

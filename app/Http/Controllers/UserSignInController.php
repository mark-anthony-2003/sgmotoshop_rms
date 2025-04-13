<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSignInController extends Controller
{
    public function showAdminSignInForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin-panel');
        }
        $userType = 'admin';
        return view('pages.auth.admin.index', compact('userType'));
    }

    public function showEmployeeSignInAs()
    {
        return view('pages.auth.employee.index');
    }
    public function showEmployeeSignInAsManager()
    {
        if (Auth::check()) {
            return redirect()->route('employee-panel');
        }
        $employeeType = 'manager';
        return view('pages.auth.employee.manager.index', compact('employeeType'));
    }
    public function showEmployeeSignInAsLaborer()
    {
        if (Auth::check()) {
            return redirect()->route('employee-panel');
        }
        $employeeType = 'laborer';
        return view('pages.auth.employee.laborer.index', compact('employeeType'));
    }

    public function showCustomerSignInForm()
    {
        if (Auth::check()) {
            return redirect()->route('customer-panel');
        }
        $userType = 'customer';
        return view('pages.auth.customer.index', compact('userType'));
    }

    // Sign in for Admin|Customer
    public function signIn(Request $request)
    {
        $request->validate([
            'user_email'    => 'required|email',
            'user_password' => 'required',
            'user_type'     => 'required|in:admin,customer'
        ]);

        $user = User::where('user_email', $request->user_email)
                    ->where('user_type', $request->user_type)
                    ->first();
        
        if ($user && Hash::check($request->user_password, $user->user_password)) {
            Auth::login($user);

            if ($user->user_type === 'admin') {
                return redirect()->route('admin-panel');
            }
            return redirect()->route('customer-panel');
        }
        return back()->withErrors([
            'email' => 'Invalid email or password.'
        ])->withInput();
    }

    // Sign in for Employee:Manager|Laborer
    public function signInEmployee(Request $request)
    {
        $credentials = $request->validate([
            'user_email'        => 'required|email',
            'user_password'     => 'required',
            'employee_type'     => 'required|in:manager,laborer'
        ]);

        $user = User::where('user_email', $credentials['user_email'])->first();

        if ($user && Hash::check($credentials['user_password'], $user->user_password)) {
            $employee = Employee::where('employee_user_id', $user->user_id)
                                ->whereHas('positionType', function($query) use ($credentials) {
                                    $query->where('position_type_name', $credentials['employee_type']);
                                })
                                ->first();

            if ($employee) {
                Auth::login($user);

                $positionType = $employee->positionType->position_type_name;
                if ($positionType === 'manager') {
                    return redirect()->route('manager.panel');
                } elseif ($positionType === 'laborer') {
                    return redirect()->route('laborer-panel');
                }
            }
            Auth::logout();
            return redirect()->back()->withErrors([
                'employee_type' => 'Unauthorized access for this employee type.'
            ]);
        }
        return redirect()->back()->withErrors([
            'user_email' => 'Invalid credentials'
        ]);
    }
}

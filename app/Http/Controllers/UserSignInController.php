<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Sign in for Admin | Customer
    public function signIn(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
            'user_type' => 'required|in:admin,customer',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])
                    ->where('user_type', $request->user_type)
                    ->first();

        if ($user && Auth::attempt($credentials)) {
            if ($user->user_type === 'admin') {
                return redirect()->route('admin.panel');
            }
            return redirect()->route('customer.panel');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.'
        ])->withInput();
    }

    // Sign in for Employee: Manager | Laborer
    public function signInEmployee(Request $request)
    {
        $request->validate([
            'email'         => 'required|email',
            'password'      => 'required',
            'employee_type' => 'required|in:manager,laborer',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->user_type !== 'employee') {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized: not an employee.']);
            }

            $employee = $user->employee;

            if (!$employee || !$employee->positionType) {
                Auth::logout();
                return back()->withErrors(['email' => 'Employee role not found.']);
            }

            $actualPosition = strtolower($employee->positionType->position_name);
            $expectedPosition = strtolower($request->employee_type);

            if ($actualPosition !== $expectedPosition) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You are not authorized to sign in as a ' . $expectedPosition . '.'
                ]);
            }

            return $actualPosition === 'manager'
                ? redirect()->route('manager.panel')
                : redirect()->route('laborer.panel');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.'
        ])->withInput();
    }
}

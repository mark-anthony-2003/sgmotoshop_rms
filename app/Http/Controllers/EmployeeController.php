<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Employee;
use App\Models\PositionType;
use App\Models\SalaryType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function employeesTable()
    {
        $employees = Employee::with(['user', 'positionType'])->get();
        return view('admin.user_management.employees.index', compact('employees'));
    }

    public function employeeForm()
    {
        $positions = PositionType::all();
        $salaries = SalaryType::all();

        return view('admin.user_management.employees.create', compact('positions', 'salaries'));
    }

    public function employeeCreate(Request $request)
    {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:6',
            'date_of_birth'     => 'required|date',
            'contact_number'    => 'required|string|max:20',
            'profile_image'     => 'nullable|image|mimes:png,jpg|max:5000',
            'country'           => 'required|string|max:100',
            'province'          => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'barangay'          => 'required|string|max:100',
            'address_type'      => 'required|in:home,work',
            'position_type_id'  => 'required|exists:position_types,position_type_id',
            'salary_type_id'    => 'required|exists:salary_types,salary_type_id'
        ]);

        $employeeImagePath = null;
        if ($request->hasFile('profile_image')) {
            $employeeImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'date_of_birth'     => $validated['date_of_birth'],
            'contact_number'    => $validated['contact_number'],
            'profile_image'     => $employeeImagePath,
            'user_status'       => 'active',
            'user_type'         => 'employee',
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10)
        ]);

        Address::create([
            'user_id'       => $user->user_id,
            'country'       => $validated['country'],
            'province'      => $validated['province'],
            'city'          => $validated['city'],
            'barangay'      => $validated['barangay'],
            'address_type'  => $validated['address_type']
        ]);

        Employee::create([
            'user_id'          => $user->user_id,
            'salary_type_id'   => $validated['salary_type_id'],
            'position_type_id' => $validated['position_type_id'],
            'date_hired'       => now(),
        ]);

        return redirect()->route('employees.table')->with('success', 'Account created successfully');
    }
}

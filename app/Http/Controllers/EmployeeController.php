<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Employee;
use App\Models\Laborer;
use App\Models\Manager;
use App\Models\PerDaySalary;
use App\Models\PositionType;
use App\Models\RegularSalary;
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
        $employee = null;
        $positions = PositionType::all();
        $salaries = SalaryType::all();

        return view('admin.user_management.employees.create', compact('employee','positions', 'salaries'));
    }

    public function employeeCreate(Request $request)
    {
        $validated = $request->validate([
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'required|string|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6',
            'date_of_birth'         => 'required|date',
            'contact_number'        => 'required|string|max:20',
            'profile_image'         => 'nullable|image|mimes:png,jpg|max:5000',
            'user_status'           => 'required|in:active,inactive,suspended',
            'country'               => 'required|string|max:100',
            'province'              => 'required|string|max:100',
            'city'                  => 'required|string|max:100',
            'barangay'              => 'required|string|max:100',
            'address_type'          => 'required|in:home,work',
            'position_type_id'      => 'required|exists:position_types,position_type_id',
            'salary_type_id'        => 'required|exists:salary_types,salary_type_id',
            'work'                  => 'nullable|string|in:Mechanic,Auto Electrician,Transmission Specialist,Welder,Tire Technician,Oil Change Specialist',
            'employment_status'     => 'nullable|string|in:active,on_leave,resigned',
            'monthly_rate'          => 'nullable|integer',
            'daily_rate'            => 'nullable|integer',
            'days_worked'           => 'nullable|integer'
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
            'user_status'       => $validated['user_status'],
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

        $employee = Employee::create([
            'user_id'           => $user->user_id,
            'salary_type_id'    => $validated['salary_type_id'],
            'position_type_id'  => $validated['position_type_id'],
            'employment_status' => $validated['employment_status'],
            'date_hired'        => now()
        ]);

        if ($validated['position_type_id'] == 1) {
            Manager::create([
                'position_type_id'   => $validated['position_type_id'],
                'employee_id'        => $employee->employee_id,
                'area_checker'       => true,
                'inventory_recorder' => true,
                'payroll_assistance' => true
            ]);
        } elseif ($validated['position_type_id'] == 2) {
            Laborer::create([
                'position_type_id'   => $validated['position_type_id'],
                'employee_id'        => $employee->employee_id,
                'work'               => $validated['work']
            ]);
        }

        if ($validated['salary_type_id'] == 1) {
            RegularSalary::create([
                'salary_type_id'    => $validated['salary_type_id'],
                'employee_id'       => $employee->employee_id,
                'monthly_rate'      => $validated['monthly_rate']
            ]);
        } elseif ($validated['salary_type_id'] == 2) {
            PerDaySalary::create([
                'salary_type_id'    => $validated['salary_type_id'],
                'employee_id'       => $employee->employee_id,
                'daily_rate'        => $validated['daily_rate'],
                'days_worked'       => $validated['days_worked']
            ]);
        }

        return redirect()->route('employees.table')->with('success', 'Account created successfully');
    }

    public function employeeEdit(Employee $employee)
    {
        $employee->load('user');
        $positions = PositionType::all();
        $salaries = SalaryType::all();

        return view('admin.user_management.employees.create', compact('employee', 'positions', 'salaries'));
    }

    public function employeeUpdate(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'email'             => 'required|email|unique:users,email,' . $employee->user->user_id . ',user_id',
            'password'          => 'nullable|string|min:6',
            'date_of_birth'     => 'required|date',
            'contact_number'    => 'required|string|max:20',
            'profile_image'     => 'nullable|image|mimes:png,jpg|max:5000',
            'user_status'       => 'required|in:active,inactive,suspended',
            'country'           => 'required|string|max:100',
            'province'          => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'barangay'          => 'required|string|max:100',
            'address_type'      => 'required|in:home,work',
            'position_type_id'  => 'required|exists:position_types,position_type_id',
            'salary_type_id'    => 'required|exists:salary_types,salary_type_id',
            'work'              => 'nullable|string|in:Mechanic,Auto Electrician,Transmission Specialist,Welder,Tire Technician,Oil Change Specialist',
            'employment_status' => 'nullable|string|in:active,on_leave,resigned',
            'monthly_rate'          => 'nullable|integer',
            'daily_rate'            => 'nullable|integer',
            'days_worked'           => 'nullable|integer'
        ]);

        $employeeImagePath = $employee->user->profile_image;
        if ($request->hasFile('profile_image')) {
            $employeeImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $employee->user->update([
            'first_name'     => $validated['first_name'],
            'last_name'      => $validated['last_name'],
            'email'          => $validated['email'],
            'date_of_birth'  => $validated['date_of_birth'],
            'contact_number' => $validated['contact_number'],
            'profile_image'  => $employeeImagePath,
            'user_status'    => $validated['user_status'],
            'password'       => $validated['password'] ? Hash::make($validated['password']) : $employee->user->password,
        ]);

        $employee->user->addresses()->updateOrCreate(
            ['user_id' => $employee->user->user_id],
            [
                'country'       => $validated['country'],
                'province'      => $validated['province'],
                'city'          => $validated['city'],
                'barangay'      => $validated['barangay'],
                'address_type'  => $validated['address_type'],
            ]
        );

        $employee->update([
            'salary_type_id'    => $validated['salary_type_id'],
            'position_type_id'  => $validated['position_type_id'],
            'employment_status' => $validated['employment_status']
        ]);

        if ($validated['position_type_id'] == 1) {
            $employee->laborer()->delete();

            $employee->manager()->updateOrCreate(
                ['employee_id' => $employee->employee_id],
                [
                    'position_type_id'   => 1,
                    'area_checker'       => true,
                    'inventory_recorder' => true,
                    'payroll_assistance' => true,
                ]
            );
        } elseif ($validated['position_type_id'] == 2) {
            $employee->manager()->delete();

            $employee->laborer()->updateOrCreate(
                ['employee_id' => $employee->employee_id],
                [
                    'position_type_id'   => 2,
                    'work'               => $validated['work']
                ]
            );
        }

        return redirect()->route('employees.table')->with('success', 'Employee updated successfully');
    }

}

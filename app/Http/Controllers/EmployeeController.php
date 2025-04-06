<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employeesTable()
    {
        $employees = Employee::with(['user', 'positionType'])->get();
        return view('admin.user_management.employees.index', compact('employees'));
    }
}

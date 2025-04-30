<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customersTable()
    {
        $customers = User::where('user_type', 'customer')->get();
        return view('admin.user_management.customers.index', compact('customers'));
    }

    public function customerEdit(User $customer)
    {
        return view('admin.user_management.customers.create', compact('customer'));
    }
}

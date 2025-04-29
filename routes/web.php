<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LaborerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserCustomerController;
use App\Http\Controllers\UserSignInController;
use App\Http\Controllers\UserSignUpController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return view('pages.index');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function() {
    Route::get('/sign-in', function() {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'admin') {
                return redirect()->route('admin-panel');
            } elseif ($user->user_type === 'employee') {
                $employee = $user->employees;
                if ($employee->positionType->position_type_name === 'manager') {
                    return redirect()->route('manager.panel');
                } elseif ($employee->positionType->position_type_name === 'laborer') {
                    return redirect()->route('laborer-panel');
                }
            } elseif ($user->user_type === 'customer') {
                return redirect()->route('customer-panel');
            }
        }
        return view('pages.auth.index');
    })->name('sign-in');

    // Sign in as Admin
    Route::get('/sign-in/admin', [UserSignInController::class, 'showAdminSignInForm'])->name('sign-in.admin');
    Route::post('/sign-in/admin', [UserSignInController::class, 'signIn'])->name('sign-in.admin.submit');
    // Sign in as Employee
    Route::get('/sign-in/as', [UserSignInController::class, 'showEmployeeSignInAs'])->name('sign-in.employee-as');
    Route::get('/sign-in/as/manager', [UserSignInController::class, 'showEmployeeSignInAsManager'])->name('sign-in.employee-as-manager');
    Route::post('/sign-in/as/manager', [UserSignInController::class, 'signInEmployee'])->name('sign-in.manager.submit');
    Route::get('/sign-in/as/laborer', [UserSignInController::class, 'showEmployeeSignInAsLaborer'])->name('sign-in.employee-as-laborer');
    Route::post('/sign-in/as/laborer', [UserSignInController::class, 'signInEmployee'])->name('sign-in.laborer.submit');
    // Sign in as Customer
    Route::get('/sign-in/customer', [UserSignInController::class, 'showCustomerSignInForm'])->name('sign-in.customer');
    Route::post('/sign-in/customer', [UserSignInController::class, 'signIn'])->name('sign-in.customer.submit');
    // Sign up as Customer
    Route::get('/sign-up/customer', [UserSignUpController::class, 'showCustomerSignUpForm'])->name('sign-up.customer');
    Route::post('/sign-up/customer', [UserSignUpController::class, 'signUp'])->name('sign-up.customer.submit');

});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/admin/dashboard', function() {
        if (Auth::user()->user_type === 'admin') {
            return view('includes.admin.index');
        }
        return abort(403);
    })->name('admin-panel');

    // Items -> Product Management
    Route::prefix('admin/items')->group(function() {
        Route::get('/', [ItemController::class, 'itemsTable'])->name('items.table');
        Route::get('/create', [ItemController::class, 'itemForm'])->name('item.create.form');
        Route::get('/{item}', [ItemController::class, 'itemDetail'])->name('item.show');
        Route::post('/store', [ItemController::class, 'itemCreate'])->name('item.store');
        Route::get('/{item}/edit', [ItemController::class, 'itemEdit'])->name('item.edit');
        Route::post('/{item}/update', [ItemController::class, 'itemUpdate'])->name('item.update');
        Route::post('/{item}/delete', [ItemController::class, 'itemDelete'])->name('item.delete');
    });
    // Services -> Service Preparation
    Route::prefix('/admin/services')->group(function() {
        Route::get('/', [ServiceTypeController::class, 'servicesTable'])->name('serviceTypes.table');
        Route::get('/create', [ServiceTypeController::class, 'serviceTypeForm'])->name('serviceType.create.form');
        Route::get('/{serviceType}', [ServiceTypeController::class, 'serviceTypeDetail'])->name('serviceType.show');
        Route::post('/store', [ServiceTypeController::class, 'serviceTypeCreate'])->name('serviceType.store');
        Route::get('/{serviceType}/edit', [ServiceTypeController::class, 'serviceTypeEdit'])->name('serviceType.edit');
        Route::post('/{serviceType}/update', [ServiceTypeController::class, 'serviceTypeUpdate'])->name('serviceType.update');
        Route::post('/{serviceType}', [ServiceTypeController::class, 'serviceTypeDelete'])->name('serviceType.delete');
    });
    Route::prefix('/admin/parts')->group(function() {
        Route::get('/', [PartController::class, 'partsTable'])->name('parts.table');
        Route::get('/create', [PartController::class, 'partForm'])->name('part.create.form');
        Route::post('/store', [PartController::class, 'partCreate'])->name('part.store');
        Route::get('/{part}/edit', [PartController::class, 'partEdit'])->name('part.edit');
        Route::post('/{part}/update', [PartController::class, 'partUpdate'])->name('part.update');
        Route::post('/{part}', [PartController::class, 'partDelete'])->name('part.delete');
    });

    // Employee -> User Management
    Route::prefix('/admin/employees')->group(function() {
        Route::get('/', [EmployeeController::class, 'employeesTable'])->name('employees.table');
        Route::get('/create', [EmployeeController::class, 'employeeForm'])->name('employee.create.form');
        Route::post('/store', [EmployeeController::class, 'employeeCreate'])->name('employee.create');
    });
    // Customer -> User Management
    Route::prefix('/admin/customers')->group(function() {
        Route::get('/', [CustomerController::class, 'customersTable'])->name('customers.table');
    });
});

// Employee Routes
Route::middleware(['auth', 'employee'])->group(function() {
    Route::get('/laborer/home', function() {
        return view('includes.employee.laborer.index');
    })->name('laborer-panel');

    // Manager Panel
    Route::get('/manager/panel', [ManagerController::class, 'managerPanel'])->name('manager.panel');
    Route::post('/manager/approve/{serviceDetailId}', [ManagerController::class, 'approveReservation'])->name('manager.approve');
    Route::post('/manager/reject/{serviceDetailId}', [ManagerController::class, 'rejectReservation'])->name('manager.reject');
    Route::post('/laborer/assign/{serviceDetailId}', [LaborerController::class, 'assignLaborer'])->name('laborer.assign');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->group(function() {
    Route::get('/customer/home', function() {
        if (Auth::user()->user_type === 'customer') {
            return view('includes.customer.index');
        }
        return abort(403);
    })->name('customer-panel');

    // Customer Profile
    Route::prefix('/customer/profile')->group(function() {
        Route::get('/{customerId}', [UserCustomerController::class, 'customerProfile'])->name('customer-profile');
        Route::post('/{customerId}', [UserCustomerController::class, 'updateCustomerProfile'])->name('customer.update');
    });

    // Order Items
    Route::prefix('/customer/items')->group(function() {
        Route::get('/', [OrderItemController::class, 'itemsList'])->name('items');
        Route::get('/{item}', [OrderItemController::class, 'itemOrderCard'])->name('item-order');
        Route::post('/{item}', [OrderItemController::class, 'itemAddToCart'])->name('item-addToCart');
        
        // Order Items Summary
        Route::post('/summary', [OrderItemController::class, 'itemsOrderCheckOut'])->name('items.checkout');
        Route::get('/summary', [OrderItemController::class, 'itemOrderSummary'])->name('items.summary');
    });

    // Reservation
    Route::prefix('/customer/reservation')->group(function() {
        Route::get('/', [ReservationController::class, 'reservationForm'])->name('reservation-form');
        Route::post('/', [ReservationController::class, 'makeReservation'])->name('reservation.submit');
    });
});

// Temp force logout
Route::get('/force-logout', function() {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/home');
});

// Universal Sign out (for all authenticated users)
Route::middleware(['auth'])->post('/sign-out', function() {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('home');
})->name('sign-out');

// Address API Routes
Route::prefix('address')->group(function() {
    Route::get('/countries', [AddressController::class, 'getCountries']);
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/cities/{provinceCode}', [AddressController::class, 'getStates']);
    Route::get('/barangays/{stateCode}', [AddressController::class, 'getBarangays']);
});
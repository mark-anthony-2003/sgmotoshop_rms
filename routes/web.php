<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserSignInController;
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
                return redirect()->route('employee-panel');
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
    Route::post('/sign-in/manager', [UserSignInController::class, 'signInEmployee'])->name('sign-in.manager.submit');
    Route::get('/sign-in/as/laborer', [UserSignInController::class, 'showEmployeeSignInAsLaborer'])->name('sign-in.employee-as-laborer');
    // Sign in as Customer
    Route::get('/sign-in/customer', [UserSignInController::class, 'showCustomerSignInForm'])->name('sign-in.customer');
    Route::post('/sign-in/customer', [UserSignInController::class, 'signIn'])->name('sign-in.customer.submit');

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
        Route::get('/', [ItemController::class, 'itemsTable'])->name('items-table');
        Route::post('/{item}', [ItemController::class, 'itemDelete'])->name('item-delete');
    });
    // Services -> Service Preparation
    Route::prefix('/admin/services')->group(function() {
        Route::get('/', [ServiceTypeController::class, 'servicesTable'])->name('serviceTypes-table');
        Route::post('/{serviceType}', [ServiceTypeController::class, 'serviceTypeDelete'])->name('serviceType-delete');
    });

    // Customer -> User Management
    Route::prefix('/admin/customers')->group(function() {
        Route::get('/', [CustomerController::class, 'customersTable'])->name('customers-table');
    });
    Route::prefix('/admin/employees')->group(function() {
        Route::get('/', [EmployeeController::class, 'employeesTable'])->name('employees-table');
    });
});

// Employee Routes
Route::middleware(['auth', 'employee'])->group(function() {
    Route::get('/manager/home', function() {
        return view('includes.employee.manager.index');
    })->name('manager-panel');

    Route::get('/laborer/home', function() {
        return view('includes.employee.laborer.index');
    })->name('laborer-panel');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->group(function() {
    Route::get('/customer/home', function() {
        if (Auth::user()->user_type === 'customer') {
            return view('includes.customer.index');
        }
        return abort(403);
    })->name('customer-panel');
});

// Temp force logout
Route::get('/force-logout', function() {
    Auth::logout();
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
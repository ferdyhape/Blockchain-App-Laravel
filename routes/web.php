<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CompanyManagementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Shareholder\DashboardController as ShareholderDashboardController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');

    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.process');
    Route::post('/register/owner', [AuthController::class, 'postRegisterOwner'])->name('register-owner.process');
    Route::post('/register/shareholder', [AuthController::class, 'postRegisterShareholder'])->name('register-shareholder.process');
    Route::get('/test-confirmation', function () {
        return view('auth.credentials.on_confirmation');
    })->name('test-confirmation');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::prefix('admin')->name('admin.')->middleware('role:Admin')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
            Route::get('test-post', [AdminDashboardController::class, 'testPost'])->name('test-post');
            Route::resource('user-management', UserManagementController::class)->names('user-management');
            Route::resource('company-management', CompanyManagementController::class)->names('company-management');
        });

        Route::prefix('shareholder')->name('shareholder.')->middleware('role:Admin,Shareholder')->group(function () {
            Route::get('/', [ShareholderDashboardController::class, 'index'])->name('index');
        });

        Route::prefix('owner')->name('owner.')->middleware('role:Admin,Owner')->group(function () {
            Route::get('/', [OwnerDashboardController::class, 'index'])->name('index');
        });
    });
});

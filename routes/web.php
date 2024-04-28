<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Shareholder\DashboardController as ShareholderDashboardController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;

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
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::prefix('admin')->name('admin.')->middleware('checkRoles:Admin')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
            Route::get('test-post', [AdminDashboardController::class, 'testPost'])->name('test-post');
        });

        Route::prefix('shareholder')->name('shareholder.')->middleware('checkRoles:Admin,Shareholder')->group(function () {
            Route::get('/', [ShareholderDashboardController::class, 'index'])->name('index');
        });

        Route::prefix('owner')->name('owner.')->middleware('checkRoles:Admin,Owner')->group(function () {
            Route::get('/', [OwnerDashboardController::class, 'index'])->name('index');
        });
    });
});

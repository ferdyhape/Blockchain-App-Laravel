<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CompanyManagementController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\AvailableProjectController as UserAvailableProjectController;
use App\Http\Controllers\User\ProjectManagementController as UserProjectManagementController;
use App\Http\Controllers\Admin\ProjectManagementController as AdminProjectManagementController;

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
    Route::post('/register', [AuthController::class, 'postRegister'])->name('register.process');
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
            Route::resource('payment-method', PaymentMethodController::class)->names('payment-method');


            // prefix project-management on admin
            Route::prefix('project-management')->name('project-management.')->group(function () {
                Route::resource('/', AdminProjectManagementController::class)->parameter('', 'project_management');
                Route::post('{id}/add-revision', [AdminProjectManagementController::class, 'addRevision'])->name('add-revision');
                Route::post('{id}/reject', [AdminProjectManagementController::class, 'reject'])->name('reject');
                Route::post('{id}/accept', [AdminProjectManagementController::class, 'accept'])->name('accept');
                Route::post('{id}/accept-revision', [AdminProjectManagementController::class, 'acceptRevision'])->name('accept-revision');
                Route::post('{id}/approve-committee', [AdminProjectManagementController::class, 'approveCommittee'])->name('approve-committee');
                Route::post('{id}/reject-committee', [AdminProjectManagementController::class, 'rejectCommittee'])->name('reject-committee');
                Route::post('{id}/accept-contract', [AdminProjectManagementController::class, 'acceptContract'])->name('accept-contract');
            });
        });

        Route::name('user.')->middleware(['role:Platinum Member|Admin'])->group(function () {
            Route::get('/', [UserDashboardController::class, 'index'])->name('index');

            // prefix project-management on user
            Route::prefix('project-management')->name('project-management.')->group(function () {
                Route::resource('/', UserProjectManagementController::class)->parameter('', 'project_management');
                Route::get('{id}/revise', [UserProjectManagementController::class, 'reviseProject'])->name('revise');
                Route::post('{id}/revise', [UserProjectManagementController::class, 'postReviseProject'])->name('revise.post');
                Route::get('{id}/upload-signed-contract', [UserProjectManagementController::class, 'uploadSignedContract'])->name('upload-signed-contract');
                Route::post('{id}/upload-signed-contract', [UserProjectManagementController::class, 'postUploadSignedContract'])->name('upload-signed-contract.post');
            });

            // Route::get('available-projects', [UserAvailableProjectController::class, 'index'])->name('available-projects');
            Route::prefix('available-project')->name('available-project.')->group(function () {
                Route::resource('/', UserAvailableProjectController::class)->parameter('', 'available_projects');
                Route::get('buy/{id}/', [UserAvailableProjectController::class, 'buyProject'])->name('buy');
                Route::post('preview-transaction/{id}', [UserAvailableProjectController::class, 'previewTransaction'])->name('preview-transaction');
            });
        });
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

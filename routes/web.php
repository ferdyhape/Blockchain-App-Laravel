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
use App\Http\Controllers\User\TransactionController as UserTransactionController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\User\TokenController as UserTokenController;
use App\Http\Controllers\User\WalletController as UserWalletController;
use App\Http\Controllers\Admin\WalletTransactionUserController as AdminWalletTransactionUser;

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
            Route::resource('payment-method', PaymentMethodController::class)->names('payment-method');
            Route::prefix('user-management')->name('user-management.')->group(function () {
                Route::post('verify-email', [UserManagementController::class, 'verifyEmail'])->name('verify-email');
                Route::post('reject-email', [UserManagementController::class, 'rejectEmail'])->name('reject-email');
                Route::resource('/', UserManagementController::class)->parameter('', 'user_management');
            });
            // Route::resource('user-management', UserManagementController::class)->names('user-management');

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


            Route::prefix('transaction')->name('transaction.')->group(function () {
                Route::resource('/', AdminTransactionController::class)->parameter('', 'transaction');
                Route::post('{code}/upload-proof', [AdminTransactionController::class, 'uploadProof'])->name('upload-proof');
                Route::put('{code}/change-status', [AdminTransactionController::class, 'changeStatus'])->name('change-status');
            });

            Route::prefix('wallet-transaction')->name('wallet-transaction.')->group(function () {
                Route::resource('/', AdminWalletTransactionUser::class)->parameter('', 'wallet_transaction');
                Route::post('accept', [AdminWalletTransactionUser::class, 'accept'])->name('accept');
                Route::post('reject', [AdminWalletTransactionUser::class, 'reject'])->name('reject');
                Route::patch('{id}/upload-proof', [AdminWalletTransactionUser::class, 'uploadProof'])->name('upload-proof');
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
                Route::get('{projectId}/check-transaction', [UserProjectManagementController::class, 'checkTransaction'])->name('check-transaction');
                Route::get('{transactionCode}/show', [UserProjectManagementController::class, 'showTransaction'])->name('show-transaction');
                Route::post('{transactionCode}/pay-for-sale-token', [UserProjectManagementController::class, 'payForSaleToken'])->name('pay-for-sale-token');
                Route::get('{id}/add-bank-account', [UserProjectManagementController::class, 'addBankAccount'])->name('add-bank-account');
                Route::post('{id}/add-bank-account', [UserProjectManagementController::class, 'postBankAccount'])->name('add-bank-account.post');
                Route::post('{id}/withdraw-campaign', [UserProjectManagementController::class, 'withdrawCampaign'])->name('withdraw-campaign');
                // route for get and post profit sharing payment
                Route::get('{id}/profit-sharing-payment', [UserProjectManagementController::class, 'profitSharingPayment'])->name('profit-sharing-payment');
                Route::post('{id}/profit-sharing-payment', [UserProjectManagementController::class, 'postProfitSharingPayment'])->name('profit-sharing-payment.post');
                // upload proof of payment for profit sharing
                Route::post('{transactionId}/profit-sharing-payment/upload-proof', [UserProjectManagementController::class, 'uploadProofProfitSharing'])->name('profit-sharing-payment.upload-proof');
            });

            Route::prefix('available-project')->name('available-project.')->group(function () {
                Route::resource('/', UserAvailableProjectController::class)->parameter('', 'available_projects');
                Route::get('buy/{id}/', [UserAvailableProjectController::class, 'buyProject'])->name('buy');
                Route::post('preview-transaction/{id}', [UserAvailableProjectController::class, 'previewTransaction'])->name('preview-transaction');
                Route::post('buy', [UserAvailableProjectController::class, 'postBuyProject'])->name('buy.post');
            });

            Route::prefix('transaction')->name('transaction.')->group(function () {
                Route::get('/', [UserTransactionController::class, 'index'])->name('index');
                Route::get('{code}', [UserTransactionController::class, 'show'])->name('show');
                Route::post('{code}/upload-proof', [UserTransactionController::class, 'uploadProof'])->name('upload-proof');
                Route::put('{code}/change-status', [UserTransactionController::class, 'changeStatus'])->name('change-status');
            });

            Route::prefix('token')->name('token.')->group(function () {
                Route::get('/', [UserTokenController::class, 'index'])->name('index');
                Route::get('/{id}', [UserTokenController::class, 'show'])->name('show');
                Route::post('/{campaign_id}/sell', [UserTokenController::class, 'sell'])->name('sell');
            });


            Route::prefix('my-walllet')->name('my-wallet.')->group(function () {
                Route::get('withdraw', [UserWalletController::class, 'withdraw'])->name('withdraw');
                Route::get('add-bank-account', [UserWalletController::class, 'addBankAccount'])->name('add-bank-account');
                Route::post('add-bank-account', [UserWalletController::class, 'postBankAccount'])->name('add-bank-account.post');
                Route::post('withdraw', [UserWalletController::class, 'postWithdraw'])->name('withdraw.post');
                Route::resource('/', UserWalletController::class)->parameter('', 'my_wallet');
                Route::post('topup', [UserWalletController::class, 'store'])->name('topup');
                Route::patch('{id}/upload-proof', [UserWalletController::class, 'uploadProof'])->name('upload-proof');
            });
        });
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

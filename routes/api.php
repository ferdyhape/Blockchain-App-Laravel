<?php

use App\Http\Controllers\API\PaymentMethodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/payment-methods-detail-buy-token', [PaymentMethodController::class, 'getPaymentMethodDetailForBuyToken'])->name('get-payment-methods-details-for-buy-token');
Route::get('/payment-methods-detail-sell-token', [PaymentMethodController::class, 'getPaymentMethodDetailForSellToken'])->name('get-payment-methods-details-for-sell-token');

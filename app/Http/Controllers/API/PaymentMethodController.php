<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodService;
use App\Http\Resources\PaymentMethodDetailResource;

class PaymentMethodController extends Controller
{
    public function getPaymentMethodDetailForBuyToken(Request $request)
    {
        $paymentMethod = PaymentMethodService::getPaymentMethodDetailForBuyToken($request->paymentMethodId);

        if (count($paymentMethod) == 0) {
            return response()->json([
                'message' => 'Detail Payment method not found'
            ], 404);
        }

        return response()->json(
            [
                'data' => PaymentMethodDetailResource::collection($paymentMethod),
                'message' => 'Success get detail payment method'
            ],
            200
        );
    }

    // getPaymentMethodDetailForBuyToken
    public function getPaymentMethodDetailForSellToken(Request $request)
    {
        $paymentMethod = PaymentMethodService::getPaymentMethodDetailForSellToken($request->paymentMethodId);

        // dd($paymentMethod);

        return response()->json(
            [
                'data' => $paymentMethod,
                'message' => 'Success get detail payment method'
            ],
            200
        );
    }
}

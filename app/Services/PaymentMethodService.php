<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodDetail;

/**
 * Class PaymentMethodService.
 */
class PaymentMethodService
{
    public static function storePaymentMethodDetail($data)
    {
        $createdPaymentMethodDetail =  PaymentMethodDetail::create([
            'name' => $data['bank_name'],
            'description' => $data['description'],
            'payment_method_id' => $data['payment_method_category_id'],
            'user_id' => $data['user_id'] ?? null,
        ]);

        if (isset($data['logo'])) {
            MediaLibraryService::attachMedia(
                $createdPaymentMethodDetail,
                $data['logo'],
                'payment_method_logo',
                false
            );
        }
    }

    public static function updatePaymentMethodDetail($paymentMethodDetailId, $data)
    {
        $paymentMethodDetail = PaymentMethodDetail::findOrFail($paymentMethodDetailId);
        $paymentMethodDetail->update([
            'name' => $data['name'],
            'description' => $data['editDescription'],
            'payment_method_id' => $data['payment_method_category_id'],
        ]);

        if (isset($data['logo'])) {
            MediaLibraryService::updateMedia(
                $paymentMethodDetail,
                $data['logo'],
                'payment_method_logo',
                false
            );
        }

        return $paymentMethodDetail;
    }

    public static function getPaymentMethodDetailById($paymentMethodDetailId)
    {
        return PaymentMethodDetail::findOrFail($paymentMethodDetailId)->load('paymentMethod');
    }

    public static function getPaymentMethod()
    {
        return PaymentMethod::with('details')->get();
    }

    public static function getPaymentMethodByName($paymentMethodName)
    {
        return PaymentMethod::where('name', $paymentMethodName)->first();
    }

    public static function getPaymentMethodForBuyToken()
    {
        return PaymentMethod::with(['details' => function ($query) {
            $query->whereNull('user_id');
        }])->get();
    }

    public static function getUserWalletPaymentMethodDetailForUser($userId = null)
    {
        return PaymentMethodDetail::where('user_id', $userId ?? auth()->id())->get();
    }

    public static function getPaymentMethodById($paymentMethodId)
    {
        return PaymentMethodDetail::with('paymentMethod')->find($paymentMethodId);
    }


    public static function getPaymentMethodDetailByPaymentMethodId($paymentMethodId)
    {
        $relatedPaymentMethod = PaymentMethod::find($paymentMethodId);
        return $relatedPaymentMethod->details;
    }

    public static function getPaymentMethodDetailForBuyToken($paymentMethodId)
    {
        return
            PaymentMethodDetail::with(['paymentMethod'])->whereNull('user_id')->where('payment_method_id', $paymentMethodId)->get();
    }

    public static function getPaymentMethodDetailForSellToken($paymentMethodDetailId)
    {
        return
            PaymentMethodDetail::find($paymentMethodDetailId);
    }

    public static function ajaxDatatableByAdmin()
    {
        $query = PaymentMethodDetail::with(['paymentMethod'])->whereNull('user_id')->get();
        // dd($query);
        $query->each(function ($query) {
            $query->logo = $query->getMedia('payment_method_logo');
        });

        return DatatableService::buildDatatable(
            $query,
            'auth.admin.payment_method.action'
        );
    }
}

<?php

namespace App\Services;

use Ramsey\Uuid\Uuid;
use App\Models\WalletTransactionUser;

/**
 * Class WalletService.
 */
class WalletService
{
    public static function storeWalletTransaction(array $data, $type)
    {
        $data = [
            'user_id' => auth()->id(),
            'amount' => $data['amount'],
            'payment_method_detail_id' => $data['payment_method_detail_id'],
            'status' => 'pending',
            'type' => $type,
            'code' => self::generateCode($type),
        ];
        $data = WalletTransactionUser::create($data);
        return $data;
    }

    public static function ajaxDatatableByAdmin()
    {
        $query = WalletTransactionUser::with(['user', 'paymentMethodDetail'])->latest();
        return DatatableService::buildDatatable(
            $query,
            'auth.admin.wallet_transaction.action'
        );
    }

    public static function uploadPaymentProof($walletTransactionId, $proofOfPayment)
    {
        $waleltTransaction = self::getWalletTransactionById($walletTransactionId);
        $filename = Uuid::uuid4()->toString() . '.' . $proofOfPayment->getClientOriginalExtension();
        $proofOfPayment->storeAs('wallet_transaction_user/payment_proof', $filename, 'public');
        $path = 'storage/wallet_transaction_user/payment_proof/' . $filename;

        $waleltTransaction->update([
            'payment_proof' => $path,
        ]);

        return $waleltTransaction;
    }

    // getWalletTransactionById
    public static function getWalletTransactionById($walletTransactionId)
    {
        return WalletTransactionUser::find($walletTransactionId);
    }

    public static function ajaxDatatableByUser()
    {
        $query = WalletTransactionUser::with(['paymentMethodDetail'])->where('user_id', auth()->id())->latest();
        return DatatableService::buildDatatable(
            $query,
            'auth.user.my_wallet.action'
        );
    }

    public static function rejectWalletTransaction($topUpWalletId)
    {
        $topup = WalletTransactionUser::find($topUpWalletId);
        $topup->update(['status' => 'rejected']);
        $topup->save();
    }

    public static function acceptWalletTransaction($topUpWalletId)
    {
        $topup = WalletTransactionUser::find($topUpWalletId);
        $topup->update(['status' => 'accepted']);
        self::updateUserBallance($topup->user_id, $topup->amount, 'topup');
        $topup->save();
    }

    private static function updateUserBallance($userId, $totalPrice, $type)
    {
        $user = UserService::getUserById($userId);
        if ($type == 'topup') {
            $user->wallet->deposit($totalPrice, ['description' => 'Topup wallet']);
        } else {
            $user->wallet->withdraw($totalPrice, ['description' => 'Withdraw wallet']);
        }
    }


    private static function generateCode($type): string
    {
        // $table->enum('type', ['topup', 'withdraw', 'withdraw_campaign', 'topup_campaign', 'profit_sharing_payment']);
        if ($type == 'topup') {
            $code = 'TP' . date('YmdHis') . rand(1000, 9999);
        } elseif ($type == 'withdraw') {
            $code = 'WD' . date('YmdHis') . rand(1000, 9999);
        } elseif ($type == 'withdraw_campaign') {
            $code = 'WDC' . date('YmdHis') . rand(1000, 9999);
        } elseif ($type == 'topup_campaign') {
            $code = 'TPC' . date('YmdHis') . rand(1000, 9999);
        } elseif ($type == 'profit_sharing_payment') {
            $code = 'PSP' . date('YmdHis') . rand(1000, 9999);
        }


        if (WalletTransactionUser::where('code', $code)->exists()) {
            return self::generateCode($type);
        }
        return $code;
    }
}

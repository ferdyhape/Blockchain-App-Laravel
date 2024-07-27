<?php

namespace App\Services;

use Ramsey\Uuid\Uuid;
use App\Models\WalletTransactionUser;

/**
 * Class WalletService.
 */
class WalletService
{

    // refundWalletTransaction
    public static function refundWalletTransaction($campaignId)
    {
        $campaign = CampaignService::getCampaignById($campaignId);
        $allToken = CampaignTokenService::getTokenByCampaignId($campaignId);
        $grouppedTokenOwner = [];

        foreach ($allToken as $token) {
            $soldTo = $token['sold_to'];
            if (isset($grouppedTokenOwner[$soldTo])) {
                $grouppedTokenOwner[$soldTo]['total'] += 1;
            } else {
                $grouppedTokenOwner[$soldTo] = [
                    'sold_to' => $soldTo,
                    'total' => 1
                ];
            }
        }

        foreach ($grouppedTokenOwner as $owner) {
            $totalAmount = $owner['total'] * $campaign->price_per_unit;
            $buildDescription = 'Refund payment for campaign "' . $campaign->project->title . '" (' . $owner['total'] . ' tokens x ' . self::toRupiahCurrency($campaign->price_per_unit) . ' = ' . self::toRupiahCurrency($totalAmount) . ')';
            $data = [
                'amount' => $totalAmount,
                'payment_method_detail_id' => 1,
                'description' => $buildDescription,
                'user_id' => $owner['sold_to'],
            ];
            $ownerWallet = WalletService::storeWalletTransaction($data, 'refund_payment', true);
            self::updateUserBallance($owner['sold_to'], $totalAmount, 'refund_payment');
        }

        CampaignTokenService::deleteTokenByCampaignId($campaignId);
        CampaignService::clearCampaignWalletBalance($campaign);
    }

    public static function storeWalletTransaction(array $data, $type, $redirectProfitSharing = false)
    {
        $walletable_id = isset($data['walletable_id']) ? $data['walletable_id'] : (isset($data['user_id']) ? $data['user_id'] : auth()->id());
        $data = [
            'amount' => $data['amount'],
            'payment_method_detail_id' => $data['payment_method_detail_id'],
            // 'status' => $forProfitSharing ? 'accepted' : 'pending',
            'description' => $data['description'] ?? '-',
            'status' => $redirectProfitSharing ? 'accepted' : 'pending',
            'type' => $type,
            'code' => self::generateCode($type),
            'walletable_id' => $walletable_id,
            'walletable_type' => $redirectProfitSharing ? 'App\Models\User' : self::checkWallettableType($type),
            'payment_proof' => $redirectProfitSharing ? '-' : null,
        ];

        $data = WalletTransactionUser::create($data);
        return $data;
    }

    private static function checkWallettableType($type)
    {
        if ($type == 'topup' || $type == 'withdraw') {
            return 'App\Models\User';
        } else {
            return 'App\Models\Campaign';
        }
    }

    public static function ajaxDatatableByAdmin()
    {
        $query = WalletTransactionUser::with(['walletable', 'paymentMethodDetail'])
            ->latest()
            ->get()
            ->map(function ($transaction) {
                if ($transaction->walletable_type == 'App\Models\Campaign' && $transaction->walletable) {
                    $transaction->walletable->load('project');
                }
                return $transaction;
            });

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
        $query = WalletTransactionUser::with(['paymentMethodDetail'])->where('walletable_type', 'App\Models\User')->where('walletable_id', auth()->id())->latest();
        return DatatableService::buildDatatable(
            $query,
            'auth.user.my_wallet.action'
        );
    }
    public static function walletTransactionByCampaign($campaignId)
    {
        $query = WalletTransactionUser::with(['paymentMethodDetail'])->where('walletable_type', 'App\Models\Campaign')->where('walletable_id', $campaignId)->latest()->get();
        return $query;
    }

    public static function rejectWalletTransaction($walletTransactionId)
    {
        $walletTransaction = WalletTransactionUser::find($walletTransactionId);
        $walletTransaction->update(['status' => 'rejected']);
        $walletTransaction->save();
    }

    public static function acceptWalletTransaction($walletTransactionId)
    {
        $walletTransaction = WalletTransactionUser::find($walletTransactionId);
        $walletTransaction->update(['status' => 'accepted']);
        switch ($walletTransaction->type) {
            case 'topup':
                self::updateUserBallance($walletTransaction->walletable_id, $walletTransaction->amount, 'topup');
                break;
            case 'withdraw':
                self::updateUserBallance($walletTransaction->walletable_id, $walletTransaction->amount, 'withdraw');
                break;
            case 'withdraw_campaign':
                CampaignService::updateWalletBalanceCampaign($walletTransaction->walletable_id, $walletTransaction->amount, 'decrease');
                break;
            case 'topup_campaign':
                CampaignService::updateWalletBalanceCampaign($walletTransaction->walletable_id, $walletTransaction->amount, 'increase');
                break;
            case 'profit_sharing_payment':
                $campaign = CampaignService::getCampaignById($walletTransaction->walletable_id);
                $allToken = CampaignTokenService::getTokenByCampaignId($walletTransaction->walletable_id);
                $grouppedTokenOwner = [];
                foreach ($allToken as $token) {
                    $soldTo = $token['sold_to'];
                    if (isset($grouppedTokenOwner[$soldTo])) {
                        $grouppedTokenOwner[$soldTo]['total'] += 1;
                    } else {
                        $grouppedTokenOwner[$soldTo] = [
                            'sold_to' => $soldTo,
                            // 'tokens' => [$token],
                            'total' => 1
                        ];
                    }
                }

                foreach ($grouppedTokenOwner as $owner) {
                    $profit = $owner['total'] * $campaign->price_per_unit * $campaign->project->profit_sharing_percentage / 100;
                    $netto = $owner['total'] * $campaign->price_per_unit;
                    $totalAmount = $profit + ($owner['total'] * $campaign->price_per_unit);
                    // $buildDescription = 'Profit sharing payment for campaign "' . $campaign->project->title . '" (' . $owner['total'] . ' tokens x ' . self::toRupiahCurrency($campaign->price_per_unit) . ' x ' . $campaign->project->profit_sharing_percentage . '% = ' . self::toRupiahCurrency($profit) . ')';
                    $buildDescription = 'Profit sharing payment for campaign "' . $campaign->project->title . '" (' . $owner['total'] . ' tokens x ' . self::toRupiahCurrency($campaign->price_per_unit) . ' x ' . $campaign->project->profit_sharing_percentage . '% = ' . self::toRupiahCurrency($profit) . ') + ' . self::toRupiahCurrency($owner['total'] * $campaign->price_per_unit) . ' = ' . self::toRupiahCurrency($totalAmount);
                    $data = [
                        'amount' => $totalAmount,
                        'payment_method_detail_id' => 1,
                        'description' => $buildDescription,
                        'user_id' => $owner['sold_to'],
                    ];


                    $ownerWallet = WalletService::storeWalletTransaction($data, 'profit_sharing_payment', true);
                    self::updateUserBallance($owner['sold_to'], $totalAmount, 'profit_sharing_payment');
                }
                CampaignTokenService::deleteTokenByCampaignId($walletTransaction->walletable_id);
                CampaignService::clearCampaignWalletBalance($campaign);
                break;
        }

        $walletTransaction->save();
    }

    private static function toRupiahCurrency($amount)
    {
        return 'Rp' . number_format($amount, 0, ',', '.');
    }

    public static function updateUserBallance($userId, $totalPrice, $type)
    {
        $user = UserService::getUserById($userId);
        if ($type == 'topup') {
            $user->wallet->deposit($totalPrice, ['description' => 'Topup wallet']);
        } else if ($type == 'withdraw') {
            $user->wallet->withdraw($totalPrice, ['description' => 'Withdraw wallet']);
        } else if ($type == 'profit_sharing_payment') {
            $user->wallet->deposit($totalPrice, ['description' => 'Profit sharing payment']);
        } else if ($type == 'refund_payment') {
            $user->wallet->deposit($totalPrice, ['description' => 'Refund payment']);
        }
    }


    private static function generateCode($type): string
    {
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
        } elseif ($type == 'refund_payment') {
            $code = 'RF' . date('YmdHis') . rand(1000, 9999);
        }


        if (WalletTransactionUser::where('code', $code)->exists()) {
            return self::generateCode($type);
        }
        return $code;
    }
}

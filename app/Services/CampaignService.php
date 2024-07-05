<?php

namespace App\Services;

use App\Models\Campaign;

/**
 * Class CampaignService.
 */
class CampaignService
{
    public static function getTokenPriceByCampaignId(string $campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);
        return $campaign->price_per_unit;
    }

    public static function getCampaigns()
    {
        return Campaign::where('status', 'on_fundraising')->latest()->get();
    }
    // reduce wallet balance
    public static function updateWalletBalanceCampaign($campaignId, $totalPrice, $type)
    {
        // type reduce or increase
        $campaign = CampaignService::getCampaignById($campaignId);
        if ($type == 'increase') {
            $campaign->wallet->balance += $totalPrice;
        } else {
            $campaign->wallet->balance -= $totalPrice;
        }
        $campaign->wallet->save();
    }

    public static function checkAvailablePayWithWallet($transactionCode)
    {
        $transaction = TransactionService::getTransactionByCode($transactionCode);
        return self::getCampaignWalletBalanceFromTransaction($transactionCode) >= $transaction->total_price;
    }

    public static function getCampaignWalletBalanceFromTransaction($transaction_code)
    {
        $transaction = TransactionService::getTransactionByCode($transaction_code);
        $campaign = CampaignService::getCampaignById($transaction->campaign_id);
        return $campaign->wallet->balance;
    }


    public static function getCampaignById(string $id)
    {
        return Campaign::findOrFail($id);
    }

    public static function getCampaignByIds(array $ids)
    {
        return Campaign::whereIn('id', $ids)->get();
    }

    // this function need to convert to blockchain
    public static function getCampaignByTransactionCode(string $transactionCode)
    {
        $transaction = TransactionService::getTransactionByCode($transactionCode);
        $campaign = Campaign::findOrFail($transaction->campaign_id);
        return $campaign;
    }
}

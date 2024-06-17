<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignToken;

/**
 * Class CampaignTokenService.
 */
class CampaignTokenService
{
    public static function deleteTokenByTransactionCode($transactionCode)
    {
        $campaignToken = CampaignToken::where('transaction_code', $transactionCode)->delete();
        // dd($campaignToken);
        $campaign = CampaignService::getCampaignByTransactionCode($transactionCode);
        $campaign->sold_token_amount = $campaign->sold_token_amount - $campaignToken;
        return $campaign->save();
    }

    public static function getSomeTokenForSell($campaign_id, $quantity, $userId = null)
    {
        return CampaignToken::where('campaign_id', $campaign_id)
            ->where('sold_to', $userId ?? auth()->id())
            ->where('status', 'sold')
            ->limit($quantity)
            ->orderBy('created_at')
            ->get();
    }

    public static function getTokenByUserId($userId = null)
    {
        return CampaignToken::where('sold_to', $userId ?? auth()->id())
            ->get();
    }

    public static function getTokenGroupByCampaign($userId = null)
    {
        $campaign_ids = CampaignToken::where('sold_to', $userId ?? auth()->id())
            ->get()
            ->pluck('campaign_id')
            ->unique()
            ->toArray();

        return CampaignService::getCampaignByIds($campaign_ids);
    }

    public static function getSoldTokenGroupByCampaign($userId = null)
    {
        $campaign_ids = CampaignToken::where('sold_to', $userId ?? auth()->id())
            ->where('status', 'sold')
            ->get()
            ->pluck('campaign_id')
            ->unique()
            ->toArray();

        return CampaignService::getCampaignByIds($campaign_ids);
    }


    public static function getTokenByCampaignId($campaignId, $userId = null)
    {
        return CampaignToken::where('campaign_id', $campaignId)
            ->where('sold_to', $userId ?? auth()->id())
            ->get();
    }

    public static function getSoldTokenByCampaignId($campaignId, $userId = null)
    {
        return CampaignToken::where('campaign_id', $campaignId)
            ->where('sold_to', $userId ?? auth()->id())
            ->where('status', 'sold')
            ->get();
    }
}

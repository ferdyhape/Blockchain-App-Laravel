<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignToken;

/**
 * Class CampaignTokenService.
 */
class CampaignTokenService
{
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


    public static function getTokenByCampaignId($campaignId, $userId = null)
    {
        return CampaignToken::where('campaign_id', $campaignId)
            ->where('sold_to', $userId ?? auth()->id())
            ->get();
    }
}

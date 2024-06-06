<?php

namespace App\Services;

use App\Models\Campaign;

/**
 * Class CampaignService.
 */
class CampaignService
{

    public static function getCampaigns()
    {
        return Campaign::where('status', 'on_fundraising')->latest()->get();
    }


    public static function getCampaignById(string $id)
    {
        return Campaign::findOrFail($id);
    }

    public static function getCampaignByIds(array $ids)
    {
        return Campaign::whereIn('id', $ids)->get();
    }
}

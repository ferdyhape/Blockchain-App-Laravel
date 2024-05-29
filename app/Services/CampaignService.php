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
        return Campaign::where('status', 'on_fundraising')->get();
    }
}

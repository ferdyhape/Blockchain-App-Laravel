<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use App\Services\CampaignTokenService;

class TokenController extends Controller
{
    public function sell($id, Request $request)
    {
        dd($id, $request->all());
        // $campaign = CampaignService::getCampaignById($id);
        // return view('auth.user.token.sell', compact('campaign'));
    }

    public function index()
    {
        $campaigns = CampaignTokenService::getTokenGroupByCampaign();
        return view('auth.user.token.index', compact('campaigns'));
    }


    public function show($id)
    {
        $campaign = CampaignService::getCampaignById($id);
        $tokens = CampaignTokenService::getTokenByCampaignId($id);
        return view('auth.user.token.show', compact('campaign', 'tokens'));
    }
}

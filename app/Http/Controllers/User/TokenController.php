<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Services\CampaignService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SellTokenRequest;
use App\Services\CampaignTokenService;
use App\Services\PaymentMethodService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    public function sell($campaign_id, SellTokenRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        TransactionService::sellToken($campaign_id, $validated);
        DB::commit();
        return redirect()->route('dashboard.user.token.index');
    }

    public function index()
    {
        // Mendapatkan token yang terjual dan mengelompokkan berdasarkan campaign_id
        $grouppedByCampaign = CampaignTokenService::getSoldTokenGroupByCampaign();

        if (count($grouppedByCampaign) == 0) {
            return view('auth.user.token.index', [
                'campaigns' => []
            ]);
        }

        $campaigns = CampaignService::getCampaignByIds($grouppedByCampaign->keys()->toArray());
        $campaigns = $campaigns->map(function ($campaign) use ($grouppedByCampaign) {
            $campaign->tokens = $grouppedByCampaign[$campaign->id];
            return $campaign;
        });

        return view('auth.user.token.index', compact('campaigns'));
    }




    public function show($id)
    {
        $campaign = CampaignService::getCampaignById($id);
        $tokens = CampaignTokenService::getSoldTokenByCampaignId($id);
        $wallets = PaymentMethodService::getUserWalletPaymentMethodDetailForUser();
        return view('auth.user.token.show', compact('campaign', 'tokens', 'wallets'));
    }
}

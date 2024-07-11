<?php

namespace App\Services;

use APIHelper;
use App\Models\Campaign;
use App\Models\CampaignToken;

/**
 * Class CampaignTokenService.
 */
class CampaignTokenService
{

    private static function mappingToken($tokensData, $isSingle = false)
    {
        $tokenMapped = [];

        if (is_object($tokensData)) {
            $tokensData = [$tokensData];
        }

        foreach ($tokensData as $token) {
            $tokenMapped[] = [
                'campaign_id' => $token->campaignId,
                'transaction_code' => $token->transactionCode,
                'token' => $token->token,
                'status' => $token->status,
                'sold_to' => $token->soldTo,
            ];
        }
        if ($isSingle) {
            return APIHelper::encodeDecode($tokenMapped[0]);
        }

        return $tokenMapped;
    }

    public static function getAllTokens()
    {
        $tokens = APIHelper::httpGet('getAllTokens');
        if (self::ifTokenNotFound($tokens)) {
            return [];
        }
        return self::mappingToken($tokens->data);
    }


    private static function ifTokenNotFound($tokens)
    {
        if (isset($tokens->error) && $tokens->error == 'Tokens not found') {
            return true;
        }
        return false;
    }

    // done
    public static function updateTokenStatus($transactionCode, $status)
    {
        $res = APIHelper::httpPost('changeStatusByTransactionCode', [
            'status' => $status == 'success' ? 'sold' : 'available',
            'transactionCode' => $transactionCode,
        ]);
        return $res;
    }


    public static function deleteTokenByTransactionCode($transactionCode)
    {
        $res = APIHelper::httpPost('deleteTokenByTransactionCode', [
            'transactionCode' => $transactionCode,
        ]);
        return $res;
    }

    public static function getCampaignTokensByTransactionCode($transactionCode)
    {
        $tokens = APIHelper::httpGet('getTokensByTransactionCode', $transactionCode);
        if (self::ifTokenNotFound($tokens)) {
            return [];
        }
        return self::mappingToken($tokens->data);
    }

    // public static function getSomeTokenForSell($campaign_id, $quantity, $userId)
    // {
    //     return CampaignToken::where('campaign_id', $campaign_id)
    //         ->where('sold_to', $userId)
    //         ->where('status', 'sold')
    //         ->limit($quantity)
    //         ->orderBy('created_at')
    //         ->get();
    // }

    // public static function getTokenByUserId($userId = null)
    // {
    //     return CampaignToken::where('sold_to', $userId ?? auth()->id())
    //         ->get();
    // }

    // public static function getTokenGroupByCampaign($userId = null)
    // {
    //     $campaign_ids = CampaignToken::where('sold_to', $userId ?? auth()->id())
    //         ->get()
    //         ->pluck('campaign_id')
    //         ->unique()
    //         ->toArray();

    //     return CampaignService::getCampaignByIds($campaign_ids);
    // }

    public static function getSoldTokenGroupByCampaign($userId = null)
    {
        $tokens = APIHelper::httpGet('getTokensBySoldTo', $userId ?? auth()->id());
        if (self::ifTokenNotFound($tokens)) {
            return [];
        }
        // dd($tokens);

        $tokensData = self::mappingToken($tokens->data);
        $filteredTokens = self::filterTokensWithStatusSold($tokensData);
        $grouppedByCampaign = collect($filteredTokens)->groupBy('campaign_id');
        // dd($grouppedByCampaign);

        return $grouppedByCampaign;
    }


    public static function filterTokensWithStatusSold($tokens)
    {
        $filtered = [];
        foreach ($tokens as $token) {
            if ($token['status'] == 'sold') {
                $filtered[] = $token;
            }
        }
        return $filtered;
    }


    public static function deleteTokenByCampaignId($campaignId)
    {
        $res = APIHelper::httpPost('deleteTokenByCampaignId', [
            'campaignId' => $campaignId,
        ]);
        return $res;
    }

    public static function getTokenByCampaignId($campaignId, $userId = null)
    {
        $tokens = APIHelper::httpGet('getTokensByCampaignId', $campaignId);
        if (self::ifTokenNotFound($tokens)) {
            return [];
        }

        return self::mappingToken($tokens->data);
    }

    public static function getSoldTokenByCampaignId($campaignId, $userId = null)
    {
        $tokens = APIHelper::httpGet('getTokensByCampaignIdAndSoldTo', $campaignId . '/' . ($userId ?? auth()->id()));
        if (self::ifTokenNotFound($tokens)) {
            return [];
        }

        return self::mappingToken($tokens->data);
    }


    public static function deleteTokenByCampaignIdAndSoldTo($campaignId, $quantity, $userId)
    {
        $res = APIHelper::httpPost('deleteTokenByCampaignIdAndSoldTo', [
            'campaignId' => $campaignId,
            'soldTo' => $userId,
            'quantity' => $quantity,
        ]);
        return $res;
    }
}

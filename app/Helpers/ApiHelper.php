<?php

use Illuminate\Support\Facades\Http;

class APIHelper
{
    private static $baseApiUrl;
    private static $apiToken;

    private static $arraySegmentApi = [
        // get transaction
        'getAllTransactions' => '/transactions',
        'getTransactionDetails' => '/transaction-details',
        'getTransactionByCode' => '/transactions/code',
        'getTransactionByFromToUserId' => '/transactions/fromToUserId',
        'getTransactionByCampaignId' => '/transactions/campaignId',
        'getCountTransaction' => '/transactions/count',

        // post transaction
        'addTransaction' => '/transactions',
        'updateTransactionStatus' => '/transactions/update-status',
        'updateTransactionPaymentStatus' => '/transactions/update-payment-status',
        'uploadTransactionPaymentProof' => '/transactions/upload-payment-proof',

        // get transaction details
        'getTransactionDetailByTransactionCode' => '/transaction-details/getTransactionDetails',
        'getCountTransactionDetailByTransactionCode' => '/transaction-details/count',
        'getPriceFromTransactionDetailByTransactionCode' => '/transaction-details/price',

        // post transaction details
        'addTransactionDetail' => '/transaction-details',

        // get token
        'getAllTokens' => '/tokens',
        'getTokensByCampaignId' => '/tokens/campaign',
        'getSoldTokensByCampaignId' => '/tokens/sold',
        'getTokensBySoldTo' => '/tokens/soldTo',
        'getTokensByCampaignIdAndSoldTo' => '/tokens/campaignSoldTo',
        'getTokensByTransactionCode' => '/tokens/transaction',

        // post token
        'addToken' => '/tokens',
        'changeStatusByTransactionCode' => '/tokens/changeStatusByTransactionCode',
        'deleteTokenByTransactionCode' => '/tokens/deleteTokenByTransactionCode',
        'deleteTokenByCampaignIdAndSoldTo' => '/tokens/deleteTokenByCampaignIdAndSoldTo',
        'deleteTokenByCampaignId' => '/tokens/deleteTokenByCampaignId',
    ];


    public static function initialize()
    {
        self::$baseApiUrl = config('app.base_api_url');
        self::$apiToken = config('app.api_token');
    }

    public static function httpGet($key, string $param = null, $encodeDecode = true)
    {
        $config = self::buildConfig($key);
        $url = $config['fullApiUrl'];

        if ($param) {
            // get params value
            $url .= '/' . $param;
        }

        // dd($url);
        $response = Http::withHeaders([
            'Authorization' => self::$apiToken,
        ])->get($url)->json();

        if (!$encodeDecode) {
            return $response;
        }
        return self::encodeDecode($response);
    }



    public static function encodeDecode($data)
    {
        $data = json_encode($data);
        return json_decode($data);
    }

    public static function httpPost($key, $data, $param = null)
    {
        $config = self::buildConfig($key);

        if ($param) {
            // get params value
            $config['fullApiUrl'] .= '/' . $param;
        }

        // dd($config['fullApiUrl'], $data);

        return Http::withHeaders([
            'Authorization' => self::$apiToken,
        ])->post($config['fullApiUrl'], $data)->json();
    }

    private static function buildConfig($key)
    {
        self::initialize();
        $segmentApiUrl = self::$arraySegmentApi[$key];
        return [
            'baseApiUrl' => self::$baseApiUrl,
            'fullApiUrl' => self::$baseApiUrl . $segmentApiUrl
        ];
    }
}

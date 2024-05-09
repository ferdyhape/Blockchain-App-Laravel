<?php

use Illuminate\Support\Facades\Http;

class APIHelper
{
    private static $baseApiUrl;
    private static $apiToken;
    private static $arraySegmentApi = [
        'getTransactions' => '/transactions',
        'getTransactionDetails' => '/transaction-details',
        'addTransaction' => '/transactions',
        'addTransactionDetail' => '/transaction-details',
    ];

    public static function initialize()
    {
        self::$baseApiUrl = config('app.base_api_url');
        self::$apiToken = config('app.api_token');
    }

    public static function httpGet($key)
    {
        $config = self::buildConfig($key);
        return Http::withHeaders([
            'Authorization' => self::$apiToken,
        ])->get($config['fullApiUrl'])->json();
    }

    public static function httpPost($key, $data)
    {
        $config = self::buildConfig($key);

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

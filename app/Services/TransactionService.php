<?php

namespace App\Services;

use APIHelper;
use Ramsey\Uuid\Uuid;
use App\Models\Campaign;
use App\Models\CampaignToken;
use Illuminate\Support\Facades\Log;
use App\Jobs\AddTokenProcess;
use App\Jobs\TokenManagementQueue;

/**
 * Class TransactionService.
 */
class TransactionService
{

    // this function need to convert to blockchain
    public static function payForSaleToken($transactionCode, $method, $proofOfPayment = null)
    {
        if ($method == 'wallet') {
            // jika pembayaran menggunakan wallet maka yang upload proof adalah admin
            if (CampaignService::checkAvailablePayWithWallet($transactionCode)) {
                self::changeTransactionStatus($transactionCode, 'pending', 'needAdminAction');
            } else {
                return redirect()->back()->with('error', 'Insufficient balance');
            }
        } else {
            // jika pembayaran menggunakan transfer maka yang upload proof adalah user
            self::changeTransactionStatus($transactionCode, 'pending', 'paid');
            self::uploadPaymentProof($transactionCode, $proofOfPayment);
        }
    }

    // done integration with blockchain
    public static function changeTransactionStatus($code, $status, $paymentStatus)
    {
        $transaction = self::getTransactionByCode($code);
        self::updateTransactionStatus($code, $status);
        self::updateTransactionPaymentStatus($code, $paymentStatus ?? 'failed');
        self::changeCampaignStatus($transaction, $status);
    }

    // done integration with blockchain
    public static function uploadPaymentProof($transactionCode, $proofOfPayment, bool $paidBycampaignBalance = false)
    {
        $transaction = self::getTransactionByCode($transactionCode);
        $filename = Uuid::uuid4()->toString() . '.' . $proofOfPayment->getClientOriginalExtension();
        $proofOfPayment->storeAs('payment_proof', $filename, 'public');
        $path = 'storage/payment_proof/' . $filename;

        self::updateTransactionPaymentProof($transactionCode, $path);
        self::updateTransactionPaymentStatus($transactionCode, $paidBycampaignBalance == true ? 'paidByCampaignBalance' : 'paid');

        return $transaction;
    }

    // done integration with blockchain
    public static function sellToken($campaign_id, $data)
    {
        $relatedCampaign = CampaignService::getCampaignById($campaign_id);
        $transactionCode = self::generateTransactionCode('sell');
        $totalPrice = $relatedCampaign->price_per_unit * $data['quantity'];

        $postData = [
            'transactionCode' => $transactionCode,
            'campaignId' => $relatedCampaign->id,
            'fromToUserId' => auth()->user()->id,
            'orderType' => 'sell',
            'paymentStatus' => 'paid',
            'status' => 'success',
            'quantity' => $data['quantity'],
            'totalPrice' => $totalPrice,
            'paymentMethodDetailId' => "null",
            'paymentProof' => null,
            'createdAt' => date('c'),
        ];

        self::postTransaction($postData);
        AddTokenProcess::dispatch(
            $relatedCampaign,
            $transactionCode,
            $data['quantity'],
            auth()->user()->id,
            'sell'
        )->delay(now()->addSeconds(10));

        self::updateUserBallance(auth()->user()->id, $totalPrice, 'sell');
        self::updateSoldTokenAmount($relatedCampaign, $data['quantity'], "decrement");
        CampaignService::updateWalletBalanceCampaign($relatedCampaign->id, $totalPrice, 'reduce');
        // CampaignTokenService::deleteTokenByTransactionCode($transactionCode);

        return $transactionCode;
    }

    // done integration with blockchain
    public static function buyToken(array $data)
    {
        $relatedCampaign = CampaignService::getCampaignById($data['campaign_id']);
        $transactionCode = self::generateTransactionCode('buy');
        $totalPrice = $relatedCampaign->price_per_unit * $data['quantity'];

        $postData = [
            'transactionCode' => $transactionCode,
            'campaignId' => $relatedCampaign->id,
            'fromToUserId' => auth()->user()->id,
            'orderType' => 'buy',
            'paymentStatus' => 'paid',
            'status' => 'success',
            'quantity' => $data['quantity'],
            'totalPrice' => $totalPrice,
            'paymentMethodDetailId' => "null",
            'paymentProof' => null,
            // 'createdAt' => time(),
            'createdAt' => date('c')
        ];

        self::postTransaction($postData);
        AddTokenProcess::dispatch(
            $relatedCampaign,
            $transactionCode,
            $data['quantity'],
            auth()->user()->id,
            'buy'
        )->delay(now()->addSeconds(10));

        self::updateUserBallance(auth()->user()->id, $totalPrice, 'buy');
        self::updateSoldTokenAmount($relatedCampaign, $data['quantity'], "increment");
        CampaignService::updateWalletBalanceCampaign($relatedCampaign->id, $totalPrice, 'increase');

        return $transactionCode;
    }

    // this function need to convert to blockchain
    public static function addToken(Campaign $campaign, string $transaction_code, $quantity, $orderType, $userId)
    {
        if ($orderType == 'buy') {
            // Generate token for each quantity
            for ($i = 1; $i <= $quantity; $i++) {

                $generatedToken = null;
                $generatedToken = Uuid::uuid4()->toString();
                $microtime = microtime(true);
                $timestamp = number_format($microtime, 6, '', '');
                $formattedToken = $generatedToken . '-' . $timestamp;

                self::postToken([
                    'token' => $formattedToken,
                    'status' => 'sold',
                    'soldTo' => $userId,
                    'transactionCode' => $transaction_code,
                    'campaignId' => $campaign->id,
                ]);
            }
        }

        // if order type is sell,
        else {
            CampaignTokenService::deleteTokenByCampaignIdAndSoldTo($campaign->id, $quantity, $userId);
        }
    }

    private static function changeCampaignStatus($transaction, $status)
    {
        CampaignTokenService::updateTokenStatus($transaction->transaction_code, $status);
        $campaign = CampaignService::getCampaignById($transaction->campaign_id);
        $campaignToken = CampaignTokenService::getCampaignTokensByTransactionCode($transaction->transaction_code);

        if ($status == 'success') {
            if ($transaction->order_type == 'buy') {
                $campaign->wallet->deposit($transaction->total_price, ['description' => 'Buy token from campaign']);
                $campaign->sold_token_amount = $campaign->sold_token_amount + count($campaignToken);
                $campaign->save();
            } elseif ($transaction->order_type == 'sell') {
                CampaignTokenService::deleteTokenByTransactionCode($transaction->transaction_code);
            }
        }
    }

    private static function updateUserBallance($userId, $totalPrice, $orderType)
    {
        $user = UserService::getUserById($userId);
        if ($orderType == 'buy') {
            $user->wallet->withdraw($totalPrice, ['description' => 'Buy token for campaign']);
        } else {
            $user->wallet->deposit($totalPrice, ['description' => 'Sell token from campaign']);
        }
    }

    private static function updateSoldTokenAmount($campaign, $quantity, $type)
    {
        // type increment or decrement
        if ($type == "increment") {
            $campaign->sold_token_amount = $campaign->sold_token_amount + $quantity;
            $campaign->save();
        } else {
            $campaign->sold_token_amount = $campaign->sold_token_amount - $quantity;
            $campaign->save();
        }
    }


    // -- START FUNC FOR GET TO EXPRESS JS, MAPPING DATA, AND POST TO BLOCKCHAIN -- //

    public static function postToken(array $data)
    {
        $res = APIHelper::httpPost('addToken', $data);
        return $res;
    }

    // done integration with blockchain
    private static function postTransaction(array $data)
    {
        $data['totalPrice'] = (int) $data['totalPrice'];
        $res =  APIHelper::httpPost('addTransaction', $data);
        return $res;
    }

    // done integration with blockchain
    private static function postTransactionDetail(array $data)
    {
        $data['price'] = (int) $data['price'];
        $res = APIHelper::httpPost('addTransactionDetail', $data);
        return $res;
    }

    // done integration with blockchain
    private static function updateTransactionStatus($code, $status)
    {
        $res = APIHelper::httpPost('updateTransactionStatus', [
            'status' => $status,
            'transactionCode' => $code,
        ]);
        return $res;
    }

    // done integration with blockchain
    private static function updateTransactionPaymentStatus($code, $paymentStatus)
    {
        $res = APIHelper::httpPost('updateTransactionPaymentStatus', [
            'paymentStatus' => $paymentStatus,
            'transactionCode' => $code,
        ]);
        return $res;
    }

    // done integration with blockchain
    private static function updateTransactionPaymentProof($code, $proofOfPayment)
    {
        $res = APIHelper::httpPost('uploadTransactionPaymentProof', [
            'paymentProof' => $proofOfPayment,
            'transactionCode' => $code,
        ]);
        return $res;
    }

    public static function checkIfMaximumPurchased($campaign_id, $quantity)
    {
        $relatedCampaign = CampaignService::getCampaignById($campaign_id);
        // $countBuyerTokenInThisCampaign = CampaignToken::where('sold_to', auth()->user()->id)->where('campaign_id', $campaign_id)->count();
        $countBuyerTokenInThisCampaign = count(CampaignTokenService::getSoldTokenByCampaignId($campaign_id, auth()->user()->id));
        $totalMaximumPurchased = $relatedCampaign->maximum_purchase;

        if ($countBuyerTokenInThisCampaign + $quantity > $totalMaximumPurchased) {
            return false;
        }
        return true;
    }

    public static function checkIfWalletBalanceEnough($totalPrice)
    {
        $user = UserService::getUserById(auth()->user()->id);
        if ($user->wallet->balance < $totalPrice) {
            return false;
        }
        return true;
    }

    // done integration with blockchain
    public static function ajaxDatatableByAdmin()
    {
        $transactionsData = self::getAllTransaction();
        usort($transactionsData, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });
        return DatatableService::buildDatatable(
            $transactionsData,
            'auth.admin.transaction.action',
        );
    }

    // done integration with blockchain
    public static function ajaxDatatableTransactionInProjectManagementByUser($campaign_id)
    {
        $transactionsData = self::getTransactionByCampaignId($campaign_id);
        usort($transactionsData, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });
        return DatatableService::buildDatatable(
            $transactionsData,
            'auth.user.project_management.transactionAction'
        );
    }

    // done integration with blockchain
    public static function getTransactionByUserId()
    {
        $transactions = APIHelper::httpGet('getTransactionByFromToUserId', auth()->user()->id);

        if (self::ifTransactionNotFound($transactions)) {
            return [];
        }
        $transactionData = (array) $transactions->data;
        usort($transactionData, function ($a, $b) {
            return $b->createdAt <=> $a->createdAt;
        });
        return self::mappingTransaction($transactions->data);
    }

    // done integration with blockchain
    public static function getAllTransaction()
    {
        $transactions = APIHelper::httpGet('getAllTransactions');
        if (self::ifTransactionNotFound($transactions)) {
            return [];
        }

        return self::mappingTransaction($transactions->data);
    }

    // done integration with blockchain
    public static function getTransactionByCampaignId($campaign_id)
    {
        $transactions = APIHelper::httpGet('getTransactionByCampaignId', $campaign_id);
        if (self::ifTransactionNotFound($transactions)) {
            return [];
        }

        return self::mappingTransaction($transactions->data);
    }

    // done integration with blockchain
    public static function getTransactionByCode($code)
    {
        $transactions = APIHelper::httpGet('getTransactionByCode', $code);
        return self::mappingTransaction($transactions->data, true);
    }

    // done integration with blockchain
    public static function getPriceFromTransactionDetailByTransactionCode($transaction_code)
    {
        $res = APIHelper::httpGet('getPriceFromTransactionDetailByTransactionCode', $transaction_code);
        return $res->data;
    }

    // done integration with blockchain
    public static function getCountTransactionDetailByTransactionCode($transaction_code)
    {
        $res = APIHelper::httpGet('getCountTransactionDetailByTransactionCode', $transaction_code);
        return $res->data;
    }

    // done integration with blockchain
    public static function getTransactionDetailByCode($transaction_code)
    {
        return APIHelper::httpGet('getTransactionDetailByTransactionCode', $transaction_code);
    }

    // check if transaction not found
    private static function ifTransactionNotFound($transactions)
    {
        if (isset($transactions->error) && $transactions->error == 'Transaction not found') {
            return true;
        }
        return false;
    }

    // mapping transaction data from blockchain
    private static function mappingTransaction($transactionsData, $isSingle = false)
    {
        $transactionMapped = [];

        if (is_object($transactionsData)) {
            $transactionsData = [$transactionsData];
        }

        foreach ($transactionsData as $transaction) {
            $transactionMapped[] = [
                'transaction_code' => $transaction->transactionCode,
                'campaign_id' => $transaction->campaignId,
                'campaign_name' => CampaignService::getCampaignById($transaction->campaignId)->project->title,
                'from_to_user_id' => $transaction->fromToUserId,
                'from_to_user_name' => UserService::getUserById($transaction->fromToUserId)->name,
                'order_type' => $transaction->orderType,
                'payment_status' => $transaction->paymentStatus,
                'status' => $transaction->status,
                'quantity' => $transaction->quantity,
                'total_price' => $transaction->totalPrice,
                'payment_proof' => $transaction->paymentProof,
                'created_at' => $transaction->createdAt,
            ];
        }
        if ($isSingle) {
            return APIHelper::encodeDecode($transactionMapped[0]);
        }

        // dd($transactionMapped);
        return $transactionMapped;
    }

    // done integration with blockchain
    public static function generateTransactionCode($orderType)
    {
        $prefix = $orderType === 'sell' ? 'TS' : 'TB';
        $response = APIHelper::httpGet('getCountTransaction');
        $countOfTransaction = $response->data;
        return $prefix . date('Ymd') . '-' . ($countOfTransaction + 1);
    }
}

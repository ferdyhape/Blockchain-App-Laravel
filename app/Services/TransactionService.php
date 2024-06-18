<?php

namespace App\Services;

use APIHelper;
use Ramsey\Uuid\Uuid;
use App\Models\Campaign;
use App\Models\CampaignToken;
use Illuminate\Support\Facades\Log;
use App\Jobs\AddTransactionDetailProcess;
use App\Models\Transaction;
use App\Models\TransactionDetail;

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
        $relatedPaymentMethodDetail = PaymentMethodService::getPaymentMethodDetailById($data['payment_method_detail_id']);
        $transactionCode = self::generateTransactionCode('sell');

        $postData = [
            'transactionCode' => $transactionCode,
            'campaignId' => $relatedCampaign->id,
            'fromToUserId' => auth()->user()->id,
            'orderType' => 'sell',
            'paymentStatus' => 'unpaid',
            'status' => 'pending',
            'quantity' => $data['quantity'],
            'totalPrice' => $relatedCampaign->price_per_unit * $data['quantity'],
            'paymentMethodDetailId' => $relatedPaymentMethodDetail->id,
            'paymentProof' => null,
            'createdAt' => time(),
        ];

        self::postTransaction($postData);
        AddTransactionDetailProcess::dispatch(
            $relatedCampaign,
            $transactionCode,
            $data['quantity'],
            auth()->user()->id,
            'sell'
        )->delay(now()->addSeconds(10));
    }

    // done integration with blockchain
    public static function buyToken(array $data)
    {
        $relatedCampaign = CampaignService::getCampaignById($data['campaign_id']);
        $relatedPaymentMethodDetail = PaymentMethodService::getPaymentMethodDetailById($data['payment_method_detail_id']);
        $transactionCode = self::generateTransactionCode('buy');

        $postData = [
            'transactionCode' => $transactionCode,
            'campaignId' => $relatedCampaign->id,
            'fromToUserId' => auth()->user()->id,
            'orderType' => 'buy',
            'paymentStatus' => 'unpaid',
            'status' => 'pending',
            'quantity' => $data['quantity'],
            'totalPrice' => $relatedCampaign->price_per_unit * $data['quantity'],
            'paymentMethodDetailId' => $relatedPaymentMethodDetail->id,
            'paymentProof' => null,
            'createdAt' => time(),
        ];

        self::postTransaction($postData);
        AddTransactionDetailProcess::dispatch(
            $relatedCampaign,
            $transactionCode,
            $data['quantity'],
            auth()->user()->id,
            'buy'
        )->delay(now()->addSeconds(10));

        return $transactionCode;
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

    // this function need to convert to blockchain
    public static function addTransactionDetail(Campaign $campaign, string $transaction_code, $quantity, $orderType, $userId)
    {
        if ($orderType == 'buy') {
            // Generate token for each quantity
            for ($i = 1; $i <= $quantity; $i++) {

                // Generate token
                $generatedToken = null;
                do {
                    $generatedToken = Uuid::uuid4()->toString();
                } while (CampaignToken::where('token', $generatedToken)->exists());

                $campaign->campaignTokens()->create([
                    'token' => $generatedToken,
                    'status' => 'pending',
                    'sold_to' => $userId,
                    'transaction_code' => $transaction_code,
                ]);

                self::postTransactionDetail([
                    'transactionCode' => $transaction_code,
                    'price' => $campaign->price_per_unit,
                    'token' => $generatedToken,
                    'createdAt' => time(),
                ]);
            }
        }

        // if order type is sell,
        else {
            // Get some token for sell
            $campaignTokens = CampaignTokenService::getSomeTokenForSell($campaign->id, $quantity, $userId);

            Log::channel('transactionservice')->info('Campaign Tokens: ' . $campaignTokens);
            // Create transaction detail
            foreach ($campaignTokens as $token) {

                self::postTransactionDetail([
                    'transactionCode' => $transaction_code,
                    'price' => $campaign->price_per_unit,
                    'token' => $token->token,
                    'createdAt' => time(),
                ]);

                // Update token status
                $updateResult = $token->update([
                    'status' => 'pending',
                    'transaction_code' => $transaction_code,
                ]);

                Log::channel('transactionservice')->info('Update Token Status: ' . $updateResult);
            }
        }
    }

    private static function changeCampaignStatus($transaction, $status)
    {
        // get campaign token by transaction code
        $campaignToken = CampaignToken::where('transaction_code', $transaction->transaction_code)->get();

        // update token status on transaction success
        foreach ($campaignToken as $token) {
            $token->update([
                'status' => $status == 'success' ? 'sold' : 'available',
                'sold_to' => $status == 'success' ? $token->sold_to : null,
            ]);
        }

        if ($status == 'success') {
            if ($transaction->order_type == 'buy') {
                $campaignToken->first()->campaign()->first()->wallet->deposit($transaction->total_price, ['description' => 'Buy token from campaign']);
                // update campaign sold token amount on transaction success
                $campaignToken->first()->campaign()->update([
                    'sold_token_amount' => $status == 'success' ? $campaignToken->first()->campaign->sold_token_amount + $campaignToken->count() : $campaignToken->first()->campaign->sold_token_amount,
                ]);
            } elseif ($transaction->order_type == 'sell') {
                CampaignTokenService::deleteTokenByTransactionCode($transaction->transaction_code);
            }
        }
    }

    public static function checkIfMaximumPurchased($campaign_id, $quantity)
    {
        $relatedCampaign = CampaignService::getCampaignById($campaign_id);
        $countBuyerTokenInThisCampaign = CampaignToken::where('sold_to', auth()->user()->id)->where('campaign_id', $campaign_id)->count();
        $totalMaximumPurchased = $relatedCampaign->maximum_purchase;

        if ($countBuyerTokenInThisCampaign + $quantity > $totalMaximumPurchased) {
            return false;
        }
        return true;
    }

    // done integration with blockchain
    public static function ajaxDatatableByAdmin()
    {
        $transactionsData = self::getAllTransaction();
        return DatatableService::buildDatatable(
            $transactionsData,
            'auth.admin.transaction.action',
        );
    }

    // done integration with blockchain
    public static function ajaxDatatableTransactionInProjectManagementByUser($campaign_id)
    {
        $transactionData = self::getTransactionByCampaignId($campaign_id);
        return DatatableService::buildDatatable(
            $transactionData,
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
                'payment_method_detail_id' => $transaction->paymentMethodDetailId,
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

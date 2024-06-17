<?php

namespace App\Services;

use Ramsey\Uuid\Uuid;
use App\Models\Campaign;
use App\Models\Transaction;
use App\Models\CampaignToken;
use App\Models\TransactionDetail;

/**
 * Class TransactionService.
 */
class TransactionService
{
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

    // this function need to convert to blockchain
    public static function getPriceFromTransactionDetail($transaction_code)
    {
        $transaction = self::getTransactionByCode($transaction_code);
        return $transaction->transactionDetails->first()->price;
    }

    // this function need to convert to blockchain
    public static function getCountTransactionDetailByTransactionCode($transaction_code)
    {
        $transaction = self::getTransactionByCode($transaction_code);
        return $transaction->transactionDetails->count();
    }

    // this function need to convert to blockchain
    public static function getTransactionDetailByCode($transaction_code)
    {
        $transactionDetails = TransactionDetail::where('transaction_code', $transaction_code)->get();
        return $transactionDetails;
    }

    // this function need to convert to blockchain
    public static function sellToken($campaign_id, $data)
    {
        $relatedCampaign = CampaignService::getCampaignById($campaign_id);
        $relatedPaymentMethodDetail = PaymentMethodService::getPaymentMethodDetailById($data['payment_method_detail_id']);

        $prepareData = [
            'campaign_id' => $relatedCampaign->id,
            'campaign_name' => $relatedCampaign->project->title,
            'from_to_user_id' => auth()->user()->id,
            'from_to_user_name' => auth()->user()->name,
            'order_type' => 'sell',
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'quantity' => $data['quantity'],
            'payment_method_id' => $relatedPaymentMethodDetail->payment_method_id,
            'payment_method' => $relatedPaymentMethodDetail->paymentMethod->name,
            'payment_method_detail_id' => $relatedPaymentMethodDetail->id,
            'payment_method_detail' => $relatedPaymentMethodDetail->name,
            'total_price' => $relatedCampaign->price_per_unit * $data['quantity'],
        ];

        $transaction = Transaction::create($prepareData);

        self::addTransactionDetail($relatedCampaign, $transaction, $data['quantity'], 'sell');
    }

    // this function need to convert to blockchain
    public static function changeTransactionStatus($code, $status, $paymentStatus)
    {
        $transaction = self::getTransactionByCode($code);


        // if ($transaction->order_type == 'sell' && $status == 'success') {
        //     CampaignTokenService::deleteTokenByTransactionCode($code);
        // }

        // this function need to convert to blockchain (update transaction status on blockchain)
        $transaction->update([
            'status' => $status,
            'payment_status' => $paymentStatus ?? 'failed',
        ]);

        self::changeCampaignStatus($transaction, $status);
    }

    // this function need to convert to blockchain
    public static function uploadPaymentProof($transactionCode, $proofOfPayment, bool $paidBycampaignBalance = false)
    {
        $transaction = self::getTransactionByCode($transactionCode);
        $filename = Uuid::uuid4()->toString() . '.' . $proofOfPayment->getClientOriginalExtension();
        $proofOfPayment->storeAs('payment_proof', $filename, 'public');
        $path = 'storage/payment_proof/' . $filename;

        // this function need to convert to blockchain (upload payment proof on blockchain)
        $transaction->update([
            'payment_proof' => $path,
            'payment_status' => $paidBycampaignBalance == true ? 'paidByCampaignBalance' : 'paid',
        ]);

        return $transaction;
    }

    // this function need to convert to blockchain
    public static function storeTransaction(array $data)
    {
        $relatedCampaign = CampaignService::getCampaignById($data['campaign_id']);
        $relatedPaymentMethodDetail = PaymentMethodService::getPaymentMethodDetailById($data['payment_method_detail_id']);

        $prepareData = [
            'campaign_id' => $relatedCampaign->id,
            'campaign_name' => $relatedCampaign->project->title,
            'from_to_user_id' => auth()->user()->id,
            'from_to_user_name' => auth()->user()->name,
            'order_type' => 'buy',
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'quantity' => $data['quantity'],
            'payment_method_id' => $relatedPaymentMethodDetail->payment_method_id,
            'payment_method' => $relatedPaymentMethodDetail->paymentMethod->name,
            'payment_method_detail_id' => $relatedPaymentMethodDetail->id,
            'payment_method_detail' => $relatedPaymentMethodDetail->name,
            'total_price' => $relatedCampaign->price_per_unit * $data['quantity'],
        ];

        $transaction = Transaction::create($prepareData);

        // dd($transaction);
        self::addTransactionDetail($relatedCampaign, $transaction, $data['quantity']);

        return $transaction;
    }

    // this function need to convert to blockchain
    private static function addTransactionDetail(Campaign $campaign, Transaction $transaction, $quantity, $orderType = 'buy')
    {
        if ($orderType == 'buy') {

            // Generate token for each quantity
            for ($i = 1; $i <= $quantity; $i++) {

                // Generate token
                $generatedToken = null;
                do {
                    $generatedToken = Uuid::uuid4()->toString();
                } while (CampaignToken::where('token', $generatedToken)->exists());

                // Create campaign token
                $campaign->campaignTokens()->create([
                    'token' => $generatedToken,
                    'status' => 'pending',
                    'sold_to' => auth()->user()->id,
                    'transaction_code' => $transaction->transaction_code,
                ]);

                // Create transaction detail
                // this function need to convert to blockchain (create transaction detail on blockchain)
                $transaction->transactionDetails()->create([
                    'price' => $campaign->price_per_unit,
                    'token' => $generatedToken,
                ]);
            }
        }

        // if order type is sell,
        else {
            // Get some token for sell
            $campaignTokens = CampaignTokenService::getSomeTokenForSell($campaign->id, $quantity);

            // Create transaction detail
            foreach ($campaignTokens as $token) {
                // Create transaction detail
                // this function need to convert to blockchain (create transaction detail on blockchain)
                $transaction->transactionDetails()->create([
                    'price' => $campaign->price_per_unit,
                    'token' => $token->token,
                ]);

                // Update token status
                $token->update([
                    'status' => 'pending',
                    'transaction_code' => $transaction->transaction_code,
                ]);
            }

            // $campaignTokens->each->delete();
        }
    }

    private static function changeCampaignStatus(Transaction $transaction, $status)
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

    public static function ajaxDatatableByAdmin()
    {
        $query = Transaction::orderBy('created_at', 'desc');
        return DatatableService::buildDatatable(
            $query,
            'auth.admin.transaction.action'
        );
    }


    public static function ajaxDatatableTransactionInProjectManagementByUser($campaign_id)
    {
        $query = Transaction::where('campaign_id', $campaign_id)->get()->sortByDesc('created_at');
        return DatatableService::buildDatatable(
            $query,
            'auth.user.project_management.transactionAction'
        );
    }

    // this function need to convert to blockchain
    public static function getTransactionByUserId()
    {
        return Transaction::where('from_to_user_id', auth()->user()->id)->latest()->get();
    }


    // this function need to convert to blockchain
    public static function getTransactionById($id)
    {
        return Transaction::find($id);
    }

    public static function getTransactionByCampaignId($campaign_id)
    {
        return Transaction::where('campaign_id', $campaign_id)->get();
    }

    // this function need to convert to blockchain
    public static function getTransactionByCode($code)
    {
        return Transaction::where('transaction_code', $code)->first();
    }
}

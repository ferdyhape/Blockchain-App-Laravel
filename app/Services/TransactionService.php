<?php

namespace App\Services;

use Ramsey\Uuid\Uuid;
use App\Models\Campaign;
use App\Models\Transaction;
use App\Models\CampaignToken;

/**
 * Class TransactionService.
 */
class TransactionService
{


    // this function need to convert to blockchain
    public static function changeStatus($id, $status)
    {
        $transaction = Transaction::find($id);
        $transaction->update([
            'status' => $status,
            'payment_status' => $status == 'success' ? 'paid' : 'failed',
        ]);

        self::changeCampaignStatus($transaction, $status);
    }

    // this function need to convert to blockchain
    public static function uploadPaymentProof($transactionCode, $proofOfPayment)
    {
        $transaction = self::getTransactionByCode($transactionCode);
        $filename = Uuid::uuid4()->toString() . '.' . $proofOfPayment->getClientOriginalExtension();
        $proofOfPayment->storeAs('payment_proof', $filename, 'public');
        $path = 'storage/payment_proof/' . $filename;

        $transaction->update([
            'payment_proof' => $path,
            'payment_status' => 'paid',
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
    private static function addTransactionDetail(Campaign $campaign, Transaction $transaction, $quantity)
    {
        for ($i = 1; $i <= $quantity; $i++) {

            // Generate token
            $generatedToken = null;
            do {
                $generatedToken = Uuid::uuid4()->toString();
            } while (CampaignToken::where('token', $generatedToken)->exists());

            // $transaction->campaignTokens()->create([
            //     'token' => $generatedToken,
            //     'status' => 'pending',
            //     'sold_to' => auth()->user()->id,
            //     'campaign_id' => $campaign->id,
            // ]);

            $campaign->campaignTokens()->create([
                'token' => $generatedToken,
                'status' => 'pending',
                'sold_to' => auth()->user()->id,
                'transaction_code' => $transaction->transaction_code,
            ]);

            // Create transaction detail
            $transaction->transactionDetails()->create([
                'price' => $campaign->price_per_unit,
                'token' => $generatedToken,
            ]);
        }
    }

    private static function changeCampaignStatus(Transaction $transaction, $status)
    {
        $campaignToken = CampaignToken::where('transaction_code', $transaction->transaction_code)->get();
        foreach ($campaignToken as $token) {
            $token->update([
                'status' => $status == 'success' ? 'sold' : 'available',
                'sold_to' => $status == 'success' ? $token->sold_to : null,
            ]);
        }

        // update campaign sold token amount on transaction success
        $campaignToken->first()->campaign()->update([
            'sold_token_amount' => $status == 'success' ? $campaignToken->first()->campaign->sold_token_amount + $campaignToken->count() : $campaignToken->first()->campaign->sold_token_amount,
        ]);
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

    // this function need to convert to blockchain
    public static function getTransactionByCode($code)
    {
        return Transaction::where('transaction_code', $code)->first();
    }
}

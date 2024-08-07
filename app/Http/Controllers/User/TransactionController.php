<?php

namespace App\Http\Controllers\User;

use APIHelper;
use Illuminate\Http\Request;
use App\Services\CampaignService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Requests\Admin\UploadPaymentProofRequest;

class TransactionController extends Controller
{
    public function uploadProof(UploadPaymentProofRequest $request, $code)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $transaction = TransactionService::uploadPaymentProof($code, $validated['payment_proof']);
            DB::commit();
            return redirect()->route('dashboard.user.transaction.show', $transaction->transaction_code)->with('success', 'Bukti pembayaran berhasil diunggah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function index()
    {
        $data = TransactionService::getTransactionByUserId(auth()->id());
        $transactions = APIHelper::encodeDecode($data);
        return view('auth.user.transaction.index', compact('transactions'));
    }

    public function show(string $code)
    {
        $transaction = TransactionService::getTransactionByCode($code);
        $price = CampaignService::getTokenPriceByCampaignId($transaction->campaign_id);
        $count = $transaction->quantity;
        return view('auth.user.transaction.show', compact('transaction', 'price', 'count'));
    }

    // public function changeStatus(Request $request, string $code)
    // {
    //     $request->validate([
    //         'status' => 'required|in:success,failed'
    //     ]);

    //     try {
    //         DB::beginTransaction();
    //         $transaction = TransactionService::getTransactionByCode($code);
    //         if ($transaction->payment_status == 'paidByCampaignBalance') {
    //             CampaignService::reduceWalletBalanceCampaign($code);
    //         }
    //         TransactionService::changeTransactionStatus($code, $request->status, $request->status == 'success' ? 'paid' : 'failed');
    //         DB::commit();
    //         return redirect()->back()->with('success', 'Transaction status has been changed');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Something went wrong');
    //     }
    // }
}

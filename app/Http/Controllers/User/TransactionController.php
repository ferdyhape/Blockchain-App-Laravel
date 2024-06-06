<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Services\PaymentMethodService;
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
        $transactions = TransactionService::getTransactionByUserId(auth()->id());
        return view('auth.user.transaction.index', compact('transactions'));
    }

    public function show(string $code)
    {
        $transaction = TransactionService::getTransactionByCode($code);
        $paymentMethodDetail = PaymentMethodService::getPaymentMethodDetailById($transaction->payment_method_detail_id);
        return view('auth.user.transaction.show', compact('transaction', 'paymentMethodDetail'));
    }
}

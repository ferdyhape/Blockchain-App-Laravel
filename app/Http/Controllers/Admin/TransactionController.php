<?php

namespace App\Http\Controllers\Admin;

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
            TransactionService::uploadPaymentProof($code, $validated['payment_proof'], true);
            DB::commit();
            return redirect()->back()->with('success', 'Payment proof has been uploaded');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function changeStatus(Request $request, string $code)
    {
        $request->validate([
            'status' => 'required|in:success,failed'
        ]);

        try {
            DB::beginTransaction();
            TransactionService::changeTransactionStatus($code, $request->status, $request->status == 'success' ? 'paid' : 'failed');
            DB::commit();
            return redirect()->back()->with('success', 'Transaction status has been changed');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function index()
    {
        if (request()->ajax()) {
            return TransactionService::ajaxDatatableByAdmin();
        }

        return view('auth.admin.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $transaction = TransactionService::getTransactionByCode($code);
        $paymentMethodDetail = PaymentMethodService::getPaymentMethodDetailById($transaction->payment_method_detail_id);
        return view('auth.admin.transaction.show', compact('transaction', 'paymentMethodDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

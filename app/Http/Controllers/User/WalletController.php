<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Services\JsonService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\WalletTransactionUser;
use App\Services\PaymentMethodService;
use App\Http\Requests\User\TopupWalletRequest;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // uploadProof
    public function uploadProof($id, Request $request)
    {
        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            WalletService::uploadPaymentProof($id, $validated['payment_proof']);
            return JsonService::response(['message' => 'Proof of payment uploaded successfully']);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Failed to upload proof of payment'], 500);
        }
    }

    public function index()
    {

        if (request()->ajax()) {
            return WalletService::ajaxDatatableByUser();
        }
        return view('auth.user.my_wallet.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentMethods = PaymentMethodService::getPaymentMethodForBuyToken();
        return view('auth.user.my_wallet.topup', compact('paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopupWalletRequest $request)
    {

        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $storeTopup = WalletService::storeWalletTransaction($validated, 'topup');
            DB::commit();
            return response()->json(
                [
                    'redirect' => route('dashboard.user.my-wallet.index'),
                    'message' => 'Topup request sent successfully'
                ],
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }

        return redirect()->route('dashboard.user.my-wallet.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

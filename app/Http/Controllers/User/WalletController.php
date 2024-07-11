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
use App\Http\Requests\Admin\StoreBankRequest;
use App\Http\Requests\User\WithdrawWalletTransactionUserRequest;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // postWithdraw
    public function postWithdraw(WithdrawWalletTransactionUserRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        try {
            DB::beginTransaction();
            WalletService::storeWalletTransaction($validated, 'withdraw');
            DB::commit();
            return redirect()->route('dashboard.user.my-wallet.index')->with('success', 'Withdraw request sent successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function postBankAccount(StoreBankRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        try {
            DB::beginTransaction();
            $validated['payment_method_category_id'] = PaymentMethodService::getPaymentMethodByName('Bank Transfer')->id;
            $validated['user_id'] = auth()->id();
            $validated['description'] = 'Nomor Rekening: ' . $validated['account_number'] . ' a/n ' . $validated['account_name'];
            PaymentMethodService::storePaymentMethodDetail($validated);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }

        return redirect()->route('dashboard.user.my-wallet.withdraw')->with('success', 'Bank account added successfully');
    }

    public function addBankAccount()
    {
        return view('auth.user.my_wallet.addBankAccount');
    }

    public function withdraw()
    {
        $wallets = PaymentMethodService::getUserWalletPaymentMethodDetailForUser();
        return view('auth.user.my_wallet.withdraw', compact('wallets'));
    }
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

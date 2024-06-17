<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreWalletRequest;
use App\Services\PaymentMethodService;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = PaymentMethodService::getUserWalletPaymentMethodDetailForUser();
        return view('auth.user.my_wallet.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.user.my_wallet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request)
    {
        // dd($request->all());

        $validated = $request->validated();

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

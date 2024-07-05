<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WalletTransactionUserController extends Controller
{
    public function acceptTopup(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|uuid|exists:wallet_transaction_users,id',
        ]);

        try {
            DB::beginTransaction();
            $data = WalletService::acceptWalletTransaction($validated['id']);
            DB::commit();
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to accept topup'], 500);
        }
    }

    public function rejectTopup(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|uuid|exists:wallet_transaction_users,id',
        ]);

        try {
            DB::beginTransaction();
            $data = WalletService::rejectWalletTransaction($validated['id']);
            DB::commit();
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to reject topup'], 500);
        }
    }

    public function index()
    {
        if (request()->ajax()) {
            return WalletService::ajaxDatatableByAdmin();
        }

        return view('auth.admin.wallet_transaction.index');
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

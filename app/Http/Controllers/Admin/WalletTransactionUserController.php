<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\JsonService;

class WalletTransactionUserController extends Controller
{

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

    public function accept(Request $request)
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

    public function reject(Request $request)
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

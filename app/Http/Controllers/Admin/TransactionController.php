<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function changeStatus(Request $request, string $id)
    {
        DB::beginTransaction();
        TransactionService::changeStatus($id, $request->status);
        DB::commit();
        return redirect()->back()->with('success', 'Transaction status has been changed');
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
    public function show(string $id)
    {
        $transaction = TransactionService::getTransactionById($id);
        return view('auth.admin.transaction.show', compact('transaction'));
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

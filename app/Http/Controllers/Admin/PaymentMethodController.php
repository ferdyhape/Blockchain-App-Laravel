<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\JsonService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodService;
use App\Http\Requests\Admin\StorePaymentMethodRequest;
use App\Http\Requests\Admin\UpdatePaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return PaymentMethodService::ajaxDatatableByAdmin();
        }

        $paymentMethodCategories = PaymentMethodService::getPaymentMethod();
        return view('auth.admin.payment_method.index', compact('paymentMethodCategories'));
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
    public function store(StorePaymentMethodRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            PaymentMethodService::storePaymentMethodDetail($validated);
            DB::commit();
            return JsonService::response(['message' => 'Data created successfully']);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data not found'], 404);
        }
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
        try {
            $data = PaymentMethodService::getPaymentMethodById($id);
            return JsonService::editData($data);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $paymentMethodDetail = PaymentMethodService::updatePaymentMethodDetail($id, $validated);
            $paymentMethodDetail->update($validated);
            return JsonService::response(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = PaymentMethodService::getPaymentMethodDetailById($id);
        try {
            $data->clearMediaCollection('payment_method_logo');
            $data->delete();
            return JsonService::response(['message' => 'Data deleted successfully']);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data not found'], 404);
        }
    }
}

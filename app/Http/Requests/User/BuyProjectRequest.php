<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class BuyProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|numeric',
            'campaign_id' => 'required|string|exists:campaigns,id',
            // 'payment_method_detail_id' => 'required|string|exists:payment_method_details,id',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Kolom jumlah harus diisi',
            'quantity.numeric' => 'Kolom jumlah harus berupa angka',
            'campaign_id.required' => 'Kolom campaign id harus diisi',
            'campaign_id.string' => 'Kolom campaign id harus berupa string',
            'campaign_id.exists' => 'Campaign id tidak ditemukan',
            // 'payment_method_detail_id.required' => 'Kolom payment method detail id harus diisi',
            // 'payment_method_detail_id.string' => 'Kolom payment method detail id harus berupa string',
            // 'payment_method_detail_id.exists' => 'Payment method detail id tidak ditemukan',
        ];
    }
}

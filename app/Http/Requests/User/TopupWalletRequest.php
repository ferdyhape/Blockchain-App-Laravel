<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class TopupWalletRequest extends FormRequest
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
            'amount' => 'required|numeric|min:100000',
            'payment_method_detail_id' => 'required|exists:payment_method_details,id',
        ];
    }


    public function messages(): array
    {
        return [
            'amount.required' => 'Kolom jumlah harus diisi',
            'amount.numeric' => 'Kolom jumlah harus berupa angka',
            'payment_method_detail_id.required' => 'Pilih metode pembayaran terlebih dahulu',
            'payment_method_detail_id.exists' => 'Metode pembayaran tidak ditemukan',
            'amount.min' => 'Minimal top up Rp 100.000',
        ];
    }
}

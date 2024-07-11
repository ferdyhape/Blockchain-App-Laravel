<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SellTokenRequest extends FormRequest
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
            // 'payment_method_detail_id' => 'required|exists:payment_method_details,id',
            'quantity' => 'required|numeric|min:1',
        ];
    }


    public function messages(): array
    {
        return [
            'payment_method_detail_id.required' => 'Pilih metode pembayaran terlebih dahulu',
            'payment_method_detail_id.exists' => 'Metode pembayaran tidak ditemukan',
            // 'quantity.required' => 'Masukkan jumlah token yang ingin dibeli',
            // 'quantity.numeric' => 'Jumlah token harus berupa angka',
            // 'quantity.min' => 'Jumlah token minimal 1',
        ];
    }
}

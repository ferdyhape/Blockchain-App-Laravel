<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApproveComitteeRequest extends FormRequest
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
            'approved_amount' => 'required|numeric',
            // 'offered_token_amount' => 'required|numeric',
            // 'price_per_unit' => 'required|numeric',
            'minimum_purchase' => 'required|numeric',
            'maximum_purchase' => 'required|numeric'
        ];
    }


    public function messages(): array
    {
        return [
            'approved_amount.required' => 'Jumlah disetujui wajib diisi',
            'approved_amount.numeric' => 'Jumlah disetujui harus berupa angka',
            'offered_token_amount.required' => 'Jumlah token yang ditawarkan wajib diisi',
            'offered_token_amount.numeric' => 'Jumlah token yang ditawarkan harus berupa angka',
            'minimum_purchase.required' => 'Pembelian minimum wajib diisi',
            'minimum_purchase.numeric' => 'Pembelian minimum harus berupa angka',
            'maximum_purchase.required' => 'Pembelian maksimum wajib diisi',
            'maximum_purchase.numeric' => 'Pembelian maksimum harus berupa angka',
        ];
    }
}

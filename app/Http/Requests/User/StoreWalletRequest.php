<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreWalletRequest extends FormRequest
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
            'bank_name' => 'required|string',
            'account_number' => 'required|numeric',
            'account_name' => 'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'bank_name.required' => 'Nama Bank wajib dipilih',
            'account_number.required' => 'Nomor Rekening wajib diisi',
            'account_number.numeric' => 'Nomor Rekening harus berupa angka',
            'account_name.required' => 'Nama Pemilik Rekening wajib diisi',
            'account_name.string' => 'Nama Pemilik Rekening harus berupa huruf',
        ];
    }
}

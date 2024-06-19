<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PayForSaleTokenRequest extends FormRequest
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
            'payment_method' => 'in:wallet,transfer',
            'payment_proof' => 'nullable|required_if:payment_method,transfer|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    // message using bahasa indonesia

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'payment_method.in' => 'Metode pembayaran tidak valid',
            'payment_proof.required_if' => 'Bukti pembayaran harus diisi',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar',
            'payment_proof.mimes' => 'Bukti pembayaran harus berupa gambar dengan format: jpeg, png, jpg, gif, svg',
            'payment_proof.max' => 'Bukti pembayaran maksimal 2MB'
        ];
    }
}

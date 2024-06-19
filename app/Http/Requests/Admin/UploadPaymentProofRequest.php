<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UploadPaymentProofRequest extends FormRequest
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
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg']
        ];
    }

    public function messages(): array
    {
        return [
            'proof.required' => 'Kolom bukti pembayaran harus diisi',
            'proof.image' => 'Kolom bukti pembayaran harus berupa gambar',
            'proof.mimes' => 'Kolom bukti pembayaran harus berupa file: jpeg, png, jpg'
        ];
    }
}

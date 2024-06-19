<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PreviewTransactionRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Kolom jumlah harus diisi',
            'quantity.numeric' => 'Kolom jumlah harus berupa angka',
        ];
    }
}

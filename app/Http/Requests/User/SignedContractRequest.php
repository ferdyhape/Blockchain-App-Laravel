<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SignedContractRequest extends FormRequest
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
            'signed_contract' => 'required|mimes:pdf|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'signed_contract.required' => 'Kontrak yang ditandatangani wajib diunggah',
            'signed_contract.mimes' => 'Kontrak yang ditandatangani harus berupa file PDF',
            'signed_contract.max' => 'Ukuran kontrak yang ditandatangani maksimal 2MB'
        ];
    }
}

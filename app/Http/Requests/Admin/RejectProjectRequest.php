<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RejectProjectRequest extends FormRequest
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
            'rejection_note' => ['required', 'string'],
        ];
    }


    public function messages(): array
    {
        return [
            'rejection_note.required' => 'Catatan penolakan wajib diisi',
            'rejection_note.string' => 'Catatan penolakan harus berupa teks',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RejectComitteeRequest extends FormRequest
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
            'rejection_comittee_note' => ['required', 'string'],
        ];
    }


    public function messages(): array
    {
        return [
            'rejection_comittee_note.required' => 'Catatan penolakan komite wajib diisi',
            'rejection_comittee_note.string' => 'Catatan penolakan komite harus berupa teks',
        ];
    }
}

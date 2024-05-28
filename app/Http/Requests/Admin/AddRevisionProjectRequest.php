<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddRevisionProjectRequest extends FormRequest
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
            'revision_note' => ['required', 'string'],
        ];
    }


    public function messages(): array
    {
        return [
            'revision_note.required' => 'Catatan revisi wajib diisi',
            'revision_note.string' => 'Catatan revisi harus berupa teks',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
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
            'name' => 'required|unique:payment_method_details,name',
            'description' => 'required',
            'payment_method_category_id' => 'required|exists:payment_methods,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'name.unique' => 'Nama sudah digunakan',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'payment_method_category_id.required' => 'Kategori tidak boleh kosong',
            'payment_method_category_id.exists' => 'Kategori tidak ditemukan',
        ];
    }
}

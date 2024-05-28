<?php

namespace App\Http\Requests\Admin;

use App\Services\AdminUserManagementService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $this->route('user_management'),
            'phone' => 'required|unique:users,phone,' . $this->route('user_management'),
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'subdistrict_id' => 'required',
            'address_detail' => 'required',
            'number_id' => 'required|max:16|unique:users,number_id,' . $this->route('user_management'),
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus berupa alamat email yang valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal',
            'place_of_birth.required' => 'Tempat lahir wajib diisi',
            'province_id.required' => 'Provinsi wajib diisi',
            'city_id.required' => 'Kota wajib diisi',
            'subdistrict_id.required' => 'Kecamatan wajib diisi',
            'address_detail.required' => 'Alamat wajib diisi',
            'number_id.required' => 'Nomor identitas wajib diisi',
            'number_id.max' => 'Nomor identitas maksimal 16 karakter',
            'number_id.unique' => 'Nomor identitas sudah terdaftar',
        ];
    }
}

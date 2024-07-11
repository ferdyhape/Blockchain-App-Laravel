<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return  [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'subdistrict_id' => 'required',
            'address_detail' => 'required',
            'number_id' => 'required|max:16|unique:users,number_id', // as default, using size:16
            'password' => 'required|confirmed',
        ];
    }

    // add validation message using bahasa indonesia
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'date_of_birth.required' => 'Tanggal lahir harus diisi',
            'date_of_birth.date' => 'Tanggal lahir tidak valid',
            'place_of_birth.required' => 'Tempat lahir harus diisi',
            'province_id.required' => 'Provinsi harus diisi',
            'city_id.required' => 'Kota harus diisi',
            'subdistrict_id.required' => 'Kecamatan harus diisi',
            'address_detail.required' => 'Alamat harus diisi',
            'number_id.required' => 'Nomor identitas harus diisi',
            'number_id.max' => 'Nomor identitas tidak valid',
            'number_id.unique' => 'Nomor identitas sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ];
    }
}

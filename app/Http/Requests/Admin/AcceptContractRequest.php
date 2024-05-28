<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AcceptContractRequest extends FormRequest
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
            'fundraising_period_start' => 'required|date|before:fundraising_period_end',
            'fundraising_period_end' => 'required|date|after:fundraising_period_start',
        ];
    }

    // make message using bahasa indonesia
    public function messages(): array
    {
        return [
            'fundraising_period_start.required' => 'Tanggal mulai periode penggalangan dana wajib diisi',
            'fundraising_period_start.date' => 'Tanggal mulai periode penggalangan dana harus berupa tanggal',
            'fundraising_period_start.before' => 'Tanggal mulai periode penggalangan dana harus sebelum tanggal akhir periode penggalangan dana',
            'fundraising_period_end.required' => 'Tanggal akhir periode penggalangan dana wajib diisi',
            'fundraising_period_end.date' => 'Tanggal akhir periode penggalangan dana harus berupa tanggal',
            'fundraising_period_end.after' => 'Tanggal akhir periode penggalangan dana harus setelah tanggal mulai periode penggalangan dana',
        ];
    }
}

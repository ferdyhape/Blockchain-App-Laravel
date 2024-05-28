<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ReviseProjectRequest extends FormRequest
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
        // dokumen pendukung akan dihandle media library
        // brosur katalog product akan di handle media library
        return [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'project_category_id' => ['required', 'string', 'exists:project_categories,id'],
            'nominal_required' => ['required', 'numeric'],
            'description_of_use_of_funds' => ['required', 'string'],
            'collateral_assets' => ['required', 'string', 'max:150'],
            'collateral_value' => ['required', 'numeric'],
            'business_location_province_id' => ['required', 'string'],
            'business_location_city_id' => ['required', 'string'],
            'business_location_subdistrict_id' => ['required', 'string'],
            'details_of_business_location' => ['required', 'string', 'max:200'],
            'income_per_month' => ['required', 'numeric'],
            'projected_revenue_per_month' => ['required', 'string'],
            'expenses_per_month' => ['required', 'numeric'],
            'projected_monthly_expenses' => ['required', 'string'],
            'income_statement_upload_every' => ['required', 'integer'],
            'description_of_profit_sharing' => ['required', 'string'],
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi',
            'title.string' => 'Judul harus berupa teks',
            'title.max' => 'Judul maksimal 100 karakter',
            'description.required' => 'Deskripsi wajib diisi',
            'description.string' => 'Deskripsi harus berupa teks',
            'project_category_id.required' => 'Kategori proyek wajib diisi',
            'project_category_id.string' => 'Kategori proyek harus berupa teks',
            'project_category_id.exists' => 'Kategori proyek tidak valid',
            'nominal_required.required' => 'Nominal yang dibutuhkan wajib diisi',
            'nominal_required.numeric' => 'Nominal yang dibutuhkan harus berupa angka',
            'description_of_use_of_funds.required' => 'Deskripsi penggunaan dana wajib diisi',
            'description_of_use_of_funds.string' => 'Deskripsi penggunaan dana harus berupa teks',
            'collateral_assets.required' => 'Aset jaminan wajib diisi',
            'collateral_assets.string' => 'Aset jaminan harus berupa teks',
            'collateral_assets.max' => 'Aset jaminan maksimal 150 karakter',
            'collateral_value.required' => 'Nilai aset jaminan wajib diisi',
            'collateral_value.numeric' => 'Nilai aset jaminan harus berupa angka',
            'business_location_province_id.required' => 'Provinsi lokasi usaha wajib diisi',
            'business_location_city_id.required' => 'Kota lokasi usaha wajib diisi',
            'business_location_subdistrict_id.required' => 'Kecamatan lokasi usaha wajib diisi',
            'details_of_business_location.required' => 'Detail lokasi usaha wajib diisi',
            'details_of_business_location.string' => 'Detail lokasi usaha harus berupa teks',
            'details_of_business_location.max' => 'Detail lokasi usaha maksimal 200 karakter',
            'income_per_month.required' => 'Pendapatan per bulan wajib diisi',
            'income_per_month.numeric' => 'Pendapatan per bulan harus berupa angka',
            'projected_revenue_per_month.required' => 'Perkiraan pendapatan per bulan wajib diisi',
            'expenses_per_month.required' => 'Pengeluaran per bulan wajib diisi',
            'expenses_per_month.numeric' => 'Pengeluaran per bulan harus berupa angka',
            'projected_monthly_expenses.required' => 'Perkiraan pengeluaran per bulan wajib diisi',
            'projected_monthly_expenses.string' => 'Perkiraan pengeluaran per bulan harus berupa teks',
            'income_statement_upload_every.required' => 'Laporan laba rugi wajib diisi',
            'income_statement_upload_every.integer' => 'Laporan laba rugi harus berupa angka',
            'description_of_profit_sharing.required' => 'Deskripsi bagi hasil wajib diisi',
            'description_of_profit_sharing.string' => 'Deskripsi bagi hasil harus berupa teks',
        ];
    }
}

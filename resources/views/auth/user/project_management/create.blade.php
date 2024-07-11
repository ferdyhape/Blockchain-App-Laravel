@component('components.containerTemplate', [
    'pageTitle' => 'Create Project',
])

    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Project', 'Create Project']" />

        {{-- content --}}
        @component('components.contentSection')
            @slot('contentOfContentSection')
                <form action="{{ route('dashboard.user.project-management.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <x-input type="text" label="Judul Proyek" name="title" required="true" id="title" placeholder="Judul Proyek" />

                    {{-- projectCategories --}}
                    <x-input type="select" label="Kategori Proyek" name="project_category_id" required="true" id="project_category_id">
                        <option selected disabled>-- Pilih Kategori Proyek --</option>
                        @foreach ($projectCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-input>

                    <x-input label="Deskripsi Proyek" name="description" id="description" type="textarea"
                        placeholder="Deskripsi proyek" />

                    <x-input type="file" label="Dokumen Pendukung" name="supporting_documents[]" required="true"
                        id="supporting_documents" placeholder="Dokumen Pendukung" multiple />

                    <x-input type="number" label="Nominal yang Dibutuhkan" name="nominal_required" required="true"
                        id="nominal_required" placeholder="Nominal yang Dibutuhkan" />

                    <x-input label="Deskripsi Penggunaan Dana" name="description_of_use_of_funds" id="description_of_use_of_funds"
                        type="textarea" placeholder="Deskripsi Penggunaan Dana" />

                    <x-input type="text" label="Aset Jaminan" name="collateral_assets" required="true" id="collateral_assets"
                        placeholder="Aset Jaminan" />

                    <x-input type="number" label="Nilai Jaminan" name="collateral_value" required="true" id="collateral_value"
                        placeholder="Nilai Jaminan" />

                    <x-input type="select" label="Provinsi" name="business_location_province_id" required="true"
                        id="business_location_province_id">
                        <option selected disabled>-- Pilih Provinsi --</option>
                        <option value="1">Jawa Barat</option>
                        <option value="2">Jawa Tengah</option>
                        <option value="3">Jawa Timur</option>
                    </x-input>

                    <x-input type="select" label="Kota/Kabupaten" name="business_location_city_id" required="true"
                        id="business_location_city_id">
                        <option selected disabled>-- Pilih Kota/Kabupaten --</option>
                        <option value="1">Bandung</option>
                        <option value="2">Bekasi</option>
                        <option value="3">Bogor</option>
                    </x-input>


                    <x-input type="select" label="Kecamatan" name="business_location_subdistrict_id" required="true"
                        id="business_location_subdistrict_id">
                        <option selected disabled>-- Pilih Kecamatan --</option>
                        <option value="1">Cibiru</option>
                        <option value="2">Cikarang</option>
                        <option value="3">Cileungsi</option>
                    </x-input>

                    <x-input type="text" label="Detail Alamat" name="details_of_business_location" required="true"
                        id="details_of_business_location" placeholder="Detail Alamat" />

                    <x-input type="number" label="Penghasilan per Bulan" name="income_per_month" required="true" id="income_per_month"
                        placeholder="Penghasilan per Bulan" />

                    <x-input label="Proyeksi Pendapatan per Bulan" name="projected_revenue_per_month" id="projected_revenue_per_month"
                        type="textarea" placeholder="Proyeksi Pendapatan per Bulan" />

                    <x-input type="number" label="Pengeluaran per Bulan" name="expenses_per_month" required="true"
                        id="expenses_per_month" placeholder="Pengeluaran per Bulan" />

                    <x-input label="Proyeksi Pengeluaran per Bulan" name="projected_monthly_expenses" id="projected_monthly_expenses"
                        type="textarea" placeholder="Proyeksi Pengeluaran per Bulan" />

                    <x-input type="select" label="Upload Laporan Keuangan Setiap (bulan)" name="income_statement_upload_every"
                        required="true" id="income_statement_upload_every">
                        <option value="3">3 bulan</option>
                        <option value="6">6 bulan</option>
                        <option value="12">12 bulan</option>
                    </x-input>

                    <x-input label="Deskripsi Bagi Hasil" name="description_of_profit_sharing" id="description_of_profit_sharing"
                        type="textarea" placeholder="Deskripsi Bagi Hasil" />


                    {{-- input for profit_sharing_percentage  --}}
                    <x-input type="number" label="Persentase Bagi Hasil" name="profit_sharing_percentage" required="true"
                        id="profit_sharing_percentage" placeholder="Persentase Bagi Hasil (Dalam Persen)" />

                    <x-input type="file" label="Katalog Produk" name="product_catalog[]" required="true" id="product_catalog"
                        placeholder="Katalog Produk" multiple />


                    <button type="submit" class="btn btn-primary mb-5 w-100">Submit</button>
                </form>
            @endslot
        @endcomponent
    @endslot

    @if ($errors->any())
        @push('custom-scripts')
            <script>
                @foreach ($errors->all() as $error)
                    showAlert('{{ $error }}', "error");
                @endforeach
            </script>
        @endpush
    @endif

@endcomponent

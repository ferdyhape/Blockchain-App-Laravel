@component('components.containerTemplate', [
    'pageTitle' => 'Revise Project',
])
    @slot('contentOfContainer')
        <x-headerSection breadcrumbMenu="User Project Management" breadcrumbCurrent="Revise Project" />

        {{-- content --}}
        @component('components.contentSection')
            @slot('contentOfContentSection')
                <form action="{{ route('dashboard.user.project-management.revise.post', $project->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <x-input type="text" label="Judul Proyek" name="title" required="true" id="title" placeholder="Judul Proyek"
                        value="{{ $project->title ?? '' }}" />

                    {{-- projectCategories --}}
                    <x-input type="select" label="Kategori Proyek" name="project_category_id" required="true" id="project_category_id">
                        <option selected disabled>-- Pilih Kategori Proyek --</option>
                        @foreach ($projectCategories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == ($project->project_category_id ?? '') ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-input>

                    <x-input label="Deskripsi Proyek" name="description" id="description" type="textarea" placeholder="Deskripsi proyek"
                        value="{!! $project->description ?? '' !!}" />

                    <x-input type="file" label="Dokumen Pendukung" name="supporting_documents[]" id="supporting_documents"
                        placeholder="Dokumen Pendukung" multiple />

                    <x-input type="number" label="Nominal yang Dibutuhkan" name="nominal_required" required="true"
                        id="nominal_required" placeholder="Nominal yang Dibutuhkan" value="{{ $project->nominal_required ?? '' }}" />

                    <x-input label="Deskripsi Penggunaan Dana" name="description_of_use_of_funds" id="description_of_use_of_funds"
                        type="textarea" placeholder="Deskripsi Penggunaan Dana" value="{!! $project->description_of_use_of_funds ?? '' !!}" />

                    <x-input type="text" label="Aset Jaminan" name="collateral_assets" required="true" id="collateral_assets"
                        placeholder="Aset Jaminan" value="{{ $project->collateral_assets ?? '' }}" />

                    <x-input type="number" label="Nilai Jaminan" name="collateral_value" required="true" id="collateral_value"
                        placeholder="Nilai Jaminan" value="{{ $project->collateral_value ?? '' }}" />

                    <x-input type="select" label="Provinsi" name="business_location_province_id" required="true"
                        id="business_location_province_id">
                        <option selected disabled>-- Pilih Provinsi --</option>
                        <option value="1" {{ $project->business_location_province_id == 1 ? 'selected' : '' }}>Jawa Barat</option>
                        <option value="2" {{ $project->business_location_province_id == 2 ? 'selected' : '' }}>Jawa Tengah
                        </option>
                        <option value="3" {{ $project->business_location_province_id == 3 ? 'selected' : '' }}>Jawa Timur</option>
                    </x-input>

                    <x-input type="select" label="Kota/Kabupaten" name="business_location_city_id" required="true"
                        id="business_location_city_id">
                        <option selected disabled>-- Pilih Kota/Kabupaten --</option>
                        <option value="1" {{ $project->business_location_city_id == 1 ? 'selected' : '' }}>Bandung</option>
                        <option value="2" {{ $project->business_location_city_id == 2 ? 'selected' : '' }}>Bekasi</option>
                        <option value="3" {{ $project->business_location_city_id == 3 ? 'selected' : '' }}>Bogor</option>
                    </x-input>

                    <x-input type="select" label="Kecamatan" name="business_location_subdistrict_id" required="true"
                        id="business_location_subdistrict_id">
                        <option selected disabled>-- Pilih Kecamatan --</option>
                        <option value="1" {{ $project->business_location_subdistrict_id == 1 ? 'selected' : '' }}>Cibiru</option>
                        <option value="2" {{ $project->business_location_subdistrict_id == 2 ? 'selected' : '' }}>Cikarang
                        </option>
                        <option value="3" {{ $project->business_location_subdistrict_id == 3 ? 'selected' : '' }}>Cileungsi
                        </option>
                    </x-input>

                    <x-input type="text" label="Detail Alamat" name="details_of_business_location" required="true"
                        id="details_of_business_location" placeholder="Detail Alamat"
                        value="{{ $project->details_of_business_location ?? '' }}" />

                    <x-input type="number" label="Penghasilan per Bulan" name="income_per_month" required="true" id="income_per_month"
                        placeholder="Penghasilan per Bulan" value="{{ $project->income_per_month ?? '' }}" />

                    <x-input label="Proyeksi Pendapatan per Bulan" name="projected_revenue_per_month" id="projected_revenue_per_month"
                        type="textarea" placeholder="Proyeksi Pendapatan per Bulan" value="{!! $project->projected_revenue_per_month ?? '' !!}" />

                    <x-input type="number" label="Pengeluaran per Bulan" name="expenses_per_month" required="true"
                        id="expenses_per_month" placeholder="Pengeluaran per Bulan"
                        value="{{ $project->expenses_per_month ?? '' }}" />

                    <x-input label="Proyeksi Pengeluaran per Bulan" name="projected_monthly_expenses" id="projected_monthly_expenses"
                        type="textarea" placeholder="Proyeksi Pengeluaran per Bulan" value="{!! $project->projected_monthly_expenses ?? '' !!}" />

                    <x-input type="select" label="Upload Laporan Keuangan Setiap (bulan)" name="income_statement_upload_every"
                        required="true" id="income_statement_upload_every">
                        <option value="3" {{ $project->income_statement_upload_every == 3 ? 'selected' : '' }}>3 bulan</option>
                        <option value="6" {{ $project->income_statement_upload_every == 6 ? 'selected' : '' }}>6 bulan</option>
                        <option value="12" {{ $project->income_statement_upload_every == 12 ? 'selected' : '' }}>12 bulan</option>
                    </x-input>

                    <x-input label="Deskripsi Bagi Hasil" name="description_of_profit_sharing" id="description_of_profit_sharing"
                        type="textarea" placeholder="Deskripsi Bagi Hasil" value="{!! $project->description_of_profit_sharing ?? '' !!}" />

                    <x-input type="file" label="Katalog Produk" name="product_catalog[]" id="product_catalog"
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

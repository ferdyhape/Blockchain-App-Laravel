@component('components.containerTemplate', [
    'pageTitle' => 'Upload Kontrak',
])
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Project', 'Upload Signed Contract']" />

        {{-- content --}}
        @component('components.contentSection')
            @slot('contentOfContentSection')
                <div class="card-content border p-4 rounded ">
                    {{-- <h5 class="card-title fw-semibold fs-5">{{ $project->title }}</h5>
                    <h5 class="text-secondary fs-6">{{ $project->user->name }}</h5> --}}
                    <div class="my-4">
                        <table class="w-100" style="">
                            <tr>
                                <td class="text-start text-secondary">
                                    Nama Proyek
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $project->title }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Proyek Owner
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $project->user->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Proyek Kategori
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $project->category->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Nominal Disetujui
                                </td>
                                <td class="text-start fw-semibold currency">
                                    {{ $project->campaign->approved_amount }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Jumlah Koin Ditawarkan
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $project->campaign->offered_token_amount }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Harga Per Unit
                                </td>
                                <td class="text-start fw-semibold currency">
                                    {{ $project->campaign->price_per_unit }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Minimal Beli
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $project->campaign->minimum_purchase }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Maksimal Beli
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $project->campaign->maximum_purchase }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="my-4">
                    <div class="fw-bold">
                        Project anda sudah memasuki tahap tanda tangan kontrak, mohon unduh dokumen kontrak anda <a
                            href="#">disini</a>
                        dan kemudian upload
                        pada form dibawah ini
                    </div>
                </div>
                <form action="{{ route('dashboard.user.project-management.upload-signed-contract.post', $project->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <x-input type="file" label="Upload Kontrak" name="signed_contract" id="signed_contract" required="true" />

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

@component('components.containerTemplate', [
    'pageTitle' => 'Upload Kontrak',
])
    @slot('contentOfContainer')
        <x-headerSection breadcrumbMenu="User Project Management" breadcrumbCurrent="Revise Project" />

        {{-- content --}}
        @component('components.contentSection')
            @slot('contentOfContentSection')
                <div class="card-content border p-4 rounded ">
                    <h5 class="card-title fw-semibold fs-5">{{ $project->title }}</h5>
                    <h5 class="text-secondary fs-6">{{ $project->user->name }}</h5>
                    <div class="my-4">
                        <table class="w-100">
                            <tr>
                                <td class="text-start text-secondary">
                                    Target Dana
                                </td>
                                <td class="text-end currency">
                                    {{ $project->nominal_required }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Aset Jaminan
                                </td>
                                <td class="text-end">
                                    {{ $project->collateral_assets }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Nominal Jaminan
                                </td>
                                <td class="text-end currency">
                                    {{ $project->collateral_value }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr>

                    <div class="my-4">
                        <h5 class="fs-5">Model dan Rencana Bisnis</h5>
                        <table class="w-100">
                            <tr>
                                <td class="text-start text-secondary">
                                    Pendapatan/bulan
                                </td>
                                <td class="text-end currency">
                                    {{ $project->income_per_month }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Pengeluaran/bulan
                                </td>
                                <td class="text-end currency">
                                    {{ $project->expenses_per_month }}
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

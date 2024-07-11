<x-containerTemplate pageTitle="Token">

    <x-slot name="contentOfContainer">

        <x-headerSection :breadcrumbMenu="['Token']">
            @slot('headerContent')
                <div class="d-flex gap-2 align-items-center">
                    <div class="my-auto">
                        <select class="form-select my-auto form-select-sm" aria-label="Default select example">
                            <option value="1">All</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            @endslot
        </x-headerSection>

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="row">
                    @foreach ($campaigns as $campaign)
                        <div class="col-md-12 col-lg-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header fw-semibold">
                                    {{ $campaign->project->title }}
                                </div>
                                <div class="card-body">
                                    <table class="w-100">
                                        <tr>
                                            <td class="text-start text-secondary">
                                                Jumlah Token Dimiliki
                                            </td>
                                            <td class="text-end">
                                                {{ count($campaign->tokens) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-start text-secondary">
                                                Nilai Rupiah
                                            </td>
                                            <td class="text-end currency">
                                                {{ count($campaign->tokens) * $campaign->price_per_unit }}
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('dashboard.user.token.show', $campaign->id) }}"
                                            class="btn btn-primary btn-sm mt-3">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    </x-slot>

</x-containerTemplate>

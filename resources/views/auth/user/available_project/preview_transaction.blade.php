<x-containerTemplate pageTitle="Preview Transaction">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project', 'Buy Project', 'Preview Transaction']" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <h5 class="fw-semibold">Detail Transaksi</h5>
                <div class="card border-0 shadow-sm p-4 my-3">
                    <div class="card-content rounded">
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
                                    Jumlah Koin Dibeli
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $quantityBuy }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Total Harga
                                </td>
                                <td class="text-start fw-semibold currency">
                                    {{ $totalPrice }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


                <button id="next-button-buy" class="btn btn-primary w-100">
                    Lanjutkan Pembayaran
                </button>

                <style>
                    label {
                        width: 100%;
                    }

                    .card-input-element {
                        display: none;
                    }

                    .card-input:hover {
                        cursor: pointer;
                    }

                    .card-input-element:checked+.card-input {
                        box-shadow: 0 0 2px 2px #2ecc71;
                    }
                </style>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />

        @push('custom-scripts')
            <script>
                let getPaymentMethodDetailUrl = "{{ route('get-payment-methods-details-for-buy-token') }}";
                let campaignId = "{{ $project->campaign->id }}";
                let quantityBuy = "{{ $quantityBuy }}";
                let routeBuyProject = "{{ route('dashboard.user.available-project.buy.post') }}";
            </script>

            <script src="{{ asset('assets/js/dashboard/user/available_project/preview_transaction.js') }}"></script>
        @endpush

    @endslot
</x-containerTemplate>

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

                <div class="my-5" id="payment-methods">
                    <h5 class="fw-semibold">Pilih Metode Pembayaran</h5>
                    <div class="d-flex my-3 gap-2">
                        @foreach ($paymentMethods as $paymentMethod)
                            <div class="col-md-4 col-lg-3 col-sm-6">
                                <label>
                                    <input type="radio" name="paymentMethod" value="{{ $paymentMethod->id }}"
                                        class="card-input-element" />
                                    <div class="card card-default text-center p-2 card-input dashed-border border">
                                        {{ $paymentMethod->name }}
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- this div will deisplay detail if detail exist on paymentMethod->details --}}
                    <div class="accordion my-3" id="paymentMethodDetailAccordion">
                        <!-- Accordion content will be injected here -->
                    </div>
                </div>

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

        @include('components.errorAlertValidation')
        @include('components.ifSuccessAlert')

        @push('custom-scripts')
            <script>
                let getPaymentMethodDetailUrl = "{{ route('get-payment-methods-details') }}";
                let campaignId = "{{ $project->campaign->id }}";
                let quantityBuy = "{{ $quantityBuy }}";
                let routeBuyProject = "{{ route('dashboard.user.available-project.buy.post') }}";
            </script>

            <script src="{{ asset('assets/js/dashboard/user/available_project/preview_transaction.js') }}"></script>
        @endpush

    @endslot
</x-containerTemplate>

<x-containerTemplate pageTitle="Show Transaction">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Transaction', 'Show Transaction']" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="d-flex flex-column gap-3">
                    <div id="detail-transaction">
                        <h5 class="fw-semibold">Detail Transaksi</h5>
                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="card-content rounded">
                                <table class="w-100" style="">
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Judul Proyek
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->campaign_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Status
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->status }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Tipe Order
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->order_type }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Harga Per Token
                                        </td>
                                        <td class="text-end fw-semibold currency">
                                            {{ $campaign->price_per_unit }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Total pembelian
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->quantity }} Token
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Total yang harus dibayar
                                        </td>
                                        <td class="text-end fw-semibold currency">
                                            {{ $transaction->total_price }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />

        @push('custom-scripts')
            <script>
                $(document).ready(function() {
                    $('#payment_method').change(function() {
                        var paymentMethod = $(this).val();
                        if (paymentMethod == 'wallet') {
                            $('#wallet-balance-id').show();
                            $('#bank-transfer-id').hide();
                            $('#payment_proof').attr('required', false);
                        } else {
                            $('#wallet-balance-id').hide();
                            $('#bank-transfer-id').show();
                            $('#payment_proof').attr('required', true);
                        }
                    });
                });
            </script>
        @endpush
    @endslot
</x-containerTemplate>

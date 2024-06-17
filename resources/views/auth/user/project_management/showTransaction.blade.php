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
                                            {{ $transaction->transactionDetails->first()->price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Total pembelian
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->transactionDetails->count() }} Token
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

                    <div id="account-number">
                        <h5 class="fw-semibold">Tujuan</h5>
                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="card-content rounded">
                                @if ($transaction->order_type == 'sell')
                                    <div class="">
                                        Nama Bank: <span class="fw-semibold">{{ $paymentMethodDetail->name }}</span>
                                    </div>
                                    <div class="">
                                        <span class="fw-semibold">{!! $paymentMethodDetail->description !!}</span>
                                    </div>
                                @else
                                    <div class="">
                                        <span class="fw-semibold">{!! $paymentMethodDetail->description !!}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($transaction->payment_proof)
                        <div id="payment-proof">
                            <h5 class="fw-semibold">Bukti Pembayaran</h5>

                            <div class="card border-0 shadow-sm p-4 my-3">
                                <div class="card-content rounded">
                                    @if ($transaction->status == 'pending')
                                        <div class="mb-3">
                                            Note: <span class="text-danger">Pembayaran akan diverifikasi oleh penjual</span>
                                        </div>
                                    @endif
                                    <img src="{{ asset($transaction->payment_proof) }}" alt="Payment Proof" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($transaction->order_type == 'sell')
                        @if ($transaction->status == 'pending' && $transaction->payment_status == 'unpaid')
                            <div id="transaction-action">
                                <h5 class="fw-semibold">Bayar</h5>
                                {{-- input select bayar using exist wallet or transfer --}}

                                <div class="card border-0 shadow-sm p-4 my-3">
                                    <div class="card-content rounded">
                                        <div class="mb-3">
                                            Pilih metode pembayaran yang anda inginkan
                                        </div>
                                        <form
                                            action="{{ route('dashboard.user.project-management.pay-for-sale-token', $transaction->transaction_code) }}"
                                            method="POST" class="mb-3" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <x-input type="select" label="Metode Pembayaran" name="payment_method"
                                                required="true" id="payment_method">
                                                <option selected disabled>-- Pilih Metode Pembayaran --</option>
                                                <option value="wallet">Gunakan Saldo</option>
                                                <option value="transfer">Transfer Bank</option>
                                            </x-input>


                                            <div id="wallet-balance-id" style="display: none">
                                                <p class="fw-semibold">Saldo Wallet Campaign Ini adalah <span class="currency">
                                                        {{ $walletBalance }}</span>
                                                </p>
                                            </div>


                                            <div id="bank-transfer-id" style="display: none">
                                                <p class="fw-semibold">Silahkan upload bukti pembayaran</p>
                                                <x-input type="file" name="payment_proof" id="payment_proof"
                                                    placeholder="Bukti Pembayaran" />
                                            </div>

                                            <button type="submit" class="btn btn-primary">Bayar</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @elseif($transaction->status == 'pending' && $transaction->payment_status == 'paid')
                            <div id="transaction-action">
                                <h5 class="fw-semibold">Konfirmasi Pembayaran</h5>
                                <div class="card border-0 shadow-sm p-4 my-3">
                                    <div class="card-content rounded">
                                        <div class="mb-3">
                                            <p class="fw-semibold">Pembayaran menunggu dikonfirmasi oleh penjual token</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($transaction->status == 'success' && $transaction->payment_status == 'paid')
                            <div id="transaction-action">
                                <h5 class="fw-semibold">Konfirmasi Pembayaran</h5>
                                <div class="card border-0 shadow-sm p-4 my-3">
                                    <div class="card-content rounded">
                                        <div class="mb-3">
                                            <p class="fw-semibold">Pembayaran telah dikonfirmasi oleh penjual token</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($transaction->status == 'pending' && $transaction->payment_status == 'needAdminAction')
                            <div id="transaction-action">
                                <h5 class="fw-semibold">Konfirmasi Pembayaran</h5>
                                <div class="card border-0 shadow-sm p-4 my-3">
                                    <div class="card-content rounded">
                                        <div class="mb-3">
                                            <p class="fw-semibold">Menunggu admin menyelesaikan pembayaran</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

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

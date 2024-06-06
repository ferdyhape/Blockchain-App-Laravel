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
                                            Metode Pembayaran
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->payment_method_detail }}
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

                    <div id="how-to-pay">
                        <h5 class="fw-semibold">Tata Cara Pembayaran</h5>
                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="card-content rounded">
                                {!! $paymentMethodDetail->description !!}
                            </div>
                        </div>
                    </div>

                    {{-- {{ url($transaction->payment_proof) }} --}}

                    @if (!$transaction->payment_proof)
                        <div id="upload-proof">
                            <h5 class="fw-semibold">Bukti Pembayaran</h5>
                            <div class="card border-0 shadow-sm p-4 my-3">
                                <div class="card-content rounded">
                                    <div class="mb-3">
                                        Bayar sesuai tata cara diatas, dan upload bukti pembayaran anda dibawah ini sebelum
                                        transaksi anda dikonfirmasi oleh admin
                                    </div>
                                    <form
                                        action="{{ route('dashboard.user.transaction.upload-proof', $transaction->transaction_code) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <x-input type="file" name="payment_proof" required="true" id="payment_proof"
                                            placeholder="Bukti Pembayaran" />
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @else
                        <div id="">
                            <h5 class="fw-semibold">Menunggu Konfirmasi</h5>
                            <div class="card border-0 shadow-sm p-4 my-3">
                                <div class="card-content rounded">
                                    <div class="mb-3">
                                        Bukti pembayaran anda sedang diverifikasi oleh admin, mohon tunggu konfirmasi
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    @endslot
</x-containerTemplate>

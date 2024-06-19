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
                                            {{ $price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Total pembelian
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $count }} Token
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Metode Pembayaran
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $paymentMethodDetail->name }}
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

                    {{-- apabila order type buy dan status pending --}}
                    @if ($transaction->order_type == 'buy' && $transaction->status == 'pending')
                        <div id="how-to-pay">
                            <h5 class="fw-semibold">Tata Cara Pembayaran</h5>
                            <div class="card border-0 shadow-sm p-4 my-3">
                                <div class="card-content rounded">
                                    {!! $paymentMethodDetail->description !!}
                                </div>
                            </div>
                        </div>
                        {{-- apabila order type sell --}}
                    @elseif ($transaction->order_type == 'sell')
                        <div id="account-number">
                            <h5 class="fw-semibold">Bank Tujuan</h5>
                            <div class="card border-0 shadow-sm p-4 my-3">
                                <div class="card-content rounded">
                                    <div class="">
                                        Nama Bank: <span class="fw-semibold">{{ $paymentMethodDetail->name }}</span>
                                    </div>
                                    <div class="">
                                        Nomor rekening: <span class="fw-semibold">{{ $paymentMethodDetail->description }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($transaction->payment_proof != 'null')
                        <div id="payment-proof">
                            <h5 class="fw-semibold">Bukti Pembayaran</h5>
                            <div class="card border-0 shadow-sm p-4 my-3">
                                <div class="card-content rounded">
                                    <img src="{{ asset($transaction->payment_proof) }}" alt="Payment Proof" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        @if (
                            $transaction->status == 'pending' &&
                                $transaction->order_type == 'sell' &&
                                ($transaction->payment_status == 'paidByCampaignBalance' || $transaction->payment_status == 'paid'))
                            <div class="mt-3">
                                <form
                                    action="{{ route('dashboard.user.transaction.change-status', $transaction->transaction_code) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="success">
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form
                                    action="{{ route('dashboard.user.transaction.change-status', $transaction->transaction_code) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="failed">
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        @endif
                    @endif

                    {{-- apabila order type buy dan belum upload bukti pembayaran --}}
                    @if ($transaction->payment_proof == 'null' && $transaction->order_type == 'buy')
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

                        {{-- apabila order type buy dan sudah upload bukti pembayaran --}}
                    @elseif ($transaction->payment_proof && $transaction->order_type == 'buy' && $transaction->status == 'pending')
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

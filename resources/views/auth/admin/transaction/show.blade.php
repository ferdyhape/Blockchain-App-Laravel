<x-containerTemplate pageTitle="Show Transaction">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Transaction', 'Show Transaction']" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="d-flex flex-column gap-3 mb-5">
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
                                            Pembeli
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->from_to_user_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Kode Transaksi
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ $transaction->transaction_code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Status
                                        </td>
                                        <td class="text-end fw-semibold text-uppercase">
                                            {{ $transaction->status }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Status Pembayaran
                                        </td>
                                        <td class="text-end fw-semibold text-uppercase">
                                            {{ $transaction->payment_status }}
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
                                            {{ $transaction->quantity }} Token
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

                        @if ($transaction->payment_proof != null)
                            <div id="payment-proof">
                                <h5 class="fw-semibold">Bukti Pembayaran</h5>
                                <div class="card border-0 shadow-sm p-4 my-3">
                                    <div class="card-content rounded">
                                        <img src="{{ asset($transaction->payment_proof) }}" alt="Payment Proof"
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>

                            {{-- acc status --}}
                            @if ($transaction->status == 'pending')
                                <div class="mt-3">
                                    <form action="{{ route('dashboard.admin.transaction.change-status', $transaction->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="success">
                                        <button type="submit" class="btn btn-success">Accept</button>
                                    </form>
                                    <form action="{{ route('dashboard.admin.transaction.change-status', $transaction->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="failed">
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    @endslot
</x-containerTemplate>

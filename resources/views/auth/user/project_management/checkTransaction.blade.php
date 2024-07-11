<x-containerTemplate pageTitle="Check Transaction">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Project Management', 'Check Transaction']" />

        <x-contentSection>
            <x-slot name="contentOfContentSection">

                <div class="d-flex flex-column gap-3">
                    <div id="campaign-detail">
                        <h5 class="fw-semibold">Project Detail</h5>
                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="card-content rounded">
                                <table class="w-100" style="">
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Judul Proyek
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
                                            Nominal Dibutuhkan
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
                                            Harga Per Token Sekarang
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

                                    <tr class="">
                                        <td colspan="2" style="padding: 5px 0;">
                                            <hr>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-start text-secondary">
                                            Jumlah Token Terbeli
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $project->campaign->sold_token_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Jumlah Rupiah Terkumpul
                                        </td>
                                        <td class="text-start fw-semibold currency">
                                            {{ $project->campaign->wallet->balance }}
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    @if ($project->campaign->status == 'on_going' || $project->campaign->status == 'closed')
                        @php
                            $profitSharingTransaction = $walletTransaction
                                ->where('type', 'profit_sharing_payment')
                                ->first();
                            $totalTokenValue =
                                $project->campaign->price_per_unit * $project->campaign->sold_token_amount;
                            $profitSharingValue = ($totalTokenValue * $project->profit_sharing_percentage) / 100;
                            $totalToBePaid =
                                $totalTokenValue + $profitSharingValue - $project->campaign->wallet->balance;
                        @endphp

                        @if ($project->campaign->status == 'closed' && !$profitSharingTransaction)
                            {{-- Alert reminder untuk pengingat saatnya topup profit_sharing_payment --}}
                            <div class="alert alert-warning" role="alert" id="alert-profit-sharing">
                                <h4 class="alert-heading">Perhatian!</h4>
                                <p>
                                    Proyek ini telah selesai, silahkan melakukan topup pembayaran profit sharing, sesuai
                                    dengan ketentuan di awal pengajuan proyek, maka total pembayaran yang harus dilakukan
                                    dengan rincian sebagai berikut:
                                </p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Presentase Bagi Hasil</td>
                                            <td>{{ $project->profit_sharing_percentage }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Harga Per Token</td>
                                            <td class="currency">{{ $project->campaign->price_per_unit }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Token Terbeli</td>
                                            <td>{{ $project->campaign->sold_token_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>
                                    Berdasar keterangan diatas, maka kalkulasinya adalah sebagai berikut
                                </p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Kalkulasi</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Seluruh Harga Token (Harga Per Token x Jumlah Token Terbeli)</td>
                                            <td>
                                                <span class="currency">{{ $project->campaign->price_per_unit }}</span> x
                                                {{ $project->campaign->sold_token_amount }}
                                            </td>
                                            <td class="currency">
                                                {{ $totalTokenValue }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Rupiah Bagi Hasil (Presentase Bagi Hasil x Seluruh Harga Token)</td>
                                            <td>
                                                <span>{{ $project->profit_sharing_percentage }}%</span> x
                                                <span class="currency">{{ $totalTokenValue }}</span>
                                            </td>
                                            <td class="currency">
                                                {{ $profitSharingValue }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Rupiah yang perlu dikembalikan (Seluruh Harga Token + Jumlah Bagi Hasil)
                                            </td>
                                            <td>
                                                <span class="currency">{{ $totalTokenValue }}</span> +
                                                <span class="currency">{{ $profitSharingValue }}</span>
                                            </td>
                                            <td class="currency">
                                                {{ $totalTokenValue + $profitSharingValue }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>
                                    Berdasar kalkulasi diatas, berikut yang harus dibayarkan
                                </p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Rupiah yang harus dibayar</td>
                                            <td class="currency">
                                                {{ $totalTokenValue + $profitSharingValue }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Uang yang masih ada dalam wallet proyek</td>
                                            <td class="currency">
                                                {{ $project->campaign->wallet->balance }}
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>Total yang harus dibayarkan</td>
                                            <td class="currency">
                                                {{ $totalToBePaid }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('dashboard.user.project-management.profit-sharing-payment', $project->id) }}"
                                    class="btn btn-sm btn-primary">Pembayaran Profit Sharing</a>
                            </div>
                        @elseif($profitSharingTransaction && is_null($profitSharingTransaction->payment_proof))
                            <div class="alert alert-warning" role="alert" id="alert-profit-sharing">
                                <h4 class="alert-heading">Perhatian!</h4>
                                <p>
                                    Anda telah melakukan pembayaran profit sharing, silahkan upload bukti pembayaran
                                </p>
                            </div>
                        @elseif(
                            $profitSharingTransaction &&
                                $profitSharingTransaction->status == 'pending' &&
                                !is_null($profitSharingTransaction->payment_proof))
                            <div class="alert alert-success" role="alert" id="alert-profit-sharing">
                                <h4 class="alert-heading">Selamat!</h4>
                                <p>
                                    Anda telah melakukan pembayaran profit sharing, silahkan tunggu konfirmasi dari admin
                                </p>
                            </div>
                        @elseif($profitSharingTransaction && $profitSharingTransaction->status == 'accepted')
                            <div class="alert alert-success" role="alert" id="alert-profit-sharing">
                                <h4 class="alert-heading">Selamat!</h4>
                                <p>
                                    Pembayaran profit sharing anda telah diterima
                                </p>
                            </div>
                        @endif


                        @if ($project->campaign->status == 'on_going')
                            <div id="action">
                                <form
                                    action="{{ route('dashboard.user.project-management.withdraw-campaign', $project->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="card border-0 shadow-sm p-4 my-3">
                                        <div class="card-content rounded">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-semibold">Withdraw</h5>
                                                <a href="{{ route('dashboard.user.project-management.add-bank-account', $project->id) }}"
                                                    class="btn btn-primary btn-sm">Tambah Rekening Tujuan</a>
                                            </div>

                                            @if (count($wallets) >= 1)
                                                <div class="d-flex flex-column mb-3">
                                                    <p>Pilih Bank Tujuan</p>
                                                    @foreach ($wallets as $wallet)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="payment_method_detail_id"
                                                                id="radio-payment-{{ $wallet->id }}"
                                                                value="{{ $wallet->id }}"
                                                                {{ $loop->first ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="radio-payment-{{ $wallet->id }}">
                                                                <div class="fw-semibold">
                                                                    {{ $wallet->name }}
                                                                </div>
                                                                <div>
                                                                    {{ $wallet->description }}
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="d-flex flex-column gap-2">
                                                    <x-input type="number" label="Nominal Withdraw" name="amount"
                                                        required="true" id="amount"
                                                        placeholder="Masukkan Nominal Withdraw"
                                                        max="{{ $project->campaign->wallet->balance }}" />
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100">Withdraw</button>
                                            @else
                                                <p>Anda tidak memiliki rekening untuk withdraw, silahkan tambah rekening
                                                    tujuan
                                                    terlebih
                                                    dahulu</p>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <hr>
                        <div id="walletTransactionSection">
                            <h5 class="fw-semibold mb-3">Wallet Transaction</h5>
                            <div class="table-responsive">
                                <table class="table" id="walletTransactionTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Payment Proof</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($walletTransaction as $transaction)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $transaction->code }}</td>

                                                <td>
                                                    @if ($transaction->status == 'pending')
                                                        <div class="btn btn-sm btn-warning">Pending</div>
                                                    @elseif($transaction->status == 'accepted')
                                                        <div class="btn btn-sm btn-success">Accepted</div>
                                                    @else
                                                        <div class="btn btn-sm btn-danger">Rejected</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($transaction->payment_proof)
                                                        <a href="{{ asset($transaction->payment_proof) }}"
                                                            target="_blank">Lihat Bukti Pembayaran</a>
                                                    @elseif($transaction->status == 'pending' && $transaction->type == 'profit_sharing_payment')
                                                        <button type="button"
                                                            class="btn btn-sm btn-warning upload-proof-modal"
                                                            data-id="{{ $transaction->id }}">
                                                            Upload Proof
                                                        </button>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="currency">{{ $transaction->amount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <hr>

                    @include('auth.user.project_management.upload_proof')

                    <x-tableDatatable header="Campaign Transaction" tableId="transactionsTable" :oneRowThArray="[
                        'No.',
                        'Code',
                        'Campaign Name',
                        'User',
                        'Order Type',
                        'Status',
                        'Price Total',
                        'Action',
                    ]" />
                </div>

            </x-slot>

        </x-contentSection>

        @push('custom-scripts')
            <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard/user/project_management/checkTransactions.js') }}"></script>
            <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('#walletTransactionTable').DataTable();

                    $(document).on('click', '.upload-proof-modal', function() {
                        let id = $(this).data('id');
                        let route =
                            "{{ route('dashboard.user.project-management.profit-sharing-payment.upload-proof', 'defaultId') }}"
                            .replace('defaultId', id);
                        console.log(route);
                        $('#editForm').attr('action', route);
                        $('#editModal').modal('show');
                    });
                });
            </script>
        @endpush
        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    @endslot
</x-containerTemplate>

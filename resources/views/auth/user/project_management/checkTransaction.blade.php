<x-containerTemplate pageTitle="Check Transaction">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project', 'Check Transaction']" />

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
                    <div id="action">
                        {{-- form withdraw --}}
                        <form action="#" method="POST">
                            @csrf
                            @method('POST')
                            <div class="card border-0 shadow-sm p-4 my-3">
                                <div class="card-content rounded">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-semibold">Withdraw</h5>
                                        <a href="{{ route('dashboard.user.project-management.add-bank-account', $project->id) }}"
                                            class="btn btn-primary btn-sm">Tambah Bank Tujuan</a>
                                    </div>

                                    <div class="d-flex flex-column mb-3">
                                        <p>Pilih Bank Tujuan</p>
                                        @foreach ($wallets as $wallet)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="payment_method_detail_id" id="radio-payment-{{ $wallet->id }}"
                                                    value="{{ $wallet->id }}" {{ $loop->first ? 'checked' : '' }}>
                                                <label class="form-check-label" for="radio-payment-{{ $wallet->id }}">
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
                                        <x-input type="number" label="Nominal Withdraw" name="token_amount" required="true"
                                            id="token_amount" placeholder="Masukkan Nominal Withdraw"
                                            max="{{ $project->campaign->wallet->balance }}" />
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Withdraw</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <x-tableDatatable header="Campaign Transaction Management" tableId="transactionsTable"
                        :oneRowThArray="[
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
        @endpush
    @endslot
</x-containerTemplate>

<x-containerTemplate pageTitle="My Wallet">

    <x-slot name="contentOfContainer">

        <x-headerSection :breadcrumbMenu="['My Wallet']">
        </x-headerSection>

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="row gap-4">
                    <div class="col-md-12 col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header fw-semibold">
                                My Wallet
                            </div>
                            <div class="card-body">
                                <table class="w-100">
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Nama
                                        </td>
                                        <td class="text-end">
                                            {{ auth()->user()->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Saldo
                                        </td>
                                        <td class="text-end currency">
                                            {{ auth()->user()->wallet->balance }}
                                        </td>
                                    </tr>
                                </table>

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('dashboard.user.my-wallet.create') }}"
                                        class="btn btn-primary btn-sm ">Topup</a>
                                    {{-- anchor for withdraw balance --}}
                                    <a href="#" class="btn btn-primary btn-sm ">Withdraw</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-tableDatatable tableId="walletTransactionTable" :oneRowThArray="['No', 'Code', 'Jumlah', 'Status', 'Bukti Pembayaran', 'Action']" />
                </div>
            @endslot
        </x-contentSection>

        @include('auth.user.my_wallet.upload_proof')

        @push('custom-scripts')
            <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard/user/my_wallet/my_wallet.js') }}"></script>
            <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
        @endpush

        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    </x-slot>

</x-containerTemplate>

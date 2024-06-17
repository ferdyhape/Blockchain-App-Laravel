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
                    <x-tableDatatable header="Transaction Management" tableId="transactionsTable" :oneRowThArray="[
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

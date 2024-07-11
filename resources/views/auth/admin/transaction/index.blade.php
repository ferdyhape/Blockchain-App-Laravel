<x-containerTemplate pageTitle="Campaign Transaction">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Campaign Transaction']" />

        <x-contentSection>
            <x-slot name="contentOfContentSection">
                <x-tableDatatable header="Campaign Transaction Management" tableId="transactionManagementTable"
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
            </x-slot>
        </x-contentSection>

        @push('custom-scripts')
            <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard/admin/transactionManagement.js') }}"></script>
            <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
        @endpush
    @endslot
</x-containerTemplate>

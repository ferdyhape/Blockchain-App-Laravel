<x-containerTemplate pageTitle="User">
    @slot('contentOfContainer')
        <x-headerSection breadcrumbMenu="Admin User Management" breadcrumbCurrent="Users" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <x-tableDatatable header="User Management" tableId="userManagementTable" :oneRowThArray="[
                    'No',
                    'Name',
                    'Role',
                    'Email',
                    'Phone',
                    'Date of Birth',
                    'Place of Birth',
                    'Supporting Documents',
                    'Created At',
                    'Action',
                ]" />
            @endslot
        </x-contentSection>

        @include('auth.admin.user_management.edit')

        @push('custom-scripts')
            <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard/admin/userManagement.js') }}"></script>
            <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
        @endpush
    @endslot
</x-containerTemplate>

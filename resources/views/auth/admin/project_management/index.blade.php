<x-containerTemplate pageTitle="Project">
    @slot('contentOfContainer')
        <x-headerSection breadcrumbMenu="Admin Project Management" breadcrumbCurrent="Project" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <x-tableDatatable header="Project Management" tableId="projectManagementTable" :oneRowThArray="['No', 'Project Owner', 'Project Name', 'Category', 'Status', 'Action']" />
            @endslot
        </x-contentSection>


        @push('custom-scripts')
            <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard/admin/projectManagement.js') }}"></script>
            <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
        @endpush
    @endslot
</x-containerTemplate>

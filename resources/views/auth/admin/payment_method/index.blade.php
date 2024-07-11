<x-containerTemplate pageTitle="Payment Method">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Payment Method']">
            @slot('headerContent')
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"
                    id="createModalButton">
                    Create Payment Method
                </button>
            @endslot
        </x-headerSection>

        <x-contentSection>
            @slot('contentOfContentSection')
                <x-tableDatatable header="Payment Method Management" tableId="paymentMethodTable" :oneRowThArray="['No', 'Name', 'Kategori', 'Logo', 'Action']" />
            @endslot
        </x-contentSection>

        @include('auth.admin.payment_method.create')
        @include('auth.admin.payment_method.edit')

        @push('custom-scripts')
            <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard/admin/paymentMethod.js') }}"></script>
            <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
        @endpush
        @include('components.errorAlertValidation')
        @include('components.ifSuccessAlert')
    @endslot

</x-containerTemplate>

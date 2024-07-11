<x-containerTemplate pageTitle="User">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['User Management']" />

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
            <script>
                $(document).on('click', '.accept-modal', function() {
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to verify this user's account?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, verify it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('dashboard.admin.user-management.verify-email') }}",
                                type: 'POST',
                                data: {
                                    id: id
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Verified!',
                                        "This user's account has been verified.",
                                        'success'
                                    );
                                    $('#userManagementTable').DataTable().ajax.reload();
                                },
                                error: function(response) {
                                    Swal.fire(
                                        'Error!',
                                        'Something went wrong. Please try again.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.reject-modal', function() {
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to reject this user's account?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, reject it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('dashboard.admin.user-management.reject-email') }}",
                                type: 'POST',
                                data: {
                                    id: id
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Rejected!',
                                        "This user's account has been rejected.",
                                        'success'
                                    );
                                    $('#userManagementTable').DataTable().ajax.reload();
                                },
                                error: function(response) {
                                    Swal.fire(
                                        'Error!',
                                        'Something went wrong. Please try again.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            </script>
            <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard/admin/userManagement.js') }}"></script>
            <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
        @endpush
    @endslot
</x-containerTemplate>

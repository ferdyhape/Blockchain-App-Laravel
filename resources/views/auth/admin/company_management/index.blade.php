@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Company Management</h1>
                <div class="table-responsive mt-5">
                    <table id="companyManagementTable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Logo</th>
                                <th>Document</th>
                                <th>Owner</th>
                                <th>Acc Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('auth.admin.company_management.edit')

@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/js/base_datatable.js') }}"></script>
    <script src="{{ asset('assets/js/sub/admin/company_management.js') }}"></script>
    <script src="{{ asset('assets/js/datatable.js') }}"></script>
@endpush

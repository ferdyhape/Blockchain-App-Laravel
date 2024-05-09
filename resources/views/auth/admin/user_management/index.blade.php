@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>User Management</h1>
                <div class="table-responsive mt-5">
                    <table id="userManagementTable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Created At</th>
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
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/js/base_datatable.js') }}"></script>
    <script src="{{ asset('assets/js/sub/admin/user_management.js') }}"></script>
    <script src="{{ asset('assets/js/datatable.js') }}"></script>
@endpush

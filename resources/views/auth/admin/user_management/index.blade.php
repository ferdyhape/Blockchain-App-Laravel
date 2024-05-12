@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <x-tableDatatable header="User Management" tableId="userManagementTable" :oneRowThArray="[
                'No',
                'Name',
                'Role',
                'Email',
                'Phone',
                'Date of Birth',
                'Place of Birth',
                'Created At',
                'Action',
            ]" />
        </div>
    </div>
@endsection
@include('auth.admin.user_management.edit')

@push('custom-scripts')
    <script src="{{ asset('assets/js/base/datatable/datatableSettings.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/admin/userManagement.js') }}"></script>
    <script src="{{ asset('assets/js/base/datatable/datatableInitializer.js') }}"></script>
@endpush

@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Dashboard Admin Page</h1>
                <div class="table-responsive mt-5">
                    <table id="transactionTable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaction Code</th>
                                <th>From</th>
                                <th>From Id</th>
                                <th>To</th>
                                <th>To Id</th>
                                <th>Order Type</th>
                                <th>Payment Status</th>
                                <th>Created At</th>
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
    <script src="{{ asset('assets/js/sub/admin/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/datatable.js') }}"></script>
@endpush

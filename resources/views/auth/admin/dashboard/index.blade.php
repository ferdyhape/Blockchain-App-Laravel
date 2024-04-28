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

    <script>
        $(document).ready(function() {
            console.log('tes');
            $('#transactionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'transactionCode',
                        name: 'transactionCode'
                    },
                    {
                        data: 'from',
                        name: 'from'
                    },
                    {
                        data: 'fromId',
                        name: 'fromId'
                    },
                    {
                        data: 'to',
                        name: 'to'
                    },
                    {
                        data: 'toId',
                        name: 'toId'
                    },
                    {
                        data: 'orderType',
                        name: 'orderType'
                    },
                    {
                        data: 'paymentStatus',
                        name: 'paymentStatus'
                    },
                    {
                        data: 'createdAt',
                        name: 'createdAt'
                    },
                ]
            });
        });
    </script>
@endsection

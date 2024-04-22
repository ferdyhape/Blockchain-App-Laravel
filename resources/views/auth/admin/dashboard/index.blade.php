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
                                <th>Buyer</th>
                                <th>Buyer ID</th>
                                <th>Seller Company</th>
                                <th>Seller ID</th>
                                <th>Sum Of Product</th>
                                <th>Total Price</th>
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
                columns: [

                    {
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
                        data: 'buyer',
                        name: 'buyer'
                    },
                    {
                        data: 'buyerId',
                        name: 'buyerId'
                    },
                    {
                        data: 'sellerCompany',
                        name: 'sellerCompany'
                    },
                    {
                        data: 'sellerId',
                        name: 'sellerId'
                    },
                    {
                        data: 'sumOfProduct',
                        name: 'sumOfProduct'
                    },
                    {
                        data: 'totalPrice',
                        name: 'totalPrice'
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
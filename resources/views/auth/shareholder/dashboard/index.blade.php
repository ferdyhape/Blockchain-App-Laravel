@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Dashboard Shareholder Page</h1>
        </div>

        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title
                    ">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">Price: {{ toRp($product->nominal_requested) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

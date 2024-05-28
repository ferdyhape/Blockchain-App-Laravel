@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="card col-11 col-sm-10 col-md-7 col-lg-4 mx-auto p-3">
        <h1 class="card-title my-2 mx-auto">Login</h1>

        <img src="{{ asset('assets/img/login.png') }}" class="card-img-top mx-auto" style="width: 65%">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @error('credentials')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
            <form action=" {{ route('login.process') }} " method="post">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
        <p class="text-center">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </p>
    </div>
@endsection

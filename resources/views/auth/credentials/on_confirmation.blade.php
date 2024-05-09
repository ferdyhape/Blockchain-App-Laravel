@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="card col-11 col-sm-10 col-md-7 col-lg-4 mx-auto px-3 py-4">
        <h1 class="card-title my-2 mx-auto">On Confirmation</h1>

        <div class="card-body mt-4">
            <p>
                Your register of company has been successfully submitted. Please wait for the confirmation from the admin.
            </p>
            <p>
                Please check your email periodically to see the confirmation status from the admin.
            </p>

        </div>
        <p class="text-center">
            <a href="{{ route('login') }}" class="btn btn-primary w-100">Back to Login</a>
        </p>
    </div>
@endsection

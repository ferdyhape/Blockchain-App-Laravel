@extends('layouts.master')
@section('title', 'Register')
@section('content')
    <div class="container" id="container-questions-login-as">
        <h1>
            Want to register as a shareholder or owner?
        </h1>
        <div class="d-flex gap-2">
            <div class="col-2">
                <a href="#" class="btn btn-primary w-100" id="btn-as-owner"> Owner</a>
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-primary w-100" id="btn-as-shareholders"> Shareholder</a>
            </div>
        </div>
    </div>

    <div class="card card-form col-11 col-sm-10 col-md-7 col-lg-5 mx-auto p-3" id='form-login-shareholder'>
        <div class="text-end">
            <button class="btn-close"></button>
        </div>
        <h2 class="card-title my-2 mx-auto">Register As
            Shareholder</h2>

        <img src="{{ asset('assets/img/register.png') }}" class="card-img-top mx-auto" style="width: 65%">
        <div class="card-body">
            <form action="{{ route('register-shareholder.process') }}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Name">
                    @error('name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Email">

                    @error('email')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">

                    @error('password')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">

                    @error('password_confirmation')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
        <p class="text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
    <div class="card card-form col-11 col-sm-10 col-md-7 col-lg-5 mx-auto p-3" id='form-login-owner'>
        <div class="text-end">
            <button class="btn-close"></button>
        </div>
        <h2 class="card-title my-2 mx-auto">Register As Owner</h2>

        <img src="{{ asset('assets/img/register.png') }}" class="card-img-top mx-auto" style="width: 65%">
        <div class="card-body">
            <form action="{{ route('register-owner.process') }}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Name">

                    @error('name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Email">

                    @error('email')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">

                    @error('password')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">

                    @error('password_confirmation')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <p class="text-center">
                    <strong>Company Information</strong>
                </p>

                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_name" placeholder="Company Name">

                    @error('company_name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input for company description --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_description" placeholder="Company Description">

                    @error('company_description')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input for company address --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_address" placeholder="Company Address">

                    @error('company_address')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input for company logo --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_logo" placeholder="Company Logo">

                    @error('company_logo')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input for company city --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_city" placeholder="Company City">

                    @error('company_city')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input for company country --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_country" placeholder="Company Country">

                    @error('company_country')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input for company phone --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_phone" placeholder="Company Phone">

                    @error('company_phone')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- input for company employee count --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_employee_count"
                        placeholder="Company Employee Count">

                    @error('company_employee_count')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input for company established year --}}
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="company_established_year"
                        placeholder="Company Established Year">

                    @error('company_established_year')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
        <p class="text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>


    <script>
        $(document).ready(function() {
            $('.card-form').hide();
            $('#btn-as-owner').on('click', function() {
                $('#container-questions-login-as').hide();
                $('#form-login-owner').find('form').trigger('reset');
                $('#form-login-owner').show();
                $('#form-login-shareholder').hide();
            });
            $('#btn-as-shareholders').on('click', function() {
                $('#container-questions-login-as').hide();
                $('#form-login-owner').hide();
                $('#form-login-shareholder').find('form').trigger('reset');
                $('#form-login-shareholder').show();
            });
            $('.btn-close').on('click', function() {
                $('#container-questions-login-as').show();
                $('.card-form').hide();
            });
        });
    </script>
@endsection

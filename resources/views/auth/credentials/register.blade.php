@extends('layouts.master')
@section('title', 'Register')
@section('content')
    <div class="card card-form col-11 col-sm-10 col-md-7 col-lg-5 mx-auto p-3" id='form-login-shareholder'>
        <h2 class="card-title my-2 mx-auto">Register</h2>

        <img src="{{ asset('assets/img/register.png') }}" class="card-img-top mx-auto" style="width: 65%">
        <div class="card-body">
            <form action="{{ route('register.process') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    @error('email')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                    @error('phone')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                        placeholder="Date of Birth">
                    @error('date_of_birth')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="place_of_birth">Place of Birth</label>
                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth"
                        placeholder="Place of Birth">
                    @error('place_of_birth')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="province_id">Province</label>
                    <input type="text" class="form-control" id="province_id" name="province_id" placeholder="Province">
                    @error('province_id')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="city_id">City</label>
                    <input type="text" class="form-control" id="city_id" name="city_id" placeholder="City">
                    @error('city_id')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="subdistrict_id">Subdistrict</label>
                    <input type="text" class="form-control" id="subdistrict_id" name="subdistrict_id"
                        placeholder="Subdistrict">
                    @error('subdistrict_id')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="address_detail">Address Detail</label>
                    <input type="text" class="form-control" id="address_detail" name="address_detail"
                        placeholder="Address Detail">
                    @error('address_detail')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    @error('password')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="number_id">Number ID</label>
                    <input type="text" class="form-control" id="number_id" name="number_id" placeholder="Number ID">
                    @error('number_id')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm Password">
                    @error('password_confirmation')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- make for supporting document (multiple input file) --}}
                <div class="form-group mb-3">
                    <label for="supporting_documents">Supporting Document</label>
                    <input type="file" class="form-control" id="supporting_documents" name="supporting_documents[]"
                        placeholder="Supporting Document" multiple>
                    @error('supporting_documents')
                        <div class="alert alert-danger mt-2">
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
    <script></script>
@endsection

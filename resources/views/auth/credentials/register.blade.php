@extends('layouts.master')
@section('title', 'Register')
@section('content')
    <div class="card card-form col-11 col-sm-10 col-md-7 col-lg-5 mx-auto p-3" id='form-login-shareholder'>
        <h2 class="card-title my-2 mx-auto">Register</h2>

        <img src="{{ asset('assets/img/register.png') }}" class="card-img-top mx-auto" style="width: 65%">
        <div class="card-body">
            <form action="{{ route('register.process') }}" method="post" enctype="multipart/form-data">
                @csrf

                <x-input type="text" label="Nama" name="name" required="true" id="name" placeholder="Nama" />
                <x-input type="email" label="Email" name="email" required="true" id="email" placeholder="Email" />
                <x-input type="text" label="Telepon" name="phone" required="true" id="phone"
                    placeholder="Telepon" />
                <x-input type="date" label="Tanggal Lahir" name="date_of_birth" required="true" id="date_of_birth"
                    placeholder="Tanggal Lahir" />
                <x-input type="text" label="Tempat Lahir" name="place_of_birth" required="true" id="place_of_birth"
                    placeholder="Tempat Lahir" />
                <x-input type="text" label="Provinsi" name="province_id" required="true" id="province_id"
                    placeholder="Provinsi" />
                <x-input type="text" label="Kota" name="city_id" required="true" id="city_id" placeholder="Kota" />
                <x-input type="text" label="Kecamatan" name="subdistrict_id" required="true" id="subdistrict_id"
                    placeholder="Kecamatan" />
                <x-input type="text" label="Detail Alamat" name="address_detail" required="true" id="address_detail"
                    placeholder="Detail Alamat" />
                <x-input type="text" label="Nomor Identitas" name="number_id" required="true" id="number_id"
                    placeholder="Nomor Identitas" />
                <x-input type="password" label="Kata Sandi" name="password" required="true" id="password"
                    placeholder="Kata Sandi" />
                <x-input type="password" label="Konfirmasi Kata Sandi" name="password_confirmation" required="true"
                    id="password_confirmation" placeholder="Konfirmasi Kata Sandi" />
                <x-input type="file" label="Dokumen Pendukung (Foto KTP)" name="supporting_documents[]" required="true"
                    id="supporting_documents" placeholder="Dokumen Pendukung" multiple />

                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>
        </div>

        <p class="text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
    <x-errorAlertValidation />
    <x-ifSuccessAlert />
@endsection

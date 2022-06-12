@extends('layouts.auth')

@section('title', 'Verifikasi Alamat Email')

@section('body-class', 'register-page')
@section('auth-box-class', '')

@section('content')
<div class="card-body register-card-body">
    <div class="form-group text-center">
        <a href="{{ route('home') }}">
            <img class="img" alt="Aplikasi KPPN Purwodadi" height="48" src="{{ asset('assets/img/logo-full.jpg') }}">
        </a>
    </div>

    @if (session('resent'))
    <div class="alert alert-success" role="alert">
        {{ __('A fresh verification link has been sent to your email address.') }}
    </div>
    @endif

    Sebelum melanjutkan, silakan periksa inbox email Anda untuk link verifikasi akun.<br>
    Jika Anda tidak mendapatkan email masuk, <a href="{{ route('verification.resend') }}">Klik di sini untuk
        mengirim ulang email verifikasi</a>.
</div>
@endsection
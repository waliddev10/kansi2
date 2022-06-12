@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('body-class', 'login-page')

@section('content')
<div class="card-body login-card-body">
    <div class="form-group text-center">
        <a href="{{ route('home') }}">
            <img class="img" alt="Aplikasi KPPN Purwodadi" height="48" src="{{ asset('assets/img/logo-full.jpg') }}">
        </a>
    </div>
    <div class="login-box-msg">
        <h5>Lupa Password</h5>
    </div>

    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <input name="email" type="text" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Alamat Email" autocomplete="email" required autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group mb-4">
            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Kirim Link Reset</button>
        </div>
    </form>

    @guest
    <div class="form-group text-center">
        <a href="{{ route('login') }}">Login</a>
    </div>
    @endguest
</div>
@endsection
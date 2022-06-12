@extends('layouts.auth')

@section('title', 'Login')

@section('body-class', 'login-page')
@section('auth-box-class', 'login-box')

@section('content')
<div class="card-body login-card-body">
    <div class="form-group text-center">
        <a href="{{ route('home') }}">
            <img class="img" alt="Aplikasi KPPN Purwodadi" height="48" src="{{ asset('assets/img/logo-full.jpg') }}">
        </a>
    </div>
    <p class="login-box-msg">Silakan login untuk melanjutkan.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input name="username" type="text" class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username') }}" placeholder="Username" autocomplete="username" required autofocus>
            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="input-group">
                <input name="password" id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                    placeholder="Password" autocomplete="off" required>
                <div id="passwordtoggle" class="input-group-append" style="cursor: pointer;">
                    <div class="input-group-text">
                        <span id="icon" class="fas fa-eye"></span>
                    </div>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" id="remember"
                    {{ old('remember') ? 'checked' : '' }}> <label class="custom-control-label" for="remember">Ingat
                    saya</label>
            </div>
        </div>
        <div class="form-group mb-4">
            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Login</button>
        </div>
    </form>
    <div class="row">
        @if (Route::has('password.request'))
        <div class="col-6"><a href="{{ route('password.request') }}">Lupa Password?</a></div>
        @endif
        @if (Route::has('register'))
        <div class="col-6 text-right"><a href="{{ route('register') }}">Register</a></div>
        @endif
    </div>

</div>
@endsection
@extends('layouts.auth')

@section('title', 'Login')

@section('body-class', 'login-page')
@section('auth-box-class', 'login-box')

@section('content')
<div class="card-body login-card-body">
    <form method="POST" action="{{ route('login') }}">
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
                <input type="checkbox" name="remember" class="custom-control-input" id="remember" {{ old('remember')
                    ? 'checked' : '' }}> <label class="custom-control-label" for="remember">Ingat
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
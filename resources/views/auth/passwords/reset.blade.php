@extends('layouts.auth')

@section('title', 'Reset Password')

@section('body-class', 'login-page')

@section('content')
<div class="card-body login-card-body">
    <div class="form-group text-center">
        <a href="{{ route('home') }}">
            <img class="img" alt="Aplikasi KPPN Purwodadi" height="48" src="{{ asset('assets/img/logo-full.jpg') }}">
        </a>
    </div>
    <div class="login-box-msg">
        <h5>Reset Password</h5>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <input name="email" type="text" class="form-control @error('email') is-invalid @enderror"
                value="{{ $email ?? old('email') }}" placeholder="Alamat Email" autocomplete="email" required autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password Baru<span class="text-warning">*</span></label>
            <div class="input-group @error('password') is-invalid @enderror">
                <input name="password" id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                    placeholder="Password Baru" autocomplete="off" required>
                <div class="passwordtoggle input-group-append" style="cursor: pointer;">
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
            <label for="password_confirmation">Ulangi Password<span class="text-warning">*</span></label>
            <div class="input-group @error('password_confirmation') is-invalid @enderror">
                <input name="password_confirmation" id="password_confirmation" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    value="{{ old('password_confirmation') }}" placeholder="Ulangi Password" autocomplete="off"
                    required>
                <div class="passwordtoggle input-group-append" style="cursor: pointer;">
                    <div class="input-group-text">
                        <span id="icon1" class="fas fa-eye"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Ubah Password</button>
        </div>
    </form>

    @guest
    <div class="form-group text-center">
        Kembali ke halaman <a href="{{ route('login') }}">Login</a>.
    </div>
    @endguest
</div>
@endsection
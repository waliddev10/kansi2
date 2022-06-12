@extends('layouts.app')

@section('app')
<div class="text-center">
   <a href="{{ route('home') }}">
      <img class="img" alt="{{ config('app.name') }}" height="64" src="{{ asset('assets/img/logo-full.png') }}">
   </a>
</div>
<div class="@yield('auth-box-class', 'login-box') mt-3 pb-4">
   <div class="card shadow-sm">
      @yield('content')
   </div>
   <p class="mb-1 mt-4 text-center">
      <small>Version 1.1 Rev 001 Build 20210413<br>
         <span class="font-weight-bold">{{ config('app.instance', 'Moh. Walid Arkham Sani') }} &copy;
            {{ date('Y', time()) }}
         </span>
      </small>
   </p>
</div>
@endsection
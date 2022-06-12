@extends('layouts.panel')

@section('title', 'Notifikasi')

@section('content')
<div class="row">
   <div class="col">
      <div class="card shadow-sm mb-3">
         <div class="card-body">
            <div class="post">
               <div class="user-block">
                  <img class="img-circle" src="{{ asset('assets/img/note.jpg')  }}" alt="{{ $notification->title }}" />
                  <span class="username">
                     <h5 class="text-dark font-weight-bold">{{ $notification->title }}</h5>
                     <span
                        class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse($notification->created_at)->isoFormat('D MMMM YYYY') }}</span>
                  </span>
                  <span class="description">
                     <b>{{ $notification->user->name }}</b> - {{ $notification->user->workunit->name }}
                  </span>
               </div>
               <p>{{ $notification->description }}</p>
            </div>
            <a href="{{ route('notification') }}" class="btn btn-sm btn-primary mt-3">
               <i class="fas fa-reply"></i> Kembali
            </a>
            <a href="{{ route('notification.unread', [ $notification->id ]) }}" class="btn btn-sm btn-danger mt-3">
               <i class="fas fa-eye-slash"></i> Unread
            </a>
         </div>
      </div>
   </div>
</div>
@endsection
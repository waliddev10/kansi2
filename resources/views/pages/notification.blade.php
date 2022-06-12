@extends('layouts.panel')

@section('title', 'Notifikasi')

@section('content')
<div class="row">
   <div class="col">
      @forelse($notifications as $monthly => $notification)
      <div class="card shadow-sm mb-3">
         <div class="card-header">
            <h3 class="card-title">{{ $monthly }}</h3>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
               </button>
            </div>
         </div>
         <div class="card-body p-0">
            <ul class="products-list product-list-in-card p-2">
               @foreach ($notification as $notif)
               <li class="item mx-3">
                  <div class="product-img">
                     <img src="{{ asset('assets/img/note.jpg') }}" alt="{{ $notif->title }}"
                        class="img-size-50 img-circle">
                  </div>
                  <div class="product-info">
                     <a class="text-dark product-title">{{ $notif->title }}
                        <span
                           class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse($notif->date)->isoFormat('D MMMM YYYY') }}</span>
                     </a>
                     <span class="product-description">
                        {{ $notif->description }}
                     </span>
                     <a href="{{ route('notification.detail', ['slug' => $notif->slug]) }}"><span
                           class="badge badge-primary"><i class="far fa-eye"></i> Baca</span></a>
                     @if($notif->user_id)
                     <span class="float-right text-secondary text-md font-weight-bold opacity-3">
                        <i class="fas fa-check-circle"></i>
                        Dibaca
                     </span>
                     @endif
                  </div>
               </li>
               @endforeach
            </ul>
         </div>
      </div>
      @empty
      <div class="card shadow-sm mb-3">
         <div class="card-body text-muted">
            Belum ada notifikasi.
         </div>
      </div>
      @endforelse
   </div>
</div>
@endsection
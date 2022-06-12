@extends('layouts.panel')

@section('title', 'Kegiatan Selesai')

@section('content')
<div class="row">
   <div class="col">
      @forelse($agenda_list as $monthly => $agendas)
      <div class="card shadow-sm mb-3">
         <div class="card-header">
            <h3 class="card-title">{{ $monthly }}</h3>
            <div class="card-tools">
               <small class="badge badge-secondary">{{ count($agendas) }}</small>
               <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i> </button> </div>
         </div>
         <div class="card-body p-0">
            <ul class="products-list product-list-in-card p-2">
               @foreach ($agendas as $agenda)
               <li class="item mx-3">
                  <div class="product-img">
                     <img src="{{ asset('assets/img/agenda.jpg') }}" alt="{{ $agenda->title }}"
                        class="img-size-50 img-circle">
                  </div>
                  <div class="product-info">
                     <a class="text-dark product-title">{{ $agenda->title }}</a>
                     <span class="product-description">
                        {{ $agenda->description }}
                     </span>
                     <span class="product-description">
                        <i class="far fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($agenda->start)->isoFormat('dddd, D MMMM YYYY') }}
                     </span>
                     <span class="product-description">
                        <i class="far fa-clock"></i>
                        {{ \Carbon\Carbon::parse($agenda->start)->isoFormat('HH.mm') }} WIB
                     </span>
                     @if($agenda->workunit_id)
                     <span class="product-description text-primary">
                        <i class="fas fa-user"></i>
                        Terbatas
                     </span>
                     @endif
                     <a href="{{ route('agenda_detail', ['slug' => $agenda->slug]) }}"><span
                           class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                     @if($agenda->user_id)
                     <span class="float-right text-success text-md font-weight-bold opacity-3">
                        <i class="fas fa-check-circle"></i>
                        Hadir
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
            Belum ada kegiatan.
         </div>
      </div>
      @endforelse
   </div>
</div>
@endsection
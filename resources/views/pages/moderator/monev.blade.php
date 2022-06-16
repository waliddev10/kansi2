@extends('layouts.panel')

@section('title', 'Monev')

@section('content')
<div class="row">
    <div class="col">
        @forelse($agendaList as $name => $agendas)
        <div class="card shadow-sm mb-3  collapsed-card">
            <div class="card-header">
                <h3 class="card-title">{{ $name }}</h3>
                <div class="card-tools">
                    <small class="badge badge-secondary">{{ count($agendas) }}</small>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i> </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card p-2">
                    @foreach ($agendas as $agenda)
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/agenda.jpg') }}" alt="{{ $agenda->title }}"
                                class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title">{{ $agenda->title }}</a>
                            <span class="product-description">
                                <i class="far fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($agenda->start)->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                            <a href="{{ route('agenda_detail', ['slug' => $agenda->slug]) }}"><span
                                    class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                            @if(count($agenda->presents))
                            <span class="float-right text-success text-md font-weight-bold opacity-3">
                                <i class="fas fa-check-circle"></i>
                                Selesai
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
                Belum ada Aktivitas.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

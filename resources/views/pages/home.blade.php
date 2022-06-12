@extends('layouts.panel')

@section('title', 'Dasbor')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar-daygrid/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar-timegrid/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar-bootstrap/main.min.css') }}">
@endpush

@section('content')
<div class="row">
    @if (session('status'))
    <div class="col-12">
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    </div>
    @endif
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title">Kalender Kegiatan</h3>
            </div>
            <div class="card-body p-0">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title">Kegiatan Bulan Ini</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card p-2">
                    @forelse($monthly_agendas as $agenda)
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
                                <i class="fas fa-users"></i>
                                Terbatas
                            </span>
                            @endif
                            @if($agenda->user_id)
                            <span class="float-right text-success text-md font-weight-bold opacity-3">
                                <i class="fas fa-check-circle"></i>
                                Hadir
                            </span>
                            @endif
                            <a href="{{ route('agenda_detail', ['slug' => $agenda->slug]) }}"><span
                                    class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                        </div>
                    </li>
                    @empty
                    <li class="item mx-3 text-muted">
                        Belum ada kegiatan.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/main.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/locales/id.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-interaction/main.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
<script>
    $(function() { 
        var Calendar = FullCalendar.Calendar; 
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, { 
            displayEventTime: true,
            selectable: true,
            plugins: [
                'bootstrap',
                'interaction',
                'dayGrid',
                'timeGrid'
                ], 
            header: { 
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            contentHeight: 'auto',
            themeSystem: 'bootstrap',
            locale: 'id',
            events: '{{ route('agenda.get') }}', 
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            editable: false, 
            droppable: false 
        }); 
        calendar.render(); 
    }) 
</script>
@endpush
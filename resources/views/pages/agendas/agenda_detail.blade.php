@extends('layouts.panel')

@section('title', 'Detail Aktivitas')

@section('content')
<div class="row">

   <div class="col-lg-4">
      <div class="card shadow-sm mb-3">
         <div class="card-body box-profile">
            <ul class="list-group list-group-unbordered mb-3">
               <li class="list-group-item border-0">
                  <b>Aktivitas Mulai</b>
                  <br>
                  {{ \Carbon\Carbon::parse($agenda->start)->isoFormat('dddd, D MMMM YYYY HH.mm') }} WIB
               </li>
               <li class="list-group-item border-0">
                  <b>Target Selesai</b>
                  <br>
                  {{ \Carbon\Carbon::parse($agenda->end)->isoFormat('dddd, D MMMM YYYY HH.mm') }} WIB
               </li>
               <li class="list-group-item border-0">
                  <b>Sifat Aktivitas</b>
                  <br>
                  {{ $agenda->status_agenda->name }}
               </li>
               <li class="list-group-item border-0">
                  <b>Unit Kerja</b>
                  <ul>
                     @forelse($agenda->workunit as $workunit)
                     <li>{{ $workunit->name }}</li>
                     @empty
                     <li>Semua Unit Kerja</li>
                     @endforelse
                  </ul>
               </li>
               <li class="list-group-item border-0">
                  <b>Tautan</b>
                  <br>
                  @if($agenda->link)
                  <a href="{{ $agenda->link }}">
                     {{ $agenda->link }}
                  </a>
                  @else
                  <span class="text-muted">Tidak ada tautan</span>
                  @endif
               </li>
               <li class="list-group-item border-0">
                  <b>Lampiran</b>
                  <br>
                  @if($agenda->attachment)
                  <a href="{{ $agenda->attachment }}">
                     <i class="fas fa-paperclip"></i> Lihat Lampiran
                  </a>
                  @else
                  <span class="text-muted">Tidak ada lampiran</span>
                  @endif
               </li>
            </ul>
            <a href="{{ route('agenda_detail.present', ['slug' => $agenda->slug]) }}"
               class="btn btn-primary font-weight-bold"><i class="far fa-eye"></i> Lihat Status</a>

            @if($present)
            <div class="d-block pt-3">
               <i class="text-success fas fa-check-circle"></i> <b>Sudah diselesaikan pada</b>
               {{ \Carbon\Carbon::parse($present->created_at)->isoFormat('dddd, D MMMM YYYY HH.mm') }} WIB
            </div>
            @else
            <button onclick="sendPresent({{ $agenda->id }})" class="btn btn-success font-weight-bold float-right"><i
                  class="far fa-bookmark"></i> Tandai Selesai</button>
            @endif
         </div>
      </div>
   </div>
   <div class="col-lg-8">
      <div class="card shadow-sm mb-3">
         <div class="card-body">
            <div class="post">
               <div class="user-block">
                  <img class="img-circle" src="{{ asset('assets/img/agenda.jpg')  }}" alt="{{ $agenda->title }}" />
                  <span class="username">
                     <h5 class="text-dark font-weight-bold">{{ $agenda->title }}</h5>
                  </span>
                  <span class="description">
                     Dibuat oleh {{ $agenda->user->name }} - {{ $agenda->user->workunit->name }}
                  </span>
               </div>
               <p>{{ $agenda->description }}</p>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
   function sendPresent(agenda_id) {
            Swal.fire({
                title: 'Yakin Selesaikan Aktivitas Ini?',
                text: 'Aksi ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Sudah Selesai'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('agenda_detail.present.store') }}',
                        data: {agenda_id:agenda_id},
                        type: 'POST',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success').then(function(){
                                 location.reload();
                              }
                            );
                        },
                        error: function (response) {
                            error = JSON.stringify(response.responseJSON.errors);
                            if(!error) {
                               error = 'Selesai hanya bisa dilakukan 1 jam sebelum tugas dimulai hingga 1 jam setelah tanggal target tugas selesai.'
                            }
                            Swal.fire('Gagal Selesai', error, 'error');
                        }
                    });
                }
            });
        }
</script>
@endpush
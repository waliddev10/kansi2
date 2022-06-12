@extends('layouts.panel')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="row">
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
                     Diselenggarakan oleh {{ $agenda->user->workunit->name }}
                  </span>
               </div>
               <p>{{ $agenda->description }}</p>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4">
      <div class="card shadow-sm mb-3">
         <div class="card-body box-profile">
            <ul class="list-group list-group-unbordered mb-3">
               <li class="list-group-item border-0">
                  <b>Kegiatan Mulai</b>
                  <br>
                  {{ \Carbon\Carbon::parse($agenda->start)->isoFormat('dddd, D MMMM YYYY HH.mm') }} WIB
               </li>
               <li class="list-group-item border-0">
                  <b>Kegiatan Selesai</b>
                  <br>
                  {{ \Carbon\Carbon::parse($agenda->end)->isoFormat('dddd, D MMMM YYYY HH.mm') }} WIB
               </li>
               <li class="list-group-item border-0">
                  <b>Sifat Kegiatan</b>
                  <br>
                  {{ $agenda->status_agenda->name }}
               </li>
               <li class="list-group-item border-0">
                  <b>Partisipan Kegiatan</b>
                  <ul>
                     @forelse($agenda->workunit as $workunit)
                     <li>{{ $workunit->code }} - {{ $workunit->name }}</li>
                     @empty
                     <li>Semua Satuan Kerja</li>
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
               class="btn btn-primary font-weight-bold"><i class="far fa-eye"></i> Daftar Hadir</a>

            @if($present)
            <div class="d-block pt-3">
               <i class="text-success fas fa-check-circle"></i> <b>Presensi</b>
               {{ \Carbon\Carbon::parse($present->created_at)->isoFormat('dddd, D MMMM YYYY HH.mm') }} WIB
            </div>
            @else
            <button onclick="sendPresent({{ $agenda->id }})" class="btn btn-success font-weight-bold float-right"><i
                  class="far fa-bookmark"></i> Presensi</button>
            @endif
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
   function sendPresent(agenda_id) {
            Swal.fire({
                title: 'Yakin Hadir Kegiatan Ini?',
                text: 'Data kehadiran tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Saya Hadir'
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
                               error = 'Presensi hanya bisa dilakukan 1 jam sebelum acara dimulai hingga 1 jam setelah acara selesai.'
                            }
                            Swal.fire('Gagal Presensi', error, 'error');
                        }
                    });
                }
            });
        }
</script>
@endpush
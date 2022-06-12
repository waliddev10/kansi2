@extends('layouts.panel')

@section('title', 'Daftar Hadir')

@section('content')
<div class="row">
   <div class="col-lg-4">
      <div class="card shadow-sm mb-3">
         <div class="card-body box-profile">
            <ul class="list-group list-group-unbordered mb-3">
               <li class="list-group-item border-0">
                  <b>Judul Kegiatan</b>
                  <br>
                  {{ $agenda->title }}
               </li>
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
            </ul>
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
                     <h5 class="text-dark font-weight-bold">Data Kehadiran</h5>
                  </span>
                  <span class="description">
                     {{ $agenda->title }}
                  </span>
               </div>
               <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Nama</th>
                           <th>Asal Satker</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($presents as $present)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $present->user['name'] }}</td>
                           <td>{{ $present->user['workunit']['name'] }}</td>
                           <td>
                              <i class="text-success fas fa-check-circle"></i> HADIR
                              {{-- <br>
                              <small><i>{{ $present->created_at }}</i></small> --}}
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
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
                            Swal.fire('Gagal Hapus', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }
</script>
@endpush
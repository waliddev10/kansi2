@extends('layouts.panel')

@section('title', 'Detail Aktivitas')

@section('content')
<div class="row">

   <div class="col-lg-4">
      <div class="card shadow-sm mb-3">
         <a href="{{ route('agenda') }}" class="btn btn-primary font-weight-bold">
            <i class="fas fa-arrow-left"></i> Kembali
         </a>
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
            @if($present)
            <div class="d-block pt-3">
               <i class="text-success fas fa-check-circle"></i> <b>Sudah diselesaikan pada</b>
               {{ \Carbon\Carbon::parse($present->created_at)->isoFormat('dddd, D MMMM YYYY HH.mm') }} WIB
            </div>
            @else
            <button {{-- onclick="sendPresent({{ $agenda->id }})" --}} data-toggle="modal"
               data-target="#storePresentModal" class="btn btn-success font-weight-bold float-right"><i
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
      <div class="card shadow-sm mb-3">
         <div class="card-body">
            <div class="post">
               <strong class="text-dark font-weight-bold mb-2">Daftar Selesai</strong>

               <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Nama</th>
                           <th>Unit Kerja</th>
                           <th>Status</th>
                           <th>Catatan</th>
                           <th>Lampiran</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($presents as $present)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $present->user['name'] }}</td>
                           <td>{{ $present->user['workunit']['name'] }}</td>
                           <td>
                              <i class="text-success fas fa-check-circle"></i> Selesai
                              <br>
                              <small><i>{{ $present->created_at }}</i></small>
                           </td>
                           <td>{{ $present->description }}</td>
                           <td> <a href="{{ route('files.present', $present->attachment) }}">
                                 <i class="fas fa-paperclip"></i> Lihat Lampiran
                              </a></td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="4">Belum diselesaikan.</td>
                        </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="storePresentModal" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="storePresent" method="POST" action="{{ route('agenda_detail.present.store') }}">
            @csrf
            <input name="agenda_id" type="hidden" value="{{ $agenda->id }}" required />
            <div class="modal-body">
               <div class="form-group">
                  <label for="description">Catatan<span class="text-warning">*</span></label>
                  <textarea name="description" type="text" id="description" class="form-control" placeholder="Catatan"
                     rows="4" autocomplete="off" required></textarea>
                  <span id="description-error" class="invalid-feedback" role="alert">
                  </span>
               </div>
               <div class="form-group">
                  <label for="attachment">Lampiran<span class="text-warning">*</span></label>
                  <input name="attachment" type="file" class="form-control" id="attachment" placeholder="Lampiran"
                     autocomplete="off" required />
                  <span id="attachment-error" class="invalid-feedback" role="alert">
                  </span>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
               <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                  Selesaikan</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
   $(function(){
          $('#storePresent').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData($(this)[0]);
            formData.append('file', $('input[type=file]')[0].files[0]); 

            $.ajax({
              url: $(this).attr('action'),
              data: formData,
              type: 'POST',
              processData: false,
              contentType: false,
              beforeSend: function() {
                $('#storePresent :input').attr('disabled',true).removeClass('is-invalid');
                $('#storePresent').find('.invalid-feedback').text('');
              },
              complete: function() {
                $('#storePresent :input').attr('disabled',false);
              },
              success:function(res) {
                Swal.fire('Berhasil', res.message, 'success');
                $('#storePresent').trigger('reset');
                $('#storePresent').find('.select2').val(null).trigger('change');
                $('#dataPresent').DataTable().ajax.reload();
                $('#storePresentModal').modal('toggle');
                location.reload();
              },
              error: function(response) {
                Object.keys(response.responseJSON.errors).forEach(key => {
                    $(`input[name='${key}']`).addClass('is-invalid');
                    $(`#${key}-error`).text(response.responseJSON.errors[key]);
                });
              }
            })
            return false;
          });
        });
</script>
@endpush
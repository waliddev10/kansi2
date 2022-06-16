@extends('layouts.panel')

@section('title', 'Notifikasi')

@section('content')
<div class="row">
    <div class="col">
        <div class="card-body">
            <button id="storeModeratorNotificationModalButton" type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#storeModeratorNotificationModal">
                <i class="fas fa-plus-circle"></i> Tambah Notifikasi
            </button>
        </div>
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
                                <span class="float-right text-muted text-sm">{{
                                    \Carbon\Carbon::parse($notif->date)->isoFormat('D MMMM YYYY') }}</span>
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
<!-- Modal -->
<div class="modal fade" id="storeModeratorNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeModeratorNotificationModalLabel">Tambah Notifikasi</h5>
            </div>
            <form id="storeModeratorNotification" method="POST" action="{{ route('moderator.notification.store') }}">
                @csrf
                <input name="id" type="hidden" id="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul Notifikasi<span class="text-warning">*</span></label>
                        <input name="title" type="text" id="title" class="form-control" placeholder="Judul Notifikasi"
                            autocomplete="off" required>
                        <span id="title-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi<span class="text-warning">*</span></label>
                        <textarea name="description" type="text" id="description" class="form-control"
                            placeholder="Deskripsi" rows="4" autocomplete="off" required></textarea>
                        <span id="description-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                        Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#storeModeratorNotification').submit(function(e){
            e.preventDefault();
            $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: $(this).attr('method'),
              beforeSend: function() {
                $('#storeModeratorNotification :input').attr('disabled',true).removeClass('is-invalid');
                $('#storeModeratorNotification').find('.invalid-feedback').text('');
              },
              complete: function() {
                $('#storeModeratorNotification :input').attr('disabled',false);
              },
              success:function(res) {
                Swal.fire('Berhasil', res.message, 'success');
                $('#storeModeratorNotification').trigger('reset');
                $('#storeModeratorNotification').find('.select2').val(null).trigger('change');
                $('#storeModeratorNotificationModal').modal('toggle');
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
</script>
@endpush

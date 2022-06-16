@extends('layouts.panel')

@section('title', 'Arsip')

@section('content')
<div class="card-body">
    <button id="storeModeratorAgendaModalButton" type="button" class="btn btn-primary" data-toggle="modal"
        data-target="#storeModeratorAgendaModal">
        <i class="fas fa-plus-circle"></i> Tambah Dokumen
    </button>
</div>
<div class="row">
    <div class="col">
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title">AKUNTANSI</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card p-2">
                    @foreach ($akuntansi_list as $akun)
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/agenda.jpg') }}" alt="" class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title d-block">{{ $akun->year }}</a>
                            <a href="{{ route('arsip.detail.akuntansi', $akun->year) }}">
                                <span class="badge badge-primary"><i class="far fa-eye"></i> Detail</span>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title">VERIFIKASI</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card p-2">
                    @foreach ($verifikasi_list as $verif)
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/agenda.jpg') }}" alt="" class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title d-block">{{ $verif->year }}</a>
                            <a href="{{ route('arsip.detail.verifikasi', $verif->year) }}">
                                <span class="badge badge-primary"><i class="far fa-eye"></i> Detail</span>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="storeModeratorAgendaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeModeratorAgendaModalLabel">Tambah Dokumen</h5>
            </div>
            <form id="storeModeratorAgenda" method="POST" action="{{ route('arsip.store') }}">
                @csrf
                <input name="user_id" type="hidden" id="id" value="{{ Auth::user()->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="year">Tahun<span class="text-warning">*</span></label>
                        <input name="year" type="text" id="year" class="form-control" placeholder="Tahun"
                            autocomplete="off" required>
                        <span id="year-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="category">Tahun<span class="text-warning">*</span></label>
                        <select name="category" id="category" class="form-control" placeholder="Tahun"
                            autocomplete="off" required>
                            <option disabled selected>Pilih Kategori...</option>
                            <option value="AKUNTANSI">AKUNTANSI</option>
                            <option value="VERIFIKASI">VERIFIKASI</option>
                        </select>
                        <span id="category-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="title">Judul Dokumen<span class="text-warning">*</span></label>
                        <input name="title" type="text" id="title" class="form-control" placeholder="Judul Dokumen"
                            rows="4" autocomplete="off" required>
                        <span id="title-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="attachment">Lampiran</label>
                        <input name="attachment" type="file" class="form-control" id="attachment" placeholder="Lampiran"
                            autocomplete="off" />
                        <span id="attachment-error" class="invalid-feedback" role="alert">
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
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
    function updateModeratorAgendaModalButton(id) {
        $('#storeModeratorAgenda').trigger('reset');
        $('#storeModeratorAgenda').attr('action', '{{ route('moderator.agenda.update') }}');
        $('#storeModeratorAgenda').attr('method', 'PUT');
        $('#storeModeratorAgendaModalLabel').text('Edit Dokumen');
        $.ajax({
            url: '{{ route('moderator.agenda.get') }}',
            data: {id:id},
            type: 'GET',
            success: function (res) {
                Object.keys(res).forEach(key => {
                    $('#storeModeratorAgenda').find(`input[name='${key}']`).val(res[key]);
                    if($('#storeModeratorAgenda').find(`textarea[name='${key}']`)) {
                        $('#storeModeratorAgenda').find(`textarea[name='${key}']`).text(res[key]);
                    }
                    if($('#storeModeratorAgenda').find(`#${key}`)) {
                        $('#storeModeratorAgenda').find(`#${key}`).val(res[key]);
                    }
                });
                $('#storeModeratorAgendaModal').modal('toggle');
            },
            error: function (response) {
                Swal.fire('Gagal Mengambil Data', response.responseJSON.errors, 'error');
            }
        });
    }

    $('#storeModeratorAgendaModalButton').click(function(){
        $('#storeModeratorAgendaModalLabel').text('Tambah Dokumen');
        $('#storeModeratorAgenda').attr('method', 'POST');
        $('#storeModeratorAgenda').attr('action', '{{ route('arsip.store') }}');
        $('#storeModeratorAgenda').trigger('reset');
        $('#storeModeratorAgenda').find('textarea').val(null);
        $('#storeModeratorAgenda').find('.select2').val(null).trigger('change');
    });
</script>
<script type="text/javascript">
    function deleteItemModeratorAgenda(id) {
            Swal.fire({
                title: 'Yakin Hapus?',
                text: 'Data Dokumen akan terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('moderator.agenda.delete') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataModeratorAgenda').DataTable().ajax.reload();
                            if ($.fn.DataTable.isDataTable( '#dataTrashModeratorAgenda' )) {
                                $('#dataTrashModeratorAgenda').DataTable().ajax.reload();
                            }
                        },
                        error: function (response) {
                            Swal.fire('Gagal Hapus', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }
</script>
<script type="text/javascript">
    $(function(){
          $('#storeModeratorAgenda').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData($(this)[0]);
            formData.append('file', $('input[type=file]')[0].files[0]);

            $.ajax({
              url: $(this).attr('action'),
              data: formData,
              type: $(this).attr('method'),
              processData: false,
              contentType: false,
              beforeSend: function() {
                $('#storeModeratorAgenda :input').attr('disabled',true).removeClass('is-invalid');
                $('#storeModeratorAgenda').find('.invalid-feedback').text('');
              },
              complete: function() {
                $('#storeModeratorAgenda :input').attr('disabled',false);
              },
              success:function(res) {
                Swal.fire('Berhasil', res.message, 'success');
                $('#storeModeratorAgenda').trigger('reset');
                $('#storeModeratorAgenda').find('.select2').val(null).trigger('change');
                $('#dataModeratorAgenda').DataTable().ajax.reload();
                $('#storeModeratorAgendaModal').modal('toggle');
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

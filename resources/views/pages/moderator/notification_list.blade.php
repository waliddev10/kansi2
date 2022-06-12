@extends('layouts.panel')

@section('title', 'Daftar Notifikasi')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <button id="storeModeratorNotificationModalButton" type="button" class="btn btn-primary"
                    data-toggle="modal" data-target="#storeModeratorNotificationModal">
                    <i class="fas fa-plus-circle"></i> Tambah Notifikasi
                </button>
                <button id="trashModeratorNotificationModalButton" type="button" class="btn btn-danger float-right"
                    data-toggle="modal" data-target="#trashModeratorNotificationModal">
                    <i class="fas fa-trash"></i> Trash
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataModeratorNotification" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Judul Notifikasi</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
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
<div class="modal fade" id="trashModeratorNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tempat Sampah</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="dataTrashModeratorNotification" class="table table-bordered table-striped"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Judul Notifikasi</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
    function updateModeratorNotificationModalButton(id) {
        $('#storeModeratorNotification').trigger('reset');
        $('#storeModeratorNotification').attr('action', '{{ route('moderator.notification.update') }}');
        $('#storeModeratorNotification').attr('method', 'PUT');
        $('#storeModeratorNotificationModalLabel').text('Edit Notifikasi');
        $.ajax({
            url: '{{ route('moderator.notification.get') }}',
            data: {id:id},
            type: 'GET',
            success: function (res) {
                Object.keys(res).forEach(key => {
                    $('#storeModeratorNotification').find(`input[name='${key}']`).val(res[key]);
                    if($('#storeModeratorNotification').find(`textarea[name='${key}']`)) {
                        $('#storeModeratorNotification').find(`textarea[name='${key}']`).text(res[key]);
                    }
                    if($('#storeModeratorNotification').find(`#${key}`)) {
                        $('#storeModeratorNotification').find(`#${key}`).val(res[key]);
                    }
                });
                $('#storeModeratorNotificationModal').modal('toggle');
            },
            error: function (response) {
                Swal.fire('Gagal Mengambil Data', response.responseJSON.errors, 'error');
            }
        });
    }

    $('#storeModeratorNotificationModalButton').click(function(){
        $('#storeModeratorNotificationModalLabel').text('Tambah Notifikasi');
        $('#storeModeratorNotification').attr('method', 'POST');
        $('#storeModeratorNotification').attr('action', '{{ route('moderator.notification.store') }}');
        $('#storeModeratorNotification').trigger('reset');
        $('#storeModeratorNotification').find('textarea').val(null);
        $('#storeModeratorNotification').find('.select2').val(null).trigger('change');
    });
</script>
<script type="text/javascript">
    function deleteItemModeratorNotification(id) {
            Swal.fire({
                title: 'Yakin Hapus?',
                text: 'Data kegiatan akan terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('moderator.notification.delete') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataModeratorNotification').DataTable().ajax.reload();
                            if ($.fn.DataTable.isDataTable( '#dataTrashModeratorNotification' )) {
                                $('#dataTrashModeratorNotification').DataTable().ajax.reload();
                            }
                        },
                        error: function (response) {
                            Swal.fire('Gagal Hapus', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }

        function restoreItemModeratorNotification(id) {
            Swal.fire({
                title: 'Yakin Restore Data?',
                text: 'Data akan dikembalikan lagi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Restore'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('moderator.notification.restore') }}',
                        data: {id:id},
                        type: 'PUT',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataModeratorNotification').DataTable().ajax.reload();
                            $('#dataTrashModeratorNotification').DataTable().ajax.reload();
                        },
                        error: function (response) {
                            Swal.fire('Gagal Restore', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }

        function deletePermanentItemModeratorNotification(id) {
            Swal.fire({
                title: 'Yakin Hapus Permanent?',
                text: 'Data kegiatan akan terhapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Permanen'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('moderator.notification.destroy') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataTrashModeratorNotification').DataTable().ajax.reload();
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
                $('#dataModeratorNotification').DataTable().ajax.reload();
                $('#storeModeratorNotificationModal').modal('toggle');
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
<script type="text/javascript">
    $(function () {
        $('#trashModeratorNotificationModalButton').click(function(){
            if ( ! $.fn.DataTable.isDataTable( '#dataTrashModeratorNotification' ) ) {
                $('#dataTrashModeratorNotification').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    deferRender: true,
                    order: [[ 3, 'desc' ]],
                    ajax: {
                        url: '{{ route('moderator.notification.data_trash') }}', 
                        type: 'POST'
                    },
                    columns: [
                        { render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            orderable: false
                        },
                        { data: 'title' },
                        { data: 'description' },
                        { data: 'id',
                            render: function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = `<div class="text-nowrap">
                                    <button class="btn badge badge-sm badge-success" onclick="restoreItemModeratorNotification(${data})"><i
                                    class="fas fa-reply"></i></button>
                                    <button class="btn badge badge-sm badge-danger" onclick="deletePermanentItemModeratorNotification(${data})"><i class="fas fa-trash"></i></button>
                                    </div>`;
                                return html;
                            }, 
                            orderable: false
                        },
                    ],
                    columnDefs: [
                        { responsivePriority: 1, targets: 1 }
                    ]
                })
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#dataModeratorNotification').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            deferRender: true,
            order: [[ 3, 'desc' ]],
            ajax: {
                url: '{{ route('moderator.notification.data') }}', 
                type: 'POST'
            },
            columns: [
                { render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                { data: 'title' },
                { data: 'description' },
                { data: 'id',
                    render: function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = `<div class="text-nowrap">
                            <button class="btn badge badge-sm badge-warning" onclick="updateModeratorNotificationModalButton(${data})"><i class="fas fa-edit"></i></button>
                            <button class="btn badge badge-sm badge-danger" onclick="deleteItemModeratorNotification(${data})"><i class="fas fa-trash"></i></button>
                            </div>`;
                        return html;
                    }, 
                    orderable: false
                },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 }
            ]
        })
    });
</script>
@endpush
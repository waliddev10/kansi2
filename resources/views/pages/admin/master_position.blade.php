@extends('layouts.panel')

@section('title', 'Daftar Jabatan')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <button id="storePositionModalButton" type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#storePositionModal">
                    <i class="fas fa-plus-circle"></i> Tambah Jabatan
                </button>
                <button id="trashPositionModalButton" type="button" class="btn btn-danger float-right"
                    data-toggle="modal" data-target="#trashPositionModal">
                    <i class="fas fa-trash"></i> Trash
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataPosition" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Nama Jabatan</th>
                                <th>Tgl Dibuat</th>
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
<div class="modal fade" id="storePositionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storePositionModalLabel">Tambah Jabatan</h5>
            </div>
            <form id="storePosition" method="POST" action="{{ route('master_position.store') }}">
                @csrf
                <input name="id" type="hidden" id="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Jabatan<span class="text-warning">*</span></label>
                        <input name="name" type="text" id="name" class="form-control" placeholder="Nama Jabatan"
                            autocomplete="off" required>
                        <span id="name-error" class="invalid-feedback" role="alert">
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
<div class="modal fade" id="trashPositionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tempat Sampah</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="dataTrashPosition" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Nama Jabatan</th>
                                <th>Tgl Hapus</th>
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
    function updatePositionModalButton(id) {
        $('#storePosition').trigger('reset');
        $('#storePosition').attr('action', '{{ route('master_position.update') }}');
        $('#storePosition').attr('method', 'PUT');
        $('#storePositionModalLabel').text('Edit Jabatan');
        $.ajax({
            url: '{{ route('master_position.get') }}',
            data: {id:id},
            type: 'GET',
            success: function (res) {
                Object.keys(res).forEach(key => {
                    $('#storePosition').find(`input[name='${key}']`).val(res[key]);
                });
                $('#storePositionModal').modal('toggle');
            },
            error: function (response) {
                Swal.fire('Gagal Mengambil Data', response.responseJSON.errors, 'error');
            }
        });
    }

    $('#storePositionModalButton').click(function(){
        $('#storePositionModalLabel').text('Tambah Jabatan');
        $('#storePosition').attr('method', 'POST');
        $('#storePosition').attr('action', '{{ route('master_position.store') }}');
        $('#storePosition').trigger('reset');
    });
</script>
<script type="text/javascript">
    function deleteItemPosition(id) {
            Swal.fire({
                title: 'Yakin Hapus?',
                text: 'Data yang berkaitan dengan jabatan (user, dll) juga akan terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('master_position.destroy') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataPosition').DataTable().ajax.reload();
                            if ($.fn.DataTable.isDataTable( '#dataTrashPosition' )) {
                                $('#dataTrashPosition').DataTable().ajax.reload();
                            }
                        },
                        error: function (response) {
                            Swal.fire('Gagal Hapus', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }

        function restoreItemPosition(id) {
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
                        url: '{{ route('master_position.restore') }}',
                        data: {id:id},
                        type: 'PUT',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataPosition').DataTable().ajax.reload();
                            $('#dataTrashPosition').DataTable().ajax.reload();
                        },
                        error: function (response) {
                            Swal.fire('Gagal Restore', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }

        function deletePermanentItemPosition(id) {
            Swal.fire({
                title: 'Yakin Hapus Permanent?',
                text: 'Data yang berkaitan dengan jabatan (user, dll) juga akan terhapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Permanen'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('master_position.destroy_permanent') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataTrashPosition').DataTable().ajax.reload();
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
          $('#storePosition').submit(function(e){
            e.preventDefault();
            $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: $(this).attr('method'),
              beforeSend: function() {
                $('#storePosition :input').attr('disabled',true).removeClass('is-invalid');
                $('#storePosition').find('.invalid-feedback').text('');
              },
              complete: function() {
                $('#storePosition :input').attr('disabled',false);
              },
              success:function(res) {
                Swal.fire('Berhasil', res.message, 'success');
                $('#storePosition').trigger('reset');
                $('#dataPosition').DataTable().ajax.reload();
                $('#storePositionModal').modal('toggle');
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
        $('#trashPositionModalButton').click(function(){
            if ( ! $.fn.DataTable.isDataTable( '#dataTrashPosition' ) ) {
                $('#dataTrashPosition').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    deferRender: true,
                    order: [[ 1, 'asc' ]],
                    ajax: {
                        url: '{{ route('datatable_trash_position') }}', 
                        type: 'POST'
                    },
                    columns: [
                        { render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            orderable: false
                        },
                        { data: 'name' },
                        { data: 'deleted_at' },
                        { data: 'id',
                            render: function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = `<div class="text-nowrap">
                                    <button class="btn badge badge-sm badge-success" onclick="restoreItemPosition(${data})" data-toggle="tooltip" data-placement="top" title="Restore"><i
                                    class="fas fa-reply"></i></button>
                                    <button class="btn badge badge-sm badge-danger" onclick="deletePermanentItemPosition(${data})" data-toggle="tooltip" data-placement="top" title="Hapus Permanen"><i class="fas fa-trash"></i></button>
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
        $('#dataPosition').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            deferRender: true,
            order: [[ 1, 'asc' ]],
            ajax: {
                url: '{{ route('datatable_position') }}', 
                type: 'POST'
            },
            columns: [
                { render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                { data: 'name' },
                { data: 'created_at' },
                { data: 'id',
                    render: function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = `<div class="text-nowrap">
                            <button class="btn badge badge-sm badge-warning" onclick="updatePositionModalButton(${data})"><i class="fas fa-edit"></i></button>
                            <button class="btn badge badge-sm badge-danger" onclick="deleteItemPosition(${data})"><i class="fas fa-trash"></i></button>
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
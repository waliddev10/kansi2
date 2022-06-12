@extends('layouts.panel')

@section('title', 'Daftar User')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <button id="trashUserModalButton" type="button" class="btn btn-danger float-right" data-toggle="modal"
                    data-target="#trashUserModal">
                    <i class="fas fa-trash"></i> User Nonaktif
                </button>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Moderator dapat menonaktifkan atau merestore akun
                        dengan status role
                        <i>User</i> saja.
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataUser" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Nama User</th>
                                <th>Asal Satker</th>
                                <th>Jabatan</th>
                                <th>NIP</th>
                                <th>Status Role</th>
                                <th>Alamat Email</th>
                                <th>Username</th>
                                <th>No. Handphone</th>
                                <th>Tgl. Verif Email</th>
                                <th>Tgl. Dibuat</th>
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
<div class="modal fade" id="trashUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tempat Sampah</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="dataTrashUser" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Nama User</th>
                                <th>Asal Satker</th>
                                <th>Jabatan</th>
                                <th>NIP</th>
                                <th>Status Role</th>
                                <th>Alamat Email</th>
                                <th>Username</th>
                                <th>No. Handphone</th>
                                <th>Tgl. Verif Email</th>
                                <th>Tgl. Nonaktif</th>
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
    function deleteItemUser(id) {
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
                        url: '{{ route('moderator.user_list.delete') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataUser').DataTable().ajax.reload();
                            if ($.fn.DataTable.isDataTable( '#dataTrashUser' )) {
                                $('#dataTrashUser').DataTable().ajax.reload();
                            }
                        },
                        error: function (response) {
                            Swal.fire('Gagal Hapus', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }

        function restoreItemUser(id) {
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
                        url: '{{ route('moderator.user_list.restore') }}',
                        data: {id:id},
                        type: 'PUT',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataUser').DataTable().ajax.reload();
                            $('#dataTrashUser').DataTable().ajax.reload();
                        },
                        error: function (response) {
                            Swal.fire('Gagal Restore', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }

        function deletePermanentItemUser(id) {
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
                        url: '{{ route('moderator.user_list.destroy') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataTrashUser').DataTable().ajax.reload();
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
    $(function () {
        $('#trashUserModalButton').click(function(){
            if ( ! $.fn.DataTable.isDataTable( '#dataTrashUser' ) ) {
                $('#dataTrashUser').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    deferRender: true,
                    order: [[ 1, 'asc' ]],
                    ajax: {
                        url: '{{ route('moderator.user_list.datatable_trash') }}', 
                        type: 'POST'
                    },
                    columns: [
                        { render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            orderable: false
                        },
                        { data: 'name', orderable: false},
                        { data: 'workunit.name', orderable: false},
                        { data: 'position.name', orderable: false},
                        { data: 'nip' },
                        { data: 'role' },
                        { data: 'email' },
                        { data: 'username' },
                        { data: 'handphone' },
                        { data: 'email_verified_at' },
                        { data: 'deleted_at' },
                        { data: 'id',
                            render: function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = `<div class="text-nowrap">
                                    <button class="btn badge badge-sm badge-success" onclick="restoreItemUser(${data})" data-toggle="tooltip" data-placement="top" title="Restore"><i
                                    class="fas fa-reply"></i></button>
                                    <button class="btn badge badge-sm badge-danger" onclick="deletePermanentItemUser(${data})" data-toggle="tooltip" data-placement="top" title="Hapus Permanen"><i class="fas fa-trash"></i></button>
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
        $('#dataUser').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            deferRender: true,
            order: [[ 1, 'asc' ]],
            ajax: {
                url: '{{ route('moderator.user_list.datatable') }}', 
                type: 'POST'
            },
            columns: [
                { render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                { data: 'name' },
                { data: 'workunit.name', orderable: false},
                { data: 'position.name', orderable: false},
                { data: 'nip' },
                { data: 'role' },
                { data: 'email' },
                { data: 'username' },
                { data: 'handphone' },
                { data: 'email_verified_at' },
                { data: 'created_at' },
                { data: 'id',
                    render: function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = `<button class="btn badge badge-sm badge-danger" onclick="deleteItemUser(${data})"><i class="fas fa-trash"></i></button>
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
@extends('layouts.panel')

@section('title', 'Daftar Admin')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <button id="moderatorModalButton" type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#userModal">
                    <i class="fas fa-plus-circle"></i> Tambah Admin
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataAdmin" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Nama Admin</th>
                                <th>Asal Satker</th>
                                <th>Jabatan</th>
                                <th>NIP</th>
                                <th>Status Role</th>
                                <th>Alamat Email</th>
                                <th>Username</th>
                                <th>No. Handphone</th>
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
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Database Moderator</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Anda
                    dapat mencari data akun Moderator yang akan dijadikan Admin dengan memanfaatkan kolom search.
                </div>
                <div class="table-responsive">
                    <table id="dataModerator" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Nama Moderator</th>
                                <th>Asal Satker</th>
                                <th>Jabatan</th>
                                <th>NIP</th>
                                <th>Status Role</th>
                                <th>Alamat Email</th>
                                <th>Username</th>
                                <th>No. Handphone</th>
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
    function updateItemAdmin(id) {
            Swal.fire({
                title: 'Yakin akan mengubah data?',
                text: 'Status akun akan dirubah, jangan sampai salah akun.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin_list.update') }}',
                        data: {id:id},
                        type: 'PUT',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataAdmin').DataTable().ajax.reload();
                            if ($.fn.DataTable.isDataTable( '#dataModerator' )) {
                                $('#dataModerator').DataTable().ajax.reload();
                            }
                        },
                        error: function (response) {
                            Swal.fire('Gagal', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }
</script>
<script type="text/javascript">
    $(function () {
        $('#moderatorModalButton').click(function(){
            if ( ! $.fn.DataTable.isDataTable( '#dataModerator' ) ) {
                $('#dataModerator').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    deferRender: true,
                    order: [[ 1, 'asc' ]],
                    ajax: {
                        url: '{{ route('moderator_list.datatable') }}', 
                        type: 'POST'
                    },
                    columns: [
                        { render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            orderable: false
                        },
                        { data: 'name' },
                        { data: 'workunit.name', orderable: false },
                        { data: 'position.name', orderable: false },
                        { data: 'nip' },
                        { data: 'role' },
                        { data: 'email' },
                        { data: 'username' },
                        { data: 'handphone' },
                        { data: 'id',
                            render: function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = `<div class="text-nowrap">
                                    <button class="btn badge badge-sm badge-success" onclick="updateItemAdmin(${data})"><i
                                    class="fas fa-check"></i></button>`;
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
        $('#dataAdmin').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            deferRender: true,
            order: [[ 1, 'asc' ]],
            ajax: {
                url: '{{ route('admin_list.datatable') }}', 
                type: 'POST'
            },
            columns: [
                { render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                { data: 'name' },
                { data: 'workunit.name', orderable: false },
                { data: 'position.name', orderable: false },
                { data: 'nip' },
                { data: 'role' },
                { data: 'email' },
                { data: 'username' },
                { data: 'handphone' },
                { data: 'id',
                    render: function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = `<div class="text-nowrap">
                            <button class="btn badge badge-sm badge-danger" onclick="updateItemAdmin(${data})"><i class="fas fa-times"></i></button>
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
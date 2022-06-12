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
                <div class="form-group">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Operator dapat menghapus akun
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
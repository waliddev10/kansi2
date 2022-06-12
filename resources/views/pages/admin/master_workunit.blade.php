@extends('layouts.panel')

@section('title', 'Daftar Unit Kerja')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <button id="storeWorkunitModalButton" type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#storeWorkunitModal">
                    <i class="fas fa-plus-circle"></i> Tambah Unit Kerja
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataWorkunit" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Nama Unit Kerja</th>
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
<div class="modal fade" id="storeWorkunitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeWorkunitModalLabel">Tambah Unit Kerja</h5>
            </div>
            <form id="storeWorkunit" method="POST" action="{{ route('master_workunit.store') }}">
                @csrf
                <input name="id" type="hidden" id="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Unit Kerja<span class="text-warning">*</span></label>
                        <input name="name" type="text" id="name" class="form-control" placeholder="Nama Unit Kerja"
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
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
    function updateWorkunitModalButton(id) {
        $('#storeWorkunit').trigger('reset');
        $('#storeWorkunit').attr('action', '{{ route('master_workunit.update') }}');
        $('#storeWorkunit').attr('method', 'PUT');
        $('#storeWorkunitModalLabel').text('Edit Unit Kerja');
        $.ajax({
            url: '{{ route('master_workunit.get') }}',
            data: {id:id},
            type: 'GET',
            success: function (res) {
                Object.keys(res).forEach(key => {
                    $('#storeWorkunit').find(`input[name='${key}']`).val(res[key]);
                });
                $('#storeWorkunitModal').modal('toggle');
            },
            error: function (response) {
                Swal.fire('Gagal Mengambil Data', response.responseJSON.errors, 'error');
            }
        });
    }
</script>
<script type="text/javascript">
    function deleteItemWorkunit(id) {
            Swal.fire({
                title: 'Yakin Hapus?',
                text: 'Data yang berkaitan dengan Unit Kerja (user, dll) juga akan terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('master_workunit.destroy') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataWorkunit').DataTable().ajax.reload();
                            if ($.fn.DataTable.isDataTable( '#dataTrashWorkunit' )) {
                                $('#dataTrashWorkunit').DataTable().ajax.reload();
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
          $('#storeWorkunit').submit(function(e){
            e.preventDefault();
            $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: $(this).attr('method'),
              beforeSend: function() {
                $('#storeWorkunit :input').attr('disabled',true).removeClass('is-invalid');
                $('#storeWorkunit').find('.invalid-feedback').text('');
              },
              complete: function() {
                $('#storeWorkunit :input').attr('disabled',false);
              },
              success:function(res) {
                Swal.fire('Berhasil', res.message, 'success');
                $('#storeWorkunit').trigger('reset');
                $('#dataWorkunit').DataTable().ajax.reload();
                $('#storeWorkunitModal').modal('toggle');
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
        $('#dataWorkunit').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            deferRender: true,
            order: [[ 1, 'asc' ]],
            ajax: {
                url: '{{ route('datatable_workunit') }}', 
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
                            <button class="btn badge badge-sm badge-warning" onclick="updateWorkunitModalButton(${data})"><i class="fas fa-edit"></i></button>
                            <button class="btn badge badge-sm badge-danger" onclick="deleteItemWorkunit(${data})"><i class="fas fa-trash"></i></button>
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
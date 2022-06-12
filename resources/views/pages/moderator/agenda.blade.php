@extends('layouts.panel')

@section('title', 'Daftar Kegiatan')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <button id="storeModeratorAgendaModalButton" type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#storeModeratorAgendaModal">
                    <i class="fas fa-plus-circle"></i> Tambah Kegiatan
                </button>
                <button id="trashModeratorAgendaModalButton" type="button" class="btn btn-danger float-right"
                    data-toggle="modal" data-target="#trashModeratorAgendaModal">
                    <i class="fas fa-trash"></i> Trash
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataModeratorAgenda" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Kegiatan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Sifat</th>
                                <th>Satuan Kerja</th>
                                <th>Tautan</th>
                                <th>Lampiran</th>
                                <th>PIC Mod.</th>
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
<div class="modal fade" id="storeModeratorAgendaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeModeratorAgendaModalLabel">Tambah Kegiatan</h5>
            </div>
            <form id="storeModeratorAgenda" method="POST" action="{{ route('moderator.agenda.store') }}">
                @csrf
                <input name="id" type="hidden" id="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Nama Kegiatan<span class="text-warning">*</span></label>
                        <input name="title" type="text" id="title" class="form-control" placeholder="Judul Kegiatan"
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
                    <div class="form-group">
                        <label for="start">Tgl. Mulai<span class="text-warning">*</span></label>
                        <input name="start" type="text" class="form-control datetimepicker-input" id="start"
                            data-toggle="datetimepicker" data-target="#start" placeholder="Tgl. Mulai"
                            autocomplete="off" required />
                        <span id="start-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="end">Tgl. Selesai<span class="text-warning">*</span></label>
                        <input name="end" type="text" class="form-control datetimepicker-input" id="end"
                            data-toggle="datetimepicker" data-target="#end" placeholder="Tgl. Selesai"
                            autocomplete="off" required />
                        <span id="end-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="link">Tautan</label>
                        <textarea name="link" type="text" id="link" class="form-control" placeholder="Tautan" rows="2"
                            autocomplete="off"></textarea>
                        <span id="link-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="workunit_id">Satker</label>
                        <small class="text-warning">Kosongkan jika untuk semua satker.</small>
                        <select id="workunit_id" name="workunit_id[]" class="select2 form-control" multiple="multiple"
                            style="width: 100%;"></select>
                        <span id="workunit_id-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="attachment">Lampiran</label>
                        <textarea name="attachment" type="text" id="attachment" class="form-control"
                            placeholder="Lampiran" rows="2" autocomplete="off"></textarea>
                        <span id="attachment-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="status_agenda_id">Sifat<span class="text-warning">*</span></label>
                        <select name="status_agenda_id" class="select2 form-control" id="status_agenda_id"
                            style="width: 100%;" autocomplete="off" required></select>
                        <span id="status_agenda_id-error" class="invalid-feedback" role="alert">
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
<div class="modal fade" id="trashModeratorAgendaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tempat Sampah</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="dataTrashModeratorAgenda" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th>Kegiatan</th>
                                <th>Deskripsi</th>
                                <th>Tgl. Mulai</th>
                                <th>Tgl. Selesai</th>
                                <th>Sifat</th>
                                <th>Tautan</th>
                                <th>Lampiran</th>
                                <th>PIC Mod.</th>
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
        $('#storeModeratorAgendaModalLabel').text('Edit Kegiatan');
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
        $('#storeModeratorAgendaModalLabel').text('Tambah Kegiatan');
        $('#storeModeratorAgenda').attr('method', 'POST');
        $('#storeModeratorAgenda').attr('action', '{{ route('moderator.agenda.store') }}');
        $('#storeModeratorAgenda').trigger('reset');
        $('#storeModeratorAgenda').find('textarea').val(null);
        $('#storeModeratorAgenda').find('.select2').val(null).trigger('change');
    });
</script>
<script type="text/javascript">
    function deleteItemModeratorAgenda(id) {
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

        function restoreItemModeratorAgenda(id) {
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
                        url: '{{ route('moderator.agenda.restore') }}',
                        data: {id:id},
                        type: 'PUT',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataModeratorAgenda').DataTable().ajax.reload();
                            $('#dataTrashModeratorAgenda').DataTable().ajax.reload();
                        },
                        error: function (response) {
                            Swal.fire('Gagal Restore', JSON.stringify(response.responseJSON.errors), 'error');
                        }
                    });
                }
            });
        }

        function deletePermanentItemModeratorAgenda(id) {
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
                        url: '{{ route('moderator.agenda.destroy') }}',
                        data: {id:id},
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#dataTrashModeratorAgenda').DataTable().ajax.reload();
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
            $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: $(this).attr('method'),
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
        $('#trashModeratorAgendaModalButton').click(function(){
            if ( ! $.fn.DataTable.isDataTable( '#dataTrashModeratorAgenda' ) ) {
                $('#dataTrashModeratorAgenda').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    deferRender: true,
                    order: [[ 3, 'desc' ]],
                    ajax: {
                        url: '{{ route('moderator.agenda.data_trash') }}', 
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
                        { data: 'start' },
                        { data: 'end' },
                        { data: 'status_agenda.name' },
                        { data: 'link' },
                        { data: 'attachment' },
                        { data: 'user.name' },
                        { data: 'id',
                            render: function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = `<div class="text-nowrap">
                                    <button class="btn badge badge-sm badge-success" onclick="restoreItemModeratorAgenda(${data})"><i
                                    class="fas fa-reply"></i></button>
                                    <button class="btn badge badge-sm badge-danger" onclick="deletePermanentItemModeratorAgenda(${data})"><i class="fas fa-trash"></i></button>
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
        $('#dataModeratorAgenda').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            deferRender: true,
            order: [[ 3, 'desc' ]],
            ajax: {
                url: '{{ route('moderator.agenda.data') }}', 
                type: 'POST'
            },
            columns: [
                { render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                { data:
                    {
                        title: 'title',
                        description: 'description'
                    },
                    render: function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = `<div class="font-weight-bold d-block">${data.title}</div>
                        <span>${data.description}</span>`;
                        return html;
                    },
                    orderable: false
                 },
                { data: 'start' },
                { data: 'end' },
                { data: 'status_agenda.name',
                    orderable: false
                },
                {   data: 'workunit',
                    render: function ( data, type, row ) { 
                        var html = '';

                        data.forEach(myFunction);
                        function myFunction(item, index) {
                            html += `<b>${item.code}</b> ${item.name} `;
                        }

                        if(html) {
                            return html;
                        } else {
                            return '<b>Semua Satker</b>';
                        }
                    },
                  orderable: false
                },
                { data: 'link' },
                { data: 'attachment' },
                { data: 'user.name' },
                { data: 'id',
                    render: function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = `<div class="text-nowrap">
                            <button class="btn badge badge-sm badge-warning" onclick="updateModeratorAgendaModalButton(${data})"><i class="fas fa-edit"></i></button>
                            <button class="btn badge badge-sm badge-danger" onclick="deleteItemModeratorAgenda(${data})"><i class="fas fa-trash"></i></button>
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
<script type="text/javascript">
   $(function(){
      $('#start').datetimepicker({
         format: 'YYYY-MM-DD HH:mm:ss',
         buttons: 
         {
            showToday: true,
            showClear: true,
            showClose: true
         }
      });
      $('#end').datetimepicker({
         format: 'YYYY-MM-DD HH:mm:ss',
         buttons:
         {
            showToday: true,
            showClear: true,
            showClose: true
         }
      });
      $('#status_agenda_id').select2({
            placeholder: 'Pilih Sifat Kegiatan...',
            allowClear: true,
            ajax: {
                url: '{{ route('api_status_agendas') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('#workunit_id').select2({
            placeholder: 'Pilih Satuan Kerja...',
            allowClear: true,
            ajax: {
                url: '{{ route('api_workunits') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.code+ ' - ' +item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>
@endpush
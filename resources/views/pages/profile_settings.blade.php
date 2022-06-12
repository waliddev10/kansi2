@extends('layouts.panel')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="row">
    @if (session('status'))
    <div class="col-12">
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    </div>
    @endif
    @if (session('error'))
    <div class="col-12">
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    </div>
    @endif
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header px-0 pb-0">
                <div class="px-2 py-3">
                    <div class="img rounded pb-2 text-center">
                        <img class="img shadow-sm rounded-circle" src="{{ asset('assets/img/user.jpg') }}"
                            alt="User Avatar" width="84">
                    </div>
                    <div class="text-center">
                        <h4 class="font-weight-bolder">{{ Auth::user()->name }}</h4>
                        <h6>NIP. {{ Auth::user()->nip }}</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item border-0">
                        <b>Username</b>
                        <br>
                        {{ Auth::user()->username }}
                    </li>
                    <li class="list-group-item border-0">
                        <b>Alamat Email</b>
                        <br>
                        {{ Auth::user()->email }}
                    </li>
                    <li class="list-group-item border-0">
                        <b>Satuan Kerja</b>
                        <br>
                        {{ Auth::user()->workunit->code }} - {{ Auth::user()->workunit->name }}
                    </li>
                    <li class="list-group-item border-0">
                        <b>Jabatan</b>
                        <br>
                        {{ Auth::user()->position->name }}
                    </li>
                    <li class="list-group-item border-0">
                        <b>No. Handphone</b>
                        <br>
                        {{ Auth::user()->handphone }}
                    </li>
                    <li class="list-group-item border-0">
                        <b>Tgl. Daftar</b>
                        <br>
                        {{ \Carbon\Carbon::parse(Auth::user()->created_at)->isoFormat('dddd, D MMMM YYYY') }}
                    </li>
                </ul>
                <button id="updateProfileModalButton" type="button" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Profil
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title">Ubah Password</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile_settings.password.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="old_password">Password Lama<span class="text-warning">*</span></label>
                        <div class="input-group @error('old_password') is-invalid @enderror">
                            <input name="old_password" id="old_password" type="password"
                                class="form-control @error('old_password') is-invalid @enderror"
                                value="{{ old('old_password') }}" placeholder="Password Lama" autocomplete="off"
                                required>
                            <div class="passwordtoggle input-group-append" style="cursor: pointer;">
                                <div class="input-group-text">
                                    <span id="icon" class="fas fa-eye"></span>
                                </div>
                            </div>
                        </div>
                        @error('old_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru<span class="text-warning">*</span></label>
                        <div class="input-group @error('password') is-invalid @enderror">
                            <input name="password" id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                value="{{ old('password') }}" placeholder="Password Baru" autocomplete="off" required>
                            <div class="passwordtoggle input-group-append" style="cursor: pointer;">
                                <div class="input-group-text">
                                    <span id="icon1" class="fas fa-eye"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Ulangi Password Baru<span
                                class="text-warning">*</span></label>
                        <div class="input-group @error('password_confirmation') is-invalid @enderror">
                            <input name="password_confirmation" id="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                value="{{ old('password_confirmation') }}" placeholder="Ulangi Password Baru"
                                autocomplete="off" required>
                            <div class="passwordtoggle input-group-append" style="cursor: pointer;">
                                <div class="input-group-text">
                                    <span id="icon2" class="fas fa-eye"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                            Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Edit Profil</h5>
            </div>
            <form id="updateProfile" method="PUT" action="{{ route('profile_settings.update') }}">
                @csrf
                <input name="id" type="hidden" id="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap<span class="text-warning">*</span></label>
                        <input name="name" type="text" id="name" class="form-control" placeholder="Nama Lengkap"
                            autocomplete="off" required>
                        <span id="name-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="username">Username<span class="text-warning">*</span></label>
                        <input name="username" type="text" id="username" class="form-control" placeholder="Username"
                            autocomplete="off" required>
                        <span id="username-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP<span class="text-warning">*</span></label>
                        <input name="nip" type="text" id="nip" class="form-control" placeholder="NIP" autocomplete="off"
                            required>
                        <span id="nip-error" class="invalid-feedback" role="alert">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="handphone">No. Handphone<span class="text-warning">*</span></label>
                        <input name="handphone" type="text" id="handphone" class="form-control"
                            placeholder="No. Handphone" autocomplete="off" required>
                        <span id="handphone-error" class="invalid-feedback" role="alert">
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
    $('#updateProfileModalButton').click(function() {
            $('#updateProfile').trigger('reset');
            $.ajax({
                url: '{{ route('profile_settings.get') }}',
                type: 'GET',
                success: function (res) {
                    Object.keys(res).forEach(key => {
                        $('#updateProfile').find(`input[name='${key}']`).val(res[key]);
                        if($('#updateProfile').find(`textarea[name='${key}']`)) {
                           $('#updateProfile').find(`textarea[name='${key}']`).text(res[key]);
                        }
                    });
                    $('#updateProfileModal').modal('toggle');
                },
                error: function (response) {
                    Swal.fire('Gagal Mengambil Data', response.responseJSON.errors, 'error');
                }
            });
        });
</script>
<script type="text/javascript">
    $(function(){
          $('#updateProfile').submit(function(e){
            e.preventDefault();
            $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: $(this).attr('method'),
              beforeSend: function() {
                $('#updateProfile :input').attr('disabled',true).removeClass('is-invalid');
                $('#updateProfile').find('.invalid-feedback').text('');
              },
              complete: function() {
                $('#updateProfile :input').attr('disabled',false);
              },
              success:function(res) {
                Swal.fire('Berhasil', res.message, 'success').then(function(){
                        location.reload();
                    }
                );
                $('#updateProfile').trigger('reset');
                $('#updateProfileModal').modal('toggle');
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
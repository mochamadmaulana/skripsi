@extends('layouts.admin', ['title' => 'Edit Pengguna','icon' => 'fas fa-users'])

@section('content')

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-sm btn-secondary float-right shadow-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengguna.update', $pengguna->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="form-group text-center">
                                <img id="preview-avatar-before-upload" src="{{ asset('avatar/' . $pengguna->avatar) }}" class="img-circle elevation-2 shadow" height="200px" width="200px" alt="avatar">
                            </div>

                            <div class="form-group text-center">
                                <label class="text-danger text-sm"><i>Format : jpg|jpeg|png|gif (4096KB)</label><br>
                                <input type="file" name="avatar" id="avatar">
                            </div>

                            <div class="form-group">
                                <label>Nama <span class="text-red">*</span></label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ $pengguna->nama }}" autofocus>
                                @error('nama')
                                <div class="invalid-feedback">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Username <span class="text-red">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                    value="{{ $pengguna->username }}">
                                @error('username')
                                <div class="invalid-feedback">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Email <span class="text-red">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ $pengguna->email }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Jabatan <span class="text-red">*</span></label>
                                <select name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" id="selectJabatan">
                                    <option value="">-pilih jabatan-</option>
                                    @foreach ($jabatan as $val)
                                    <option value="{{ $val->id }}" @if ($pengguna->jabatan_id == $val->id) selected @endif>{{ $val->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jabatan')
                                <div class="invalid-feedback">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label><br>
                                <div class="form-check form-check-inline">
                                    <input name="aktif" class="form-check-input" type="radio" value="1" id="aktif"
                                        @if($pengguna->aktif == 1) checked @endif/>
                                    <label class="form-check-label" for="aktif"> Aktif </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="aktif" class="form-check-input" type="radio" value="0" id="tidakAktif"
                                        @if($pengguna->aktif == 0) checked @endif/>
                                    <label class="form-check-label" for="tidakAktif"> Tidak Aktif </label>
                                </div>
                                @error('aktif')
                                <div class="invalid-feedback">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Role <span class="text-danger">*</span></label><br>
                                <div class="form-check form-check-inline">
                                    <input name="role" class="form-check-input" type="radio" value="User" id="user"
                                        @if($pengguna->role == 'User') checked @endif />
                                    <label class="form-check-label" for="user"> User </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="role" class="form-check-input" type="radio" value="Admin" id="admin"
                                        @if($pengguna->role == 'Admin') checked @endif />
                                    <label class="form-check-label" for="admin"> Admin </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="role" class="form-check-input" type="radio" value="Kepala Sekolah"
                                        id="kepalasekolah" @if($pengguna->role == 'Kepala Sekolah') checked @endif />
                                    <label class="form-check-label" for="kepalasekolah"> Kepala Sekolah </label>
                                </div>
                                @error('role')
                                <div class="invalid-feedback">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-edit"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.pengguna.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Edit Data</li>
@endpush

@push('js')
<script>
    $(document).ready(function (e) {
       $('#avatar').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
          $('#preview-avatar-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
       });

        // $('input[type="file"]').change(function(e) {
        //     var fileName = e.target.files[0].name;
        //     $('.custom-file-label').html(fileName);
        // });

    });
</script>
<script>
    $(document).ready(function () {
        $('#selectJabatan').select2({
            theme: 'bootstrap4',
            placeholder: '-Pilih-'
        })
    });
</script>
@endpush

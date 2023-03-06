@extends('layouts.kepala-sekolah', ['title' => 'Profile','icon' => 'fas fa-user'])

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <a href="{{ asset('storage/avatar/'.auth()->user()->avatar) }}" target="_blank">
                        <img src="{{ asset('avatar/'.auth()->user()->avatar) }}" class="img-circle elevation-1 shadow-sm" height="200px" width="200px" alt="avatar">
                    </a>
                </div>

                <h3 class="profile-username text-center mb-3">{{ auth()->user()->nama }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Username</b> <span class="float-right text-muted">{{ auth()->user()->username }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right text-muted">{{ auth()->user()->email }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Jabatan</b> <span class="float-right text-muted">{{ auth()->user()->jabatan->nama }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Role</b> <span class="float-right text-muted">{{ auth()->user()->role}}</span>
                    </li>
                    <li class="list-group-item">
                        @if(auth()->user()->aktif == 1)
                        <b>Status</b> <span class="float-right badge badge-success">Aktif</span>
                        @else
                        <b>Status</b> <span class="float-right badge badge-danger">Tidak Aktif</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-7">
      <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#tab-profile" data-toggle="tab">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab-password" data-toggle="tab">Password</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab-avatar" data-toggle="tab">Avatar</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">

                <div class="active tab-pane" id="tab-profile">
                    <form class="form-horizontal" action="{{ route('kepala-sekolah.profile.update-profile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ @old('nama') }}" id="nama" >
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ @old('username') }}" id="username">
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ @old('email') }}" id="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-edit mr-1"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="tab-password">
                    <form class="form-horizontal" method="POST" action="{{ route('kepala-sekolah.profile.update-password') }}">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Password Baru</label>
                            <div class="col-sm-8">
                            <input type="password" name="password_baru" class="form-control @error('password_baru') is-invalid @enderror" id="password" placeholder="Password Baru">
                            @error('password_baru') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        </div>
                        <div class="form-group row">
                            <label for="konfirmasi_password" class="col-sm-4 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-8">
                            <input type="password" name="konfirmasi_password" class="form-control @error('konfirmasi_password') is-invalid @enderror" id="konfirmasi_password" placeholder="Konfirmasi Password">
                            @error('konfirmasi_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-sm-4 col-sm-8">
                                <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-lock mr-1"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="tab-avatar">
                    <form class="form-horizontal" method="POST" action="{{ route('kepala-sekolah.profile.update-avatar') }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group text-center">
                            <img id="preview-avatar-before-upload" src="{{ asset('avatar/' . auth()->user()->avatar) }}" class="img-circle elevation-1 shadow" height="200px" width="200px" alt="avatar">
                        </div>

                        <div class="form-group text-center">
                            <label class="text-danger text-sm"><i>Format : jpg|jpeg|png|gif (4096KB)</label><br>
                            <input type="file" name="avatar" id="avatar">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-image mr-1"></i> Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item active">Profile</li>
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

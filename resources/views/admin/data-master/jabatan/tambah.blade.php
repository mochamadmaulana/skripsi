@extends('layouts.admin', ['title' => 'Tambah Jabatan','icon' => 'fas fa-server'])
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <a href="{{ route('admin.data-master.jabatan.index') }}" class="btn btn-sm btn-secondary float-right shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="{{ route('admin.data-master.jabatan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama <span class="text-red">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ @old('nama') }}" autofocus autocomplete="off">
                        @error('nama')
                        <div class="invalid-feedback">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-paper-plane"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.data-master.jabatan.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Tambah Data</li>
@endpush

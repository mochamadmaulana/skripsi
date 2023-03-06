@extends('layouts.admin', ['title' => 'Edit Jabatan','icon' => 'fas fa-server'])

@section('content')

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('admin.data-master.jabatan.index') }}" class="btn btn-sm btn-secondary float-right shadow-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="{{ route('admin.data-master.jabatan.update', $jabatan->id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $jabatan->nama }}" autofocus autocomplete="off" />
                                @error('nama')
                                <div class="invalid-feedback">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-edit"></i> Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.data-master.jabatan.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Edit Data</li>
@endpush

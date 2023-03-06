@extends('layouts.admin', ['title' => 'Tambah Surat Keluar', 'icon' => 'fas fa-envelope'])

@section('content')

@if ($errors->has('files.*'))
    <div class="alert alert-danger"><span class="mr-2">File extention must be:</span> jpg|jpeg|png|pdf|docx|docs|xlsx|csv|ppt|pptx</div>
@endif

<div class="card mb-4">
    <div class="card-header">
        <a href="{{ route('admin.surat-keluar.index') }}" class="btn btn-sm btn-secondary float-right shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nomor Agenda <span class="text-success font-italic"><sup>Terisi otomatis oleh sistem</sup></span></label>
                        <input type="text" class="form-control" value="{{ $nomor_agenda }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Ditujukan Kepada <span class="text-danger">*</span></label>
                        <input type="text" name="ditujukan_kepada" class="form-control @error('ditujukan_kepada') is-invalid @enderror" value="{{ @old('ditujukan_kepada') }}" placeholder="Ditujukan Kepada">
                        @error('ditujukan_kepada')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nomor Surat <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ @old('nomor_surat') }}" placeholder="Nomor Surat">
                        @error('nomor_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nama Surat <span class="text-danger">*</span></label>
                        <input type="text" name="nama_surat" class="form-control @error('nama_surat') is-invalid @enderror" value="{{ @old('nama_surat') }}" placeholder="Nama Surat">
                        @error('nama_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Akses Surat <span class="text-red">*</span></label>
                        <select name="akses_surat[]" class="form-control @error('akses_surat') is-invalid @enderror" multiple="multiple" id="selectAksesSurat">
                            <option value="">-Pilih-</option>
                            @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}" @if (@old('akses_surat') == $jabatan->id) selected @endif>{{ $jabatan->nama }}</option>
                            @endforeach
                        </select>
                        @error('akses_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Surat <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ @old('tanggal_surat') }}">
                        @error('tanggal_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Keluar <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ @old('tanggal_keluar') }}">
                        @error('tanggal_keluar')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Perihal <span class="text-warning font-italic"><sup>Opsional</sup></span></label>
                        <textarea name="perihal" class="form-control @error('perihal') is-invalid @enderror" cols="5" rows="5" ></textarea>
                        @error('perihal')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>File Surat <span class="text-danger font-italic">* <sup>jpg|jpeg|png|pdf|docx|docs|xlsx|csv|ppt|pptx (2048mb)</sup></span></label>
                        <div id="file">
                            <div class="row">
                                <div class="col-lg">
                                    <input type="file" class="is-invalid" name="files[]" multiple="true">
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-sm btn-success add-row float-right"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-paper-plane"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.surat-keluar.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Tambah Data</li>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#selectAksesSurat').select2({
            theme: 'bootstrap4',
            placeholder: '-Pilih-',
            allowClear: true
        })

        $('.add-row').on('click', function(){
            var html = '';
            html += '<div class="row mt-3" id="row">';
            html += '<div class="col-lg">';
            html += '<input type="file" name="files[]" multiple="true">';
            html += '</div>';
            html += '<div class="col-lg-2">';
            html += '<button type="button" class="btn btn-sm btn-danger float-right"><i class="fas fa-times"></i></button>';
            html += '</div>';
            html += '</div>';
            $('#file').append(html);

            $(document).on('click','.btn-danger',function(){
                $(this).closest('#row').remove();
            })
        })
    })
</script>
@endpush

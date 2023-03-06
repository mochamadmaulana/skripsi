@extends('layouts.admin', ['title' => 'Laporan Surat Keluar', 'icon' => 'fas fa-book'])

@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <form action="{{ route('admin.laporan-surat.surat-keluar.export-excel') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Export</label> <span class="text-danger">*</span>
                        <select name="pilih_export" class="form-control @error('pilih_export') is-invalid @enderror">
                            <option value="">-Pilih-</option>
                            <option value="Excel" @if (@old('pilih_export') == 'Excel') selected @endif>Excel</option>
                            <option value="Csv" @if (@old('pilih_export') == 'Csv') selected @endif>Csv</option>
                        </select>
                        @error('pilih_export') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal</label> <span class="text-danger">*</span>
                        <select name="pilih_tanggal" class="form-control @error('pilih_tanggal') is-invalid @enderror">
                            <option value="">-Pilih-</option>
                            <option value="Tanggal Surat"  @if (@old('pilih_tanggal') == 'Tanggal Surat') selected @endif>Tanggal Surat</option>
                            <option value="Tanggal Keluar"  @if (@old('pilih_tanggal') == 'Tanggal Keluar') selected @endif>Tanggal Keluar</option>
                        </select>
                        @error('pilih_tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal Awal</label> <span class="text-danger">*</span>
                        <input type="date" name="tanggal_awal" value="{{ @old('tanggal_awal') }}" class="form-control @error('tanggal_awal') is-invalid @enderror">
                        @error('tanggal_awal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal Akhir</label> <span class="text-danger">*</span>
                        <input type="date" name="tanggal_akhir" value="{{ @old('tanggal_akhir') }}" class="form-control @error('tanggal_akhir') is-invalid @enderror">
                        @error('tanggal_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary mr-1"><i class="fas fa-download mr-1"></i> Download</button>
        </form>
    </div>
</div>
@endsection

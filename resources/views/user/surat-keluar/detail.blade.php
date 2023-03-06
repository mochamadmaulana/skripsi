@extends('layouts.user', ['title' => 'Detail Surat Keluar', 'icon' => 'fas fa-envelope'])

@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <a href="{{ route('user.surat-keluar.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <strong><i class="fas fa-sort-numeric-up mr-1"></i> Nomor Agenda</strong>
                <p class="text-muted">{{ $surat_keluar->nomor_agenda }}</p>
                <hr>

                <strong><i class="fas fa-envelope mr-1"></i> Nomor Surat</strong>
                <p class="text-muted">{{ $surat_keluar->nomor_surat }}</p>
                <hr>

                <strong><i class="fas fa-envelope mr-1"></i> Nama Surat</strong>
                <p class="text-muted">{{ $surat_keluar->nama_surat }}</p>
                <hr>

                <strong><i class="fas fa-building mr-1"></i> Ditujukan Kepada</strong>
                <p class="text-muted">{{ $surat_keluar->ditujukan_kepada }}</p>
                <hr>

                <strong><i class="fas fa-calendar mr-1"></i> Tanggal Surat</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($surat_keluar->tanggal_surat)->translatedFormat('d F Y') }}</p>
                <hr>

                <strong><i class="fas fa-calendar-check mr-1"></i> Tanggal Keluar</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($surat_keluar->tanggal_keluar)->translatedFormat('d F Y') }}</p>
                <hr>

                <strong><i class="fas fa-tag mr-1"></i> Status</strong>
                <p class="text-muted">
                    @if($surat_keluar->status_approve == 'Disetujui')
                        <span class="badge badge-success">{{ $surat_keluar->status_approve }}</span>
                    @elseif($surat_keluar->status_approve == 'Prosess')
                        <span class="badge badge-secondary">{{ $surat_keluar->status_approve }}</span>
                    @else
                        <span class="badge badge-danger">{{ $surat_keluar->status_approve }}</span>
                    @endif
                </p>
                <hr>

                <strong><i class="fas fa-file-alt mr-1"></i> File Surat</strong>
                <p class="text-muted">
                    @foreach($surat_keluar->file_surat_keluar as $fsm)
                    @if($fsm->extention == 'pdf')
                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-pdf"></i> {{ $fsm->nama_file }}</a><br>
                    @elseif($fsm->extention == 'docx' || $fsm->extention == 'docs')
                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-word"></i> {{ $fsm->nama_file }}</a><br>
                    @elseif($fsm->extention == 'xlsx' || $fsm->extention == 'csv')
                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-excel"></i> {{ $fsm->nama_file }}</a><br>
                    @elseif($fsm->extention == 'ppt' || $fsm->extention == 'pptx')
                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-powerpoint"></i> {{ $fsm->nama_file }}</a><br>
                    @else
                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-image"></i> {{ $fsm->nama_file }}</a><br>
                    @endif
                    @endforeach
                </p>
                <hr>

                <strong><i class="fas fa-book-open mr-1"></i> Perihal</strong>
                <p class="text-muted">{{ $surat_keluar->perihal }}</p>
                <hr>

            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('user.surat-keluar.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Detail Data</li>
@endpush

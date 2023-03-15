@extends('layouts.admin', ['title' => 'Detail Surat Masuk', 'icon' => 'fas fa-envelope-open-text'])

@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <a href="{{ route('admin.surat-masuk.index') }}" class="btn btn-sm btn-secondary shadow-sm">
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
                <p class="text-muted">{{ $surat_masuk->nomor_agenda }}</p>
                <hr>

                <strong><i class="fas fa-envelope-open-text mr-1"></i> Nomor Surat</strong>
                <p class="text-muted">{{ $surat_masuk->nomor_surat }}</p>
                <hr>

                <strong><i class="fas fa-envelope-open-text mr-1"></i> Nama Surat</strong>
                <p class="text-muted">{{ $surat_masuk->nama_surat }}</p>
                <hr>

                <strong><i class="fas fa-user mr-1"></i> Pengirim</strong>
                <p class="text-muted">{{ $surat_masuk->nama_pengirim }}</p>
                <hr>

                <strong><i class="fas fa-calendar mr-1"></i> Tanggal Surat</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($surat_masuk->tanggal_surat)->translatedFormat('d F Y') }}</p>
                <hr>

                <strong><i class="fas fa-calendar-check mr-1"></i> Tanggal Diterima</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($surat_masuk->tanggal_diterima)->translatedFormat('d F Y') }}</p>
                <hr>

                <strong><i class="fas fa-file-alt mr-1"></i> File Surat</strong>
                <p class="text-muted">
                    @foreach($surat_masuk->file_surat_masuk as $fsm)
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

                <strong><i class="fas fa-tags mr-1"></i> Disposisi Surat</strong>
                <p class="text-muted">
                    @foreach($surat_masuk->disposisi_surat_masuk as $as)
                        <span class="badge badge-primary mr-1">{{ $as->jabatan->nama }}</span>
                    @endforeach
                </p>
                <hr>

                <strong><i class="fas fa-book-open mr-1"></i> Perihal</strong>
                <p class="text-muted">{{ $surat_masuk->perihal ?? 'No Data'}}</p>
                <hr>

            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.surat-masuk.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Detail Data</li>
@endpush

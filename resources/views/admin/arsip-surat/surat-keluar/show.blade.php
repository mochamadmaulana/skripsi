@extends('layouts.admin', ['title' => 'Arsip Surat Keluar', 'icon' => 'fas fa-archive'])

@section('content')
@include('admin.arsip-surat.surat-keluar.form')

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="tableShowSearch" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No. Agenda</th>
                            <th>Nomor Surat</th>
                            <th>Nama Surat</th>
                            <th>Ditujukan Kepada</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Keluar</th>
                            <th>Status Approve</th>
                            <th>Akses Surat</th>
                            <th>File Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($surat_keluar)
                        @foreach ($surat_keluar as $item)
                        <tr>
                            <td>{{ $item->nomor_agenda }}</td>
                            <td>{{ $item->nomor_surat }}</td>
                            <td>{{ $item->nama_surat }}</td>
                            <td>{{ $item->ditujukan_kepada }}</td>
                            <td class="@if(request()->get('pilih_tanggal') == 'Tanggal Surat') table-success @endif">{{  \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('l, d F Y') }}</td>
                            <td class="@if(request()->get('pilih_tanggal') == 'Tanggal Keluar') table-success @endif">{{  \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('l, d F Y') }}</td>
                            <td>
                                @if($item->status_approve == 'Disetujui')
                                    <span class="badge badge-success">{{ $item->status_approve }}</span>
                                @elseif($item->status_approve == 'Prosess')
                                    <span class="badge badge-secondary">{{ $item->status_approve }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $item->status_approve }}</span>
                                @endif
                            </td>
                            <td>
                                @foreach ($item->akses_surat_keluar as $ask)
                                    <span class="badge badge-primary">{{ $ask->jabatan->nama }}</span>
                                @endforeach
                            </td>
                            <td>
                                <ul>
                                    @foreach ($item->file_surat_keluar as $fsm)
                                        @if($fsm->extention == 'pdf')
                                            <li><a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-pdf"></i> {{ $fsm->nama_file }}</a></li>
                                        @elseif($fsm->extention == 'docx' || $fsm->extention == 'docs')
                                            <li><a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-word"></i> {{ $fsm->nama_file }}</a></li>
                                        @elseif($fsm->extention == 'xlsx' || $fsm->extention == 'csv')
                                            <li><a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-excel"></i> {{ $fsm->nama_file }}</a></li>
                                        @elseif($fsm->extention == 'ppt' || $fsm->extention == 'pptx')
                                            <li><a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-powerpoint"></i> {{ $fsm->nama_file }}</a></li>
                                        @else
                                            <li><a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-image"></i> {{ $fsm->nama_file }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.arsip-surat.surat-keluar.index') }}">Form Search</a></li>
<li class="breadcrumb-item active">Search Data</li>
@endpush

@push('js')
<script>
    $(function () {
      $('#tableShowSearch').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
@endpush

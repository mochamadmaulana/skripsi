@extends('layouts.admin', ['title' => 'Arsip Surat Masuk', 'icon' => 'fas fa-archive'])

@section('content')
@include('admin.arsip-surat.surat-masuk.form')

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
                            <th>Pengirim</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Diterima</th>
                            <th>Akses Surat</th>
                            <th>File Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($surat_masuk)
                        @foreach ($surat_masuk as $item)
                        <tr>
                            <td>{{ $item->nomor_agenda }}</td>
                            <td>{{ $item->nomor_surat }}</td>
                            <td>{{ $item->nama_surat }}</td>
                            <td>{{ $item->nama_pengirim }}</td>
                            <td class="@if(request()->get('pilih_tanggal') == 'Tanggal Surat') table-success @endif">{{  \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}</td>
                            <td class="@if(request()->get('pilih_tanggal') == 'Tanggal Diterima') table-success @endif">{{  \Carbon\Carbon::parse($item->tanggal_diterima)->translatedFormat('d F Y') }}</td>
                            <td>
                                @foreach ($item->akses_surat_masuk as $asm)
                                    <span class="badge badge-primary">{{ $asm->jabatan->nama }}</span>
                                @endforeach
                            </td>
                            <td>
                                <ul>
                                    @foreach ($item->file_surat_masuk as $fsm)
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
<li class="breadcrumb-item"><a href="{{ route('admin.arsip-surat.surat-masuk.index') }}">Form Search</a></li>
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

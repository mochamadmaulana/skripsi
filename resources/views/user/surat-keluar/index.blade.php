@extends('layouts.user', ['title' => 'Surat Keluar', 'icon' => 'fas fa-envelope'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="tablesuratmasuk" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No. Agenda</th>
                            <th>Nomor Surat</th>
                            <th>Nama Surat</th>
                            <th>Ditujukan Kepada</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat_keluar as $val)
                        <tr>
                            <td>{{ $val->surat_keluar->nomor_agenda }}</td>
                            <td>{{ $val->surat_keluar->nomor_surat }}</td>
                            <td>{{ $val->surat_keluar->nama_surat }}</td>
                            <td>{{ $val->surat_keluar->ditujukan_kepada }}</td>
                            <td>{{  \Carbon\Carbon::parse($val->surat_keluar->tanggal_surat)->translatedFormat(' d F Y') }}</td>
                            <td>{{  \Carbon\Carbon::parse($val->surat_keluar->tanggal_keluar)->translatedFormat(' d F Y') }}</td>
                            <td>
                                @if($val->surat_keluar->status_approve == 'Disetujui')
                                    <span class="badge badge-success">{{ $val->surat_keluar->status_approve }}</span>
                                @elseif($val->surat_keluar->status_approve == 'Prosess')
                                    <span class="badge badge-secondary">{{ $val->surat_keluar->status_approve }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $val->surat_keluar->status_approve }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.surat-keluar.show', $val->surat_keluar_id) }}" class="btn btn-xs btn-info mr-2 shadow-sm"><i class="far fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        @endforeach
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
<li class="breadcrumb-item active">List Data</li>
@endpush

@push('js')
<script>
    $(function () {
      $('#tablesuratmasuk').DataTable({
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

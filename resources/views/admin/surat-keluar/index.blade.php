@extends('layouts.admin', ['title' => 'Surat Keluar', 'icon' => 'fas fa-envelope'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.surat-keluar.create') }}" class="btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus"></i> Tambah Data</a>
            </div>
            <!-- /.card-header -->
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
                            <th>Status Approve</th>
                            <th>Akses Surat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat_keluar as $val)
                        <tr>
                            <td>{{ $val->nomor_agenda }}</td>
                            <td>{{ $val->nomor_surat }}</td>
                            <td>{{ $val->nama_surat }}</td>
                            <td>{{ $val->ditujukan_kepada }}</td>
                            <td>{{  \Carbon\Carbon::parse($val->tanggal_surat)->translatedFormat(' d F Y') }}</td>
                            <td>{{  \Carbon\Carbon::parse($val->tanggal_keluar)->translatedFormat(' d F Y') }}</td>
                            <td>
                                @if($val->status_approve == 'Disetujui')
                                    <span class="badge badge-success">{{ $val->status_approve }}</span>
                                @elseif($val->status_approve == 'Prosess')
                                    <span class="badge badge-secondary">{{ $val->status_approve }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $val->status_approve }}</span>
                                @endif
                            </td>
                            <td>
                                @foreach ($val->akses_surat_keluar as $item)
                                    <span class="badge badge-primary">{{ $item->jabatan->nama }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.surat-keluar.show', $val->id) }}" class="btn btn-xs btn-info mr-2 shadow-sm"><i class="far fa-eye"></i> Detail</a>
                                <a href="{{ route('admin.surat-keluar.edit', $val->id) }}" class="btn btn-xs btn-success mr-2 shadow-sm"><i class="far fa-edit"></i> edit</a>
                                <form action="{{ route('admin.surat-keluar.destroy', $val->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-xs btn-danger border-0 shadow-sm" onclick="return confirm('Yakin, untuk menghapus surat keluar dengan nomor agenda {{ $val->nomor_agenda }} ?')"><i class="far fa-trash-alt"></i> hapus</button>
                                </form>
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

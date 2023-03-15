@extends('layouts.admin', ['title' => 'Surat Masuk', 'icon' => 'fas fa-envelope-open-text'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.surat-masuk.create') }}" class="btn btn-sm btn-primary shadow-sm"><i
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
                            <th>Pengirim</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Diterima</th>
                            <th>Disposisi Surat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat_masuk as $val)
                        <tr>
                            <td>{{ $val->nomor_agenda }}</td>
                            <td>{{ $val->nomor_surat }}</td>
                            <td>{{ $val->nama_surat }}</td>
                            <td>{{ $val->nama_pengirim }}</td>
                            <td>{{  \Carbon\Carbon::parse($val->tanggal_surat)->translatedFormat('d F Y') }}</td>
                            <td>{{  \Carbon\Carbon::parse($val->tanggal_diterima)->translatedFormat('d F Y') }}</td>
                            <td>
                                @foreach ($val->disposisi_surat_masuk as $item)
                                    <span class="badge badge-primary">{{ $item->jabatan->nama }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.surat-masuk.show', $val->id) }}" class="btn btn-xs btn-info mr-2 shadow-sm"><i class="far fa-eye"></i> Detail</a>
                                <a href="{{ route('admin.surat-masuk.edit', $val->id) }}" class="btn btn-xs btn-success mr-2 shadow-sm"><i class="far fa-edit"></i> edit</a>
                                <form action="{{ route('admin.surat-masuk.destroy', $val->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-xs btn-danger border-0 shadow-sm" onclick="return confirm('Yakin, untuk menghapus surat masuk dengan nomor agenda {{ $val->nomor_agenda }} ?')"><i class="far fa-trash-alt"></i> hapus</button>
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

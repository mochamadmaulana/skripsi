@extends('layouts.kepala-sekolah', ['title' => 'Surat Masuk', 'icon' => 'fas fa-envelope-open-text'])

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
                            <th>Pengirim</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Diterima</th>
                            <th>Akses Surat</th>
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
                                @foreach ($val->akses_surat_masuk as $item)
                                    <span class="badge badge-primary">{{ $item->jabatan->nama }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('kepala-sekolah.surat-masuk.show', $val->id) }}" class="btn btn-xs btn-info mr-2 shadow-sm"><i class="far fa-eye"></i> Detail</a>
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

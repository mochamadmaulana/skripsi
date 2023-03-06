@extends('layouts.admin', ['title' => 'Jabatan','icon' => 'fas fa-server'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.data-master.jabatan.create') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus"></i>
                    Tambah Data</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tablejabatan" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jabatan as $val)
                        <tr>
                            <td>{{ $val->nama }}</td>
                            <td>
                                <a href="{{ route('admin.data-master.jabatan.edit',$val->id) }}" class="btn btn-xs btn-success mr-2 shadow-sm"><i class="fas fa-edit"></i> edit</a>
                                <form action="{{ route('admin.data-master.jabatan.destroy', $val->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-xs btn-danger border-0 shadow-sm" onclick="return confirm('Yakin, untuk menghapus {{ $val->nama }} ?')"><i class="fas fa-trash-alt"></i> hapus</button>
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
      $('#tablejabatan').DataTable({
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

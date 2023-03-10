@extends('layouts.admin', ['title' => 'Pengguna', 'icon' => 'fas fa-users'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.pengguna.create') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus"></i> Tambah Data</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tablePengguna" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Role</th>
                            <th>Aktif</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengguna as $val)
                        <tr>
                            <td>
                                <a href="{{ asset('avatar/'.$val->avatar) }}" target="_blank"><img src="{{ asset('avatar/'.$val->avatar) }}" class="img-circle elevation-2" alt="Avatar" width="60vh" height="60vh"></a>
                            </td>
                            <td>{{ $val->nama }}</td>
                            <td>{{ $val->username }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->jabatan->nama }}</td>
                            <td><span class="badge badge-primary">{{ $val->role }}</span></td>
                            <td>
                                @if ($val->aktif == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($val->username !== auth()->user()->username)
                                <a href="{{ route('admin.pengguna.edit', $val->id) }}" class="btn btn-xs btn-success mr-2 shadow-sm"><i class="far fa-edit"></i> edit</a>
                                <form action="{{ route('admin.pengguna.destroy', $val->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-xs btn-danger border-0 shadow-sm" onclick="return confirm('Yakin, untuk menghapus pengguna {{ $val->nama }} ?')"><i class="far fa-trash-alt"></i> hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item active">List Data</li>
@endpush

@push('js')
<script>
    $(function () {
      $('#tablePengguna').DataTable({
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

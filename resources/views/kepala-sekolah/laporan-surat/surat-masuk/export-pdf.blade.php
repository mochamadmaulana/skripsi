<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') ?? 'APP-SK' }} | {{ $title ?? '' }}</title>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('templates/dist/css/adminlte.min.css') }}">
</head>
<body>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No. Agenda</th>
                                        <th>Nomor Surat</th>
                                        <th>Nama Surat</th>
                                        <th>Pengirim</th>
                                        <th>Tanggal Surat</th>
                                        <th>Tanggal Diterima</th>
                                        <th>Perihal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($surat_masuk as $item)
                                    <tr>
                                        <td>{{ $item->nomor_agenda }}</td>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->nama_surat }}</td>
                                        <td>{{ $item->nama_pengirim }}</td>
                                        <td class="@if(request()->get('pilih_tanggal') == 'Tanggal Surat') table-success @endif">{{  \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('l, d F Y') }}</td>
                                        <td class="@if(request()->get('pilih_tanggal') == 'Tanggal Diterima') table-success @endif">{{  \Carbon\Carbon::parse($item->tanggal_diterima)->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ $item->perihal }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- jQuery -->
    <script src="{{ asset('templates/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('templates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('templates/dist/js/adminlte.min.js') }}"></script>
</body>

</html>

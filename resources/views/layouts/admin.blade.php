<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') ?? 'APP-SK' }} | {{ $title ?? '' }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('templates/dist/css/adminlte.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/toastr/toastr.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <h4 class="brand-text font-weight-light"><b>SMA</b> Genta Syaputra</h4>
            {{-- <img src="{{ asset('templates/dist/img/loading-spiner.gif') }}" alt="Loading..." height="100" width="100"> --}}
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('templates/img/logo-sma.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-2" style="opacity: .8">
                <span class="brand-text font-weight-light ml-3">APSK <sup class="ml-2">V 0.1</sup></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="ml-2">
                        <img src="{{ asset('avatar/'.auth()->user()->avatar) }}" class="img-circle elevation-2" alt="Avatar" alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->nama ?? 'No Data' }}</a>
                        <small class="text-success">
                            <i>{{ auth()->user()->jabatan->nama ?? 'No Data' }}</i>
                            {{-- <i>{{ auth()->user()->jabatan->nama_jabatan ?? 'No Data' }}</i> --}}
                        </small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">MENU</li>

                        <!-- Master Data -->
                        <li class="nav-item {{ request()->is('admin/data-master*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/data-master*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-server"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.data-master.jabatan.index') }}" class="nav-link {{ (request()->is('admin/data-master/jabatan*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jabatan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Surat Masuk -->
                        <li class="nav-item">
                            <a href="{{ route('admin.surat-masuk.index') }}" class="nav-link {{ (request()->is('admin/surat-masuk*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope-open-text"></i>
                                <p>
                                    Surat Masuk
                                </p>
                            </a>
                        </li>

                        <!-- Surat Keluar -->
                        <li class="nav-item">
                            <a href="{{ route('admin.surat-keluar.index') }}" class="nav-link {{ (request()->is('admin/surat-keluar*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>
                                    Surat Keluar
                                </p>
                            </a>
                        </li>

                        <!-- Arsip Surat -->
                        <li class="nav-item {{ request()->is('admin/arsip-surat*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/arsip-surat*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    Arsip Surat
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.arsip-surat.surat-masuk.index') }}" class="nav-link {{ (request()->is('admin/arsip-surat/surat-masuk*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.arsip-surat.surat-keluar.index') }}" class="nav-link {{ (request()->is('admin/arsip-surat/surat-keluar*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Laporan Surat -->
                        <li class="nav-item {{ request()->is('admin/laporan-surat*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is('admin/laporan-surat*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Laporan Surat
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.laporan-surat.surat-masuk.index') }}" class="nav-link {{ (request()->is('admin/laporan-surat/surat-masuk*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.laporan-surat.surat-keluar.index') }}" class="nav-link {{ (request()->is('admin/laporan-surat/surat-keluar*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Pengguna -->
                        <li class="nav-item">
                            <a href="{{ route('admin.pengguna.index') }}" class="nav-link {{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Pengguna
                                </p>
                            </a>
                        </li>

                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ request()->is('admin/profile*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>

                        <!-- Logout -->
                        <li class="nav-item mb-5">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><i class="{{ $icon ?? '' }}"></i> {{ $title ?? '' }}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @stack('breadcrumb')
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Small boxes (Stat box) -->
                    @yield('content')
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="https://smagentasyaputra.sch.id/" target="_blank">SMA GENTA SYAPUTRA</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>{{ Auth::user()->role }}</b> | V 0.1
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @stack('modal')

    <!-- jQuery -->
    <script src="{{ asset('templates/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('templates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('templates/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('templates/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('templates/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('templates/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('templates/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('templates/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('templates/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('templates/dist/js/adminlte.min.js') }}"></script>
    @stack('js')

    @if(session()->has('success'))
    <script>
        $(document).ready(function () {
            toastr.success('{{ session("success") }}')
        })
    </script>
    @endif
    @if(session()->has('error'))
    <script>
        $(document).ready(function () {
            toastr.error('{{ session("error") }}')
        })
    </script>
    @endif
</body>

</html>

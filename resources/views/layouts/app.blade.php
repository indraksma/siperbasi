<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Sistem Informasi Pelayanan Publik Pengembalian Barangbukti atau Sitaan" />
    <meta name="author" content="Seksi Pengembangan Aplikasi Bidang E-Government Dinkominfo Banjarnegara" />
    <link rel="icon" type="image/x-icon" href="{{ asset('dist/img/favicon.png') }}" />
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('headscripts')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('dist/img/kejaksaan.png') }}" alt="AdminLTE Logo" class="brand-image">
                <span class="brand-text font-weight-bold">SI-PERBASI</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ url('/admin/home') }}"
                                class="{{ request()->routeIs('admin.home') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/penyitaan') }}"
                                class="{{ request()->routeIs(['admin.penyitaan', 'admin.addpenyitaan']) ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-box"></i>
                                <p>
                                    Penyitaan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/putusan') }}"
                                class="{{ request()->routeIs('admin.putusan') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Putusan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/barangbukti') }}"
                                class="{{ request()->routeIs('admin.barangbukti') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    Barang Bukti
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/pengumuman') }}"
                                class="{{ request()->routeIs('admin.pengumuman') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-bullhorn"></i>
                                <p>
                                    Pengumuman Lelang
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/survey') }}"
                                class="{{ request()->routeIs('admin.survey') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Survey Kepuasan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/setting') }}"
                                class="{{ request()->routeIs('admin.setting') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Setting
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link">
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
        {{ $slot }}
        <!-- /.content-wrapper -->

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Default to the left -->
            <strong>Copyright &copy; 2024</strong>. All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::flash />
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    @stack('footscripts')
</body>

</html>

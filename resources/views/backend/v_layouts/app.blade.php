<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">

    <!-- Tinycon untuk badge favicon -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinycon/0.6.8/tinycon.min.js"></script> --}}

    {{-- Font Poppins --}}
    <link rel="stylesheet" href="{{ asset('font/poppins-font.css') }}">

    <title>SIADU</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    {{-- <link href="{{ asset('backend/dist/css/sidebar.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('backend/dist/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

@php
    // Warna dan shape bisa diubah lewat class CSS di bawah
    $logoBgColor = '#FFFFFFFF'; // Ganti sesuai kebutuhan
    $logoBorderRadius = '50%'; // Bisa '8px', '50%' (lingkaran), dll
@endphp

<style>
    .left-sidebar {
        transition: all 0.3s ease
    }

    header.topbar {
        transition: all 0.3s ease
    }

    .page-wrapper {
        transition: all 0.3s ease
    }

    .custom-logo-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #FFFFFFFF;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin-right: 10px;
        margin-left: 15px;
        transition: background 0.3s;
    }

    .custom-logo-wrapper img {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .notif-shape {
        border-radius: 100%;
    }

    .mobile-notif-size {
        font-size: 0.75rem;
        font-weight: bold;
        font-family: 'Poppins', Arial, Helvetica, sans-serif !important;
        font-style: normal;
        position: absolute;
        top: 13px;
        right: -2px;
    }

    .pc-notif-size {
        font-size: 0.7rem;
        font-weight: bold;
        font-family: 'Poppins', Arial, Helvetica, sans-serif !important;
        font-style: normal;
        position: absolute;
        top: -8px;
        right: -8px;
    }
</style>


<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    {{-- @include('backend.partials.navbar') --}}

    <div id="main-wrapper">

        <!-- Modal Notifikasi (role-based) -->
        @if (Auth::user()->role == 0)
            <div class="modal fade none-border" id="notifikasiUser">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="bi bi-bell-fill"></i>
                                <strong>Notifikasi</strong>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="max-height: 350px; overflow-y: auto;">
                                        <ul id="notifListUser" class="list-group"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" id="toggleNotifSoundUser"
                                    class="btn btn-light d-flex align-items-center">
                                    <i id="notifSoundIconUser" class="bi bi-volume-up-fill"></i>
                                    <span id="notifSoundTextUser" class=""></span>
                                </button>
                            </div>
                            <div>
                                <button type="button" id="hapusSemuaNotifUser" class="btn btn-danger waves-effect"
                                    style="display:none;">
                                    <i class="bi bi-trash3-fill"></i>
                                    Hapus Semua
                                </button>
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Auth::user()->role == 1)
            <div class="modal fade none-border" id="notifikasiAdmin">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="bi bi-bell-fill"></i>
                                <strong>Notifikasi Admin</strong>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="max-height: 350px; overflow-y: auto;">
                                        <ul id="notifListAdmin" class="list-group"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" id="toggleNotifSoundAdmin"
                                    class="btn btn-light d-flex align-items-center">
                                    <i id="notifSoundIconAdmin" class="bi bi-volume-up-fill"></i>
                                    <span id="notifSoundTextAdmin" class=""></span>
                                </button>
                            </div>
                            <div>
                                <button type="button" id="hapusSemuaNotifAdmin" class="btn btn-danger waves-effect"
                                    style="display:none;">
                                    <i class="bi bi-trash3-fill"></i>
                                    Hapus Semua
                                </button>
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Auth::user()->role == 2)
            <div class="modal fade none-border" id="notifikasiPetugas">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="bi bi-bell-fill"></i>
                                <strong>Notifikasi Petugas</strong>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="max-height: 350px; overflow-y: auto;">
                                        <ul id="notifListPetugas" class="list-group"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" id="toggleNotifSoundPetugas"
                                    class="btn btn-light d-flex align-items-center">
                                    <i id="notifSoundIconPetugas" class="bi bi-volume-up-fill"></i>
                                    <span id="notifSoundTextPetugas" class=""></span>
                                </button>
                            </div>
                            <div>
                                <button type="button" id="hapusSemuaNotifPetugas"
                                    class="btn btn-danger waves-effect" style="display:none;">
                                    <i class="bi bi-trash3-fill"></i>
                                    Hapus Semua
                                </button>
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <header class="topbar" data-navbarbg="skin5" style="position: fixed; width: 100%; z-index: 1000;">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close">
                        </i>
                    </a>
                    @if (Auth::user()->role == 0)
                        <a class="navbar-brand d-flex align-items-center" href="{{ route('backend.beranda.user') }}"
                            style="padding-left: 0px; padding-right: 0px;">
                            <span class="custom-logo-wrapper">
                                <img src="{{ asset('image/logo.png') }}" alt="homepage" class="light-logo" />
                            </span>
                            <span alt="homepage" class="light-logo font-weight-bold">SIADU</span>
                        </a>
                    @elseif(Auth::user()->role == 1)
                        <a class="navbar-brand d-flex align-items-center" href="{{ route('backend.beranda') }}"
                            style="padding-left: 0px; padding-right: 0px;">
                            <span class="custom-logo-wrapper">
                                <img src="{{ asset('image/logo.png') }}" alt="homepage" class="light-logo" />
                            </span>
                            <span alt="homepage" class="light-logo font-weight-bold">SIADU</span>
                        </a>
                    @elseif(Auth::user()->role == 2)
                        <a class="navbar-brand d-flex align-items-center"
                            href="{{ route('backend.petugas.dashboard') }}"
                            style="padding-left: 0px; padding-right: 0px;">
                            <span class="custom-logo-wrapper">
                                <img src="{{ asset('image/logo.png') }}" alt="homepage" class="light-logo" />
                            </span>
                            <span alt="homepage" class="light-logo font-weight-bold">SIADU</span>
                        </a>
                    @endif
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        @if (Auth::user()->role == 0)
                            <i class="ti-more" style="position: relative;">
                                <span id="notifBadgeMobileUser"
                                    class="badge badge-danger notif-shape mobile-notif-size"
                                    style="display: none;">0</span>
                            </i>
                        @elseif (Auth::user()->role == 1)
                            <i class="ti-more" style="position: relative;">
                                <span id="notifBadgeMobileAdmin"
                                    class="badge badge-danger notif-shape mobile-notif-size"
                                    style="display: none;">0</span>
                            </i>
                        @elseif (Auth::user()->role == 2)
                            <i class="ti-more" style="position: relative;">
                                <span id="notifBadgeMobilePetugas"
                                    class="badge badge-danger notif-shape mobile-notif-size"
                                    style="display: none;">0</span>
                            </i>
                        @else
                            <h1>Login Terlebih dahulu!!!</h1>
                        @endif
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5"
                    style="background-color: #fff;">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-right">

                        {{-- Notifikasi User --}}
                        <li class="nav-item dropdown">
                            @if (Auth::user()->role == 0)
                                <a class="nav-link" href="#" id="notifBellUser" data-toggle="modal"
                                    data-target="#notifikasiUser">
                                    <i class="bi bi-bell" style="font-size: 1.5rem; position: relative;">
                                        <span id="notifBadge" class="badge badge-danger notif-shape pc-notif-size"
                                            style="display:none;">0</span>
                                    </i>
                                </a>
                            @elseif (Auth::user()->role == 1)
                                <a class="nav-link" href="#" id="notifBellAdmin" data-toggle="modal"
                                    data-target="#notifikasiAdmin">
                                    <i class="bi bi-bell" style="font-size: 1.5rem; position: relative;">
                                        <span id="notifBadge" class="badge badge-danger notif-shape pc-notif-size"
                                            style="display:none;">0</span>
                                    </i>
                                </a>
                            @elseif (Auth::user()->role == 2)
                                <a class="nav-link" href="#" id="notifBellPetugas" data-toggle="modal"
                                    data-target="#notifikasiPetugas">
                                    <i class="bi bi-bell" style="font-size: 1.5rem; position: relative;">
                                        <span id="notifBadge" class="badge badge-danger notif-shape pc-notif-size"
                                            style="display:none;">0</span>
                                    </i>
                                </a>
                            @endif
                        </li>


                        <li class="nav-item dropdown">
                            {{-- <div> --}}
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic d-flex align-items-center"
                                href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->foto)
                                    <img src="{{ asset('storage/img-user/' . Auth::user()->foto) }}" alt="user"
                                        class="rounded-circle" width="31" style="margin-right: 7px;">
                                @else
                                    <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="user"
                                        class="rounded-circle" width="31" style="margin-right: 7px;">
                                @endif

                                {{ Auth::user()->nama }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                @if (Auth::user()->role == 0)
                                    <a class="dropdown-item"
                                        href="{{ route('backend.user.edit', ['id' => Auth::user()->id_user]) }}">
                                        <i class="ti-user m-r-5 m-l-5"></i> Profil Saya
                                    </a>
                                @elseif(Auth::user()->role == 1)
                                    <a class="dropdown-item"
                                        href="{{ route('backend.admin.edit', Auth::user()->id_user) }}">
                                        <i class="ti-user m-r-5 m-l-5"></i> Profil Saya
                                    </a>
                                @elseif(Auth::user()->role == 2)
                                    <a class="dropdown-item"
                                        href="{{ route('backend.petugas.edit', Auth::user()->id_user) }}">
                                        <i class="ti-user m-r-5 m-l-5"></i> Profil Saya
                                    </a>
                                @endif
                                <a class="dropdown-item logout-confirm" href="">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Keluar
                                </a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin5" style="position: fixed; z-index: 999;">
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        {{-- MENU UNTUK USER --}}
                        @if (Auth::user()->role == 0)
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('backend.beranda.user') }}" aria-expanded="false">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span class="hide-menu">Beranda</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="m-r-10 mdi mdi-note-text"></i>
                                    <span class="hide-menu">Aduan</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('backend.user.riwayataduan') }}" class="sidebar-link">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Riwayat Aduan</span>
                                        </a>
                                    </li>
                                    {{-- <li class="sidebar-item">
                                <a href="" class="sidebar-link">
                                    <i class="mdi mdi-chevron-right"></i>
                                    <span class="hide-menu">Coloumn Menu 2</span>
                                </a>
                            </li> --}}
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('backend.user.riwayat_tindaklanjut') }}">
                                    <i class="mdi mdi-check-circle"></i>
                                    <span class="hide-menu">Riwayat Tindak Lanjut</span>
                                </a>
                            </li>
                        @endif

                        {{-- MENU UNTUK ADMIN --}}
                        @if (Auth::user()->role == 1)
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('backend.beranda') }}" aria-expanded="false">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span class="hide-menu">Beranda</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="mdi mdi-account"></i>
                                    <span class="hide-menu">User</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ route('backend.user.showUser') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Admin & Petugas</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ route('backend.user.masyarakat') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">User/Masyarakat</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="bi bi-info-circle-fill"></i>
                                    <span class="hide-menu">Tindak Lanjut</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    {{-- Untuk admin --}}
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ route('backend.tindaklanjut.index') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Tindak Lanjut</span>
                                        </a>
                                    </li>

                                    {{-- <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('backend.admin.tindaklanjut.belumselesai') }}">
                                    <i class="mdi mdi-chevron-right"></i>
                                    <span class="hide-menu">Tindak Lanjut Belum Selesai</span>
                                </a>
                            </li> --}}

                                    <li class="sidebar-item">
                                        <a class="sidebar-link"
                                            href="{{ route('backend.admin.tindaklanjut.petugas') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Riwayat Tindak Lanjut</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="mdi mdi-receipt"></i>
                                    <span class="hide-menu">Laporan</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ route('backend.laporan.user') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Laporan User</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ route('backend.laporan.petugasadmin') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Laporan Petugas & Admin</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ route('backend.laporan.pengaduan') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Laporan Pengaduan</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ route('backend.laporan.tindaklanjut') }}">
                                            <i class="mdi mdi-chevron-right"></i>
                                            <span class="hide-menu">Laporan Tindak Lanjut</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{-- MENU UNTUK PETUGAS --}}
                        @if (Auth::user()->role == 2)
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('backend.petugas.dashboard') }}" aria-expanded="false">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span class="hide-menu">Beranda</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('backend.petugas.pengaduan') }}">
                                    <i class="mdi mdi-note-text"></i>
                                    <span class="hide-menu">Pengaduan</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('backend.petugas.tindaklanjut') }}">
                                    <i class="mdi mdi-check-circle"></i>
                                    <span class="hide-menu">Riwayat Tindak Lanjut</span>
                                </a>
                            </li>
                            {{-- <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('backend.petugas.edit') }}">
                            <i class="mdi mdi-account"></i>
                            <span class="hide-menu">Edit Profil</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('backend.petugas.gantipassword') }}">
                            <i class="mdi mdi-lock"></i>
                            <span class="hide-menu">Ganti Password</span>
                        </a>
                    </li> --}}
                        @endif
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        </aside>

        <div class="page-wrapper">
            {{-- Isi konten --}}
            <div class="container-fluid" style="margin-top: 60px; padding-top: 20px;">
                @yield('content')
            </div>
            {{-- Akhir isi konten --}}
            <footer class="footer text-center">
                SIADU &copy; {{ date('Y') }}. All Rights Reserved.
            </footer>
        </div>
    </div>

    <audio id="notifSound" src="{{ asset('sound/notif.mp3') }}" preload="auto"></audio>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinycon/0.6.8/tinycon.min.js"></script> --}}
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('backend/dist/js/waves.js') }}"></script>
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script>
        $('#zero_config').DataTable();
    </script>
    <form id="keluar-app" action="{{ route('backend.logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}"
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    <script>
        function previewFoto() {
            const foto = document.querySelector('input[name="foto"]');
            const fotoPreview = document.querySelector('.foto-preview');
            const fileReader = new FileReader();
            fileReader.readAsDataURL(foto.files[0]);
            fileReader.onload = function(e) {
                fotoPreview.style.display = 'block';
                fotoPreview.src = e.target.result;
            }
        }
    </script>

    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var konfdelete = $(this).data("konf-delete");
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                html: "Data yang dihapus <strong>" + konfdelete + "</strong> tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, dihapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('.logout-confirm').click(function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Anda yakin ingin keluar dari aplikasi ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('keluar-app').submit();
                }
            });
        });
    </script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        const ckeditorElem = document.querySelector('#ckeditor');
        if (ckeditorElem) {
            ClassicEditor
                .create(ckeditorElem)
                .catch(error => {
                    console.error(error);
                });
        }
    </script>

    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.iife.js"></script>
    <script>
        @php
            $role = Auth::user()->role;
            $notifListId = $role == 0 ? 'notifListUser' : ($role == 1 ? 'notifListAdmin' : 'notifListPetugas');
            $notifBadgeId = 'notifBadge';
            $notifBadgeMobileId = $role == 0 ? 'notifBadgeMobileUser' : ($role == 1 ? 'notifBadgeMobileAdmin' : 'notifBadgeMobilePetugas');
            $hapusSemuaId = $role == 0 ? 'hapusSemuaNotifUser' : ($role == 1 ? 'hapusSemuaNotifAdmin' : 'hapusSemuaNotifPetugas');
            $modalId = $role == 0 ? 'notifikasiUser' : ($role == 1 ? 'notifikasiAdmin' : 'notifikasiPetugas');

            $routeGet = $role == 0 ? route('backend.user.getnotifikasi') : ($role == 1 ? route('backend.admin.getnotifikasi') : route('backend.petugas.getnotifikasi'));
            $routeCount = $role == 0 ? route('backend.user.countnotifikasiunread') : ($role == 1 ? route('backend.admin.countnotifikasiunread') : route('backend.petugas.countnotifikasiunread'));
            $routeRead = $role == 0 ? route('backend.user.readnotifikasi') : ($role == 1 ? route('backend.admin.readnotifikasi') : route('backend.petugas.readnotifikasi'));
            $routeDeleteAll = $role == 0 ? route('backend.user.deleteallnotifikasi') : ($role == 1 ? route('backend.admin.deleteallnotifikasi') : route('backend.petugas.deleteallnotifikasi'));
            $toggleId = $role == 0 ? 'toggleNotifSoundUser' : ($role == 1 ? 'toggleNotifSoundAdmin' : 'toggleNotifSoundPetugas');
            $iconId = $role == 0 ? 'notifSoundIconUser' : ($role == 1 ? 'notifSoundIconAdmin' : 'notifSoundIconPetugas');
            $textId = $role == 0 ? 'notifSoundTextUser' : ($role == 1 ? 'notifSoundTextAdmin' : 'notifSoundTextPetugas');
        @endphp

        @if (Auth::check())
            window.Echo = new window.Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true
            });

            document.addEventListener("DOMContentLoaded", function() {
                fetch('{{ $routeCount }}')
                    .then(res => res.json())
                    .then(data => {
                        updateNotifBadges(data.count);
                    })
                    .catch(err => console.error("Gagal ambil jumlah notifikasi:", err));
            });

            let notifMuted = localStorage.getItem('notifMuted') === '1';

            function updateNotifSoundUI() {
                const icon = document.getElementById('{{ $iconId }}');
                const text = document.getElementById('{{ $textId }}');
                if (icon && text) {
                    if (notifMuted) {
                        icon.className = 'bi bi-volume-mute-fill';
                    } else {
                        icon.className = 'bi bi-volume-up-fill';
                    }
                }
            }

            const toggleBtn = document.getElementById('{{ $toggleId }}');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    notifMuted = !notifMuted;
                    localStorage.setItem('notifMuted', notifMuted ? '1' : '0');
                    updateNotifSoundUI();
                });
            }

            updateNotifSoundUI();

            function playNotifSound() {
                if (!notifMuted) {
                    document.getElementById('notifSound').play();
                }
            }

            // Echo.channel('user-notif.{{ Auth::user()->id_user }}')
            //     .listen('UserNotification', (e) => {
            //         addNotifToList(e.title, e.message, e.url, e.id_notifikasi);
            //         playNotifSound();
            //     });

            Echo.channel('user-notif.{{ Auth::user()->id_user }}')
                .listen('UserNotification', (e) => {
                    addNotifToList(e.title, e.message, e.url, e.id_notifikasi);
                    playNotifSound();
                    // Tambahkan ini:
                    fetch('{{ $routeCount }}')
                        .then(res => res.json())
                        .then(data => {
                            updateNotifBadges(data.count);
                        });
                });

            function addNotifToList(title, message, url, id_notifikasi = null) {
                let notifList = document.getElementById('{{ $notifListId }}');
                let li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.style.cursor = 'pointer';

                let contentDiv = document.createElement('div');
                contentDiv.innerHTML = `<b>${title}</b><br>${message}`;
                contentDiv.onclick = function() {
                    window.location.href = url;
                };

                let delBtn = document.createElement('button');
                delBtn.className = 'btn btn-sm btn-danger p-1 ml-2';
                delBtn.innerHTML = '<i class="bi bi-trash"></i>';
                delBtn.onclick = function(e) {
                    e.stopPropagation();
                    hapusNotif(id_notifikasi, li);
                };

                li.appendChild(contentDiv);
                if (id_notifikasi) li.appendChild(delBtn);

                notifList.append(li);

                fetch('{{ $routeCount }}')
                    .then(response => response.json())
                    .then(data => {
                        // updateNotifBadges(data.count);
                    });
            }

            $('#{{ $modalId }}').on('show.bs.modal', function() {
                let notifList = document.getElementById('{{ $notifListId }}');
                let hapusSemuaBtn = document.getElementById('{{ $hapusSemuaId }}');

                notifList.innerHTML =
                    '<li class="list-group-item text-center text-muted">Memuat notifikasi...</li>';

                fetch('{{ $routeGet }}')
                    .then(response => response.json())
                    .then(data => {
                        notifList.innerHTML = '';
                        if (data.length === 0) {
                            notifList.innerHTML =
                                '<li class="list-group-item text-center text-muted">Belum ada notifikasi.</li>';
                            hapusSemuaBtn.style.display = 'none';
                        } else {
                            data.forEach(function(notif) {
                                addNotifToList(notif.title, notif.pesan, notif.url, notif
                                    .id_notifikasi);
                            });
                            hapusSemuaBtn.style.display = '';
                        }
                    });

                fetch('{{ $routeRead }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    }
                }).then(() => {
                    updateNotifBadges(0);
                });
            });

            function updateNotifBadges(count) {
                let notifBadge = document.getElementById('{{ $notifBadgeId }}');
                let notifBadgeMobile = document.getElementById('{{ $notifBadgeMobileId }}');

                [notifBadge, notifBadgeMobile].forEach(function(badge) {
                    if (badge) {
                        if (count > 0) {
                            badge.style.display = '';
                            badge.textContent = count;
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
            }

            // Hapus satu notifikasi
            function hapusNotif(id_notifikasi, li) {
                Swal.fire({
                    title: 'Hapus Notifikasi?',
                    text: 'Notifikasi ini akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let deleteUrl = '';
                        @if ($role == 0)
                            deleteUrl = '/user/notifikasi/' + id_notifikasi;
                        @elseif ($role == 1)
                            deleteUrl = '/admin/notifikasi/' + id_notifikasi;
                        @elseif ($role == 2)
                            deleteUrl = '/backend/petugas/notifikasi/' + id_notifikasi;
                        @endif

                        fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        }).then(() => {
                            li.remove();
                            fetch('{{ $routeCount }}')
                                .then(response => response.json())
                                .then(data => {
                                    updateNotifBadges(data.count);
                                });
                        });
                    }
                });
            }

            // Hapus semua notifikasi (event delegation, selalu aktif)
            $(document).on('click', '#{{ $hapusSemuaId }}', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Semua Notifikasi?',
                    text: 'Semua notifikasi akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus Semua',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ $routeDeleteAll }}', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        }).then(() => {
                            document.getElementById('{{ $notifListId }}').innerHTML =
                                '<li class="list-group-item text-center text-muted">Belum ada notifikasi.</li>';
                            updateNotifBadges(0);
                            document.getElementById('{{ $hapusSemuaId }}').style.display = 'none';
                        });
                    }
                });
            });
        @endif

        // Panggilan updateNotifBadges hanya boleh dilakukan setelah DOM siap
        document.addEventListener("DOMContentLoaded", function() {
            fetch('{{ $routeCount }}')
                .then(res => res.json())
                .then(data => {
                    updateNotifBadges(data.count);
                });
        });
    </script>

    @yield('script')

</body>

</html>

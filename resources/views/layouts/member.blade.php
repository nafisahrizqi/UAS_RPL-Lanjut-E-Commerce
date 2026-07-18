<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Member Portal - {{ config('app.name') }}</title>

    <!-- Google Font: Outfit & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap 4 / Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
        }
        h1, h2, h3, h4, h5, h6, .brand-text {
            font-family: 'Outfit', sans-serif;
        }
        .bg-emerald {
            background-color: #059669 !important;
        }
        .text-emerald {
            color: #059669 !important;
        }
        .border-emerald {
            border-color: #059669 !important;
        }
        .btn-emerald {
            background-color: #059669 !important;
            color: white !important;
            border: none;
            transition: all 0.2s ease-in-out;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-emerald:hover {
            background-color: #047857 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .card-emerald {
            border-top: 3px solid #059669 !important;
        }
        .navbar-emerald {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .main-sidebar-emerald {
            background-color: #1e293b !important;
        }
        .sidebar-dark-emerald .nav-sidebar > .nav-item > .nav-link.active,
        .sidebar-light-emerald .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #059669 !important;
            color: #fff !important;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }
        .badge-cart {
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: 0.65rem;
            padding: 0.2em 0.45em;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(241, 245, 249, 0.8);
        }
    </style>
    @stack('style')
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-emerald navbar-light glass-header">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars text-secondary"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('member.products.index') }}" class="nav-link font-weight-medium text-dark"><i class="fas fa-store mr-1 text-emerald"></i> Marketplace</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto align-items-center">
                <!-- Shopping Cart -->
                <li class="nav-item mr-3">
                    <a class="nav-link position-relative p-2" href="{{ route('member.cart.index') }}">
                        <i class="fas fa-shopping-cart fa-lg text-secondary"></i>
                        @php $cartCount = count(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="badge badge-emerald badge-pill badge-cart">{{ $cartCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="img-circle mr-2"
                            style="width: 32px; height: 32px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image: url({{ Auth::guard('customer')->user()->photo ? asset('storage/' . Auth::guard('customer')->user()->photo) : 'https://ui-avatars.com/api/?background=059669&color=fff&name=' . urlencode(Auth::guard('customer')->user()->name) }});">
                        </div>
                        <span class="d-none d-md-inline font-weight-medium text-dark">{{ Auth::guard('customer')->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;">
                        <span class="dropdown-item dropdown-header bg-light">
                            <strong>{{ Auth::guard('customer')->user()->name }}</strong>
                            <div class="text-xs text-muted">{{ Auth::guard('customer')->user()->number }}</div>
                        </span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('member.dashboard') }}" class="dropdown-item">
                            <i class="fas fa-tachometer-alt mr-2 text-emerald"></i> Dashboard Saya
                        </a>
                        <a href="{{ route('member.orders.index') }}" class="dropdown-item">
                            <i class="fas fa-list-alt mr-2 text-emerald"></i> Riwayat Belanja
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-danger" id="member-logout-button">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </a>
                        <form id="member-logout-form" action="{{ route('member.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar main-sidebar-emerald sidebar-dark-emerald elevation-1">
            <!-- Brand Logo -->
            <a href="{{ route('member.dashboard') }}" class="brand-link" style="border-bottom: 1px solid #334155;">
                <img src="{{ asset('logo.jpg') }}" alt="{{ config('app.name') }}" class="brand-image img-circle"
                    style="opacity: .8">
                <span class="brand-text font-weight-light text-white">PORTAL <strong>NASABAH</strong></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('member.dashboard') }}" class="nav-link {{ Route::is('member.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-header text-muted font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">LOKAL MARKETPLACE</li>
                        <li class="nav-item">
                            <a href="{{ route('member.products.index') }}" class="nav-link {{ Route::is('member.products.*') && !Route::is('member.cart.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-store"></i>
                                <p>Belanja Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('member.cart.index') }}" class="nav-link {{ Route::is('member.cart.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Keranjang Belanja</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('member.orders.index') }}" class="nav-link {{ Route::is('member.orders.*') && !Route::is('member.checkout.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Riwayat Pesanan</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-3 align-items-center">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark font-weight-bold" style="font-size: 1.75rem;">@yield('title')</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer bg-white border-top-0 text-muted py-3">
            <div class="float-right d-none d-sm-inline">
                Kosunu Digital Ecosystem
            </div>
            <strong>Copyright &copy; 2026 <a href="#" class="text-emerald">{{ config('app.name') }}</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            @if (session('success'))
                notification('success', '{{ session('success') }}')
            @elseif (session('error'))
                notification('error', '{{ session('error') }}')
            @endif

            $(document).on('click', '#member-logout-button', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Keluar',
                    text: "Anda yakin ingin keluar dari portal nasabah?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Iya, Keluar',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-emerald px-4 mr-2',
                        cancelButton: 'btn btn-secondary px-4'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#member-logout-form').submit();
                    }
                });
            });
        });

        function notification(icon, message) {
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            }).fire({
                icon: icon,
                title: message,
            })
        }
    </script>
    @stack('script')
</body>

</html>

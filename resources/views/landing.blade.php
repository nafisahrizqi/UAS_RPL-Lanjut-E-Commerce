<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koperasi Kosunu - Cooperative Digital Ecosystem</title>

    <!-- Google Font: Outfit & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap 4 / Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #064e3b 100%);
            min-height: 100vh;
            color: #f8fafc;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 20%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: rgba(16, 185, 129, 0.2);
            filter: blur(100px);
            border-radius: 50%;
            z-index: 0;
        }

        body::after {
            content: "";
            position: absolute;
            bottom: 20%;
            right: 10%;
            width: 400px;
            height: 400px;
            background: rgba(14, 165, 233, 0.15);
            filter: blur(120px);
            border-radius: 50%;
            z-index: 0;
        }

        h1, h2, h3, h4, h5, h6, .brand-text {
            font-family: 'Outfit', sans-serif;
        }

        .navbar-custom {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .hero-section {
            position: relative;
            z-index: 10;
            padding-top: 120px;
            padding-bottom: 80px;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        .portal-tab {
            border: none;
            background: none;
            padding: 12px 20px;
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
            flex: 1;
            text-align: center;
        }

        .portal-tab:hover {
            color: #f8fafc;
        }

        .portal-tab.active {
            color: #10b981;
        }

        .portal-tab.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 20%;
            right: 20%;
            height: 3px;
            background-color: #10b981;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        .portal-tab.staff.active {
            color: #0ea5e9;
        }

        .portal-tab.staff.active::after {
            background-color: #0ea5e9;
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.5);
        }

        .input-group-custom {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            overflow: hidden;
        }

        .input-group-custom:focus-within {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .input-group-custom.staff:focus-within {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        .input-group-custom .form-control {
            background: transparent !important;
            border: none !important;
            color: #f8fafc !important;
            padding: 12px 16px;
            height: auto;
        }

        .input-group-custom .form-control::placeholder {
            color: #64748b;
        }

        .input-group-custom .input-group-text {
            background: transparent;
            border: none;
            color: #64748b;
            padding-right: 16px;
        }

        .btn-emerald-gradient {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            color: white !important;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-emerald-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        }

        .btn-sky-gradient {
            background: linear-gradient(90deg, #0ea5e9 0%, #0284c7 100%);
            color: white !important;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
        }

        .btn-sky-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.35);
        }

        .feature-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .brand-logo-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid rgba(16, 185, 129, 0.5);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center font-weight-bold" href="#">
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="brand-logo-img mr-2">
                <span class="brand-text text-white">Koperasi <strong class="text-emerald">Kosunu</strong></span>
            </a>
        </div>
    </nav>

    <!-- Main Content Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left: Hero Text & Features -->
                <div class="col-lg-7 pr-lg-5 mb-5 mb-lg-0">
                    <span class="badge bg-emerald text-white px-3 py-1 mb-3 font-weight-medium" style="background-color: rgba(16, 185, 129, 0.2) !important; color: #10b981 !important; border: 1px solid rgba(16, 185, 129, 0.3);">
                        Cooperative Digital Ecosystem
                    </span>
                    <h1 class="display-4 font-weight-bold text-white mb-3" style="line-height: 1.15; letter-spacing: -0.02em;">
                        Sistem Informasi Koperasi <br>& <span class="text-emerald">E-Commerce</span>
                    </h1>
                    <p class="lead text-secondary mb-5" style="font-size: 1.15rem; line-height: 1.6;">
                        Selamat datang di portal pelayanan Koperasi Konsumen Usaha Sejahtera Mandiri (Kosunu). Layanan terintegrasi Simpan Pinjam (KSP) dan Marketplace Belanja Anggota secara digital.
                    </p>

                    <!-- Feature List -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon-wrapper mr-3">
                                    <i class="fas fa-piggy-bank fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold text-white mb-1">Simpan Pinjam</h5>
                                    <p class="text-muted text-sm mb-0">Tabungan pokok, wajib, sukarela, & pengajuan kredit cicilan terstruktur.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon-wrapper mr-3" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border-color: rgba(14, 165, 233, 0.2);">
                                    <i class="fas fa-store fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold text-white mb-1">Marketplace Lokal</h5>
                                    <p class="text-muted text-sm mb-0">E-Commerce produk anggota untuk memperluas pemasaran lokal.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon-wrapper mr-3">
                                    <i class="fas fa-exchange-alt fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold text-white mb-1">Potong Saldo Otomatis</h5>
                                    <p class="text-muted text-sm mb-0">Belanja instan dengan pemotongan langsung saldo simpanan sukarela.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon-wrapper mr-3" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border-color: rgba(14, 165, 233, 0.2);">
                                    <i class="fas fa-file-pdf fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold text-white mb-1">Pelaporan Transparan</h5>
                                    <p class="text-muted text-sm mb-0">Cetak riwayat simpanan, cicilan, dan invoice transaksi belanja PDF.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Glassmorphic Member Login Card -->
                <div class="col-lg-5">
                    <div class="card glass-card p-4">
                        <div class="mb-4 text-center">
                            <h4 class="font-weight-bold text-white mb-1">Masuk Portal Anggota</h4>
                            <p class="text-muted text-sm">Silakan login untuk mengakses Simpan Pinjam & Belanja</p>
                        </div>

                        <!-- Error Alerts -->
                        @if($errors->any())
                            <div class="alert alert-danger border-0 mb-4" style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border-radius: 12px;">
                                <ul class="mb-0 pl-3 text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger border-0 mb-4" style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border-radius: 12px; font-size: 0.9rem;">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form action="{{ route('member.login.submit') }}" method="POST">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label class="text-xs font-weight-bold text-uppercase text-secondary mb-2">Username Anggota</label>
                                <div class="input-group input-group-custom">
                                    <input type="text" name="username" class="form-control" placeholder="Masukkan username Anda" value="{{ old('username') }}" required autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="text-xs font-weight-bold text-uppercase text-secondary mb-2">Password</label>
                                <div class="input-group input-group-custom">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                                    <div class="input-group-append" id="toggle-password" style="cursor: pointer;">
                                        <span class="input-group-text" title="Tampilkan Password">
                                            <i class="fas fa-eye" id="password-eye-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label text-sm text-secondary" for="remember" style="cursor: pointer;">Ingat Saya</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-emerald-gradient btn-block shadow-sm">
                                Masuk ke Portal
                            </button>
                            
                            <div class="text-center mt-4 text-sm text-secondary">
                                Belum menjadi anggota? <a href="{{ route('member.register') }}" class="text-emerald font-weight-medium">Daftar Sekarang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Password visibility toggle
            $('#toggle-password').click(function() {
                var passwordField = $('#password');
                var fieldType = passwordField.attr('type');
                var icon = $('#password-eye-icon');
                
                if (fieldType === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    $(this).find('span').attr('title', 'Sembunyikan Password');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    $(this).find('span').attr('title', 'Tampilkan Password');
                }
            });
        });
    </script>
</body>

</html>

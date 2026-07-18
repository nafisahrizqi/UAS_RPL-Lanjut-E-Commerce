<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Anggota - {{ config('app.name') }}</title>
    
    <!-- Google Fonts: Outfit (headings) & Inter (body) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap 4 / AdminLTE core style (for form helpers) -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    
    <style>
        :root {
            --primary: #10b981;
            --primary-hover: #059669;
            --bg-dark-1: #090d16;
            --bg-dark-2: #0f172a;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at center, var(--bg-dark-2) 0%, var(--bg-dark-1) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            color: var(--text-light);
            overflow: hidden;
            position: relative;
        }

        /* Ambient Glow Backdrops */
        .bg-glow-1 {
            position: absolute;
            top: 15%;
            left: 20%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.22) 0%, rgba(16, 185, 129, 0) 70%);
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
            animation: floatGlow 12s ease-in-out infinite;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: 15%;
            right: 20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.14) 0%, rgba(14, 165, 233, 0) 70%);
            filter: blur(90px);
            z-index: 0;
            pointer-events: none;
            animation: floatGlow 16s ease-in-out infinite reverse;
        }

        @keyframes floatGlow {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.1); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(16, 185, 129, 0.04);
            width: 100%;
            max-width: 450px;
            padding: 3rem 2.5rem;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-wrapper {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-img {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            border: 3px solid rgba(16, 185, 129, 0.4);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
            margin-bottom: 1.25rem;
            transition: all 0.5s ease;
        }

        .logo-img:hover {
            transform: rotate(360deg) scale(1.05);
            border-color: var(--primary);
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.45);
        }

        .brand-text {
            font-family: 'Outfit', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-light);
            letter-spacing: -0.02em;
            margin-bottom: 0.35rem;
        }

        .brand-text span {
            color: var(--primary);
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 400;
        }

        /* Custom Form Controls */
        .form-group label {
            font-size: 0.75rem;
            font-weight: 700;
            text-uppercase: true;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group-custom {
            background: rgba(15, 23, 42, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            position: relative;
        }

        .input-group-custom:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            transform: translateY(-1px);
        }

        .input-group-custom .form-control {
            background: transparent !important;
            border: none !important;
            color: var(--text-light) !important;
            padding: 14px 16px;
            height: auto;
            font-size: 0.95rem;
            box-shadow: none !important;
            flex-grow: 1;
        }

        .input-group-custom .form-control::placeholder {
            color: #4b5563;
        }

        .input-group-custom .input-icon-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0 16px;
            cursor: pointer;
            outline: none;
            transition: color 0.2s ease;
        }

        .input-group-custom .input-icon-btn:hover {
            color: var(--text-light);
        }

        /* Custom Checkbox */
        .custom-checkbox-wrapper {
            display: flex;
            align-items: center;
            user-select: none;
        }

        .custom-checkbox-wrapper input {
            display: none;
        }

        .checkbox-box {
            width: 18px;
            height: 18px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            background: rgba(15, 23, 42, 0.4);
            cursor: pointer;
        }

        .custom-checkbox-wrapper input:checked + .checkbox-box {
            background-color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.4);
        }

        .checkbox-box i {
            color: white;
            font-size: 0.7rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .custom-checkbox-wrapper input:checked + .checkbox-box i {
            opacity: 1;
        }

        .checkbox-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            cursor: pointer;
        }

        /* Buttons */
        .btn-emerald-gradient {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            color: white !important;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            cursor: pointer;
            width: 100%;
            outline: none;
        }

        .btn-emerald-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-emerald-gradient:active {
            transform: translateY(0);
        }

        /* Alert styling */
        .custom-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
        }

        .custom-alert i {
            margin-top: 3px;
            margin-right: 10px;
        }

        /* Footer Link */
        .register-hint {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .register-hint a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .register-hint a:hover {
            color: #34d399;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Backdrops -->
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <div class="login-container">
        <div class="glass-card">
            
            <!-- Logo & Brand Header -->
            <div class="logo-wrapper">
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="logo-img">
                <h1 class="brand-text">Koperasi <span>Kosunu</span></h1>
                <p class="subtitle">Portal Belanja & Simpan Pinjam Anggota</p>
            </div>

            <!-- Error Notification -->
            @if(session('error'))
                <div class="custom-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="custom-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('member.login.submit') }}" method="POST">
                @csrf
                
                <div class="form-group mb-4">
                    <label for="username">Username Anggota</label>
                    <div class="input-group-custom">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username Anda" value="{{ old('username') }}" required autofocus>
                        <button type="button" class="input-icon-btn"><i class="fas fa-user"></i></button>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <div class="input-group-custom">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <button type="button" id="toggle-password" class="input-icon-btn" title="Tampilkan Password">
                            <i class="fas fa-eye" id="password-eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label class="custom-checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <div class="checkbox-box">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="checkbox-label">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-emerald-gradient">Masuk ke Portal</button>

                <div class="register-hint">
                    Belum menjadi anggota? <a href="{{ route('member.register') }}">Daftar Sekarang</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    
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
                    $(this).attr('title', 'Sembunyikan Password');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    $(this).attr('title', 'Tampilkan Password');
                }
            });
        });
    </script>
</body>
</html>

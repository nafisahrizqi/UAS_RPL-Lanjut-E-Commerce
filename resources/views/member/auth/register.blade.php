<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Nasabah - {{ config('app.name') }}</title>
    <!-- Google Font: Outfit & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #d1fae5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 2rem 0;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 600px;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }
        .brand-text {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            color: #0f172a;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            color: #64748b;
            font-size: 0.875rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-control-custom {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            height: auto;
            font-size: 0.95rem;
            transition: all 0.2s ease-in-out;
        }
        .form-control-custom:focus {
            background-color: #ffffff;
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
            color: #0f172a;
        }
        .btn-emerald {
            background-color: #059669;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s ease-in-out;
        }
        .btn-emerald:hover {
            background-color: #047857;
            transform: translateY(-1px);
        }
        .logo-img {
            display: block;
            margin: 0 auto 1.5rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
        .text-link {
            color: #059669;
            font-weight: 500;
            text-decoration: none;
        }
        .text-link:hover {
            color: #047857;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <img src="{{ asset('logo.jpg') }}" alt="Logo" class="logo-img">
        <div class="brand-text">Pendaftaran Nasabah Baru</div>
        <div class="subtitle">Bergabung dengan Ekosistem Digital Koperasi Kosunu</div>

        <form action="{{ route('member.register.submit') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label for="nik" class="text-sm font-weight-medium text-secondary">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" id="nik" class="form-control form-control-custom @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="16 Digit NIK Anda" required>
                    @error('nik')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="name" class="text-sm font-weight-medium text-secondary">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control form-control-custom @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama Lengkap sesuai KTP" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label for="phone" class="text-sm font-weight-medium text-secondary">Nomor Telepon/WA</label>
                    <input type="text" name="phone" id="phone" class="form-control form-control-custom @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" required>
                    @error('phone')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="email" class="text-sm font-weight-medium text-secondary">Alamat Email (Opsional)</label>
                    <input type="email" name="email" id="email" class="form-control form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nama@email.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="address" class="text-sm font-weight-medium text-secondary">Alamat Lengkap Tempat Tinggal</label>
                <textarea name="address" id="address" rows="2" class="form-control form-control-custom @error('address') is-invalid @enderror" placeholder="Tuliskan alamat lengkap Anda saat ini" required>{{ old('address') }}</textarea>
                @error('address')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <label for="username" class="text-sm font-weight-medium text-secondary">Username untuk Login</label>
                    <input type="text" name="username" id="username" class="form-control form-control-custom @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Buat username unik Anda (min. 4 karakter)" required>
                    @error('username')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-4">
                    <label for="password" class="text-sm font-weight-medium text-secondary">Password</label>
                    <input type="password" name="password" id="password" class="form-control form-control-custom @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label for="password_confirmation" class="text-sm font-weight-medium text-secondary">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-custom" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-emerald mb-3">Daftar Sekarang</button>

            <div class="text-center text-sm text-secondary mt-2">
                Sudah memiliki akun? <a href="{{ route('member.login') }}" class="text-link">Login di sini</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

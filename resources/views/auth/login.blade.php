<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
    <!-- Primary SEO Meta Tags -->
    <title>Masuk / Login - Sistem Informasi Rekam Medis Omah Terapiku</title>
    <meta name="title" content="Masuk / Login - Sistem Informasi Rekam Medis Omah Terapiku">
    <meta name="description" content="Halaman Masuk Sistem Informasi Manajemen Pelayanan Rekam Medis dan Terapi Terpadu Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur.">
    <meta name="keywords" content="Login Omah Terapiku, Masuk Omah Terapiku, Rekam Medis Terapi, Dinas Sosial Jatim">
    <meta name="author" content="Dinas Sosial Provinsi Jawa Timur - Omah Terapiku">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Omah Terapiku">
    <meta property="og:title" content="Masuk / Login - Sistem Informasi Rekam Medis Omah Terapiku">
    <meta property="og:description" content="Halaman Masuk Sistem Informasi Manajemen Pelayanan Rekam Medis dan Terapi Terpadu Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:locale" content="id_ID">

    <!-- Theme Color & Mobile -->
    <meta name="theme-color" content="#1e40af">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.png')}}">
    <link rel="apple-touch-icon" href="{{asset('images/logo.png')}}">
    
    <!-- CSS Dependencies -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/toastr/css/toastr.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ot-navy: #2D4B7A;
            --ot-navy-hover: #22385c;
            --ot-cyan: #38A5DB;
            --ot-yellow: #F3B329;
            --ot-red: #D9383A;
            --ot-green: #2EB88A;
        }

        * {
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: #eef2f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
            width: 100%;
            max-width: 420px;
            padding: 38px 32px 34px 32px;
            text-align: center;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 14px;
        }

        .main-logo {
            max-height: 85px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 6px rgba(37, 99, 235, 0.15));
        }

        .login-app-title {
            font-size: 15.5px;
            font-weight: 700;
            color: #1e3a8a;
            margin: 0 0 24px 0;
            line-height: 1.45;
            letter-spacing: 0.2px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
            z-index: 2;
        }

        .input-icon-right {
            position: absolute;
            right: 14px;
            color: #94a3b8;
            font-size: 15px;
            cursor: pointer;
            z-index: 2;
            transition: color 0.2s;
        }

        .input-icon-right:hover {
            color: var(--ot-navy);
        }

        .form-control-custom {
            width: 100%;
            height: 46px;
            padding: 10px 42px 10px 40px;
            border: 1.5px solid #cbd5e1;
            border-radius: 4px;
            font-size: 13.5px;
            color: #1e293b;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            background-color: #ffffff;
            border-color: #1888f0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(24, 136, 240, 0.2);
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
            font-size: 13px;
        }

        .btn-submit {
            width: 100%;
            height: 46px;
            background: linear-gradient(135deg, #1888f0 0%, #1565c0 100%);
            border: none;
            border-radius: 6px;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 8px;
            box-shadow: 0 4px 14px rgba(24, 136, 240, 0.35);
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #1474d2 0%, #0d47a1 100%);
            box-shadow: 0 6px 18px rgba(24, 136, 240, 0.45);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .help-admin-link {
            margin-top: 16px;
            font-size: 12.5px;
            color: #64748b;
        }

        .help-admin-link a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        /* Copyright Footer */
        .login-copyright {
            margin-top: 20px;
            font-size: 11.5px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <!-- Logo PNG Omah Terapiku -->
        <div class="logo-container">
            <img src="{{asset('images/logo-blue.png')}}" alt="Logo Omah Terapiku" class="main-logo">
        </div>

        <h2 class="login-app-title">Sistem Informasi Rekam Medis<br>Omah Terapiku</h2>

        <!-- Form Login -->
        <form action="{{Route('login.auth')}}" method="POST">
            {{ csrf_field() }}

            <!-- Input Username / Nama -->
            <div class="form-group">
                <label class="form-label">Username / Nama</label>
                <div class="input-group-custom">
                    <i class="fa-solid fa-user input-icon-left"></i>
                    <input type="text" name="username" class="form-control-custom" placeholder="Masukkan Username atau Nama" required value="{{ old('username', old('name', old('nip'))) }}" autofocus>
                </div>
            </div>

            <!-- Input Password -->
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <i class="fa-solid fa-lock input-icon-left"></i>
                    <input type="password" id="passwordField" name="password" class="form-control-custom" placeholder="Masukkan password" required>
                    <i class="fa-regular fa-eye-slash input-icon-right" id="togglePassword" title="Tampilkan/Sembunyikan Password"></i>
                </div>
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" class="btn-submit">
                <span>Masuk</span>
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <!-- Tautan ke Portal Pasien & Keluarga -->
        <div style="margin-top: 16px; padding-top: 14px; border-top: 1px dashed #e2e8f0;">
            <a href="{{ route('portal.index') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 13px; font-weight: 600; color: #1e40af; text-decoration: none; padding: 9px 12px; background: #eff6ff; border-radius: 8px; border: 1px solid #bfdbfe; transition: all 0.2s ease;">
                <i class="fa-solid fa-hospital-user"></i>
                <span>Masuk ke Portal Pasien & Keluarga</span>
                <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
            </a>
        </div>

        <!-- Kendala Hubungi Admin (Teks Sederhana) -->
        <div class="help-admin-link">
            <span>Kendala saat login? Hubungi Admin</span>
        </div>

        <!-- Copyright Footer -->
        <div class="login-copyright">
            Omah Terapiku © {{ date('Y') }} All Rights Reserved
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
    <script src="{{asset('vendor/toastr/js/toastr.min.js')}}"></script>

    <!-- Script Toggle Show/Hide Password -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('passwordField');

            if (togglePassword && passwordField) {
                togglePassword.addEventListener('click', function () {
                    const isPassword = passwordField.getAttribute('type') === 'password';
                    passwordField.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    // Toggle class icon mata
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>

    <!-- Toastr Alert Notifikasi -->
    <script>
        @if(Session::has('sukses'))
            toastr.success("{{Session::get('sukses')}}", "Sukses", {timeOut: 5000});
        @endif
        @if(Session::has('gagal'))
            toastr.error("{{Session::get('gagal')}}", "Gagal", {timeOut: 5000});
        @endif
    </script>

</body>
</html>
<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Omah Terapiku</title>
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.png')}}">
    
    <!-- CSS Dependencies -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/toastr/css/toastr.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #094754 0%, #0d6e80 40%, #128fa5 75%, #19b2ca 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 26px;
            box-shadow: 0 20px 45px rgba(4, 47, 56, 0.25);
            width: 100%;
            max-width: 410px;
            padding: 40px 32px 36px 32px;
            text-align: center;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 18px;
        }

        .main-logo {
            max-height: 75px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(13, 110, 128, 0.2));
        }

        .login-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f2c35;
            margin-bottom: 6px;
        }

        .login-subtitle-main {
            font-size: 14.5px;
            font-weight: 700;
            color: #0d6e80;
            margin: 0 0 2px 0;
            letter-spacing: 0.3px;
        }

        .login-subtitle-sub {
            font-size: 12.5px;
            font-weight: 500;
            color: #64748b;
            margin: 0 0 26px 0;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
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
            color: #0d6e80;
        }

        .form-control-custom {
            width: 100%;
            height: 48px;
            padding: 10px 42px 10px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #1e293b;
            background-color: #f8fafc;
            transition: all 0.25s ease;
        }

        .form-control-custom:focus {
            background-color: #ffffff;
            border-color: #0d6e80;
            outline: none;
            box-shadow: 0 0 0 3.5px rgba(13, 110, 128, 0.15);
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
            font-size: 13.5px;
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            background: linear-gradient(90deg, #095968 0%, #118c9f 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 8px 18px rgba(13, 110, 128, 0.25);
        }

        .btn-submit:hover {
            opacity: 0.96;
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(13, 110, 128, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .footer-links {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .link-item {
            font-size: 13px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .link-item:hover {
            color: #095968;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <!-- Logo PNG Omah Terapiku -->
        <div class="logo-container">
            <img src="{{asset('images/logo.png')}}" alt="Logo Omah Terapiku" class="main-logo">
        </div>

        <h2 class="login-title">Login Masuk</h2>
        <p class="login-subtitle-main">Omah Terapiku</p>
        <p class="login-subtitle-sub">Dinas Sosial Provinsi Jawa Timur</p>

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
            <button type="submit" class="btn-submit">Masuk</button>

            <!-- Link Lupa Password -->
            <div class="footer-links">
                <a href="#" class="link-item">
                    <i class="fa-solid fa-key" style="font-size: 11px;"></i> Lupa Password?
                </a>
            </div>
        </form>
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
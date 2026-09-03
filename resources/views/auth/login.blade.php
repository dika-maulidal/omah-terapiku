<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sistem Informasi Rekam Medis Omah Terapiku - Login</title>
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.png')}}">
    
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
            font-size: 12px;
            color: #64748b;
        }

        .help-admin-link a {
            color: #1888f0;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .help-admin-link a:hover {
            color: #0d47a1;
            text-decoration: underline;
        }

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

        <!-- Kendala Hubungi Admin -->
        <div class="help-admin-link">
            <span>Kendala saat login? </span>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalBantuanAdmin">
                Hubungi Admin
            </a>
        </div>

        <!-- Copyright Footer -->
        <div class="login-copyright">
            Omah Terapiku © {{ date('Y') }} All Rights Reserved
        </div>
    </div>

    <!-- Modal Bantuan Admin -->
    <div class="modal fade" id="modalBantuanAdmin" tabindex="-1" role="dialog" aria-labelledby="modalBantuanAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 8px; border: none; text-align: left; box-shadow: 0 15px 35px rgba(24, 44, 79, 0.25);">
                <div class="modal-header" style="background: #edf3fc; border-bottom: 1px solid #e2e8f0; padding: 14px 18px;">
                    <h5 class="modal-title" id="modalBantuanAdminLabel" style="font-size: 15px; font-weight: 700; color: #2e4b82; margin: 0;">
                        <i class="fa-solid fa-headset mr-1"></i> Bantuan & Layanan Akun
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <p style="font-size: 13px; color: #475569; margin-bottom: 16px; line-height: 1.5;">
                        Jika Anda mengalami kendala seperti lupa kata sandi, akun terkunci, atau memerlukan aktivasi hak akses (Dokter, Terapis, Pendaftaran, Admin), silakan hubungi tim pengelola sistem:
                    </p>
                    <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 6px; padding: 12px 14px; margin-bottom: 10px;">
                        <strong style="font-size: 13px; color: #1e293b; display: block; margin-bottom: 2px;">
                            <i class="fa-solid fa-user-shield text-primary mr-1"></i> Admin / Pengelola Sistem
                        </strong>
                        <span style="font-size: 12px; color: #64748b;">Dinas Sosial Provinsi Jawa Timur</span>
                    </div>
                    <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 6px; padding: 12px 14px; margin-bottom: 10px;">
                        <strong style="font-size: 13px; color: #1e293b; display: block; margin-bottom: 2px;">
                            <i class="fa-brands fa-whatsapp text-success mr-1"></i> Kontak Helpdesk / WhatsApp
                        </strong>
                        <span style="font-size: 12px; color: #64748b;">Hubungi koordinator IT untuk proses reset password akun</span>
                    </div>
                    <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 6px; padding: 12px 14px;">
                        <strong style="font-size: 13px; color: #1e293b; display: block; margin-bottom: 2px;">
                            <i class="fa-solid fa-clock text-warning mr-1"></i> Jam Layanan
                        </strong>
                        <span style="font-size: 12px; color: #64748b;">Senin – Jumat (08.00 – 16.00 WIB)</span>
                    </div>
                </div>
                <div class="modal-footer py-2 px-3" style="background: #fafbfc; border-top: 1px solid #edf2f7;">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" style="border-radius: 4px; padding: 6px 16px;">Tutup</button>
                </div>
            </div>
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
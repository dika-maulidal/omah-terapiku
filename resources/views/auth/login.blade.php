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

        .help-admin-link a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .login-copyright {
            margin-top: 20px;
            font-size: 11.5px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
        }

        /* Modal Bantuan Admin Custom Styling Sesuai DESIGN.md */
        .modal-admin-dialog {
            max-width: 520px;
            margin: 1.75rem auto;
        }

        .modal-admin-content {
            border-radius: 14px;
            border: 1px solid #dbeafe;
            box-shadow: 0 12px 36px rgba(30, 64, 175, 0.12);
            overflow: hidden;
            background: #ffffff;
            text-align: left;
        }

        .modal-admin-header {
            background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%);
            padding: 16px 22px;
            border-bottom: 1.5px solid #bfdbfe;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-admin-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid #bfdbfe;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 18px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1);
        }

        .modal-admin-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e40af !important;
            margin: 0;
            line-height: 1.25;
        }

        .modal-admin-subtitle {
            font-size: 11.5px;
            color: #64748b;
            font-weight: 500;
            margin-top: 2px;
            display: block;
        }

        .modal-admin-close {
            font-size: 24px;
            color: #64748b;
            opacity: 0.8;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            transition: all 0.2s ease;
        }

        .modal-admin-close:hover {
            color: #1e293b;
            opacity: 1;
            transform: scale(1.1);
        }

        .modal-admin-body {
            padding: 20px 22px;
            background: #ffffff;
        }

        .help-intro-card {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .help-intro-card i {
            color: #2563eb;
            font-size: 16px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .help-intro-card p {
            font-size: 12.5px;
            color: #1e40af;
            line-height: 1.5;
            margin: 0;
            font-weight: 500;
        }

        .contact-card-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 13px 15px;
            margin-bottom: 12px;
            transition: all 0.22s ease;
        }

        .contact-card-item:hover {
            border-color: #cbd5e1;
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(46, 75, 130, 0.06);
            transform: translateY(-1px);
        }

        .contact-card-item.featured {
            background: #ffffff;
            border: 1.5px solid #6ee7b7;
            box-shadow: 0 3px 12px rgba(16, 185, 129, 0.08);
        }

        .contact-card-item.featured:hover {
            border-color: #10b981;
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.15);
        }

        .contact-badge-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .btn-contact-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 7px;
            transition: all 0.2s ease;
            text-decoration: none !important;
            cursor: pointer;
            border: none;
        }

        .btn-contact-action.btn-wa {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            box-shadow: 0 3px 10px rgba(16, 185, 129, 0.28);
        }

        .btn-contact-action.btn-wa:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.38);
            transform: translateY(-1px);
        }

        .btn-contact-action.btn-copy {
            background: #f1f5f9;
            color: #334155 !important;
            border: 1px solid #cbd5e1;
        }

        .btn-contact-action.btn-copy:hover {
            background: #e2e8f0;
            color: #1e293b !important;
        }

        .btn-contact-action.btn-email {
            background: #eff6ff;
            color: #2563eb !important;
            border: 1px solid #bfdbfe;
        }

        .btn-contact-action.btn-email:hover {
            background: #dbeafe;
            color: #1d4ed8 !important;
        }

        /* Quick Tips Section */
        .quick-tips-accordion {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 14px;
        }

        .quick-tips-header {
            background: #f8fafc;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 700;
            color: #1e40af;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
            transition: background 0.2s ease;
        }

        .quick-tips-header:hover {
            background: #eff6ff;
        }

        .quick-tips-body {
            padding: 12px 14px;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #475569;
        }

        .quick-tips-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .quick-tips-list li {
            position: relative;
            padding-left: 18px;
            margin-bottom: 8px;
            line-height: 1.45;
        }

        .quick-tips-list li:last-child {
            margin-bottom: 0;
        }

        .quick-tips-list li::before {
            content: "•";
            position: absolute;
            left: 4px;
            top: -1px;
            color: #2563eb;
            font-size: 16px;
            font-weight: bold;
        }

        .modal-admin-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 12px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
                <i class="fa-solid fa-circle-question mr-1"></i> Hubungi Admin
            </a>
        </div>

        <!-- Copyright Footer -->
        <div class="login-copyright">
            Omah Terapiku © {{ date('Y') }} All Rights Reserved
        </div>
    </div>

    <!-- Modal Bantuan Admin (Desain Modern Sesuai DESIGN.md) -->
    <div class="modal fade" id="modalBantuanAdmin" tabindex="-1" role="dialog" aria-labelledby="modalBantuanAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-admin-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-admin-content">
                
                <!-- Modal Header: Soft Blue Light Gradient & Royal Blue Theme -->
                <div class="modal-header modal-admin-header">
                    <div class="d-flex align-items-center">
                        <div class="modal-admin-icon mr-3">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <h5 class="modal-admin-title" id="modalBantuanAdminLabel">
                                Pusat Bantuan & Layanan Akun
                            </h5>
                            <span class="modal-admin-subtitle">
                                <i class="fa-solid fa-shield-halved text-primary mr-1"></i> SIM Rekam Medis Omah Terapi-KU
                            </span>
                        </div>
                    </div>
                    <button type="button" class="close modal-admin-close" data-dismiss="modal" aria-label="Close" title="Tutup Pop-up">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-admin-body">
                    
                    <!-- Alert Pengantar -->
                    <div class="alert alert-light mb-3 d-flex align-items-start py-2.5 px-3" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; font-size: 12px; gap: 8px; color: #475569; line-height: 1.5;">
                        <i class="fa-solid fa-circle-info text-primary mt-1" style="font-size: 14px; flex-shrink: 0;"></i>
                        <div>
                            Mengalami kendala login, lupa kata sandi, atau memerlukan aktivasi hak akses (Dokter, Terapis, Pendaftaran)? Tim Pengelola SIM Rekam Medis siap membantu Anda.
                        </div>
                    </div>

                    <!-- Kontak 1: WhatsApp Helpdesk (Featured Card) -->
                    <div class="contact-card-item featured" style="border-radius: 10px; border: 1px solid #bbf7d0; background: #ffffff;">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <div class="contact-badge-icon mr-3" style="background: #ecfdf5; color: #10b981; border: 1px solid #a7f3d0; border-radius: 8px;">
                                    <i class="fa-brands fa-whatsapp" style="font-size: 20px;"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                        <strong style="font-size: 13.5px; color: #0f172a; font-weight: 700;">Helpdesk WhatsApp IT</strong>
                                        <span class="badge" style="background: #d1fae5; color: #065f46; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 10px;">
                                            <i class="fa-solid fa-bolt mr-1"></i>Respon Cepat
                                        </span>
                                    </div>
                                    <span style="font-size: 12px; color: #64748b; display: block; margin-top: 1px;">
                                        Layanan reset password & aktivasi akun
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: #f1f5f9 !important; gap: 8px;">
                            <span class="font-w600 text-dark" style="font-size: 13px; letter-spacing: 0.3px;">
                                <i class="fa-solid fa-phone-volume mr-1 text-muted" style="font-size: 11px;"></i> +62 812-3456-7890
                            </span>
                            <div class="d-flex align-items-center" style="gap: 6px;">
                                <button type="button" class="btn-contact-action btn-copy" onclick="copyContactText('+6281234567890', 'Nomor WhatsApp')">
                                    <i class="fa-regular fa-copy"></i> Salin
                                </button>
                                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Omah%20Terapi-KU%2C%20saya%20mengalami%20kendala%20saat%20login%20ke%20sistem.%20Mohon%20bantuannya." target="_blank" class="btn-contact-action btn-wa">
                                    <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak 2: Email Layanan Pengelola -->
                    <div class="contact-card-item" style="border-radius: 10px; border: 1px solid #bfdbfe; background: #ffffff;">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <div class="contact-badge-icon mr-3" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 8px;">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div>
                                    <strong style="font-size: 13.5px; color: #0f172a; font-weight: 700; display: block;">Email Layanan SIM</strong>
                                    <span style="font-size: 12px; color: #64748b; display: block; margin-top: 1px;">
                                        omahterapiku@dinsos.jatimprov.go.id
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: #f1f5f9 !important; gap: 8px;">
                            <span class="text-muted" style="font-size: 11.5px;">
                                <i class="fa-solid fa-clock mr-1"></i> Respon max 1x24 jam
                            </span>
                            <div class="d-flex align-items-center" style="gap: 6px;">
                                <button type="button" class="btn-contact-action btn-copy" onclick="copyContactText('omahterapiku@dinsos.jatimprov.go.id', 'Alamat Email')">
                                    <i class="fa-regular fa-copy"></i> Salin
                                </button>
                                <a href="mailto:omahterapiku@dinsos.jatimprov.go.id?subject=Kendala%20Akun%20SIM%20Omah%20Terapi-KU" class="btn-contact-action btn-email">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Email
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak 3: Unit Kerja & Jam Operasional -->
                    <div class="contact-card-item mb-0" style="border-radius: 10px;">
                        <div class="d-flex align-items-start">
                            <div class="contact-badge-icon mr-3" style="background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div style="flex: 1;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 4px;">
                                    <strong style="font-size: 13px; color: #0f172a; font-weight: 700;">Dinas Sosial Provinsi Jawa Timur</strong>
                                    <span class="badge" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-size: 10.5px; font-weight: 600; padding: 2px 7px; border-radius: 6px;">
                                        <i class="fa-regular fa-clock mr-1"></i>08.00 – 16.00 WIB
                                    </span>
                                </div>
                                <span style="font-size: 11.5px; color: #64748b; display: block; margin-top: 2px;">
                                    Seksi Rehabilitasi Sosial & Pengelola UPT Omah Terapi-KU
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Panduan Cepat Kendala (Quick Accordion) -->
                    <div class="quick-tips-accordion" style="border-radius: 8px;">
                        <div class="quick-tips-header" data-toggle="collapse" data-target="#collapseQuickTips" aria-expanded="false" aria-controls="collapseQuickTips">
                            <span><i class="fa-solid fa-circle-question mr-1 text-primary"></i> Panduan Cepat Kendala Akun</span>
                            <i class="fa-solid fa-chevron-down" style="font-size: 10px; transition: transform 0.2s ease;"></i>
                        </div>
                        <div class="collapse" id="collapseQuickTips">
                            <div class="quick-tips-body">
                                <ul class="quick-tips-list">
                                    <li><strong>Lupa Kata Sandi:</strong> Hubungi admin via WhatsApp dan sebutkan Nama Lengkap serta NIP untuk verifikasi identitas akun.</li>
                                    <li><strong>Aktivasi Hak Akses:</strong> Untuk peran baru (Dokter, Terapis, Pendaftaran), minta verifikasi akun melalui Kepala UPT / Koordinator Sistem.</li>
                                    <li><strong>Gagal Login:</strong> Pastikan Caps Lock mati dan periksa kembali penulisan username/password Anda.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-admin-footer">
                    <div class="d-flex align-items-center text-muted" style="font-size: 11.5px;">
                        <i class="fa-solid fa-circle-check text-success mr-1"></i> Layanan Resmi Dinsos Jatim
                    </div>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border-radius: 6px; font-size: 12.5px; color: #475569; border: 1px solid #cbd5e1; padding: 6px 16px;">
                            Tutup
                        </button>
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Omah%20Terapi-KU%2C%20saya%20mengalami%20kendala%20saat%20login%20ke%20sistem.%20Mohon%20bantuannya." target="_blank" class="btn btn-sm btn-primary font-w700" style="border-radius: 6px; font-size: 12.5px; padding: 7px 18px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                            <i class="fa-brands fa-whatsapp mr-1"></i> Hubungi WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
    <script src="{{asset('vendor/toastr/js/toastr.min.js')}}"></script>

    <!-- Script Interaktif: Salin Teks ke Clipboard -->
    <script>
        function copyContactText(text, label) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    showCopySuccess(label);
                }).catch(function() {
                    fallbackCopyText(text, label);
                });
            } else {
                fallbackCopyText(text, label);
            }
        }

        function fallbackCopyText(text, label) {
            var tempInput = document.createElement("input");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand("copy");
                showCopySuccess(label);
            } catch (err) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('Gagal menyalin teks', 'Error');
                } else {
                    alert('Gagal menyalin: ' + text);
                }
            }
            document.body.removeChild(tempInput);
        }

        function showCopySuccess(label) {
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "3000"
                };
                toastr.success(label + ' berhasil disalin ke clipboard!', 'Tersalin');
            } else {
                alert(label + ' berhasil disalin!');
            }
        }
    </script>

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

            // Animate Chevron on quick tips accordion toggle
            $('#collapseQuickTips').on('show.bs.collapse', function () {
                $('.quick-tips-header .fa-chevron-down').css('transform', 'rotate(180deg)');
            });
            $('#collapseQuickTips').on('hide.bs.collapse', function () {
                $('.quick-tips-header .fa-chevron-down').css('transform', 'rotate(0deg)');
            });
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
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Primary SEO Meta Tags -->
    <title>Portal Pasien & Keluarga - Omah Terapiku</title>
    <meta name="title" content="Portal Pasien & Keluarga - Omah Terapiku">
    <meta name="description" content="Portal Pasien & Keluarga Omah Terapiku - Dinas Sosial Provinsi Jawa Timur. Cek hasil asesmen Denver II, GMFM, skala nyeri, dan rekam medis terapi.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Omah Terapiku">
    <meta property="og:title" content="Portal Pasien & Keluarga - Omah Terapiku">
    <meta property="og:description" content="Informasi rekam medis dan hasil asesmen terapi anak Omah Terapiku.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">

    <style>
        :root {
            --ot-navy: #1e40af;
            --ot-navy-dark: #1e293b;
            --ot-blue: #2563eb;
            --ot-blue-hover: #1d4ed8;
            --ot-sky: #eff6ff;
            --ot-border: #e2e8f0;
            --ot-border-focus: #93c5fd;
            --ot-bg: #f8fafc;
            --ot-text: #1e293b;
            --ot-text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--ot-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--ot-text);
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navbar (Clean Web Application Navbar) */
        .portal-navbar {
            width: 100%;
            background: #ffffff;
            border-bottom: 1px solid var(--ot-border);
            box-shadow: 0 2px 10px rgba(46, 75, 130, 0.04);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo {
            height: 44px;
            width: auto;
            object-fit: contain;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--ot-navy);
            line-height: 1.15;
            letter-spacing: -0.3px;
        }

        .brand-subtitle {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--ot-text-muted);
            letter-spacing: 0.2px;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-nav-help {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            border: 1px solid var(--ot-border);
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            padding: 7px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-nav-help:hover {
            color: var(--ot-blue);
            background: var(--ot-sky);
            border-color: #bfdbfe;
        }

        .btn-nav-staff {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            padding: 7px 16px;
            border-radius: 8px;
            background: var(--ot-navy);
            border: 1px solid var(--ot-navy);
            box-shadow: 0 2px 6px rgba(30, 64, 175, 0.18);
            transition: all 0.2s ease;
        }

        .btn-nav-staff:hover {
            background: #172554;
            border-color: #172554;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(30, 64, 175, 0.25);
            transform: translateY(-1px);
        }

        /* Main Container */
        .portal-main {
            flex: 1;
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 20px 48px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Hero Layout */
        .hero-section {
            display: grid;
            grid-template-columns: 1.25fr 0.85fr;
            align-items: center;
            gap: 36px;
            margin-bottom: 32px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: var(--ot-sky);
            border: 1px solid #bfdbfe;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            color: var(--ot-navy);
            margin-bottom: 12px;
            width: fit-content;
        }

        .hero-title-prefix {
            font-size: 20px;
            font-weight: 600;
            color: #475569;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .hero-title-main {
            font-size: 34px;
            font-weight: 800;
            color: var(--ot-navy);
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 14px;
        }

        .hero-desc {
            font-size: 14.5px;
            line-height: 1.65;
            color: var(--ot-text-muted);
            max-width: 520px;
        }

        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image-trans {
            width: 100%;
            max-width: 360px;
            height: auto;
            border: none;
            background: transparent;
            filter: drop-shadow(0 12px 24px rgba(37, 99, 235, 0.1));
            transition: transform 0.3s ease;
        }

        .hero-image-trans:hover {
            transform: translateY(-4px) scale(1.02);
        }

        /* Search Card (Unified White Card - DESIGN.md) */
        .search-card {
            background: #ffffff;
            border: 1px solid var(--ot-border);
            border-radius: 14px;
            padding: 26px 30px;
            box-shadow: 0 4px 20px rgba(46, 75, 130, 0.05);
            width: 100%;
        }

        .search-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
        }

        .search-card-icon {
            width: 44px;
            height: 44px;
            background: var(--ot-sky);
            color: var(--ot-blue);
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .search-card-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--ot-navy);
            line-height: 1.25;
        }

        .search-card-desc {
            font-size: 13px;
            color: var(--ot-text-muted);
            margin-top: 2px;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 18px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--ot-text);
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-label i {
            color: var(--ot-blue);
            font-size: 12px;
        }

        .form-input {
            width: 100%;
            height: 46px;
            padding: 8px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 14px;
            color: var(--ot-text);
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--ot-blue);
            outline: none;
            box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.12);
        }

        .form-input::placeholder {
            color: #94a3b8;
            font-size: 13.5px;
        }

        .btn-submit {
            height: 46px;
            background: var(--ot-navy);
            color: #ffffff;
            border: none;
            border-radius: 9px;
            padding: 0 26px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(30, 64, 175, 0.2);
            white-space: nowrap;
        }

        .btn-submit:hover {
            background: #172554;
            box-shadow: 0 6px 18px rgba(30, 64, 175, 0.3);
            transform: translateY(-1px);
        }

        /* Footer */
        .portal-footer {
            width: 100%;
            background: #ffffff;
            border-top: 1px solid var(--ot-border);
            padding: 18px 20px;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1180px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 12.5px;
            color: var(--ot-text-muted);
        }

        .footer-brand-link {
            color: var(--ot-navy);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-brand-link:hover {
            color: var(--ot-blue);
            text-decoration: underline;
        }

        /* Modal Bantuan */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 1000;
            backdrop-filter: blur(2px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: #ffffff;
            border-radius: 14px;
            max-width: 460px;
            width: 100%;
            padding: 26px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            border: 1px solid var(--ot-border);
        }

        .modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            background: #f1f5f9;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ot-text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: var(--ot-navy);
        }

        .modal-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--ot-navy);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-content-text {
            font-size: 13px;
            line-height: 1.65;
            color: #334155;
        }

        .modal-tips {
            background: var(--ot-sky);
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 14px;
            margin: 14px 0;
            font-size: 12.5px;
        }

        .modal-tips ul {
            padding-left: 18px;
            margin: 6px 0 0 0;
        }

        .modal-tips li {
            margin-bottom: 4px;
        }

        /* Responsive */
        @media (max-width: 860px) {
            .hero-section {
                grid-template-columns: 1fr;
                gap: 20px;
                text-align: left;
            }

            .hero-visual {
                display: none;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn-submit {
                width: 100%;
            }

            .hero-title-main {
                font-size: 26px;
            }

            .footer-container {
                flex-direction: column;
                text-align: center;
                gap: 4px;
            }
        }
    </style>
</head>

<body>
    <!-- Top Navbar (Clean Web Application Navbar) -->
    <header class="portal-navbar">
        <div class="navbar-container">
            <a href="{{ route('portal.index') }}" class="brand-link">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Omah Terapiku" class="brand-logo">
                <div class="brand-text">
                    <span class="brand-title">Omah Terapi-KU</span>
                    <span class="brand-subtitle">Dinas Sosial Provinsi Jawa Timur</span>
                </div>
            </a>

            <div class="navbar-actions">
                <button type="button" class="btn-nav-help" id="btnHelp" title="Petunjuk Akses Portal">
                    <i class="fa-regular fa-circle-question" style="color: var(--ot-blue);"></i>
                    <span>Bantuan</span>
                </button>
                <a href="{{ route('login') }}" class="btn-nav-staff" title="Masuk ke Sistem Petugas / Terapis">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Login Petugas</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="portal-main">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-text">
                <div class="hero-title-prefix">Selamat Datang di</div>
                <h1 class="hero-title-main">Portal Informasi Terapi & Rekam Medis</h1>
                <p class="hero-desc">
                    Pantau perkembangan motorik anak, hasil asesmen Denver II & GMFM, riwayat sesi terapi, serta panduan program latihan mandiri di rumah secara mudah dan transparan.
                </p>
            </div>

            <div class="hero-visual">
                <img src="{{ asset('images/portal-hero-trans.png') }}" alt="Ilustrasi Terapis Medis dan Anak" class="hero-image-trans">
            </div>
        </section>

        <!-- Search Card (Unified White Card - DESIGN.md) -->
        <div class="search-card">
            <div class="search-card-header">
                <div class="search-card-icon">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                </div>
                <div>
                    <h2 class="search-card-title">Akses Rekam Medis Pasien</h2>
                    <p class="search-card-desc">Masukkan Nomor Rekam Medis (No. RM) dan Tanggal Lahir pasien penerima manfaat.</p>
                </div>
            </div>

            <form action="{{ route('portal.login') }}" method="POST">
                {{ csrf_field() }}

                <div class="form-grid">
                    <!-- No. RM -->
                    <div class="form-group">
                        <label for="inputNoRm" class="form-label">
                            <i class="fa-solid fa-id-card"></i>
                            <span>No. Rekam Medis</span>
                        </label>
                        <input 
                            type="text" 
                            id="inputNoRm" 
                            name="no_rm" 
                            class="form-input" 
                            placeholder="Contoh: OTK-24-00001 / DP222" 
                            value="{{ old('no_rm') }}" 
                            required 
                            autofocus
                        >
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form-group">
                        <label for="inputTglLahir" class="form-label">
                            <i class="fa-regular fa-calendar"></i>
                            <span>Tanggal Lahir Pasien</span>
                        </label>
                        <input 
                            type="date" 
                            id="inputTglLahir" 
                            name="tgl_lahir" 
                            class="form-input" 
                            value="{{ old('tgl_lahir') }}" 
                            required
                        >
                    </div>

                    <!-- Tombol Cari -->
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Buka Data Pasien</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="footer-container">
            <div>
                Copyright &copy; <a href="{{ route('portal.index') }}" class="footer-brand-link">Omah Terapiku</a> {{ date('Y') }}. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Modal Bantuan -->
    <div class="modal-overlay" id="helpModal">
        <div class="modal-box">
            <button type="button" class="modal-close" id="btnCloseHelp" aria-label="Tutup Bantuan">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="modal-title">
                <i class="fa-solid fa-circle-question" style="color: var(--ot-blue);"></i>
                <span>Panduan Akses Data Pasien</span>
            </div>
            <div class="modal-content-text">
                <p>Untuk mengakses data hasil asesmen dan rekam medis pasien, silakan masukkan data berikut:</p>
                
                <div class="modal-tips">
                    <strong style="color: var(--ot-navy);"><i class="fa-solid fa-circle-info mr-1"></i> Petunjuk No. Rekam Medis:</strong>
                    <ul>
                        <li>Tertera pada lembar struk pendaftaran / cetak resume terapi.</li>
                        <li>Format nomor contoh: <code>OTK-24-00001</code> atau <code>DP222</code>.</li>
                    </ul>
                </div>

                <p>Jika data tidak ditemukan atau Anda lupa nomor rekam medis, silakan menghubungi petugas administrasi di klinik Omah Terapiku.</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script>
        // Modal Help
        const helpModal = document.getElementById('helpModal');
        const btnHelp = document.getElementById('btnHelp');
        const btnCloseHelp = document.getElementById('btnCloseHelp');

        if (btnHelp) {
            btnHelp.addEventListener('click', () => helpModal.classList.add('active'));
        }
        if (btnCloseHelp) {
            btnCloseHelp.addEventListener('click', () => helpModal.classList.remove('active'));
        }
        if (helpModal) {
            helpModal.addEventListener('click', (e) => {
                if (e.target === helpModal) helpModal.classList.remove('active');
            });
        }

        // Toastr Flash Messages
        @if(Session::has('sukses'))
            toastr.success("{{ Session::get('sukses') }}", "Berhasil", {timeOut: 4000, closeButton: true});
        @endif
        @if(Session::has('gagal'))
            toastr.error("{{ Session::get('gagal') }}", "Gagal", {timeOut: 5000, closeButton: true});
        @endif
        @if(isset($errors) && $errors->any())
            @foreach($errors->all() as $error)
                toastr.warning("{{ $error }}", "Perhatian", {timeOut: 4000});
            @endforeach
        @endif
    </script>
</body>

</html>

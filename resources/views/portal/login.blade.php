<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Primary SEO Meta Tags -->
    <title>Portal Pasien & Pendaftaran Online - Omah Terapi-KU</title>
    <meta name="title" content="Portal Pasien & Pendaftaran Online - Omah Terapi-KU">
    <meta name="description" content="Portal Pasien & Pendaftaran Online Omah Terapi-KU - Dinas Sosial Provinsi Jawa Timur. Cek rekam medis, hasil asesmen Denver II & GMFM, pendaftaran pasien baru, dan lacak status registrasi.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Omah Terapi-KU">
    <meta property="og:title" content="Portal Pasien & Pendaftaran Online - Omah Terapi-KU">
    <meta property="og:description" content="Layanan mandiri akses rekam medis, asesmen perkembangan anak, dan pendaftaran online.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">

    <style>
        :root {
            --ot-royal: #2563eb;
            --ot-royal-dark: #1d4ed8;
            --ot-navy: #1e40af;
            --ot-navy-dark: #1e293b;
            --ot-sky: #38bdf8;
            --ot-soft-blue: #eff6ff;
            --ot-border: #e2e8f0;
            --ot-border-focus: #93c5fd;
            --ot-bg: #f8fafc;
            --ot-surface: #ffffff;
            --ot-text: #1e293b;
            --ot-text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--ot-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--ot-text);
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navbar (Brand Blue Theme - Matching Dashboard Sidebar & Nav-Header) */
        .portal-navbar {
            width: 100%;
            background: linear-gradient(180deg, #3574b5 0%, #295d96 100%);
            background-color: #3168a5;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(41, 93, 150, 0.18);
        }

        .navbar-container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }

        .brand-link:hover {
            opacity: 0.95;
        }

        .brand-link .logo-abbr {
            max-height: 48px;
            max-width: 54px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.25));
            flex-shrink: 0;
            transition: all 0.25s ease;
        }

        .brand-link .brand-title {
            max-height: 40px;
            max-width: 175px;
            width: auto;
            object-fit: contain;
            display: inline-block;
            transition: all 0.25s ease;
        }

        /* Desktop & Mobile Actions */
        .navbar-actions-desktop {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-nav-help {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            padding: 7px 15px;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            backdrop-filter: blur(4px);
        }

        .btn-nav-help:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.45);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-nav-help i {
            color: #ffffff !important;
        }

        /* Login Petugas with Crisp White Contrast Button Style */
        .btn-nav-staff {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 700;
            color: #2D4B7A;
            text-decoration: none;
            padding: 7px 16px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            transition: all 0.2s ease;
        }

        .btn-nav-staff:hover {
            background: #f8fafc;
            color: #1e3a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        }

        .btn-nav-staff i {
            color: #2D4B7A;
        }

        /* Mobile Hamburger Toggle Button */
        .nav-toggle-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-toggle-btn:hover,
        .nav-toggle-btn:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            color: #ffffff;
            outline: none;
        }

        /* Mobile Menu Dropdown Panel */
        .navbar-mobile-menu {
            display: none;
            width: 100%;
            background: linear-gradient(180deg, #2e66a0 0%, #225184 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 12px 24px rgba(26, 60, 99, 0.25);
            animation: mobileMenuSlideDown 0.22s ease forwards;
        }

        .navbar-mobile-menu.active {
            display: block;
        }

        @keyframes mobileMenuSlideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-menu-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 14px 16px 18px 16px;
        }

        .mobile-menu-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-mobile-staff {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 42px;
            background: #ffffff;
            color: #2D4B7A !important;
            font-size: 13.5px;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }

        .btn-mobile-staff:hover {
            background: #f8fafc;
            color: #1e3a8a !important;
        }

        .btn-mobile-help {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 40px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-mobile-help:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        .mobile-menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.15);
            margin: 12px 0 10px 0;
        }

        .mobile-menu-nav-title {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.75);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .mobile-menu-tabs {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .mobile-tab-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            text-align: left;
            cursor: pointer;
            transition: all 0.18s ease;
            width: 100%;
        }

        .mobile-tab-item:hover,
        .mobile-tab-item:active {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .mobile-tab-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .mobile-tab-label {
            font-size: 13px;
            color: #ffffff;
            font-weight: 700;
        }

        /* Hero Banner Section with object-fit: cover */
        .hero-banner-section {
            position: relative;
            width: 100%;
            min-height: 360px;
            background-color: #0f2444;
            padding: 60px 24px 120px 24px;
            text-align: center;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-bg-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .hero-bg-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center bottom;
            display: block;
            pointer-events: none;
            user-select: none;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(15, 33, 64, 0.78) 0%, rgba(20, 45, 82, 0.88) 100%);
            z-index: 2;
        }

        .hero-banner-content {
            position: relative;
            z-index: 3;
            max-width: 820px;
            margin: 0 auto;
        }

        .hero-tagline {
            display: block;
            color: #93c5fd;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .hero-title-main {
            font-size: 30px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            letter-spacing: -0.4px;
            margin-bottom: 12px;
        }

        .hero-desc {
            font-size: 13.5px;
            line-height: 1.65;
            color: #e2e8f0;
            max-width: 740px;
            margin: 0 auto;
        }

        .hero-desc strong {
            color: #ffffff;
            font-weight: 700;
        }

        /* Main Container - Floating Card Overlapping Hero Banner */
        .portal-main {
            flex: 1;
            width: 100%;
            max-width: 1140px;
            margin: -65px auto 0 auto;
            padding: 0 24px 48px 24px;
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
        }

        /* Main Portal Card (DESIGN.md Spec) */
        .portal-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.12), 0 4px 12px -2px rgba(15, 23, 42, 0.05);
            width: 100%;
            overflow: hidden;
        }

        /* Segmented Capsule Tab Navigation */
        .portal-tabs-nav {
            display: flex;
            flex-wrap: nowrap;
            background: #f1f5f9;
            padding: 6px;
            gap: 6px;
            border-bottom: 1px solid var(--ot-border);
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
            scroll-behavior: smooth;
        }

        .portal-tabs-nav::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            flex: 1 1 0;
            min-width: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            background: transparent;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
            user-select: none;
            text-align: center;
            flex-shrink: 0;
        }

        .tab-btn:hover {
            color: var(--ot-royal);
            background: rgba(255, 255, 255, 0.7);
        }

        .tab-btn.active {
            color: var(--ot-navy);
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .tab-btn.active i {
            color: var(--ot-royal);
        }

        .tab-content-panel {
            display: none;
            padding: 32px 32px 38px 32px;
        }

        .tab-content-panel.active {
            display: block;
        }

        /* Grid and Utility Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -9px;
            margin-left: -9px;
        }

        .col-12 { flex: 0 0 100%; max-width: 100%; padding: 0 9px; }
        .col-md-3 { flex: 0 0 25%; max-width: 25%; padding: 0 9px; }
        .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; padding: 0 9px; }
        .col-md-5 { flex: 0 0 41.666667%; max-width: 41.666667%; padding: 0 9px; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; padding: 0 9px; }
        .col-md-7 { flex: 0 0 58.333333%; max-width: 58.333333%; padding: 0 9px; }
        .col-md-8 { flex: 0 0 66.666667%; max-width: 66.666667%; padding: 0 9px; }
        .col-md-9 { flex: 0 0 75%; max-width: 75%; padding: 0 9px; }
        .col-sm-6 { flex: 0 0 50%; max-width: 50%; padding: 0 9px; }
        .col-sm-12 { flex: 0 0 100%; max-width: 100%; padding: 0 9px; }

        @media (max-width: 768px) {
            .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 4px !important; }
        .mb-2 { margin-bottom: 8px !important; }
        .mb-3 { margin-bottom: 16px !important; }
        .mb-4 { margin-bottom: 24px !important; }
        .mt-1 { margin-top: 4px !important; }
        .mt-2 { margin-top: 8px !important; }
        .mt-3 { margin-top: 16px !important; }
        .mt-4 { margin-top: 24px !important; }
        .mr-1 { margin-right: 4px !important; }
        .mr-2 { margin-right: 8px !important; }
        .mr-3 { margin-right: 12px !important; }
        .p-2 { padding: 8px !important; }
        .p-3 { padding: 16px !important; }
        .p-4 { padding: 24px !important; }
        .pb-2 { padding-bottom: 8px !important; }
        .pt-2 { padding-top: 8px !important; }
        .pt-3 { padding-top: 16px !important; }

        .d-flex { display: flex !important; }
        .d-block { display: block !important; }
        .d-none { display: none !important; }
        .align-items-center { align-items: center !important; }
        .justify-content-between { justify-content: space-between !important; }
        .justify-content-end { justify-content: flex-end !important; }
        .justify-content-center { justify-content: center !important; }
        .flex-wrap { flex-wrap: wrap !important; }
        .text-center { text-align: center !important; }

        .font-w400 { font-weight: 400 !important; }
        .font-w500 { font-weight: 500 !important; }
        .font-w600 { font-weight: 600 !important; }
        .font-w700 { font-weight: 700 !important; }
        .font-w800 { font-weight: 800 !important; }

        .text-dark { color: #1e293b !important; }
        .text-primary { color: #2563eb !important; }
        .text-danger { color: #ef4444 !important; }
        .text-muted { color: #64748b !important; }
        .text-success { color: #059669 !important; }

        /* Form Styles */
        .form-grid-rm {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 16px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 14px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            color: var(--ot-royal);
            font-size: 12px;
        }

        .form-control, .form-input, .form-select {
            width: 100%;
            height: 42px;
            padding: 8px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
            color: var(--ot-text);
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        /* Native Select with Inset Dropdown Chevron */
        select.form-control, select.form-select, .form-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px 16px;
            padding-right: 38px;
            cursor: pointer;
        }

        select.form-control:focus, select.form-select:focus, .form-select:focus {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%232563eb'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E");
        }

        .form-textarea {
            width: 100%;
            height: auto;
            min-height: 75px;
            padding: 8px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
            color: var(--ot-text);
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--ot-royal);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .form-control::placeholder, .form-input::placeholder, .form-textarea::placeholder {
            color: #94a3b8;
            font-size: 12.5px;
        }

        .form-control-file {
            width: 100%;
            font-size: 12.5px;
            border-radius: 8px;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .form-control-file:hover {
            border-color: #93c5fd;
            background: #eff6ff;
        }

        .form-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-input {
            cursor: pointer;
            width: 16px;
            height: 16px;
            accent-color: #2563eb;
            margin: 0;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 13px;
            color: #334155;
            user-select: none;
        }

        .btn-dtks-kemensos {
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #bfdbfe;
            color: #2563eb;
            background: #eff6ff;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12.5px;
            text-decoration: none;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-dtks-kemensos:hover {
            background: #dbeafe;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .submit-action-wrapper {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .btn-submit {
            height: 46px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 9px;
            padding: 0 26px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 3px 10px rgba(37, 99, 235, 0.22);
            text-decoration: none;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            box-shadow: 0 5px 14px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
            color: #ffffff;
        }

        /* Modern Check Pill Cards */
        .check-pill-card {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
            user-select: none;
        }

        .check-pill-card input {
            cursor: pointer;
            accent-color: var(--ot-royal);
        }

        .check-pill-card:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: var(--ot-royal);
        }

        .check-pill-card.active {
            background: #eff6ff;
            border-color: #93c5fd;
            color: var(--ot-navy);
            font-weight: 700;
        }

        /* Search Form Card */
        .search-form-card {
            background: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 12px;
            padding: 28px 30px;
        }

        /* Tracking Result Box */
        .track-result-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px 20px;
            margin-top: 16px;
            box-shadow: 0 2px 10px rgba(46, 75, 130, 0.04);
        }

        /* Footer */
        .portal-footer {
            width: 100%;
            background: #ffffff;
            border-top: 1px solid var(--ot-border);
            padding: 18px 24px;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1140px;
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
            color: var(--ot-royal);
        }

        /* Modals */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: #ffffff;
            border-radius: 14px;
            max-width: 480px;
            width: 100%;
            padding: 24px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
            position: relative;
            border: 1px solid var(--ot-border);
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #f1f5f9;
            border: none;
            width: 28px;
            height: 28px;
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

        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 5px 14px;
            display: flex;
            align-items: center;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--ot-text);
            font-size: 13px;
            line-height: normal;
            padding-left: 0;
            padding-right: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 12px;
            top: 1px;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #64748b transparent transparent transparent;
            border-width: 5px 4px 0 4px;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #2563eb transparent;
            border-width: 0 4px 5px 4px;
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--ot-royal);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .select2-dropdown {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
            font-size: 13px;
            z-index: 1060;
            overflow: hidden;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb;
            color: #ffffff;
        }

        .select2-container--default .select2-search--dropdown {
            padding: 6px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 12.5px;
            outline: none;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991px) {
            .portal-main {
                padding: 20px 18px 36px 18px;
            }
            
            .tab-content-panel {
                padding: 26px 20px 30px 20px;
            }
        }

        @media (max-width: 768px) {
            .navbar-actions-desktop {
                display: none !important;
            }

            .nav-toggle-btn {
                display: inline-flex;
            }

            .portal-navbar {
                padding: 0;
            }

            .navbar-container {
                padding: 10px 16px;
            }

            .brand-link .logo-abbr {
                max-height: 40px;
                max-width: 44px;
            }

            .brand-link .brand-title {
                max-height: 32px;
                max-width: 140px;
            }

            .hero-banner-section {
                padding: 42px 18px 85px 18px;
            }

            .hero-title-main {
                font-size: 24px;
                line-height: 1.3;
            }

            .hero-desc {
                font-size: 13px;
            }

            .portal-main {
                margin-top: -55px;
                padding: 0 16px 36px 16px;
            }

            .portal-tabs-nav {
                padding: 5px;
                gap: 5px;
            }

            .tab-btn {
                padding: 10px 10px;
                font-size: 12.5px;
                gap: 6px;
                border-radius: 8px;
            }

            .form-grid-rm {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .submit-action-wrapper {
                justify-content: stretch !important;
                width: 100% !important;
            }

            .btn-submit,
            .submit-action-wrapper .btn-submit,
            .btn-submit-daftar {
                width: 100% !important;
                height: auto !important;
                min-height: 46px !important;
                padding: 12px 18px !important;
                font-size: 13.5px !important;
                white-space: normal !important;
                text-align: center !important;
                line-height: 1.35 !important;
                justify-content: center !important;
            }

            .search-form-card {
                padding: 20px 16px !important;
                border-radius: 10px;
            }

            .tab-content-panel {
                padding: 22px 16px 26px 16px;
            }

            .col-wilayah {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 680px) {
            .portal-tabs-nav {
                padding: 5px;
                gap: 6px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scroll-snap-type: x mandatory;
            }

            .tab-btn {
                flex: 0 0 auto;
                min-width: max-content;
                padding: 10px 16px;
                font-size: 12.5px;
                gap: 6px;
                border-radius: 8px;
                scroll-snap-align: start;
            }
        }

        @media (max-width: 576px) {
            .navbar-container {
                padding: 8px 12px;
            }

            .brand-link .logo-abbr {
                max-height: 38px;
                max-width: 42px;
            }

            .brand-link .brand-title {
                max-height: 30px;
                max-width: 130px;
            }

            .btn-nav-help {
                padding: 6px 10px;
                font-size: 11.5px;
            }

            .btn-nav-staff {
                padding: 6px 12px;
                font-size: 11.5px;
            }

            .hero-banner-section {
                padding: 40px 14px 85px 14px;
                min-height: 300px;
            }

            .hero-tagline {
                font-size: 13px;
            }

            .hero-title-main {
                font-size: 20px;
            }

            .portal-main {
                margin-top: -45px;
                padding: 0 12px 28px 12px;
            }

            .tab-content-panel {
                padding: 18px 12px 22px 12px;
            }

            .search-form-card {
                padding: 15px 12px !important;
            }

            .col-wilayah {
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }

            .check-pill-card {
                padding: 6px 10px;
                font-size: 12px;
            }
        }

        @media (max-width: 420px) {
            .brand-link {
                gap: 8px;
            }

            .brand-link .logo-abbr {
                max-height: 36px;
                max-width: 40px;
            }

            .brand-link .brand-title {
                max-height: 28px;
                max-width: 125px;
            }
        }

        @media (max-width: 380px) {
            .tab-btn {
                padding: 9px 12px;
                font-size: 11.5px;
            }

            .brand-link .logo-abbr {
                max-height: 32px;
                max-width: 36px;
            }

            .brand-link .brand-title {
                max-height: 24px;
                max-width: 110px;
            }
        }
    </style>
</head>

<body>
    <!-- Top Navbar (Matching Dashboard Sidebar & Nav-Header Theme) -->
    <header class="portal-navbar">
        <div class="navbar-container">
            <a href="{{ route('portal.index') }}" class="brand-link" title="Portal Pasien Omah Terapi-KU">
                <img class="logo-abbr" src="{{ asset('images/header.png') }}" alt="Logo Omah Terapi-KU">
                <img class="brand-title" src="{{ asset('images/logo-text.png') }}" alt="Omah Terapi-KU">
            </a>

            <!-- Desktop Actions -->
            <div class="navbar-actions-desktop">
                <button type="button" class="btn-nav-help btn-help-trigger" title="Petunjuk Akses">
                    <i class="fa-regular fa-circle-question" style="color: #2563eb;"></i>
                    <span>Bantuan</span>
                </button>
                <a href="{{ route('login') }}" class="btn-nav-staff" title="Masuk Petugas / Terapis">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Login Petugas</span>
                </a>
            </div>

            <!-- Mobile Hamburger Toggle Button -->
            <button type="button" class="nav-toggle-btn" id="navToggleBtn" aria-label="Buka Menu Navigasi" aria-expanded="false">
                <i class="fa-solid fa-bars" id="navToggleIcon"></i>
            </button>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div class="navbar-mobile-menu" id="navbarMobileMenu">
            <div class="mobile-menu-inner">
                <div class="mobile-menu-actions">
                    <a href="{{ route('login') }}" class="btn-mobile-staff">
                        <i class="fa-solid fa-user-shield mr-2"></i>
                        <span>Login Petugas / Terapis</span>
                    </a>
                    <button type="button" class="btn-mobile-help btn-help-trigger">
                        <i class="fa-regular fa-circle-question mr-2" style="color: #2563eb;"></i>
                        <span>Bantuan & Petunjuk Akses</span>
                    </button>
                </div>

                <div class="mobile-menu-divider"></div>

                <div class="mobile-menu-nav-title">Menu Layanan Portal</div>
                <div class="mobile-menu-tabs">
                    <button type="button" class="mobile-tab-item" data-target-tab="tab-cek-rm">
                        <div class="mobile-tab-icon"><i class="fa-solid fa-file-waveform"></i></div>
                        <span class="mobile-tab-label">Cek Rekam Medis</span>
                    </button>
                    <button type="button" class="mobile-tab-item" data-target-tab="tab-daftar-baru">
                        <div class="mobile-tab-icon"><i class="fa-solid fa-user-plus"></i></div>
                        <span class="mobile-tab-label">Pendaftaran Pasien Baru</span>
                    </button>
                    <button type="button" class="mobile-tab-item" data-target-tab="tab-lacak">
                        <div class="mobile-tab-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                        <span class="mobile-tab-label">Lacak Status Pendaftaran</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Banner Section (Like login.png with object-fit: cover) -->
    <section class="hero-banner-section">
        <div class="hero-bg-wrapper">
            <img src="{{ asset('images/hero-image.svg') }}" alt="Ilustrasi Pelayanan Terpadu Omah Terapi-KU" class="hero-bg-img">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-banner-content">
            <span class="hero-tagline">Pelayanan Terpadu Disabilitas & Tumbuh Kembang Anak</span>
            <h1 class="hero-title-main">Akses Rekam Medis & Pendaftaran Online</h1>
            <p class="hero-desc">
                Selamat datang di Portal Pasien Resmi <strong>Omah Terapi-KU</strong> &ndash; Dinas Sosial Provinsi Jawa Timur. Layanan mandiri terpadu untuk kemudahan akses riwayat rekam medis, pemantauan intervensi terapi SOAP, evaluasi asesmen Denver II & GMFM, pendaftaran penerima manfaat baru, serta pelacakan status verifikasi berkas dan jadwal terapis secara transparan.
            </p>
        </div>
    </section>

    <!-- Main Container (Floating Card Overlapping Hero Banner) -->
    <main class="portal-main">

        <!-- Main Multi-Tab Card -->
        <div class="portal-card">
            <!-- Navigation Tabs (Segmented Control) -->
            <div class="portal-tabs-nav">
                <button type="button" class="tab-btn active" data-tab="tab-cek-rm">
                    <i class="fa-solid fa-file-waveform"></i>
                    <span>Cek Rekam Medis</span>
                </button>
                <button type="button" class="tab-btn" data-tab="tab-daftar-baru">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Pendaftaran Pasien Baru</span>
                </button>
                <button type="button" class="tab-btn" data-tab="tab-lacak">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                    <span>Lacak Status</span>
                </button>
            </div>

            <!-- ======================================================== -->
            <!-- TAB 1: CEK REKAM MEDIS (PASIEN LAMA)                     -->
            <!-- ======================================================== -->
            <div class="tab-content-panel active" id="tab-cek-rm">
                <div class="mb-4">
                    <h2 style="font-size: 17px; font-weight: 800; color: var(--ot-navy); margin: 0 0 4px 0; letter-spacing: -0.2px;">
                        Cek Rekam Medis Pasien Terdaftar
                    </h2>
                    <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5;">
                        Masukkan Nomor Rekam Medis (No. RM) dan Tanggal Lahir pasien untuk mengakses data rekam medis.
                    </p>
                </div>

                <div class="search-form-card">
                    <form action="{{ route('portal.login') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-grid-rm" style="gap: 22px;">
                            <!-- No. RM -->
                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="inputNoRm" class="form-label" style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">
                                    <i class="fa-solid fa-id-card text-primary mr-1"></i>
                                    <span>No. Rekam Medis</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="inputNoRm" 
                                    name="no_rm" 
                                    class="form-input" 
                                    placeholder="Contoh: OTK-24-00001" 
                                    value="{{ old('no_rm') }}" 
                                    required 
                                    autofocus
                                    style="height: 46px; font-size: 13.5px; border-radius: 9px; padding: 10px 16px;"
                                >
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="inputTglLahir" class="form-label" style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">
                                    <i class="fa-regular fa-calendar text-primary mr-1"></i>
                                    <span>Tanggal Lahir Pasien</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="inputTglLahir" 
                                    name="tgl_lahir" 
                                    class="form-input" 
                                    value="{{ old('tgl_lahir') }}" 
                                    required
                                    style="height: 46px; font-size: 13.5px; border-radius: 9px; padding: 10px 16px;"
                                >
                            </div>

                            <!-- Tombol Cari -->
                            <button type="submit" class="btn-submit" style="height: 46px; padding: 0 28px; font-size: 13.5px; border-radius: 9px;">
                                <i class="fa-solid fa-arrow-right-to-bracket mr-1"></i>
                                <span>Buka Rekam Medis</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- TAB 2: PENDAFTARAN PENERIMA MANFAAT BARU ONLINE          -->
            <!-- ======================================================== -->
            <div class="tab-content-panel" id="tab-daftar-baru">
                <div class="mb-4">
                    <h2 style="font-size: 17px; font-weight: 800; color: var(--ot-navy); margin: 0 0 4px 0; letter-spacing: -0.2px;">
                        Formulir Pendaftaran Penerima Manfaat Baru
                    </h2>
                    <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5;">
                        Lengkapi data identitas dan persyaratan untuk proses verifikasi berkas serta penerbitan Nomor Rekam Medis (No. RM) resmi.
                    </p>
                </div>

                <form action="{{ route('portal.pendaftaran.store') }}" method="POST" enctype="multipart/form-data" id="formPendaftaranBaru">
                    {{ csrf_field() }}

                    <!-- BAGIAN: IDENTITAS PENERIMA MANFAAT -->
                    <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 14.5px;">
                            <i class="fa-solid fa-id-card mr-2" style="color: #2563eb;"></i> Identitas Penerima Manfaat
                        </h5>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label font-w600 text-dark">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" id="nama" required placeholder="Nama lengkap sesuai Kartu Keluarga (KK)" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" class="form-control" name="nik" maxlength="16" id="nik" placeholder="Masukkan 16 digit NIK jika ada" value="{{ old('nik') }}">
                            @error('nik')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">No. BPJS / KIS</label>
                            <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" placeholder="Nomor kartu BPJS jika ada" value="{{ old('no_bpjs') }}">
                            @error('no_bpjs')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tmp_lahir" placeholder="Kota/Kabupaten kelahiran" value="{{ old('tmp_lahir') }}">
                            @error('tmp_lahir')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_lahir" required value="{{ old('tgl_lahir') }}">
                            @error('tgl_lahir')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label font-w600 text-dark d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center" style="gap: 16px; height: 42px;">
                                <div class="form-check mb-0">
                                    <input type="radio" name="jk" id="jk_l" class="form-check-input" value="Laki-Laki" {{ old('jk', 'Laki-Laki') == 'Laki-Laki' ? 'checked' : '' }} required>
                                    <label class="form-check-label font-w500" for="jk_l">Laki-Laki</label>     
                                </div>
                                <div class="form-check mb-0">
                                    <input type="radio" name="jk" id="jk_p" class="form-check-input" value="Perempuan" {{ old('jk') == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label font-w500" for="jk_p">Perempuan</label>   
                                </div>
                            </div>
                            @error('jk')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label font-w600 text-dark">Agama</label>
                            <select name="agama" class="form-control">
                                <option value="Islam" {{ old('agama', 'Islam') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katholik" {{ old('agama') == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label font-w600 text-dark">Pendidikan Terakhir</label>
                            <select name="pendidikan" class="form-control">
                                <option value="Tidak Sekolah" {{ old('pendidikan', 'Tidak Sekolah') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah / Balita</option>
                                <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="Diploma" {{ old('pendidikan') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="cara_bayar" value="Gratis">
                    </div>

                    <!-- BAGIAN: KONTAK & ALAMAT DOMISILI -->
                    <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 14.5px;">
                            <i class="fa-solid fa-location-dot mr-2" style="color: #2563eb;"></i> Kontak & Alamat Domisili
                        </h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">No. HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_hp" required placeholder="Contoh: 081234567890" value="{{ old('no_hp') }}">
                            @error('no_hp')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">Kode Pos</label>
                            <input type="number" maxlength="5" class="form-control" name="kodepos" id="kodepos" placeholder="Contoh: 61219" value="{{ old('kodepos') }}">
                            @error('kodepos')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DROPDOWN WILAYAH BERJENJANG (SELECT2) -->
                        <div class="col-12" id="wrapper_wilayah_api">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                    <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between">
                                        <span>Provinsi</span>
                                        <span id="loading_provinsi" class="text-primary d-none" style="font-size: 11px;"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                    </label>
                                    <select id="select_provinsi" class="form-control select2-wilayah" style="width: 100%;">
                                        <option value="" data-code="">-- Memuat Provinsi... --</option>
                                    </select>
                                </div>

                                <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                    <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between">
                                        <span>Kabupaten / Kota</span>
                                        <span id="loading_kabupaten" class="text-primary d-none" style="font-size: 11px;"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                    </label>
                                    <select id="select_kabupaten" name="kabupaten" class="form-control select2-wilayah" style="width: 100%;" disabled>
                                        <option value="" data-code="">-- Pilih Kabupaten / Kota --</option>
                                    </select>
                                    @error('kabupaten')
                                        <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                    <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between">
                                        <span>Kecamatan</span>
                                        <span id="loading_kecamatan" class="text-primary d-none" style="font-size: 11px;"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                    </label>
                                    <select id="select_kecamatan" name="kecamatan" class="form-control select2-wilayah" style="width: 100%;" disabled>
                                        <option value="" data-code="">-- Pilih Kab/Kota Dahulu --</option>
                                    </select>
                                    @error('kecamatan')
                                        <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                    <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between">
                                        <span>Kelurahan / Desa</span>
                                        <span id="loading_kelurahan" class="text-primary d-none" style="font-size: 11px;"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                    </label>
                                    <select id="select_kelurahan" name="kelurahan" class="form-control select2-wilayah" style="width: 100%;" disabled>
                                        <option value="" data-code="">-- Pilih Kecamatan Dahulu --</option>
                                    </select>
                                    @error('kelurahan')
                                        <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label font-w600 text-dark">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="2" placeholder="Alamat jalan, RT/RW, Dusun, Blok, dll." style="height: auto; min-height: 70px;">{{ old('alamat_lengkap') }}</textarea>
                            @error('alamat_lengkap')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- BAGIAN: DATA SOSIAL, DISABILITAS, UPT & WALI -->
                    <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 14.5px;">
                            <i class="fa-solid fa-wheelchair mr-2" style="color: #2563eb;"></i> Data Sosial, Disabilitas, UPT & Wali
                        </h5>
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="form-label font-w600 text-dark">Desil (DTKS / P3KE)</label>
                            <select name="desil" class="form-control" id="desil">
                                <option value="">--Pilih Tingkat Desil Sosial--</option>
                                <option value="Desil 1" {{ old('desil') == 'Desil 1' ? 'selected' : '' }}>Desil 1 (Sangat Miskin / Ekstrem)</option>
                                <option value="Desil 2" {{ old('desil') == 'Desil 2' ? 'selected' : '' }}>Desil 2 (Miskin)</option>
                                <option value="Desil 3" {{ old('desil') == 'Desil 3' ? 'selected' : '' }}>Desil 3 (Hampir Miskin)</option>
                                <option value="Desil 4" {{ old('desil') == 'Desil 4' ? 'selected' : '' }}>Desil 4 (Rentan Miskin)</option>
                                <option value="Desil 5" {{ old('desil') == 'Desil 5' ? 'selected' : '' }}>Desil 5 (Menengah Bawah)</option>
                                <option value="Desil 6" {{ old('desil') == 'Desil 6' ? 'selected' : '' }}>Desil 6</option>
                                <option value="Desil 7" {{ old('desil') == 'Desil 7' ? 'selected' : '' }}>Desil 7</option>
                                <option value="Desil 8" {{ old('desil') == 'Desil 8' ? 'selected' : '' }}>Desil 8</option>
                                <option value="Desil 9" {{ old('desil') == 'Desil 9' ? 'selected' : '' }}>Desil 9</option>
                                <option value="Desil 10" {{ old('desil') == 'Desil 10' ? 'selected' : '' }}>Desil 10</option>
                                <option value="Non-Desil" {{ old('desil') == 'Non-Desil' ? 'selected' : '' }}>Non-Desil / Belum Terdata</option>
                            </select>
                            <div id="desilBadge" class="mt-2 d-none"></div>
                            @error('desil')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label font-w600 text-dark">Pilihan Lokasi UPT</label>
                            <select name="upt_lokasi" class="form-control">
                                @php $currentUpt = old('upt_lokasi', 'UPT PPSAB Sidoarjo'); @endphp
                                @if(isset($polis) && count($polis) > 0)
                                    @foreach($polis as $p)
                                        <option value="{{ $p->nama }}" {{ $currentUpt == $p->nama ? 'selected' : '' }}>{{ $p->nama }}</option>
                                    @endforeach
                                @else
                                    <option value="UPT PPSAB Sidoarjo" {{ $currentUpt == 'UPT PPSAB Sidoarjo' ? 'selected' : '' }}>UPT PPSAB Sidoarjo</option>
                                    <option value="Balai RS PMKS Sidoarjo" {{ $currentUpt == 'Balai RS PMKS Sidoarjo' ? 'selected' : '' }}>Balai RS PMKS Sidoarjo</option>
                                    <option value="UPT RSBN Malang" {{ $currentUpt == 'UPT RSBN Malang' ? 'selected' : '' }}>UPT RSBN Malang</option>
                                @endif
                            </select>
                            @error('upt_lokasi')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label font-w600 text-dark">Verifikasi DTKS</label>
                            <a href="https://cekbansos.kemensos.go.id/" target="_blank" rel="noopener noreferrer" class="btn-dtks-kemensos" title="Buka portal Cek Bansos Kemensos RI">
                                <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Cek di Kemensos
                            </a>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">Nama Orang Tua / Wali</label>
                            <input type="text" class="form-control" name="nama_wali" placeholder="Nama lengkap wali / orang tua" value="{{ old('nama_wali') }}">
                            @error('nama_wali')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">Hubungan dengan Pasien</label>
                            <select name="hubungan_wali" class="form-control">
                                <option value="Orang Tua Kandung" {{ old('hubungan_wali', 'Orang Tua Kandung') == 'Orang Tua Kandung' ? 'selected' : '' }}>Orang Tua Kandung</option>
                                <option value="Wali" {{ old('hubungan_wali') == 'Wali' ? 'selected' : '' }}>Wali</option>
                                <option value="Pengasuh UPT" {{ old('hubungan_wali') == 'Pengasuh UPT' ? 'selected' : '' }}>Pengasuh UPT</option>
                                <option value="Keluarga / Kerabat" {{ old('hubungan_wali') == 'Keluarga / Kerabat' ? 'selected' : '' }}>Keluarga / Kerabat</option>
                                <option value="Lainnya" {{ old('hubungan_wali') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('hubungan_wali')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label font-w600 text-dark d-block" style="margin-bottom: 8px;">
                                Ragam Disabilitas <small class="text-muted font-w400">(Dapat dipilih lebih dari satu)</small>
                            </label>
                            @php
                                $oldDis = (array) old('jenis_disabilitas', []);
                                $disOpts = ['Fisik', 'Intelektual', 'Mental', 'Sensorik Netra', 'Sensorik Rungu/Wicara', 'Ganda', 'Lainnya'];
                            @endphp
                            <div class="d-flex flex-wrap" style="gap: 8px;">
                                @foreach($disOpts as $disOpt)
                                    <label class="check-pill-card {{ in_array($disOpt, $oldDis) ? 'active' : '' }}">
                                        <input type="checkbox" name="jenis_disabilitas[]" value="{{ $disOpt }}" {{ in_array($disOpt, $oldDis) ? 'checked' : '' }}>
                                        <span>{{ $disOpt }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div id="wrapper_disabilitas_lainnya" class="mt-2 {{ in_array('Lainnya', $oldDis) ? '' : 'd-none' }}" style="max-width: 480px;">
                                <input type="text" class="form-control" name="jenis_disabilitas_lainnya" id="input_disabilitas_lainnya" placeholder="Sebutkan ragam disabilitas lainnya..." value="{{ old('jenis_disabilitas_lainnya') }}" style="height: 38px; font-size: 12.5px;">
                            </div>
                            @error('jenis_disabilitas')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label font-w600 text-dark d-block" style="margin-bottom: 8px;">
                                Alat Bantu Mobilitas <small class="text-muted font-w400">(Dapat dipilih lebih dari satu)</small>
                            </label>
                            @php
                                $oldAb = (array) old('alat_bantu', ['Tidak Ada']);
                                $isTidakAda = in_array('Tidak Ada', $oldAb);
                                $abOpts = ['Kursi Roda', 'Tongkat Ketiak (Crutches)', 'Walker', 'Tripod / Quadripod', 'Alat Bantu Dengar', 'Kruk / Tongkat Penuntun', 'AFO / Splint', 'Lainnya'];
                            @endphp
                            <div class="d-flex flex-wrap" style="gap: 8px;">
                                <label class="check-pill-card {{ $isTidakAda ? 'active' : '' }}">
                                    <input type="checkbox" name="alat_bantu[]" id="ab_tidak_ada" class="ab-tidak-ada-check" value="Tidak Ada" {{ $isTidakAda ? 'checked' : '' }}>
                                    <span>Tidak Ada</span>
                                </label>

                                @foreach($abOpts as $abOpt)
                                    <label class="check-pill-card ab-option-pill {{ in_array($abOpt, $oldAb) && !$isTidakAda ? 'active' : '' }}" style="{{ $isTidakAda ? 'display: none !important;' : '' }}">
                                        <input type="checkbox" name="alat_bantu[]" class="ab-item-check" value="{{ $abOpt }}" {{ in_array($abOpt, $oldAb) && !$isTidakAda ? 'checked' : '' }}>
                                        <span>{{ $abOpt }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div id="wrapper_alat_bantu_lainnya" class="mt-2 {{ in_array('Lainnya', $oldAb) && !$isTidakAda ? '' : 'd-none' }}" style="max-width: 480px;">
                                <input type="text" class="form-control" name="alat_bantu_lainnya" id="input_alat_bantu_lainnya" placeholder="Sebutkan alat bantu lainnya..." value="{{ old('alat_bantu_lainnya') }}" style="height: 38px; font-size: 12.5px;">
                            </div>
                            @error('alat_bantu')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- BAGIAN: PILIHAN LAYANAN & RENCANA KUNJUNGAN -->
                    <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 14.5px;">
                            <i class="fa-solid fa-calendar-check mr-2" style="color: #2563eb;"></i> Pilihan Layanan & Rencana Kunjungan
                        </h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">Layanan Terapi <span class="text-danger">*</span></label>
                            <select name="layanan_terapi" class="form-control" required>
                                <option value="Fisioterapi Pediatrik" {{ old('layanan_terapi', 'Fisioterapi Pediatrik') == 'Fisioterapi Pediatrik' ? 'selected' : '' }}>Fisioterapi Pediatrik (Motorik & Postur)</option>
                                <option value="Terapi Wicara & Bahasa" {{ old('layanan_terapi') == 'Terapi Wicara & Bahasa' ? 'selected' : '' }}>Terapi Wicara & Bahasa (Oral Motor)</option>
                                <option value="Terapi Okupasi" {{ old('layanan_terapi') == 'Terapi Okupasi' ? 'selected' : '' }}>Terapi Okupasi (Sensori & Kemandirian)</option>
                                <option value="Sensori Integrasi (SI)" {{ old('layanan_terapi') == 'Sensori Integrasi (SI)' ? 'selected' : '' }}>Sensori Integrasi (SI)</option>
                                <option value="Hidroterapi Anak" {{ old('layanan_terapi') == 'Hidroterapi Anak' ? 'selected' : '' }}>Hidroterapi Anak (Kolam Terapi)</option>
                            </select>
                            @error('layanan_terapi')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label font-w600 text-dark">Tanggal Rencana Sesi I <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_rencana_kunjungan" class="form-control" min="{{ date('Y-m-d') }}" required value="{{ old('tgl_rencana_kunjungan', date('Y-m-d')) }}">
                            @error('tgl_rencana_kunjungan')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label font-w600 text-dark">
                                Sesi Waktu <span class="text-danger">*</span> <small class="text-muted font-w400">(Rabu, 30-45 mnt)</small>
                            </label>
                            @php
                                $currJam = old('jam_rencana_kunjungan', 'Sesi 1 (08.00 - 08.45 WIB)');
                            @endphp
                            <select name="jam_rencana_kunjungan" class="form-control" required>
                                <option value="">--Pilih Slot Sesi Waktu--</option>
                                <option value="Sesi 1 (08.00 - 08.45 WIB)" {{ $currJam == 'Sesi 1 (08.00 - 08.45 WIB)' ? 'selected' : '' }}>Sesi 1 (08.00 - 08.45 WIB)</option>
                                <option value="Sesi 2 (08.45 - 09.30 WIB)" {{ $currJam == 'Sesi 2 (08.45 - 09.30 WIB)' ? 'selected' : '' }}>Sesi 2 (08.45 - 09.30 WIB)</option>
                                <option value="Sesi 3 (09.30 - 10.15 WIB)" {{ $currJam == 'Sesi 3 (09.30 - 10.15 WIB)' ? 'selected' : '' }}>Sesi 3 (09.30 - 10.15 WIB)</option>
                                <option value="Sesi 4 (10.15 - 11.00 WIB)" {{ $currJam == 'Sesi 4 (10.15 - 11.00 WIB)' ? 'selected' : '' }}>Sesi 4 (10.15 - 11.00 WIB)</option>
                                <option value="Sesi 5 (11.00 - 11.45 WIB)" {{ $currJam == 'Sesi 5 (11.00 - 11.45 WIB)' ? 'selected' : '' }}>Sesi 5 (11.00 - 11.45 WIB)</option>
                                <option value="Sesi 6 (11.45 - 12.30 WIB)" {{ $currJam == 'Sesi 6 (11.45 - 12.30 WIB)' ? 'selected' : '' }}>Sesi 6 (11.45 - 12.30 WIB)</option>
                                <option value="Sesi 7 (12.30 - 13.00 WIB)" {{ $currJam == 'Sesi 7 (12.30 - 13.00 WIB)' ? 'selected' : '' }}>Sesi 7 (12.30 - 13.00 WIB)</option>
                                <option value="Sesi Khusus / Fleksibel" {{ $currJam == 'Sesi Khusus / Fleksibel' ? 'selected' : '' }}>Sesi Khusus / Fleksibel</option>
                            </select>
                            @error('jam_rencana_kunjungan')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label font-w600 text-dark">Keluhan & Kebutuhan Terapi</label>
                            <textarea name="keluhan_utama" class="form-control" rows="2" placeholder="Jelaskan secara singkat kondisi atau keluhan yang dialami pasien..." style="height: auto; min-height: 70px;">{{ old('keluhan_utama') }}</textarea>
                            @error('keluhan_utama')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- BAGIAN: BERKAS & DOKUMEN PENDUKUNG -->
                    <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 14.5px;">
                            <i class="fa-solid fa-folder-open mr-2" style="color: #2563eb;"></i> Berkas & Dokumen Pendukung (Opsional)
                        </h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">File Kartu Keluarga (KK)</label>
                            <input type="file" class="form-control-file" name="file_kk" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted d-block mt-1" style="font-size: 11.5px;">
                                <i class="fa-solid fa-circle-info mr-1 text-primary"></i> Format: JPG, JPEG, PNG, PDF (Maksimal 10MB)
                            </small>
                            @error('file_kk')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-w600 text-dark">Surat Resume / Riwayat Berobat Sebelumnya</label>
                            <input type="file" class="form-control-file" name="file_resume" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted d-block mt-1" style="font-size: 11.5px;">
                                <i class="fa-solid fa-circle-info mr-1 text-primary"></i> Format: JPG, JPEG, PNG, PDF (Maksimal 10MB)
                            </small>
                            @error('file_resume')
                                <div class="invalid-feedback d-block" style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="submit-action-wrapper mt-4 pt-3" style="border-top: 1px solid #edf2f7;">
                        <button type="submit" class="btn-submit btn-submit-daftar" id="btnSubmitDaftar">
                            <i class="fa-solid fa-paper-plane mr-2"></i>
                            <span>Kirim Pendaftaran & Dapatkan Kode Registrasi</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ======================================================== -->
            <!-- TAB 3: LACAK STATUS REGISTRASI & BOOKING                 -->
            <!-- ======================================================== -->
            <div class="tab-content-panel" id="tab-lacak">
                <div class="mb-4">
                    <h2 style="font-size: 17px; font-weight: 800; color: var(--ot-navy); margin: 0 0 4px 0; letter-spacing: -0.2px;">
                        Lacak Status Pendaftaran & Booking Sesi
                    </h2>
                    <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5;">
                        Masukkan Nomor Registrasi / Booking beserta Nomor HP atau NIK yang terdaftar untuk memverifikasi dan melacak status proses.
                    </p>
                </div>

                <div class="search-form-card mb-4">
                    <div class="form-grid-rm" style="gap: 22px;">
                        <!-- No. Registrasi / Booking -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="inputTrackKode" class="form-label" style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">
                                <i class="fa-solid fa-barcode text-primary mr-1"></i>
                                <span>No. Registrasi / No. RM / Kode Booking <span class="text-danger">*</span></span>
                            </label>
                            <input 
                                type="text" 
                                id="inputTrackKode" 
                                name="kode" 
                                class="form-input" 
                                placeholder="Contoh: OTK-26-00015 / REG-2609-00001 / BKG-2609-00001" 
                                style="height: 46px; font-size: 13.5px; border-radius: 9px; padding: 10px 16px;"
                            >
                        </div>

                        <!-- No. HP / Telepon -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="inputTrackHp" class="form-label" style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">
                                <i class="fa-solid fa-phone text-primary mr-1"></i>
                                <span>No. HP / NIK Terdaftar <span class="text-danger">*</span></span>
                            </label>
                            <input 
                                type="text" 
                                id="inputTrackHp" 
                                name="no_hp" 
                                class="form-input" 
                                placeholder="Masukkan No. HP atau NIK terdaftar" 
                                style="height: 46px; font-size: 13.5px; border-radius: 9px; padding: 10px 16px;"
                            >
                        </div>

                        <!-- Tombol Lacak -->
                        <button type="button" class="btn-submit" id="btnTrackSearch" style="height: 46px; padding: 0 28px; font-size: 13.5px; border-radius: 9px;">
                            <i class="fa-solid fa-magnifying-glass mr-1"></i>
                            <span>Lacak Status</span>
                        </button>
                    </div>
                </div>

                <!-- Live Status Result Wrapper -->
                <div id="trackResultWrapper" style="display: none;"></div>
            </div>
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

    <!-- Modal Sukses Pendaftaran Baru -->
    @if(Session::has('pendaftaran_success'))
        <div class="modal-overlay active" id="modalSuccessPendaftaran">
            <div class="modal-box text-center p-4" style="max-width: 480px;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: #ecfdf5; color: #059669; font-size: 24px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; border: 1px solid #a7f3d0;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h3 style="font-size: 17px; font-weight: 800; color: var(--ot-navy); margin-bottom: 2px;">Pendaftaran Berhasil Terkirim!</h3>
                <p style="font-size: 12.5px; color: #64748b; margin-bottom: 12px;">
                    Data registrasi penerima manfaat baru telah tersimpan di sistem Omah Terapi-KU.
                </p>

                <div style="background: #eff6ff; border: 1px dashed #2563eb; border-radius: 9px; padding: 12px; margin-bottom: 14px; text-align: left;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kode Registrasi:</span>
                        <button type="button" class="btn btn-xs btn-light font-w700" onclick="copyKodeReg()" style="font-size: 11px; border: 1px solid #cbd5e1; border-radius: 5px; padding: 2px 7px;">
                            <i class="fa-regular fa-copy mr-1"></i> Salin
                        </button>
                    </div>
                    <div style="font-size: 18px; font-weight: 800; color: #1e40af; letter-spacing: 0.5px; margin-bottom: 8px;" id="copyCodeText">
                        {{ Session::get('kode_pendaftaran') }}
                    </div>
                    <div style="font-size: 12px; color: #334155; border-top: 1px dashed #bfdbfe; padding-top: 6px; line-height: 1.5;">
                        <div><strong>Pasien:</strong> {{ Session::get('nama_pasien') }}</div>
                        <div><strong>Layanan:</strong> {{ Session::get('layanan_terapi') ?: 'Layanan Terpadu' }}</div>
                        <div><strong>Jadwal:</strong> {{ Session::get('tgl_rencana') }} ({{ Session::get('jam_rencana') }})</div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-center flex-wrap" style="gap: 8px; margin-bottom: 8px;">
                    <a href="{{ Session::get('cetak_url') ?: (Session::has('kode_pendaftaran') ? route('portal.pendaftaran.cetak', Session::get('kode_pendaftaran')) : '#') }}" target="_blank" class="btn btn-primary font-w700" style="border-radius: 7px; padding: 8px 16px; font-size: 12.5px; flex: 1; min-width: 170px; text-decoration: none;">
                        <i class="fa-solid fa-print mr-1"></i> Cetak Bukti (PDF)
                    </a>
                    <button type="button" class="btn btn-light font-w600" onclick="document.getElementById('modalSuccessPendaftaran').classList.remove('active')" style="border: 1px solid #cbd5e1; border-radius: 7px; padding: 8px 16px; font-size: 12.5px;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Petunjuk Bantuan -->
    <div class="modal-overlay" id="helpModal">
        <div class="modal-box">
            <button type="button" class="modal-close" id="btnCloseHelp">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="d-flex align-items-center mb-3" style="gap: 10px;">
                <div style="width: 34px; height: 34px; border-radius: 7px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <div>
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--ot-navy); margin: 0;">Petunjuk Akses Portal</h3>
                </div>
            </div>
            <div style="font-size: 12.5px; line-height: 1.55; color: #475569;">
                <p class="mb-2"><strong>1. Pasien Lama (Cek Rekam Medis):</strong></p>
                <p class="mb-2.5 text-muted">Gunakan Nomor Rekam Medis resmi (contoh: OTK-24-00001) dan tanggal lahir pasien yang terdaftar.</p>
                <p class="mb-2"><strong>2. Pasien Baru (Pendaftaran Online):</strong></p>
                <p class="mb-2.5 text-muted">Isi data lengkap penerima manfaat baru untuk mendapatkan <em>Kode Registrasi</em> (contoh: REG-2609-001).</p>
                <p class="mb-2"><strong>3. Lacak Status:</strong></p>
                <p class="mb-0 text-muted">Pantau status verifikasi pendaftaran dan penugasan terapis melalui menu Lacak Status.</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>

    <script>
        // Native Tab Navigation with Smooth Auto-Scroll
        document.addEventListener('DOMContentLoaded', function() {
            var tabsNav = document.querySelector('.portal-tabs-nav');
            var tabBtns = document.querySelectorAll('.tab-btn');
            var tabPanels = document.querySelectorAll('.tab-content-panel');

            tabBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var targetTabId = this.getAttribute('data-tab');

                    tabBtns.forEach(function(b) { b.classList.remove('active'); });
                    this.classList.add('active');

                    // Auto scroll tab into view on mobile
                    if (tabsNav) {
                        var btnRect = this.getBoundingClientRect();
                        var navRect = tabsNav.getBoundingClientRect();
                        if (btnRect.left < navRect.left || btnRect.right > navRect.right) {
                            this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                        }
                    }

                    tabPanels.forEach(function(panel) { panel.classList.remove('active'); });
                    var targetPanel = document.getElementById(targetTabId);
                    if (targetPanel) {
                        targetPanel.classList.add('active');
                    }

                    if (targetTabId === 'tab-daftar-baru') {
                        setTimeout(function() {
                            if (typeof WilayahManager !== 'undefined') {
                                WilayahManager.initSelect2();
                            }
                        }, 50);
                    }
                });
            });

            // Smooth Drag to Scroll for Tabs Nav
            if (tabsNav) {
                var isDown = false;
                var startX;
                var scrollLeft;

                tabsNav.addEventListener('mousedown', function(e) {
                    isDown = true;
                    startX = e.pageX - tabsNav.offsetLeft;
                    scrollLeft = tabsNav.scrollLeft;
                });
                tabsNav.addEventListener('mouseleave', function() {
                    isDown = false;
                });
                tabsNav.addEventListener('mouseup', function() {
                    isDown = false;
                });
                tabsNav.addEventListener('mousemove', function(e) {
                    if (!isDown) return;
                    e.preventDefault();
                    var x = e.pageX - tabsNav.offsetLeft;
                    var walk = (x - startX) * 1.5;
                    tabsNav.scrollLeft = scrollLeft - walk;
                });
            }

            // Navbar Mobile Menu Toggle Handlers
            var navToggleBtn = document.getElementById('navToggleBtn');
            var navbarMobileMenu = document.getElementById('navbarMobileMenu');
            var navToggleIcon = document.getElementById('navToggleIcon');

            if (navToggleBtn && navbarMobileMenu) {
                navToggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var isOpen = navbarMobileMenu.classList.toggle('active');
                    navToggleBtn.setAttribute('aria-expanded', isOpen);
                    if (navToggleIcon) {
                        navToggleIcon.className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
                    }
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (navbarMobileMenu.classList.contains('active') && !navbarMobileMenu.contains(e.target) && !navToggleBtn.contains(e.target)) {
                        navbarMobileMenu.classList.remove('active');
                        navToggleBtn.setAttribute('aria-expanded', 'false');
                        if (navToggleIcon) navToggleIcon.className = 'fa-solid fa-bars';
                    }
                });

                // Mobile Tab Items Navigation
                $('.mobile-tab-item').on('click', function() {
                    var targetTab = $(this).data('target-tab');
                    if (targetTab) {
                        $('.tab-btn[data-tab="' + targetTab + '"]').click();
                        navbarMobileMenu.classList.remove('active');
                        navToggleBtn.setAttribute('aria-expanded', 'false');
                        if (navToggleIcon) navToggleIcon.className = 'fa-solid fa-bars';
                        var cardEl = document.querySelector('.portal-card');
                        if (cardEl) {
                            cardEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                });
            }

            // Help Modal Handlers (Desktop & Mobile triggers)
            var helpModal = document.getElementById('helpModal');
            var btnCloseHelp = document.getElementById('btnCloseHelp');

            $(document).on('click', '.btn-help-trigger', function() {
                if (helpModal) helpModal.classList.add('active');
                if (navbarMobileMenu) {
                    navbarMobileMenu.classList.remove('active');
                    if (navToggleBtn) navToggleBtn.setAttribute('aria-expanded', 'false');
                    if (navToggleIcon) navToggleIcon.className = 'fa-solid fa-bars';
                }
            });

            if (btnCloseHelp && helpModal) {
                btnCloseHelp.addEventListener('click', function() {
                    helpModal.classList.remove('active');
                });
            }
            if (helpModal) {
                helpModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.remove('active');
                    }
                });
            }
        });

        // Copy Kode Registrasi
        function copyKodeReg() {
            var el = document.getElementById('copyCodeText');
            if (!el) return;
            var text = el.innerText.trim();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Kode Registrasi berhasil disalin!', 'Tersalin', {timeOut: 2000});
                    } else {
                        alert('Kode Registrasi berhasil disalin: ' + text);
                    }
                });
            }
        }

        // Fast switch to Tab 1 with pre-filled No. RM
        function loginWithRm(noRm) {
            var btnCekRm = document.querySelector('.tab-btn[data-tab="tab-cek-rm"]');
            if (btnCekRm) btnCekRm.click();
            var inputNoRm = document.getElementById('inputNoRm');
            if (inputNoRm) inputNoRm.value = noRm;
            var inputTgl = document.getElementById('inputTglLahir');
            if (inputTgl) inputTgl.focus();
        }

        // Live Tracking Status AJAX Handler
        $(document).ready(function() {
            // Desil helper badge
            function updateDesilBadge() {
                var val = $('#desil').val();
                var $badge = $('#desilBadge');
                if (!val) {
                    $badge.addClass('d-none').html('');
                    return;
                }
                $badge.removeClass('d-none');
                if (['Desil 1', 'Desil 2', 'Desil 3', 'Desil 4'].indexOf(val) !== -1) {
                    $badge.html('<div style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 6px; font-size: 11.5px; font-weight: 700; color: #059669;"><i class="fa-solid fa-circle-check"></i> PRIORITAS PROGRAM (' + val + ' - Masuk Kuota Prioritas)</div>');
                } else if (val === 'Non-Desil') {
                    $badge.html('<div style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 700; color: #475569;"><i class="fa-solid fa-circle-info"></i> NON-DESIL / BELUM TERDATA (Layanan Tetap Terbuka)</div>');
                } else {
                    $badge.html('<div style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; font-size: 11.5px; font-weight: 700; color: #d97706;"><i class="fa-solid fa-triangle-exclamation"></i> NON-PRIORITAS (' + val + ' - Tidak Prioritas / Layanan Tetap Terbuka)</div>');
                }
            }
            $('#desil').on('change', updateDesilBadge);
            updateDesilBadge();

            // Toggle Disabilitas Lainnya
            $(document).on('change', 'input[name="jenis_disabilitas[]"]', function() {
                var isLainnya = $('input[name="jenis_disabilitas[]"][value="Lainnya"]').is(':checked');
                if (isLainnya) {
                    $('#wrapper_disabilitas_lainnya').removeClass('d-none');
                } else {
                    $('#wrapper_disabilitas_lainnya').addClass('d-none');
                }

                if ($(this).is(':checked')) {
                    $(this).closest('.check-pill-card').addClass('active');
                } else {
                    $(this).closest('.check-pill-card').removeClass('active');
                }
            });

            // Toggle Alat Bantu Mobilitas
            $(document).on('change', '#ab_tidak_ada', function() {
                if ($(this).is(':checked')) {
                    $('.ab-item-check').prop('checked', false).closest('.check-pill-card').removeClass('active');
                    $('.ab-option-pill').attr('style', 'display: none !important;');
                    $('#wrapper_alat_bantu_lainnya').addClass('d-none');
                    $(this).closest('.check-pill-card').addClass('active');
                } else {
                    $('.ab-option-pill').removeAttr('style');
                    $(this).closest('.check-pill-card').removeClass('active');
                }
            });

            $(document).on('change', '.ab-item-check', function() {
                if ($(this).is(':checked')) {
                    $('#ab_tidak_ada').prop('checked', false).closest('.check-pill-card').removeClass('active');
                    $(this).closest('.check-pill-card').addClass('active');
                } else {
                    $(this).closest('.check-pill-card').removeClass('active');
                }

                var isAbLainnya = $('.ab-item-check[value="Lainnya"]').is(':checked');
                if (isAbLainnya && !$('#ab_tidak_ada').is(':checked')) {
                    $('#wrapper_alat_bantu_lainnya').removeClass('d-none');
                } else {
                    $('#wrapper_alat_bantu_lainnya').addClass('d-none');
                }
            });

            // Tracking Search
            $('#btnTrackSearch').on('click', function() {
                var kode = $('#inputTrackKode').val().trim();
                var noHp = $('#inputTrackHp').val().trim();

                if (!kode) {
                    toastr.warning('Masukkan Nomor Registrasi atau Kode Booking Anda terlebih dahulu.', 'Perhatian');
                    $('#inputTrackKode').focus();
                    return;
                }

                if (!noHp) {
                    toastr.warning('Masukkan Nomor HP atau NIK yang terdaftar untuk verifikasi data.', 'Perhatian');
                    $('#inputTrackHp').focus();
                    return;
                }

                var btn = $(this);
                btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Melacak...');

                $.ajax({
                    url: "{{ route('portal.lacak.status') }}",
                    type: "GET",
                    data: { kode: kode, no_hp: noHp },
                    success: function(res) {
                        btn.prop('disabled', false).html('<i class="fa-solid fa-magnifying-glass mr-1"></i> Lacak Status');
                        if (res.success) {
                            var html = '';

                            // 1. Data Penerima Manfaat Terdaftar (No. RM)
                            if (res.pasien) {
                                var pas = res.pasien;
                                html += '<div class="track-result-box mb-3">';
                                html += '  <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">';
                                html += '    <div>';
                                html += '      <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;"><i class="fa-solid fa-hospital-user text-primary mr-1"></i> Profil Penerima Manfaat Terdaftar</span>';
                                html += '      <h4 style="font-size: 16px; font-weight: 800; color: #1e40af; margin: 2px 0;">' + pas.no_rm + ' &bull; ' + pas.nama + '</h4>';
                                html += '    </div>';
                                html += '    <div class="d-flex align-items-center" style="gap: 6px;">';
                                html += '      ' + (pas.status_text || '');
                                html += '      <button type="button" onclick="loginWithRm(\'' + pas.no_rm + '\')" class="btn btn-sm btn-primary font-w700" style="border-radius: 6px; padding: 4px 12px; font-size: 12px;"><i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Masuk Portal</button>';
                                html += '    </div>';
                                html += '  </div>';

                                html += '  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; font-size: 12.5px; margin-bottom: 6px;">';
                                html += '    <div><span class="text-muted">Nama Lengkap:</span> <strong class="text-dark d-block">' + pas.nama + '</strong></div>';
                                html += '    <div><span class="text-muted">NIK:</span> <strong class="text-dark d-block">' + pas.nik + '</strong></div>';
                                html += '    <div><span class="text-muted">No. HP / Kontak:</span> <strong class="text-dark d-block">' + pas.no_hp + '</strong></div>';
                                html += '    <div><span class="text-muted">Lokasi UPT:</span> <strong class="text-dark d-block">' + pas.upt_lokasi + '</strong></div>';
                                html += '    <div><span class="text-muted">Riwayat Pelayanan:</span> <strong class="text-primary d-block font-w700">' + pas.total_sesi + ' Sesi Selesai</strong></div>';
                                if (pas.sesi_terakhir) {
                                    html += '    <div><span class="text-muted">Kunjungan Terakhir:</span> <strong class="text-dark d-block"><i class="fa-regular fa-calendar-check text-success mr-1"></i>' + pas.sesi_terakhir + '</strong></div>';
                                }
                                if (pas.terapis_terakhir) {
                                    html += '    <div><span class="text-muted">Terapis Terakhir:</span> <strong class="text-dark d-block"><i class="fa-solid fa-user-doctor text-info mr-1"></i>' + pas.terapis_terakhir + '</strong></div>';
                                }
                                html += '  </div>';
                                html += '</div>';
                            }

                            // 2. Data Pendaftaran Pasien Baru Online
                            if (res.pendaftaran) {
                                var p = res.pendaftaran;
                                var regCetakUrl = p.cetak_url || ('/portal/pendaftaran/' + p.kode + '/cetak');
                                html += '<div class="track-result-box">';
                                html += '  <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">';
                                html += '    <div>';
                                html += '      <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Pendaftaran Pasien Baru</span>';
                                html += '      <h4 style="font-size: 15px; font-weight: 800; color: #1e40af; margin: 2px 0;">' + p.kode + '</h4>';
                                html += '    </div>';
                                html += '    <div class="d-flex align-items-center" style="gap: 6px;">';
                                html += '      ' + p.status_badge;
                                html += '      <a href="' + regCetakUrl + '" target="_blank" class="btn btn-sm btn-outline-primary font-w700" style="border-radius: 6px; padding: 3px 8px; font-size: 11px;" title="Cetak Bukti"><i class="fa-solid fa-print mr-1"></i> Cetak</a>';
                                html += '    </div>';
                                html += '  </div>';

                                html += '  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; font-size: 12.5px; margin-bottom: 14px;">';
                                html += '    <div><span class="text-muted">Nama Pasien:</span> <strong class="text-dark d-block">' + p.nama + '</strong></div>';
                                html += '    <div><span class="text-muted">NIK:</span> <strong class="text-dark d-block">' + p.nik + '</strong></div>';
                                html += '    <div><span class="text-muted">No. HP / Telepon:</span> <strong class="text-dark d-block">' + (p.no_hp || '-') + '</strong></div>';
                                html += '    <div><span class="text-muted">Layanan:</span> <strong class="text-primary d-block font-w700">' + (p.layanan_terapi || 'Layanan Terpadu') + '</strong></div>';
                                html += '    <div><span class="text-muted">Rencana Kunjungan:</span> <strong class="text-dark d-block">' + (p.tgl_rencana || '-') + ' (' + (p.jam_rencana || 'Sesi 1 (08.00 - 08.45 WIB)') + ')</strong></div>';
                                html += '    <div><span class="text-muted">Lokasi UPT:</span> <strong class="text-dark d-block">' + p.upt_lokasi + '</strong></div>';
                                html += '  </div>';

                                if (p.status === 'disetujui' && p.no_rm) {
                                    html += '  <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 12px; margin-bottom: 12px;">';
                                    html += '    <div style="font-size: 12.5px; font-weight: 700; color: #059669;"><i class="fa-solid fa-circle-check mr-1"></i> Pendaftaran Telah Disetujui!</div>';
                                    html += '    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; margin-top: 8px; font-size: 12.5px;">';
                                    html += '      <div><span class="text-muted">No. Rekam Medis:</span> <strong class="text-primary d-block" style="font-size: 15px;">' + p.no_rm + '</strong></div>';
                                    html += '      <div><span class="text-muted">Terapis:</span> <strong class="text-success d-block font-w700"><i class="fa-solid fa-user-doctor mr-1"></i>' + (p.terapis_nama || 'Petugas Terapis') + '</strong></div>';
                                    html += '      <div><span class="text-muted">Jadwal Sesi I:</span> <strong class="text-dark d-block"><i class="fa-regular fa-calendar-check mr-1"></i>' + (p.tgl_sesi_disetujui || p.tgl_rencana) + ' (' + (p.jam_sesi_disetujui || p.jam_rencana) + ')</strong></div>';
                                    html += '    </div>';
                                    if (p.catatan) {
                                        html += '    <div class="mt-2 pt-2" style="border-top: 1px dashed #a7f3d0; font-size: 12px; color: #065f46;"><strong>Catatan Petugas:</strong> ' + p.catatan + '</div>';
                                    }
                                    html += '    <div class="mt-2.5 d-flex align-items-center flex-wrap" style="gap: 6px;">';
                                    html += '      <button type="button" onclick="loginWithRm(\'' + p.no_rm + '\')" class="btn btn-sm btn-primary font-w700" style="border-radius: 6px; padding: 5px 12px; font-size: 12px;"><i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Buka Rekam Medis</button>';
                                    html += '      <a href="' + regCetakUrl + '" target="_blank" class="btn btn-sm btn-outline-success font-w700" style="border-radius: 6px; padding: 5px 12px; font-size: 11.5px;"><i class="fa-solid fa-print mr-1"></i> Cetak Bukti</a>';
                                    html += '    </div>';
                                    html += '  </div>';
                                } else if (p.status === 'ditolak') {
                                    html += '  <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px; color: #dc2626; font-size: 12px;">';
                                    html += '    <strong><i class="fa-solid fa-circle-xmark mr-1"></i> Catatan Penolakan:</strong> ' + (p.catatan || 'Berkas/persyaratan belum memenuhi kriteria.');
                                    html += '  </div>';
                                } else {
                                    html += '  <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px; color: #1e40af; font-size: 12px; line-height: 1.4;">';
                                    html += '    <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 6px;">';
                                    html += '      <div><i class="fa-solid fa-hourglass-half mr-1"></i> <strong>Menunggu Verifikasi:</strong> Sedang dalam antrean verifikasi berkas & penugasan terapis.</div>';
                                    html += '      <a href="' + regCetakUrl + '" target="_blank" class="btn btn-xs btn-outline-primary font-w700" style="border-radius: 5px; padding: 3px 8px; font-size: 11px;"><i class="fa-solid fa-print mr-1"></i> Cetak Bukti</a>';
                                    html += '    </div>';
                                    html += '  </div>';
                                }
                                html += '</div>';
                            }

                            if (res.booking) {
                                var b = res.booking;
                                var bkgCetakUrl = b.cetak_url || ('/portal/booking/' + b.kode + '/cetak');
                                html += '<div class="track-result-box" style="margin-top: 14px;">';
                                html += '  <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">';
                                html += '    <div>';
                                html += '      <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Permohonan Booking Sesi</span>';
                                html += '      <h4 style="font-size: 15px; font-weight: 800; color: #1e40af; margin: 2px 0;">' + b.kode + '</h4>';
                                html += '    </div>';
                                html += '    <div class="d-flex align-items-center" style="gap: 6px;">';
                                html += '      ' + b.status_badge;
                                html += '      <a href="' + bkgCetakUrl + '" target="_blank" class="btn btn-sm btn-outline-primary font-w700" style="border-radius: 6px; padding: 3px 8px; font-size: 11px;" title="Cetak Bukti Booking"><i class="fa-solid fa-print mr-1"></i> Cetak</a>';
                                html += '    </div>';
                                html += '  </div>';

                                html += '  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; font-size: 12.5px;">';
                                html += '    <div><span class="text-muted">Pasien:</span> <strong class="text-dark d-block">' + b.nama_pasien + ' (' + b.no_rm + ')</strong></div>';
                                html += '    <div><span class="text-muted">No. HP / Kontak:</span> <strong class="text-dark d-block">' + (b.no_hp || '-') + '</strong></div>';
                                html += '    <div><span class="text-muted">Layanan:</span> <strong class="text-primary d-block font-w700">' + b.layanan + '</strong></div>';
                                html += '    <div><span class="text-muted">Jadwal:</span> <strong class="text-dark d-block">' + b.tgl_rencana + ' (' + (b.jam_sesi || 'Sesi 1 (08.00 - 08.45 WIB)') + ')</strong></div>';
                                html += '    <div><span class="text-muted">Terapis:</span> <strong class="text-dark d-block">' + b.terapis + '</strong></div>';
                                html += '  </div>';
                                html += '</div>';
                            }

                            $('#trackResultWrapper').html(html).fadeIn(150);
                        } else {
                            $('#trackResultWrapper').html('<div class="p-3 text-center text-muted" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin-top: 14px; font-size: 12.5px;"><i class="fa-solid fa-triangle-exclamation text-warning mr-1"></i> ' + res.message + '</div>').fadeIn(150);
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fa-solid fa-magnifying-glass mr-1"></i> Lacak Status');
                        toastr.error('Terjadi gangguan koneksi. Silakan coba lagi.', 'Error');
                    }
                });
            });

            // Enter key trigger on tracking inputs
            $('#inputTrackKode, #inputTrackHp').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#btnTrackSearch').click();
                }
            });

            // Initialize Wilayah API Manager
            WilayahManager.init();

            // Flash Toastr
            @if(Session::has('sukses'))
                toastr.success("{{ Session::get('sukses') }}", "Berhasil", {timeOut: 3500, closeButton: true});
            @endif
            @if(Session::has('gagal'))
                toastr.error("{{ Session::get('gagal') }}", "Gagal", {timeOut: 4500, closeButton: true});
            @endif
        });

        // =========================================================================
        // WILAYAH API BERJENJANG MANAGER (Wilayah.id via Proxy)
        // =========================================================================
        const WilayahManager = {
            proxyUrl: "{{ url('/api/wilayah') }}",
            savedKab: "{{ old('kabupaten') }}",
            savedKec: "{{ old('kecamatan') }}",
            savedKel: "{{ old('kelurahan') }}",
            provincesData: [],
            regenciesData: [],
            districtsData: [],
            villagesData: [],
            isInitializing: false,

            fallbackProvinces: [
                { code: "11", name: "Aceh" },
                { code: "12", name: "Sumatera Utara" },
                { code: "13", name: "Sumatera Barat" },
                { code: "14", name: "Riau" },
                { code: "15", name: "Jambi" },
                { code: "16", name: "Sumatera Selatan" },
                { code: "17", name: "Bengkulu" },
                { code: "18", name: "Lampung" },
                { code: "19", name: "Kepulauan Bangka Belitung" },
                { code: "21", name: "Kepulauan Riau" },
                { code: "31", name: "DKI Jakarta" },
                { code: "32", name: "Jawa Barat" },
                { code: "33", name: "Jawa Tengah" },
                { code: "34", name: "Daerah Istimewa Yogyakarta" },
                { code: "35", name: "Jawa Timur" },
                { code: "36", name: "Banten" },
                { code: "51", name: "Bali" },
                { code: "52", name: "Nusa Tenggara Barat" },
                { code: "53", name: "Nusa Tenggara Timur" },
                { code: "61", name: "Kalimantan Barat" },
                { code: "62", name: "Kalimantan Tengah" },
                { code: "63", name: "Kalimantan Selatan" },
                { code: "64", name: "Kalimantan Timur" },
                { code: "65", name: "Kalimantan Utara" },
                { code: "71", name: "Sulawesi Utara" },
                { code: "72", name: "Sulawesi Tengah" },
                { code: "73", name: "Sulawesi Selatan" },
                { code: "74", name: "Sulawesi Tenggara" },
                { code: "75", name: "Gorontalo" },
                { code: "76", name: "Sulawesi Barat" },
                { code: "81", name: "Maluku" },
                { code: "82", name: "Maluku Utara" },
                { code: "91", name: "Papua" },
                { code: "92", name: "Papua Barat" },
                { code: "93", name: "Papua Selatan" },
                { code: "94", name: "Papua Tengah" },
                { code: "95", name: "Papua Pegunungan" },
                { code: "96", name: "Papua Barat Daya" }
            ],

            async init() {
                this.initSelect2();
                this.bindEvents();
                this.isInitializing = true;
                await this.loadProvinces();
                this.isInitializing = false;
            },

            initSelect2() {
                $('.select2-wilayah').each(function() {
                    const $this = $(this);
                    if ($this.hasClass('select2-hidden-accessible')) {
                        $this.select2('destroy');
                    }
                    $this.select2({
                        width: '100%',
                        language: {
                            noResults: function() { return 'Tidak ada data ditemukan'; },
                            searching: function() { return 'Mencari...'; }
                        }
                    });
                });
            },

            normalizeName(str) {
                if (!str) return '';
                return str.toString().toLowerCase()
                    .replace(/^(kabupaten|kab\.|kota|kecamatan|kec\.|kelurahan|kel\.|desa|ds\.)\s+/i, '')
                    .replace(/[^a-z0-9]/g, '')
                    .trim();
            },

            getSelectedCode(selectElement, dataList) {
                if (!selectElement) return '';
                const $selected = $(selectElement).find('option:selected');
                let code = $selected.attr('data-code') || $selected.data('code') || '';
                if (!code && selectElement.selectedIndex >= 0) {
                    const opt = selectElement.options[selectElement.selectedIndex];
                    if (opt) code = opt.getAttribute('data-code') || '';
                }
                if (!code && dataList && dataList.length > 0) {
                    const val = $(selectElement).val();
                    if (val) {
                        const normVal = this.normalizeName(val);
                        const found = dataList.find(d => 
                            this.normalizeName(d.name) === normVal || 
                            (d.name && d.name.toLowerCase() === val.toLowerCase())
                        );
                        if (found) code = found.code;
                    }
                }
                return code;
            },

            bindEvents() {
                const self = this;

                // Ganti Provinsi -> Muat Kabupaten
                $('#select_provinsi').on('change', async function() {
                    if (self.isInitializing) return;
                    const provCode = self.getSelectedCode(this, self.provincesData);
                    if (provCode) {
                        await self.loadRegencies(provCode);
                    } else {
                        self.resetSelect('#select_kabupaten', '-- Pilih Kabupaten / Kota --', true);
                        self.resetSelect('#select_kecamatan', '-- Pilih Kab/Kota Dahulu --', true);
                        self.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);
                    }
                });

                // Ganti Kabupaten -> Muat Kecamatan
                $('#select_kabupaten').on('change', async function() {
                    if (self.isInitializing) return;
                    const regCode = self.getSelectedCode(this, self.regenciesData);
                    if (regCode) {
                        await self.loadDistricts(regCode);
                    } else {
                        self.resetSelect('#select_kecamatan', '-- Pilih Kab/Kota Dahulu --', true);
                        self.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);
                    }
                });

                // Ganti Kecamatan -> Muat Kelurahan
                $('#select_kecamatan').on('change', async function() {
                    if (self.isInitializing) return;
                    const distCode = self.getSelectedCode(this, self.districtsData);
                    if (distCode) {
                        await self.loadVillages(distCode);
                    } else {
                        self.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);
                    }
                });
            },

            resetSelect(selector, placeholder, disable = true) {
                const $el = $(selector);
                $el.empty();
                const opt = new Option(placeholder, '', true, true);
                opt.setAttribute('data-code', '');
                $el.append(opt);
                $el.prop('disabled', disable).trigger('change.select2');
            },

            showLoading(level, isShow) {
                const $loader = $(`#loading_${level}`);
                if (isShow) {
                    $loader.removeClass('d-none');
                } else {
                    $loader.addClass('d-none');
                }
            },

            async fetchJson(endpoint, fallbackData = []) {
                try {
                    const res = await fetch(`${this.proxyUrl}/${endpoint}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const json = await res.json();
                        if (json && json.data && Array.isArray(json.data) && json.data.length > 0) {
                            return json.data;
                        }
                    }
                } catch (e) {
                    console.warn(`Wilayah API fetch failed for ${endpoint}:`, e);
                }
                return fallbackData || [];
            },

            async loadProvinces() {
                this.showLoading('provinsi', true);
                try {
                    let provinces = await this.fetchJson('provinces', this.fallbackProvinces);
                    if (!provinces || provinces.length === 0) {
                        provinces = this.fallbackProvinces;
                    }
                    this.provincesData = provinces;

                    const $prov = $('#select_provinsi');
                    $prov.empty();

                    const defaultOpt = new Option('-- Pilih Provinsi --', '', false, false);
                    defaultOpt.setAttribute('data-code', '');
                    $prov.append(defaultOpt);

                    let defaultProvCode = '35'; // Default Jawa Timur
                    let matchedProvCode = '';

                    provinces.forEach(p => {
                        const isSelected = (p.code === defaultProvCode || this.normalizeName(p.name) === 'jawatimur');
                        if (isSelected) {
                            matchedProvCode = p.code;
                        }
                        const opt = new Option(p.name, p.name, false, isSelected);
                        opt.setAttribute('data-code', p.code);
                        $prov.append(opt);
                    });

                    $prov.prop('disabled', false).trigger('change.select2');

                    if (matchedProvCode) {
                        await this.loadRegencies(matchedProvCode, this.savedKab);
                    } else {
                        this.resetSelect('#select_kabupaten', '-- Pilih Kabupaten / Kota --', false);
                    }

                } catch (err) {
                    console.error('Gagal memuat provinsi:', err);
                    const $prov = $('#select_provinsi');
                    $prov.empty().append(new Option('Gagal memuat data API', '', true, true)).trigger('change.select2');
                } finally {
                    this.showLoading('provinsi', false);
                }
            },

            async loadRegencies(provCode, preselectedKab = '') {
                this.showLoading('kabupaten', true);
                this.resetSelect('#select_kabupaten', 'Memuat Kabupaten/Kota...', true);
                this.resetSelect('#select_kecamatan', '-- Pilih Kab/Kota Dahulu --', true);
                this.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);

                try {
                    let regencies = await this.fetchJson(`regencies/${provCode}`, []);
                    this.regenciesData = regencies;

                    const $kab = $('#select_kabupaten');
                    $kab.empty();

                    const defaultOpt = new Option('-- Pilih Kabupaten / Kota --', '', true, !preselectedKab);
                    defaultOpt.setAttribute('data-code', '');
                    $kab.append(defaultOpt);

                    let matchedCode = '';
                    const normSavedKab = this.normalizeName(preselectedKab);

                    if (regencies && regencies.length > 0) {
                        regencies.forEach(r => {
                            const isSelected = normSavedKab && (
                                this.normalizeName(r.name) === normSavedKab || 
                                r.name.toLowerCase() === preselectedKab.toLowerCase()
                            );
                            if (isSelected) {
                                matchedCode = r.code;
                            }
                            const opt = new Option(r.name, r.name, false, isSelected);
                            opt.setAttribute('data-code', r.code);
                            $kab.append(opt);
                        });
                    }

                    if (preselectedKab && !matchedCode) {
                        const customOpt = new Option(`${preselectedKab} (Tersimpan)`, preselectedKab, false, true);
                        customOpt.setAttribute('data-code', '');
                        $kab.append(customOpt);
                    }

                    $kab.prop('disabled', false).trigger('change.select2');

                    if (matchedCode) {
                        await this.loadDistricts(matchedCode, this.savedKec);
                    }

                } catch (err) {
                    console.error('Gagal memuat regencies:', err);
                    this.resetSelect('#select_kabupaten', 'Gagal memuat Kab/Kota', false);
                } finally {
                    this.showLoading('kabupaten', false);
                }
            },

            async loadDistricts(regCode, preselectedKec = '') {
                this.showLoading('kecamatan', true);
                this.resetSelect('#select_kecamatan', 'Memuat Kecamatan...', true);
                this.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);

                try {
                    const districts = await this.fetchJson(`districts/${regCode}`, []);
                    this.districtsData = districts;

                    const $kec = $('#select_kecamatan');
                    $kec.empty();

                    const defaultOpt = new Option('-- Pilih Kecamatan --', '', true, !preselectedKec);
                    defaultOpt.setAttribute('data-code', '');
                    $kec.append(defaultOpt);

                    let matchedCode = '';
                    const normSavedKec = this.normalizeName(preselectedKec);

                    if (districts && districts.length > 0) {
                        districts.forEach(d => {
                            const isSelected = normSavedKec && (
                                this.normalizeName(d.name) === normSavedKec || 
                                d.name.toLowerCase() === preselectedKec.toLowerCase()
                            );
                            if (isSelected) {
                                matchedCode = d.code;
                            }
                            const opt = new Option(d.name, d.name, false, isSelected);
                            opt.setAttribute('data-code', d.code);
                            $kec.append(opt);
                        });
                    }

                    if (preselectedKec && !matchedCode) {
                        const customOpt = new Option(`${preselectedKec} (Tersimpan)`, preselectedKec, false, true);
                        customOpt.setAttribute('data-code', '');
                        $kec.append(customOpt);
                    }

                    $kec.prop('disabled', false).trigger('change.select2');

                    if (matchedCode) {
                        await this.loadVillages(matchedCode, this.savedKel);
                    }

                } catch (err) {
                    console.error('Gagal memuat districts:', err);
                    this.resetSelect('#select_kecamatan', 'Gagal memuat Kecamatan', false);
                } finally {
                    this.showLoading('kecamatan', false);
                }
            },

            async loadVillages(distCode, preselectedKel = '') {
                this.showLoading('kelurahan', true);
                this.resetSelect('#select_kelurahan', 'Memuat Kelurahan/Desa...', true);

                try {
                    const villages = await this.fetchJson(`villages/${distCode}`, []);
                    this.villagesData = villages;

                    const $kel = $('#select_kelurahan');
                    $kel.empty();

                    const defaultOpt = new Option('-- Pilih Kelurahan / Desa --', '', true, !preselectedKel);
                    defaultOpt.setAttribute('data-code', '');
                    $kel.append(defaultOpt);

                    let matchedCode = '';
                    const normSavedKel = this.normalizeName(preselectedKel);

                    if (villages && villages.length > 0) {
                        villages.forEach(v => {
                            const isSelected = normSavedKel && (
                                this.normalizeName(v.name) === normSavedKel || 
                                v.name.toLowerCase() === preselectedKel.toLowerCase()
                            );
                            if (isSelected) {
                                matchedCode = v.code;
                            }
                            const opt = new Option(v.name, v.name, false, isSelected);
                            opt.setAttribute('data-code', v.code);
                            $kel.append(opt);
                        });
                    }

                    if (preselectedKel && !matchedCode) {
                        const customOpt = new Option(`${preselectedKel} (Tersimpan)`, preselectedKel, false, true);
                        customOpt.setAttribute('data-code', '');
                        $kel.append(customOpt);
                    }

                    $kel.prop('disabled', false).trigger('change.select2');

                } catch (err) {
                    console.error('Gagal memuat villages:', err);
                    this.resetSelect('#select_kelurahan', 'Gagal memuat Kelurahan', false);
                } finally {
                    this.showLoading('kelurahan', false);
                }
            }
        };
    </script>
</body>

</html>

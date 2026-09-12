<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Primary Meta Tags -->
    <title>@hasSection('title')@yield('title') | Portal Pasien - Omah Terapi-KU @else Portal Pasien & Keluarga - Omah Terapi-KU @endif</title>
    <meta name="title" content="@hasSection('title')@yield('title') | Portal Pasien - Omah Terapi-KU @else Portal Pasien & Keluarga - Omah Terapi-KU @endif">
    <meta name="description" content="Portal Akses Mandiri Hasil Asesmen Denver II, GMFM, Skala Nyeri & Rekam Medis Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Stylesheets -->
    <link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/brand-theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
    <link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-dark: #1e40af;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-neutral: #f1f5f9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            background-color: var(--bg-neutral) !important;
            color: #334155;
        }

        .portal-patient-pill {
            background: #eff6ff;
            color: #1e40af;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #bfdbfe;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .portal-logout-btn {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .portal-logout-btn:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Sidebar Portal Styling */
        .deznav .metismenu > li.mm-active > a {
            background: rgba(37, 99, 235, 0.08) !important;
            color: #2563eb !important;
            font-weight: 700 !important;
            border-left: 4px solid #2563eb;
        }

        .deznav .metismenu > li > a i {
            color: #2563eb;
        }

        .deznav .metismenu li.nav-label {
            font-size: 11px;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #94a3b8;
            padding: 18px 24px 6px 24px;
            text-transform: uppercase;
        }

        .content-body {
            padding-top: 80px;
            min-height: calc(100vh - 60px);
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
            background: #ffffff;
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 16px 22px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e40af;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>

    @yield('style')
    @yield('css')
</head>

<body data-instant-allow-query-string>
    <div id="main-wrapper" class="show">
        <!-- Nav Header -->
        <div class="nav-header">
            <a href="{{ route('portal.dashboard') }}" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('images/header.png') }}" alt="Logo Omah Terapi-KU">
                <img class="brand-title" src="{{ asset('images/logo-text.png') }}" alt="Omah Terapi-KU">
            </a>

            <div class="nav-control" title="Toggle Menu">
                <div class="hamburger">
                    <i class="fa-solid fa-bars hamburger-icon-bars"></i>
                    <i class="fa-solid fa-arrow-right hamburger-icon-arrow"></i>
                </div>
            </div>
        </div>

        <!-- Header -->
        @include('portal.layout.header')

        <!-- Sidebar -->
        @include('portal.layout.sidebar')

        <!-- Content Body -->
        <div class="content-body">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        @include('portal.layout.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>
    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <script>
        @if(Session::has('sukses'))
            toastr.success("{{ Session::get('sukses') }}", "Berhasil", {timeOut: 4000, closeButton: true});
        @endif
        @if(Session::has('gagal'))
            toastr.error("{{ Session::get('gagal') }}", "Perhatian", {timeOut: 5000, closeButton: true});
        @endif

        // Konfirmasi Logout Portal Pasien
        function handlePortalLogout(logoutUrl) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Keluar Portal?',
                    html: 'Apakah Anda yakin ingin keluar dari sesi Portal Pasien <strong>{{ session("portal_pasien_nama", "Penerima Manfaat") }}</strong>?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Ya, Keluar',
                    cancelButtonText: '<i class="fa-solid fa-xmark mr-1"></i> Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.value || result.isConfirmed) {
                        window.location.href = logoutUrl || "{{ route('portal.logout') }}";
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari Portal Pasien?')) {
                    window.location.href = logoutUrl || "{{ route('portal.logout') }}";
                }
            }
        }

        $(document).on('click', '.btn-logout, a[href="{{ route('portal.logout') }}"]', function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr('href') || "{{ route('portal.logout') }}";
            handlePortalLogout(targetUrl);
        });
    </script>

    @yield('script')
    @yield('js')
    <!-- Instant.page: Hover Prefetching untuk Navigasi Instan Cepat -->
    <script src="{{ asset('js/instantpage.min.js') }}" type="module"></script>
</body>

</html>

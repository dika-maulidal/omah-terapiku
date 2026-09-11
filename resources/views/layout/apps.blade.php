<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Primary Meta Tags -->
    <title>@hasSection('title')@yield('title') | Omah Terapiku @else Omah Terapiku - Sistem Informasi Pelayanan Terapi Terpadu @endif</title>
    <meta name="title" content="@hasSection('title')@yield('title') | Omah Terapiku @else Omah Terapiku - Sistem Informasi Pelayanan Terapi Terpadu @endif">
    <meta name="description" content="@yield('meta_description', 'Sistem Informasi Manajemen Pelayanan Rekam Medis & Terapi Terpadu Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur.')">
    <meta name="keywords" content="Omah Terapiku, Terapi Anak, Rekam Medis Terapi, Fisioterapi, Terapi Okupasi, Terapi Wicara, Disabilitas, Dinas Sosial Jawa Timur">
    <meta name="author" content="Dinas Sosial Provinsi Jawa Timur - Omah Terapiku">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Omah Terapiku">
    <meta property="og:title" content="@hasSection('title')@yield('title') | Omah Terapiku @else Omah Terapiku - Sistem Informasi Pelayanan Terapi Terpadu @endif">
    <meta property="og:description" content="@yield('meta_description', 'Sistem Informasi Manajemen Pelayanan Rekam Medis & Terapi Terpadu Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur.')">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@hasSection('title')@yield('title') | Omah Terapiku @else Omah Terapiku - Sistem Informasi Pelayanan Terapi Terpadu @endif">
    <meta name="twitter:description" content="@yield('meta_description', 'Sistem Informasi Manajemen Pelayanan Rekam Medis & Terapi Terpadu Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur.')">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">

    <!-- Mobile & PWA Theme Colors -->
    <meta name="theme-color" content="#1e40af">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Omah Terapiku">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.png')}}">
    <link rel="apple-touch-icon" href="{{asset('images/logo.png')}}">

    <!-- Schema.org Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "Omah Terapiku",
        "applicationCategory": "HealthApplication",
        "operatingSystem": "All",
        "description": "Sistem Informasi Manajemen Pelayanan Rekam Medis & Terapi Terpadu Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur.",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "inLanguage": "id-ID"
    }
    </script>
	<link rel="stylesheet" href="{{asset('vendor/chartist/css/chartist.min.css')}}">
	<!-- Datatable -->
    <link href="{{asset('vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{asset('css/brand-theme.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/toastr/css/toastr.min.css')}}">
    <link href="{{asset('vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <!-- Marked.js Markdown Parser -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
    p {
        margin: 0;
    }
    </style>
    @yield('header')
    @yield('style')
    @yield('css')
    @stack('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body data-instant-allow-query-string>

    {{-- =========================================================================
         PRELOADER SPINNER (DI-NONAKTIFKAN UNTUK NAVIGASI CEPAT & RINGAN)
         Jika sewaktu-waktu ingin diaktifkan kembali, cukup hapus kurung kurawal komentar ini:
    <div id="preloader">
        <div class="loader-spinner-wrapper">
            <div class="brand-spinner"></div>
            <p class="loader-text">Memuat...</p>
        </div>
    </div>
    ========================================================================= --}}
    
    <div id="main-wrapper" class="show">

     
        <div class="nav-header">
            <a href="{{Route('dashboard')}}" class="brand-logo">
                <img class="logo-abbr" src="{{asset('images/header.png')}}" alt="Logo Omah Terapiku">
                <img class="brand-title" src="{{asset('images/logo-text.png')}}" alt="Omah Terapiku">
            </a>

            <div class="nav-control" title="Toggle Sidebar">
                <div class="hamburger">
                    <i class="fa-solid fa-bars hamburger-icon-bars"></i>
                    <i class="fa-solid fa-arrow-right hamburger-icon-arrow"></i>
                </div>
            </div>
        </div>

		<!--**********************************
            Header start
        ***********************************-->
        @include('layout.partial.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('layout.partial.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				@yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        @include('layout.partial.footer')
     

    </div>
    
    <!-- AI Asisten Klinis & Terapi Slide-Over Drawer -->
    @include('layout.partial.ai-assistant-modal')
 
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
	<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('vendor/select2/js/select2.full.min.js')}}"></script>
	<script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
	<script src="{{asset('js/deznav-init.js')}}"></script>

    <!-- Datatable -->
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/toastr/js/toastr.min.js')}}"></script>
    <script src="{{asset('vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    

	<script>
        // Mobile Sidebar Close Events
        $(document).on('click', '.mobile-sidebar-backdrop', function() {
            $('#main-wrapper').removeClass('menu-toggle');
            $('.hamburger').removeClass('is-active');
        });

        $(document).on('click', '.deznav .metismenu a:not(.has-arrow)', function() {
            if ($(window).width() < 768) {
                $('#main-wrapper').removeClass('menu-toggle');
                $('.hamburger').removeClass('is-active');
            }
        });

        @if(Session::has('sukses'))
            toastr.success("{{Session::get('sukses')}}", "Sukses",{timeOut: 5000})
        @endif
        @if(Session::has('gagal'))
            toastr.error("{{Session::get('gagal')}}", "Gagal",{timeOut: 5000})
        @endif

        // =========================================================================
        // Sistem Notifikasi Real-time & Poller (Terapis / Dokter / Pendaftaran)
        // =========================================================================
        var user_id = "{{ auth()->check() ? auth()->user()->id : '' }}";
        var role = "{{ auth()->check() ? auth()->user()->role_display() : '' }}";
        var lastUnreadCount = parseInt("{{ auth()->check() ? auth()->user()->unreadnotifications->count() : 0 }}") || 0;

        function playNotificationChime() {
            try {
                var AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                var ctx = new AudioContext();
                var now = ctx.currentTime;

                var osc1 = ctx.createOscillator();
                var gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(587.33, now); // D5
                gain1.gain.setValueAtTime(0.12, now);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.3);
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(now);
                osc1.stop(now + 0.3);

                var osc2 = ctx.createOscillator();
                var gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(880, now + 0.12); // A5
                gain2.gain.setValueAtTime(0.18, now + 0.12);
                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.55);
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(now + 0.12);
                osc2.stop(now + 0.55);
            } catch (e) {
                // Audio context may be restricted by browser policy before user interaction
            }
        }

        function renderNotificationItems(items, unreadCount) {
            var $countBadge = $('.notif-badge-indicator');
            var $countText = $('.notif-count');
            var $list = $('#notificationTimelineList');

            if (unreadCount > 0) {
                $countBadge.removeClass('d-none');
                $countText.text(unreadCount);
            } else {
                $countBadge.addClass('d-none');
                $countText.text('0');
            }

            if (!items || items.length === 0) {
                $list.html(`
                    <li class="text-center py-4 text-muted empty-notif-state">
                        <div class="mb-2" style="width: 44px; height: 44px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 18px;">
                            <i class="fa-regular fa-bell-slash"></i>
                        </div>
                        <p class="fs-12 mb-0 font-w600 text-secondary">Tidak ada notifikasi baru</p>
                        <small class="text-muted" style="font-size: 11px;">Notifikasi penugasan pasien akan muncul di sini</small>
                    </li>
                `);
                return;
            }

            var html = '';
            items.forEach(function(notif) {
                html += `
                    <li class="p-2 mb-1 notif-item" style="border-radius: 8px; border-bottom: 1px solid #f1f5f9; background: #ffffff; transition: background 0.2s ease;">
                        <div class="d-flex align-items-start">
                            <div class="mr-2.5 mt-1" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 14px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                            <div class="media-body" style="font-size: 12px;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <strong class="text-dark font-w700" style="font-size: 12.5px;">${notif.nama_pasien}</strong>
                                    <span class="badge badge-primary light font-w600" style="font-size: 10px; padding: 1px 6px;">${notif.layanan_terapi}</span>
                                </div>
                                <p class="mb-1 text-secondary" style="font-size: 11.5px; line-height: 1.35; color: #475569 !important;">
                                    ${notif.message}
                                </p>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <small class="text-muted font-w500" style="font-size: 10.5px;">
                                        <i class="fa-regular fa-clock mr-1"></i>${notif.created_at}
                                    </small>
                                    <a href="${notif.read_url}" class="btn btn-primary btn-xs font-w600" style="padding: 2px 8px; font-size: 11px; border-radius: 5px; background: #2563eb;">
                                        <i class="fa-solid fa-arrow-right mr-1"></i> Buka
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                `;
            });
            $list.html(html);
        }

        window.markAllNotificationsRead = function(e) {
            if (e) e.stopPropagation();
            $.ajax({
                url: "{{ route('notifications.markAllRead') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    lastUnreadCount = 0;
                    renderNotificationItems([], 0);
                    if (typeof toastr !== 'undefined') {
                        toastr.success("Semua notifikasi ditandai telah dibaca", "Notifikasi", { timeOut: 3000 });
                    }
                }
            });
        };

        function fetchUnreadNotifications() {
            if (!user_id) return;
            $.ajax({
                url: "{{ route('notifications.unreadJson') }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res && res.success) {
                        if (res.unread_count > lastUnreadCount) {
                            playNotificationChime();
                            if (typeof toastr !== 'undefined' && res.notifications && res.notifications.length > 0) {
                                var latest = res.notifications[0];
                                toastr.info(
                                    `<div style="font-size:12.5px;"><strong>${latest.nama_pasien}</strong><br><small>${latest.message}</small></div>`,
                                    "🔔 Pasien Baru Ditugaskan",
                                    { timeOut: 7500, closeButton: true, escapeHtml: false }
                                );
                            }
                        }
                        lastUnreadCount = res.unread_count;
                        renderNotificationItems(res.notifications, res.unread_count);
                    }
                }
            });
        }

        // Jalankan polling setiap 25 detik sebagai failover real-time yang andal
        if (user_id) {
            setInterval(fetchUnreadNotifications, 25000);
        }

        // Pusher Real-time Subscriber
        try {
            if (typeof Pusher !== 'undefined' && user_id) {
                var pusher = new Pusher('d0f5c330385c88c7da90', {
                    cluster: 'ap1'
                });

                var channel = pusher.subscribe('status-rekam-updated-' + user_id);
                channel.bind('App\\Events\\StatusRekamUpdate', function(data) {
                    fetchUnreadNotifications();
                });
            }
        } catch (err) {
            console.warn('Pusher initialization:', err);
        }
        // =========================================================================
        // Konfirmasi Logout dengan SweetAlert2 (Popup Ya / Tidak)
        // =========================================================================
        function handleLogoutConfirm(logoutUrl) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    html: 'Apakah Anda yakin ingin keluar dari akun <strong>{{ auth()->user() ? auth()->user()->name : "Omah Terapi-KU" }}</strong>?',
                    type: 'warning',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Ya, Keluar',
                    cancelButtonText: '<i class="fa-solid fa-xmark mr-1"></i> Tidak / Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.value || result.isConfirmed) {
                        window.location.href = logoutUrl || "{{ Route('logout') }}";
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari sistem Omah Terapi-KU?')) {
                    window.location.href = logoutUrl || "{{ Route('logout') }}";
                }
            }
        }

        $(document).on('click', '.btn-logout, a.text-logout, a[href="{{ Route('logout') }}"], a[href$="/logout"]', function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr('href') || "{{ Route('logout') }}";
            handleLogoutConfirm(targetUrl);
        });
	</script>
    @yield('script')
    @stack('scripts')
    <!-- Instant.page: Hover Prefetching untuk Navigasi Instan Cepat -->
    <script src="{{asset('js/instantpage.min.js')}}" type="module"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>500 - Terjadi Kesalahan Sistem | Omah Terapiku</title>
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.png')}}">
    
    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ot-navy: #3574b5;
            --ot-navy-dark: #295d96;
            --ot-cyan: #38A5DB;
            --ot-yellow: #F3B329;
            --bg-gray: #eef2f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-gray);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #1e293b;
        }

        .error-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
            width: 100%;
            max-width: 520px;
            padding: 44px 36px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
        }

        .logo-wrap {
            margin-bottom: 20px;
        }

        .logo-img {
            max-width: 76px;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(53, 116, 181, 0.2));
        }

        .system-subtitle {
            font-size: 13px;
            font-weight: 700;
            color: var(--ot-navy);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 8px;
            margin-bottom: 24px;
        }

        .error-code-badge {
            display: inline-block;
            font-size: 72px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px;
            letter-spacing: -2px;
        }

        .error-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .error-description {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 32px;
            padding: 0 10px;
        }

        .btn-group-action {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary-action {
            background: linear-gradient(135deg, #3574b5 0%, #295d96 100%);
            color: #ffffff !important;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(53, 116, 181, 0.28);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .btn-primary-action:hover {
            background: linear-gradient(135deg, #295d96 0%, #1e4673 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(53, 116, 181, 0.38);
        }

        .btn-secondary-action {
            background: #f8fafc;
            color: #475569 !important;
            border: 1px solid #cbd5e1;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-secondary-action:hover {
            background: #f1f5f9;
            color: #0f172a !important;
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        .error-footer {
            margin-top: 36px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
            font-size: 12px;
            color: #94a3b8;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @media (max-width: 480px) {
            .error-card {
                padding: 32px 20px 24px;
            }

            .error-code-badge {
                font-size: 60px;
            }

            .error-title {
                font-size: 18px;
            }

            .btn-group-action {
                flex-direction: column;
            }

            .btn-primary-action,
            .btn-secondary-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="error-card">
        <!-- Logo -->
        <div class="logo-wrap">
            <img src="{{asset('images/logo-blue.png')}}" alt="Logo Omah Terapiku" class="logo-img" onerror="this.onerror=null; this.src='{{asset('images/logo.png')}}';">
            <p class="system-subtitle">Sistem Informasi Rekam Medis Omah Terapiku</p>
        </div>

        <!-- 500 Heading -->
        <div class="error-code-badge">500</div>
        <h1 class="error-title">Terjadi Gangguan pada Server</h1>
        <p class="error-description">
            Mohon maaf, sistem sedang mengalami kendala teknis internal. Tim kami sedang menindaklanjuti hal ini. Silakan coba muat ulang beberapa saat lagi.
        </p>

        <!-- Actions -->
        <div class="btn-group-action">
            @if(auth()->check())
                <a href="{{ route('dashboard') }}" class="btn-primary-action">
                    <i class="fa-solid fa-house"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            @else
                <a href="{{ url('/') }}" class="btn-primary-action">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Halaman Login</span>
                </a>
            @endif

            <button type="button" onclick="window.location.reload()" class="btn-secondary-action">
                <i class="fa-solid fa-rotate-right"></i>
                <span>Muat Ulang Halaman</span>
            </button>
        </div>

        <!-- Footer -->
        <div class="error-footer">
            <p>&copy; {{ date('Y') }} <strong>Omah Terapiku</strong> &bull; Dinas Sosial Provinsi Jawa Timur</p>
        </div>
    </div>
</body>

</html>

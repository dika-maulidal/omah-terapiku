<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Latihan Rumahan (Home Program) - {{ $pasien->nama }} (RM# {{ $pasien->no_rm }})</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* Format Dokumen Rekam Medis Standar Kedinasan (Monokrom / Hitam Putih Standar Reference PDF) */
        @page {
            size: A4 portrait;
            margin: 8mm 10mm 10mm 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body, table, input, select, textarea, button, .print-container, .print-toolbar {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Enforce Font Awesome icons font-family */
        .fa, .fas, .far, .fab, .fa-solid, .fa-regular, .fa-brands, [class^="fa-"], [class*=" fa-"] {
            font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands', 'FontAwesome' !important;
        }

        body {
            background-color: #e2e8f0;
            color: #000000;
            font-size: 8.5pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .print-toolbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #cbd5e1;
            padding: 8px 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .print-container {
            max-width: 820px;
            margin: 15px auto 35px auto;
            background: #ffffff;
            padding: 22px 28px;
            border-radius: 4px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
            color: #000000;
        }

        /* Kop Surat Resmi */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 2px;
        }
        .kop-table td {
            border: none !important;
            padding: 0 4px;
            vertical-align: middle;
        }
        .kop-logo {
            max-width: 68px;
            max-height: 68px;
            object-fit: contain;
        }
        .kop-instansi {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #000000;
            letter-spacing: 0.3px;
            line-height: 1.2;
        }
        .kop-dinas {
            font-size: 13pt;
            font-weight: 800;
            text-transform: uppercase;
            color: #000000;
            letter-spacing: 0.4px;
            line-height: 1.2;
        }
        .kop-unit {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #000000;
            line-height: 1.2;
        }
        .kop-sub {
            font-size: 8pt;
            color: #000000;
            line-height: 1.25;
            margin-top: 1px;
        }
        .kop-line {
            border-top: 2px solid #000000;
            border-bottom: 1px solid #000000;
            height: 3px;
            margin-top: 4px;
            margin-bottom: 8px;
        }

        /* Header RM Box Table (Matching Reference PDF) */
        .header-box-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .header-box-table td {
            border: 1.5px solid #000000 !important;
        }

        /* Section Title (Hitam Putih / Formal) */
        .section-title {
            background-color: #efefef !important;
            color: #000000;
            font-weight: bold;
            font-size: 8.5pt;
            padding: 3px 6px;
            margin-top: 8px;
            margin-bottom: 4px;
            border: 1px solid #000000;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            page-break-after: avoid !important;
            break-after: avoid !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        /* Tabel Penilaian / Konten Klinis */
        .table-assessment {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 8.5pt;
        }
        .table-assessment th, 
        .table-assessment td {
            border: 1px solid #000000 !important;
            padding: 3px 5px;
            color: #000000;
            vertical-align: middle;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .table-assessment th {
            background-color: #e8e8e8 !important;
            font-weight: bold;
            text-align: left;
            color: #000000;
        }
        .table-assessment tr {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        thead {
            display: table-header-group !important;
        }
        tfoot {
            display: table-footer-group !important;
        }

        /* Box Konten & Card */
        .box-content-card {
            border: 1px solid #000000;
            background: #ffffff;
            margin-bottom: 8px;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .box-content-header {
            background-color: #f1f1f1;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 8.5pt;
            text-transform: uppercase;
            border-bottom: 1px solid #000000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .box-content-body {
            padding: 8px 10px;
            font-size: 8.5pt;
            line-height: 1.45;
            color: #000000;
        }

        /* Tips & Anjuran Box */
        .box-tips {
            border: 1px solid #000000;
            background: #fbfbfb;
            padding: 6px 10px;
            margin-bottom: 8px;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            font-size: 8pt;
            line-height: 1.35;
        }
        .box-tips-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
            font-size: 8.5pt;
            color: #000000;
        }

        /* Tanda Tangan */
        .sign-area {
            width: 100%;
            margin-top: 10px;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            font-size: 8.5pt;
        }
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .sign-table td {
            border: none !important;
            padding: 2px 6px;
            vertical-align: top;
            text-align: center;
        }

        /* Anti-potong / Anti-crop Classes untuk Print & PDF */
        .no-break, .print-block, .sign-area, .kop-table, .header-box-table, .box-content-card, .box-tips {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 8.5pt;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .print-toolbar {
                display: none !important;
            }
            .no-print {
                display: none !important;
            }
            .table-assessment th, .box-content-header {
                background-color: #e8e8e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .section-title {
                background-color: #efefef !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .box-tips {
                background-color: #fbfbfb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

@php
    $pathLogoOmah = public_path('images/logo.png');
    if (!file_exists($pathLogoOmah)) {
        $pathLogoOmah = public_path('images/logo-blue.png');
    }
    $logoOmahBase64 = file_exists($pathLogoOmah) 
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($pathLogoOmah)) 
        : asset('images/logo.png');

    $pathLogoDinsos = public_path('images/logo-dinsos.png');
    $logoDinsosBase64 = file_exists($pathLogoDinsos) 
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($pathLogoDinsos)) 
        : asset('images/logo-dinsos.png');

    // Safe Date Helper (Anti-Crash Carbon Parse)
    $safeFormatDate = function($date, $default = '-') {
        if (empty($date)) return $default;
        try {
            return \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            return (string)$date;
        }
    };

    $safeAge = function($date) {
        if (empty($date)) return '-';
        try {
            return \Carbon\Carbon::parse($date)->age . ' Tahun';
        } catch (\Throwable $e) {
            return '-';
        }
    };

    $usiaTahun = $safeAge($pasien->tgl_lahir);
    $tglSesiFormatted = $safeFormatDate($rekam->tgl_rekam, date('d F Y'));
    $tglCetak = \Carbon\Carbon::now()->translatedFormat('d F Y');
@endphp

<!-- Sticky Action Toolbar (Hanya Tampil di Layar) -->
<div class="print-toolbar no-print">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between" style="max-width: 820px; gap: 8px; padding: 0;">
        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            <span class="badge badge-dark" style="font-size: 11px; padding: 4px 8px; background: #0f172a; color: #fff; font-weight: bold;">
                <i class="fa-solid fa-house-user mr-1"></i> HOME PROGRAM
            </span>
            <strong style="color: #0f172a; font-size: 12.5px;">{{ $pasien->nama }}</strong>
            <span class="text-muted" style="font-size: 11.5px;">(RM# {{ $pasien->no_rm }} &bull; Sesi: {{ $tglSesiFormatted }})</span>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            <button type="button" onclick="triggerPrintDialog()" class="btn btn-sm btn-dark" style="padding: 5px 12px; font-size: 11.5px; font-weight: bold; border-radius: 4px; background: #0f172a; border: none; color: #fff;">
                <i class="fa-solid fa-print mr-1"></i> Cetak / Simpan PDF
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-success text-white" style="padding: 5px 12px; font-size: 11.5px; font-weight: bold; border-radius: 4px; background: #16a34a; border: none;">
                <i class="fa-solid fa-download mr-1"></i> Unduh PDF
            </button>
            <a href="{{ route('rekam.soap.print', $rekam->id) }}" class="btn btn-sm btn-primary text-white" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; background: #2563eb; border: none;" title="Cetak Lembar SOAP Lengkap">
                <i class="fa-solid fa-file-medical mr-1"></i> SOAP
            </a>
            @if($rekam->assessment)
                <a href="{{ route('rekam.assessment.print', $rekam->id) }}" class="btn btn-sm btn-info text-white" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; background: #0284c7; border: none;" title="Cetak Lembar Asesmen">
                    <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                </a>
            @endif
            <a href="{{ route('rekam.detail', $pasien->id) }}" class="btn btn-sm btn-light border" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; color: #334155;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="print-container" id="print-area">
    
    <!-- =========================================================================
         KOP SURAT RESMI PEMERINTAHAN (KIRI: LOGO OMAH TERAPI, KANAN: LOGO DINSOS)
         ========================================================================= -->
    <table class="kop-table">
        <tr>
            <!-- Kiri: Logo Omah Terapi -->
            <td style="width: 85px; text-align: left; vertical-align: middle;">
                <img src="{{ $logoOmahBase64 }}" alt="Logo Omah Terapi" class="kop-logo">
            </td>
            
            <!-- Tengah: Teks Kop Surat Dinas Resmi -->
            <td style="text-align: center; vertical-align: middle; padding: 0 8px;">
                <div class="kop-instansi">PEMERINTAH PROVINSI JAWA TIMUR</div>
                <div class="kop-dinas">DINAS SOSIAL</div>
                <div class="kop-unit">OMAH TERAPI-KU JAWA TIMUR</div>
                <div class="kop-sub">
                    Pusat Pelayanan Terapi & Rehabilitasi Disabilitas &bull; Unit Pelayanan: {{ $rekam->poli ?: ($rekam->upt_lokasi ?: 'Jawa Timur') }}
                </div>
                @php
                    $uptContact = isset($upt) && $upt && $upt->no_telp ? $upt->no_telp : null;
                    if (!$uptContact) {
                        $pLoc = $rekam->upt_lokasi ?: ($rekam->poli ?: '');
                        if ($pLoc) {
                            $foundPoli = \App\Models\Poli::where('nama', $pLoc)->orWhere('nama', 'LIKE', "%{$pLoc}%")->first();
                            $uptContact = $foundPoli->no_telp ?? null;
                        }
                    }
                @endphp
                <div class="kop-sub" style="font-size: 8pt; color: #222;">
                    Layanan: {{ $rekam->layanan_terapi ?: 'Fisioterapi & Terapi Terpadu' }}@if($uptContact) &bull; No. Handphone / Telp UPT: {{ $uptContact }}@endif
                </div>
            </td>
            
            <!-- Kanan: Logo Dinsos Jawa Timur -->
            <td style="width: 85px; text-align: right; vertical-align: middle;">
                <img src="{{ $logoDinsosBase64 }}" alt="Logo Dinsos Jawa Timur" class="kop-logo">
            </td>
        </tr>
    </table>

    <!-- Garis Ganda Pembatas Kop Surat Resmi -->
    <div class="kop-line"></div>

    <!-- Header Box Judul & Nomor Rekam Medis (Format Sesuai Reference PDF) -->
    <table class="table-assessment header-box-table" style="width: 100%; border-collapse: collapse; margin-bottom: 6px;">
        <tr>
            <td style="width: 58%; text-align: center; vertical-align: middle; border: 1.5px solid #000000 !important; padding: 6px 8px; background: #ffffff;">
                <div style="font-size: 11.5pt; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">PANDUAN LATIHAN RUMAHAN</div>
                <div style="font-size: 10pt; font-weight: bold; text-transform: uppercase; margin-top: 1px;">(HOME PROGRAM &amp; STIMULASI MANDIRI)</div>
                <div style="font-size: 8pt; color: #333333; margin-top: 2px;">OMAH TERAPI-KU DINAS SOSIAL PROVINSI JAWA TIMUR</div>
            </td>
            <td style="width: 42%; border: 1.5px solid #000000 !important; padding: 0; vertical-align: top; background: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-size: 8.5pt;">
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold; width: 44%;">NOMOR RM</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: 800; font-size: 9.5pt; letter-spacing: 0.5px;">: {{ $pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold;">Tgl. Sesi / Program</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px;">: {{ $tglSesiFormatted }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; padding: 3px 6px; font-weight: bold;">Terapis / Petugas</td>
                        <td style="border: none !important; padding: 3px 6px;">: {{ $rekam->dokter->nama ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- =========================================================================
         IDENTITAS PENERIMA MANFAAT (FORMAT TABEL FORMAL DINAS)
         ========================================================================= -->
    <table class="table-assessment" style="margin-bottom: 8px; font-size: 8.5pt;">
        <thead>
            <tr>
                <th colspan="4" style="background-color: #e8e8e8; font-size: 9pt; font-weight: bold; text-transform: uppercase; border: 1px solid #000000 !important; padding: 3px 6px;">
                    IDENTITAS PENERIMA MANFAAT (PASIEN)
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 18%; font-weight: bold; border: 1px solid #000000 !important;">Nama Lengkap</td>
                <td style="width: 32%; border: 1px solid #000000 !important;">: {{ $pasien->nama }}</td>
                <td style="width: 18%; font-weight: bold; border: 1px solid #000000 !important;">Orang Tua / Wali</td>
                <td style="width: 32%; border: 1px solid #000000 !important;">: {{ $pasien->nama_wali ? $pasien->nama_wali . ' (' . ($pasien->hubungan_wali ?: 'Wali') . ')' : ($pasien->nama_ortu ?: '-') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Nomor NIK / KIS</td>
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->nik ?: '-' }}</td>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Ragam Disabilitas</td>
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada' ? $pasien->jenis_disabilitas : 'Non-Disabilitas' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">TTL / Usia</td>
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $safeFormatDate($pasien->tgl_lahir) }} ({{ $safeAge($pasien->tgl_lahir) }})</td>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">No. Kontak / HP</td>
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->no_hp ?: '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Unit Layanan UPT</td>
                <td style="border: 1px solid #000000 !important;">: {{ $rekam->upt_lokasi ?: ($rekam->poli ?: 'Omah Terapi-KU') }}</td>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Jenis Kelamin</td>
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->jk == 'L' ? 'Laki-laki' : ($pasien->jk == 'P' ? 'Perempuan' : ($pasien->jk ?: '-')) }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Alamat Domisili</td>
                <td colspan="3" style="border: 1px solid #000000 !important;">: {{ $pasien->alamat ?: '-' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- =========================================================================
         SECTION I: INSTRUKSI & RENCANA LATIHAN MANDIRI DI RUMAH (HOME EXERCISE)
         ========================================================================= -->
    <div class="section-title">
        I. INSTRUKSI &amp; RENCANA LATIHAN MANDIRI DI RUMAH (HOME EXERCISE PROGRAM)
    </div>

    <div class="box-content-card no-break">
        <div class="box-content-header">
            <div>
                <strong>PETUNJUK LATIHAN &amp; STIMULASI DARI TERAPIS</strong>
            </div>
            <span style="font-size: 8pt; font-weight: normal; text-transform: none; color: #333;">Diterapkan oleh Keluarga / Orang Tua</span>
        </div>
        <div class="box-content-body">
            @if(!empty($rekam->latihan_rumahan))
                <div style="white-space: pre-line; font-size: 8.5pt; color: #000000;">{{ $rekam->latihan_rumahan }}</div>
            @else
                <div style="padding: 10px; text-align: center; color: #444;">
                    <div style="font-weight: bold; margin-bottom: 2px;">Belum ada rincian latihan khusus tertulis pada sesi ini.</div>
                    <div style="font-size: 8pt; color: #666;">Disarankan untuk melanjutkan rutinitas stimulasi mandiri, peregangan lembut, dan menjaga postur duduk/berbaring yang baik sesuai petunjuk lisan terapis.</div>
                </div>
            @endif
        </div>
    </div>

    <!-- =========================================================================
         SECTION II: RINGKASAN INTERVENSI / TINDAKAN SESI KLINIS (JIKA ADA)
         ========================================================================= -->
    @if(!empty($rekam->tindakan) || !empty($rekam->anamnesa) || !empty($rekam->diagnosa))
        <div class="section-title">
            II. RINGKASAN TINDAKAN &amp; EVALUASI SESI KLINIS DI UPT (REFERENSI ORANG TUA)
        </div>
        
        <table class="table-assessment no-break" style="margin-bottom: 8px;">
            @if(!empty($rekam->diagnosa))
                <tr>
                    <td style="width: 25%; font-weight: bold; background-color: #f8f8f8;">Diagnosa / Problem Terapi</td>
                    <td style="width: 75%;">{{ $rekam->diagnosa }}</td>
                </tr>
            @endif
            @if(!empty($rekam->anamnesa))
                <tr>
                    <td style="font-weight: bold; background-color: #f8f8f8;">Keluhan / Kondisi Awal Sesi</td>
                    <td>{{ $rekam->anamnesa }}</td>
                </tr>
            @endif
            @if(!empty($rekam->tindakan))
                <tr>
                    <td style="font-weight: bold; background-color: #f8f8f8;">Tindakan &amp; Latihan di Klinik</td>
                    <td style="white-space: pre-line;">{{ $rekam->tindakan }}</td>
                </tr>
            @endif
        </table>
    @endif

    <!-- =========================================================================
         SECTION III: PANDUAN & ANJURAN PENTING BAGI KELUARGA / ORANG TUA WALI
         ========================================================================= -->
    <div class="section-title">
        @if(!empty($rekam->tindakan) || !empty($rekam->anamnesa) || !empty($rekam->diagnosa)) III. @else II. @endif PANDUAN, PETUNJUK &amp; ANJURAN PENTING BAGI KELUARGA / ORANG TUA WALI
    </div>

    <div class="box-tips no-break">
        <div class="box-tips-title">
            PRINSIP UTAMA PELAKSANAAN HOME PROGRAM:
        </div>
        <table style="width: 100%; border-collapse: collapse; font-size: 8pt; line-height: 1.35;">
            <tr>
                <td style="width: 24px; vertical-align: top; font-weight: bold; padding: 2px 0;">1.</td>
                <td style="vertical-align: top; padding: 2px 0;">
                    <strong>Jadwal &amp; Frekuensi Teratur:</strong> Lakukan latihan secara rutin 1–2 kali sehari dengan durasi singkat (15–30 menit) sesuai daya tahan anak agar tidak menimbulkan kelelahan.
                </td>
            </tr>
            <tr>
                <td style="width: 24px; vertical-align: top; font-weight: bold; padding: 2px 0;">2.</td>
                <td style="vertical-align: top; padding: 2px 0;">
                    <strong>Suasana Menyenangkan &amp; Positif:</strong> Ciptakan suasana latihan yang santai melalui permainan, gunakan mainan favorit, dan selalu berikan pujian/afirmasi positif atas setiap pencapaian anak.
                </td>
            </tr>
            <tr>
                <td style="width: 24px; vertical-align: top; font-weight: bold; padding: 2px 0;">3.</td>
                <td style="vertical-align: top; padding: 2px 0;">
                    <strong>Observasi Respon &amp; Keamanan:</strong> Jangan memaksakan gerakan bila anak rewel berlebih atau kesakitan. Pastikan posisi tubuh aman, stabil, dan lingkungan bebas dari bahaya benturan.
                </td>
            </tr>
            <tr>
                <td style="width: 24px; vertical-align: top; font-weight: bold; padding: 2px 0;">4.</td>
                <td style="vertical-align: top; padding: 2px 0;">
                    <strong>Pencatatan Kemajuan &amp; Konsultasi:</strong> Catat kemajuan motorik/perilaku baru maupun kendala yang dirasakan di rumah untuk didiskusikan dengan terapis pada sesi kunjungan berikutnya.
                </td>
            </tr>
        </table>
    </div>

    <!-- =========================================================================
         AREA TANDA TANGAN & KOMITMEN PENDAMPINGAN KELUARGA
         ========================================================================= -->
    <div class="sign-area no-break" style="margin-top: 14px;">
        <table class="sign-table">
            <tr>
                <td style="width: 48%; text-align: center; vertical-align: top;">
                    Diterima &amp; Akan Diterapkan di Rumah,<br>
                    <strong>Orang Tua / Wali Pendamping</strong>
                    <div style="height: 55px;"></div>
                    <strong style="text-decoration: underline;">( {{ $pasien->nama_wali ? $pasien->nama_wali : ($pasien->nama_ortu ?: '................................................') }} )</strong><br>
                    <small style="font-size: 8pt; color: #333;">Orang Tua / Wali Penerima Manfaat</small>
                </td>
                <td style="width: 4%;"></td>
                <td style="width: 48%; text-align: center; vertical-align: top;">
                    Jawa Timur, {{ $tglSesiFormatted }}<br>
                    <strong>Terapis Pembimbing / Pemeriksa</strong>
                    <div style="height: 55px;"></div>
                    <strong style="text-decoration: underline;">( {{ $rekam->dokter->nama ?? 'Terapis Omah Terapi' }} )</strong><br>
                    <small style="font-size: 8pt; color: #333;">NIP / STR: {{ $rekam->dokter->user->nip ?? ($rekam->dokter->nip ?? '-') }}</small>
                </td>
            </tr>
        </table>
    </div>

</div>

<script>
function triggerPrintDialog() {
    window.print();
}

function downloadPDF() {
    var element = document.getElementById('print-area');
    var btn = document.getElementById('btnDownloadPdf');
    var origHtml = btn ? btn.innerHTML : '';
    
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Mengunduh PDF...';
    }

    var cleanName = "{{ preg_replace('/[^a-zA-Z0-9_-]/', '_', $pasien->nama) }}";
    var cleanNoRm = "{{ preg_replace('/[^a-zA-Z0-9_-]/', '_', $pasien->no_rm) }}";
    var cleanDate = "{{ $rekam->tgl_rekam ?: date('Y-m-d') }}";
    var opt = {
        margin:       [8, 10, 10, 10],
        filename:     'Home_Program_' + cleanNoRm + '_' + cleanName + '_' + cleanDate + '.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { 
            scale: 2, 
            useCORS: true, 
            logging: false,
            letterRendering: true,
            scrollY: 0
        },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak:    { 
            mode: ['avoid-all', 'css', 'legacy'],
            avoid: ['tr', 'tbody tr', '.section-title', '.table-assessment', '.box-content-card', '.box-tips', '.sign-area', '.no-break', '.print-block', '.header-box-table']
        }
    };

    html2pdf().set(opt).from(element).save().then(function() {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Terunduh!';
            setTimeout(function() {
                btn.innerHTML = origHtml;
            }, 3000);
        }
    }).catch(function(err) {
        console.error('PDF generation error:', err);
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = origHtml;
        }
        window.print();
    });
}

// Auto-trigger on page load
window.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);
    var downloadMode = urlParams.get('download');
    var noPrint = urlParams.get('noprint');
    var autoPrint = urlParams.get('auto_print');

    if (downloadMode === 'pdf' || downloadMode === '1') {
        setTimeout(function() {
            downloadPDF();
        }, 600);
    } else if (autoPrint === '1') {
        setTimeout(function() {
            triggerPrintDialog();
        }, 500);
    }
});
</script>

</body>
</html>

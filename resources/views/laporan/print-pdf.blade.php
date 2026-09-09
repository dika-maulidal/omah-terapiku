<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Eksekutif & Rekapitulasi Statistik Omah Terapi-KU - {{ $meta['periode_text'] }}</title>
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

        /* Header Box Table (Matching Reference PDF) */
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

        /* Tabel Data Standar Kedinasan */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 8.5pt;
        }
        .table-data th, 
        .table-data td {
            border: 1px solid #000000 !important;
            padding: 3px 5px;
            color: #000000;
            vertical-align: middle;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .table-data th {
            background-color: #e8e8e8 !important;
            font-weight: bold;
            text-align: left;
            color: #000000;
            text-transform: uppercase;
            font-size: 8pt;
        }
        .table-data tr {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        thead {
            display: table-header-group !important;
        }
        tfoot {
            display: table-footer-group !important;
        }

        /* KPI Matrix Cards */
        .kpi-matrix {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .kpi-matrix td {
            border: 1px solid #000000;
            padding: 5px 6px;
            text-align: center;
            vertical-align: middle;
            background: #ffffff;
        }
        .kpi-matrix-val {
            font-size: 13pt;
            font-weight: 800;
            color: #000000;
            display: block;
            line-height: 1.2;
        }
        .kpi-matrix-lbl {
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #1e293b;
            display: block;
            margin-top: 1px;
        }

        /* Tanda Tangan */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            font-size: 8.5pt;
        }
        .ttd-table td {
            border: none !important;
            padding: 2px 8px;
            text-align: center;
            vertical-align: top;
        }

        /* Anti-potong / Anti-crop Classes untuk Print & PDF */
        .no-break, .print-block, .ttd-table, .kop-table, .header-box-table, .kpi-matrix {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 8.5pt !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            .print-toolbar {
                display: none !important;
            }
            .no-print {
                display: none !important;
            }
            .table-data th {
                background-color: #e8e8e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .section-title {
                background-color: #efefef !important;
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
    if (!file_exists($pathLogoDinsos)) {
        $pathLogoDinsos = public_path('images/dinsos.png');
    }
    $logoDinsosBase64 = file_exists($pathLogoDinsos) 
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($pathLogoDinsos)) 
        : asset('images/logo-dinsos.png');
@endphp

<!-- TOOLBAR ATAS (HANYA MUNCUL DI LAYAR BROWSER) -->
<div class="print-toolbar no-print">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between" style="max-width: 820px; gap: 8px; padding: 0;">
        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            <span class="badge badge-dark" style="font-size: 11px; padding: 4px 8px; background: #0f172a; color: #fff; font-weight: bold;">
                <i class="fa-solid fa-chart-pie mr-1"></i> LAPORAN EKSEKUTIF
            </span>
            <strong style="color: #0f172a; font-size: 12.5px;">Dinas Sosial Provinsi Jawa Timur</strong>
            <span class="text-muted" style="font-size: 11.5px;">&bull; Periode: {{ $meta['periode_text'] }}</span>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            <button type="button" class="btn btn-sm btn-dark font-w700" onclick="triggerPrintDialog()" style="padding: 5px 12px; font-size: 11.5px; border-radius: 4px; background: #0f172a; border: none; color: #fff;">
                <i class="fa-solid fa-print mr-1"></i> Cetak / Simpan PDF
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-primary font-w700 text-white" style="padding: 5px 12px; font-size: 11.5px; border-radius: 4px; background: #2563eb; border: none;">
                <i class="fa-solid fa-download mr-1"></i> Unduh PDF
            </button>
            <a href="{{ route('laporan.eksekutif', request()->all()) }}" class="btn btn-sm btn-light border font-w600" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; color: #334155;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<div class="print-container" id="print-area">
    
    <!-- =========================================================================
         KOP SURAT RESMI PEMERINTAH PROVINSI JAWA TIMUR (LOGO GANDA BASE64)
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
                    Pusat Pelayanan Terapi Inklusif Terpadu Disabilitas, ABK, Lansia, &amp; ODGJ Jawa Timur
                </div>
                <div class="kop-sub" style="font-size: 8pt; color: #222;">
                    Cakupan: {{ $meta['upt_text'] }} &bull; Hari Pelayanan: Setiap Hari Rabu (08.00 - 13.00 WIB) &bull; Hotline Layanan Gratis Dinsos Jatim
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

    <!-- Header Box Judul & Metadata Laporan (Format Sesuai Reference PDF) -->
    <table class="table-data header-box-table" style="width: 100%; border-collapse: collapse; margin-bottom: 6px;">
        <tr>
            <td style="width: 58%; text-align: center; vertical-align: middle; border: 1.5px solid #000000 !important; padding: 6px 8px; background: #ffffff;">
                <div style="font-size: 11.5pt; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">LAPORAN EKSEKUTIF &amp; REKAPITULASI STATISTIK</div>
                <div style="font-size: 10pt; font-weight: bold; text-transform: uppercase; margin-top: 1px;">PELAYANAN REHABILITASI MEDIS &amp; TERAPI TERPADU</div>
                <div style="font-size: 8pt; color: #333333; margin-top: 2px;">OMAH TERAPI-KU DINAS SOSIAL PROVINSI JAWA TIMUR</div>
            </td>
            <td style="width: 42%; border: 1.5px solid #000000 !important; padding: 0; vertical-align: top; background: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-size: 8.5pt;">
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold; width: 40%;">PERIODE</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: 800; font-size: 9pt;">: {{ $meta['periode_text'] }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold;">Cakupan UPT</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px;">: {{ $meta['upt_text'] }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; padding: 3px 6px; font-weight: bold;">Tgl. Cetak</td>
                        <td style="border: none !important; padding: 3px 6px;">: {{ $tglCetakFormatted }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ========================================================================= -->
    <!-- 1. RINGKASAN EKSEKUTIF / CAPAIAN INDIKATOR UTAMA -->
    <!-- ========================================================================= -->
    <div class="section-title">1. RINGKASAN EKSEKUTIF &amp; CAPAIAN INDIKATOR UTAMA (IKU)</div>
    
    <table class="kpi-matrix no-break">
        <tr>
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ number_format($data['total_sesi'], 0, ',', '.') }}</span>
                <span class="kpi-matrix-lbl">Total Sesi Terapi</span>
                <small style="font-size: 7.5pt; color: #475569;">({{ $data['total_sesi_selesai'] }} Selesai &bull; {{ $data['total_sesi_proses'] }} Proses)</small>
            </td>
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ number_format($data['total_pasien_terlayani'], 0, ',', '.') }}</span>
                <span class="kpi-matrix-lbl">Penerima Manfaat</span>
                <small style="font-size: 7.5pt; color: #475569;">({{ $data['total_pasien_baru'] }} Pasien Baru)</small>
            </td>
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ $data['avg_sesi_per_rabu'] }}</span>
                <span class="kpi-matrix-lbl">Rata-Rata Sesi / Rabu</span>
                <small style="font-size: 7.5pt; color: #475569;">({{ $data['rabu_count'] }} Hari Pelayanan)</small>
            </td>
            @php
                $totalDesilPasien = array_sum($data['desil_breakdown']);
                $desil12Count = ($data['desil_breakdown']['Desil 1'] ?? 0) + ($data['desil_breakdown']['Desil 2'] ?? 0);
                $desil12Pct = $totalDesilPasien > 0 ? round(($desil12Count / $totalDesilPasien) * 100, 1) : 0;
            @endphp
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ $desil12Pct }}%</span>
                <span class="kpi-matrix-lbl">Prioritas Desil 1 &amp; 2</span>
                <small style="font-size: 7.5pt; color: #475569;">({{ $desil12Count }} Pasien DTKS Terverifikasi)</small>
            </td>
        </tr>
    </table>

    <!-- ========================================================================= -->
    <!-- 2. ANALISIS KETEPATAN SASARAN PENERIMA MANFAAT (DISTRIBUSI DESIL DTKS) -->
    <!-- ========================================================================= -->
    <div class="section-title">2. ANALISIS KETEPATAN SASARAN PENERIMA MANFAAT (DISTRIBUSI DESIL DTKS / DTSEN)</div>
    
    <table class="table-data no-break">
        <thead>
            <tr>
                <th style="width: 35px; text-align: center;">No</th>
                <th style="width: 140px;">Kategori Desil DTKS</th>
                <th>Klasifikasi Status Sosial Ekonomi</th>
                <th style="width: 100px; text-align: center;">Jumlah Pasien</th>
                <th style="width: 85px; text-align: center;">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $desilKeterangan = [
                    'Desil 1' => 'Rumah Tangga dengan tingkat kemiskinan ekstrem / Sangat Miskin',
                    'Desil 2' => 'Rumah Tangga miskin dengan keterbatasan akses dasar',
                    'Desil 3' => 'Rumah Tangga hampir miskin dengan kerentanan sosial ekonomi',
                    'Desil 4' => 'Rumah Tangga rentan miskin dengan penyandang disabilitas',
                    'Desil 5' => 'Penerima manfaat dengan kebutuhan terapi rehabilitatif khusus',
                    'Non-Desil / Belum Terdata' => 'Penerima manfaat rujukan klinis atau pendataan mandiri',
                ];
            @endphp
            @foreach($data['desil_breakdown'] as $desilName => $count)
                @php
                    $pct = $totalDesilPasien > 0 ? round(($count / $totalDesilPasien) * 100, 1) : 0;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td><strong>{{ $desilName }}</strong></td>
                    <td>{{ $desilKeterangan[$desilName] ?? '-' }}</td>
                    <td style="text-align: center;"><strong>{{ $count }}</strong> Orang</td>
                    <td style="text-align: center;"><strong>{{ $pct }}%</strong></td>
                </tr>
            @endforeach
            <tr style="background: #e8e8e8; font-weight: bold;">
                <td colspan="3" style="text-align: right; text-transform: uppercase;">Total Penerima Manfaat Terverifikasi:</td>
                <td style="text-align: center;">{{ $totalDesilPasien }} Orang</td>
                <td style="text-align: center;">100.0%</td>
            </tr>
        </tbody>
    </table>

    <!-- ========================================================================= -->
    <!-- 3. RAGAM LAYANAN TERAPI & DEMOGRAFI PENERIMA MANFAAT -->
    <!-- ========================================================================= -->
    <div class="section-title">3. DISTRIBUSI LAYANAN TERAPI &amp; DEMOGRAFI PENERIMA MANFAAT</div>
    
    <div class="row no-break">
        <!-- Kolom Kiri: Layanan Terapi -->
        <div class="col-6 pr-1">
            <table class="table-data mb-0">
                <thead>
                    <tr>
                        <th>Ragam Layanan Terapi</th>
                        <th style="width: 75px; text-align: center;">Total Sesi</th>
                        <th style="width: 65px; text-align: center;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['layanan_breakdown'] as $l)
                        @php
                            $pctL = $data['total_sesi'] > 0 ? round(($l->total / $data['total_sesi']) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td><strong>{{ $l->layanan_terapi }}</strong></td>
                            <td style="text-align: center;">{{ $l->total }} Sesi</td>
                            <td style="text-align: center;">{{ $pctL }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">Tidak ada data layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Kolom Kanan: Demografi Usia & Gender -->
        <div class="col-6 pl-1">
            <table class="table-data mb-0">
                <thead>
                    <tr>
                        <th>Kelompok Usia &amp; Gender</th>
                        <th style="width: 70px; text-align: center;">Jumlah</th>
                        <th style="width: 75px; text-align: center;">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Anak-Anak / ABK (&lt; 18 Tahun)</td>
                        <td style="text-align: center;"><strong>{{ $data['demografi']['anak'] }}</strong></td>
                        <td style="text-align: center;">Prioritas ABK</td>
                    </tr>
                    <tr>
                        <td>Dewasa (18 s.d. 59 Tahun)</td>
                        <td style="text-align: center;"><strong>{{ $data['demografi']['dewasa'] }}</strong></td>
                        <td style="text-align: center;">Stroke/ODGJ</td>
                    </tr>
                    <tr>
                        <td>Lansia (&ge; 60 Tahun)</td>
                        <td style="text-align: center;"><strong>{{ $data['demografi']['lansia'] }}</strong></td>
                        <td style="text-align: center;">Geriatri</td>
                    </tr>
                    <tr style="background: #f8fafc;">
                        <td>Gender: Laki-laki / Perempuan</td>
                        <td style="text-align: center;" colspan="2">
                            <strong>{{ $data['demografi']['laki'] }}</strong> L &bull; <strong>{{ $data['demografi']['perempuan'] }}</strong> P
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 4. TINDAKAN TERAPI & PROFIL RAGAM DISABILITAS PENERIMA MANFAAT -->
    <!-- ========================================================================= -->
    <div class="section-title">4. TINDAKAN TERAPI &amp; PROFIL RAGAM DISABILITAS PENERIMA MANFAAT</div>
    
    <div class="row no-break">
        <!-- Kolom Kiri: Tindakan Terapi Terbanyak -->
        <div class="col-6 pr-1">
            <table class="table-data mb-0">
                <thead>
                    <tr>
                        <th style="width: 30px; text-align: center;">No</th>
                        <th>Tindakan Terapi Sering Diberikan</th>
                        <th style="width: 75px; text-align: center;">Frekuensi</th>
                        <th style="width: 65px; text-align: center;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $noTdk = 1; 
                    @endphp
                    @forelse($data['top_tindakan'] as $tt)
                        @php
                            $pctT = $data['total_sesi'] > 0 ? round(($tt->total / $data['total_sesi']) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $noTdk++ }}</td>
                            <td><strong>{{ $tt->tindakan }}</strong></td>
                            <td style="text-align: center;">{{ $tt->total }} Sesi</td>
                            <td style="text-align: center;">{{ $pctT }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Belum ada tindakan tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Kolom Kanan: Profil Ragam Disabilitas -->
        <div class="col-6 pl-1">
            <table class="table-data mb-0">
                <thead>
                    <tr>
                        <th style="width: 30px; text-align: center;">No</th>
                        <th>Ragam Disabilitas Terlayani</th>
                        <th style="width: 70px; text-align: center;">Jumlah</th>
                        <th style="width: 75px; text-align: center;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $noDis = 1; 
                        $totalDisCount = array_sum($data['disabilitas_breakdown']);
                    @endphp
                    @forelse($data['disabilitas_breakdown'] as $disName => $disCount)
                        @php
                            $pctDis = $totalDisCount > 0 ? round(($disCount / $totalDisCount) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $noDis++ }}</td>
                            <td><strong>{{ $disName }}</strong></td>
                            <td style="text-align: center;"><strong>{{ $disCount }}</strong> Orang</td>
                            <td style="text-align: center;">{{ $pctDis }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Data disabilitas belum tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 5. SEBARAN GEOGRAFIS ASAL PENERIMA MANFAAT (KABUPATEN / KOTA) -->
    <!-- ========================================================================= -->
    <div class="section-title">5. SEBARAN GEOGRAFIS ASAL PENERIMA MANFAAT (KABUPATEN / KOTA)</div>
    
    <table class="table-data no-break">
        <thead>
            <tr>
                <th style="width: 35px; text-align: center;">No</th>
                <th>Kabupaten / Kota Asal Domisili</th>
                <th style="width: 120px; text-align: center;">Jumlah Pasien</th>
                <th style="width: 85px; text-align: center;">Proporsi</th>
                <th style="width: 230px;">Klasifikasi Jangkauan Wilayah</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $noKab = 1;
                $totalPasienWilayah = array_sum($data['wilayah_breakdown']);
            @endphp
            @forelse($data['wilayah_breakdown'] as $kabName => $kabTotal)
                @php
                    $pctKab = $totalPasienWilayah > 0 ? round(($kabTotal / $totalPasienWilayah) * 100, 1) : 0;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $noKab++ }}</td>
                    <td><strong>{{ $kabName }}</strong></td>
                    <td style="text-align: center;"><strong>{{ $kabTotal }}</strong> Orang</td>
                    <td style="text-align: center;"><strong>{{ $pctKab }}%</strong></td>
                    <td>
                        @if(stripos($kabName, 'Sidoarjo') !== false)
                            Wilayah Inti Pelayanan (PPSAB &amp; RS PMKS Sidoarjo)
                        @elseif(stripos($kabName, 'Malang') !== false)
                            Wilayah Inti Pelayanan (UPT RSBN Malang)
                        @elseif(stripos($kabName, 'Surabaya') !== false || stripos($kabName, 'Gresik') !== false || stripos($kabName, 'Pasuruan') !== false || stripos($kabName, 'Mojokerto') !== false)
                            Kawasan Penyangga Aglomerasi Terdekat
                        @else
                            Rujukan Lintas Daerah Jawa Timur
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data domisili tercatat pada periode ini.</td>
                </tr>
            @endforelse
            @if($totalPasienWilayah > 0)
                <tr style="background: #e8e8e8; font-weight: bold;">
                    <td colspan="2" style="text-align: right; text-transform: uppercase;">Total Penerima Manfaat Terdata:</td>
                    <td style="text-align: center;">{{ $totalPasienWilayah }} Orang</td>
                    <td style="text-align: center;">100.0%</td>
                    <td>Tersebar di {{ count($data['wilayah_breakdown']) }} Kab/Kota Jawa Timur</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- ========================================================================= -->
    <!-- 6. REKAPITULASI KONSOLIDASI PER UNIT PELAKSANA TEKNIS (UPT) -->
    <!-- ========================================================================= -->
    <div class="section-title">6. REKAPITULASI PELAYANAN PER UNIT PELAKSANA TEKNIS (UPT)</div>
    
    <table class="table-data no-break">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th style="width: 170px;">Nama UPT / Balai</th>
                <th>Fokus Layanan &amp; Hotline</th>
                <th style="width: 65px; text-align: center;">Terapis</th>
                <th style="width: 70px; text-align: center;">Pasien</th>
                <th style="width: 70px; text-align: center;">Total Sesi</th>
                <th style="width: 70px; text-align: center;">Selesai</th>
            </tr>
        </thead>
        <tbody>
            @php $noUpt = 1; @endphp
            @foreach($data['upt_rekap'] as $u)
                <tr>
                    <td style="text-align: center;">{{ $noUpt++ }}</td>
                    <td><strong>{{ $u['nama'] }}</strong></td>
                    <td>
                        {{ $u['fokus'] }}
                        @if($u['no_telp'] && $u['no_telp'] !== '-')
                            <br><small style="color: #334155;">Telp/Hotline: {{ $u['no_telp'] }}</small>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $u['total_terapis'] }} Org</td>
                    <td style="text-align: center;"><strong>{{ $u['total_pasien'] }}</strong> Org</td>
                    <td style="text-align: center;"><strong>{{ $u['total_sesi'] }}</strong></td>
                    <td style="text-align: center;"><strong>{{ $u['selesai_sesi'] }}</strong></td>
                </tr>
            @endforeach
            <tr style="background: #e8e8e8; font-weight: bold;">
                <td colspan="3" style="text-align: right; text-transform: uppercase;">Total Konsolidasi Jawa Timur:</td>
                <td style="text-align: center;">{{ array_sum(array_column($data['upt_rekap'], 'total_terapis')) }} Org</td>
                <td style="text-align: center;">{{ $data['total_pasien_terlayani'] }} Org</td>
                <td style="text-align: center;">{{ $data['total_sesi'] }}</td>
                <td style="text-align: center;">{{ $data['total_sesi_selesai'] }}</td>
            </tr>
        </tbody>
    </table>

    <!-- ========================================================================= -->
    <!-- 7. UTILISASI & KINERJA TENAGA TERAPIS / MEDIS -->
    <!-- ========================================================================= -->
    <div class="section-title">7. REKAPITULASI KINERJA TENAGA TERAPIS &amp; TENAGA MEDIS</div>
    
    <table class="table-data no-break">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th>Nama Tenaga Terapis / Medis</th>
                <th style="width: 140px;">NIP / No. Registrasi</th>
                <th style="width: 160px;">Penempatan UPT</th>
                <th style="width: 80px; text-align: center;">Sesi Dilayani</th>
                <th style="width: 80px; text-align: center;">Sesi Selesai</th>
            </tr>
        </thead>
        <tbody>
            @php $noTerapis = 1; @endphp
            @forelse($data['terapis_rekap'] as $t)
                <tr>
                    <td style="text-align: center;">{{ $noTerapis++ }}</td>
                    <td><strong>{{ $t['nama'] }}</strong></td>
                    <td>{{ $t['nip'] }}</td>
                    <td>{{ $t['penempatan'] }}</td>
                    <td style="text-align: center;"><strong>{{ $t['total_sesi'] }}</strong> Sesi</td>
                    <td style="text-align: center;">{{ $t['selesai'] }} Sesi</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data terapis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ========================================================================= -->
    <!-- 8. LEMBAR PENGESAHAN RESMI DOKUMEN PEMERINTAH -->
    <!-- ========================================================================= -->
    <table class="ttd-table no-break">
        <tr>
            <td style="width: 50%;">
                Mengetahui / Memeriksa,<br>
                <strong>Penanggung Jawab Program Omah Terapi-KU</strong><br>
                Dinas Sosial Provinsi Jawa Timur<br>
                <div style="height: 55px;"></div>
                <strong>( ___________________________________ )</strong><br>
                <small style="font-size: 8.5pt; color: #333;">NIP. ___________________________</small>
            </td>
            <td style="width: 50%;">
                Surabaya, {{ $tglCetakFormatted }}<br>
                <strong>Kepala Dinas Sosial Provinsi Jawa Timur</strong><br>
                <br>
                <div style="height: 55px;"></div>
                <strong style="text-decoration: underline;">Dra. RESTU NOVI WIDIANI, M.M.</strong><br>
                <small style="font-size: 8pt; color: #333;">Pembina Utama Madya (Gol. IV/d)<br>NIP. 19681109 199303 2 006</small>
            </td>
        </tr>
    </table>

</div>

<script>
function triggerPrintDialog() {
    window.print();
}

function downloadPDF() {
    var element = document.getElementById('print-area');
    var btnDownload = document.getElementById('btnDownloadPdf');
    var originalText = btnDownload ? btnDownload.innerHTML : '';
    
    if (btnDownload) {
        btnDownload.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Mengunduh PDF...';
        btnDownload.disabled = true;
    }

    var cleanPeriode = "{{ preg_replace('/[^a-zA-Z0-9_-]/', '_', $meta['periode_text']) }}";
    var opt = {
        margin:       [8, 10, 10, 10],
        filename:     'Laporan_Eksekutif_OmahTerapiKU_' + cleanPeriode + '.pdf',
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
            avoid: ['tr', 'tbody tr', '.section-title', '.table-data', '.kpi-matrix', '.ttd-table', '.no-break', '.print-block', '.header-box-table']
        }
    };

    html2pdf().set(opt).from(element).save().then(function() {
        if (btnDownload) {
            btnDownload.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Terunduh!';
            btnDownload.disabled = false;
            setTimeout(function() {
                btnDownload.innerHTML = originalText;
            }, 3000);
        }
    }).catch(function(err) {
        console.error('PDF generation error:', err);
        if (btnDownload) {
            btnDownload.innerHTML = originalText;
            btnDownload.disabled = false;
        }
        window.print();
    });
}

document.addEventListener("DOMContentLoaded", function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('download') === 'pdf') {
        setTimeout(function() {
            downloadPDF();
        }, 600);
    } else if (urlParams.get('auto_print') === '1') {
        setTimeout(function() {
            triggerPrintDialog();
        }, 500);
    }
});
</script>

</body>
</html>

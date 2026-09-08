<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Eksekutif & Rekapitulasi Statistik Omah Terapi-KU - {{ $meta['periode_text'] }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Format Dokumen Pemerintahan Resmi (Standar Dinas Sosial Prov. Jatim) */
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 15mm 15mm;
        }

        body {
            background-color: #e2e8f0;
            color: #000000;
            font-family: 'Times New Roman', Times, serif, 'Segoe UI', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.35;
        }

        .print-toolbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #cbd5e1;
            padding: 10px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .print-container {
            max-width: 850px;
            margin: 20px auto 40px auto;
            background: #ffffff;
            padding: 28px 36px;
            border-radius: 4px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
            color: #000000;
        }

        /* Kop Surat Resmi */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 4px;
        }
        .kop-table td {
            border: none !important;
            padding: 0 4px;
            vertical-align: middle;
        }
        .kop-logo {
            max-width: 78px;
            max-height: 78px;
            object-fit: contain;
        }
        .kop-instansi {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #000000;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        .kop-dinas {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #000000;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        .kop-unit {
            font-size: 12pt;
            font-weight: bold;
            color: #000000;
            margin-top: 1px;
        }
        .kop-sub {
            font-size: 8.5pt;
            color: #000000;
            margin-top: 2px;
            line-height: 1.25;
        }
        .kop-line {
            border-bottom: 3px double #000000;
            margin-top: 5px;
            margin-bottom: 14px;
        }

        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            font-size: 12.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            color: #000000;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #000000;
            margin-bottom: 3px;
        }
        .doc-meta {
            text-align: center;
            font-size: 9.5pt;
            color: #000000;
            margin-bottom: 14px;
            border-bottom: 1px solid #000000;
            padding-bottom: 6px;
        }

        /* Section Styling */
        .section-header {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f1f5f9;
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            padding: 4px 8px;
            margin-top: 14px;
            margin-bottom: 8px;
            color: #000000;
        }

        /* Tabel Standar Dinas */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9pt;
        }
        .table-data th {
            border: 1px solid #000000;
            padding: 5px 6px;
            font-weight: bold;
            text-align: center;
            background-color: #f8fafc;
            color: #000000;
            text-transform: uppercase;
            font-size: 8.5pt;
        }
        .table-data td {
            border: 1px solid #000000;
            padding: 4px 6px;
            vertical-align: middle;
            color: #000000;
        }

        /* Ringkasan Angka Matriks */
        .kpi-matrix {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .kpi-matrix td {
            border: 1px solid #000000;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }
        .kpi-matrix-val {
            font-size: 14pt;
            font-weight: bold;
            color: #000000;
            display: block;
        }
        .kpi-matrix-lbl {
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #334155;
            display: block;
        }

        /* Tanda Tangan */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            border: none !important;
            padding: 2px 10px;
            text-align: center;
            vertical-align: top;
            font-size: 9.5pt;
        }

        .no-break {
            page-break-inside: avoid;
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 9.5pt !important;
            }
            .print-toolbar {
                display: none !important;
            }
            .print-container {
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
                box-shadow: none !important;
                border: none !important;
            }
            .section-header {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .table-data th {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

<!-- TOOLBAR ATAS (HANYA MUNCUL DI LAYAR BROWSER) -->
<div class="print-toolbar no-print">
    <div class="d-flex align-items-center justify-content-between max-w-7xl mx-auto" style="max-width: 850px;">
        <div class="d-flex align-items-center">
            <span class="badge badge-primary mr-2" style="font-size: 11px; padding: 4px 8px; background: #2563eb;">PDF Preview</span>
            <strong class="text-dark" style="font-size: 13px;">Laporan Eksekutif & Statistik Dinas Sosial Provinsi Jawa Timur</strong>
        </div>
        <div class="d-flex align-items-center" style="gap: 8px;">
            <button type="button" class="btn btn-sm btn-primary font-w700" onclick="window.print()" style="background: #2563eb; border-color: #2563eb;">
                <i class="fa-solid fa-print mr-1"></i> Cetak Dokumen / Simpan PDF
            </button>
            <a href="{{ route('laporan.eksekutif', request()->all()) }}" class="btn btn-sm btn-light font-w600" style="border: 1px solid #cbd5e1;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<div class="print-container" id="print-area">
    
    <!-- KOP SURAT RESMI PEMERINTAH PROVINSI JAWA TIMUR -->
    <table class="kop-table">
        <tr>
            <td style="width: 80px; text-align: left; vertical-align: middle;">
                <img src="{{ $logoOmahBase64 }}" alt="Logo Omah Terapi" class="kop-logo">
            </td>
            <td style="text-align: center; vertical-align: middle; padding: 0 6px;">
                <div class="kop-instansi">PEMERINTAH PROVINSI JAWA TIMUR</div>
                <div class="kop-dinas">DINAS SOSIAL</div>
                <div class="kop-unit">OMAH TERAPI-KU JAWA TIMUR</div>
                <div class="kop-sub">
                    Pusat Pelayanan Terapi Inklusif Terpadu Disabilitas, ABK, Lansia, & ODGJ Jawa Timur<br>
                    Cakupan Operasional: {{ $meta['upt_text'] }} &bull; Hari Pelayanan: Setiap Hari Rabu (08.00 - 13.00 WIB)<br>
                    Website: omahterapiku.dinsos.jatimprov.go.id &bull; Hotline Layanan Gratis Pemprov Jatim
                </div>
            </td>
            <td style="width: 80px; text-align: right; vertical-align: middle;">
                <img src="{{ $logoDinsosBase64 }}" alt="Logo Dinsos Jawa Timur" class="kop-logo">
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- JUDUL DOKUMEN LAPORAN RESMI -->
    <div class="doc-title">LAPORAN EKSEKUTIF & REKAPITULASI STATISTIK PELAYANAN TERAPI</div>
    <div class="doc-subtitle">PROGRAM OMAH TERAPI-KU DINAS SOSIAL PROVINSI JAWA TIMUR</div>
    <div class="doc-meta">
        <strong>Periode Laporan:</strong> {{ $meta['periode_text'] }} &bull; 
        <strong>Cakupan:</strong> {{ $meta['upt_text'] }} &bull; 
        <strong>Layanan:</strong> {{ $meta['layanan_text'] }}
    </div>

    <!-- ========================================================================= -->
    <!-- 1. RINGKASAN EKSEKUTIF / CAPAIAN INDIKATOR UTAMA -->
    <!-- ========================================================================= -->
    <div class="section-header">1. RINGKASAN EKSEKUTIF & CAPAIAN INDIKATOR UTAMA (IKU)</div>
    
    <table class="kpi-matrix no-break">
        <tr>
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ number_format($data['total_sesi'], 0, ',', '.') }}</span>
                <span class="kpi-matrix-lbl">Total Sesi Terapi</span>
                <small style="font-size: 7.5pt; color: #475569;">({{ $data['total_sesi_selesai'] }} Selesai &bull; {{ $data['total_sesi_proses'] }} On-going)</small>
            </td>
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ number_format($data['total_pasien_terlayani'], 0, ',', '.') }}</span>
                <span class="kpi-matrix-lbl">Penerima Manfaat</span>
                <small style="font-size: 7.5pt; color: #475569;">({{ $data['total_pasien_baru'] }} Pasien Terdaftar Baru)</small>
            </td>
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ $data['avg_sesi_per_rabu'] }}</span>
                <span class="kpi-matrix-lbl">Rata-Rata Sesi / Rabu</span>
                <small style="font-size: 7.5pt; color: #475569;">(Total {{ $data['rabu_count'] }} Hari Pelayanan)</small>
            </td>
            @php
                $totalDesilPasien = array_sum($data['desil_breakdown']);
                $desil12Count = ($data['desil_breakdown']['Desil 1'] ?? 0) + ($data['desil_breakdown']['Desil 2'] ?? 0);
                $desil12Pct = $totalDesilPasien > 0 ? round(($desil12Count / $totalDesilPasien) * 100, 1) : 0;
            @endphp
            <td style="width: 25%;">
                <span class="kpi-matrix-val">{{ $desil12Pct }}%</span>
                <span class="kpi-matrix-lbl">Prioritas Desil 1 & 2</span>
                <small style="font-size: 7.5pt; color: #475569;">({{ $desil12Count }} Pasien DTKS Terverifikasi)</small>
            </td>
        </tr>
    </table>

    <!-- ========================================================================= -->
    <!-- 2. ANALISIS KETEPATAN SASARAN PENERIMA MANFAAT (DISTRIBUSI DESIL DTKS) -->
    <!-- ========================================================================= -->
    <div class="section-header">2. ANALISIS KETEPATAN SASARAN PENERIMA MANFAAT (DISTRIBUSI DESIL DTKS / DTSEN)</div>
    
    <table class="table-data no-break">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 140px; text-align: left;">Kategori Desil DTKS</th>
                <th style="text-align: left;">Klasifikasi Status Sosial Ekonomi</th>
                <th style="width: 100px;">Jumlah Pasien</th>
                <th style="width: 90px;">Persentase</th>
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
            <tr style="background: #f8fafc; font-weight: bold;">
                <td colspan="3" style="text-align: right; text-transform: uppercase;">Total Penerima Manfaat Terverifikasi:</td>
                <td style="text-align: center;">{{ $totalDesilPasien }} Orang</td>
                <td style="text-align: center;">100.0%</td>
            </tr>
        </tbody>
    </table>

    <!-- ========================================================================= -->
    <!-- 3. RAGAM LAYANAN TERAPI & DEMOGRAFI PENERIMA MANFAAT -->
    <!-- ========================================================================= -->
    <div class="section-header">3. DISTRIBUSI LAYANAN TERAPI & DEMOGRAFI PENERIMA MANFAAT</div>
    
    <div class="row no-break">
        <!-- Kolom Kiri: Layanan Terapi -->
        <div class="col-6 pr-1">
            <table class="table-data mb-0">
                <thead>
                    <tr>
                        <th style="text-align: left;">Ragam Layanan Terapi</th>
                        <th style="width: 70px;">Total Sesi</th>
                        <th style="width: 60px;">Proporsi</th>
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
                            <td colspan="3" style="text-align: center;">Tidak ada data.</td>
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
                        <th style="text-align: left;">Kelompok Usia & Gender</th>
                        <th style="width: 70px;">Jumlah</th>
                        <th style="width: 60px;">Keterangan</th>
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
    <!-- 4. REKAPITULASI KONSOLIDASI PER UNIT PELAKSANA TEKNIS (UPT) -->
    <!-- ========================================================================= -->
    <div class="section-header">4. REKAPITULASI PELAYANAN PER UNIT PELAKSANA TEKNIS (UPT)</div>
    
    <table class="table-data no-break">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="text-align: left; width: 170px;">Nama UPT / Balai</th>
                <th style="text-align: left;">Fokus Layanan & Hotline</th>
                <th style="width: 70px;">Terapis</th>
                <th style="width: 75px;">Pasien</th>
                <th style="width: 75px;">Total Sesi</th>
                <th style="width: 75px;">Selesai</th>
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
            <tr style="background: #f8fafc; font-weight: bold;">
                <td colspan="3" style="text-align: right; text-transform: uppercase;">Total Konsolidasi Jawa Timur:</td>
                <td style="text-align: center;">{{ array_sum(array_column($data['upt_rekap'], 'total_terapis')) }} Org</td>
                <td style="text-align: center;">{{ $data['total_pasien_terlayani'] }} Org</td>
                <td style="text-align: center;">{{ $data['total_sesi'] }}</td>
                <td style="text-align: center;">{{ $data['total_sesi_selesai'] }}</td>
            </tr>
        </tbody>
    </table>

    <!-- ========================================================================= -->
    <!-- 5. UTILISASI & KINERJA TENAGA TERAPIS / MEDIS -->
    <!-- ========================================================================= -->
    <div class="section-header">5. REKAPITULASI KINERJA TENAGA TERAPIS & TENAGA MEDIS</div>
    
    <table class="table-data no-break">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="text-align: left;">Nama Tenaga Terapis / Medis</th>
                <th style="width: 140px; text-align: left;">NIP / No. Registrasi</th>
                <th style="text-align: left; width: 160px;">Penempatan UPT</th>
                <th style="width: 80px;">Sesi Dilayani</th>
                <th style="width: 80px;">Sesi Selesai</th>
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
    <!-- 6. LEMBAR PENGESAHAN RESMI DOKUMEN PEMERINTAH -->
    <!-- ========================================================================= -->
    <table class="ttd-table no-break">
        <tr>
            <td style="width: 50%;">
                Mengetahui / Memeriksa,<br>
                <strong>Penanggung Jawab Program Omah Terapi-KU</strong><br>
                Dinas Sosial Provinsi Jawa Timur<br>
                <div style="height: 65px;"></div>
                <strong><u>dr. Hj. SITI AISYAH, Sp.KFR</u></strong><br>
                NIP. 19780512 200604 2 008
            </td>
            <td style="width: 50%;">
                Surabaya, {{ $tglCetakFormatted }}<br>
                <strong>Kepala Dinas Sosial Provinsi Jawa Timur</strong><br>
                <br>
                <div style="height: 65px;"></div>
                <strong><u>Dra. RESTU NOVI WIDIANI, M.M.</u></strong><br>
                Pembina Utama Madya (Gol. IV/d)<br>
                NIP. 19681109 199303 2 006
            </td>
        </tr>
    </table>

</div>

</body>
</html>

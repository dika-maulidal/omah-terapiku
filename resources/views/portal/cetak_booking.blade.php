<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Reservasi Sesi Terapi - {{ $booking->pasien ? $booking->pasien->nama : 'Pasien' }} ({{ $booking->kode_booking }})</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* Format Dokumen Rekam Medis & Reservasi Standar Kedinasan (Monokrom / Standar Reference PDF) */
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
            line-height: 1.28;
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

        /* Header RM Box Table */
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

        /* Box Rekap / Catatan Khusus */
        .box-rekap {
            background-color: #f8f8f8;
            border: 1px solid #000000;
            border-radius: 0;
            padding: 6px 10px;
            margin-bottom: 6px;
            font-size: 8.5pt;
            color: #000000;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        /* Tanda Tangan */
        .sign-area {
            width: 100%;
            margin-top: 14px;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            font-size: 8.5pt;
        }
        .sign-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sign-table td {
            border: none !important;
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
        }
        .sig-spacer {
            height: 52px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Print Media Query */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .print-toolbar {
                display: none !important;
            }
            .print-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            .kop-line {
                border-top: 2px solid #000000 !important;
                border-bottom: 1px solid #000000 !important;
            }
            .header-box-table td {
                border: 1.5px solid #000000 !important;
            }
            .table-assessment th {
                background-color: #e8e8e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .section-title {
                background-color: #efefef !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                page-break-after: avoid !important;
                break-after: avoid !important;
            }
            .box-rekap {
                background-color: #f8f8f8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            tr, .table-assessment tr, .table-assessment td, .table-assessment th {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            .no-break, .sign-area, .kop-table, .header-box-table {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
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
        : (file_exists($pathLogoOmah) ? $logoOmahBase64 : asset('images/logo.png'));

    // Safe Date Helper
    $safeFormatDate = function($date, $default = '-') {
        if (empty($date)) return $default;
        try {
            return \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            return (string)$date;
        }
    };

    $pasien = $booking->pasien;
    $safeAge = function($date) {
        if (empty($date)) return '-';
        try {
            return \Carbon\Carbon::parse($date)->age . ' Tahun';
        } catch (\Throwable $e) {
            return '-';
        }
    };

    $usiaTahun = $pasien ? $safeAge($pasien->tgl_lahir) : '-';
    $tglPengajuanFormatted = $safeFormatDate($booking->created_at, date('d F Y'));
    $tglRencanaFormatted = $safeFormatDate($booking->tgl_rencana, '-');
    $tglCetak = \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB';

    $uptNama = $booking->upt_lokasi ?: ($upt ? $upt->nama : ($pasien ? $pasien->upt_lokasi : 'UPT RSBN Malang'));
    $uptContact = $upt && $upt->no_telp ? $upt->no_telp : '0812-3456-7890';
@endphp

<!-- Sticky Action Toolbar (Hanya Tampil di Layar) -->
<div class="print-toolbar no-print">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between" style="max-width: 820px; gap: 8px; padding: 0;">
        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 4px 8px; background: #2563eb; color: #fff;">
                <i class="fa-solid fa-calendar-check mr-1"></i> BUKTI RESERVASI
            </span>
            <strong style="color: #0f172a; font-size: 12.5px;">{{ $pasien ? $pasien->nama : 'Pasien' }}</strong>
            <span class="text-muted" style="font-size: 11.5px;">({{ $booking->kode_booking }})</span>
            @if($booking->status === 'disetujui')
                <span class="badge badge-success font-w600" style="background: #16a34a; font-size: 11px; padding: 4px 7px;">
                    <i class="fa-solid fa-check-circle mr-1"></i> Disetujui
                </span>
            @elseif($booking->status === 'selesai')
                <span class="badge badge-info font-w600" style="background: #0284c7; color: #fff; font-size: 11px; padding: 4px 7px;">
                    <i class="fa-solid fa-check-double mr-1"></i> Selesai
                </span>
            @elseif($booking->status === 'ditolak')
                <span class="badge badge-danger font-w600" style="background: #dc2626; font-size: 11px; padding: 4px 7px;">
                    <i class="fa-solid fa-xmark mr-1"></i> Ditolak
                </span>
            @else
                <span class="badge badge-warning font-w600" style="background: #d97706; color: #fff; font-size: 11px; padding: 4px 7px;">
                    <i class="fa-solid fa-clock mr-1"></i> Menunggu
                </span>
            @endif
        </div>

        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            <button type="button" onclick="triggerPrintDialog()" class="btn btn-sm btn-dark font-w700" style="padding: 5px 12px; font-size: 11.5px; border-radius: 4px; background: #0f172a; border: none; color: #fff;">
                <i class="fa-solid fa-print mr-1"></i> Cetak / Simpan PDF
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-primary font-w700 text-white" style="padding: 5px 12px; font-size: 11.5px; border-radius: 4px; background: #2563eb; border: none;">
                <i class="fa-solid fa-download mr-1"></i> Unduh PDF
            </button>
            @if(Session::has('portal_pasien_id'))
                <a href="{{ route('portal.booking') }}" class="btn btn-sm btn-light border font-w600" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; color: #334155;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Portal
                </a>
            @else
                <a href="{{ route('portal.index') }}" class="btn btn-sm btn-light border font-w600" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; color: #334155;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
            @endif
        </div>
    </div>
</div>

<!-- Container Dokumen Cetak (A4 Paper) -->
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
                <div class="kop-unit">OMAH TERAPI-KU &bull; {{ $uptNama }}</div>
                <div class="kop-sub">
                    Layanan Terapi Terpadu Tumbuh Kembang, Fisioterapi, Okupasi, dan Wicara Anak Disabilitas<br>
                    Telp/WA: {{ $uptContact }} &bull; Website: {{ url('/') }}
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

    <!-- Header Box Judul & Nomor Booking -->
    <table class="table-assessment header-box-table" style="width: 100%; border-collapse: collapse; margin-bottom: 6px;">
        <tr>
            <td style="width: 58%; text-align: center; vertical-align: middle; border: 1.5px solid #000000 !important; padding: 6px 8px; background: #ffffff;">
                <div style="font-size: 11pt; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">BUKTI RESERVASI &amp; JADWAL SESI TERAPI</div>
                <div style="font-size: 9.5pt; font-weight: bold; text-transform: uppercase; margin-top: 1px;">(SISTEM BOOKING SESI MANDIRI ONLINE)</div>
                <div style="font-size: 8pt; color: #333333; margin-top: 2px;">OMAH TERAPI-KU DINAS SOSIAL PROVINSI JAWA TIMUR</div>
            </td>
            <td style="width: 42%; border: 1.5px solid #000000 !important; padding: 0; vertical-align: top; background: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-size: 8.5pt;">
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold; width: 44%;">KODE BOOKING</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: 800; font-size: 9.5pt; letter-spacing: 0.5px;">: {{ $booking->kode_booking }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold;">Tgl. Pengajuan</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px;">: {{ $tglPengajuanFormatted }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; padding: 3px 6px; font-weight: bold;">Status Sesi</td>
                        <td style="border: none !important; padding: 3px 6px; font-weight: bold;">
                            : @if($booking->status === 'disetujui')
                                TERJADWAL / DISETUJUI
                              @elseif($booking->status === 'selesai')
                                SELESAI DILAKSANAKAN
                              @elseif($booking->status === 'ditolak')
                                PERMOHONAN DITOLAK
                              @else
                                MENUNGGU KONFIRMASI
                              @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- =========================================================================
         I. IDENTITAS PENERIMA MANFAAT (PASIEN)
         ========================================================================= -->
    <div class="section-title">
        I. IDENTITAS PENERIMA MANFAAT (PASIEN)
    </div>
    <table class="table-assessment" style="margin-bottom: 6px; font-size: 8.5pt;">
        <tbody>
            <tr>
                <td style="width: 20%; font-weight: bold;">Nama Lengkap Pasien</td>
                <td style="width: 30%;">: <strong>{{ $pasien ? $pasien->nama : '-' }}</strong></td>
                <td style="width: 20%; font-weight: bold;">No. Rekam Medis (No. RM)</td>
                <td style="width: 30%;">: <strong style="font-size: 9.5pt;">{{ $pasien ? $pasien->no_rm : '-' }}</strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nomor NIK Pasien</td>
                <td style="font-weight: bold;">: {{ $pasien ? ($pasien->nik ?: '-') : '-' }}</td>
                <td style="font-weight: bold;">Orang Tua / Wali</td>
                <td>: {{ $pasien ? ($pasien->nama_wali ? $pasien->nama_wali . ' (' . ($pasien->hubungan_wali ?: 'Wali') . ')' : ($pasien->nama_ortu ?: '-')) : '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">TTL / Usia Pasien</td>
                <td>: {{ $pasien && $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien ? $safeFormatDate($pasien->tgl_lahir) : '-' }} ({{ $usiaTahun }})</td>
                <td style="font-weight: bold;">No. Kontak / WhatsApp</td>
                <td style="font-weight: bold;">: {{ $pasien ? ($pasien->no_hp ?: '-') : '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Jenis Kelamin</td>
                <td>: {{ $pasien ? ($pasien->jk == 'L' ? 'Laki-laki' : ($pasien->jk == 'P' ? 'Perempuan' : ($pasien->jk ?: '-'))) : '-' }}</td>
                <td style="font-weight: bold;">Unit Layanan UPT</td>
                <td>: {{ $uptNama }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Alamat Domisili</td>
                <td colspan="3">: {{ $pasien ? ($pasien->alamat ?: ($pasien->alamat_lengkap ?: '-')) : '-' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- =========================================================================
         II. DETAIL PERMOHONAN LAYANAN & RENCANA SESI TERAPI
         ========================================================================= -->
    <div class="section-title">
        II. DETAIL PERMOHONAN LAYANAN &amp; RENCANA SESI TERAPI
    </div>
    <table class="table-assessment" style="margin-bottom: 6px; font-size: 8.5pt;">
        <tbody>
            <tr>
                <td style="width: 20%; font-weight: bold;">Jenis Layanan Terapi</td>
                <td style="width: 30%;">: <strong>{{ $booking->layanan_terapi }}</strong></td>
                <td style="width: 20%; font-weight: bold;">Lokasi Klinik / UPT</td>
                <td style="width: 30%;">: {{ $uptNama }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Rencana Tgl. Kunjungan</td>
                <td style="font-weight: bold;">: {{ $tglRencanaFormatted }}</td>
                <td style="font-weight: bold;">Preferensi Sesi Waktu</td>
                <td>: {{ $booking->jam_sesi ?: 'Sesi Pagi (08:00 - 10:00 WIB)' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Fokus / Catatan Pasien</td>
                <td colspan="3">: {{ $booking->keluhan_catatan ?: '-' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- =========================================================================
         III. PENETAPAN JADWAL & PENUGASAN PETUGAS MEDIS (JIKA DISETUJUI / SELESAI)
         ========================================================================= -->
    @if($booking->status === 'disetujui' || $booking->status === 'selesai')
        <div class="section-title">
            III. PENETAPAN JADWAL &amp; PENUGASAN PETUGAS MEDIS TERAPIS
        </div>
        <table class="table-assessment" style="margin-bottom: 6px; font-size: 8.5pt;">
            <tbody>
                <tr>
                    <td style="width: 20%; font-weight: bold;">Terapis Penanggung Jawab</td>
                    <td style="width: 30%;">: <strong>{{ $booking->dokter ? $booking->dokter->nama : 'Petugas Medis Omah Terapi-KU' }}</strong></td>
                    <td style="width: 20%; font-weight: bold;">Jadwal Sesi Terapi</td>
                    <td style="width: 30%; font-weight: bold;">: {{ $tglRencanaFormatted }} ({{ $booking->jam_sesi ?: 'Sesi Pagi' }})</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Status Pelaksanaan</td>
                    <td style="font-weight: bold;">: {{ $booking->status === 'selesai' ? 'SELESAI DILAKSANAKAN' : 'TERKONFIRMASI / SIAP HADIR' }}</td>
                    <td style="font-weight: bold;">Catatan Petugas</td>
                    <td>: {{ $booking->catatan_petugas ?: '-' }}</td>
                </tr>
            </tbody>
        </table>
    @elseif($booking->status === 'ditolak')
        <div class="section-title">
            III. CATATAN PEMBATALAN / PENOLAKAN
        </div>
        <div class="box-rekap" style="border-color: #000000; background-color: #fafafa;">
            <strong>Catatan Petugas:</strong> {{ $booking->catatan_petugas ?: 'Jadwal pada sesi tersebut sedang penuh atau terapis berhalangan. Silakan ajukan jadwal di tanggal lainnya.' }}
        </div>
    @endif

    <!-- =========================================================================
         PETUNJUK & TATA TERTIB KEHADIRAN
         ========================================================================= -->
    <div class="box-rekap no-break" style="margin-top: 6px; font-size: 8pt; line-height: 1.35;">
        <strong><i class="fa-solid fa-circle-info mr-1"></i> Tata Tertib &amp; Ketentuan Sesi Terapi:</strong>
        <ol style="margin: 3px 0 0 0; padding-left: 18px;">
            <li>Harap hadir di lokasi klinik/UPT minimal <strong>15 menit sebelum waktu sesi</strong> terapi dimulai untuk registrasi ulang antrean.</li>
            <li>Membawa lembar bukti booking ini (cetak fisik atau digital di smartphone) beserta kartu / buku rekam medis pasien.</li>
            <li>Jika berhalangan hadir atau ingin menjadwalkan ulang, mohon konfirmasi selambat-lambatnya 1 hari sebelumnya ke kontak resmi UPT.</li>
        </ol>
    </div>

    <!-- =========================================================================
         TANDA TANGAN VALIDASI (STANDAR FORMAL DINAS)
         ========================================================================= -->
    <div class="sign-area no-break">
        <table class="sign-table">
            <tr>
                <td style="width: 50%;">
                    <div>Mengetahui,</div>
                    <div>Penerima Manfaat / Wali Pasien</div>
                    <div class="sig-spacer"></div>
                    <div class="sig-name">{{ $pasien ? ($pasien->nama_wali ?: $pasien->nama) : 'Pemohon' }}</div>
                    <div style="font-size: 7.5pt; color: #444;">Tanda Tangan Pemohon</div>
                </td>
                <td style="width: 50%;">
                    <div>Jawa Timur, {{ date('d F Y') }}</div>
                    <div>Petugas Pelayanan / Terapis Omah Terapi-KU</div>
                    <div class="sig-spacer"></div>
                    <div class="sig-name">{{ $booking->dokter ? $booking->dokter->nama : ($booking->verifier ? $booking->verifier->name : 'Petugas Omah Terapi-KU') }}</div>
                    <div style="font-size: 7.5pt; color: #444;">NIP / ID Petugas Pelayanan</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Timestamp Cetak Footer Monokrom -->
    <div style="margin-top: 18px; font-size: 7.5pt; color: #555555; text-align: center; border-top: 1px solid #000000; padding-top: 4px;">
        Dokumen ini dicetak secara otomatis dari Sistem Resmi Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur pada {{ $tglCetak }}.
    </div>

</div>

<!-- Script Cetak & HTML2PDF Handlers -->
<script>
    function triggerPrintDialog() {
        window.print();
    }

    function downloadPDF() {
        var element = document.getElementById('print-area');
        var btn = document.getElementById('btnDownloadPdf');
        var originalText = btn ? btn.innerHTML : '';
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Menyimpan...';
            btn.disabled = true;
        }

        var opt = {
            margin:       [8, 10, 10, 10],
            filename:     'Bukti_Booking_{{ $booking->kode_booking }}_{{ preg_replace("/[^a-zA-Z0-9]/", "_", $booking->pasien ? $booking->pasien->nama : "Pasien") }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, letterRendering: true, logging: false },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
            pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
        };

        html2pdf().set(opt).from(element).save().then(function() {
            if (btn) {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }).catch(function(err) {
            console.error('PDF Generation Error:', err);
            if (btn) {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
            window.print();
        });
    }
</script>
</body>
</html>

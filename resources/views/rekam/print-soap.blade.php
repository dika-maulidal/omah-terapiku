<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Sesi Terapi (SOAP) - {{ $pasien->nama }} (RM# {{ $pasien->no_rm }})</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* Format Dokumen Pemerintahan Resmi (Monokrom / Hitam Putih Standar Dinas) */
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 15mm 15mm;
        }

        body {
            background-color: #e2e8f0;
            color: #000000;
            font-family: 'Times New Roman', Times, serif, 'Segoe UI', Arial, sans-serif;
            font-size: 11pt;
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
            padding: 30px 40px;
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
            font-size: 15pt;
            font-weight: 800;
            text-transform: uppercase;
            color: #000000;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        .kop-unit {
            font-size: 12.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #000000;
            line-height: 1.2;
        }
        .kop-sub {
            font-size: 9pt;
            color: #000000;
            line-height: 1.25;
            margin-top: 2px;
        }
        .kop-line {
            border-top: 2.5px solid #000000;
            border-bottom: 1px solid #000000;
            height: 3.5px;
            margin-top: 6px;
            margin-bottom: 16px;
        }

        .doc-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            text-decoration: underline;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }

        /* Tabel Identitas */
        .table-identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10pt;
        }
        .table-identitas td {
            padding: 3.5px 6px;
            vertical-align: top;
            border: 1px solid #94a3b8;
        }
        .table-identitas .label-col {
            width: 22%;
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .table-identitas .val-col {
            width: 28%;
        }

        /* Section SOAP Card / Box */
        .soap-section {
            border: 1.5px solid #000000;
            margin-bottom: 14px;
            page-break-inside: avoid;
            background: #ffffff;
        }
        .soap-header {
            background-color: #e2e8f0;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 10.5pt;
            border-bottom: 1.5px solid #000000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .soap-badge {
            display: inline-block;
            width: 22px;
            height: 22px;
            line-height: 20px;
            text-align: center;
            font-weight: 800;
            background: #000000;
            color: #ffffff;
            border-radius: 3px;
            margin-right: 8px;
            font-size: 10pt;
        }
        .soap-body {
            padding: 10px 14px;
            font-size: 10.5pt;
            line-height: 1.45;
        }

        /* Sub-box Home Program */
        .home-program-box {
            border: 1px solid #000000;
            background: #f8fafc;
            padding: 8px 12px;
            margin-top: 10px;
            border-radius: 2px;
        }
        .home-program-title {
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }

        /* Tanda Tangan */
        .sign-area {
            width: 100%;
            margin-top: 24px;
            page-break-inside: avoid;
            font-size: 10.5pt;
        }
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .sign-table td {
            border: none !important;
            padding: 4px 10px;
            vertical-align: top;
            text-align: center;
        }

        /* Anti-potong / Anti-crop Classes untuk Print & PDF */
        .no-break, .print-block, .sign-area, .kop-table, .soap-section {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        /* Print Media Query */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 10.5pt;
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
            .soap-header {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .soap-badge {
                background: #000000 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .table-identitas .label-col {
                background-color: #f1f5f9 !important;
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

    $usiaTahun = $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age : '-';
    $tglSesiFormatted = $rekam->tgl_rekam ? \Carbon\Carbon::parse($rekam->tgl_rekam)->translatedFormat('d F Y') : date('d F Y');
    $tglCetak = \Carbon\Carbon::now()->translatedFormat('d F Y');
@endphp

<!-- Sticky Action Toolbar (Hanya Tampil di Layar) -->
<div class="print-toolbar no-print">
    <div class="container d-flex flex-wrap align-items-center justify-content-between" style="max-width: 850px; gap: 10px;">
        <div class="d-flex align-items-center">
            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 6px 10px; background: #2563eb; color: #fff;">
                <i class="fa-solid fa-file-medical mr-1"></i> SOAP Sesi Terapi
            </span>
            <strong style="color: #1e293b; font-size: 13.5px;">{{ $pasien->nama }}</strong>
            <span class="text-muted ml-1" style="font-size: 12px;">({{ $pasien->no_rm }}) &bull; Sesi: {{ $rekam->tgl_rekam }}</span>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
            <button type="button" onclick="triggerPrintDialog()" class="btn btn-sm btn-dark font-w700" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px; background: #1e293b; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.15); color: #fff;">
                <i class="fa-solid fa-print mr-1"></i> Cetak / Simpan PDF
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-primary font-w700 text-white" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px; background: #2563eb; border: none; box-shadow: 0 2px 6px rgba(37,99,235,0.25);">
                <i class="fa-solid fa-download mr-1"></i> Unduh File PDF
            </button>
            <a href="{{ route('rekam.home-program.print', $rekam->id) }}" class="btn btn-sm btn-success font-w600 text-white" style="padding: 7px 14px; font-size: 12.5px; border-radius: 6px; background: #10b981; border: none;" title="Cetak Lembar Latihan Rumahan Saja">
                <i class="fa-solid fa-house-user mr-1"></i> Cetak Latihan Rumahan
            </a>
            <a href="{{ route('rekam.detail', $pasien->id) }}" class="btn btn-sm btn-light border font-w600" style="padding: 7px 14px; font-size: 12.5px; border-radius: 6px; color: #475569;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="print-container" id="print-area">
    
    <!-- KOP SURAT RESMI PEMERINTAHAN -->
    <table class="kop-table">
        <tr>
            <td style="width: 85px; text-align: left; vertical-align: middle;">
                <img src="{{ $logoOmahBase64 }}" alt="Logo Omah Terapi" class="kop-logo">
            </td>
            <td style="text-align: center; vertical-align: middle; padding: 0 8px;">
                <div class="kop-instansi">PEMERINTAH PROVINSI JAWA TIMUR</div>
                <div class="kop-dinas">DINAS SOSIAL</div>
                <div class="kop-unit">OMAH TERAPI-KU JAWA TIMUR</div>
                <div class="kop-sub">
                    Pusat Layanan Terapi Terpadu Disabilitas &bull; Layanan Terapi Fisik, Okupasi, Wicara, & Sensori Integrasi<br>
                    Lokasi UPT: {{ $rekam->upt_lokasi ?: ($rekam->poli ?: 'Jawa Timur') }}@if(isset($upt) && $upt && $upt->no_telp) &bull; Telp: {{ $upt->no_telp }}@endif &bull; Website: omahterapiku.dinsos.jatimprov.go.id
                </div>
            </td>
            <td style="width: 85px; text-align: right; vertical-align: middle;">
                <img src="{{ $logoDinsosBase64 }}" alt="Logo Dinsos Jawa Timur" class="kop-logo">
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title">LEMBAR CATATAN SESI TERAPI (SOAP)</div>
    <div class="doc-subtitle">Nomor Sesi Rekam Medis: {{ $rekam->no_rekam ?: ('RM-' . $rekam->id) }} &bull; Tanggal Sesi: {{ $tglSesiFormatted }}</div>

    <!-- TABEL IDENTITAS PENERIMA MANFAAT & DETAIL SESI -->
    <table class="table-identitas no-break">
        <tr>
            <td class="label-col">No. Rekam Medis</td>
            <td class="val-col"><strong>{{ $pasien->no_rm }}</strong></td>
            <td class="label-col">Tanggal & Waktu Sesi</td>
            <td class="val-col">{{ $tglSesiFormatted }} ({{ $rekam->sesi_waktu ?: 'Reguler' }})</td>
        </tr>
        <tr>
            <td class="label-col">Nama Penerima Manfaat</td>
            <td class="val-col"><strong>{{ $pasien->nama }}</strong></td>
            <td class="label-col">Layanan Terapi</td>
            <td class="val-col"><strong>{{ $rekam->layanan_terapi ?: ($rekam->poli ?: 'Terapi Terpadu') }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">NIK / No. Identitas</td>
            <td class="val-col">{{ $pasien->nik ?: '-' }}</td>
            <td class="label-col">Lokasi UPT Pelayanan</td>
            <td class="val-col">{{ $rekam->upt_lokasi ?: ($rekam->poli ?: 'Omah Terapi-KU') }}</td>
        </tr>
        <tr>
            <td class="label-col">TTL / Usia / JK</td>
            <td class="val-col">{{ $pasien->tmp_lahir ?: '-' }}, {{ $pasien->tgl_lahir ?: '-' }} ({{ $usiaTahun }} Thn &bull; {{ $pasien->jk ?: '-' }})</td>
            <td class="label-col">Terapis Penanggung Jawab</td>
            <td class="val-col"><strong>{{ $rekam->dokter->nama ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">Nama Orang Tua / Wali</td>
            <td class="val-col">{{ $pasien->nama_wali ?: '-' }} ({{ $pasien->hubungan_wali ?: 'Wali' }})</td>
            <td class="label-col">Terapis Pendamping</td>
            <td class="val-col">{{ $rekam->terapisPendamping->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Ragam Disabilitas / Desil</td>
            <td class="val-col">{{ $pasien->jenis_disabilitas ?: 'Non-Disabilitas' }} &bull; {{ $pasien->desil ?: 'Non-Desil' }}</td>
            <td class="label-col">No. Telepon / HP Wali</td>
            <td class="val-col">{{ $pasien->no_hp ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Lengkap</td>
            <td colspan="3">{{ $pasien->alamat_lengkap ?: '-' }}</td>
        </tr>
    </table>

    <!-- =========================================================================
         CATATAN SOAP KLINIS TERPERINCI
         ========================================================================= -->

    <!-- SECTION S: SUBJEKTIF -->
    <div class="soap-section no-break">
        <div class="soap-header">
            <div>
                <span class="soap-badge">S</span>
                <span>SUBJEKTIF (Subjective) — Keluhan & Anamnesa Sesi Ini</span>
            </div>
        </div>
        <div class="soap-body">
            @if(!empty($rekam->keluhan))
                <div style="white-space: pre-line;">{{ $rekam->keluhan }}</div>
            @else
                <span class="text-muted font-italic">Tidak ada keluhan subjektif khusus yang dilaporkan pada sesi ini.</span>
            @endif
        </div>
    </div>

    <!-- SECTION O: OBJEKTIF -->
    <div class="soap-section no-break">
        <div class="soap-header">
            <div>
                <span class="soap-badge">O</span>
                <span>OBJEKTIF (Objective) — Pemeriksaan Fisik, Tanda Vital & Observasi Gerak</span>
            </div>
            @if($rekam->pemeriksaan_file)
                <small style="font-weight: normal;">[Dokumentasi Foto Tersedia]</small>
            @endif
        </div>
        <div class="soap-body">
            @if(!empty($rekam->pemeriksaan) && $rekam->pemeriksaan !== 'Belum ada data pemeriksaan fisik')
                <div style="white-space: pre-line;">{{ $rekam->pemeriksaan }}</div>
            @else
                <span class="text-muted font-italic">Pemeriksaan fisik umum dalam batas wajar sesuai kondisi anak.</span>
            @endif
        </div>
    </div>

    <!-- SECTION A: ASSESSMENT -->
    <div class="soap-section no-break">
        <div class="soap-header">
            <div>
                <span class="soap-badge">A</span>
                <span>ASSESSMENT (Assessment) — Diagnosa Klinis & Catatan Asesmen Terapi</span>
            </div>
            @if($rekam->assessment)
                <small style="font-weight: normal; font-size: 9.5pt;">[Lembar Asesmen 15 Modul Terisi]</small>
            @endif
        </div>
        <div class="soap-body">
            <div>
                <strong>Diagnosa Klinis / Masalah Fungsional Utama:</strong>
                <div style="margin-top: 4px; font-weight: 600; font-size: 11pt; color: #000000; white-space: pre-line;">
                    {{ $rekam->diagnosa ?: 'Catatan klinis umum sesi terapi' }}
                </div>
            </div>
            @if($rekam->assessment && !empty($rekam->assessment->diagnosa_medis))
                <div style="margin-top: 6px; font-size: 10pt; color: #334155;">
                    <strong>Diagnosa Tambahan / Medis:</strong> {{ $rekam->assessment->diagnosa_medis }}
                </div>
            @endif
        </div>
    </div>

    <!-- SECTION P: PLAN -->
    <div class="soap-section no-break">
        <div class="soap-header">
            <div>
                <span class="soap-badge">P</span>
                <span>PLAN (Plan) — Rencana Tindakan, Intervensi Klinis & Latihan Rumahan</span>
            </div>
        </div>
        <div class="soap-body">
            <!-- 1. Intervensi Terapi Klinis -->
            <div style="margin-bottom: 10px;">
                <strong>1. Rencana Intervensi & Tindakan Terapi Klinis:</strong>
                <div style="margin-top: 3px; white-space: pre-line;">
                    {{ $rekam->tindakan ?: 'Latihan fungsional, modalitas terapi fisik/okupasi/wicara sesuai protokol klinis.' }}
                </div>
            </div>

            <!-- 2. Program Latihan Rumahan (Home Program) -->
            <div class="home-program-box">
                <div class="home-program-title">
                    <i class="fa-solid fa-house-user mr-1"></i> 2. Program Latihan Rumahan & Edukasi Keluarga (Home Program):
                </div>
                @if(!empty($rekam->latihan_rumahan))
                    <div style="white-space: pre-line; color: #0f172a; font-size: 10pt;">{{ $rekam->latihan_rumahan }}</div>
                @else
                    <div class="text-muted font-italic" style="font-size: 9.5pt;">
                        Melanjutkan latihan mandiri di rumah sesuai panduan terapis, menjaga postur yang benar, dan melatih stimulasi fungsional harian secara konsisten bersama keluarga.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- AREA TANDA TANGAN & PENGESAHAN -->
    <div class="sign-area no-break">
        <table class="sign-table">
            <tr>
                <td style="width: 45%;">
                    Mengetahui / Menyetujui,<br>
                    Orang Tua / Wali Penerima Manfaat<br>
                    <div style="height: 60px;"></div>
                    <strong>( {{ $pasien->nama_wali ?: '................................................' }} )</strong><br>
                    <small>Wali / Pendamping Keluarga</small>
                </td>
                <td style="width: 10%;"></td>
                <td style="width: 45%;">
                    Jawa Timur, {{ $tglSesiFormatted }}<br>
                    Terapis Penanggung Jawab Pemeriksa<br>
                    <div style="height: 60px;"></div>
                    <strong>( {{ $rekam->dokter->nama ?? 'Terapis Omah Terapi' }} )</strong><br>
                    <small>NIP / STR: {{ $rekam->dokter->user->nip ?? '-' }}</small>
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
    var btnDownload = document.getElementById('btnDownloadPdf');
    var originalText = btnDownload ? btnDownload.innerHTML : '';
    
    if (btnDownload) {
        btnDownload.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Memproses PDF...';
        btnDownload.disabled = true;
    }

    var cleanName = "{{ preg_replace('/[^a-zA-Z0-9_-]/', '_', $pasien->nama) }}";
    var cleanNoRm = "{{ preg_replace('/[^a-zA-Z0-9_-]/', '_', $pasien->no_rm) }}";
    var cleanDate = "{{ $rekam->tgl_rekam ?: date('Y-m-d') }}";
    var opt = {
        margin:       [10, 12, 12, 12],
        filename:     'Catatan_SOAP_' + cleanNoRm + '_' + cleanName + '_' + cleanDate + '.pdf',
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
            avoid: ['tr', 'tbody tr', '.soap-section', '.sign-area', '.no-break', '.print-block']
        }
    };

    html2pdf().set(opt).from(element).save().then(function() {
        if (btnDownload) {
            btnDownload.innerHTML = originalText;
            btnDownload.disabled = false;
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
            window.print();
        }, 500);
    }
});
</script>

</body>
</html>

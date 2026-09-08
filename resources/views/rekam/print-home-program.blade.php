<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Latihan Rumahan (Home Program) - {{ $pasien->nama }} (RM# {{ $pasien->no_rm }})</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* Format Cetak Ramah Keluarga & Dokumen Resmi Dinas Sosial */
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 15mm 15mm;
        }

        body {
            background-color: #e2e8f0;
            color: #000000;
            font-family: 'Times New Roman', Times, serif, 'Segoe UI', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
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
            font-size: 10.5pt;
            font-style: italic;
            margin-bottom: 16px;
            color: #334155;
        }

        /* Tabel Identitas */
        .table-identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10.5pt;
        }
        .table-identitas td {
            padding: 4px 8px;
            vertical-align: top;
            border: 1px solid #94a3b8;
        }
        .table-identitas .label-col {
            width: 24%;
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .table-identitas .val-col {
            width: 26%;
        }

        /* Program Box */
        .program-card {
            border: 2px solid #000000;
            border-radius: 4px;
            margin-bottom: 16px;
            page-break-inside: avoid;
            background: #ffffff;
        }
        .program-card-header {
            background-color: #e2e8f0;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
            border-bottom: 2px solid #000000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .program-card-body {
            padding: 14px 16px;
            font-size: 11pt;
            line-height: 1.6;
        }

        /* Tips Box */
        .tips-box {
            border: 1px dashed #64748b;
            background: #f8fafc;
            padding: 10px 14px;
            border-radius: 4px;
            margin-bottom: 16px;
            page-break-inside: avoid;
            font-size: 10pt;
        }
        .tips-box-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
            color: #0f172a;
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
        .no-break, .print-block, .sign-area, .kop-table, .program-card, .tips-box {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

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
            .program-card-header {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .table-identitas .label-col {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .tips-box {
                background-color: #f8fafc !important;
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
            <span class="badge badge-success mr-2" style="font-size: 12px; padding: 6px 10px; background: #10b981; color: #fff;">
                <i class="fa-solid fa-house-user mr-1"></i> Home Program
            </span>
            <strong style="color: #1e293b; font-size: 13.5px;">{{ $pasien->nama }}</strong>
            <span class="text-muted ml-1" style="font-size: 12px;">({{ $pasien->no_rm }}) &bull; Sesi: {{ $rekam->tgl_rekam }}</span>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
            <button type="button" onclick="triggerPrintDialog()" class="btn btn-sm btn-dark font-w700" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px; background: #1e293b; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.15); color: #fff;">
                <i class="fa-solid fa-print mr-1"></i> Cetak / Simpan PDF
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-success font-w700 text-white" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px; background: #10b981; border: none; box-shadow: 0 2px 6px rgba(16,185,129,0.25);">
                <i class="fa-solid fa-download mr-1"></i> Unduh File PDF
            </button>
            <a href="{{ route('rekam.soap.print', $rekam->id) }}" class="btn btn-sm btn-primary font-w600 text-white" style="padding: 7px 14px; font-size: 12.5px; border-radius: 6px; background: #2563eb; border: none;" title="Cetak Lembar SOAP Lengkap">
                <i class="fa-solid fa-file-medical mr-1"></i> Cetak SOAP Lengkap
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
    <div class="doc-title">LEMBAR REKOMENDASI & PANDUAN LATIHAN RUMAHAN (HOME PROGRAM)</div>
    <div class="doc-subtitle">Panduan Terapi Mandiri dan Dukungan Stimulasi Keluarga untuk Penerima Manfaat</div>

    <!-- TABEL IDENTITAS PENERIMA MANFAAT -->
    <table class="table-identitas no-break">
        <tr>
            <td class="label-col">Nama Penerima Manfaat</td>
            <td class="val-col"><strong>{{ $pasien->nama }}</strong></td>
            <td class="label-col">No. Rekam Medis</td>
            <td class="val-col"><strong>{{ $pasien->no_rm }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">TTL / Usia / JK</td>
            <td class="val-col">{{ $pasien->tmp_lahir ?: '-' }}, {{ $pasien->tgl_lahir ?: '-' }} ({{ $usiaTahun }} Thn &bull; {{ $pasien->jk ?: '-' }})</td>
            <td class="label-col">Layanan Terapi</td>
            <td class="val-col"><strong>{{ $rekam->layanan_terapi ?: ($rekam->poli ?: 'Terapi Terpadu') }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">Nama Orang Tua / Wali</td>
            <td class="val-col"><strong>{{ $pasien->nama_wali ?: '-' }}</strong> ({{ $pasien->hubungan_wali ?: 'Wali' }})</td>
            <td class="label-col">Tanggal Sesi Terapi</td>
            <td class="val-col">{{ $tglSesiFormatted }}</td>
        </tr>
        <tr>
            <td class="label-col">Terapis Pembimbing</td>
            <td class="val-col"><strong>{{ $rekam->dokter->nama ?? '-' }}</strong></td>
            <td class="label-col">Lokasi UPT</td>
            <td class="val-col">{{ $rekam->upt_lokasi ?: ($rekam->poli ?: 'Omah Terapi-KU') }}</td>
        </tr>
    </table>

    <!-- KOTAK UTAMA: PANDUAN LATIHAN RUMAHAN DARI TERAPIS -->
    <div class="program-card no-break">
        <div class="program-card-header">
            <div>
                <i class="fa-solid fa-house-user mr-1.5"></i> Instuksi & Rencana Latihan Mandiri di Rumah (Home Exercise)
            </div>
            <span style="font-size: 9.5pt; font-weight: normal; text-transform: none;">Diberikan oleh Terapis</span>
        </div>
        <div class="program-card-body">
            @if(!empty($rekam->latihan_rumahan))
                <div style="white-space: pre-line; font-size: 11pt; color: #000000;">{{ $rekam->latihan_rumahan }}</div>
            @else
                <div class="p-3 text-center text-muted">
                    <p class="mb-1 font-weight-bold">Belum ada rincian latihan khusus tertulis pada sesi ini.</p>
                    <small>Disarankan untuk melanjutkan rutinitas stimulasi mandiri, peregangan lembut, dan menjaga postur duduk/berbaring yang baik sesuai petunjuk lisan terapis.</small>
                </div>
            @endif
        </div>
    </div>

    <!-- KOTAK TAMBAHAN: FOKUS & TINDAKAN KLINIS SESI INI -->
    @if(!empty($rekam->tindakan))
        <div class="program-card no-break">
            <div class="program-card-header" style="background-color: #f1f5f9; font-size: 10pt;">
                <div>
                    <i class="fa-solid fa-clipboard-check mr-1.5"></i> Ringkasan Intervensi / Terapi di Klinik (Untuk Referensi Orang Tua)
                </div>
            </div>
            <div class="program-card-body" style="font-size: 10pt; padding: 10px 14px;">
                <div style="white-space: pre-line;">{{ $rekam->tindakan }}</div>
            </div>
        </div>
    @endif

    <!-- PETUNJUK & CATATAN PENTING UNTUK KELUARGA -->
    <div class="tips-box no-break">
        <div class="tips-box-title">
            <i class="fa-solid fa-circle-info mr-1"></i> Petunjuk & Anjuran Penting untuk Orang Tua / Wali:
        </div>
        <ol style="margin-bottom: 0; padding-left: 18px; line-height: 1.5;">
            <li><strong>Lakukan Secara Konsisten:</strong> Latihan rumahan dilakukan secara teratur (misal 1-2 kali sehari) dengan durasi singkat namun rutin agar anak tidak lelah.</li>
            <li><strong>Suasana Menyenangkan:</strong> Ciptakan suasana latihan yang santai, aman, dan penuh dorongan positif (bisa diselingi mainan favorit atau pujian).</li>
            <li><strong>Perhatikan Respon Anak:</strong> Jangan memaksakan gerakan jika anak tampak kesakitan, rewel berlebih, atau kelelahan. Berikan jeda istirahat yang cukup.</li>
            <li><strong>Catat Perkembangan & Kendala:</strong> Catat kemajuan baru atau kesulitan yang dihadapi selama di rumah untuk didiskusikan dengan terapis pada sesi berikutnya.</li>
        </ol>
    </div>

    <!-- AREA TANDA TANGAN & KOMITMEN PENDAMPINGAN -->
    <div class="sign-area no-break">
        <table class="sign-table">
            <tr>
                <td style="width: 45%;">
                    Diterima & Akan Diterapkan Oleh,<br>
                    Orang Tua / Wali Pendamping<br>
                    <div style="height: 60px;"></div>
                    <strong>( {{ $pasien->nama_wali ?: '................................................' }} )</strong><br>
                    <small>Orang Tua / Wali Penerima Manfaat</small>
                </td>
                <td style="width: 10%;"></td>
                <td style="width: 45%;">
                    Jawa Timur, {{ $tglSesiFormatted }}<br>
                    Terapis Pembimbing / Pemeriksa<br>
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
            avoid: ['tr', 'tbody tr', '.program-card', '.tips-box', '.sign-area', '.no-break', '.print-block']
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

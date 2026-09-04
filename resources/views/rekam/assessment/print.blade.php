<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Assessment - {{ $pasien->nama }} (RM# {{ $pasien->no_rm }})</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            background-color: #f1f5f9;
            color: #1e293b;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 13px;
        }

        .print-toolbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #cbd5e1;
            padding: 12px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .print-container {
            max-width: 850px;
            margin: 20px auto;
            background: #fff;
            padding: 35px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .kop-header {
            border-bottom: 2.5px solid #1e40af;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .section-title {
            background: #eff6ff;
            color: #1e40af;
            font-weight: 700;
            font-size: 13.5px;
            padding: 6px 12px;
            border-radius: 4px;
            margin-top: 18px;
            margin-bottom: 10px;
            border-left: 4px solid #2563eb;
        }

        .table-assessment {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-assessment th, .table-assessment td {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            font-size: 12.5px;
        }

        .table-assessment th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 600;
        }

        .badge-val {
            display: inline-block;
            font-weight: 600;
            color: #0f172a;
        }

        @media print {
            body {
                background: #fff !important;
                color: #000 !important;
            }
            .print-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Sticky Action Toolbar (Hanya Tampil di Layar, Tersembunyi saat Cetak) -->
<div class="print-toolbar no-print">
    <div class="container d-flex flex-wrap align-items-center justify-content-between" style="max-width: 850px; gap: 10px;">
        <div class="d-flex align-items-center">
            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 6px 10px; background: #2563eb;">
                <i class="fa-solid fa-file-pdf mr-1"></i> Asesmen
            </span>
            <strong style="color: #1e293b; font-size: 13.5px;">{{ $pasien->nama }}</strong>
            <span class="text-muted ml-1" style="font-size: 12px;">({{ $pasien->no_rm }})</span>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
            <button type="button" onclick="triggerPrintDialog()" class="btn btn-sm btn-primary font-w700" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);">
                <i class="fa-solid fa-print mr-1"></i> Cetak / Simpan PDF
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-success font-w700 text-white" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px; background: linear-gradient(135deg, #10b981, #059669); border: none; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.25);">
                <i class="fa-solid fa-download mr-1"></i> Unduh File PDF
            </button>
            <a href="{{ route('rekam.detail', $pasien->id) }}" class="btn btn-sm btn-light border font-w600" style="padding: 7px 14px; font-size: 12.5px; border-radius: 6px; color: #475569;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="print-container" id="print-area">
    <!-- Kop Header -->
    <div class="kop-header d-flex align-items-center justify-content-between">
        <div>
            <h3 style="font-weight: 800; color: #1e40af; margin: 0; font-size: 22px; letter-spacing: 0.5px;">OMAH TERAPIKU</h3>
            <p style="margin: 2px 0 0 0; font-size: 12px; color: #64748b;">
                Pusat Pelayanan Terapi & Rehabilitasi Disabilitas
            </p>
            <small style="color: #64748b; font-size: 11px;">
                Lokasi: {{ $rekam->poli }} &bull; Layanan: {{ $rekam->layanan_terapi ?: 'Terapi Terpadu' }}
            </small>
        </div>
        <div class="text-right">
            <div style="font-size: 15px; font-weight: 700; color: #1e40af;">LEMBAR ASSESSMENT KLINIS</div>
            <div style="font-size: 11.5px; color: #475569;">Tgl Asesmen: <strong>{{ $assessment->tgl_assessment ? $assessment->tgl_assessment->format('d/m/Y') : date('d/m/Y') }}</strong></div>
            <div style="font-size: 11.5px; color: #475569;">No. RM: <strong>{{ $pasien->no_rm }}</strong></div>
        </div>
    </div>

    <!-- Data Pasien -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 15px;">
        <div class="row">
            <div class="col-6">
                <table style="width: 100%; font-size: 12px;">
                    <tr>
                        <td style="width: 35%; color: #64748b;">Nama Penerima</td>
                        <td style="width: 3%;">:</td>
                        <td><strong>{{ $pasien->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">NIK</td>
                        <td>:</td>
                        <td>{{ $pasien->nik ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">TTL / Usia</td>
                        <td>:</td>
                        <td>{{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ?: '-' }} ({{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age . ' Tahun' : '-' }})</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ $pasien->jk ?: '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table style="width: 100%; font-size: 12px;">
                    <tr>
                        <td style="width: 35%; color: #64748b;">Wali / Orang Tua</td>
                        <td style="width: 3%;">:</td>
                        <td>{{ $pasien->nama_wali ? $pasien->nama_wali . ' (' . ($pasien->hubungan_wali ?: 'Wali') . ')' : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Disabilitas</td>
                        <td>:</td>
                        <td>{{ $pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada' ? $pasien->jenis_disabilitas : 'Non-Disabilitas' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">No. HP</td>
                        <td>:</td>
                        <td>{{ $pasien->no_hp ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Terapis Pemeriksa</td>
                        <td>:</td>
                        <td><strong>{{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? '-') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- 1. Kemampuan Motorik -->
    <div class="section-title">1. KEMAMPUAN MOTORIK</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Mengangkat Kepala</td>
                <td><span class="badge-val">{{ $assessment->motorik_mengangkat_kepala ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Posisi Tengkurap</td>
                <td><span class="badge-val">{{ $assessment->motorik_posisi_tengkurap ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Posisi Duduk</td>
                <td><span class="badge-val">{{ $assessment->motorik_posisi_duduk ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Merangkak</td>
                <td><span class="badge-val">{{ $assessment->motorik_merangkak ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Berlutut</td>
                <td><span class="badge-val">{{ $assessment->motorik_berlutut ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Berjalan</td>
                <td><span class="badge-val">{{ $assessment->motorik_berjalan ?: '-' }}</span></td>
            </tr>
        </tbody>
    </table>
    @if($assessment->motorik_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan Motorik: {{ $assessment->motorik_catatan }}</em>
        </div>
    @endif

    <!-- 2. GMFM-88 Terpadu: Dimensi A, B, C, D & E -->
    <div class="section-title">2. GROSS MOTOR FUNCTION MEASURE (GMFM-88)</div>
    @if(!is_null($assessment->gmfm_dimensi_a_total) || !is_null($assessment->gmfm_dimensi_b_total) || !is_null($assessment->gmfm_dimensi_c_total) || !is_null($assessment->gmfm_dimensi_d_total) || !is_null($assessment->gmfm_dimensi_e_total))
        <!-- TOTAL GMFM-88 REKAPITULASI -->
        <div style="background: #1e293b; color: white; border-radius: 4px; padding: 6px 12px; margin-bottom: 8px; font-size: 11.5px; display: flex; justify-content: space-between; align-items: center;">
            <span><strong>REKAPITULASI TOTAL GMFM-88 (88 ITEM):</strong> Skor Total: <strong>{{ $assessment->gmfm_total_score ?? 0 }} / 264</strong></span>
            <span>Rata-rata Capaian: <strong>{{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%</strong></span>
        </div>
        <!-- DIMENSI A -->
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 10px; margin-bottom: 5px; font-size: 11px;">
            <strong>DIMENSI A (BERBARING & BERGULING):</strong> &nbsp;
            Skor: <strong>{{ $assessment->gmfm_dimensi_a_total ?? 0 }} / 51</strong> ({{ number_format($assessment->gmfm_dimensi_a_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
            Interpretasi: <strong>{{ ($assessment->gmfm_dimensi_a_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_a_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}</strong>
        </div>
        <table class="table-assessment" style="font-size: 10px; margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 74%;">Item Aktivitas Gerakan (Dimensi A)</th>
                    <th style="width: 20%; text-align: center;">Skor (0-3)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $gmfm_a_items = config('gmfm.dimensions.A.items', []);
                    $g_a_scores = is_array($assessment->gmfm_dimensi_a_scores) ? $assessment->gmfm_dimensi_a_scores : [];
                @endphp
                @foreach($gmfm_a_items as $no => $item)
                    @php $scA = $g_a_scores[$no] ?? '-'; @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>
                            <span style="color: #64748b;">{{ $item['position'] }}:</span>
                            <strong>{{ $item['action'] }}</strong>
                        </td>
                        <td class="text-center font-w700">
                            {{ $scA === 'NT' ? 'NT (Tidak Diuji)' : ($scA !== null && $scA !== '' ? $scA : '-') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($assessment->gmfm_dimensi_a_catatan)
            <div style="font-size: 10.5px; color: #334155; margin-bottom: 8px;">
                <em>Catatan Dimensi A: {{ $assessment->gmfm_dimensi_a_catatan }}</em>
            </div>
        @endif

        <!-- DIMENSI B -->
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 10px; margin-bottom: 5px; margin-top: 6px; font-size: 11px;">
            <strong>DIMENSI B (DUDUK / SITTING):</strong> &nbsp;
            Skor: <strong>{{ $assessment->gmfm_dimensi_b_total ?? 0 }} / 60</strong> ({{ number_format($assessment->gmfm_dimensi_b_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
            Interpretasi: <strong>{{ ($assessment->gmfm_dimensi_b_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_b_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}</strong>
        </div>
        <table class="table-assessment" style="font-size: 10px; margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 74%;">Item Aktivitas Gerakan (Dimensi B: Duduk)</th>
                    <th style="width: 20%; text-align: center;">Skor (0-3)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $gmfm_b_items = config('gmfm.dimensions.B.items', []);
                    $g_b_scores = is_array($assessment->gmfm_dimensi_b_scores) ? $assessment->gmfm_dimensi_b_scores : [];
                @endphp
                @foreach($gmfm_b_items as $no => $item)
                    @php $scB = $g_b_scores[$no] ?? '-'; @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>
                            <span style="color: #64748b;">{{ $item['position'] }}:</span>
                            <strong>{{ $item['action'] }}</strong>
                        </td>
                        <td class="text-center font-w700">
                            {{ $scB === 'NT' ? 'NT (Tidak Diuji)' : ($scB !== null && $scB !== '' ? $scB : '-') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($assessment->gmfm_dimensi_b_catatan)
            <div style="font-size: 10.5px; color: #334155; margin-bottom: 8px;">
                <em>Catatan Dimensi B: {{ $assessment->gmfm_dimensi_b_catatan }}</em>
            </div>
        @endif

        <!-- DIMENSI C -->
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 10px; margin-bottom: 5px; margin-top: 6px; font-size: 11px;">
            <strong>DIMENSI C (MERANGKAK & BERLUTUT):</strong> &nbsp;
            Skor: <strong>{{ $assessment->gmfm_dimensi_c_total ?? 0 }} / 42</strong> ({{ number_format($assessment->gmfm_dimensi_c_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
            Interpretasi: <strong>{{ ($assessment->gmfm_dimensi_c_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_c_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}</strong>
        </div>
        <table class="table-assessment" style="font-size: 10px; margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 74%;">Item Aktivitas Gerakan (Dimensi C: Merangkak & Berlutut)</th>
                    <th style="width: 20%; text-align: center;">Skor (0-3)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $gmfm_c_items = config('gmfm.dimensions.C.items', []);
                    $g_c_scores = is_array($assessment->gmfm_dimensi_c_scores) ? $assessment->gmfm_dimensi_c_scores : [];
                @endphp
                @foreach($gmfm_c_items as $no => $item)
                    @php $scC = $g_c_scores[$no] ?? '-'; @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>
                            <span style="color: #64748b;">{{ $item['position'] }}:</span>
                            <strong>{{ $item['action'] }}</strong>
                        </td>
                        <td class="text-center font-w700">
                            {{ $scC === 'NT' ? 'NT (Tidak Diuji)' : ($scC !== null && $scC !== '' ? $scC : '-') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($assessment->gmfm_dimensi_c_catatan)
            <div style="font-size: 10.5px; color: #334155; margin-bottom: 8px;">
                <em>Catatan Dimensi C: {{ $assessment->gmfm_dimensi_c_catatan }}</em>
            </div>
        @endif

        <!-- DIMENSI D -->
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 10px; margin-bottom: 5px; margin-top: 6px; font-size: 11px;">
            <strong>DIMENSI D (BERDIRI / STANDING):</strong> &nbsp;
            Skor: <strong>{{ $assessment->gmfm_dimensi_d_total ?? 0 }} / 39</strong> ({{ number_format($assessment->gmfm_dimensi_d_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
            Interpretasi: <strong>{{ ($assessment->gmfm_dimensi_d_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_d_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}</strong>
        </div>
        <table class="table-assessment" style="font-size: 10px; margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 74%;">Item Aktivitas Gerakan (Dimensi D: Berdiri)</th>
                    <th style="width: 20%; text-align: center;">Skor (0-3)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $gmfm_d_items = config('gmfm.dimensions.D.items', []);
                    $g_d_scores = is_array($assessment->gmfm_dimensi_d_scores) ? $assessment->gmfm_dimensi_d_scores : [];
                @endphp
                @foreach($gmfm_d_items as $no => $item)
                    @php $scD = $g_d_scores[$no] ?? '-'; @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>
                            <span style="color: #64748b;">{{ $item['position'] }}:</span>
                            <strong>{{ $item['action'] }}</strong>
                        </td>
                        <td class="text-center font-w700">
                            {{ $scD === 'NT' ? 'NT (Tidak Diuji)' : ($scD !== null && $scD !== '' ? $scD : '-') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($assessment->gmfm_dimensi_d_catatan)
            <div style="font-size: 10.5px; color: #334155; margin-bottom: 8px;">
                <em>Catatan Dimensi D: {{ $assessment->gmfm_dimensi_d_catatan }}</em>
            </div>
        @endif

        <!-- DIMENSI E -->
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 10px; margin-bottom: 5px; margin-top: 6px; font-size: 11px;">
            <strong>DIMENSI E (BERJALAN, BERLARI & MELOMPAT):</strong> &nbsp;
            Skor: <strong>{{ $assessment->gmfm_dimensi_e_total ?? 0 }} / 72</strong> ({{ number_format($assessment->gmfm_dimensi_e_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
            Interpretasi: <strong>{{ ($assessment->gmfm_dimensi_e_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_e_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}</strong>
        </div>
        <table class="table-assessment" style="font-size: 10px; margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 74%;">Item Aktivitas Gerakan (Dimensi E: Berjalan, Berlari & Melompat)</th>
                    <th style="width: 20%; text-align: center;">Skor (0-3)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $gmfm_e_items = config('gmfm.dimensions.E.items', []);
                    $g_e_scores = is_array($assessment->gmfm_dimensi_e_scores) ? $assessment->gmfm_dimensi_e_scores : [];
                @endphp
                @foreach($gmfm_e_items as $no => $item)
                    @php $scE = $g_e_scores[$no] ?? '-'; @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>
                            <span style="color: #64748b;">{{ $item['position'] }}:</span>
                            <strong>{{ $item['action'] }}</strong>
                        </td>
                        <td class="text-center font-w700">
                            {{ $scE === 'NT' ? 'NT (Tidak Diuji)' : ($scE !== null && $scE !== '' ? $scE : '-') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($assessment->gmfm_dimensi_e_catatan)
            <div style="font-size: 10.5px; color: #334155; margin-bottom: 8px;">
                <em>Catatan Dimensi E: {{ $assessment->gmfm_dimensi_e_catatan }}</em>
            </div>
        @endif
    @else
        <div style="font-size: 11.5px; color: #64748b; margin-bottom: 8px; font-style: italic;">
            Item GMFM belum diuji / diisi.
        </div>
    @endif

    <!-- 3. Kemampuan Aktivitas Sehari-hari -->
    <div class="section-title">3. KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL)</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Kontak Mata</td>
                <td><span class="badge-val">{{ $assessment->adl_kontak_mata ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Bisa Duduk Tenang Saat Melakukan Aktivitas</td>
                <td><span class="badge-val">{{ $assessment->adl_duduk_tenang ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Gerakan Berulang dan Tidak Bertujuan</td>
                <td><span class="badge-val">{{ $assessment->adl_gerakan_berulang ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Merespon Saat Dipanggil Nama</td>
                <td><span class="badge-val">{{ $assessment->adl_respon_nama ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Makan</td>
                <td><span class="badge-val">{{ $assessment->adl_makan ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Mandi</td>
                <td><span class="badge-val">{{ $assessment->adl_mandi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td>Berpakaian</td>
                <td><span class="badge-val">{{ $assessment->adl_berpakaian ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">8</td>
                <td>BAK (Buang Air Kecil)</td>
                <td><span class="badge-val">{{ $assessment->adl_bak ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">9</td>
                <td>BAB (Buang Air Besar)</td>
                <td><span class="badge-val">{{ $assessment->adl_bab ?: '-' }}</span></td>
            </tr>
        </tbody>
    </table>
    @if($assessment->adl_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan ADL: {{ $assessment->adl_catatan }}</em>
        </div>
    @endif

    <!-- 3. Kemampuan Wicara -->
    <div class="section-title">3. KEMAMPUAN WICARA & KOMUNIKASI</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Kemampuan Berkomunikasi</td>
                <td><span class="badge-val">{{ $assessment->wicara_komunikasi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Kondisi Organ Bicara & Pendengaran</td>
                <td>
                    <span class="badge-val">{{ $assessment->wicara_organ ?: '-' }}</span>
                    @if($assessment->wicara_organ_keterangan)
                        <br><small class="text-muted">({{ $assessment->wicara_organ_keterangan }})</small>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Kemampuan Makan, Minum, Mengunyah & Menelan</td>
                <td>
                    <span class="badge-val">{{ $assessment->wicara_makan_menelan ?: '-' }}</span>
                    @if($assessment->wicara_makan_menelan_keterangan)
                        <br><small class="text-muted">({{ $assessment->wicara_makan_menelan_keterangan }})</small>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if($assessment->wicara_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan Wicara: {{ $assessment->wicara_catatan }}</em>
        </div>
    @endif

    <!-- 4. Status Penglihatan (Netra) -->
    <div class="section-title">4. STATUS PENGLIHATAN (ASESMEN NETRA)</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Klasifikasi Penglihatan</td>
                <td><span class="badge-val">{{ $assessment->penglihatan_klasifikasi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Onset & Sisi</td>
                <td>
                    <span class="badge-val">{{ $assessment->penglihatan_onset ?: '-' }}</span>
                    @if($assessment->penglihatan_sisi)
                        <span class="badge-val">({{ $assessment->penglihatan_sisi }})</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Usia Onset & Durasi</td>
                <td>
                    {{ $assessment->penglihatan_usia_onset ? $assessment->penglihatan_usia_onset . ' Thn' : '-' }} / 
                    {{ $assessment->penglihatan_durasi ? 'Durasi: ' . $assessment->penglihatan_durasi . ' Thn' : '-' }}
                </td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Etiologi / Diagnosis Medis</td>
                <td><span class="badge-val">{{ $assessment->penglihatan_etiologi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Progresif? & Terakhir Periksa</td>
                <td>
                    Progresif: {{ $assessment->penglihatan_progresif ?: '-' }} 
                    {{ $assessment->penglihatan_terakhir_periksa ? ' &bull; Terakhir: ' . $assessment->penglihatan_terakhir_periksa : '' }}
                </td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Visus OD & OS (Low Vision)</td>
                <td>OD: {{ $assessment->penglihatan_visus_od ?: '-' }} &bull; OS: {{ $assessment->penglihatan_visus_os ?: '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td>Persepsi Cahaya & Sisi Visual</td>
                <td>
                    Persepsi Cahaya: {{ $assessment->penglihatan_persepsi_cahaya ?: '-' }} &bull; 
                    Preferensi: {{ $assessment->penglihatan_preferensi_sisi ?: '-' }}
                </td>
            </tr>
            <tr>
                <td class="text-center">8</td>
                <td>Alat Bantu yang Digunakan</td>
                <td>
                    @if(is_array($assessment->penglihatan_alat_bantu) && count($assessment->penglihatan_alat_bantu) > 0)
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach($assessment->penglihatan_alat_bantu as $alat)
                                <li>
                                    {{ $alat }}
                                    @if($alat == 'Tongkat putih' && $assessment->penglihatan_teknik_tongkat)
                                        (Teknik: {{ $assessment->penglihatan_teknik_tongkat }})
                                    @elseif($alat == 'Lainnya' && $assessment->penglihatan_alat_bantu_lainnya)
                                        ({{ $assessment->penglihatan_alat_bantu_lainnya }})
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span>-</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if($assessment->penglihatan_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan Penglihatan: {{ $assessment->penglihatan_catatan }}</em>
        </div>
    @endif

    <!-- 5. Intensitas Nyeri & Body Chart -->
    <div class="section-title">5. INTENSITAS NYERI & BODY CHART</div>
    <div class="row mb-3" style="page-break-inside: avoid;">
        <div class="col-7">
            <table class="table-assessment">
                <thead>
                    <tr>
                        <th style="width: 45%;">Indikator Nyeri</th>
                        <th style="width: 55%;">Hasil Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Skor Total Nyeri (VAS)</strong></td>
                        <td>
                            @if($assessment->nyeri_skor_total !== null)
                                <span class="badge-val">
                                    {{ $assessment->nyeri_skor_total }} / 10
                                    @if($assessment->nyeri_skor_total == 0) (Tidak Nyeri)
                                    @elseif($assessment->nyeri_skor_total <= 3) (Nyeri Ringan)
                                    @elseif($assessment->nyeri_skor_total <= 6) (Nyeri Sedang)
                                    @elseif($assessment->nyeri_skor_total <= 9) (Nyeri Berat)
                                    @elseif($assessment->nyeri_skor_total == 10) (Sangat Hebat)
                                    @endif
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Saat Istirahat</td>
                        <td>{{ $assessment->nyeri_saat_istirahat !== null ? $assessment->nyeri_saat_istirahat . ' / 10' : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Saat Aktivitas</td>
                        <td>{{ $assessment->nyeri_saat_aktivitas !== null ? $assessment->nyeri_saat_aktivitas . ' / 10' : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Sifat Nyeri</td>
                        <td>
                            @if(is_array($assessment->nyeri_sifat) && count($assessment->nyeri_sifat) > 0)
                                {{ implode(', ', array_map(function($s) use ($assessment) {
                                    return $s == 'Lainnya' && $assessment->nyeri_sifat_lainnya ? 'Lainnya (' . $assessment->nyeri_sifat_lainnya . ')' : $s;
                                }, $assessment->nyeri_sifat)) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Deskripsi Area Keluhan</td>
                        <td>{{ $assessment->nyeri_lokasi_keluhan ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>
            @if($assessment->nyeri_catatan)
                <div style="font-size: 11.5px; color: #334155; margin-top: 4px;">
                    <em>Catatan Nyeri: {{ $assessment->nyeri_catatan }}</em>
                </div>
            @endif
        </div>
        <div class="col-5 text-center">
            <div style="border: 1px solid #cbd5e1; border-radius: 4px; padding: 6px; background: #fafafa;">
                <div style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px;">PETA LOKASI KELUHAN (BODY CHART)</div>
                @if($assessment->nyeri_body_chart)
                    <img src="{{ $assessment->nyeri_body_chart }}" alt="Body Chart" style="max-height: 170px; max-width: 100%;">
                @else
                    <img src="{{ asset('images/body.png') }}" alt="Body Chart" style="max-height: 170px; max-width: 100%; opacity: 0.6;">
                @endif
                <div style="font-size: 9.5px; color: #64748b; margin-top: 3px;">
                    Simbol: <strong>~</strong> Nyeri | <strong>#</strong> Kesemutan | <strong>-</strong> Kelemahan | <strong>/</strong> Bengkak | <strong>X</strong> Kaku
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT) -->
    @php
        $rom_data = is_array($assessment->rom_mmt_data) ? $assessment->rom_mmt_data : [];
        $rom_labels = config('assessment.rom_mmt.rows', []);
    @endphp
    <div class="section-title">6. LINGKUP GERAK SENDI (ROM) & KEKUATAN OTOT (MMT)</div>
    <table class="table-assessment" style="font-size: 11px;">
        <thead>
            <tr>
                <th style="text-align: left; width: 24%;">Gerakan / Sendi</th>
                <th style="width: 10%; text-align: center;">Fleksi</th>
                <th style="width: 10%; text-align: center;">Ekstensi</th>
                <th style="width: 9%; text-align: center;">Abd</th>
                <th style="width: 9%; text-align: center;">Add</th>
                <th style="width: 9%; text-align: center;">IR</th>
                <th style="width: 9%; text-align: center;">ER</th>
                <th style="width: 10%; text-align: center;">Lainnya</th>
                <th style="width: 10%; text-align: center;">MMT (0-5)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rom_labels as $key => $lbl)
                @php $item = $rom_data[$key] ?? []; @endphp
                <tr>
                    <td><strong>{{ $key === 'custom' && !empty($item['nama']) ? 'Sendi: ' . $item['nama'] : $lbl }}</strong></td>
                    <td class="text-center">{{ $item['fleksi'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['ekstensi'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['abd'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['add'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['ir'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['er'] ?? '-' }}</td>
                    <td>{{ $item['lainnya'] ?? '-' }}</td>
                    <td class="text-center"><strong>{{ isset($item['mmt']) && $item['mmt'] !== '' ? 'Nilai ' . $item['mmt'] : '-' }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($assessment->rom_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan ROM & MMT: {{ $assessment->rom_catatan }}</em>
        </div>
    @endif

    <!-- 7. Pemeriksaan Neurologis -->
    <div class="section-title">7. PEMERIKSAAN NEUROLOGIS (SISTEM SARAF)</div>
    <table class="table-assessment" style="margin-bottom: 8px;">
        <thead>
            <tr>
                <th style="width: 25%;">Indikator Neurologis</th>
                <th style="width: 75%;">Hasil Pemeriksaan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Sensasi</strong></td>
                <td>
                    {{ $assessment->neuro_sensasi ?: '-' }}
                    @if($assessment->neuro_sensasi_area)
                        &bull; <em>Area: {{ $assessment->neuro_sensasi_area }}</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Tonus Otot</strong></td>
                <td>{{ $assessment->neuro_tonus_otot ?: '-' }}</td>
            </tr>
            <tr>
                <td><strong>Refleks Tendon (D/S)</strong></td>
                <td>
                    Bisep: <strong>{{ $assessment->neuro_refleks_bisep_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_bisep_s ?: '-' }}</strong> &bull;
                    Trisep: <strong>{{ $assessment->neuro_refleks_trisep_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_trisep_s ?: '-' }}</strong> &bull;
                    Patela: <strong>{{ $assessment->neuro_refleks_patela_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_patela_s ?: '-' }}</strong> &bull;
                    Achilles: <strong>{{ $assessment->neuro_refleks_achilles_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_achilles_s ?: '-' }}</strong>
                    <span style="font-size: 10px; color: #64748b;">(D: Kanan / S: Kiri)</span>
                </td>
            </tr>
            <tr>
                <td><strong>Tes Koordinasi</strong></td>
                <td>
                    @if(is_array($assessment->neuro_koordinasi) && count($assessment->neuro_koordinasi) > 0)
                        {{ implode(', ', array_map(function($k) use ($assessment) {
                            return $k == 'Lainnya' && $assessment->neuro_koordinasi_lainnya ? 'Lainnya (' . $assessment->neuro_koordinasi_lainnya . ')' : $k;
                        }, $assessment->neuro_koordinasi)) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if($assessment->neuro_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Neurologis: {{ $assessment->neuro_catatan }}</em>
        </div>
    @endif

    <!-- 8. Pemeriksaan Postur & Keseimbangan -->
    <div class="section-title">8. PEMERIKSAAN POSTUR & KESEIMBANGAN</div>
    <div class="row mb-2">
        <div class="col-5">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th>Temuan Postur (Observasi / Palpasi)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if(is_array($assessment->postur_temuan) && count($assessment->postur_temuan) > 0)
                                <ul style="margin: 0; padding-left: 16px;">
                                    @foreach($assessment->postur_temuan as $pt)
                                        <li>{{ $pt }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>- Tidak ada kelainan postur khusus</span>
                            @endif
                            <div style="margin-top: 4px; border-top: 1px dashed #e2e8f0; padding-top: 3px;">
                                <strong>Postur Tangan Tongkat:</strong> {{ $assessment->postur_tangan_tongkat ?: '-' }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-7">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th>Instrumen Keseimbangan</th>
                        <th style="width: 25%; text-align: center;">Skor / Waktu</th>
                        <th style="width: 35%;">Nilai Normal / Cut-off</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Berg Balance Scale (BBS)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_bbs_skor !== null ? $assessment->keseimbangan_bbs_skor . '/56' : '-' }}</strong></td>
                        <td>&lt; 45 (Risiko jatuh tinggi)</td>
                    </tr>
                    <tr>
                        <td>Timed Up and Go (TUG)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_tug_detik ? $assessment->keseimbangan_tug_detik . 's' : '-' }}</strong></td>
                        <td>&gt; 13,5s (Risiko jatuh)</td>
                    </tr>
                    <tr>
                        <td>Romberg Test (Mata Tertutup)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_romberg ?: '-' }}</strong></td>
                        <td>Positif (Defisit propriosepsi)</td>
                    </tr>
                    <tr>
                        <td>One-Leg Stance (OLS)</td>
                        <td class="text-center">
                            D: {{ $assessment->keseimbangan_ols_kanan ? $assessment->keseimbangan_ols_kanan . 's' : '-' }} &bull;
                            S: {{ $assessment->keseimbangan_ols_kiri ? $assessment->keseimbangan_ols_kiri . 's' : '-' }}
                        </td>
                        <td>&lt; 5s (Risiko jatuh)</td>
                    </tr>
                    <tr>
                        <td>Dual-Task TUG</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_dual_task_tug ? $assessment->keseimbangan_dual_task_tug . 's' : '-' }}</strong></td>
                        <td>Selisih &gt; 4,5s dari TUG</td>
                    </tr>
                    <tr>
                        <td>Falls Efficacy Scale (FES-I)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_fesi_skor !== null ? $assessment->keseimbangan_fesi_skor . '/64' : '-' }}</strong></td>
                        <td>&gt; 28 (Ketakutan jatuh tinggi)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if($assessment->postur_keseimbangan_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Keseimbangan & Kompensasi: {{ $assessment->postur_keseimbangan_catatan }}</em>
        </div>
    @endif

    <!-- 9. Pemeriksaan Gaya Berjalan (Gait) -->
    <div class="section-title">9. PEMERIKSAAN GAYA BERJALAN (GAIT)</div>
    <div class="row mb-2">
        <div class="col-6">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th>Karakteristik Pola Berjalan (Gait)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if(is_array($assessment->gait_karakteristik) && count($assessment->gait_karakteristik) > 0)
                                <ul style="margin: 0; padding-left: 16px;">
                                    @foreach($assessment->gait_karakteristik as $gk)
                                        <li>{{ $gk }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>- Pola berjalan dalam batas normal</span>
                            @endif
                            <div style="margin-top: 4px; border-top: 1px dashed #e2e8f0; padding-top: 3px;">
                                <strong>Deteksi Tekstur Lantai:</strong> {{ $assessment->gait_deteksi_lantai ?: '-' }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">10-Meter Walk Test (10MWT)</th>
                    </tr>
                    <tr>
                        <th style="width: 33%; text-align: center;">Kecepatan Nyaman</th>
                        <th style="width: 33%; text-align: center;">Kecepatan Cepat</th>
                        <th style="width: 34%; text-align: center;">Jumlah Langkah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"><strong>{{ $assessment->gait_10mwt_kecepatan_nyaman ? $assessment->gait_10mwt_kecepatan_nyaman . ' m/s' : '-' }}</strong></td>
                        <td class="text-center"><strong>{{ $assessment->gait_10mwt_kecepatan_cepat ? $assessment->gait_10mwt_kecepatan_cepat . ' m/s' : '-' }}</strong></td>
                        <td class="text-center"><strong>{{ $assessment->gait_10mwt_jumlah_langkah ? $assessment->gait_10mwt_jumlah_langkah . ' langkah' : '-' }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if($assessment->gait_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Pola Berjalan: {{ $assessment->gait_catatan }}</em>
        </div>
    @endif

    <!-- 10. Pemeriksaan Sensoris, Propriosepsi & Vestibular -->
    <div class="section-title">10. PEMERIKSAAN SENSORIS, PROPRIOSEPSI & VESTIBULAR</div>
    <div class="row mb-2">
        <div class="col-6">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Pemeriksaan Sensoris & Propriosepsi</th>
                    </tr>
                    <tr>
                        <th style="width: 38%;">Sensasi</th>
                        <th style="width: 35%;">Parameter</th>
                        <th style="width: 27%; text-align: center;">Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: middle;">Sensasi Taktil</td>
                        <td>Raba Halus</td>
                        <td class="text-center"><strong>{{ $assessment->sensoris_taktil_raba_halus ?: '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Pinprick</td>
                        <td class="text-center"><strong>{{ $assessment->sensoris_taktil_pinprick ?: '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Suhu</td>
                        <td class="text-center"><strong>{{ $assessment->sensoris_taktil_suhu ?: '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: middle;">Propriosepsi & Kinesthesia</td>
                        <td>Posisi Sendi</td>
                        <td class="text-center"><strong>{{ $assessment->sensoris_posisi_sendi ?: '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Vibrasi</td>
                        <td class="text-center"><strong>{{ $assessment->sensoris_vibrasi ?: '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Kinesthesia Jari</td>
                        <td class="text-center"><strong>{{ $assessment->sensoris_kinesthesia_jari ?: '-' }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Skrining Vestibular Dasar</th>
                    </tr>
                    <tr>
                        <th style="width: 45%;">Tes / Keluhan</th>
                        <th style="width: 25%; text-align: center;">Hasil</th>
                        <th style="width: 30%;">Interpretasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Head Impulse Test (HIT)</td>
                        <td class="text-center"><strong>{{ $assessment->vestibular_hit ?: '-' }}</strong></td>
                        <td>{{ $assessment->vestibular_hit == 'Abnormal' ? 'Disfungsi kanal semisirkular' : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Dix-Hallpike Test</td>
                        <td class="text-center"><strong>{{ $assessment->vestibular_dix_hallpike ?: '-' }}</strong></td>
                        <td>{{ $assessment->vestibular_dix_hallpike == 'Positif' ? 'BPPV (Kanalit)' : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Pusing Saat Bergerak</td>
                        <td class="text-center"><strong>{{ $assessment->vestibular_keluhan_pusing ?: '-' }}</strong></td>
                        <td>{{ $assessment->vestibular_keluhan_pusing == 'Ya' ? 'Sensasi vertigo' : '-' }}</td>
                    </tr>
                </tbody>
            </table>

            @if($assessment->sensoris_defisit_lokasi)
                <div style="font-size: 11px; border: 1px dashed #cbd5e1; padding: 5px 8px; border-radius: 4px; background: #fafcff; margin-bottom: 6px;">
                    <strong>Lokasi Defisit Sensoris:</strong> {{ $assessment->sensoris_defisit_lokasi }}
                </div>
            @endif
        </div>
    </div>
    @if($assessment->sensoris_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Sensoris & Vestibular: {{ $assessment->sensoris_catatan }}</em>
        </div>
    @endif

    <!-- 11. Faktor Psikososial & Kontekstual -->
    <div class="section-title">11. FAKTOR PSIKOSOSIAL & KONTEKSTUAL</div>
    <table class="table-assessment" style="font-size: 11px; margin-bottom: 8px;">
        <tbody>
            <tr>
                <td style="width: 28%; font-weight: 600;">Pekerjaan / Hobi Terdampak</td>
                <td style="width: 2%;">:</td>
                <td>{{ $assessment->psikososial_pekerjaan_hobi ?: '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: 600;">Faktor Psikologis</td>
                <td>:</td>
                <td><strong>{{ $assessment->psikososial_faktor_psikologis ?: '-' }}</strong></td>
            </tr>
            <tr>
                <td style="font-weight: 600;">Dukungan Sosial</td>
                <td>:</td>
                <td><strong>{{ $assessment->psikososial_dukungan_sosial ?: '-' }}</strong></td>
            </tr>
            <tr>
                <td style="font-weight: 600;">Harapan / Ekspektasi Pasien</td>
                <td>:</td>
                <td>{{ $assessment->psikososial_harapan_pasien ?: '-' }}</td>
            </tr>
        </tbody>
    </table>
    @if($assessment->psikososial_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Psikososial: {{ $assessment->psikososial_catatan }}</em>
        </div>
    @endif

    <!-- 12. Perencanaan Terapi -->
    <div class="section-title">12. PERENCANAAN TERAPI & PROGRAM INTERVENSI</div>
    <table class="table-assessment" style="font-size: 11px; margin-bottom: 8px;">
        <thead>
            <tr>
                <th style="width: 25%;">Kategori Terapi</th>
                <th style="width: 75%;">Teknik & Intervensi Terpilih</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: 600;">Modalitas Fisik</td>
                <td>
                    @if(is_array($assessment->rencana_modalitas_fisik) && count($assessment->rencana_modalitas_fisik) > 0)
                        {{ implode(', ', $assessment->rencana_modalitas_fisik) }}
                    @else
                        -
                    @endif
                    @if($assessment->rencana_modalitas_lainnya)
                        <em>(Lainnya: {{ $assessment->rencana_modalitas_lainnya }})</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-weight: 600;">Manual Terapi</td>
                <td>
                    @if(is_array($assessment->rencana_manual_terapi) && count($assessment->rencana_manual_terapi) > 0)
                        {{ implode(', ', $assessment->rencana_manual_terapi) }}
                    @else
                        -
                    @endif
                    @if($assessment->rencana_manual_lainnya)
                        <em>(Lainnya: {{ $assessment->rencana_manual_lainnya }})</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-weight: 600;">Latihan Terapi</td>
                <td>
                    @if(is_array($assessment->rencana_latihan_terapi) && count($assessment->rencana_latihan_terapi) > 0)
                        {{ implode(', ', $assessment->rencana_latihan_terapi) }}
                    @else
                        -
                    @endif
                    @if($assessment->rencana_latihan_lainnya)
                        <em>(Lainnya: {{ $assessment->rencana_latihan_lainnya }})</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-weight: 600;">Edukasi & Konseling</td>
                <td>
                    @if(is_array($assessment->rencana_edukasi_konseling) && count($assessment->rencana_edukasi_konseling) > 0)
                        {{ implode(', ', array_filter($assessment->rencana_edukasi_konseling, fn($x) => $x !== 'Lainnya')) }}
                    @else
                        -
                    @endif
                    @if($assessment->rencana_edukasi_lainnya)
                        <em>(Lainnya: {{ $assessment->rencana_edukasi_lainnya }})</em>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table-assessment text-center" style="font-size: 11px; margin-bottom: 8px;">
        <thead>
            <tr>
                <th style="width: 25%;">Frekuensi Terapi</th>
                <th style="width: 25%;">Durasi per Sesi</th>
                <th style="width: 25%;">Estimasi Total Sesi</th>
                <th style="width: 25%;">Re-assessment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>{{ $assessment->rencana_dosis_frekuensi ? $assessment->rencana_dosis_frekuensi . ' x/minggu' : '-' }}</strong></td>
                <td><strong>{{ $assessment->rencana_dosis_durasi ? $assessment->rencana_dosis_durasi . ' Menit' : '-' }}</strong></td>
                <td><strong>{{ $assessment->rencana_dosis_total_sesi ?: '-' }}</strong></td>
                <td><strong>{{ $assessment->rencana_dosis_reassessment ?: '-' }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- 14. Kesimpulan & Rekomendasi Terapi -->
    <div class="section-title">14. KESIMPULAN & EVALUASI KLINIS</div>
    <div style="border: 1px solid #cbd5e1; border-radius: 4px; padding: 8px 12px; margin-bottom: 12px; font-size: 12.5px;">
        <div style="margin-bottom: 6px;">
            <strong>Kesimpulan & Evaluasi Klinis:</strong>
            <p style="margin: 3px 0 0 0; color: #334155;">{{ $assessment->kesimpulan ?: '-' }}</p>
        </div>
        <div style="border-top: 1px dashed #e2e8f0; padding-top: 6px;">
            <strong>Rencana Terapi Lanjutan & Target:</strong>
            <p style="margin: 3px 0 0 0; color: #334155;">{{ $assessment->rencana_terapi ?: '-' }}</p>
        </div>
    </div>

    <!-- 15. Skala Denver (DDST II) -->
    <div class="section-title">15. SKALA PERKEMBANGAN DENVER II (DDST II)</div>
    @php
        $has_denver_print = !is_null($assessment->denver_pass_count) || !is_null($assessment->denver_fail_count) || !empty($assessment->denver_data);
    @endphp
    @if($has_denver_print)
        <!-- Denver Summary Box -->
        <div style="background: #1e293b; color: white; border-radius: 4px; padding: 6px 12px; margin-bottom: 8px; font-size: 11px; display: flex; justify-content: space-between; align-items: center;">
            <span><strong>STATUS SKRINING DDST II:</strong> {{ $assessment->denver_kesimpulan ?: 'Tercatat' }}</span>
            <span>Pass (P): <strong>{{ $assessment->denver_pass_count ?? 0 }}</strong> &nbsp;|&nbsp; Fail (F): <strong>{{ $assessment->denver_fail_count ?? 0 }}</strong> &nbsp;|&nbsp; Refusal (R): <strong>{{ $assessment->denver_refusal_count ?? 0 }}</strong> &nbsp;|&nbsp; No Opp (NO): <strong>{{ $assessment->denver_no_count ?? 0 }}</strong></span>
        </div>

        @php
            $denver_print_data = is_array($assessment->denver_data) ? $assessment->denver_data : [];
            $denver_print_sectors = config('denver.sectors', []);
        @endphp

        <table class="table-assessment" style="font-size: 10.5px; margin-bottom: 8px;">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 38%;">Nama Task Perkembangan</th>
                    <th style="width: 14%; text-align: center;">Rentang Usia</th>
                    <th style="width: 16%; text-align: center;">Hasil Penilaian</th>
                    <th style="width: 26%;">Catatan Terapis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($denver_print_sectors as $sec)
                    <tr style="background: #f1f5f9;">
                        <td colspan="5" style="font-weight: 700; color: #1e293b; font-size: 11px;">
                            {{ $sec['title'] }}
                        </td>
                    </tr>
                    @foreach($sec['tasks'] as $tKey => $task)
                        @php
                            $pScore = $denver_print_data[$tKey]['score'] ?? '-';
                            $pNote = $denver_print_data[$tKey]['catatan'] ?? '';
                        @endphp
                        <tr>
                            <td class="text-center">{{ $task['no'] }}</td>
                            <td><strong>{{ $task['name'] }}</strong></td>
                            <td class="text-center">{{ $task['age'] }}</td>
                            <td class="text-center font-w700">
                                @if($pScore === 'P')
                                    <span style="color: #16a34a;">Pass (P)</span>
                                @elseif($pScore === 'F')
                                    <span style="color: #dc2626;">Fail (F)</span>
                                @elseif($pScore === 'R')
                                    <span style="color: #d97706;">Refusal (R)</span>
                                @elseif($pScore === 'NO')
                                    <span style="color: #64748b;">No Opp (NO)</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $pNote ?: '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @if($assessment->denver_catatan)
            <div style="font-size: 10.5px; color: #334155; margin-bottom: 10px;">
                <em>Catatan Observasi Skala Denver: {{ $assessment->denver_catatan }}</em>
            </div>
        @endif
    @else
        <div style="font-size: 11px; color: #64748b; margin-bottom: 8px; font-style: italic;">
            Skala Denver (DDST II) belum diuji / diisi.
        </div>
    @endif

    <!-- Tanda Tangan Section -->
    <div class="row mt-4 pt-2" style="page-break-inside: avoid;">
        <div class="col-6"></div>
        <div class="col-6 text-center">
            <div style="font-size: 12px; color: #475569;">
                {{ $rekam->poli ?: 'Omah Terapiku' }}, {{ date('d F Y') }}
            </div>
            <div style="font-size: 12.5px; font-weight: 600; margin-top: 4px;">Terapis / Tenaga Medis Pemeriksa,</div>
            <div style="height: 65px;"></div>
            <div style="font-weight: 700; text-decoration: underline; font-size: 13px;">
                {{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? 'Terapis Omah Terapiku') }}
            </div>
            @if(isset($assessment->dokter->nip) || (isset($rekam->dokter) && $rekam->dokter->nip))
                <div style="font-size: 11.5px; color: #64748b;">
                    NIP: {{ $assessment->dokter->nip ?? $rekam->dokter->nip }}
                </div>
            @endif
        </div>
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

    var opt = {
        margin:       [8, 8, 8, 8],
        filename:     'Lembar-Assessment-{{ Str::slug($pasien->nama) }}-{{ $pasien->no_rm }}.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true, logging: false },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
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
        console.error('Error generating PDF:', err);
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = origHtml;
        }
        // Fallback to window.print() if html2pdf fails
        window.print();
    });
}

// Auto-trigger on page load
window.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);
    var downloadMode = urlParams.get('download');
    var noPrint = urlParams.get('noprint');

    if (downloadMode === 'pdf' || downloadMode === '1') {
        // Otomatis download file PDF ke komputer
        setTimeout(function() {
            downloadPDF();
        }, 500);
    } else if (noPrint !== '1') {
        // Otomatis buka dialog Cetak / Simpan sebagai PDF browser
        setTimeout(function() {
            triggerPrintDialog();
        }, 400);
    }
});
</script>

</body>
</html>

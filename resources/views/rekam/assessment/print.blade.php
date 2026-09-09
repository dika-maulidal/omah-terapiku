<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Asesmen Klinis - {{ $pasien->nama }} (RM# {{ $pasien->no_rm }})</title>
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

        /* Tabel Penilaian Klinis */
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
        .table-assessment .text-center {
            text-align: center;
        }
        .table-assessment .text-right {
            text-align: right;
        }

        /* Rekapitulasi & Box Grayscale */
        .box-rekap {
            background-color: #f8f8f8;
            border: 1px solid #000000;
            border-radius: 0;
            padding: 4px 8px;
            margin-bottom: 4px;
            font-size: 8.5pt;
            color: #000000;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .box-subdimensi {
            background-color: #f2f2f2;
            border: 1px solid #000000;
            padding: 3px 6px;
            margin-bottom: 3px;
            font-size: 8.5pt;
            font-weight: bold;
            color: #000000;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            page-break-after: avoid !important;
            break-after: avoid !important;
        }

        .badge-val {
            font-weight: bold;
            color: #000000;
        }

        /* Anti-potong / Anti-crop Classes untuk Print & PDF */
        .no-break,
        .print-block,
        .sign-area,
        .kop-table,
        .header-box-table {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            break-inside: avoid-page !important;
            -webkit-column-break-inside: avoid !important;
        }

        .page-break {
            page-break-before: always !important;
            break-before: always !important;
            clear: both;
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 8.5pt;
            }
            .print-container {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            .no-print {
                display: none !important;
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
            .box-rekap, .box-subdimensi {
                background-color: #f8f8f8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            tr, .table-assessment tr, .table-assessment td, .table-assessment th {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            .no-break, .print-block, .sign-area, .kop-table, .header-box-table {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>
<body>

@php
    // Encode Logo Omah Terapi (Kiri) & Logo Dinsos Jatim (Kanan) ke Base64 untuk 100% reliable print/PDF
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

    // Helper untuk mengecek array memiliki konten bermakna
    $hasArrayContent = function($arr) {
        if (!is_array($arr) || empty($arr)) return false;
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $subk => $subv) {
                    if ($subv !== null && $subv !== '' && $subv !== '-' && $subv !== 'NT') return true;
                }
            } else {
                if ($v !== null && $v !== '' && $v !== '-' && $v !== 'NT') return true;
            }
        }
        return false;
    };

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

    // Evaluasi Pengisian Setiap Modul (1 sd 15)
    // 1. Kemampuan Motorik
    $has_m1 = !empty($assessment->motorik_mengangkat_kepala) || 
              !empty($assessment->motorik_posisi_tengkurap) || 
              !empty($assessment->motorik_posisi_duduk) || 
              !empty($assessment->motorik_merangkak) || 
              !empty($assessment->motorik_berlutut) || 
              !empty($assessment->motorik_berjalan) || 
              !empty($assessment->motorik_catatan);

    // 2. GMFM-88
    $has_gmfm_scores = $hasArrayContent($assessment->gmfm_dimensi_a_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_b_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_c_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_d_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_e_scores);
    $has_gmfm_notes = !empty($assessment->gmfm_dimensi_a_catatan) ||
                      !empty($assessment->gmfm_dimensi_b_catatan) ||
                      !empty($assessment->gmfm_dimensi_c_catatan) ||
                      !empty($assessment->gmfm_dimensi_d_catatan) ||
                      !empty($assessment->gmfm_dimensi_e_catatan);
    $has_gmfm_totals = (!empty($assessment->gmfm_total_score) && $assessment->gmfm_total_score > 0) || 
                       (!empty($assessment->gmfm_total_persen) && $assessment->gmfm_total_persen > 0) ||
                       (!empty($assessment->gmfm_dimensi_a_total) && $assessment->gmfm_dimensi_a_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_b_total) && $assessment->gmfm_dimensi_b_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_c_total) && $assessment->gmfm_dimensi_c_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_d_total) && $assessment->gmfm_dimensi_d_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_e_total) && $assessment->gmfm_dimensi_e_total > 0);
    $has_m2 = $has_gmfm_scores || $has_gmfm_notes || $has_gmfm_totals;

    // 3. ADL
    $has_m3 = !empty($assessment->adl_kontak_mata) || 
              !empty($assessment->adl_duduk_tenang) || 
              !empty($assessment->adl_gerakan_berulang) || 
              !empty($assessment->adl_respon_nama) || 
              !empty($assessment->adl_makan) || 
              !empty($assessment->adl_mandi) || 
              !empty($assessment->adl_berpakaian) || 
              !empty($assessment->adl_bak) || 
              !empty($assessment->adl_bab) || 
              !empty($assessment->adl_catatan);

    // 4. Wicara
    $has_m4 = !empty($assessment->wicara_komunikasi) || 
              !empty($assessment->wicara_organ) || 
              !empty($assessment->wicara_organ_keterangan) || 
              !empty($assessment->wicara_makan_menelan) || 
              !empty($assessment->wicara_makan_menelan_keterangan) || 
              !empty($assessment->wicara_catatan);

    // 5. Penglihatan (Netra)
    $has_m5 = !empty($assessment->penglihatan_klasifikasi) || 
              !empty($assessment->penglihatan_onset) || 
              !empty($assessment->penglihatan_sisi) || 
              !empty($assessment->penglihatan_usia_onset) || 
              !empty($assessment->penglihatan_durasi) || 
              !empty($assessment->penglihatan_etiologi) || 
              !empty($assessment->penglihatan_progresif) || 
              !empty($assessment->penglihatan_terakhir_periksa) || 
              !empty($assessment->penglihatan_visus_od) || 
              !empty($assessment->penglihatan_visus_os) || 
              !empty($assessment->penglihatan_persepsi_cahaya) || 
              !empty($assessment->penglihatan_preferensi_sisi) || 
              (!empty($assessment->penglihatan_alat_bantu) && count($assessment->penglihatan_alat_bantu) > 0) || 
              !empty($assessment->penglihatan_catatan);

    // 6. Nyeri & Body Chart
    $has_m6 = ($assessment->nyeri_skor_total !== null && $assessment->nyeri_skor_total > 0) || 
              ($assessment->nyeri_saat_istirahat !== null && $assessment->nyeri_saat_istirahat > 0) || 
              ($assessment->nyeri_saat_aktivitas !== null && $assessment->nyeri_saat_aktivitas > 0) || 
              (!empty($assessment->nyeri_sifat) && count($assessment->nyeri_sifat) > 0) || 
              !empty($assessment->nyeri_lokasi_keluhan) || 
              !empty($assessment->nyeri_body_chart) || 
              !empty($assessment->nyeri_catatan);

    // 7. ROM & MMT
    $has_m7 = !empty($assessment->rom_catatan) || $hasArrayContent($assessment->rom_mmt_data);

    // 8. Neurologis
    $has_m8 = !empty($assessment->neuro_sensasi) || 
              !empty($assessment->neuro_sensasi_area) || 
              !empty($assessment->neuro_tonus_otot) || 
              !empty($assessment->neuro_refleks_bisep_d) || 
              !empty($assessment->neuro_refleks_bisep_s) || 
              !empty($assessment->neuro_refleks_trisep_d) || 
              !empty($assessment->neuro_refleks_trisep_s) || 
              !empty($assessment->neuro_refleks_patela_d) || 
              !empty($assessment->neuro_refleks_patela_s) || 
              !empty($assessment->neuro_refleks_achilles_d) || 
              !empty($assessment->neuro_refleks_achilles_s) || 
              (!empty($assessment->neuro_koordinasi) && count($assessment->neuro_koordinasi) > 0) || 
              !empty($assessment->neuro_catatan);

    // 9. Postur & Keseimbangan
    $has_m9 = (!empty($assessment->postur_temuan) && count($assessment->postur_temuan) > 0) || 
              !empty($assessment->postur_tangan_tongkat) || 
              ($assessment->keseimbangan_bbs_skor !== null && $assessment->keseimbangan_bbs_skor > 0) || 
              !empty($assessment->keseimbangan_tug_detik) || 
              !empty($assessment->keseimbangan_romberg) || 
              !empty($assessment->keseimbangan_ols_kanan) || 
              !empty($assessment->keseimbangan_ols_kiri) || 
              !empty($assessment->keseimbangan_dual_task_tug) || 
              ($assessment->keseimbangan_fesi_skor !== null && $assessment->keseimbangan_fesi_skor > 0) || 
              !empty($assessment->postur_keseimbangan_catatan);

    // 10. Gaya Berjalan (Gait)
    $has_m10 = (!empty($assessment->gait_karakteristik) && count($assessment->gait_karakteristik) > 0) || 
               !empty($assessment->gait_deteksi_lantai) || 
               !empty($assessment->gait_10mwt_kecepatan_nyaman) || 
               !empty($assessment->gait_10mwt_kecepatan_cepat) || 
               !empty($assessment->gait_10mwt_jumlah_langkah) || 
               !empty($assessment->gait_catatan);

    // 11. Sensoris & Vestibular
    $has_m11 = !empty($assessment->sensoris_taktil_raba_halus) || 
               !empty($assessment->sensoris_taktil_pinprick) || 
               !empty($assessment->sensoris_taktil_suhu) || 
               !empty($assessment->sensoris_posisi_sendi) || 
               !empty($assessment->sensoris_vibrasi) || 
               !empty($assessment->sensoris_kinesthesia_jari) || 
               !empty($assessment->sensoris_defisit_lokasi) || 
               !empty($assessment->vestibular_hit) || 
               !empty($assessment->vestibular_dix_hallpike) || 
               !empty($assessment->vestibular_keluhan_pusing) || 
               !empty($assessment->sensoris_catatan);

    // 12. Psikososial
    $has_m12 = !empty($assessment->psikososial_pekerjaan_hobi) || 
               !empty($assessment->psikososial_faktor_psikologis) || 
               !empty($assessment->psikososial_dukungan_sosial) || 
               !empty($assessment->psikososial_harapan_pasien) || 
               !empty($assessment->psikososial_catatan);

    // 13. Perencanaan Terapi
    $has_m13 = (!empty($assessment->rencana_modalitas_fisik) && count($assessment->rencana_modalitas_fisik) > 0) || 
               (!empty($assessment->rencana_manual_terapi) && count($assessment->rencana_manual_terapi) > 0) || 
               (!empty($assessment->rencana_latihan_terapi) && count($assessment->rencana_latihan_terapi) > 0) || 
               (!empty($assessment->rencana_edukasi_konseling) && count($assessment->rencana_edukasi_konseling) > 0) || 
               !empty($assessment->rencana_modalitas_lainnya) || 
               !empty($assessment->rencana_manual_lainnya) || 
               !empty($assessment->rencana_latihan_lainnya) || 
               !empty($assessment->rencana_edukasi_lainnya) || 
               !empty($assessment->rencana_dosis_frekuensi) || 
               !empty($assessment->rencana_dosis_durasi) || 
               !empty($assessment->rencana_dosis_total_sesi) || 
               !empty($assessment->rencana_dosis_reassessment);

    // 14. Kesimpulan & Evaluasi
    $has_m14 = !empty($assessment->kesimpulan) || !empty($assessment->rencana_terapi);

    // 15. Skala Denver II
    $has_denver_scores = false;
    if (!empty($assessment->denver_data) && is_array($assessment->denver_data)) {
        foreach ($assessment->denver_data as $dItem) {
            if (is_array($dItem)) {
                $score = $dItem['score'] ?? null;
                $note = trim($dItem['catatan'] ?? '');
                if (!empty($score) && in_array(strtoupper($score), ['P', 'F', 'R', 'NO'])) {
                    $has_denver_scores = true;
                    break;
                }
                if (!empty($note) && $note !== '-') {
                    $has_denver_scores = true;
                    break;
                }
            }
        }
    }
    $has_denver_counts = (($assessment->denver_pass_count !== null && (int)$assessment->denver_pass_count > 0) ||
                          ($assessment->denver_fail_count !== null && (int)$assessment->denver_fail_count > 0) ||
                          ($assessment->denver_refusal_count !== null && (int)$assessment->denver_refusal_count > 0) ||
                          ($assessment->denver_no_count !== null && (int)$assessment->denver_no_count > 0));
    $valid_denver_kesimpulan = !empty($assessment->denver_kesimpulan) && !in_array($assessment->denver_kesimpulan, ['Belum Dinilai', 'Belum Diisi', '-', 'null']);
    $valid_denver_catatan = !empty(trim($assessment->denver_catatan ?? ''));

    $has_m15 = $has_denver_scores || $has_denver_counts || $valid_denver_kesimpulan || $valid_denver_catatan;

    $moduleList = [
        1  => ['id' => 1,  'name' => '1. Kemampuan Motorik', 'has' => $has_m1, 'title' => 'KEMAMPUAN MOTORIK KASAR & HALUS'],
        2  => ['id' => 2,  'name' => '2. GMFM-88', 'has' => $has_m2, 'title' => 'GROSS MOTOR FUNCTION MEASURE (GMFM-88)'],
        3  => ['id' => 3,  'name' => '3. ADL (Aktivitas Sehari-hari)', 'has' => $has_m3, 'title' => 'KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL)'],
        4  => ['id' => 4,  'name' => '4. Wicara & Komunikasi', 'has' => $has_m4, 'title' => 'KEMAMPUAN WICARA & KOMUNIKASI'],
        5  => ['id' => 5,  'name' => '5. Asesmen Netra (Penglihatan)', 'has' => $has_m5, 'title' => 'STATUS PENGLIHATAN (ASESMEN NETRA)'],
        6  => ['id' => 6,  'name' => '6. Nyeri & Body Chart', 'has' => $has_m6, 'title' => 'INTENSITAS NYERI & BODY CHART'],
        7  => ['id' => 7,  'name' => '7. ROM & MMT', 'has' => $has_m7, 'title' => 'LINGKUP GERAK SENDI (ROM) & KEKUATAN OTOT (MMT)'],
        8  => ['id' => 8,  'name' => '8. Neurologis (Saraf)', 'has' => $has_m8, 'title' => 'PEMERIKSAAN NEUROLOGIS (SISTEM SARAF)'],
        9  => ['id' => 9,  'name' => '9. Postur & Keseimbangan', 'has' => $has_m9, 'title' => 'PEMERIKSAAN POSTUR & KESEIMBANGAN'],
        10 => ['id' => 10, 'name' => '10. Gaya Berjalan (Gait)', 'has' => $has_m10, 'title' => 'PEMERIKSAAN GAYA BERJALAN (GAIT)'],
        11 => ['id' => 11, 'name' => '11. Sensoris & Vestibular', 'has' => $has_m11, 'title' => 'PEMERIKSAAN SENSORIS, PROPRIOSEPSI & VESTIBULAR'],
        12 => ['id' => 12, 'name' => '12. Psikososial & Kontekstual', 'has' => $has_m12, 'title' => 'FAKTOR PSIKOSOSIAL & KONTEKSTUAL'],
        13 => ['id' => 13, 'name' => '13. Perencanaan Intervensi', 'has' => $has_m13, 'title' => 'PERENCANAAN TERAPI & PROGRAM INTERVENSI'],
        14 => ['id' => 14, 'name' => '14. Kesimpulan Klinis', 'has' => $has_m14, 'title' => 'KESIMPULAN & EVALUASI KLINIS'],
        15 => ['id' => 15, 'name' => '15. Skala Denver II (DDST II)', 'has' => $has_m15, 'title' => 'SKALA PERKEMBANGAN DENVER II (DDST II)'],
    ];

    $filledCount = count(array_filter($moduleList, fn($m) => $m['has']));
    $serverSeqNum = 1;
@endphp

<!-- Sticky Action Toolbar (Hanya Tampil di Layar, Tersembunyi saat Cetak/Unduh) -->
<div class="print-toolbar no-print">
    <div class="container d-flex flex-wrap align-items-center justify-content-between" style="max-width: 900px; gap: 10px;">
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
            <span class="badge badge-dark" style="font-size: 12px; padding: 6px 10px; background: #334155; color: #fff;">
                <i class="fa-solid fa-file-pdf mr-1"></i> Asesmen
            </span>
            <strong style="color: #1e293b; font-size: 13.5px;">{{ $pasien->nama }}</strong>
            <span class="text-muted" style="font-size: 12px;">({{ $pasien->no_rm }})</span>
            <span class="badge badge-primary font-w600 ml-1" id="badgeFilledCount" style="background: #2563eb; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                <i class="fa-solid fa-check-circle mr-1"></i> {{ $filledCount }} dari 15 Modul Terisi
            </span>
        </div>

        <!-- Filter Mode Pengaturan Cetak -->
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
            <div class="btn-group btn-group-sm" role="group" aria-label="Mode Cetak">
                <button type="button" id="btnModeFilled" class="btn btn-primary font-w600" onclick="setPrintMode('filled')" style="font-size: 11.5px; padding: 6px 12px; border-radius: 6px 0 0 6px;">
                    <i class="fa-solid fa-filter mr-1"></i> Hanya yang Diisi ({{ $filledCount }})
                </button>
                <button type="button" id="btnModeAll" class="btn btn-outline-secondary font-w600" onclick="setPrintMode('all')" style="font-size: 11.5px; padding: 6px 12px; border-radius: 0 6px 6px 0;">
                    <i class="fa-solid fa-table-list mr-1"></i> Cetak Semua (15)
                </button>
            </div>

            <button type="button" onclick="triggerPrintDialog()" class="btn btn-sm btn-dark font-w700" style="padding: 7px 15px; font-size: 12px; border-radius: 6px; background: #1e293b; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.15); color: #fff;">
                <i class="fa-solid fa-print mr-1"></i> Cetak
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-primary font-w700 text-white" style="padding: 7px 15px; font-size: 12px; border-radius: 6px; background: #2563eb; border: none; box-shadow: 0 2px 6px rgba(37,99,235,0.25);">
                <i class="fa-solid fa-download mr-1"></i> Unduh PDF
            </button>
            <a href="{{ route('rekam.detail', $pasien->id) }}" class="btn btn-sm btn-light border font-w600" style="padding: 7px 12px; font-size: 12px; border-radius: 6px; color: #475569;">
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
                <div style="font-size: 11.5pt; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">PENGKAJIAN AWAL KLINIS</div>
                <div style="font-size: 10pt; font-weight: bold; text-transform: uppercase; margin-top: 1px;">REHABILITASI MEDIS &amp; TERAPI TERPADU</div>
                <div style="font-size: 8pt; color: #333333; margin-top: 2px;">OMAH TERAPI-KU DINAS SOSIAL PROVINSI JAWA TIMUR</div>
            </td>
            <td style="width: 42%; border: 1.5px solid #000000 !important; padding: 0; vertical-align: top; background: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-size: 8.5pt;">
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold; width: 44%;">NOMOR RM</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: 800; font-size: 9.5pt; letter-spacing: 0.5px;">: {{ $pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold;">Tgl. Asesmen</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px;">: {{ $safeFormatDate($assessment->tgl_assessment, date('d F Y')) }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; padding: 3px 6px; font-weight: bold;">Terapis / Petugas</td>
                        <td style="border: none !important; padding: 3px 6px;">: {{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? '-') }}</td>
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
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Jenis Kelamin</td>
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->jk == 'L' ? 'Laki-laki' : ($pasien->jk == 'P' ? 'Perempuan' : ($pasien->jk ?: '-')) }}</td>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Diagnosa Klinis</td>
                <td style="border: 1px solid #000000 !important;">: <strong>{{ $rekam->diagnosa ?: '-' }}</strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Alamat Domisili</td>
                <td colspan="3" style="border: 1px solid #000000 !important;">: {{ $pasien->alamat ?: '-' }} {{ $pasien->kabupaten_kota ? '— ' . $pasien->kabupaten_kota : '' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Notice jika tidak ada modul yang terisi sama sekali -->
    <div id="no-modules-notice" class="box-rekap text-center py-4 my-3" style="{{ $filledCount === 0 ? '' : 'display: none;' }}">
        <i class="fa-solid fa-file-circle-exclamation fs-24 mb-2 text-muted"></i>
        <p class="mb-0 font-weight-bold">Belum ada data modul asesmen klinis yang diisi pada sesi ini.</p>
        <small class="text-muted">Silakan isi form asesmen terlebih dahulu melalui menu Edit Assessment.</small>
    </div>

    <!-- =========================================================================
         1. KEMAMPUAN MOTORIK
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-1" data-section-id="1" data-has-data="{{ $has_m1 ? '1' : '0' }}" data-title="KEMAMPUAN MOTORIK KASAR & HALUS" style="{{ $has_m1 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m1 ? $serverSeqNum++ : '1' }}</span>. KEMAMPUAN MOTORIK KASAR & HALUS</div>
        <table class="table-assessment">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 44%;">Indikator Penilaian Motorik</th>
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
            <div style="font-size: 9pt; margin-bottom: 8px;">
                <em>Catatan Motorik: {{ $assessment->motorik_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         2. GROSS MOTOR FUNCTION MEASURE (GMFM-88)
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-2" data-section-id="2" data-has-data="{{ $has_m2 ? '1' : '0' }}" data-title="GROSS MOTOR FUNCTION MEASURE (GMFM-88)" style="{{ $has_m2 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m2 ? $serverSeqNum++ : '2' }}</span>. GROSS MOTOR FUNCTION MEASURE (GMFM-88)</div>
        @if(!is_null($assessment->gmfm_dimensi_a_total) || !is_null($assessment->gmfm_dimensi_b_total) || !is_null($assessment->gmfm_dimensi_c_total) || !is_null($assessment->gmfm_dimensi_d_total) || !is_null($assessment->gmfm_dimensi_e_total))
            <!-- REKAPITULASI TOTAL GMFM-88 -->
            <div class="box-rekap d-flex justify-content-between align-items-center">
                <span><strong>REKAPITULASI TOTAL GMFM-88 (88 ITEM):</strong> Skor Total: <strong>{{ $assessment->gmfm_total_score ?? 0 }} / 264</strong></span>
                <span>Rata-rata Capaian: <strong>{{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%</strong></span>
            </div>

            <!-- DIMENSI A -->
            <div class="box-subdimensi">
                DIMENSI A (BERBARING & BERGULING): &nbsp;
                Skor: {{ $assessment->gmfm_dimensi_a_total ?? 0 }} / 51 ({{ number_format($assessment->gmfm_dimensi_a_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
                Interpretasi: {{ ($assessment->gmfm_dimensi_a_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_a_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}
            </div>
            <table class="table-assessment" style="font-size: 8.5pt; margin-bottom: 4px;">
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
                            <td>{{ $item['position'] }}: <strong>{{ $item['action'] }}</strong></td>
                            <td class="text-center font-weight-bold">
                                {{ $scA === 'NT' ? 'NT (Tidak Diuji)' : ($scA !== null && $scA !== '' ? $scA : '-') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($assessment->gmfm_dimensi_a_catatan)
                <div style="font-size: 8.5pt; margin-bottom: 6px;">
                    <em>Catatan Dimensi A: {{ $assessment->gmfm_dimensi_a_catatan }}</em>
                </div>
            @endif

            <!-- DIMENSI B -->
            <div class="box-subdimensi" style="margin-top: 6px;">
                DIMENSI B (DUDUK / SITTING): &nbsp;
                Skor: {{ $assessment->gmfm_dimensi_b_total ?? 0 }} / 60 ({{ number_format($assessment->gmfm_dimensi_b_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
                Interpretasi: {{ ($assessment->gmfm_dimensi_b_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_b_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}
            </div>
            <table class="table-assessment" style="font-size: 8.5pt; margin-bottom: 4px;">
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
                            <td>{{ $item['position'] }}: <strong>{{ $item['action'] }}</strong></td>
                            <td class="text-center font-weight-bold">
                                {{ $scB === 'NT' ? 'NT (Tidak Diuji)' : ($scB !== null && $scB !== '' ? $scB : '-') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($assessment->gmfm_dimensi_b_catatan)
                <div style="font-size: 8.5pt; margin-bottom: 6px;">
                    <em>Catatan Dimensi B: {{ $assessment->gmfm_dimensi_b_catatan }}</em>
                </div>
            @endif

            <!-- DIMENSI C -->
            <div class="box-subdimensi" style="margin-top: 6px;">
                DIMENSI C (MERANGKAK & BERLUTUT): &nbsp;
                Skor: {{ $assessment->gmfm_dimensi_c_total ?? 0 }} / 42 ({{ number_format($assessment->gmfm_dimensi_c_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
                Interpretasi: {{ ($assessment->gmfm_dimensi_c_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_c_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}
            </div>
            <table class="table-assessment" style="font-size: 8.5pt; margin-bottom: 4px;">
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
                            <td>{{ $item['position'] }}: <strong>{{ $item['action'] }}</strong></td>
                            <td class="text-center font-weight-bold">
                                {{ $scC === 'NT' ? 'NT (Tidak Diuji)' : ($scC !== null && $scC !== '' ? $scC : '-') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($assessment->gmfm_dimensi_c_catatan)
                <div style="font-size: 8.5pt; margin-bottom: 6px;">
                    <em>Catatan Dimensi C: {{ $assessment->gmfm_dimensi_c_catatan }}</em>
                </div>
            @endif

            <!-- DIMENSI D -->
            <div class="box-subdimensi" style="margin-top: 6px;">
                DIMENSI D (BERDIRI / STANDING): &nbsp;
                Skor: {{ $assessment->gmfm_dimensi_d_total ?? 0 }} / 39 ({{ number_format($assessment->gmfm_dimensi_d_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
                Interpretasi: {{ ($assessment->gmfm_dimensi_d_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_d_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}
            </div>
            <table class="table-assessment" style="font-size: 8.5pt; margin-bottom: 4px;">
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
                            <td>{{ $item['position'] }}: <strong>{{ $item['action'] }}</strong></td>
                            <td class="text-center font-weight-bold">
                                {{ $scD === 'NT' ? 'NT (Tidak Diuji)' : ($scD !== null && $scD !== '' ? $scD : '-') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($assessment->gmfm_dimensi_d_catatan)
                <div style="font-size: 8.5pt; margin-bottom: 6px;">
                    <em>Catatan Dimensi D: {{ $assessment->gmfm_dimensi_d_catatan }}</em>
                </div>
            @endif

            <!-- DIMENSI E -->
            <div class="box-subdimensi" style="margin-top: 6px;">
                DIMENSI E (BERJALAN, BERLARI & MELOMPAT): &nbsp;
                Skor: {{ $assessment->gmfm_dimensi_e_total ?? 0 }} / 72 ({{ number_format($assessment->gmfm_dimensi_e_persen ?? 0, 1) }}%) &nbsp;|&nbsp;
                Interpretasi: {{ ($assessment->gmfm_dimensi_e_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_e_persen ?? 0) >= 50 ? 'Sedang' : 'Keterbatasan Signifikan') }}
            </div>
            <table class="table-assessment" style="font-size: 8.5pt; margin-bottom: 4px;">
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
                            <td>{{ $item['position'] }}: <strong>{{ $item['action'] }}</strong></td>
                            <td class="text-center font-weight-bold">
                                {{ $scE === 'NT' ? 'NT (Tidak Diuji)' : ($scE !== null && $scE !== '' ? $scE : '-') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($assessment->gmfm_dimensi_e_catatan)
                <div style="font-size: 8.5pt; margin-bottom: 6px;">
                    <em>Catatan Dimensi E: {{ $assessment->gmfm_dimensi_e_catatan }}</em>
                </div>
            @endif
        @else
            <div style="font-size: 9pt; color: #555; margin-bottom: 6px; font-style: italic;">
                Item GMFM belum diuji / diisi.
            </div>
        @endif
    </div>

    <!-- =========================================================================
         3. KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL)
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-3" data-section-id="3" data-has-data="{{ $has_m3 ? '1' : '0' }}" data-title="KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL)" style="{{ $has_m3 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m3 ? $serverSeqNum++ : '3' }}</span>. KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL)</div>
        <table class="table-assessment">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 44%;">Indikator Penilaian ADL</th>
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
            <div style="font-size: 9pt; margin-bottom: 8px;">
                <em>Catatan ADL: {{ $assessment->adl_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         4. KEMAMPUAN WICARA & KOMUNIKASI
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-4" data-section-id="4" data-has-data="{{ $has_m4 ? '1' : '0' }}" data-title="KEMAMPUAN WICARA & KOMUNIKASI" style="{{ $has_m4 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m4 ? $serverSeqNum++ : '4' }}</span>. KEMAMPUAN WICARA & KOMUNIKASI</div>
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
                            <br><small>({{ $assessment->wicara_organ_keterangan }})</small>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Kemampuan Makan, Minum, Mengunyah & Menelan</td>
                    <td>
                        <span class="badge-val">{{ $assessment->wicara_makan_menelan ?: '-' }}</span>
                        @if($assessment->wicara_makan_menelan_keterangan)
                            <br><small>({{ $assessment->wicara_makan_menelan_keterangan }})</small>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @if($assessment->wicara_catatan)
            <div style="font-size: 9pt; margin-bottom: 8px;">
                <em>Catatan Wicara: {{ $assessment->wicara_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         5. STATUS PENGLIHATAN (ASESMEN NETRA)
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-5" data-section-id="5" data-has-data="{{ $has_m5 ? '1' : '0' }}" data-title="STATUS PENGLIHATAN (ASESMEN NETRA)" style="{{ $has_m5 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m5 ? $serverSeqNum++ : '5' }}</span>. STATUS PENGLIHATAN (ASESMEN NETRA)</div>
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
                            {{ implode(', ', array_map(function($alat) use ($assessment) {
                                if ($alat == 'Tongkat putih' && $assessment->penglihatan_teknik_tongkat) {
                                    return 'Tongkat Putih (' . $assessment->penglihatan_teknik_tongkat . ')';
                                } elseif ($alat == 'Lainnya' && $assessment->penglihatan_alat_bantu_lainnya) {
                                    return 'Lainnya (' . $assessment->penglihatan_alat_bantu_lainnya . ')';
                                }
                                return $alat;
                            }, $assessment->penglihatan_alat_bantu)) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @if($assessment->penglihatan_catatan)
            <div style="font-size: 9pt; margin-bottom: 8px;">
                <em>Catatan Penglihatan: {{ $assessment->penglihatan_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         6. INTENSITAS NYERI & BODY CHART
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-6" data-section-id="6" data-has-data="{{ $has_m6 ? '1' : '0' }}" data-title="INTENSITAS NYERI & BODY CHART" style="{{ $has_m6 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m6 ? $serverSeqNum++ : '6' }}</span>. INTENSITAS NYERI & BODY CHART</div>
        
        <div class="row mb-2 no-break">
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
                    <div style="font-size: 8.5pt; margin-top: 3px;">
                        <em>Catatan Nyeri: {{ $assessment->nyeri_catatan }}</em>
                    </div>
                @endif
            </div>
            <div class="col-5 text-center">
                <div style="border: 1px solid #000000; padding: 6px; background: #ffffff;">
                    <div style="font-size: 8.5pt; font-weight: bold; margin-bottom: 4px;">PETA LOKASI KELUHAN (BODY CHART)</div>
                    @if($assessment->nyeri_body_chart)
                        <img src="{{ $assessment->nyeri_body_chart }}" alt="Body Chart" style="max-height: 160px; max-width: 100%;">
                    @else
                        <img src="{{ asset('images/body.png') }}" alt="Body Chart" style="max-height: 160px; max-width: 100%; opacity: 0.6;">
                    @endif
                    <div style="font-size: 8pt; margin-top: 3px;">
                        Simbol: <strong>~</strong> Nyeri | <strong>#</strong> Kesemutan | <strong>-</strong> Kelemahan | <strong>/</strong> Bengkak | <strong>X</strong> Kaku
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         7. LINGKUP GERAK SENDI (ROM) & KEKUATAN OTOT (MMT)
         ========================================================================= -->
    @php
        $rom_data = is_array($assessment->rom_mmt_data) ? $assessment->rom_mmt_data : [];
        $rom_labels = config('assessment.rom_mmt.rows', []);
    @endphp
    <div class="assessment-section-block" id="sec-block-7" data-section-id="7" data-has-data="{{ $has_m7 ? '1' : '0' }}" data-title="LINGKUP GERAK SENDI (ROM) & KEKUATAN OTOT (MMT)" style="{{ $has_m7 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m7 ? $serverSeqNum++ : '7' }}</span>. LINGKUP GERAK SENDI (ROM) & KEKUATAN OTOT (MMT)</div>
        <table class="table-assessment" style="font-size: 8.5pt;">
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
            <div style="font-size: 8.5pt; margin-bottom: 6px;">
                <em>Catatan ROM & MMT: {{ $assessment->rom_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         8. PEMERIKSAAN NEUROLOGIS (SISTEM SARAF)
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-8" data-section-id="8" data-has-data="{{ $has_m8 ? '1' : '0' }}" data-title="PEMERIKSAAN NEUROLOGIS (SISTEM SARAF)" style="{{ $has_m8 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m8 ? $serverSeqNum++ : '8' }}</span>. PEMERIKSAAN NEUROLOGIS (SISTEM SARAF)</div>
        <table class="table-assessment" style="margin-bottom: 6px;">
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
                        <span style="font-size: 8pt; color: #333;">(D: Kanan / S: Kiri)</span>
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
            <div style="font-size: 8.5pt; margin-bottom: 6px;">
                <em>Catatan Neurologis: {{ $assessment->neuro_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         9. PEMERIKSAAN POSTUR & KESEIMBANGAN
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-9" data-section-id="9" data-has-data="{{ $has_m9 ? '1' : '0' }}" data-title="PEMERIKSAAN POSTUR & KESEIMBANGAN" style="{{ $has_m9 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m9 ? $serverSeqNum++ : '9' }}</span>. PEMERIKSAAN POSTUR & KESEIMBANGAN</div>
        <div class="row mb-2 no-break">
            <div class="col-5">
                <table class="table-assessment" style="font-size: 8.5pt;">
                    <thead>
                        <tr>
                            <th>Temuan Postur (Observasi)</th>
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
                                <div style="margin-top: 4px; border-top: 1px dashed #999; padding-top: 3px;">
                                    <strong>Postur Tangan Tongkat:</strong> {{ $assessment->postur_tangan_tongkat ?: '-' }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-7">
                <table class="table-assessment" style="font-size: 8.5pt;">
                    <thead>
                        <tr>
                            <th>Instrumen Keseimbangan</th>
                            <th style="width: 20%; text-align: center;">Skor / Waktu</th>
                            <th style="width: 25%;">Cut-off</th>
                            <th style="width: 30%;">Interpretasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Berg Balance Scale (BBS)</td>
                            <td class="text-center"><strong>{{ $assessment->keseimbangan_bbs_skor !== null ? $assessment->keseimbangan_bbs_skor . '/56' : '-' }}</strong></td>
                            <td>41–56: Mandiri<br><small style="color:#64748b;">&le; 40: Bantuan/Risiko</small></td>
                            <td>
                                @if($assessment->keseimbangan_bbs_skor !== null)
                                    @if($assessment->keseimbangan_bbs_skor >= 41)
                                        <strong>Risiko Rendah (Mandiri)</strong>
                                    @elseif($assessment->keseimbangan_bbs_skor >= 21)
                                        <strong>Risiko Sedang (Bantuan)</strong>
                                    @else
                                        <strong>Risiko Jatuh Tinggi</strong>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Timed Up and Go (TUG)</td>
                            <td class="text-center"><strong>{{ $assessment->keseimbangan_tug_detik ? $assessment->keseimbangan_tug_detik . 's' : '-' }}</strong></td>
                            <td>&le; 13,5s: Normal<br><small style="color:#64748b;">&gt; 13,5s: Risiko Jatuh</small></td>
                            <td>
                                @if(!empty($assessment->keseimbangan_tug_detik))
                                    @php $tugVal = (float)str_replace(',', '.', $assessment->keseimbangan_tug_detik); @endphp
                                    @if($tugVal > 0 && $tugVal <= 13.5)
                                        <strong>Normal / Mandiri</strong>
                                    @elseif($tugVal <= 20)
                                        <strong>Risiko Jatuh</strong>
                                    @else
                                        <strong>Risiko Jatuh Tinggi</strong>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Romberg Test (Mata Tertutup)</td>
                            <td class="text-center"><strong>{{ $assessment->keseimbangan_romberg ?: '-' }}</strong></td>
                            <td>Negatif: Normal<br><small style="color:#64748b;">Positif: Defisit</small></td>
                            <td>
                                @if($assessment->keseimbangan_romberg == 'Negatif')
                                    <strong>Normal</strong>
                                @elseif($assessment->keseimbangan_romberg == 'Positif')
                                    <strong>Defisit Sensoris/Propriosepsi</strong>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>One-Leg Stance (OLS)</td>
                            <td class="text-center">
                                D: {{ $assessment->keseimbangan_ols_kanan ? $assessment->keseimbangan_ols_kanan . 's' : '-' }} &bull;
                                S: {{ $assessment->keseimbangan_ols_kiri ? $assessment->keseimbangan_ols_kiri . 's' : '-' }}
                            </td>
                            <td>&ge; 5s: Normal<br><small style="color:#64748b;">&lt; 5s: Risiko Jatuh</small></td>
                            <td>
                                @php
                                    $olsD = !empty($assessment->keseimbangan_ols_kanan) ? (float)str_replace(',', '.', $assessment->keseimbangan_ols_kanan) : null;
                                    $olsS = !empty($assessment->keseimbangan_ols_kiri) ? (float)str_replace(',', '.', $assessment->keseimbangan_ols_kiri) : null;
                                @endphp
                                @if($olsD !== null && $olsS !== null)
                                    @if($olsD >= 5 && $olsS >= 5)
                                        <strong>Normal (D & S &ge; 5s)</strong>
                                    @elseif($olsD < 5 && $olsS < 5)
                                        <strong>Risiko Jatuh (D & S &lt; 5s)</strong>
                                    @else
                                        <strong>Asimetri (Salah satu &lt; 5s)</strong>
                                    @endif
                                @elseif($olsD !== null)
                                    <strong>{{ $olsD >= 5 ? 'Normal D' : 'Risiko Jatuh D' }}</strong>
                                @elseif($olsS !== null)
                                    <strong>{{ $olsS >= 5 ? 'Normal S' : 'Risiko Jatuh S' }}</strong>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Dual-Task TUG</td>
                            <td class="text-center"><strong>{{ $assessment->keseimbangan_dual_task_tug ? $assessment->keseimbangan_dual_task_tug . 's' : '-' }}</strong></td>
                            <td>Selisih &le; 4,5s: Normal<br><small style="color:#64748b;">&gt; 4,5s: Perlu Perhatian</small></td>
                            <td>
                                @if(!empty($assessment->keseimbangan_dual_task_tug))
                                    @php
                                        $dualVal = (float)str_replace(',', '.', $assessment->keseimbangan_dual_task_tug);
                                        $baseTug = !empty($assessment->keseimbangan_tug_detik) ? (float)str_replace(',', '.', $assessment->keseimbangan_tug_detik) : null;
                                    @endphp
                                    @if($baseTug !== null && $baseTug > 0)
                                        @php $diff = $dualVal - $baseTug; @endphp
                                        <strong>{{ $diff <= 4.5 ? 'Normal (Δ ' . ($diff >= 0 ? '+' : '') . number_format($diff, 1) . 's)' : 'Perlu Perhatian (Δ +' . number_format($diff, 1) . 's)' }}</strong>
                                    @else
                                        {{ $dualVal }}s
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Falls Efficacy Scale (FES-I)</td>
                            <td class="text-center"><strong>{{ $assessment->keseimbangan_fesi_skor !== null ? $assessment->keseimbangan_fesi_skor . '/64' : '-' }}</strong></td>
                            <td>16–19: Rendah<br><small style="color:#64748b;">20–27: Sedang | &ge; 28: Tinggi</small></td>
                            <td>
                                @if($assessment->keseimbangan_fesi_skor !== null)
                                    @if($assessment->keseimbangan_fesi_skor <= 19)
                                        <strong>Ketakutan Rendah</strong>
                                    @elseif($assessment->keseimbangan_fesi_skor <= 27)
                                        <strong>Ketakutan Sedang</strong>
                                    @else
                                        <strong>Ketakutan Jatuh Tinggi</strong>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if($assessment->postur_keseimbangan_catatan)
            <div style="font-size: 8.5pt; margin-bottom: 6px;">
                <em>Catatan Keseimbangan & Kompensasi: {{ $assessment->postur_keseimbangan_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         10. PEMERIKSAAN GAYA BERJALAN (GAIT)
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-10" data-section-id="10" data-has-data="{{ $has_m10 ? '1' : '0' }}" data-title="PEMERIKSAAN GAYA BERJALAN (GAIT)" style="{{ $has_m10 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m10 ? $serverSeqNum++ : '10' }}</span>. PEMERIKSAAN GAYA BERJALAN (GAIT)</div>
        <div class="row mb-2 no-break">
            <div class="col-6">
                <table class="table-assessment" style="font-size: 8.5pt;">
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
                                <div style="margin-top: 4px; border-top: 1px dashed #999; padding-top: 3px;">
                                    <strong>Deteksi Tekstur Lantai:</strong> {{ $assessment->gait_deteksi_lantai ?: '-' }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <table class="table-assessment" style="font-size: 8.5pt;">
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
            <div style="font-size: 8.5pt; margin-bottom: 6px;">
                <em>Catatan Pola Berjalan: {{ $assessment->gait_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         11. PEMERIKSAAN SENSORIS, PROPRIOSEPSI & VESTIBULAR
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-11" data-section-id="11" data-has-data="{{ $has_m11 ? '1' : '0' }}" data-title="PEMERIKSAAN SENSORIS, PROPRIOSEPSI & VESTIBULAR" style="{{ $has_m11 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m11 ? $serverSeqNum++ : '11' }}</span>. PEMERIKSAAN SENSORIS, PROPRIOSEPSI & VESTIBULAR</div>
        <div class="row mb-2 no-break">
            <div class="col-6">
                <table class="table-assessment" style="font-size: 8.5pt;">
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
                            <td rowspan="3" style="font-weight: bold; vertical-align: middle;">Sensasi Taktil</td>
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
                            <td rowspan="3" style="font-weight: bold; vertical-align: middle;">Propriosepsi</td>
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
                <table class="table-assessment" style="font-size: 8.5pt;">
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
                    <div style="font-size: 8.5pt; border: 1px dashed #000; padding: 4px 6px; background: #fafafa; margin-bottom: 6px;">
                        <strong>Lokasi Defisit Sensoris:</strong> {{ $assessment->sensoris_defisit_lokasi }}
                    </div>
                @endif
            </div>
        </div>
        @if($assessment->sensoris_catatan)
            <div style="font-size: 8.5pt; margin-bottom: 6px;">
                <em>Catatan Sensoris & Vestibular: {{ $assessment->sensoris_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         12. FAKTOR PSIKOSOSIAL & KONTEKSTUAL
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-12" data-section-id="12" data-has-data="{{ $has_m12 ? '1' : '0' }}" data-title="FAKTOR PSIKOSOSIAL & KONTEKSTUAL" style="{{ $has_m12 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m12 ? $serverSeqNum++ : '12' }}</span>. FAKTOR PSIKOSOSIAL & KONTEKSTUAL</div>
        <table class="table-assessment" style="font-size: 9pt; margin-bottom: 6px;">
            <tbody>
                <tr>
                    <td style="width: 28%; font-weight: bold;">Pekerjaan / Aktivitas Terdampak</td>
                    <td style="width: 2%;">:</td>
                    <td>{{ $assessment->psikososial_pekerjaan_hobi ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Faktor Psikologis</td>
                    <td>:</td>
                    <td><strong>{{ $assessment->psikososial_faktor_psikologis ?: '-' }}</strong></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Dukungan Sosial & Keluarga</td>
                    <td>:</td>
                    <td><strong>{{ $assessment->psikososial_dukungan_sosial ?: '-' }}</strong></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Harapan / Ekspektasi Pasien</td>
                    <td>:</td>
                    <td>{{ $assessment->psikososial_harapan_pasien ?: '-' }}</td>
                </tr>
            </tbody>
        </table>
        @if($assessment->psikososial_catatan)
            <div style="font-size: 8.5pt; margin-bottom: 6px;">
                <em>Catatan Psikososial: {{ $assessment->psikososial_catatan }}</em>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         13. PERENCANAAN TERAPI & PROGRAM INTERVENSI
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-13" data-section-id="13" data-has-data="{{ $has_m13 ? '1' : '0' }}" data-title="PERENCANAAN TERAPI & PROGRAM INTERVENSI" style="{{ $has_m13 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m13 ? $serverSeqNum++ : '13' }}</span>. PERENCANAAN TERAPI & PROGRAM INTERVENSI</div>
        <table class="table-assessment" style="font-size: 9pt; margin-bottom: 6px;">
            <thead>
                <tr>
                    <th style="width: 25%;">Kategori Terapi</th>
                    <th style="width: 75%;">Teknik & Intervensi Terpilih</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Modalitas Fisik</td>
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
                    <td style="font-weight: bold;">Manual Terapi</td>
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
                    <td style="font-weight: bold;">Latihan Terapi</td>
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
                    <td style="font-weight: bold;">Edukasi & Konseling</td>
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

        <table class="table-assessment text-center" style="font-size: 9pt; margin-bottom: 6px;">
            <thead>
                <tr>
                    <th style="width: 25%; text-align: center;">Frekuensi Terapi</th>
                    <th style="width: 25%; text-align: center;">Durasi per Sesi</th>
                    <th style="width: 25%; text-align: center;">Estimasi Total Sesi</th>
                    <th style="width: 25%; text-align: center;">Jadwal Re-assessment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $assessment->rencana_dosis_frekuensi ? $assessment->rencana_dosis_frekuensi . ' x / minggu' : '-' }}</strong></td>
                    <td><strong>{{ $assessment->rencana_dosis_durasi ? $assessment->rencana_dosis_durasi . ' Menit' : '-' }}</strong></td>
                    <td><strong>{{ $assessment->rencana_dosis_total_sesi ?: '-' }}</strong></td>
                    <td><strong>{{ $assessment->rencana_dosis_reassessment ?: '-' }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- =========================================================================
         14. KESIMPULAN & EVALUASI KLINIS
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-14" data-section-id="14" data-has-data="{{ $has_m14 ? '1' : '0' }}" data-title="KESIMPULAN & EVALUASI KLINIS" style="{{ $has_m14 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m14 ? $serverSeqNum++ : '14' }}</span>. KESIMPULAN & EVALUASI KLINIS</div>
        <div class="no-break" style="border: 1px solid #000000; padding: 6px 10px; margin-bottom: 10px; font-size: 9.5pt;">
            <div style="margin-bottom: 4px;">
                <strong>Kesimpulan & Evaluasi Klinis:</strong>
                <p style="margin: 2px 0 0 0; color: #000;">{{ $assessment->kesimpulan ?: '-' }}</p>
            </div>
            <div style="border-top: 1px dashed #000; padding-top: 4px; margin-top: 4px;">
                <strong>Rencana Terapi Lanjutan & Target:</strong>
                <p style="margin: 2px 0 0 0; color: #000;">{{ $assessment->rencana_terapi ?: '-' }}</p>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         15. SKALA PERKEMBANGAN DENVER II (DDST II)
         ========================================================================= -->
    <div class="assessment-section-block" id="sec-block-15" data-section-id="15" data-has-data="{{ $has_m15 ? '1' : '0' }}" data-title="SKALA PERKEMBANGAN DENVER II (DDST II)" style="{{ $has_m15 ? '' : 'display: none;' }}">
        <div class="section-title"><span class="sec-number">{{ $has_m15 ? $serverSeqNum++ : '15' }}</span>. SKALA PERKEMBANGAN DENVER II (DDST II)</div>
        @if($has_m15)
            <!-- Denver Summary Box (Grayscale) -->
            <div class="box-rekap d-flex justify-content-between align-items-center">
                <span><strong>STATUS SKRINING DDST II:</strong> {{ $assessment->denver_kesimpulan ?: 'Tercatat' }}</span>
                <span>Pass (P): <strong>{{ $assessment->denver_pass_count ?? 0 }}</strong> &bull; Fail (F): <strong>{{ $assessment->denver_fail_count ?? 0 }}</strong> &bull; Refusal (R): <strong>{{ $assessment->denver_refusal_count ?? 0 }}</strong> &bull; No Opp (NO): <strong>{{ $assessment->denver_no_count ?? 0 }}</strong></span>
            </div>

            @php
                $denver_print_data = is_array($assessment->denver_data) ? $assessment->denver_data : [];
                $denver_print_sectors = config('denver.sectors', []);
            @endphp

            <table class="table-assessment" style="font-size: 8.5pt; margin-bottom: 6px;">
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
                        <tr style="background: #f0f0f0;">
                            <td colspan="5" style="font-weight: bold; font-size: 9pt;">
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
                                <td class="text-center font-weight-bold">
                                    @if($pScore === 'P') Pass (P)
                                    @elseif($pScore === 'F') Fail (F)
                                    @elseif($pScore === 'R') Refusal (R)
                                    @elseif($pScore === 'NO') No Opportunity (NO)
                                    @else -
                                    @endif
                                </td>
                                <td>{{ $pNote ?: '-' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            @if($assessment->denver_catatan)
                <div style="font-size: 8.5pt; margin-bottom: 8px;">
                    <em>Catatan Observasi Skala Denver: {{ $assessment->denver_catatan }}</em>
                </div>
            @endif
        @else
            <div style="font-size: 9pt; color: #555; margin-bottom: 6px; font-style: italic;">
                Skala Denver (DDST II) belum diuji / diisi.
            </div>
        @endif
    </div>

    <!-- =========================================================================
         TANDA TANGAN RESMI KEDINASAN & PROGRAM DOSIS TERAPI
         ========================================================================= -->
    <div class="sign-area no-break" style="margin-top: 14px; border: 1px solid #000000;">
        <table style="width: 100%; border-collapse: collapse; font-size: 8.5pt;">
            <tr>
                <td style="width: 55%; border: none !important; border-right: 1px solid #000000 !important; padding: 6px 8px; vertical-align: top;">
                    <div style="font-weight: bold; text-transform: uppercase; font-size: 8.5pt; margin-bottom: 4px; border-bottom: 1px solid #000000; padding-bottom: 2px;">
                        RENCANA DOSIS &amp; PROGRAM TERAPI
                    </div>
                    <table style="width: 100%; border: none !important; font-size: 8pt;">
                        <tr>
                            <td style="border: none !important; width: 44%; padding: 1.5px 0;">Frekuensi &amp; Durasi</td>
                            <td style="border: none !important; padding: 1.5px 0;">: <strong>{{ $assessment->rencana_dosis_frekuensi ? $assessment->rencana_dosis_frekuensi . 'x / minggu' : '-' }} ({{ $assessment->rencana_dosis_durasi ? $assessment->rencana_dosis_durasi . ' Menit' : '-' }})</strong></td>
                        </tr>
                        <tr>
                            <td style="border: none !important; padding: 1.5px 0;">Target Total Sesi</td>
                            <td style="border: none !important; padding: 1.5px 0;">: <strong>{{ $assessment->rencana_dosis_total_sesi ? $assessment->rencana_dosis_total_sesi . ' Sesi' : '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="border: none !important; padding: 1.5px 0;">Jadwal Re-assessment</td>
                            <td style="border: none !important; padding: 1.5px 0;">: <strong>{{ $assessment->rencana_dosis_reassessment ?: '-' }}</strong></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 45%; border: none !important; text-align: center; vertical-align: top; padding: 6px 8px;">
                    <div>
                        {{ $rekam->poli ?: ($rekam->upt_lokasi ?: 'Malang') }}, {{ $safeFormatDate($assessment->tgl_assessment, date('d F Y')) }}
                    </div>
                    <div style="font-weight: bold; margin-top: 2px;">Terapis Pemeriksa / Dokter,</div>
                    <div style="height: 48px;"></div>
                    <div style="font-weight: bold; text-decoration: underline;">
                        ( {{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? '..........................................') }} )
                    </div>
                    @if(isset($assessment->dokter->nip) || (isset($rekam->dokter) && $rekam->dokter->nip))
                        <div style="font-size: 8pt; margin-top: 1px;">
                            NIP. {{ $assessment->dokter->nip ?? $rekam->dokter->nip }}
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</div>

<script>
var currentMode = 'filled'; // 'filled' (default) atau 'all'

function setPrintMode(mode) {
    currentMode = mode;
    var btnFilled = document.getElementById('btnModeFilled');
    var btnAll = document.getElementById('btnModeAll');

    if (mode === 'filled') {
        if (btnFilled) {
            btnFilled.className = 'btn btn-primary font-w600';
        }
        if (btnAll) {
            btnAll.className = 'btn btn-outline-secondary font-w600';
        }
    } else {
        if (btnFilled) {
            btnFilled.className = 'btn btn-outline-secondary font-w600';
        }
        if (btnAll) {
            btnAll.className = 'btn btn-primary font-w600';
        }
    }

    applySectionVisibility();
}

function applySectionVisibility() {
    var blocks = document.querySelectorAll('.assessment-section-block');
    var visibleCounter = 1;
    var hasAnyVisible = false;

    blocks.forEach(function(block) {
        var hasData = block.getAttribute('data-has-data') === '1';
        var shouldShow = (currentMode === 'all') || hasData;

        if (shouldShow) {
            block.style.display = '';
            hasAnyVisible = true;
            var numSpan = block.querySelector('.sec-number');
            if (numSpan) {
                numSpan.textContent = visibleCounter;
            }
            visibleCounter++;
        } else {
            block.style.display = 'none';
        }
    });

    var notice = document.getElementById('no-modules-notice');
    if (notice) {
        notice.style.display = hasAnyVisible ? 'none' : '';
    }
}

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
        margin:       [8, 10, 10, 10],
        filename:     'Lembar-Asesmen-{{ Str::slug($pasien->nama) }}-{{ $pasien->no_rm }}.pdf',
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
            before: '.page-break-before',
            after: '.page-break-after',
            avoid: ['tr', 'tbody tr', '.section-title', '.table-assessment', '.box-rekap', '.box-subdimensi', '.sign-area', '.no-break', '.print-block', '.header-box-table']
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
    // Inisialisasi filter tampilan modul terisi
    applySectionVisibility();

    var urlParams = new URLSearchParams(window.location.search);
    var downloadMode = urlParams.get('download');
    var noPrint = urlParams.get('noprint');
    var modeParam = urlParams.get('mode');

    if (modeParam === 'all') {
        setPrintMode('all');
    }

    if (downloadMode === 'pdf' || downloadMode === '1') {
        // Otomatis download file PDF ke komputer
        setTimeout(function() {
            downloadPDF();
        }, 600);
    } else if (noPrint !== '1') {
        // Otomatis buka dialog Cetak / Simpan sebagai PDF browser
        setTimeout(function() {
            triggerPrintDialog();
        }, 500);
    }
});
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Sesi Terapi (SOAP) - {{ $pasien->nama }} (RM# {{ $pasien->no_rm }})</title>
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

        /* Box SOAP Card / Structure */
        .soap-block {
            border: 1px solid #000000;
            background: #ffffff;
            margin-bottom: 6px;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .soap-block-header {
            background-color: #f1f1f1;
            padding: 3px 8px;
            font-weight: bold;
            font-size: 8.5pt;
            border-bottom: 1px solid #000000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .soap-badge {
            display: inline-block;
            width: 18px;
            height: 18px;
            line-height: 18px;
            text-align: center;
            font-weight: bold;
            background: #000000;
            color: #ffffff;
            border-radius: 2px;
            margin-right: 6px;
            font-size: 8.5pt;
        }
        .soap-block-body {
            padding: 6px 10px;
            font-size: 8.5pt;
            line-height: 1.4;
            color: #000000;
        }

        /* Rekapitulasi & Box Grayscale */
        .box-rekap {
            background-color: #f8f8f8;
            border: 1px solid #000000;
            border-radius: 0;
            padding: 4px 8px;
            margin-bottom: 6px;
            font-size: 8.5pt;
            color: #000000;
        }
        .box-subdimensi {
            background-color: #f0f0f0;
            border: 1px solid #000000;
            border-bottom: none;
            padding: 3px 6px;
            font-size: 8.5pt;
            font-weight: bold;
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
        .no-break, .print-block, .sign-area, .kop-table, .header-box-table, .soap-block, .box-rekap, .assessment-section-block {
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
            .soap-badge {
                background: #000000 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .table-assessment th, .soap-block-header {
                background-color: #e8e8e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .section-title {
                background-color: #efefef !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .box-rekap, .box-subdimensi {
                background-color: #f8f8f8 !important;
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

    // Evaluasi Pengisian Modul Assessment jika ada
    $has_m1 = $assessment && (!empty($assessment->motorik_mengangkat_kepala) || 
              !empty($assessment->motorik_posisi_tengkurap) || 
              !empty($assessment->motorik_posisi_duduk) || 
              !empty($assessment->motorik_merangkak) || 
              !empty($assessment->motorik_berlutut) || 
              !empty($assessment->motorik_berjalan) || 
              !empty($assessment->motorik_catatan));

    $has_gmfm_scores = $assessment && ($hasArrayContent($assessment->gmfm_dimensi_a_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_b_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_c_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_d_scores) ||
                       $hasArrayContent($assessment->gmfm_dimensi_e_scores));
    $has_gmfm_notes = $assessment && (!empty($assessment->gmfm_dimensi_a_catatan) ||
                      !empty($assessment->gmfm_dimensi_b_catatan) ||
                      !empty($assessment->gmfm_dimensi_c_catatan) ||
                      !empty($assessment->gmfm_dimensi_d_catatan) ||
                      !empty($assessment->gmfm_dimensi_e_catatan));
    $has_gmfm_totals = $assessment && ((!empty($assessment->gmfm_total_score) && $assessment->gmfm_total_score > 0) || 
                       (!empty($assessment->gmfm_total_persen) && $assessment->gmfm_total_persen > 0) ||
                       (!empty($assessment->gmfm_dimensi_a_total) && $assessment->gmfm_dimensi_a_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_b_total) && $assessment->gmfm_dimensi_b_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_c_total) && $assessment->gmfm_dimensi_c_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_d_total) && $assessment->gmfm_dimensi_d_total > 0) ||
                       (!empty($assessment->gmfm_dimensi_e_total) && $assessment->gmfm_dimensi_e_total > 0));
    $has_m2 = $has_gmfm_scores || $has_gmfm_notes || $has_gmfm_totals;

    $has_m3 = $assessment && (!empty($assessment->adl_kontak_mata) || 
              !empty($assessment->adl_duduk_tenang) || 
              !empty($assessment->adl_gerakan_berulang) || 
              !empty($assessment->adl_respon_nama) || 
              !empty($assessment->adl_makan) || 
              !empty($assessment->adl_mandi) || 
              !empty($assessment->adl_berpakaian) || 
              !empty($assessment->adl_bak) || 
              !empty($assessment->adl_bab) || 
              !empty($assessment->adl_catatan));

    $has_m4 = $assessment && (!empty($assessment->wicara_komunikasi) || 
              !empty($assessment->wicara_organ) || 
              !empty($assessment->wicara_organ_keterangan) || 
              !empty($assessment->wicara_makan_menelan) || 
              !empty($assessment->wicara_makan_menelan_keterangan) || 
              !empty($assessment->wicara_catatan));

    $has_m5 = $assessment && (!empty($assessment->penglihatan_klasifikasi) || 
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
              !empty($assessment->penglihatan_catatan));

    $has_m6 = $assessment && (($assessment->nyeri_skor_total !== null && $assessment->nyeri_skor_total > 0) || 
              ($assessment->nyeri_saat_istirahat !== null && $assessment->nyeri_saat_istirahat > 0) || 
              ($assessment->nyeri_saat_aktivitas !== null && $assessment->nyeri_saat_aktivitas > 0) || 
              (!empty($assessment->nyeri_sifat) && count($assessment->nyeri_sifat) > 0) || 
              !empty($assessment->nyeri_lokasi_keluhan) || 
              !empty($assessment->nyeri_body_chart) || 
              !empty($assessment->nyeri_catatan));

    $has_m7 = $assessment && (!empty($assessment->rom_catatan) || $hasArrayContent($assessment->rom_mmt_data));

    $has_m8 = $assessment && (!empty($assessment->neuro_sensasi) || 
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
              !empty($assessment->neuro_catatan));

    $has_m9 = $assessment && ((!empty($assessment->postur_temuan) && count($assessment->postur_temuan) > 0) || 
              !empty($assessment->postur_tangan_tongkat) || 
              ($assessment->keseimbangan_bbs_skor !== null && $assessment->keseimbangan_bbs_skor > 0) || 
              !empty($assessment->keseimbangan_tug_detik) || 
              !empty($assessment->keseimbangan_romberg) || 
              !empty($assessment->keseimbangan_ols_kanan) || 
              !empty($assessment->keseimbangan_ols_kiri) || 
              !empty($assessment->keseimbangan_dual_task_tug) || 
              ($assessment->keseimbangan_fesi_skor !== null && $assessment->keseimbangan_fesi_skor > 0) || 
              !empty($assessment->postur_keseimbangan_catatan));

    $has_m10 = $assessment && ((!empty($assessment->gait_karakteristik) && count($assessment->gait_karakteristik) > 0) || 
               !empty($assessment->gait_deteksi_lantai) || 
               !empty($assessment->gait_10mwt_kecepatan_nyaman) || 
               !empty($assessment->gait_10mwt_kecepatan_cepat) || 
               !empty($assessment->gait_10mwt_jumlah_langkah) || 
               !empty($assessment->gait_catatan));

    $has_m11 = $assessment && (!empty($assessment->sensoris_taktil_raba_halus) || 
               !empty($assessment->sensoris_taktil_pinprick) || 
               !empty($assessment->sensoris_taktil_suhu) || 
               !empty($assessment->sensoris_posisi_sendi) || 
               !empty($assessment->sensoris_vibrasi) || 
               !empty($assessment->sensoris_kinesthesia_jari) || 
               !empty($assessment->sensoris_defisit_lokasi) || 
               !empty($assessment->vestibular_hit) || 
               !empty($assessment->vestibular_dix_hallpike) || 
               !empty($assessment->vestibular_keluhan_pusing) || 
               !empty($assessment->sensoris_catatan));

    $has_m12 = $assessment && (!empty($assessment->psikososial_pekerjaan_hobi) || 
               !empty($assessment->psikososial_faktor_psikologis) || 
               !empty($assessment->psikososial_dukungan_sosial) || 
               !empty($assessment->psikososial_harapan_pasien) || 
               !empty($assessment->psikososial_catatan));

    $has_m13 = $assessment && ((!empty($assessment->rencana_modalitas_fisik) && count($assessment->rencana_modalitas_fisik) > 0) || 
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
               !empty($assessment->rencana_dosis_reassessment));

    $has_m14 = $assessment && (!empty($assessment->kesimpulan) || !empty($assessment->rencana_terapi));

    // Denver II check
    $has_denver_scores = false;
    if ($assessment && !empty($assessment->denver_data) && is_array($assessment->denver_data)) {
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
    $has_denver_counts = $assessment && ((($assessment->denver_pass_count !== null && (int)$assessment->denver_pass_count > 0) ||
                          ($assessment->denver_fail_count !== null && (int)$assessment->denver_fail_count > 0) ||
                          ($assessment->denver_refusal_count !== null && (int)$assessment->denver_refusal_count > 0) ||
                          ($assessment->denver_no_count !== null && (int)$assessment->denver_no_count > 0)));
    $valid_denver_kesimpulan = $assessment && !empty($assessment->denver_kesimpulan) && !in_array($assessment->denver_kesimpulan, ['Belum Dinilai', 'Belum Diisi', '-', 'null']);
    $valid_denver_catatan = $assessment && !empty(trim($assessment->denver_catatan ?? ''));

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

<!-- Sticky Action Toolbar (Hanya Tampil di Layar) -->
<div class="print-toolbar no-print">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between" style="max-width: 820px; gap: 8px; padding: 0;">
        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 4px 8px; background: #2563eb; color: #fff;">
                <i class="fa-solid fa-file-medical mr-1"></i> CATATAN SOAP
            </span>
            <strong style="color: #0f172a; font-size: 12.5px;">{{ $pasien->nama }}</strong>
            <span class="text-muted" style="font-size: 11.5px;">(RM# {{ $pasien->no_rm }})</span>
            @if($assessment && $filledCount > 0)
                <span class="badge badge-success font-w600" style="background: #16a34a; font-size: 11px; padding: 4px 7px;">
                    <i class="fa-solid fa-check-circle mr-1"></i> {{ $filledCount }} Modul Asesmen
                </span>
            @endif
        </div>

        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
            @if($assessment && $filledCount > 0)
                <div class="btn-group btn-group-sm" role="group" aria-label="Mode Cetak">
                    <button type="button" id="btnModeComplete" class="btn btn-primary" onclick="setDocumentMode('complete')" style="font-size: 11px; padding: 5px 10px; font-weight: bold; border-radius: 4px 0 0 4px;">
                        <i class="fa-solid fa-layer-group mr-1"></i> SOAP + Asesmen
                    </button>
                    <button type="button" id="btnModeSoapOnly" class="btn btn-outline-secondary" onclick="setDocumentMode('soap_only')" style="font-size: 11px; padding: 5px 10px; font-weight: bold; border-radius: 0 4px 4px 0;">
                        <i class="fa-solid fa-file-lines mr-1"></i> SOAP Saja
                    </button>
                </div>
            @endif

            <button type="button" onclick="triggerPrintDialog()" class="btn btn-sm btn-dark font-w700" style="padding: 5px 12px; font-size: 11.5px; border-radius: 4px; background: #0f172a; border: none; color: #fff;">
                <i class="fa-solid fa-print mr-1"></i> Cetak / Simpan PDF
            </button>
            <button type="button" id="btnDownloadPdf" onclick="downloadPDF()" class="btn btn-sm btn-primary font-w700 text-white" style="padding: 5px 12px; font-size: 11.5px; border-radius: 4px; background: #2563eb; border: none;">
                <i class="fa-solid fa-download mr-1"></i> Unduh PDF
            </button>
            @if($assessment)
                <a href="{{ route('rekam.assessment.print', $rekam->id) }}" class="btn btn-sm btn-info text-white" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; background: #0284c7; border: none;" title="Cetak Lembar Asesmen Saja">
                    <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                </a>
            @endif
            <a href="{{ route('rekam.home-program.print', $rekam->id) }}" class="btn btn-sm btn-success text-white" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; background: #16a34a; border: none;" title="Cetak Panduan Latihan Rumahan">
                <i class="fa-solid fa-house-user mr-1"></i> Home Program
            </a>
            <a href="{{ route('rekam.detail', $pasien->id) }}" class="btn btn-sm btn-light border font-w600" style="padding: 5px 10px; font-size: 11.5px; border-radius: 4px; color: #334155;">
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
                <div style="font-size: 11.5pt; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">LEMBAR CATATAN SESI TERAPI</div>
                <div style="font-size: 10pt; font-weight: bold; text-transform: uppercase; margin-top: 1px;">(CATATAN PERKEMBANGAN PASIEN &amp; SOAP KLINIS)</div>
                <div style="font-size: 8pt; color: #333333; margin-top: 2px;">OMAH TERAPI-KU DINAS SOSIAL PROVINSI JAWA TIMUR</div>
            </td>
            <td style="width: 42%; border: 1.5px solid #000000 !important; padding: 0; vertical-align: top; background: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-size: 8.5pt;">
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold; width: 44%;">NOMOR RM</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: 800; font-size: 9.5pt; letter-spacing: 0.5px;">: {{ $pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px; font-weight: bold;">Tgl. Sesi Terapi</td>
                        <td style="border: none !important; border-bottom: 1px solid #000000 !important; padding: 3px 6px;">: {{ $tglSesiFormatted }} ({{ $rekam->sesi_waktu ?: 'Reguler' }})</td>
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
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->translatedFormat('d F Y') : '-' }} ({{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age . ' Tahun' : '-' }})</td>
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
                <td style="border: 1px solid #000000 !important;">: {{ $pasien->alamat ?: '-' }}</td>
                <td style="font-weight: bold; border: 1px solid #000000 !important;">Diagnosa Klinis</td>
                <td style="border: 1px solid #000000 !important;">: <strong>{{ $rekam->diagnosa ?: '-' }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- =========================================================================
         BAGIAN I: CATATAN REKAM MEDIS KLINIS (SOAP SESI TERAPI)
         ========================================================================= -->
    <div class="section-title">
        I. CATATAN REKAM MEDIS &amp; PERKEMBANGAN KLINIS HARIAN (SOAP)
    </div>

    <!-- S: SUBJEKTIF -->
    <div class="soap-block no-break">
        <div class="soap-block-header">
            <div>
                <span class="soap-badge">S</span>
                <span>SUBJEKTIF (Subjective) — Keluhan Utama &amp; Anamnesa Sesi</span>
            </div>
        </div>
        <div class="soap-block-body">
            @if(!empty($rekam->keluhan))
                <div style="white-space: pre-line;">{{ $rekam->keluhan }}</div>
            @else
                <span style="color: #555; font-style: italic;">Tidak ada keluhan subjektif khusus yang dilaporkan pada sesi ini.</span>
            @endif
        </div>
    </div>

    <!-- O: OBJEKTIF -->
    <div class="soap-block no-break">
        <div class="soap-block-header">
            <div>
                <span class="soap-badge">O</span>
                <span>OBJEKTIF (Objective) — Pemeriksaan Fisik, Tanda Vital &amp; Observasi Gerak</span>
            </div>
            @if($rekam->pemeriksaan_file)
                <small style="font-weight: normal;">[Dokumentasi Klinis Tersedia]</small>
            @endif
        </div>
        <div class="soap-block-body">
            @if(!empty($rekam->pemeriksaan) && $rekam->pemeriksaan !== 'Belum ada data pemeriksaan fisik')
                <div style="white-space: pre-line;">{{ $rekam->pemeriksaan }}</div>
            @else
                <span style="color: #555; font-style: italic;">Pemeriksaan fisik umum dalam batas wajar sesuai kondisi anak.</span>
            @endif
        </div>
    </div>

    <!-- A: ASESMEN -->
    <div class="soap-block no-break">
        <div class="soap-block-header">
            <div>
                <span class="soap-badge">A</span>
                <span>ASSESSMENT (Assessment) — Diagnosa Klinis &amp; Analisa Kemajuan</span>
            </div>
        </div>
        <div class="soap-block-body">
            <div>
                <strong>Diagnosa Fungsional / Analisa Sesi:</strong>
                <div style="margin-top: 2px; font-weight: bold; color: #000; white-space: pre-line;">
                    {{ $rekam->diagnosa ?: 'Catatan klinis umum sesi terapi' }}
                </div>
            </div>
            @if($assessment && !empty($assessment->diagnosa_medis))
                <div style="margin-top: 4px; border-top: 1px dashed #ccc; padding-top: 3px;">
                    <strong>Diagnosa Medis / Sekunder:</strong> {{ $assessment->diagnosa_medis }}
                </div>
            @endif
        </div>
    </div>

    <!-- P: PLAN -->
    <div class="soap-block no-break">
        <div class="soap-block-header">
            <div>
                <span class="soap-badge">P</span>
                <span>PLAN (Plan) — Rencana Intervensi Klinis &amp; Program Latihan Rumahan</span>
            </div>
        </div>
        <div class="soap-block-body">
            <!-- 1. Intervensi Terapi Klinis -->
            <div style="margin-bottom: 6px;">
                <strong>1. Tindakan &amp; Intervensi Terapi di Klinik:</strong>
                <div style="margin-top: 2px; white-space: pre-line;">
                    {{ $rekam->tindakan ?: 'Latihan fungsional, modalitas terapi fisik/okupasi/wicara sesuai protokol klinis.' }}
                </div>
            </div>

            <!-- 2. Program Latihan Rumahan (Home Program) -->
            <div style="border: 1px solid #000000; background: #fbfbfb; padding: 6px 8px; margin-top: 4px;">
                <div style="font-weight: bold; text-transform: uppercase; font-size: 8pt; margin-bottom: 2px; border-bottom: 1px solid #ddd; padding-bottom: 2px;">
                    <i class="fa-solid fa-house-user mr-1"></i> 2. Instruksi Latihan Rumahan (Home Program):
                </div>
                @if(!empty($rekam->latihan_rumahan))
                    <div style="white-space: pre-line; color: #000; font-size: 8.5pt;">{{ $rekam->latihan_rumahan }}</div>
                @else
                    <div style="color: #555; font-style: italic; font-size: 8pt;">
                        Melanjutkan latihan mandiri di rumah sesuai panduan terapis, menjaga postur yang benar, dan melatih stimulasi fungsional harian secara konsisten bersama keluarga.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- =========================================================================
         BAGIAN II: PENGKAJIAN & ASESMEN KLINIS TERPADU (MODUL YANG TERISI)
         ========================================================================= -->
    @if($assessment)
    <div id="assessment-container">
        <div class="section-title" style="margin-top: 10px;">
            II. PENGKAJIAN &amp; ASESMEN KLINIS TERPADU (HASIL EVALUASI TERAPIS)
        </div>

        <!-- Notice jika tidak ada modul yang terisi sama sekali -->
        <div id="no-modules-notice" class="box-rekap text-center py-3 my-2" style="{{ $filledCount === 0 ? '' : 'display: none;' }}">
            <p class="mb-0 font-weight-bold">Belum ada rincian modul asesmen klinis yang diisi pada sesi ini.</p>
        </div>

        <!-- 1. KEMAMPUAN MOTORIK -->
        <div class="assessment-section-block" id="sec-block-1" data-section-id="1" data-has-data="{{ $has_m1 ? '1' : '0' }}" style="{{ $has_m1 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m1 ? $serverSeqNum++ : '1' }}</span>. KEMAMPUAN MOTORIK KASAR &amp; HALUS</div>
            <table class="table-assessment">
                <thead>
                    <tr>
                        <th style="width: 6%; text-align: center;">No</th>
                        <th style="width: 44%;">Indikator Penilaian Motorik</th>
                        <th style="width: 50%;">Hasil Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="text-center">1</td><td>Mengangkat Kepala</td><td><strong>{{ $assessment->motorik_mengangkat_kepala ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">2</td><td>Posisi Tengkurap</td><td><strong>{{ $assessment->motorik_posisi_tengkurap ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">3</td><td>Posisi Duduk</td><td><strong>{{ $assessment->motorik_posisi_duduk ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">4</td><td>Merangkak</td><td><strong>{{ $assessment->motorik_merangkak ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">5</td><td>Berlutut</td><td><strong>{{ $assessment->motorik_berlutut ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">6</td><td>Berjalan</td><td><strong>{{ $assessment->motorik_berjalan ?: '-' }}</strong></td></tr>
                </tbody>
            </table>
            @if($assessment->motorik_catatan)
                <div style="font-size: 8pt; margin-bottom: 6px;"><em>Catatan Motorik: {{ $assessment->motorik_catatan }}</em></div>
            @endif
        </div>

        <!-- 2. GMFM-88 -->
        <div class="assessment-section-block" id="sec-block-2" data-section-id="2" data-has-data="{{ $has_m2 ? '1' : '0' }}" style="{{ $has_m2 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m2 ? $serverSeqNum++ : '2' }}</span>. GROSS MOTOR FUNCTION MEASURE (GMFM-88)</div>
            @if(!is_null($assessment->gmfm_dimensi_a_total) || !is_null($assessment->gmfm_dimensi_b_total) || !is_null($assessment->gmfm_dimensi_c_total) || !is_null($assessment->gmfm_dimensi_d_total) || !is_null($assessment->gmfm_dimensi_e_total))
                <div class="box-rekap d-flex justify-content-between align-items-center">
                    <span><strong>REKAPITULASI TOTAL GMFM-88:</strong> Skor Total: <strong>{{ $assessment->gmfm_total_score ?? 0 }} / 264</strong></span>
                    <span>Rata-rata Capaian: <strong>{{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%</strong></span>
                </div>
            @endif
        </div>

        <!-- 3. ADL -->
        <div class="assessment-section-block" id="sec-block-3" data-section-id="3" data-has-data="{{ $has_m3 ? '1' : '0' }}" style="{{ $has_m3 ? '' : 'display: none;' }}">
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
                    <tr><td class="text-center">1</td><td>Kontak Mata</td><td><strong>{{ $assessment->adl_kontak_mata ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">2</td><td>Bisa Duduk Tenang</td><td><strong>{{ $assessment->adl_duduk_tenang ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">3</td><td>Gerakan Berulang</td><td><strong>{{ $assessment->adl_gerakan_berulang ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">4</td><td>Merespon Nama</td><td><strong>{{ $assessment->adl_respon_nama ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">5</td><td>Makan Mandiri</td><td><strong>{{ $assessment->adl_makan ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">6</td><td>Mandi</td><td><strong>{{ $assessment->adl_mandi ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">7</td><td>Berpakaian</td><td><strong>{{ $assessment->adl_berpakaian ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">8</td><td>Toilet (BAK / BAB)</td><td><strong>BAK: {{ $assessment->adl_bak ?: '-' }} &bull; BAB: {{ $assessment->adl_bab ?: '-' }}</strong></td></tr>
                </tbody>
            </table>
            @if($assessment->adl_catatan)
                <div style="font-size: 8pt; margin-bottom: 6px;"><em>Catatan ADL: {{ $assessment->adl_catatan }}</em></div>
            @endif
        </div>

        <!-- 4. WICARA -->
        <div class="assessment-section-block" id="sec-block-4" data-section-id="4" data-has-data="{{ $has_m4 ? '1' : '0' }}" style="{{ $has_m4 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m4 ? $serverSeqNum++ : '4' }}</span>. KEMAMPUAN WICARA &amp; KOMUNIKASI</div>
            <table class="table-assessment">
                <thead>
                    <tr>
                        <th style="width: 6%; text-align: center;">No</th>
                        <th style="width: 44%;">Indikator Penilaian</th>
                        <th style="width: 50%;">Hasil Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="text-center">1</td><td>Kemampuan Berkomunikasi</td><td><strong>{{ $assessment->wicara_komunikasi ?: '-' }}</strong></td></tr>
                    <tr><td class="text-center">2</td><td>Kondisi Organ Bicara &amp; Pendengaran</td><td><strong>{{ $assessment->wicara_organ ?: '-' }}</strong> @if($assessment->wicara_organ_keterangan) <small>({{ $assessment->wicara_organ_keterangan }})</small> @endif</td></tr>
                    <tr><td class="text-center">3</td><td>Kemampuan Makan, Menelan &amp; Mengunyah</td><td><strong>{{ $assessment->wicara_makan_menelan ?: '-' }}</strong> @if($assessment->wicara_makan_menelan_keterangan) <small>({{ $assessment->wicara_makan_menelan_keterangan }})</small> @endif</td></tr>
                </tbody>
            </table>
            @if($assessment->wicara_catatan)
                <div style="font-size: 8pt; margin-bottom: 6px;"><em>Catatan Wicara: {{ $assessment->wicara_catatan }}</em></div>
            @endif
        </div>

        <!-- 5. PENGLIHATAN -->
        <div class="assessment-section-block" id="sec-block-5" data-section-id="5" data-has-data="{{ $has_m5 ? '1' : '0' }}" style="{{ $has_m5 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m5 ? $serverSeqNum++ : '5' }}</span>. STATUS PENGLIHATAN (ASESMEN NETRA)</div>
            <table class="table-assessment">
                <tbody>
                    <tr><td style="width: 25%; font-weight: bold;">Klasifikasi &amp; Onset</td><td>{{ $assessment->penglihatan_klasifikasi ?: '-' }} (Onset: {{ $assessment->penglihatan_onset ?: '-' }})</td></tr>
                    <tr><td style="font-weight: bold;">Visus OD / OS</td><td>OD: {{ $assessment->penglihatan_visus_od ?: '-' }} &bull; OS: {{ $assessment->penglihatan_visus_os ?: '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        <!-- 6. NYERI & BODY CHART -->
        <div class="assessment-section-block" id="sec-block-6" data-section-id="6" data-has-data="{{ $has_m6 ? '1' : '0' }}" data-title="INTENSITAS NYERI & BODY CHART" style="{{ $has_m6 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m6 ? $serverSeqNum++ : '6' }}</span>. INTENSITAS NYERI &amp; BODY CHART</div>
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
                                        <strong>
                                            {{ $assessment->nyeri_skor_total }} / 10
                                            @if($assessment->nyeri_skor_total == 0) (Tidak Nyeri)
                                            @elseif($assessment->nyeri_skor_total <= 3) (Nyeri Ringan)
                                            @elseif($assessment->nyeri_skor_total <= 6) (Nyeri Sedang)
                                            @elseif($assessment->nyeri_skor_total <= 9) (Nyeri Berat)
                                            @elseif($assessment->nyeri_skor_total == 10) (Sangat Hebat)
                                            @endif
                                        </strong>
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
                        <div style="font-size: 8pt; margin-top: 3px;">
                            <em>Catatan Nyeri: {{ $assessment->nyeri_catatan }}</em>
                        </div>
                    @endif
                </div>
                <div class="col-5 text-center">
                    <div style="border: 1px solid #000000; padding: 6px; background: #ffffff;">
                        <div style="font-size: 8.5pt; font-weight: bold; margin-bottom: 4px;">PETA LOKASI KELUHAN (BODY CHART)</div>
                        @if($assessment->nyeri_body_chart)
                            <img src="{{ $assessment->nyeri_body_chart }}" alt="Body Chart" style="max-height: 160px; max-width: 100%; object-fit: contain;">
                        @else
                            @php
                                $pathBodyImg = public_path('images/body.png');
                                $bodyBase64 = file_exists($pathBodyImg) ? 'data:image/png;base64,' . base64_encode(file_get_contents($pathBodyImg)) : asset('images/body.png');
                            @endphp
                            <img src="{{ $bodyBase64 }}" alt="Body Chart" style="max-height: 160px; max-width: 100%; opacity: 0.6; object-fit: contain;">
                        @endif
                        <div style="font-size: 7.5pt; margin-top: 3px; color: #333;">
                            Simbol: <strong>~</strong> Nyeri | <strong>#</strong> Kesemutan | <strong>-</strong> Kelemahan | <strong>/</strong> Bengkak | <strong>X</strong> Kaku
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7. ROM & MMT -->
        @php
            $rom_data = is_array($assessment->rom_mmt_data) ? $assessment->rom_mmt_data : [];
            $rom_labels = config('assessment.rom_mmt.rows', []);
        @endphp
        <div class="assessment-section-block" id="sec-block-7" data-section-id="7" data-has-data="{{ $has_m7 ? '1' : '0' }}" style="{{ $has_m7 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m7 ? $serverSeqNum++ : '7' }}</span>. LINGKUP GERAK SENDI (ROM) &amp; KEKUATAN OTOT (MMT)</div>
            <table class="table-assessment" style="font-size: 8pt;">
                <thead>
                    <tr>
                        <th style="width: 24%;">Sendi</th>
                        <th style="width: 10%; text-align: center;">Fleksi</th>
                        <th style="width: 10%; text-align: center;">Ekstensi</th>
                        <th style="width: 9%; text-align: center;">Abd</th>
                        <th style="width: 9%; text-align: center;">Add</th>
                        <th style="width: 9%; text-align: center;">IR</th>
                        <th style="width: 9%; text-align: center;">ER</th>
                        <th style="width: 19%; text-align: center;">MMT (0-5)</th>
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
                            <td class="text-center"><strong>{{ isset($item['mmt']) && $item['mmt'] !== '' ? 'Nilai ' . $item['mmt'] : '-' }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($assessment->rom_catatan)
                <div style="font-size: 8pt; margin-bottom: 6px;"><em>Catatan ROM: {{ $assessment->rom_catatan }}</em></div>
            @endif
        </div>

        <!-- 8. NEUROLOGIS -->
        <div class="assessment-section-block" id="sec-block-8" data-section-id="8" data-has-data="{{ $has_m8 ? '1' : '0' }}" style="{{ $has_m8 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m8 ? $serverSeqNum++ : '8' }}</span>. PEMERIKSAAN NEUROLOGIS (SISTEM SARAF)</div>
            <table class="table-assessment">
                <tbody>
                    <tr><td style="width: 25%; font-weight: bold;">Sensasi &amp; Tonus</td><td>Sensasi: {{ $assessment->neuro_sensasi ?: '-' }} &bull; Tonus: {{ $assessment->neuro_tonus_otot ?: '-' }}</td></tr>
                    <tr><td style="font-weight: bold;">Refleks Fisiologis</td><td>Bisep: {{ $assessment->neuro_refleks_bisep_d ?: '-' }}/{{ $assessment->neuro_refleks_bisep_s ?: '-' }} &bull; Patela: {{ $assessment->neuro_refleks_patela_d ?: '-' }}/{{ $assessment->neuro_refleks_patela_s ?: '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        <!-- 9. POSTUR & KESEIMBANGAN -->
        <div class="assessment-section-block" id="sec-block-9" data-section-id="9" data-has-data="{{ $has_m9 ? '1' : '0' }}" style="{{ $has_m9 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m9 ? $serverSeqNum++ : '9' }}</span>. PEMERIKSAAN POSTUR &amp; KESEIMBANGAN</div>
            <table class="table-assessment">
                <tbody>
                    <tr><td style="width: 30%; font-weight: bold;">Berg Balance Scale (BBS)</td><td><strong>{{ $assessment->keseimbangan_bbs_skor !== null ? $assessment->keseimbangan_bbs_skor . '/56' : '-' }}</strong></td></tr>
                    <tr><td style="font-weight: bold;">Timed Up and Go (TUG)</td><td><strong>{{ $assessment->keseimbangan_tug_detik ? $assessment->keseimbangan_tug_detik . ' detik' : '-' }}</strong></td></tr>
                </tbody>
            </table>
        </div>

        <!-- 10. GAYA BERJALAN (GAIT) -->
        <div class="assessment-section-block" id="sec-block-10" data-section-id="10" data-has-data="{{ $has_m10 ? '1' : '0' }}" style="{{ $has_m10 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m10 ? $serverSeqNum++ : '10' }}</span>. PEMERIKSAAN GAYA BERJALAN (GAIT)</div>
            <table class="table-assessment">
                <tbody>
                    <tr><td style="width: 30%; font-weight: bold;">10-Meter Walk Test</td><td>Kecepatan: {{ $assessment->gait_10mwt_kecepatan_nyaman ? $assessment->gait_10mwt_kecepatan_nyaman . ' m/s' : '-' }} &bull; Langkah: {{ $assessment->gait_10mwt_jumlah_langkah ? $assessment->gait_10mwt_jumlah_langkah . ' langkah' : '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        <!-- 11. SENSORIS & VESTIBULAR -->
        <div class="assessment-section-block" id="sec-block-11" data-section-id="11" data-has-data="{{ $has_m11 ? '1' : '0' }}" style="{{ $has_m11 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m11 ? $serverSeqNum++ : '11' }}</span>. PEMERIKSAAN SENSORIS &amp; VESTIBULAR</div>
            <table class="table-assessment">
                <tbody>
                    <tr><td style="width: 30%; font-weight: bold;">Sensasi Taktil &amp; Posisi Sendi</td><td>Raba Halus: {{ $assessment->sensoris_taktil_raba_halus ?: '-' }} &bull; Posisi Sendi: {{ $assessment->sensoris_posisi_sendi ?: '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        <!-- 12. PSIKOSOSIAL -->
        <div class="assessment-section-block" id="sec-block-12" data-section-id="12" data-has-data="{{ $has_m12 ? '1' : '0' }}" style="{{ $has_m12 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m12 ? $serverSeqNum++ : '12' }}</span>. FAKTOR PSIKOSOSIAL &amp; KONTEKSTUAL</div>
            <table class="table-assessment">
                <tbody>
                    <tr><td style="width: 30%; font-weight: bold;">Faktor Psikologis &amp; Dukungan</td><td>Psikologis: {{ $assessment->psikososial_faktor_psikologis ?: '-' }} &bull; Dukungan: {{ $assessment->psikososial_dukungan_sosial ?: '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        <!-- 13. PERENCANAAN TERAPI -->
        <div class="assessment-section-block" id="sec-block-13" data-section-id="13" data-has-data="{{ $has_m13 ? '1' : '0' }}" style="{{ $has_m13 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m13 ? $serverSeqNum++ : '13' }}</span>. PERENCANAAN TERAPI &amp; PROGRAM INTERVENSI</div>
            <table class="table-assessment text-center">
                <thead>
                    <tr>
                        <th>Frekuensi</th>
                        <th>Durasi Sesi</th>
                        <th>Estimasi Total Sesi</th>
                        <th>Re-assessment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ $assessment->rencana_dosis_frekuensi ? $assessment->rencana_dosis_frekuensi . 'x / mgg' : '-' }}</strong></td>
                        <td><strong>{{ $assessment->rencana_dosis_durasi ? $assessment->rencana_dosis_durasi . ' Menit' : '-' }}</strong></td>
                        <td><strong>{{ $assessment->rencana_dosis_total_sesi ? $assessment->rencana_dosis_total_sesi . ' Sesi' : '-' }}</strong></td>
                        <td><strong>{{ $assessment->rencana_dosis_reassessment ? \Carbon\Carbon::parse($assessment->rencana_dosis_reassessment)->translatedFormat('d F Y') : '-' }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 14. KESIMPULAN KLINIS -->
        <div class="assessment-section-block" id="sec-block-14" data-section-id="14" data-has-data="{{ $has_m14 ? '1' : '0' }}" style="{{ $has_m14 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m14 ? $serverSeqNum++ : '14' }}</span>. KESIMPULAN &amp; EVALUASI KLINIS</div>
            <div style="border: 1px solid #000; padding: 6px 8px; margin-bottom: 6px; font-size: 8.5pt;">
                <div><strong>Kesimpulan Klinis:</strong> {{ $assessment->kesimpulan ?: '-' }}</div>
                @if($assessment->rencana_terapi)
                    <div style="margin-top: 3px; border-top: 1px dashed #ccc; padding-top: 3px;"><strong>Rencana Terapi Lanjutan:</strong> {{ $assessment->rencana_terapi }}</div>
                @endif
            </div>
        </div>

        <!-- 15. SKALA DENVER II -->
        <div class="assessment-section-block" id="sec-block-15" data-section-id="15" data-has-data="{{ $has_m15 ? '1' : '0' }}" style="{{ $has_m15 ? '' : 'display: none;' }}">
            <div class="section-title"><span class="sec-number">{{ $has_m15 ? $serverSeqNum++ : '15' }}</span>. SKALA PERKEMBANGAN DENVER II (DDST II)</div>
            @if($has_m15)
                <div class="box-rekap d-flex justify-content-between align-items-center">
                    <span><strong>STATUS SKRINING DDST II:</strong> {{ $assessment->denver_kesimpulan ?: 'Tercatat' }}</span>
                    <span>Pass (P): <strong>{{ $assessment->denver_pass_count ?? 0 }}</strong> &bull; Fail (F): <strong>{{ $assessment->denver_fail_count ?? 0 }}</strong> &bull; Refusal (R): <strong>{{ $assessment->denver_refusal_count ?? 0 }}</strong></span>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- =========================================================================
         AREA TANDA TANGAN & PENGESAHAN DOKUMEN KLINIS
         ========================================================================= -->
    <div class="sign-area no-break" style="margin-top: 14px;">
        <table class="sign-table">
            <tr>
                <td style="width: 48%; text-align: center; vertical-align: top;">
                    Mengetahui / Menyetujui,<br>
                    <strong>Orang Tua / Wali Penerima Manfaat</strong>
                    <div style="height: 55px;"></div>
                    <strong style="text-decoration: underline;">( {{ $pasien->nama_wali ? $pasien->nama_wali : ($pasien->nama_ortu ?: '................................................') }} )</strong><br>
                    <small style="font-size: 8pt; color: #333;">Wali / Pendamping Keluarga</small>
                </td>
                <td style="width: 4%;"></td>
                <td style="width: 48%; text-align: center; vertical-align: top;">
                    Jawa Timur, {{ $tglSesiFormatted }}<br>
                    <strong>Terapis Penanggung Jawab Pemeriksa</strong>
                    <div style="height: 55px;"></div>
                    <strong style="text-decoration: underline;">( {{ $rekam->dokter->nama ?? 'Terapis Omah Terapi' }} )</strong><br>
                    <small style="font-size: 8pt; color: #333;">NIP / STR: {{ $rekam->dokter->user->nip ?? ($rekam->dokter->nip ?? '-') }}</small>
                </td>
            </tr>
        </table>
    </div>

</div>

<script>
var docMode = 'complete'; // 'complete' (SOAP + Asesmen) atau 'soap_only'

function setDocumentMode(mode) {
    docMode = mode;
    var container = document.getElementById('assessment-container');
    var btnComplete = document.getElementById('btnModeComplete');
    var btnSoapOnly = document.getElementById('btnModeSoapOnly');

    if (mode === 'soap_only') {
        if (container) container.style.display = 'none';
        if (btnSoapOnly) btnSoapOnly.className = 'btn btn-primary';
        if (btnComplete) btnComplete.className = 'btn btn-outline-secondary';
    } else {
        if (container) container.style.display = '';
        if (btnComplete) btnComplete.className = 'btn btn-primary';
        if (btnSoapOnly) btnSoapOnly.className = 'btn btn-outline-secondary';
    }
}

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

    var cleanName = "{{ preg_replace('/[^a-zA-Z0-9_-]/', '_', $pasien->nama) }}";
    var cleanNoRm = "{{ preg_replace('/[^a-zA-Z0-9_-]/', '_', $pasien->no_rm) }}";
    var cleanDate = "{{ $rekam->tgl_rekam ?: date('Y-m-d') }}";
    var opt = {
        margin:       [8, 10, 10, 10],
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
            avoid: ['tr', 'tbody tr', '.section-title', '.table-assessment', '.soap-block', '.box-rekap', '.sign-area', '.no-break', '.print-block', '.header-box-table']
        }
    };

    html2pdf().set(opt).from(element).save().then(function() {
        if (btnDownload) {
            btnDownload.disabled = false;
            btnDownload.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Terunduh!';
            setTimeout(function() {
                btnDownload.innerHTML = originalText;
            }, 3000);
        }
    }).catch(function(err) {
        console.error('PDF generation error:', err);
        if (btnDownload) {
            btnDownload.disabled = false;
            btnDownload.innerHTML = originalText;
        }
        window.print();
    });
}

document.addEventListener("DOMContentLoaded", function() {
    var urlParams = new URLSearchParams(window.location.search);
    var downloadMode = urlParams.get('download');
    var autoPrint = urlParams.get('auto_print');
    var modeParam = urlParams.get('mode');

    if (modeParam === 'soap_only') {
        setDocumentMode('soap_only');
    }

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

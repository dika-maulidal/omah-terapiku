@extends('layout.apps')
@section('content')

@php
    $hasStr = function($val) {
        if ($val === null) return false;
        $val = trim((string)$val);
        return $val !== '' && $val !== '-' && $val !== 'null' && $val !== 'Tidak Ada' && $val !== 'Belum Diisi' && $val !== 'Belum Dinilai';
    };

    $hasArrayContent = function($arr) use ($hasStr) {
        if (!is_array($arr) || empty($arr)) return false;
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $subk => $subv) {
                    if ($hasStr($subv) && $subv !== 'NT') return true;
                }
            } else {
                if ($hasStr($v) && $v !== 'NT') return true;
            }
        }
        return false;
    };

    // Subtest 1.1 Netra
    $has_sub_1_1 = $hasStr($assessment->penglihatan_klasifikasi) || $hasStr($assessment->penglihatan_onset) || $hasStr($assessment->penglihatan_sisi) || $hasStr($assessment->penglihatan_usia_onset) || $hasStr($assessment->penglihatan_durasi) || $hasStr($assessment->penglihatan_etiologi) || $hasStr($assessment->penglihatan_progresif) || $hasStr($assessment->penglihatan_terakhir_periksa) || $hasStr($assessment->penglihatan_visus_od) || $hasStr($assessment->penglihatan_visus_os) || $hasStr($assessment->penglihatan_persepsi_cahaya) || $hasStr($assessment->penglihatan_preferensi_sisi) || $hasStr($assessment->penglihatan_catatan) || (!empty($assessment->penglihatan_alat_bantu) && is_array($assessment->penglihatan_alat_bantu) && count(array_filter($assessment->penglihatan_alat_bantu, $hasStr)) > 0);

    // Subtest 1.2 Psikososial
    $has_sub_1_2 = $hasStr($assessment->psikososial_pekerjaan_hobi) || $hasStr($assessment->psikososial_faktor_psikologis) || $hasStr($assessment->psikososial_dukungan_sosial) || $hasStr($assessment->psikososial_harapan_pasien) || $hasStr($assessment->psikososial_catatan);

    // Subtest 2.1 Motorik
    $has_sub_2_1 = $hasStr($assessment->motorik_mengangkat_kepala) || $hasStr($assessment->motorik_posisi_tengkurap) || $hasStr($assessment->motorik_posisi_duduk) || $hasStr($assessment->motorik_merangkak) || $hasStr($assessment->motorik_berlutut) || $hasStr($assessment->motorik_berjalan) || $hasStr($assessment->motorik_catatan);

    // Subtest 2.2 ADL
    $has_sub_2_2 = $hasStr($assessment->adl_kontak_mata) || $hasStr($assessment->adl_duduk_tenang) || $hasStr($assessment->adl_gerakan_berulang) || $hasStr($assessment->adl_respon_nama) || $hasStr($assessment->adl_makan) || $hasStr($assessment->adl_mandi) || $hasStr($assessment->adl_berpakaian) || $hasStr($assessment->adl_bak) || $hasStr($assessment->adl_bab) || $hasStr($assessment->adl_catatan);

    // Subtest 2.3 Wicara
    $has_sub_2_3 = $hasStr($assessment->wicara_komunikasi) || $hasStr($assessment->wicara_organ) || $hasStr($assessment->wicara_organ_keterangan) || $hasStr($assessment->wicara_makan_menelan) || $hasStr($assessment->wicara_makan_menelan_keterangan) || $hasStr($assessment->wicara_catatan);

    // Subtest 3.1 Nyeri
    $has_sub_3_1 = ($assessment->nyeri_skor_total !== null && (int)$assessment->nyeri_skor_total > 0) || ($assessment->nyeri_saat_istirahat !== null && (int)$assessment->nyeri_saat_istirahat > 0) || ($assessment->nyeri_saat_aktivitas !== null && (int)$assessment->nyeri_saat_aktivitas > 0) || (!empty($assessment->nyeri_sifat) && is_array($assessment->nyeri_sifat) && count(array_filter($assessment->nyeri_sifat, $hasStr)) > 0) || $hasStr($assessment->nyeri_lokasi_keluhan) || $hasStr($assessment->nyeri_catatan);

    // Subtest 3.2 ROM & MMT
    $has_sub_3_2 = $hasArrayContent($assessment->rom_mmt_data) || $hasStr($assessment->rom_catatan);

    // Subtest 4.1 Neurologis
    $has_sub_4_1 = $hasStr($assessment->neuro_sensasi) || $hasStr($assessment->neuro_sensasi_area) || $hasStr($assessment->neuro_tonus_otot) || $hasStr($assessment->neuro_refleks_bisep_d) || $hasStr($assessment->neuro_refleks_bisep_s) || $hasStr($assessment->neuro_refleks_trisep_d) || $hasStr($assessment->neuro_refleks_trisep_s) || $hasStr($assessment->neuro_refleks_patela_d) || $hasStr($assessment->neuro_refleks_patela_s) || $hasStr($assessment->neuro_refleks_achilles_d) || $hasStr($assessment->neuro_refleks_achilles_s) || (!empty($assessment->neuro_koordinasi) && is_array($assessment->neuro_koordinasi) && count(array_filter($assessment->neuro_koordinasi, $hasStr)) > 0) || $hasStr($assessment->neuro_catatan);

    // Subtest 4.2 Postur & Keseimbangan
    $has_sub_4_2 = (!empty($assessment->postur_temuan) && is_array($assessment->postur_temuan) && count(array_filter($assessment->postur_temuan, $hasStr)) > 0) || $hasStr($assessment->postur_tangan_tongkat) || ($assessment->keseimbangan_bbs_skor !== null && (int)$assessment->keseimbangan_bbs_skor >= 0) || $hasStr($assessment->keseimbangan_tug_detik) || $hasStr($assessment->keseimbangan_romberg) || $hasStr($assessment->keseimbangan_ols_kanan) || $hasStr($assessment->keseimbangan_ols_kiri) || $hasStr($assessment->keseimbangan_single_leg_kanan) || $hasStr($assessment->keseimbangan_single_leg_kiri) || $hasStr($assessment->keseimbangan_dual_task_tug) || ($assessment->keseimbangan_fesi_skor !== null && (int)$assessment->keseimbangan_fesi_skor > 0) || $hasStr($assessment->keseimbangan_catatan) || $hasStr($assessment->postur_keseimbangan_catatan);

    // Subtest 4.3 Gaya Berjalan (Gait)
    $has_sub_4_3 = (!empty($assessment->gait_deviasi) && is_array($assessment->gait_deviasi) && count(array_filter($assessment->gait_deviasi, $hasStr)) > 0) || (!empty($assessment->gait_karakteristik) && is_array($assessment->gait_karakteristik) && count(array_filter($assessment->gait_karakteristik, $hasStr)) > 0) || $hasStr($assessment->gait_deteksi_lantai) || $hasStr($assessment->gait_fase) || $hasStr($assessment->gait_alat_bantu) || $hasStr($assessment->gait_jarak_mwt) || $hasStr($assessment->gait_10mwt_kecepatan_nyaman) || $hasStr($assessment->gait_10mwt_kecepatan_cepat) || $hasStr($assessment->gait_10mwt_jumlah_langkah) || $hasStr($assessment->gait_catatan);

    // Subtest 4.4 Sensoris & Vestibular
    $has_sub_4_4 = $hasStr($assessment->sensoris_taktil_raba_halus) || $hasStr($assessment->sensoris_taktil_pinprick) || $hasStr($assessment->sensoris_taktil_suhu) || $hasStr($assessment->sensoris_posisi_sendi) || $hasStr($assessment->sensoris_vibrasi) || $hasStr($assessment->sensoris_kinesthesia_jari) || $hasStr($assessment->sensoris_defisit_lokasi) || $hasStr($assessment->vestibular_hit) || $hasStr($assessment->vestibular_dix_hallpike) || $hasStr($assessment->vestibular_keluhan_pusing) || $hasStr($assessment->sensoris_catatan);

    // Subtest 5.1 GMFM
    $has_sub_5_1 = $hasArrayContent($assessment->gmfm_dimensi_a_scores) || $hasArrayContent($assessment->gmfm_dimensi_b_scores) || $hasArrayContent($assessment->gmfm_dimensi_c_scores) || $hasArrayContent($assessment->gmfm_dimensi_d_scores) || $hasArrayContent($assessment->gmfm_dimensi_e_scores) || $hasStr($assessment->gmfm_dimensi_a_catatan) || $hasStr($assessment->gmfm_dimensi_b_catatan) || $hasStr($assessment->gmfm_dimensi_c_catatan) || $hasStr($assessment->gmfm_dimensi_d_catatan) || $hasStr($assessment->gmfm_dimensi_e_catatan) || (!empty($assessment->gmfm_total_score) && (float)$assessment->gmfm_total_score > 0) || (!empty($assessment->gmfm_total_persen) && (float)$assessment->gmfm_total_persen > 0);

    // Subtest 5.2 Denver
    $has_denver_score = false;
    if (!empty($assessment->denver_data) && is_array($assessment->denver_data)) {
        foreach ($assessment->denver_data as $dItem) {
            if (is_array($dItem) && !empty($dItem['score']) && in_array(strtoupper($dItem['score']), ['P', 'F', 'R', 'NO'])) {
                $has_denver_score = true;
                break;
            }
        }
    }
    $has_sub_5_2 = $has_denver_score || ($assessment->denver_pass_count !== null && (int)$assessment->denver_pass_count > 0) || ($assessment->denver_fail_count !== null && (int)$assessment->denver_fail_count > 0) || $hasStr($assessment->denver_kesimpulan) || $hasStr($assessment->denver_catatan);

    // Subtest 6.1 Perencanaan
    $has_sub_6_1 = (!empty($assessment->rencana_modalitas_fisik) && is_array($assessment->rencana_modalitas_fisik) && count(array_filter($assessment->rencana_modalitas_fisik, $hasStr)) > 0) || (!empty($assessment->rencana_manual_terapi) && is_array($assessment->rencana_manual_terapi) && count(array_filter($assessment->rencana_manual_terapi, $hasStr)) > 0) || (!empty($assessment->rencana_latihan_terapi) && is_array($assessment->rencana_latihan_terapi) && count(array_filter($assessment->rencana_latihan_terapi, $hasStr)) > 0) || (!empty($assessment->rencana_edukasi_konseling) && is_array($assessment->rencana_edukasi_konseling) && count(array_filter($assessment->rencana_edukasi_konseling, $hasStr)) > 0) || $hasStr($assessment->rencana_modalitas_lainnya) || $hasStr($assessment->rencana_manual_lainnya) || $hasStr($assessment->rencana_latihan_lainnya) || $hasStr($assessment->rencana_edukasi_lainnya) || $hasStr($assessment->rencana_dosis_frekuensi) || $hasStr($assessment->rencana_dosis_durasi) || $hasStr($assessment->rencana_dosis_total_sesi) || $hasStr($assessment->rencana_dosis_reassessment) || $hasStr($assessment->rencana_terapi);

    // Subtest 6.2 Kesimpulan & TTD
    $has_sub_6_2 = $hasStr($assessment->kesimpulan);

    // Modul Rollup 1 sd 6
    $has_modul1 = $has_sub_1_1 || $has_sub_1_2;
    $has_modul2 = $has_sub_2_1 || $has_sub_2_2 || $has_sub_2_3;
    $has_modul3 = $has_sub_3_1 || $has_sub_3_2;
    $has_modul4 = $has_sub_4_1 || $has_sub_4_2 || $has_sub_4_3 || $has_sub_4_4;
    $has_modul5 = $has_sub_5_1 || $has_sub_5_2;
    $has_modul6 = $has_sub_6_1 || $has_sub_6_2;

    $modulesStatus = [
        1 => $has_modul1,
        2 => $has_modul2,
        3 => $has_modul3,
        4 => $has_modul4,
        5 => $has_modul5,
        6 => $has_modul6,
    ];

    $totalFilledModules = count(array_filter($modulesStatus));
@endphp

<!-- Page Header Banner (Unified Card Sesuai DESIGN.md) -->
<div class="card mb-3 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0; border: 1px solid #bfdbfe; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);">
                    <i class="fa-solid fa-file-waveform"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-0" style="color: #1e40af; font-size: 20px;">Hasil Assessment Penerima Manfaat</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px; margin-top: 4px;">
                        <li class="breadcrumb-item"><a href="{{Route('dashboard')}}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{Route('rekam')}}" style="color: #2563eb;">Rekam Medis</a></li>
                        <li class="breadcrumb-item"><a href="{{Route('rekam.detail', $pasien->id)}}" style="color: #2563eb;">{{ $pasien->nama }}</a></li>
                        <li class="breadcrumb-item active text-muted">Lembar Hasil Asesmen</li>
                    </ol>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <a href="{{Route('rekam.detail', $pasien->id)}}" class="btn btn-sm btn-light font-w600" style="padding: 8px 16px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Rekam Medis
                </a>
                @if(auth()->user() && in_array(auth()->user()->role_display(), ['Admin', 'Dokter']))
                    <a href="{{Route('rekam.assessment', $rekam->id)}}" class="btn btn-sm btn-info text-white font-w600" style="padding: 8px 16px; font-size: 12.5px; border-radius: 8px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important; border: none !important; box-shadow: 0 4px 10px rgba(2, 132, 199, 0.2);">
                        <i class="fa-solid fa-pencil mr-1"></i> Edit Assessment
                    </a>
                @endif
                <a href="{{Route('rekam.assessment.print', $rekam->id)}}" target="_blank" class="btn btn-sm btn-primary font-w700" style="padding: 8px 16px; font-size: 12.5px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-print mr-1"></i> Cetak Asesmen
                </a>
                <a href="{{Route('rekam.assessment.print', $rekam->id)}}?download=pdf" target="_blank" class="btn btn-sm btn-success text-white font-w700" style="padding: 8px 16px; font-size: 12.5px; border-radius: 8px; background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                    <i class="fa-solid fa-download mr-1"></i> Unduh PDF
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Profil Pasien & Rekam Summary (Context Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-3">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 mb-2 mb-lg-0">
                <div>
                    <h4 class="font-w700 mb-1" style="font-size: 17px; color: #1e293b;">
                        {{ $pasien->nama }}
                    </h4>
                    <div class="text-muted font-w500" style="font-size: 12.5px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <span style="color: #1e40af; font-weight: 600;">No. RM: {{ $pasien->no_rm }}</span>
                        <span class="text-muted">&bull;</span>
                        <span style="color: #64748b;">NIK: {{ $pasien->nik ?: '-' }}</span>
                    </div>
                    <!-- Metadata Info Pasien -->
                    <div class="d-flex align-items-center flex-wrap mt-2" style="gap: 10px;">
                        <span class="badge badge-light border" style="padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #334155; background: #f8fafc;">
                            <i class="fa-solid fa-venus-mars mr-1.5 text-primary"></i> {{ $pasien->jk ?: '-' }}
                        </span>
                        <span class="badge badge-light border" style="padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #334155; background: #f8fafc;">
                            <i class="fa-solid fa-calendar mr-1.5 text-primary"></i> {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ?: '-' }} ({{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age . ' Thn' : '-' }})
                        </span>
                        <span class="badge font-w700" style="padding: 6px 14px; border-radius: 6px; font-size: 12px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                            <i class="fa-solid fa-wheelchair mr-1.5 text-primary"></i> {{ $pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada' ? $pasien->jenis_disabilitas : 'Non-Disabilitas' }}
                        </span>
                        @if($pasien->status_display)
                            {!! $pasien->status_display !!}
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="d-flex justify-content-lg-end align-items-center flex-wrap" style="gap: 16px;">
                    <div class="text-lg-right">
                        <small class="text-muted d-block font-w600" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.3px;">Tanggal Assessment</small>
                        <strong class="text-primary font-w700" style="font-size: 13px;">{{ $assessment->tgl_assessment ? $assessment->tgl_assessment->format('d M Y') : '-' }}</strong>
                    </div>
                    <div class="pl-3" style="border-left: 2px solid #e2e8f0;">
                        <small class="text-muted d-block font-w600" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.3px;">Terapis Pemeriksa</small>
                        <strong style="color: #1e293b; font-size: 13px; font-weight: 700;">{{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? '-') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Card Container with 6 Module Underline Tabs Navigation -->
<div class="card mb-4" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">

    <!-- 6 Modules Grid Tab Navigation Header (3x2, Tanpa Perlu Geser) -->
    <div class="card-header p-3 border-bottom" style="background: #ffffff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
        <ul class="nav assessment-modul-grid-tabs" id="assessmentShowTab" role="tablist">
            @php
                $tabTitles = [
                    1 => 'Modul 1: Penglihatan & Psikososial',
                    2 => 'Modul 2: Motorik Dasar & ADL',
                    3 => 'Modul 3: Evaluasi Fisik & Nyeri',
                    4 => 'Modul 4: Neurologis & Gait',
                    5 => 'Modul 5: Instrumen Khusus',
                    6 => 'Modul 6: Rencana Terapi & TTD',
                ];
            @endphp
            @foreach($tabTitles as $idx => $title)
                @php
                    $isFilled = $modulesStatus[$idx];
                @endphp
                <li class="nav-item module-tab-item" role="presentation" data-module-index="{{ $idx }}" data-has-data="{{ $isFilled ? '1' : '0' }}">
                    <a class="nav-link module-tab-link {{ $idx === 1 ? 'active' : '' }}" id="tab-modul{{ $idx }}-btn" data-toggle="tab" href="#modul-{{ $idx }}" role="tab" aria-controls="modul-{{ $idx }}" aria-selected="{{ $idx === 1 ? 'true' : 'false' }}" data-module-index="{{ $idx }}">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <div class="d-flex align-items-center text-truncate" style="min-width: 0;">
                                <span class="tab-module-num mr-2">{{ $idx }}</span>
                                <span class="tab-module-title text-truncate">{{ $title }}</span>
                            </div>
                            @if($isFilled)
                                <span class="badge font-w700 ml-2 tab-status-badge flex-shrink-0" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                    <i class="fa-solid fa-check mr-1"></i> Terisi
                                </span>
                            @else
                                <span class="badge font-w500 ml-2 tab-status-badge flex-shrink-0" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                    Kosong
                                </span>
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Tab Content Panels -->
    <div class="card-body p-3 p-md-4">
        <div class="tab-content" id="assessmentShowTabContent">

            <!-- ======================================================== -->
            <!-- MODUL 1: STATUS PENGLIHATAN & PSIKOSOSIAL               -->
            <!-- ======================================================== -->
            <div class="tab-pane fade show active" id="modul-1" role="tabpanel" aria-labelledby="tab-modul1-btn">
                
                <!-- Subtest 1.1: Status Penglihatan (Netra) (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-eye text-primary mr-1.5"></i> Subtest 1.1: Status Penglihatan (Netra)
                        </h6>
                        @if($has_sub_1_1)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td style="width: 28%; font-weight: 600; color: #475569;">Klasifikasi Penglihatan</td>
                                    <td style="width: 2%;">:</td>
                                    <td><strong class="text-primary">{{ $assessment->penglihatan_klasifikasi ?: '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Onset & Sisi</td>
                                    <td>:</td>
                                    <td>
                                        <strong class="text-primary">{{ $assessment->penglihatan_onset ?: '-' }}</strong>
                                        @if($assessment->penglihatan_sisi)
                                             <span class="badge badge-light border ml-1">({{ $assessment->penglihatan_sisi }})</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Usia Onset / Durasi</td>
                                    <td>:</td>
                                    <td>
                                        {{ $assessment->penglihatan_usia_onset ? $assessment->penglihatan_usia_onset . ' Thn' : '-' }} / 
                                        {{ $assessment->penglihatan_durasi ? 'Durasi ' . $assessment->penglihatan_durasi . ' Thn' : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Etiologi / Diagnosis</td>
                                    <td>:</td>
                                    <td><strong class="text-dark">{{ $assessment->penglihatan_etiologi ?: '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Progresifitas & Terakhir Periksa</td>
                                    <td>:</td>
                                    <td>
                                        {{ $assessment->penglihatan_progresif ?: '-' }} 
                                        {{ $assessment->penglihatan_terakhir_periksa ? ' (Terakhir: ' . $assessment->penglihatan_terakhir_periksa . ')' : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Visus OD / OS</td>
                                    <td>:</td>
                                    <td>OD: <strong>{{ $assessment->penglihatan_visus_od ?: '-' }}</strong> &bull; OS: <strong>{{ $assessment->penglihatan_visus_os ?: '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Persepsi Cahaya & Preferensi Sisi</td>
                                    <td>:</td>
                                    <td>Cahaya: {{ $assessment->penglihatan_persepsi_cahaya ?: '-' }} &bull; Sisi Preferensi: {{ $assessment->penglihatan_preferensi_sisi ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Alat Bantu yang Digunakan</td>
                                    <td>:</td>
                                    <td>
                                        @if(is_array($assessment->penglihatan_alat_bantu) && count($assessment->penglihatan_alat_bantu) > 0)
                                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                                @foreach($assessment->penglihatan_alat_bantu as $alat)
                                                    <span class="badge badge-light border text-dark font-w600" style="font-size: 11px;">
                                                        {{ $alat }}
                                                        @if($alat == 'Tongkat putih' && $assessment->penglihatan_teknik_tongkat)
                                                            ({{ $assessment->penglihatan_teknik_tongkat }})
                                                        @elseif($alat == 'Lainnya' && $assessment->penglihatan_alat_bantu_lainnya)
                                                            ({{ $assessment->penglihatan_alat_bantu_lainnya }})
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if($assessment->penglihatan_catatan)
                            <div class="p-3" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Penglihatan:</span>
                                <p class="mb-0 text-dark">{{ $assessment->penglihatan_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subtest 1.2: Faktor Psikososial & Kontekstual (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-users text-primary mr-1.5"></i> Subtest 1.2: Faktor Psikososial & Kontekstual
                        </h6>
                        @if($has_sub_1_2)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="p-3 rounded border bg-light h-100">
                                    <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">Dukungan Sosial & Keluarga</small>
                                    <strong class="text-primary font-w700" style="font-size: 13.5px;">{{ $assessment->psikososial_dukungan_sosial ?: '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="p-3 rounded border bg-light h-100">
                                    <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">Faktor Emosional & Psikologis</small>
                                    <strong class="text-dark font-w700" style="font-size: 13.5px;">{{ $assessment->psikososial_faktor_psikologis ?: '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="p-3 rounded border bg-white">
                                    <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">Pekerjaan / Sekolah / Aktivitas / Hobi</small>
                                    <div class="font-w600 text-dark" style="font-size: 13px;">{{ $assessment->psikososial_pekerjaan_hobi ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="p-3 rounded border bg-white">
                                    <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">Harapan Penerima Manfaat / Keluarga</small>
                                    <div class="font-w600 text-dark" style="font-size: 13px;">{{ $assessment->psikososial_harapan_pasien ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        @if($assessment->psikososial_catatan)
                            <div class="p-3 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Observasi Psikososial:</span>
                                <p class="mb-0 text-dark">{{ $assessment->psikososial_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Next Module Nav -->
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-sm btn-primary font-w700" onclick="showModuleTab(2)" style="border-radius: 6px; padding: 6px 14px;">
                        Modul 2: Motorik & ADL <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 2: MOTORIK DASAR & ADL                            -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-2" role="tabpanel" aria-labelledby="tab-modul2-btn">
                
                <!-- Subtest 2.1: Kemampuan Motorik Kasar & Halus (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-child text-primary mr-1.5"></i> Subtest 2.1: Kemampuan Motorik Kasar & Halus
                        </h6>
                        @if($has_sub_2_1)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0" style="font-size: 13px;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 6%; text-align: center;">No</th>
                                    <th style="width: 44%;">Indikator Penilaian Motorik</th>
                                    <th style="width: 50%;">Hasil Penilaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center font-w700 text-muted">1</td>
                                    <td class="font-w600 text-dark">Mengangkat Kepala</td>
                                    <td>
                                        @if($assessment->motorik_mengangkat_kepala)
                                            <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->motorik_mengangkat_kepala }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">2</td>
                                    <td class="font-w600 text-dark">Posisi Tengkurap</td>
                                    <td>
                                        @if($assessment->motorik_posisi_tengkurap)
                                            <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->motorik_posisi_tengkurap }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">3</td>
                                    <td class="font-w600 text-dark">Posisi Duduk</td>
                                    <td>
                                        @if($assessment->motorik_posisi_duduk)
                                            <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->motorik_posisi_duduk }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">4</td>
                                    <td class="font-w600 text-dark">Merangkak</td>
                                    <td>
                                        @if($assessment->motorik_merangkak)
                                            <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->motorik_merangkak }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">5</td>
                                    <td class="font-w600 text-dark">Berlutut</td>
                                    <td>
                                        @if($assessment->motorik_berlutut)
                                            <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->motorik_berlutut }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">6</td>
                                    <td class="font-w600 text-dark">Berjalan</td>
                                    <td>
                                        @if($assessment->motorik_berjalan)
                                            <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->motorik_berjalan }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if($assessment->motorik_catatan)
                            <div class="p-3" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Motorik:</span>
                                <p class="mb-0 text-dark">{{ $assessment->motorik_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subtest 2.2: Kemampuan Aktivitas Sehari-hari (ADL) (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-list-check text-primary mr-1.5"></i> Subtest 2.2: Kemampuan Aktivitas Sehari-hari (ADL)
                        </h6>
                        @if($has_sub_2_2)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0" style="font-size: 13px;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 6%; text-align: center;">No</th>
                                    <th style="width: 44%;">Indikator Penilaian ADL</th>
                                    <th style="width: 50%;">Hasil Penilaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center font-w700 text-muted">1</td>
                                    <td class="font-w600 text-dark">Kontak Mata</td>
                                    <td><span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->adl_kontak_mata ?: '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">2</td>
                                    <td class="font-w600 text-dark">Duduk Tenang Saat Melakukan Aktivitas</td>
                                    <td><span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->adl_duduk_tenang ?: '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">3</td>
                                    <td class="font-w600 text-dark">Gerakan Berulang dan Tidak Bertujuan</td>
                                    <td><span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->adl_gerakan_berulang ?: '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">4</td>
                                    <td class="font-w600 text-dark">Merespon Saat Dipanggil Nama</td>
                                    <td><span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->adl_respon_nama ?: '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">5</td>
                                    <td class="font-w600 text-dark">Makan & Minum Mandiri</td>
                                    <td><span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->adl_makan ?: '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">6</td>
                                    <td class="font-w600 text-dark">Mandi</td>
                                    <td><span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->adl_mandi ?: '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">7</td>
                                    <td class="font-w600 text-dark">Berpakaian</td>
                                    <td><span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{ $assessment->adl_berpakaian ?: '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">8</td>
                                    <td class="font-w600 text-dark">Toilet (BAK / BAB)</td>
                                    <td>
                                        <span class="badge badge-primary font-w600 mr-1" style="font-size: 12px; padding: 4px 10px;">BAK: {{ $assessment->adl_bak ?: '-' }}</span>
                                        <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">BAB: {{ $assessment->adl_bab ?: '-' }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if($assessment->adl_catatan)
                            <div class="p-3" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan ADL:</span>
                                <p class="mb-0 text-dark">{{ $assessment->adl_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subtest 2.3: Kemampuan Wicara & Komunikasi (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-comments text-primary mr-1.5"></i> Subtest 2.3: Kemampuan Wicara & Komunikasi
                        </h6>
                        @if($has_sub_2_3)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0" style="font-size: 13px;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 6%; text-align: center;">No</th>
                                    <th style="width: 44%;">Indikator Penilaian</th>
                                    <th style="width: 50%;">Hasil Penilaian & Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center font-w700 text-muted">1</td>
                                    <td class="font-w600 text-dark">Kemampuan Berkomunikasi</td>
                                    <td><strong class="text-primary">{{ $assessment->wicara_komunikasi ?: '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">2</td>
                                    <td class="font-w600 text-dark">Kondisi Organ Bicara & Pendengaran</td>
                                    <td>
                                        <strong class="text-primary">{{ $assessment->wicara_organ ?: '-' }}</strong>
                                        @if($assessment->wicara_organ_keterangan)
                                            <span class="text-muted ml-1">({{ $assessment->wicara_organ_keterangan }})</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center font-w700 text-muted">3</td>
                                    <td class="font-w600 text-dark">Kemampuan Makan, Mengunyah & Menelan</td>
                                    <td>
                                        <strong class="text-primary">{{ $assessment->wicara_makan_menelan ?: '-' }}</strong>
                                        @if($assessment->wicara_makan_menelan_keterangan)
                                            <span class="text-muted ml-1">({{ $assessment->wicara_makan_menelan_keterangan }})</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if($assessment->wicara_catatan)
                            <div class="p-3" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Wicara:</span>
                                <p class="mb-0 text-dark">{{ $assessment->wicara_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Next & Prev Buttons -->
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-sm btn-light font-w600 border" onclick="showModuleTab(1)" style="border-radius: 6px; padding: 6px 14px;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Modul 1
                    </button>
                    <button type="button" class="btn btn-sm btn-primary font-w700" onclick="showModuleTab(3)" style="border-radius: 6px; padding: 6px 14px;">
                        Modul 3: Fisik & Nyeri <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 3: EVALUASI FISIK & NYERI                         -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-3" role="tabpanel" aria-labelledby="tab-modul3-btn">
                <div class="row">
                    <!-- Subtest 3.1: Intensitas Nyeri & Body Chart -->
                    <div class="col-12 mb-4">
                        <div class="card border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-heart-pulse text-primary mr-1.5"></i> Subtest 3.1: Intensitas Nyeri & Anatomi Body Chart
                                </h6>
                                @if($has_sub_3_1)
                                    <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                        <i class="fa-solid fa-check mr-1"></i> Terisi
                                    </span>
                                @else
                                    <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                        Kosong
                                    </span>
                                @endif
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                                        <table class="table mb-0" style="font-size: 13px;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 44%; font-weight: 600; color: #475569;">Skor Total Nyeri (VAS)</td>
                                                    <td style="width: 2%;">:</td>
                                                    <td>
                                                        @if($assessment->nyeri_skor_total !== null)
                                                            <span class="badge font-w700" style="font-size: 12px; padding: 4px 10px; background: {{ $assessment->nyeri_skor_total == 0 ? '#dcfce7; color: #166534;' : ($assessment->nyeri_skor_total <= 3 ? '#fef9c3; color: #854d0e;' : ($assessment->nyeri_skor_total <= 6 ? '#ffedd5; color: #9a3412;' : '#fee2e2; color: #991b1b;')) }}">
                                                                {{ $assessment->nyeri_skor_total }} / 10
                                                                @if($assessment->nyeri_skor_total == 0) (Tidak Nyeri)
                                                                @elseif($assessment->nyeri_skor_total <= 3) (Nyeri Ringan)
                                                                @elseif($assessment->nyeri_skor_total <= 6) (Nyeri Sedang)
                                                                @elseif($assessment->nyeri_skor_total <= 9) (Nyeri Berat)
                                                                @elseif($assessment->nyeri_skor_total == 10) (Sangat Hebat)
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; color: #475569;">Saat Istirahat / Aktivitas</td>
                                                    <td>:</td>
                                                    <td>
                                                        Istirahat: <strong class="text-primary">{{ $assessment->nyeri_saat_istirahat !== null && $assessment->nyeri_saat_istirahat !== '' ? $assessment->nyeri_saat_istirahat . ' / 10' : '-' }}</strong> &bull; 
                                                        Aktivitas: <strong class="text-primary">{{ $assessment->nyeri_saat_aktivitas !== null && $assessment->nyeri_saat_aktivitas !== '' ? $assessment->nyeri_saat_aktivitas . ' / 10' : '-' }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; color: #475569;">Sifat Nyeri</td>
                                                    <td>:</td>
                                                    <td>
                                                        @if(is_array($assessment->nyeri_sifat) && count($assessment->nyeri_sifat) > 0)
                                                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                                                @foreach($assessment->nyeri_sifat as $sf)
                                                                    <span class="badge badge-light border text-dark font-w600" style="font-size: 11px;">
                                                                        {{ $sf }}
                                                                        @if($sf == 'Lainnya' && $assessment->nyeri_sifat_lainnya)
                                                                            ({{ $assessment->nyeri_sifat_lainnya }})
                                                                        @endif
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; color: #475569;">Deskripsi Area Keluhan</td>
                                                    <td>:</td>
                                                    <td><strong class="text-dark">{{ $assessment->nyeri_lokasi_keluhan ?: '-' }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @if($assessment->nyeri_catatan)
                                            <div class="p-2.5 mt-2 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12px;">
                                                <span class="text-muted d-block font-w600">Catatan Nyeri:</span>
                                                <p class="mb-0 text-dark">{{ $assessment->nyeri_catatan }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-lg-6 col-12 text-center">
                                        <span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase;">Pemetaan Body Chart Anatomi:</span>
                                        @if($assessment->nyeri_body_chart)
                                            <div class="p-2 bg-white rounded d-inline-block" style="border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); max-width: 100%;">
                                                <img src="{{ $assessment->nyeri_body_chart }}" alt="Body Chart Nyeri" style="max-height: 200px; max-width: 100%; border-radius: 4px;">
                                            </div>
                                        @else
                                            <div class="p-2 bg-white rounded d-inline-block" style="border: 1.5px solid #e2e8f0; max-width: 100%;">
                                                <img src="{{ asset('images/body.png') }}" alt="Body Chart" style="max-height: 200px; max-width: 100%; opacity: 0.7;">
                                                <small class="text-muted d-block mt-1">(Belum ada tanda keluhan khusus)</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subtest 3.2: ROM & MMT -->
                    @php
                        $rom_data = is_array($assessment->rom_mmt_data) ? $assessment->rom_mmt_data : [];
                        $rom_labels = config('assessment.rom_mmt.rows', []);
                    @endphp
                    <div class="col-12 mb-4">
                        <div class="card border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-arrows-up-down-left-right text-primary mr-1.5"></i> Subtest 3.2: Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT)
                                </h6>
                                @if($has_sub_3_2)
                                    <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                        <i class="fa-solid fa-check mr-1"></i> Terisi
                                    </span>
                                @else
                                    <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                        Kosong
                                    </span>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-0" style="font-size: 12.5px;">
                                        <thead class="bg-light text-center">
                                            <tr>
                                                <th style="text-align: left; width: 22%;">Gerakan / Sendi</th>
                                                <th style="width: 10%;">Fleksi</th>
                                                <th style="width: 10%;">Ekstensi</th>
                                                <th style="width: 9%;">Abd</th>
                                                <th style="width: 9%;">Add</th>
                                                <th style="width: 9%;">IR</th>
                                                <th style="width: 9%;">ER</th>
                                                <th style="width: 11%;">Lainnya</th>
                                                <th style="width: 10%; background: #eff6ff; color: #1e40af;">MMT (0-5)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rom_labels as $key => $lbl)
                                                @php $item = $rom_data[$key] ?? []; @endphp
                                                <tr>
                                                    <td class="font-w600 text-dark">
                                                        {{ $key === 'custom' && !empty($item['nama']) ? 'Sendi: ' . $item['nama'] : $lbl }}
                                                    </td>
                                                    <td class="text-center font-w600 text-primary">{{ $item['fleksi'] ?? '-' }}</td>
                                                    <td class="text-center font-w600 text-primary">{{ $item['ekstensi'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $item['abd'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $item['add'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $item['ir'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $item['er'] ?? '-' }}</td>
                                                    <td>{{ $item['lainnya'] ?? '-' }}</td>
                                                    <td class="text-center font-w700" style="background: #f8faff; color: #1e40af;">
                                                        {{ isset($item['mmt']) && $item['mmt'] !== '' ? 'Nilai ' . $item['mmt'] : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($assessment->rom_catatan)
                                    <div class="p-3" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                                        <span class="text-muted d-block font-w600 mb-1">Catatan ROM & Kekuatan Otot:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->rom_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next & Prev Buttons -->
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-sm btn-light font-w600 border" onclick="showModuleTab(2)" style="border-radius: 6px; padding: 6px 14px;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Modul 2
                    </button>
                    <button type="button" class="btn btn-sm btn-primary font-w700" onclick="showModuleTab(4)" style="border-radius: 6px; padding: 6px 14px;">
                        Modul 4: Neurologis & Gait <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 4: PEMERIKSAAN NEUROLOGIS & GAIT                  -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-4" role="tabpanel" aria-labelledby="tab-modul4-btn">
                
                <!-- Subtest 4.1: Pemeriksaan Neurologis (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-brain text-primary mr-1.5"></i> Subtest 4.1: Pemeriksaan Neurologis (Sistem Saraf)
                        </h6>
                        @if($has_sub_4_1)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <table class="table table-bordered mb-3" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td style="width: 25%; font-weight: 600; color: #475569; background: #f8fafc;">Sensasi</td>
                                    <td style="width: 75%;">
                                        <span class="badge badge-primary light font-w600" style="font-size: 12px;">
                                            {{ $assessment->neuro_sensasi ?: '-' }}
                                        </span>
                                        @if($assessment->neuro_sensasi_area)
                                            <span class="text-muted ml-2" style="font-size: 12px;">
                                                <em>(Area Defisit: {{ $assessment->neuro_sensasi_area }})</em>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569; background: #f8fafc;">Tonus Otot</td>
                                    <td>
                                        <span class="badge badge-info light font-w600" style="font-size: 12px;">
                                            {{ $assessment->neuro_tonus_otot ?: '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569; background: #f8fafc;">Tes Koordinasi</td>
                                    <td>
                                        @if(is_array($assessment->neuro_koordinasi) && count($assessment->neuro_koordinasi) > 0)
                                            <div class="d-flex flex-wrap" style="gap: 6px;">
                                                @foreach($assessment->neuro_koordinasi as $k_item)
                                                    <span class="badge badge-light border font-w600" style="font-size: 11.5px; padding: 4px 8px;">
                                                        {{ $k_item }}
                                                        @if($k_item == 'Lainnya' && $assessment->neuro_koordinasi_lainnya)
                                                            ({{ $assessment->neuro_koordinasi_lainnya }})
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <span class="text-muted d-block font-w700 mb-2" style="font-size: 12px; text-transform: uppercase;">
                            <i class="fa-solid fa-stethoscope text-primary mr-1"></i> Refleks Fisiologis Tendon (D / S):
                        </span>
                        <div class="table-responsive border rounded mb-2">
                            <table class="table table-bordered table-sm text-center mb-0" style="font-size: 12.5px; background: #ffffff;">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="text-align: left; width: 40%;">Tendon Pemeriksaan</th>
                                        <th style="width: 30%;">D (Kanan)</th>
                                        <th style="width: 30%;">S (Kiri)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Bisep (C5 - C6)</td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_bisep_d ?: '-' }}</strong></td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_bisep_s ?: '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Trisep (C7)</td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_trisep_d ?: '-' }}</strong></td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_trisep_s ?: '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Patela (L3 - L4)</td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_patela_d ?: '-' }}</strong></td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_patela_s ?: '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Achilles (S1)</td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_achilles_d ?: '-' }}</strong></td>
                                        <td><strong class="text-primary">{{ $assessment->neuro_refleks_achilles_s ?: '-' }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if($assessment->neuro_catatan)
                            <div class="p-3 mt-3 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Neurologis:</span>
                                <p class="mb-0 text-dark">{{ $assessment->neuro_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subtest 4.2: Pemeriksaan Postur & Keseimbangan (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-person text-primary mr-1.5"></i> Subtest 4.2: Pemeriksaan Postur & Keseimbangan
                        </h6>
                        @if($has_sub_4_2)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="table-responsive border rounded mb-3">
                            <table class="table table-bordered table-hover mb-0" style="font-size: 13px; background: #ffffff;">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 26%;">Instrumen Penilaian Keseimbangan</th>
                                        <th style="width: 22%; text-align: center;">Skor / Waktu</th>
                                        <th style="width: 28%;">Nilai Normal / Cut-Off</th>
                                        <th style="width: 24%; text-align: center;">Interpretasi Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- BBS -->
                                    <tr>
                                        <td class="font-w600 text-dark align-middle">Berg Balance Scale (BBS)</td>
                                        <td class="text-center font-w700 text-primary align-middle">{{ $assessment->keseimbangan_bbs_skor !== null ? $assessment->keseimbangan_bbs_skor . ' / 56' : '-' }}</td>
                                        <td class="align-middle">
                                            <div class="cutoff-list">
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-success">41 – 56</span>
                                                    <span class="cutoff-desc">Mandiri (Risiko Rendah)</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-warning">21 – 40</span>
                                                    <span class="cutoff-desc">Bantuan (Risiko Sedang)</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-danger">0 – 20</span>
                                                    <span class="cutoff-desc font-w600 text-danger">Risiko Jatuh Tinggi</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($assessment->keseimbangan_bbs_skor !== null)
                                                @if($assessment->keseimbangan_bbs_skor >= 41)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Risiko Rendah (Mandiri)</span>
                                                @elseif($assessment->keseimbangan_bbs_skor >= 21)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa fa-triangle-exclamation mr-1"></i> Risiko Sedang (Bantuan)</span>
                                                @else
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;"><i class="fa fa-circle-exclamation mr-1"></i> Risiko Jatuh Tinggi</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- TUG -->
                                    <tr>
                                        <td class="font-w600 text-dark align-middle">Timed Up & Go (TUG)</td>
                                        <td class="text-center font-w700 text-primary align-middle">{{ $assessment->keseimbangan_tug_detik !== null && $assessment->keseimbangan_tug_detik !== '' ? $assessment->keseimbangan_tug_detik . ' Detik' : '-' }}</td>
                                        <td class="align-middle">
                                            <div class="cutoff-list">
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-success">&le; 13.5 dtk</span>
                                                    <span class="cutoff-desc">Normal / Mandiri</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-danger">&gt; 13.5 dtk</span>
                                                    <span class="cutoff-desc font-w600 text-danger">Risiko Jatuh Meningkat</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if(!empty($assessment->keseimbangan_tug_detik))
                                                @php $tugVal = (float)str_replace(',', '.', $assessment->keseimbangan_tug_detik); @endphp
                                                @if($tugVal > 0 && $tugVal <= 13.5)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Normal / Mandiri</span>
                                                @elseif($tugVal <= 20)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa fa-triangle-exclamation mr-1"></i> Risiko Jatuh</span>
                                                @else
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;"><i class="fa fa-circle-exclamation mr-1"></i> Risiko Jatuh Tinggi</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Romberg -->
                                    <tr>
                                        <td class="font-w600 text-dark align-middle">Romberg Test (Mata Tertutup)</td>
                                        <td class="text-center font-w700 text-primary align-middle">{{ $assessment->keseimbangan_romberg ?: '-' }}</td>
                                        <td class="align-middle">
                                            <div class="cutoff-list">
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-success">Negatif</span>
                                                    <span class="cutoff-desc">Normal (Propriosepsi Baik)</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-danger">Positif</span>
                                                    <span class="cutoff-desc font-w600 text-danger">Defisit Sensoris / Propriosepsi</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($assessment->keseimbangan_romberg == 'Negatif')
                                                <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Normal</span>
                                            @elseif($assessment->keseimbangan_romberg == 'Positif')
                                                <span class="badge font-w600" style="font-size: 11px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;"><i class="fa fa-circle-exclamation mr-1"></i> Defisit Propriosepsi / Vestibular</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- OLS -->
                                    <tr>
                                        <td class="font-w600 text-dark align-middle">One-Leg Stance (OLS)</td>
                                        <td class="text-center font-w700 text-primary align-middle">
                                            D: {{ $assessment->keseimbangan_ols_kanan ? $assessment->keseimbangan_ols_kanan . 's' : '-' }} &bull;
                                            S: {{ $assessment->keseimbangan_ols_kiri ? $assessment->keseimbangan_ols_kiri . 's' : '-' }}
                                        </td>
                                        <td class="align-middle">
                                            <div class="cutoff-list">
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-success">&ge; 5 detik</span>
                                                    <span class="cutoff-desc">Normal (Kanan &amp; Kiri)</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-danger">&lt; 5 detik</span>
                                                    <span class="cutoff-desc font-w600 text-danger">Risiko Jatuh</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @php
                                                $olsD = !empty($assessment->keseimbangan_ols_kanan) ? (float)str_replace(',', '.', $assessment->keseimbangan_ols_kanan) : null;
                                                $olsS = !empty($assessment->keseimbangan_ols_kiri) ? (float)str_replace(',', '.', $assessment->keseimbangan_ols_kiri) : null;
                                            @endphp
                                            @if($olsD !== null && $olsS !== null)
                                                @if($olsD >= 5 && $olsS >= 5)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Normal (D & S &ge; 5s)</span>
                                                @elseif($olsD < 5 && $olsS < 5)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;"><i class="fa fa-circle-exclamation mr-1"></i> Risiko Jatuh (D & S &lt; 5s)</span>
                                                @else
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa fa-triangle-exclamation mr-1"></i> Asimetri (Salah satu &lt; 5s)</span>
                                                @endif
                                            @elseif($olsD !== null)
                                                @if($olsD >= 5)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Normal D (&ge; 5s)</span>
                                                @else
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa fa-triangle-exclamation mr-1"></i> Risiko Jatuh D (&lt; 5s)</span>
                                                @endif
                                            @elseif($olsS !== null)
                                                @if($olsS >= 5)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Normal S (&ge; 5s)</span>
                                                @else
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa fa-triangle-exclamation mr-1"></i> Risiko Jatuh S (&lt; 5s)</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Dual-Task TUG -->
                                    <tr>
                                        <td class="font-w600 text-dark align-middle">Dual-Task TUG</td>
                                        <td class="text-center font-w700 text-primary align-middle">{{ $assessment->keseimbangan_dual_task_tug ? $assessment->keseimbangan_dual_task_tug . ' Detik' : '-' }}</td>
                                        <td class="align-middle">
                                            <div class="cutoff-list">
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-success">&le; 4.5 dtk</span>
                                                    <span class="cutoff-desc">Normal (&Delta; selisih TUG)</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-warning">&gt; 4.5 dtk</span>
                                                    <span class="cutoff-desc font-w600 text-warning text-dark">Perlu Perhatian</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if(!empty($assessment->keseimbangan_dual_task_tug))
                                                @php
                                                    $dualVal = (float)str_replace(',', '.', $assessment->keseimbangan_dual_task_tug);
                                                    $baseTug = !empty($assessment->keseimbangan_tug_detik) ? (float)str_replace(',', '.', $assessment->keseimbangan_tug_detik) : null;
                                                @endphp
                                                @if($baseTug !== null && $baseTug > 0)
                                                    @php $diff = $dualVal - $baseTug; @endphp
                                                    @if($diff <= 4.5)
                                                        <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Dual-Task Normal (&Delta; {{ ($diff >= 0 ? '+' : '') . number_format($diff, 1) }}s)</span>
                                                    @else
                                                        <span class="badge font-w600" style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa fa-triangle-exclamation mr-1"></i> Perlu Perhatian (&Delta; +{{ number_format($diff, 1) }}s)</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-light border text-muted font-w600" style="font-size: 11px;">{{ $dualVal }}s</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- FES-I -->
                                    <tr>
                                        <td class="font-w600 text-dark align-middle">Falls Efficacy Scale – Int. (FES-I)</td>
                                        <td class="text-center font-w700 text-primary align-middle">{{ $assessment->keseimbangan_fesi_skor !== null ? $assessment->keseimbangan_fesi_skor . ' / 64' : '-' }}</td>
                                        <td class="align-middle">
                                            <div class="cutoff-list">
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-success">16 – 19</span>
                                                    <span class="cutoff-desc">Ketakutan Rendah</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-warning">20 – 27</span>
                                                    <span class="cutoff-desc">Ketakutan Sedang</span>
                                                </div>
                                                <div class="cutoff-item">
                                                    <span class="cutoff-badge cutoff-badge-danger">28 – 64</span>
                                                    <span class="cutoff-desc font-w600 text-danger">Ketakutan Jatuh Tinggi</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($assessment->keseimbangan_fesi_skor !== null)
                                                @if($assessment->keseimbangan_fesi_skor <= 19)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa fa-check-circle mr-1"></i> Ketakutan Rendah</span>
                                                @elseif($assessment->keseimbangan_fesi_skor <= 27)
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa fa-triangle-exclamation mr-1"></i> Ketakutan Sedang</span>
                                                @else
                                                    <span class="badge font-w600" style="font-size: 11px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;"><i class="fa fa-circle-exclamation mr-1"></i> Ketakutan Jatuh Tinggi</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3 bg-light rounded border mb-2">
                            <small class="text-muted font-w700 d-block mb-1.5" style="font-size: 11px; text-transform: uppercase;">Temuan Postur Tubuh (Observasi):</small>
                            @if(is_array($assessment->postur_temuan) && count($assessment->postur_temuan) > 0)
                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                    @foreach($assessment->postur_temuan as $pt)
                                        <span class="badge badge-light border font-w600 text-dark" style="font-size: 11.5px; padding: 4px 8px;">{{ $pt }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 12.5px;">- Tidak ada kelainan postur khusus</span>
                            @endif
                            @if($assessment->postur_tangan_tongkat)
                                <div class="mt-2 text-dark font-w600" style="font-size: 12px;">
                                    <strong>Postur Tangan Tongkat:</strong> {{ $assessment->postur_tangan_tongkat }}
                                </div>
                            @endif
                        </div>

                        @if($assessment->keseimbangan_catatan)
                            <div class="p-3 mt-2 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Keseimbangan & Postur:</span>
                                <p class="mb-0 text-dark">{{ $assessment->keseimbangan_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subtest 4.3: Gaya Berjalan (Gait) (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-person-walking text-primary mr-1.5"></i> Subtest 4.3: Pemeriksaan Gaya Berjalan (Gait)
                        </h6>
                        @if($has_sub_4_3)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <table class="table table-bordered mb-3" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td style="width: 25%; font-weight: 600; color: #475569; background: #f8fafc;">Fase Gait Utama</td>
                                    <td style="width: 75%;"><strong class="text-primary">{{ $assessment->gait_fase ?: '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569; background: #f8fafc;">Pola Karakteristik / Deviasi Gait</td>
                                    <td>
                                        @if(is_array($assessment->gait_deviasi) && count($assessment->gait_deviasi) > 0)
                                            <div class="d-flex flex-wrap" style="gap: 6px;">
                                                @foreach($assessment->gait_deviasi as $gd)
                                                    <span class="badge badge-light border font-w600 text-dark" style="font-size: 11.5px; padding: 4px 8px;">{{ $gd }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">- Pola berjalan dalam batas normal</span>
                                        @endif
                                        @if($assessment->gait_deteksi_lantai)
                                            <div class="mt-1 text-dark" style="font-size: 12px;">
                                                <strong>Deteksi Tekstur Lantai:</strong> {{ $assessment->gait_deteksi_lantai }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569; background: #f8fafc;">Penggunaan Alat Bantu Berjalan</td>
                                    <td><strong class="text-dark">{{ $assessment->gait_alat_bantu ?: '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569; background: #f8fafc;">Tes Jarak Berjalan (6MWT / 10MWT)</td>
                                    <td>
                                        @if($assessment->gait_jarak_mwt)
                                            <strong class="text-success">{{ $assessment->gait_jarak_mwt }} Meter (6MWT)</strong>
                                        @endif
                                        @if($assessment->gait_10mwt_kecepatan_nyaman)
                                            <span class="badge badge-light border ml-2">Kecepatan Nyaman: {{ $assessment->gait_10mwt_kecepatan_nyaman }} m/s</span>
                                        @endif
                                        @if($assessment->gait_10mwt_kecepatan_cepat)
                                            <span class="badge badge-light border ml-1">Kecepatan Cepat: {{ $assessment->gait_10mwt_kecepatan_cepat }} m/s</span>
                                        @endif
                                        @if(!$assessment->gait_jarak_mwt && !$assessment->gait_10mwt_kecepatan_nyaman)
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if($assessment->gait_catatan)
                            <div class="p-3 rounded" style="background: #f8fafc; border-1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Pola Berjalan:</span>
                                <p class="mb-0 text-dark">{{ $assessment->gait_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subtest 4.4: Sensoris & Vestibular (1 Kolom Penuh) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-fingerprint text-primary mr-1.5"></i> Subtest 4.4: Sensoris, Propriosepsi & Skrining Vestibular Dasar
                        </h6>
                        @if($has_sub_4_4)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="row" style="font-size: 12.5px;">
                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="p-3 rounded bg-light border h-100">
                                    <small class="text-muted d-block font-w600 mb-1">Taktil / Raba Halus</small>
                                    <strong class="text-primary font-w700">{{ $assessment->sensoris_taktil_raba_halus ?: ($assessment->sensoris_taktil ?: '-') }}</strong>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="p-3 rounded bg-light border h-100">
                                    <small class="text-muted d-block font-w600 mb-1">Pinprick / Nyeri Suhu</small>
                                    <strong class="text-primary font-w700">{{ $assessment->sensoris_taktil_pinprick ?: ($assessment->sensoris_prosedur ?: '-') }}</strong>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="p-3 rounded bg-light border h-100">
                                    <small class="text-muted d-block font-w600 mb-1">Propriosepsi Posisi Sendi</small>
                                    <strong class="text-primary font-w700">{{ $assessment->sensoris_posisi_sendi ?: ($assessment->sensoris_propriosepsi ?: '-') }}</strong>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="p-3 rounded bg-light border h-100">
                                    <small class="text-muted d-block font-w600 mb-1">Kinestetik / Vibrasi</small>
                                    <strong class="text-primary font-w700">{{ $assessment->sensoris_vibrasi ?: ($assessment->sensoris_kinestetik ?: '-') }}</strong>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="p-3 rounded bg-white border h-100">
                                    <small class="text-muted d-block font-w600 mb-1">Head Impulse Test (HIT) / Vestibular</small>
                                    <strong class="text-dark">{{ $assessment->vestibular_hit ?: ($assessment->sensoris_vestibular_head_thrust ?: '-') }}</strong>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="p-3 rounded bg-white border h-100">
                                    <small class="text-muted d-block font-w600 mb-1">Dix-Hallpike Maneuver</small>
                                    <strong class="text-dark">{{ $assessment->vestibular_dix_hallpike ?: ($assessment->sensoris_vestibular_dix_hallpike ?: '-') }}</strong>
                                </div>
                            </div>
                        </div>
                        @if($assessment->sensoris_defisit_lokasi)
                            <div class="p-2.5 rounded border bg-light mb-2" style="font-size: 12.5px;">
                                <strong>Lokasi Defisit Sensoris:</strong> {{ $assessment->sensoris_defisit_lokasi }}
                            </div>
                        @endif
                        @if($assessment->sensoris_catatan)
                            <div class="p-3 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                                <span class="text-muted d-block font-w600 mb-1">Catatan Sensoris & Vestibular:</span>
                                <p class="mb-0 text-dark">{{ $assessment->sensoris_catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Next & Prev Buttons -->
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-sm btn-light font-w600 border" onclick="showModuleTab(3)" style="border-radius: 6px; padding: 6px 14px;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Modul 3
                    </button>
                    <button type="button" class="btn btn-sm btn-primary font-w700" onclick="showModuleTab(5)" style="border-radius: 6px; padding: 6px 14px;">
                        Modul 5: GMFM & Denver II <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 5: INSTRUMEN KHUSUS (GMFM & DENVER II)            -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-5" role="tabpanel" aria-labelledby="tab-modul5-btn">
                
                <!-- Subtest 5.1: GMFM-88 Terpadu -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between flex-wrap" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <h6 class="font-w700 mb-0 mr-2" style="color: #1e40af; font-size: 13.5px;">
                                <i class="fa-solid fa-list-check text-primary mr-1.5"></i> Subtest 5.1: Gross Motor Function Measure (GMFM-88)
                            </h6>
                            @if($has_sub_5_1)
                                <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                    <i class="fa-solid fa-check mr-1"></i> Terisi
                                </span>
                            @else
                                <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                    Kosong
                                </span>
                            @endif
                        </div>
                        @php
                            $has_gmfm_scores = (!empty($assessment->gmfm_dimensi_a_scores) && is_array($assessment->gmfm_dimensi_a_scores) && count(array_filter($assessment->gmfm_dimensi_a_scores, fn($v) => $v !== null && $v !== '' && $v !== '-' && $v !== 'NT')) > 0) ||
                                               (!empty($assessment->gmfm_dimensi_b_scores) && is_array($assessment->gmfm_dimensi_b_scores) && count(array_filter($assessment->gmfm_dimensi_b_scores, fn($v) => $v !== null && $v !== '' && $v !== '-' && $v !== 'NT')) > 0) ||
                                               (!empty($assessment->gmfm_dimensi_c_scores) && is_array($assessment->gmfm_dimensi_c_scores) && count(array_filter($assessment->gmfm_dimensi_c_scores, fn($v) => $v !== null && $v !== '' && $v !== '-' && $v !== 'NT')) > 0) ||
                                               (!empty($assessment->gmfm_dimensi_d_scores) && is_array($assessment->gmfm_dimensi_d_scores) && count(array_filter($assessment->gmfm_dimensi_d_scores, fn($v) => $v !== null && $v !== '' && $v !== '-' && $v !== 'NT')) > 0) ||
                                               (!empty($assessment->gmfm_dimensi_e_scores) && is_array($assessment->gmfm_dimensi_e_scores) && count(array_filter($assessment->gmfm_dimensi_e_scores, fn($v) => $v !== null && $v !== '' && $v !== '-' && $v !== 'NT')) > 0);
                            $has_gmfm_notes = !empty($assessment->gmfm_dimensi_a_catatan) || !empty($assessment->gmfm_dimensi_b_catatan) || !empty($assessment->gmfm_dimensi_c_catatan) || !empty($assessment->gmfm_dimensi_d_catatan) || !empty($assessment->gmfm_dimensi_e_catatan);
                            $has_gmfm_totals = (!empty($assessment->gmfm_total_score) && $assessment->gmfm_total_score > 0) || 
                                               (!empty($assessment->gmfm_total_persen) && $assessment->gmfm_total_persen > 0) ||
                                               (!empty($assessment->gmfm_dimensi_a_total) && $assessment->gmfm_dimensi_a_total > 0) ||
                                               (!empty($assessment->gmfm_dimensi_b_total) && $assessment->gmfm_dimensi_b_total > 0) ||
                                               (!empty($assessment->gmfm_dimensi_c_total) && $assessment->gmfm_dimensi_c_total > 0) ||
                                               (!empty($assessment->gmfm_dimensi_d_total) && $assessment->gmfm_dimensi_d_total > 0) ||
                                               (!empty($assessment->gmfm_dimensi_e_total) && $assessment->gmfm_dimensi_e_total > 0);
                            $has_gmfm = $has_gmfm_scores || $has_gmfm_notes || $has_gmfm_totals;
                        @endphp
                        @if($has_gmfm)
                            <span class="badge badge-primary font-w700" style="font-size: 12px; padding: 4px 10px; border-radius: 6px;">
                                Total GMFM-88: {{ $assessment->gmfm_total_score ?? 0 }}/264 ({{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%)
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        @if($has_gmfm)
                            <!-- GMFM Dimensions Underline Tabs -->
                            <div class="d-flex align-items-center justify-content-between flex-wrap mt-3 mb-3 border-bottom" style="border-color: #e2e8f0; gap: 8px;">
                                <ul class="nav nav-tabs border-bottom-0 gmfm-dim-tabs" id="gmfmShowDimTabs" style="gap: 4px; margin-bottom: -1px;">
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-a" class="nav-link gmfm-dim-btn active" data-target-dim="#gmfm-show-pane-a">
                                            <i class="fa fa-bed mr-2 text-primary"></i> A: Berbaring & Berguling <span class="badge-counter">17</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-b" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-b">
                                            <i class="fa fa-street-view mr-2 text-muted"></i> B: Duduk <span class="badge-counter">20</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-c" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-c">
                                            <i class="fa fa-child mr-2 text-muted"></i> C: Merangkak & Berlutut <span class="badge-counter">14</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-d" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-d">
                                            <i class="fa fa-male mr-2 text-muted"></i> D: Berdiri <span class="badge-counter">13</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-e" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-e">
                                            <i class="fa fa-running mr-2 text-muted"></i> E: Jalan, Lari & Lompat <span class="badge-counter">24</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="d-flex align-items-center p-2 px-3 mt-1 mt-md-0 mb-2 rounded" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; box-shadow: 0 2px 5px rgba(37, 99, 235, 0.08); gap: 8px;">
                                    <span class="font-w700" style="font-size: 11.5px; color: #1e40af; letter-spacing: 0.3px;"><i class="fa-solid fa-calculator mr-1.5" style="color: #2563eb;"></i> TOTAL GMFM-88:</span>
                                    <span class="badge font-w800" style="font-size: 12px; padding: 4px 10px; border-radius: 6px; background: #2563eb; color: #ffffff; letter-spacing: 0.3px; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.2);">{{ $assessment->gmfm_total_score ?? 0 }} / 264</span>
                                    <span class="badge font-w800" style="font-size: 12px; padding: 4px 10px; border-radius: 6px; background: #059669; color: #ffffff; letter-spacing: 0.3px; box-shadow: 0 1px 3px rgba(5, 150, 105, 0.2);">{{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%</span>
                                </div>
                            </div>

                            <!-- DIMENSI A -->
                            <div class="gmfm-show-pane" id="gmfm-show-pane-a">
                                <div class="card mb-3 gmfm-dim-score-card">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-12 mb-2 mb-md-0">
                                                <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px;">Skor Dimensi A (Berbaring & Berguling)</small>
                                                <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 24px;">
                                                    {{ $assessment->gmfm_dimensi_a_total ?? 0 }} <span style="font-size: 14px; color: #64748b;">/ 51</span>
                                                </h3>
                                            </div>
                                            <div class="col-md-5 col-12 mb-2 mb-md-0">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi A:</small>
                                                    <strong class="text-primary font-w800">{{ number_format($assessment->gmfm_dimensi_a_persen ?? 0, 1) }}%</strong>
                                                </div>
                                                <div class="progress" style="height: 8px; border-radius: 4px; background: #dbeafe;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $assessment->gmfm_dimensi_a_persen ?? 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 text-md-right">
                                                <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi:</small>
                                                <span class="badge {{ ($assessment->gmfm_dimensi_a_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_a_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700 px-3 py-1.5" style="font-size: 11.5px; border-radius: 6px;">
                                                    {{ ($assessment->gmfm_dimensi_a_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_a_persen ?? 0) >= 50 ? 'Sedang (Perlu Stimulasi)' : 'Keterbatasan Signifikan') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $gmfm_a_items = config('gmfm.dimensions.A.items', []);
                                    $g_a_scores = is_array($assessment->gmfm_dimensi_a_scores) ? $assessment->gmfm_dimensi_a_scores : [];
                                @endphp
                                <div class="table-responsive border rounded" style="max-height: 280px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 8%; text-align: center;">No</th>
                                                <th style="width: 77%;">Aktivitas Gerakan</th>
                                                <th style="width: 15%; text-align: center;">Skor (0-3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gmfm_a_items as $no => $item)
                                                @php $scA = $g_a_scores[$no] ?? null; @endphp
                                                <tr>
                                                    <td class="text-center text-muted font-w700">{{ $no }}</td>
                                                    <td>{{ $item['action'] }}</td>
                                                    <td class="text-center font-w700">
                                                        @if($scA === '3' || $scA === 3) <span class="badge badge-success px-2">3 (Sempurna)</span>
                                                        @elseif($scA === '2' || $scA === 2) <span class="badge badge-primary px-2">2 (Sebagian)</span>
                                                        @elseif($scA === '1' || $scA === 1) <span class="badge badge-warning text-dark px-2">1 (Mulai)</span>
                                                        @elseif($scA === '0' || $scA === 0) <span class="badge badge-danger px-2">0 (Tidak)</span>
                                                        @elseif($scA === 'NT') <span class="badge badge-light border px-2">NT</span>
                                                        @else <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($assessment->gmfm_dimensi_a_catatan)
                                    <small class="text-muted d-block mt-2 font-italic">Catatan: {{ $assessment->gmfm_dimensi_a_catatan }}</small>
                                @endif
                            </div>

                            <!-- DIMENSI B -->
                            <div class="gmfm-show-pane" id="gmfm-show-pane-b" style="display: none;">
                                <div class="card mb-3 gmfm-dim-score-card">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-12 mb-2 mb-md-0">
                                                <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px;">Skor Dimensi B (Duduk)</small>
                                                <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 24px;">
                                                    {{ $assessment->gmfm_dimensi_b_total ?? 0 }} <span style="font-size: 14px; color: #64748b;">/ 60</span>
                                                </h3>
                                            </div>
                                            <div class="col-md-5 col-12 mb-2 mb-md-0">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi B:</small>
                                                    <strong class="text-primary font-w800">{{ number_format($assessment->gmfm_dimensi_b_persen ?? 0, 1) }}%</strong>
                                                </div>
                                                <div class="progress" style="height: 8px; border-radius: 4px; background: #dbeafe;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $assessment->gmfm_dimensi_b_persen ?? 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 text-md-right">
                                                <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi:</small>
                                                <span class="badge {{ ($assessment->gmfm_dimensi_b_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_b_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700 px-3 py-1.5" style="font-size: 11.5px; border-radius: 6px;">
                                                    {{ ($assessment->gmfm_dimensi_b_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_b_persen ?? 0) >= 50 ? 'Sedang (Perlu Stimulasi)' : 'Keterbatasan Signifikan') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $gmfm_b_items = config('gmfm.dimensions.B.items', []);
                                    $g_b_scores = is_array($assessment->gmfm_dimensi_b_scores) ? $assessment->gmfm_dimensi_b_scores : [];
                                @endphp
                                <div class="table-responsive border rounded" style="max-height: 280px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 8%; text-align: center;">No</th>
                                                <th style="width: 77%;">Aktivitas Gerakan</th>
                                                <th style="width: 15%; text-align: center;">Skor (0-3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gmfm_b_items as $no => $item)
                                                @php $scB = $g_b_scores[$no] ?? null; @endphp
                                                <tr>
                                                    <td class="text-center text-muted font-w700">{{ $no }}</td>
                                                    <td>{{ $item['action'] }}</td>
                                                    <td class="text-center font-w700">
                                                        @if($scB === '3' || $scB === 3) <span class="badge badge-success px-2">3 (Sempurna)</span>
                                                        @elseif($scB === '2' || $scB === 2) <span class="badge badge-primary px-2">2 (Sebagian)</span>
                                                        @elseif($scB === '1' || $scB === 1) <span class="badge badge-warning text-dark px-2">1 (Mulai)</span>
                                                        @elseif($scB === '0' || $scB === 0) <span class="badge badge-danger px-2">0 (Tidak)</span>
                                                        @elseif($scB === 'NT') <span class="badge badge-light border px-2">NT</span>
                                                        @else <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($assessment->gmfm_dimensi_b_catatan)
                                    <small class="text-muted d-block mt-2 font-italic">Catatan: {{ $assessment->gmfm_dimensi_b_catatan }}</small>
                                @endif
                            </div>

                            <!-- DIMENSI C -->
                            <div class="gmfm-show-pane" id="gmfm-show-pane-c" style="display: none;">
                                <div class="card mb-3 gmfm-dim-score-card">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-12 mb-2 mb-md-0">
                                                <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px;">Skor Dimensi C (Merangkak & Berlutut)</small>
                                                <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 24px;">
                                                    {{ $assessment->gmfm_dimensi_c_total ?? 0 }} <span style="font-size: 14px; color: #64748b;">/ 42</span>
                                                </h3>
                                            </div>
                                            <div class="col-md-5 col-12 mb-2 mb-md-0">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi C:</small>
                                                    <strong class="text-primary font-w800">{{ number_format($assessment->gmfm_dimensi_c_persen ?? 0, 1) }}%</strong>
                                                </div>
                                                <div class="progress" style="height: 8px; border-radius: 4px; background: #dbeafe;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $assessment->gmfm_dimensi_c_persen ?? 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 text-md-right">
                                                <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi:</small>
                                                <span class="badge {{ ($assessment->gmfm_dimensi_c_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_c_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700 px-3 py-1.5" style="font-size: 11.5px; border-radius: 6px;">
                                                    {{ ($assessment->gmfm_dimensi_c_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_c_persen ?? 0) >= 50 ? 'Sedang (Perlu Stimulasi)' : 'Keterbatasan Signifikan') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $gmfm_c_items = config('gmfm.dimensions.C.items', []);
                                    $g_c_scores = is_array($assessment->gmfm_dimensi_c_scores) ? $assessment->gmfm_dimensi_c_scores : [];
                                @endphp
                                <div class="table-responsive border rounded" style="max-height: 280px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 8%; text-align: center;">No</th>
                                                <th style="width: 77%;">Aktivitas Gerakan</th>
                                                <th style="width: 15%; text-align: center;">Skor (0-3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gmfm_c_items as $no => $item)
                                                @php $scC = $g_c_scores[$no] ?? null; @endphp
                                                <tr>
                                                    <td class="text-center text-muted font-w700">{{ $no }}</td>
                                                    <td>{{ $item['action'] }}</td>
                                                    <td class="text-center font-w700">
                                                        @if($scC === '3' || $scC === 3) <span class="badge badge-success px-2">3 (Sempurna)</span>
                                                        @elseif($scC === '2' || $scC === 2) <span class="badge badge-primary px-2">2 (Sebagian)</span>
                                                        @elseif($scC === '1' || $scC === 1) <span class="badge badge-warning text-dark px-2">1 (Mulai)</span>
                                                        @elseif($scC === '0' || $scC === 0) <span class="badge badge-danger px-2">0 (Tidak)</span>
                                                        @elseif($scC === 'NT') <span class="badge badge-light border px-2">NT</span>
                                                        @else <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($assessment->gmfm_dimensi_c_catatan)
                                    <small class="text-muted d-block mt-2 font-italic">Catatan: {{ $assessment->gmfm_dimensi_c_catatan }}</small>
                                @endif
                            </div>

                            <!-- DIMENSI D -->
                            <div class="gmfm-show-pane" id="gmfm-show-pane-d" style="display: none;">
                                <div class="card mb-3 gmfm-dim-score-card">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-12 mb-2 mb-md-0">
                                                <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px;">Skor Dimensi D (Berdiri)</small>
                                                <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 24px;">
                                                    {{ $assessment->gmfm_dimensi_d_total ?? 0 }} <span style="font-size: 14px; color: #64748b;">/ 39</span>
                                                </h3>
                                            </div>
                                            <div class="col-md-5 col-12 mb-2 mb-md-0">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi D:</small>
                                                    <strong class="text-primary font-w800">{{ number_format($assessment->gmfm_dimensi_d_persen ?? 0, 1) }}%</strong>
                                                </div>
                                                <div class="progress" style="height: 8px; border-radius: 4px; background: #dbeafe;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $assessment->gmfm_dimensi_d_persen ?? 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 text-md-right">
                                                <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi:</small>
                                                <span class="badge {{ ($assessment->gmfm_dimensi_d_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_d_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700 px-3 py-1.5" style="font-size: 11.5px; border-radius: 6px;">
                                                    {{ ($assessment->gmfm_dimensi_d_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_d_persen ?? 0) >= 50 ? 'Sedang (Perlu Stimulasi)' : 'Keterbatasan Signifikan') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $gmfm_d_items = config('gmfm.dimensions.D.items', []);
                                    $g_d_scores = is_array($assessment->gmfm_dimensi_d_scores) ? $assessment->gmfm_dimensi_d_scores : [];
                                @endphp
                                <div class="table-responsive border rounded" style="max-height: 280px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 8%; text-align: center;">No</th>
                                                <th style="width: 77%;">Aktivitas Gerakan</th>
                                                <th style="width: 15%; text-align: center;">Skor (0-3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gmfm_d_items as $no => $item)
                                                @php $scD = $g_d_scores[$no] ?? null; @endphp
                                                <tr>
                                                    <td class="text-center text-muted font-w700">{{ $no }}</td>
                                                    <td>{{ $item['action'] }}</td>
                                                    <td class="text-center font-w700">
                                                        @if($scD === '3' || $scD === 3) <span class="badge badge-success px-2">3 (Sempurna)</span>
                                                        @elseif($scD === '2' || $scD === 2) <span class="badge badge-primary px-2">2 (Sebagian)</span>
                                                        @elseif($scD === '1' || $scD === 1) <span class="badge badge-warning text-dark px-2">1 (Mulai)</span>
                                                        @elseif($scD === '0' || $scD === 0) <span class="badge badge-danger px-2">0 (Tidak)</span>
                                                        @elseif($scD === 'NT') <span class="badge badge-light border px-2">NT</span>
                                                        @else <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($assessment->gmfm_dimensi_d_catatan)
                                    <small class="text-muted d-block mt-2 font-italic">Catatan: {{ $assessment->gmfm_dimensi_d_catatan }}</small>
                                @endif
                            </div>

                            <!-- DIMENSI E -->
                            <div class="gmfm-show-pane" id="gmfm-show-pane-e" style="display: none;">
                                <div class="card mb-3 gmfm-dim-score-card">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-12 mb-2 mb-md-0">
                                                <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px;">Skor Dimensi E (Jalan, Lari & Lompat)</small>
                                                <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 24px;">
                                                    {{ $assessment->gmfm_dimensi_e_total ?? 0 }} <span style="font-size: 14px; color: #64748b;">/ 72</span>
                                                </h3>
                                            </div>
                                            <div class="col-md-5 col-12 mb-2 mb-md-0">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi E:</small>
                                                    <strong class="text-primary font-w800">{{ number_format($assessment->gmfm_dimensi_e_persen ?? 0, 1) }}%</strong>
                                                </div>
                                                <div class="progress" style="height: 8px; border-radius: 4px; background: #dbeafe;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $assessment->gmfm_dimensi_e_persen ?? 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 text-md-right">
                                                <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi:</small>
                                                <span class="badge {{ ($assessment->gmfm_dimensi_e_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_e_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700 px-3 py-1.5" style="font-size: 11.5px; border-radius: 6px;">
                                                    {{ ($assessment->gmfm_dimensi_e_persen ?? 0) >= 80 ? 'Sangat Baik (Mandiri)' : (($assessment->gmfm_dimensi_e_persen ?? 0) >= 50 ? 'Sedang (Perlu Stimulasi)' : 'Keterbatasan Signifikan') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $gmfm_e_items = config('gmfm.dimensions.E.items', []);
                                    $g_e_scores = is_array($assessment->gmfm_dimensi_e_scores) ? $assessment->gmfm_dimensi_e_scores : [];
                                @endphp
                                <div class="table-responsive border rounded" style="max-height: 280px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 8%; text-align: center;">No</th>
                                                <th style="width: 77%;">Aktivitas Gerakan</th>
                                                <th style="width: 15%; text-align: center;">Skor (0-3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gmfm_e_items as $no => $item)
                                                @php $scE = $g_e_scores[$no] ?? null; @endphp
                                                <tr>
                                                    <td class="text-center text-muted font-w700">{{ $no }}</td>
                                                    <td>{{ $item['action'] }}</td>
                                                    <td class="text-center font-w700">
                                                        @if($scE === '3' || $scE === 3) <span class="badge badge-success px-2">3 (Sempurna)</span>
                                                        @elseif($scE === '2' || $scE === 2) <span class="badge badge-primary px-2">2 (Sebagian)</span>
                                                        @elseif($scE === '1' || $scE === 1) <span class="badge badge-warning text-dark px-2">1 (Mulai)</span>
                                                        @elseif($scE === '0' || $scE === 0) <span class="badge badge-danger px-2">0 (Tidak)</span>
                                                        @elseif($scE === 'NT') <span class="badge badge-light border px-2">NT</span>
                                                        @else <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($assessment->gmfm_dimensi_e_catatan)
                                    <small class="text-muted d-block mt-2 font-italic">Catatan: {{ $assessment->gmfm_dimensi_e_catatan }}</small>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fa fa-info-circle fa-2x mb-2 text-muted"></i>
                                <p class="mb-0 font-w500" style="font-size: 13px;">Item GMFM-88 belum diuji / diisi.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subtest 5.2: Skala Perkembangan Denver II (DDST II) -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between flex-wrap" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <h6 class="font-w700 mb-0 mr-2" style="color: #1e40af; font-size: 13.5px;">
                                <i class="fa-solid fa-graduation-cap text-primary mr-1.5"></i> Subtest 5.2: Skala Perkembangan Denver II (DDST II)
                            </h6>
                            @if($has_sub_5_2)
                                <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                    <i class="fa-solid fa-check mr-1"></i> Terisi
                                </span>
                            @else
                                <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                    Kosong
                                </span>
                            @endif
                        </div>
                        @php
                            $has_denver_counts = (($assessment->denver_pass_count !== null && $assessment->denver_pass_count > 0) ||
                                                  ($assessment->denver_fail_count !== null && $assessment->denver_fail_count > 0) ||
                                                  ($assessment->denver_refusal_count !== null && $assessment->denver_refusal_count > 0) ||
                                                  ($assessment->denver_no_count !== null && $assessment->denver_no_count > 0));
                            $has_denver = $has_denver_counts || 
                                          (!empty($assessment->denver_data) && is_array($assessment->denver_data) && count(array_filter($assessment->denver_data, fn($v) => !empty($v['score']) && $v['score'] !== '-')) > 0) || 
                                          !empty($assessment->denver_kesimpulan) || 
                                          !empty($assessment->denver_catatan);
                        @endphp
                        @if($has_denver)
                            <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                                <span class="badge font-w700" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; padding: 4px 7px;">P: {{ $assessment->denver_pass_count ?? 0 }}</span>
                                <span class="badge font-w700" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; padding: 4px 7px;">F: {{ $assessment->denver_fail_count ?? 0 }}</span>
                                <span class="badge font-w700" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; padding: 4px 7px;">R: {{ $assessment->denver_refusal_count ?? 0 }}</span>
                                <span class="badge font-w700" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; padding: 4px 7px;">NO: {{ $assessment->denver_no_count ?? 0 }}</span>
                                <span class="badge badge-primary font-w700 text-uppercase ml-2" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->denver_kesimpulan ?: 'Evaluasi DDST II' }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        @if($has_denver)
                            <!-- Denver Recap Banner (Light Blue Medis) -->
                            <div class="card mb-4 gmfm-dim-score-card">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-lg-7 col-12 mb-3 mb-lg-0">
                                            <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px; letter-spacing: 0.5px;">
                                                <i class="fa-solid fa-chart-pie mr-1 text-primary"></i> Rekapitulasi Hasil Skrining DDST II (19 Task)
                                            </small>
                                            <div class="d-flex align-items-center flex-wrap mt-2" style="gap: 8px;">
                                                <span class="badge px-3 py-2 font-w700" style="background: #eff6ff; color: #1e40af; border: 1.5px solid #bfdbfe; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.08);">
                                                    <i class="fa fa-check mr-1" style="color: #2563eb;"></i> Pass (P): <strong style="color: #1e3a8a;">{{ $assessment->denver_pass_count ?? 0 }}</strong>
                                                </span>
                                                <span class="badge px-3 py-2 font-w700" style="background: #eff6ff; color: #1e40af; border: 1.5px solid #bfdbfe; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.08);">
                                                    <i class="fa fa-times mr-1" style="color: #2563eb;"></i> Fail (F): <strong style="color: #1e3a8a;">{{ $assessment->denver_fail_count ?? 0 }}</strong>
                                                </span>
                                                <span class="badge px-3 py-2 font-w700" style="background: #eff6ff; color: #1e40af; border: 1.5px solid #bfdbfe; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.08);">
                                                    <i class="fa fa-ban mr-1" style="color: #2563eb;"></i> Refusal (R): <strong style="color: #1e3a8a;">{{ $assessment->denver_refusal_count ?? 0 }}</strong>
                                                </span>
                                                <span class="badge px-3 py-2 font-w700" style="background: #eff6ff; color: #1e40af; border: 1.5px solid #bfdbfe; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.08);">
                                                    <i class="fa fa-minus-circle mr-1" style="color: #2563eb;"></i> No Opp (NO): <strong style="color: #1e3a8a;">{{ $assessment->denver_no_count ?? 0 }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-12 text-lg-right">
                                            <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Status Perkembangan:</small>
                                            <span class="badge px-3 py-2 font-w700 text-uppercase" style="font-size: 12.5px; border-radius: 6px; {{ $assessment->denver_kesimpulan == 'Normal (Sesuai Usia)' ? 'background:#10b981;color:white;' : ($assessment->denver_kesimpulan == 'Suspect (Meragukan)' ? 'background:#f59e0b;color:white;' : ($assessment->denver_kesimpulan == 'Keterlambatan Perkembangan' ? 'background:#ef4444;color:white;' : 'background:#e2e8f0;color:#1e293b;')) }}">
                                                {{ $assessment->denver_kesimpulan ?: 'Tercatat' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @php
                                $denver_data = is_array($assessment->denver_data) ? $assessment->denver_data : [];
                                $denver_sectors = config('denver.sectors', []);
                            @endphp

                            <!-- Denver Sectors Navigation Underline Tabs (A, B, C, D) & Summary -->
                            <div class="d-flex align-items-center justify-content-between flex-wrap mt-3 mb-3 border-bottom" style="border-color: #e2e8f0; gap: 8px;">
                                <ul class="nav nav-tabs border-bottom-0 denver-show-sec-tabs" id="denverShowSecTabs" style="gap: 4px; margin-bottom: -1px;">
                                    <li class="nav-item">
                                        <a href="#denver-show-pane-a" class="nav-link denver-show-sec-btn active" data-target-dim="#denver-show-pane-a">
                                            <i class="fa-solid fa-users mr-2 text-primary"></i> A: Personal Sosial <span class="badge-counter">4</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#denver-show-pane-b" class="nav-link denver-show-sec-btn" data-target-dim="#denver-show-pane-b">
                                            <i class="fa-solid fa-hand mr-2 text-muted"></i> B: Motorik Halus - Adaptif <span class="badge-counter">5</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#denver-show-pane-c" class="nav-link denver-show-sec-btn" data-target-dim="#denver-show-pane-c">
                                            <i class="fa-solid fa-comments mr-2 text-muted"></i> C: Bahasa <span class="badge-counter">5</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#denver-show-pane-d" class="nav-link denver-show-sec-btn" data-target-dim="#denver-show-pane-d">
                                            <i class="fa-solid fa-running mr-2 text-muted"></i> D: Motorik Kasar <span class="badge-counter">5</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="d-flex align-items-center p-2 px-3 mt-1 mt-md-0 mb-2 rounded" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; box-shadow: 0 2px 5px rgba(37, 99, 235, 0.08); gap: 8px;">
                                    <span class="font-w700" style="font-size: 11.5px; color: #1e40af; letter-spacing: 0.3px;"><i class="fa-solid fa-graduation-cap mr-2" style="color: #2563eb;"></i> TOTAL DDST II:</span>
                                    <span class="badge font-w800" style="font-size: 12px; padding: 4px 10px; border-radius: 6px; background: #2563eb; color: #ffffff; letter-spacing: 0.3px; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.2);">19 Task</span>
                                </div>
                            </div>

                            <!-- Denver Show Sector Panes -->
                            @foreach($denver_sectors as $sKey => $sector)
                                <div class="denver-show-sec-pane" id="denver-show-pane-{{ strtolower($sKey) }}" style="{{ $sKey === 'A' ? '' : 'display: none;' }}">
                                    <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                                        <table class="table table-hover mb-0" style="font-size: 12.5px; vertical-align: middle;">
                                            <thead style="background: #f8fafc; color: #475569; font-size: 11.5px;">
                                                <tr>
                                                    <th style="width: 5%; text-align: center;">No</th>
                                                    <th style="width: 45%;">Nama Task Perkembangan</th>
                                                    <th style="width: 15%; text-align: center;">Rentang Usia</th>
                                                    <th style="width: 15%; text-align: center;">Hasil Uji</th>
                                                    <th style="width: 20%;">Catatan Terapis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sector['tasks'] as $tKey => $task)
                                                    @php
                                                        $tScore = $denver_data[$tKey]['score'] ?? null;
                                                        $tNote = $denver_data[$tKey]['catatan'] ?? null;
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center font-w700 text-muted">{{ $task['no'] }}</td>
                                                        <td>
                                                            <strong class="text-dark">{{ $task['name'] }}</strong>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-light border font-w600" style="font-size: 11px;">{{ $task['age'] }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($tScore === 'P') <span class="badge badge-success font-w700 px-2 py-1" style="font-size: 11px;">Pass (P)</span>
                                                            @elseif($tScore === 'F') <span class="badge badge-danger font-w700 px-2 py-1" style="font-size: 11px;">Fail (F)</span>
                                                            @elseif($tScore === 'R') <span class="badge badge-warning font-w700 px-2 py-1" style="font-size: 11px;">Refusal (R)</span>
                                                            @elseif($tScore === 'NO') <span class="badge badge-secondary font-w700 px-2 py-1" style="font-size: 11px;">No Opp (NO)</span>
                                                            @else <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($tNote)
                                                                <span class="text-dark font-w500" style="font-size: 12px;">{{ $tNote }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                            @if($assessment->denver_catatan)
                                <div class="mt-2 p-3 bg-light rounded border">
                                    <small class="text-muted d-block font-w600 mb-1">Catatan Observasi Skala Denver:</small>
                                    <span class="text-dark" style="font-size: 12.5px;">{{ $assessment->denver_catatan }}</span>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fa fa-info-circle fa-2x mb-2 text-muted"></i>
                                <p class="mb-0 font-w500" style="font-size: 13px;">Skala Denver (DDST II) belum diuji / diisi.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Next & Prev Buttons -->
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-sm btn-light font-w600 border" onclick="showModuleTab(4)" style="border-radius: 6px; padding: 6px 14px;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Modul 4
                    </button>
                    <button type="button" class="btn btn-sm btn-primary font-w700" onclick="showModuleTab(6)" style="border-radius: 6px; padding: 6px 14px;">
                        Modul 6: Rencana Terapi & TTD <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 6: RENCANA TERAPI & VERIFIKASI TTD                -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-6" role="tabpanel" aria-labelledby="tab-modul6-btn">
                
                <!-- Subtest 6.1: Perencanaan Terapi & Dosis -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-calendar-check text-primary mr-1.5"></i> Subtest 6.1: Perencanaan Terapi & Modalitas Intervensi
                        </h6>
                        @if($has_sub_6_1)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Intervensi 4 Kategori Grid -->
                        <div class="row mb-4">
                            <!-- Modalitas Fisik -->
                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <div class="p-3 bg-white rounded border h-100">
                                    <span class="text-muted d-block font-w700 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                                        <i class="fa-solid fa-plug text-primary mr-1"></i> Modalitas Fisik:
                                    </span>
                                    @if(is_array($assessment->rencana_modalitas_fisik) && count($assessment->rencana_modalitas_fisik) > 0)
                                        <div class="d-flex flex-wrap" style="gap: 4px;">
                                            @foreach($assessment->rencana_modalitas_fisik as $mf)
                                                @if($mf !== 'Lainnya')
                                                    <span class="badge badge-light border text-dark font-w600" style="font-size: 11px; padding: 4px 8px;">
                                                        <i class="fa fa-check text-primary mr-1"></i> {{ $mf }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">-</span>
                                    @endif
                                    @if($assessment->rencana_modalitas_lainnya)
                                        <div class="mt-2" style="font-size: 11.5px;">
                                            <span class="badge font-w600" style="font-size: 11px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                Lainnya: {{ $assessment->rencana_modalitas_lainnya }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Manual Terapi -->
                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <div class="p-3 bg-white rounded border h-100">
                                    <span class="text-muted d-block font-w700 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                                        <i class="fa-solid fa-hand-holding-medical text-primary mr-1"></i> Manual Terapi:
                                    </span>
                                    @if(is_array($assessment->rencana_manual_terapi) && count($assessment->rencana_manual_terapi) > 0)
                                        <div class="d-flex flex-wrap" style="gap: 4px;">
                                            @foreach($assessment->rencana_manual_terapi as $mt)
                                                @if($mt !== 'Lainnya')
                                                    <span class="badge badge-light border text-dark font-w600" style="font-size: 11px; padding: 4px 8px;">
                                                        <i class="fa fa-check text-primary mr-1"></i> {{ $mt }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">-</span>
                                    @endif
                                    @if($assessment->rencana_manual_lainnya)
                                        <div class="mt-2" style="font-size: 11.5px;">
                                            <span class="badge font-w600" style="font-size: 11px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                Lainnya: {{ $assessment->rencana_manual_lainnya }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Latihan Terapi -->
                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <div class="p-3 bg-white rounded border h-100">
                                    <span class="text-muted d-block font-w700 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                                        <i class="fa-solid fa-dumbbell text-primary mr-1"></i> Latihan Terapi:
                                    </span>
                                    @if(is_array($assessment->rencana_latihan_terapi) && count($assessment->rencana_latihan_terapi) > 0)
                                        <div class="d-flex flex-wrap" style="gap: 4px;">
                                            @foreach($assessment->rencana_latihan_terapi as $lt)
                                                @if($lt !== 'Lainnya')
                                                    <span class="badge badge-light border text-dark font-w600" style="font-size: 11px; padding: 4px 8px;">
                                                        <i class="fa fa-check text-primary mr-1"></i> {{ $lt }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">-</span>
                                    @endif
                                    @if($assessment->rencana_latihan_lainnya)
                                        <div class="mt-2" style="font-size: 11.5px;">
                                            <span class="badge font-w600" style="font-size: 11px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                Lainnya: {{ $assessment->rencana_latihan_lainnya }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Edukasi & Konseling -->
                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <div class="p-3 bg-white rounded border h-100">
                                    <span class="text-muted d-block font-w700 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                                        <i class="fa-solid fa-graduation-cap text-primary mr-1"></i> Edukasi & Konseling:
                                    </span>
                                    @if(is_array($assessment->rencana_edukasi_konseling) && count($assessment->rencana_edukasi_konseling) > 0)
                                        <div class="d-flex flex-wrap" style="gap: 4px;">
                                            @foreach($assessment->rencana_edukasi_konseling as $ek)
                                                @if($ek !== 'Lainnya')
                                                    <span class="badge badge-light border text-dark font-w600" style="font-size: 11px; padding: 4px 8px;">
                                                        <i class="fa fa-check text-primary mr-1"></i> {{ $ek }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">-</span>
                                    @endif
                                    @if($assessment->rencana_edukasi_lainnya)
                                        <div class="mt-2" style="font-size: 11.5px;">
                                            <span class="badge font-w600" style="font-size: 11px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                Lainnya: {{ $assessment->rencana_edukasi_lainnya }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Program & Pengaturan Dosis Terapi Cards (Spacious & Clean) -->
                        <div class="p-3 rounded border" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                            <span class="font-w700 text-uppercase d-block mb-3" style="font-size: 11.5px; color: #1e40af; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-sliders mr-1 text-primary"></i> Program & Pengaturan Dosis Terapi:
                            </span>
                            <div class="row text-center">
                                <div class="col-lg-3 col-sm-6 col-12 mb-2 mb-lg-0">
                                    <div class="p-3 bg-white rounded border h-100 shadow-none">
                                        <small class="text-muted font-w600 d-block mb-1" style="font-size: 11px;">Frekuensi Terapi</small>
                                        <strong class="text-primary font-w800" style="font-size: 16px;">
                                            {{ $assessment->rencana_dosis_frekuensi ? $assessment->rencana_dosis_frekuensi . ' x/minggu' : '-' }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-2 mb-lg-0">
                                    <div class="p-3 bg-white rounded border h-100 shadow-none">
                                        <small class="text-muted font-w600 d-block mb-1" style="font-size: 11px;">Durasi per Sesi</small>
                                        <strong class="text-info font-w800" style="font-size: 16px;">
                                            {{ $assessment->rencana_dosis_durasi ? $assessment->rencana_dosis_durasi . ' Menit' : '-' }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="p-3 bg-white rounded border h-100 shadow-none">
                                        <small class="text-muted font-w600 d-block mb-1" style="font-size: 11px;">Estimasi Total Sesi</small>
                                        <strong class="font-w800" style="font-size: 16px; color: #1e293b;">
                                            {{ $assessment->rencana_dosis_total_sesi ? $assessment->rencana_dosis_total_sesi . ' Sesi' : '-' }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="p-3 bg-white rounded border h-100 shadow-none">
                                        <small class="text-muted font-w600 d-block mb-1" style="font-size: 11px;">Jadwal Re-assessment</small>
                                        <strong class="text-success font-w800" style="font-size: 16px;">
                                            {{ $assessment->rencana_dosis_reassessment ?: '-' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subtest 6.2: Evaluasi Klinis & Konfirmasi Tanda Tangan -->
                <div class="card mb-4 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-clipboard-check text-primary mr-1.5"></i> Subtest 6.2: Kesimpulan Klinis, Rekomendasi & Konfirmasi Terapis
                        </h6>
                        @if($has_sub_6_2)
                            <span class="badge font-w700" style="font-size: 10px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-check mr-1"></i> Terisi
                            </span>
                        @else
                            <span class="badge font-w500" style="font-size: 10px; padding: 3px 7px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                Kosong
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="row">
                            <!-- Kesimpulan Terapis -->
                            <div class="col-md-6 col-12 mb-3 mb-md-0">
                                <div class="p-3 rounded h-100" style="background: #f0f7ff; border: 1px solid #bfdbfe; border-left: 4px solid #2563eb;">
                                    <span class="font-w700 d-block mb-2" style="font-size: 12.5px; color: #1e40af;">
                                        <i class="fa-solid fa-user-doctor mr-1.5 text-primary"></i> Kesimpulan & Evaluasi Klinis Terapis:
                                    </span>
                                    <div style="font-size: 13px; color: #1e293b; line-height: 1.7; white-space: pre-line;">
                                        {{ $assessment->kesimpulan ?: '-' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Rencana Terapi & Target -->
                            <div class="col-md-6 col-12">
                                <div class="p-3 rounded h-100" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #10b981;">
                                    <span class="font-w700 d-block mb-2" style="font-size: 12.5px; color: #166534;">
                                        <i class="fa-solid fa-bullseye mr-1.5 text-success"></i> Rencana Program Terapi Lanjutan & Target:
                                    </span>
                                    <div style="font-size: 13px; color: #1e293b; line-height: 1.7; white-space: pre-line;">
                                        {{ $assessment->rencana_terapi ?: '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Verifikasi & Tanda Tangan Terapis Card -->
                        <div class="mt-4 p-3 rounded border" style="background: #f8fafc;">
                            <div class="row align-items-center">
                                <div class="col-md-8 col-12 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3" style="width: 44px; height: 44px; border-radius: 50%; background: #dcfce7; display: flex; align-items: center; justify-content: center; color: #166534; font-size: 20px; flex-shrink: 0; border: 1px solid #bbf7d0;">
                                            <i class="fa-solid fa-shield-halved"></i>
                                        </div>
                                        <div>
                                            <span class="badge badge-success font-w700 mb-1" style="font-size: 10.5px; padding: 3px 8px; border-radius: 4px;">
                                                <i class="fa-solid fa-check-circle mr-1"></i> Asesmen Terverifikasi Lengkap
                                            </span>
                                            <div class="font-w700 text-dark" style="font-size: 13.5px;">
                                                Terapis Pemeriksa: {{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? 'Terapis Penanggung Jawab') }}
                                            </div>
                                            <small class="text-muted font-w600">
                                                Dokumen resmi rekam medis tersimpan secara permanen pada sistem SIM Rekam Medis Omah Terapi-KU.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 text-md-right">
                                    <div class="d-inline-block text-center p-2 rounded bg-white border" style="min-width: 170px;">
                                        <small class="text-muted d-block font-w600" style="font-size: 10.5px;">Yogyakarta, {{ $assessment->tgl_assessment ? $assessment->tgl_assessment->format('d M Y') : date('d M Y') }}</small>
                                        <div class="my-1">
                                            <span class="badge badge-light border text-primary font-w700" style="font-size: 11px; padding: 4px 10px;">
                                                <i class="fa-solid fa-signature mr-1"></i> Digital Verified
                                            </span>
                                        </div>
                                        <strong class="d-block font-w700 text-dark" style="font-size: 12px;">{{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? 'Terapis Penanggung Jawab') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prev Button & Print Action -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mt-2" style="gap: 8px;">
                    <button type="button" class="btn btn-sm btn-light font-w600 border" onclick="showModuleTab(5)" style="border-radius: 6px; padding: 6px 14px;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Modul 5: GMFM & Denver II
                    </button>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <a href="{{Route('rekam.assessment.print', $rekam->id)}}?download=pdf" target="_blank" class="btn btn-sm btn-success font-w700 text-white" style="border-radius: 6px; padding: 6px 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important;">
                            <i class="fa-solid fa-download mr-1"></i> Unduh PDF
                        </a>
                        <a href="{{Route('rekam.assessment.print', $rekam->id)}}" target="_blank" class="btn btn-sm btn-primary font-w700" style="border-radius: 6px; padding: 6px 18px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;">
                            <i class="fa-solid fa-print mr-1"></i> Cetak Lembar Asesmen Lengkap
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Assessment Modul Grid Tabs (3x2 Layout - Tanpa Scroll Geser) */
.assessment-modul-grid-tabs {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 10px !important;
    width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
    list-style: none !important;
}

@media (max-width: 991px) {
    .assessment-modul-grid-tabs {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 576px) {
    .assessment-modul-grid-tabs {
        grid-template-columns: 1fr !important;
    }
}

.assessment-modul-grid-tabs .nav-item {
    margin: 0 !important;
    display: flex !important;
}

.assessment-modul-grid-tabs .nav-link {
    width: 100% !important;
    display: flex !important;
    align-items: center !important;
    padding: 11px 14px !important;
    border-radius: 8px !important;
    border: 1.5px solid #e2e8f0 !important;
    background: #f8fafc !important;
    color: #475569 !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    text-decoration: none !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    cursor: pointer !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
}

.assessment-modul-grid-tabs .nav-link .tab-module-num {
    width: 24px !important;
    height: 24px !important;
    border-radius: 50% !important;
    background: #e2e8f0 !important;
    color: #475569 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    flex-shrink: 0 !important;
    transition: all 0.2s ease !important;
}

.assessment-modul-grid-tabs .nav-link:hover {
    background: #eff6ff !important;
    color: #1d4ed8 !important;
    border-color: #93c5fd !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 3px 8px rgba(37, 99, 235, 0.1) !important;
}

.assessment-modul-grid-tabs .nav-link:hover .tab-module-num {
    background: #dbeafe !important;
    color: #1d4ed8 !important;
}

.assessment-modul-grid-tabs .nav-link.active {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
    border-color: #2563eb !important;
    border-left: 4px solid #2563eb !important;
    color: #1e40af !important;
    font-weight: 700 !important;
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.15) !important;
}

.assessment-modul-grid-tabs .nav-link.active .tab-module-num {
    background: #2563eb !important;
    color: #ffffff !important;
    box-shadow: 0 2px 5px rgba(37, 99, 235, 0.3) !important;
}

/* GMFM Dimensions Underline Tabs */
.gmfm-dim-tabs {
    border-bottom: 2px solid #e2e8f0 !important;
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 0 !important;
}
.gmfm-dim-tabs .gmfm-dim-btn {
    border: none !important;
    border-bottom: 2.5px solid transparent !important;
    background: transparent !important;
    color: #64748b !important;
    font-weight: 600 !important;
    font-size: 12.5px !important;
    padding: 10px 14px !important;
    border-radius: 8px 8px 0 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    text-decoration: none !important;
    transition: all 0.18s ease;
    cursor: pointer;
    margin-bottom: -2px;
}
.gmfm-dim-tabs .gmfm-dim-btn:hover {
    color: #2563eb !important;
    background: #f8fafc !important;
}
.gmfm-dim-tabs .gmfm-dim-btn.active {
    color: #1e40af !important;
    background: #eff6ff !important;
    border-bottom: 2.5px solid #2563eb !important;
    font-weight: 700 !important;
}
.gmfm-dim-tabs .gmfm-dim-btn i,
.denver-show-sec-tabs .denver-show-sec-btn i {
    margin-right: 8px !important;
}
.gmfm-dim-tabs .gmfm-dim-btn .badge-counter {
    font-size: 10.5px;
    padding: 2px 7px;
    border-radius: 999px;
    background: #e2e8f0;
    color: #475569;
    margin-left: 8px;
    font-weight: 700;
    transition: all 0.18s ease;
}
.gmfm-dim-tabs .gmfm-dim-btn.active .badge-counter {
    background: #2563eb;
    color: #ffffff;
}

/* GMFM Dimension Score Summary Card (Light Blue Medis) */
.gmfm-dim-score-card {
    background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%) !important;
    border: 1px solid #bfdbfe !important;
    border-left: 4px solid #2563eb !important;
    border-radius: 10px !important;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.05) !important;
    color: #1e293b !important;
}

/* Denver DDST II Sectors Underline Tabs (Show View) */
.denver-show-sec-tabs {
    border-bottom: 2px solid #e2e8f0 !important;
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 0 !important;
}
.denver-show-sec-tabs .denver-show-sec-btn {
    border: none !important;
    border-bottom: 2.5px solid transparent !important;
    background: transparent !important;
    color: #64748b !important;
    font-weight: 600 !important;
    font-size: 12.5px !important;
    padding: 10px 14px !important;
    border-radius: 8px 8px 0 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    text-decoration: none !important;
    transition: all 0.18s ease;
    cursor: pointer;
    margin-bottom: -2px;
}
.denver-show-sec-tabs .denver-show-sec-btn:hover {
    color: #2563eb !important;
    background: #f8fafc !important;
}
.denver-show-sec-tabs .denver-show-sec-btn.active {
    color: #1e40af !important;
    background: #eff6ff !important;
    border-bottom: 2.5px solid #2563eb !important;
    font-weight: 700 !important;
}
.denver-show-sec-tabs .denver-show-sec-btn .badge-counter {
    font-size: 10.5px;
    padding: 2px 7px;
    border-radius: 999px;
    background: #e2e8f0;
    color: #475569;
    margin-left: 8px;
    font-weight: 700;
    transition: all 0.18s ease;
}
.denver-show-sec-tabs .denver-show-sec-btn.active .badge-counter {
    background: #2563eb;
    color: #ffffff;
}

</style>

@endsection

@section('script')
<script>
function showModuleTab(modIdx) {
    if (modIdx < 1 || modIdx > 6) return;
    $('#tab-modul' + modIdx + '-btn').tab('show');
    $('html, body').animate({
        scrollTop: $('#assessmentShowTab').offset().top - 80
    }, 200);
}

$(document).ready(function() {
    // 1. GMFM Dimension Switcher inside Show view
    $(document).on('click', '.gmfm-dim-btn', function(e) {
        e.preventDefault();
        var targetPane = $(this).data('target-dim');
        $('.gmfm-dim-btn').removeClass('active');
        $('.gmfm-dim-btn i').removeClass('text-primary').addClass('text-muted');
        $(this).addClass('active');
        $(this).find('i').removeClass('text-muted').addClass('text-primary');
        $('.gmfm-show-pane').hide();
        $(targetPane).fadeIn(150);
    });

    // 1b. Denver DDST II Sector Switcher inside Show view
    $(document).on('click', '.denver-show-sec-btn', function(e) {
        e.preventDefault();
        var targetPane = $(this).data('target-dim');
        $('.denver-show-sec-btn').removeClass('active');
        $('.denver-show-sec-btn i').removeClass('text-primary').addClass('text-muted');
        $(this).addClass('active');
        $(this).find('i').removeClass('text-muted').addClass('text-primary');
        $('.denver-show-sec-pane').hide();
        $(targetPane).fadeIn(150);
    });

    // 2. URL Hash Persistence for Assessment Show Tabs
    var hash = window.location.hash;
    if (hash && $(hash).length) {
        $('a[href="' + hash + '"]').tab('show');
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var tabHref = $(e.target).attr('href');
        if (history.pushState) {
            history.pushState(null, null, tabHref);
        }
    });
});
</script>
@endsection
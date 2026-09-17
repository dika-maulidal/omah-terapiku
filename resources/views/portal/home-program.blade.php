@extends('portal.layout.apps')

@section('title', 'Program Terapi Rumah')

@section('style')
<style>
    .program-hero-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
    }
    .program-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .program-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }
    .program-item:hover {
        background: #f8fafc;
    }
    .program-item:last-child {
        border-bottom: none;
    }
    .dosis-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    @media (max-width: 576px) {
        .dosis-grid {
            grid-template-columns: 1fr;
        }
    }
    .dosis-stat-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 10px;
        text-align: center;
        box-shadow: 0 2px 6px rgba(46, 75, 130, 0.03);
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 135px;
    }
    .dosis-stat-box:hover {
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 75, 130, 0.06);
    }
    .home-instruction-box {
        background: #fafcff;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb;
        border-radius: 10px;
        padding: 20px;
        line-height: 1.75;
        font-size: 13.5px;
        color: #1e293b;
    }

</style>
@endsection

@section('content')
<div class="row">
    <!-- Header Banner (Unified White Card - DESIGN.md Section 1 & 3) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 14px;">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #ecfdf5; color: #059669; font-size: 20px; border: 1px solid #a7f3d0; border-radius: 10px;">
                            <i class="fa-solid fa-house-chimney-medical"></i>
                        </div>
                        <div>
                            <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                                Program Terapi Mandiri di Rumah (Home Program)
                            </h3>
                            <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                                Panduan instruksi latihan mandiri, stimulasi fisik, dan edukasi keluarga dari terapis
                            </p>
                        </div>
                    </div>

                    <!-- Actions & Filter (Standardized Dashboard Dropdown Filter) -->
                    @if(isset($rekams) && $rekams && $rekams->count() > 0)
                        <div class="position-relative mt-2 mt-sm-0" style="min-width: 250px;">
                            <i class="fa fa-filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563eb; font-size: 12px; pointer-events: none; z-index: 2;"></i>
                            <select id="filterHomeProgramRekam" class="form-control form-control-sm font-w700" onchange="if(this.value) window.location.href = '{{ route('portal.home-program') }}?rekam_id=' + this.value;" style="color: #2563eb !important; padding-left: 32px; padding-right: 36px; height: 36px; font-size: 12.5px; border-radius: 8px; border-color: #cbd5e1; cursor: pointer; background-color: #ffffff; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232563eb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 14px center; background-size: 11px 11px;">
                                @foreach($rekams as $r)
                                    <option value="{{ $r->id }}" {{ isset($selectedRekam) && $selectedRekam && $selectedRekam->id == $r->id ? 'selected' : '' }}>
                                        {{ $r->tgl_rekam ? \Carbon\Carbon::parse($r->tgl_rekam)->isoFormat('D MMMM Y') : 'Sesi #' . $r->id }} - {{ $r->layanan_terapi ?: 'Terapi' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @php
        $hasLatihanRumahan = isset($selectedRekam) && $selectedRekam && !empty($selectedRekam->latihan_rumahan);
        $hasTindakan = isset($selectedRekam) && $selectedRekam && (!empty($selectedRekam->tindakan) || $selectedRekam->getFileTindakan());
        $hasAssessmentPlan = $latestAssessment && (!empty($latestAssessment->rencana_dosis_frekuensi) || !empty($latestAssessment->rencana_dosis_durasi) || !empty($latestAssessment->rencana_latihan_terapi) || !empty($latestAssessment->rencana_edukasi_konseling));
        $hasHomeProgramData = isset($selectedRekam) && $selectedRekam && ($hasLatihanRumahan || $hasTindakan || $hasAssessmentPlan);
    @endphp

    @if($hasHomeProgramData)
        <!-- Info Banner Sesi Aktif -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
                            <!-- Meta Sesi & Terapis -->
                            <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-calendar-check mr-2 text-primary" style="font-size: 16px;"></i>
                                    <div>
                                        <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase;">Sesi Terapi</div>
                                        <strong class="text-dark" style="font-size: 13.5px;">{{ $selectedRekam->tgl_rekam ? \Carbon\Carbon::parse($selectedRekam->tgl_rekam)->isoFormat('D MMMM Y') : '-' }}</strong>
                                    </div>
                                </div>
                                <div class="pl-md-3 d-flex align-items-center" style="border-left: 2px solid #f1f5f9;">
                                    <i class="fa-solid fa-user-doctor mr-2 text-primary" style="font-size: 16px;"></i>
                                    <div>
                                        <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase;">Terapis Pembimbing</div>
                                        <strong class="text-dark" style="font-size: 13.5px;">{{ $selectedRekam->dokter ? $selectedRekam->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}</strong>
                                    </div>
                                </div>
                            </div>

                            @if($selectedRekam->diagnosa)
                                <div class="mt-3 pt-3 d-flex align-items-center flex-wrap" style="border-top: 1px dashed #e2e8f0; gap: 10px;">
                                    <span class="badge font-w700 d-inline-flex align-items-center" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 11.5px; padding: 5px 10px; border-radius: 6px; flex-shrink: 0;">
                                        <i class="fa-solid fa-stethoscope mr-1.5"></i> Diagnosa
                                    </span>
                                    <span class="text-dark font-w600" style="font-size: 13px; line-height: 1.4;">
                                        {{ $selectedRekam->diagnosa }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-5 col-md-12 text-lg-right">
                            <div class="d-flex align-items-center justify-content-lg-end flex-wrap" style="gap: 8px;">
                                <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                    <i class="fa-solid fa-hand-holding-medical mr-1"></i> {{ $selectedRekam->layanan_terapi ?: 'Layanan Terapi Terpadu' }}
                                </span>
                                @if($selectedRekam->poli || $selectedRekam->upt_lokasi)
                                    <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;">
                                        <i class="fa-solid fa-hospital text-primary mr-1"></i> {{ $selectedRekam->poli ?: $selectedRekam->upt_lokasi }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Hero Card: Instruksi Latihan Mandiri di Rumah (Home Program) -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm program-hero-card">
                <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <div>
                        <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                            <i class="fa-solid fa-house-user text-primary mr-2"></i> Instruksi Latihan Mandiri di Rumah (Home Program)
                        </h4>
                        <small class="text-muted d-block mt-0.5" style="font-size: 12px;">
                            Tugas dan stimulasi fisik yang perlu dipraktikkan orang tua / wali di rumah
                        </small>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(!empty($selectedRekam->latihan_rumahan))
                        <div class="home-instruction-box shadow-sm mb-3">
                            <div class="d-flex align-items-start mb-2">
                                <i class="fa-solid fa-notes-medical text-primary mr-2 mt-1" style="font-size: 18px;"></i>
                                <div style="flex: 1;">
                                    <strong class="text-primary d-block mb-1" style="font-size: 14px;">
                                        Rincian Instruksi &amp; Langkah Latihan dari Terapis:
                                    </strong>
                                    <div class="text-dark" style="font-size: 13.5px; line-height: 1.75; white-space: pre-line;">{!! e($selectedRekam->latihan_rumahan) !!}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-3 rounded mb-3" style="background: #f8fafc; border: 1px dashed #cbd5e1; font-size: 13px; color: #64748b;">
                            <i class="fa-solid fa-circle-info text-primary mr-1"></i> Latihan stimulasi fisik dan gerakan mandiri di rumah diarahkan secara langsung oleh terapis selama sesi berlangsung.
                        </div>
                    @endif

                    @if($selectedRekam->getFileTindakan())
                        <div class="mt-3 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="rounded p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #eff6ff; color: #2563eb; font-size: 18px; border-radius: 8px;">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-w700 text-dark mb-0.5" style="font-size: 13.5px;">Foto Dokumentasi Tindakan / Posisi Latihan</h6>
                                        <span class="text-muted" style="font-size: 12px;">Foto peragaan gerakan atau posisi latihan dari terapis</span>
                                    </div>
                                </div>
                                <a href="{{ $selectedRekam->getFileTindakan() }}" target="_blank" class="btn btn-sm btn-outline-primary font-w700" style="border-radius: 6px; padding: 5px 14px; font-size: 12px;">
                                    <i class="fa-solid fa-eye mr-1"></i> Lihat Foto Gerakan
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. Rencana Tindakan & Intervensi Klinis di Klinik (Jika Ada) -->
        @if(!empty($selectedRekam->tindakan) || !empty($selectedRekam->keluhan))
        <div class="{{ $hasAssessmentPlan ? 'col-lg-6' : 'col-12' }} col-md-12 mb-4">
            <div class="card shadow-sm h-100 program-card">
                <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                        <i class="fa-solid fa-hand-holding-medical text-primary mr-2"></i> Tindakan Klinis di Klinik
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(!empty($selectedRekam->tindakan))
                        <div class="p-3 rounded mb-3" style="background: #f8fafc; border-left: 3px solid #2563eb;">
                            <strong class="text-primary d-block mb-1.5" style="font-size: 13px;">
                                <i class="fa-solid fa-list-check mr-1"></i> Tindakan yang Diberikan Terapis:
                            </strong>
                            <div class="text-dark" style="font-size: 13px; line-height: 1.65; white-space: pre-line;">{!! e($selectedRekam->tindakan) !!}</div>
                        </div>
                    @endif

                    @if(!empty($selectedRekam->keluhan))
                        <div class="mt-3 p-3 rounded" style="background: #fffbeb; border: 1px solid #fde68a; font-size: 12.5px;">
                            <strong class="text-warning d-block mb-1" style="color: #b45309 !important;">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i> Keluhan &amp; Fokus Sesi:
                            </strong>
                            <span class="text-dark">{{ $selectedRekam->keluhan }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- 3. Dosis & Rekomendasi Terapi (Hanya Jika Ada Asesmen Terisi) -->
        @if($hasAssessmentPlan)
        <div class="{{ (!empty($selectedRekam->tindakan) || !empty($selectedRekam->keluhan)) ? 'col-lg-6' : 'col-12' }} col-md-12 mb-4">
            <div class="card shadow-sm h-100 program-card">
                <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                        <i class="fa-solid fa-stopwatch text-primary mr-2"></i> Anjuran Dosis &amp; Sasaran Terapi
                    </h4>
                </div>
                <div class="card-body p-4">
                    @php
                        $rawFrekuensi = $latestAssessment->rencana_dosis_frekuensi ? trim($latestAssessment->rencana_dosis_frekuensi) : null;
                        $displayFrekuensi = $rawFrekuensi ? (is_numeric($rawFrekuensi) ? $rawFrekuensi . 'x / Minggu' : $rawFrekuensi) : '-';

                        $rawDurasi = $latestAssessment->rencana_dosis_durasi ? trim($latestAssessment->rencana_dosis_durasi) : null;
                        $displayDurasi = $rawDurasi ? (is_numeric($rawDurasi) ? $rawDurasi . ' Menit' : $rawDurasi) : '-';
                    @endphp

                    <div class="dosis-grid mb-3">
                        <div class="dosis-stat-box">
                            <div class="d-flex align-items-center justify-content-center mb-2" style="width: 38px; height: 38px; border-radius: 8px; background: #eff6ff; color: #2563eb; font-size: 15px; border: 1px solid #bfdbfe;">
                                <i class="fa-solid fa-calendar-week"></i>
                            </div>
                            <span class="text-muted font-w700 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Frekuensi Sesi</span>
                            <div class="font-w800 my-1 text-center" style="font-size: 16.5px; color: #1e40af; line-height: 1.3;">
                                {{ $displayFrekuensi }}
                            </div>
                            <small class="text-muted font-w500" style="font-size: 11px;">Jadwal di Klinik</small>
                        </div>
                        <div class="dosis-stat-box">
                            <div class="d-flex align-items-center justify-content-center mb-2" style="width: 38px; height: 38px; border-radius: 8px; background: #f0f9ff; color: #0284c7; font-size: 15px; border: 1px solid #bae6fd;">
                                <i class="fa-solid fa-stopwatch"></i>
                            </div>
                            <span class="text-muted font-w700 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Durasi Sesi</span>
                            <div class="font-w800 my-1 text-center" style="font-size: 16.5px; color: #0284c7; line-height: 1.3;">
                                {{ $displayDurasi }}
                            </div>
                            <small class="text-muted font-w500" style="font-size: 11px;">Per Kedatangan</small>
                        </div>
                        <div class="dosis-stat-box">
                            <div class="d-flex align-items-center justify-content-center mb-2" style="width: 38px; height: 38px; border-radius: 8px; background: #ecfdf5; color: #059669; font-size: 15px; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-house-chimney-medical"></i>
                            </div>
                            <span class="text-muted font-w700 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Latihan Mandiri</span>
                            <div class="font-w800 my-1 text-center" style="font-size: 16.5px; color: #059669; line-height: 1.3;">
                                1–2x Sehari
                            </div>
                            <small class="text-muted font-w500" style="font-size: 11px;">Sesuai Panduan</small>
                        </div>
                    </div>

                    @if(!empty($latestAssessment->rencana_latihan_terapi) || !empty($latestAssessment->rencana_edukasi_konseling))
                        <div class="p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; font-size: 12.5px;">
                            <div class="d-flex align-items-center mb-2.5" style="gap: 8px;">
                                <i class="fa-solid fa-bullseye text-primary" style="font-size: 14px;"></i>
                                <strong class="text-dark font-w700" style="font-size: 12.5px;">Fokus Sasaran Latihan Asesmen:</strong>
                            </div>
                            @if(!empty($latestAssessment->rencana_latihan_terapi) && is_array($latestAssessment->rencana_latihan_terapi))
                                <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @foreach($latestAssessment->rencana_latihan_terapi as $lt)
                                        @if($lt !== 'Lainnya')
                                            <span class="badge font-w600" style="font-size: 11.5px; padding: 6px 12px; border-radius: 6px; background: #ffffff; color: #1e40af; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: inline-flex; align-items: center; gap: 7px;">
                                                <i class="fa-solid fa-check text-primary" style="font-size: 11px;"></i> {{ $lt }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if(!empty($latestAssessment->rencana_edukasi_konseling) && is_array($latestAssessment->rencana_edukasi_konseling))
                                <div class="d-flex flex-wrap mt-2.5" style="gap: 8px;">
                                    @foreach($latestAssessment->rencana_edukasi_konseling as $ek)
                                        @if($ek !== 'Lainnya')
                                            <span class="badge font-w600" style="font-size: 11.5px; padding: 6px 12px; border-radius: 6px; background: #ffffff; color: #047857; border: 1px solid #a7f3d0; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: inline-flex; align-items: center; gap: 7px;">
                                                <i class="fa-solid fa-heart-pulse text-success" style="font-size: 11px;"></i> {{ $ek }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

    @else
        <!-- Empty State Card (Konsisten dengan Evaluasi Nyeri, Skala Denver II, dan GMFM) -->
        <div class="col-12">
            <div class="card shadow-sm text-center p-5" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 72px; height: 72px; background: #ecfdf5; color: #059669; font-size: 32px; border: 1px solid #a7f3d0; margin: 0 auto;">
                    <i class="fa-solid fa-house-chimney-medical"></i>
                </div>
                <h4 class="text-dark font-w700 mb-1">Belum Ada Program Terapi Mandiri di Rumah</h4>
                <p class="text-muted" style="max-width: 480px; margin: 0 auto; font-size: 13.5px; line-height: 1.6;">
                    Program latihan mandiri di rumah (Home Program), anjuran frekuensi sesi, dan panduan stimulasi fisik anak akan disusun dan diberikan oleh terapis setelah sesi terapi atau asesmen klinis dilaksanakan.
                </p>
            </div>
        </div>
    @endif
</div>
@endsection

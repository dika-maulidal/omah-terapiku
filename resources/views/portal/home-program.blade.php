@extends('portal.layout.apps')

@section('title', 'Program Terapi Rumah')

@section('style')
<style>
    .program-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .program-item {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }
    .program-item:hover {
        background: #f8fafc;
    }
    .program-item:last-child {
        border-bottom: none;
    }
    .dosis-stat-box {
        background: #ffffff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 14px 18px;
        text-align: center;
        min-width: 120px;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.06);
        transition: transform 0.2s ease;
    }
    .dosis-stat-box:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Header Banner (Unified White Card - DESIGN.md Section 1 & 3) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center">
                    <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                        <i class="fa-solid fa-house-chimney-medical"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                            Program Terapi Mandiri di Rumah (Home Program)
                        </h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                            Panduan stimulasi, latihan fisik, dan edukasi posisi yang diresepkan oleh terapis
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($latestAssessment)
        <!-- Dosis & Pengaturan Program Terapi (Soft Blue Card - DESIGN.md Section 1 & 3) -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
                            <span class="badge font-w700 text-uppercase mb-2 px-3 py-1.5" style="font-size: 11px; border-radius: 6px; background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe;">
                                <i class="fa-solid fa-clipboard-check mr-1"></i> Rencana Dosis Terapi Aktif
                            </span>
                            <h3 class="font-w800 mb-1" style="color: var(--ot-navy, #1e40af); font-size: 22px;">
                                Anjuran Pelaksanaan Terapi
                            </h3>
                            <p class="text-muted mb-0" style="font-size: 13px;">
                                <i class="fa-solid fa-user-doctor mr-1.5 text-primary"></i> Disusun oleh: <strong class="text-dark">{{ $latestAssessment->dokter ? $latestAssessment->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}</strong>
                            </p>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="d-flex flex-wrap justify-content-lg-end" style="gap: 12px;">
                                <div class="dosis-stat-box">
                                    <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px;">Frekuensi</div>
                                    <div class="font-w800 my-1" style="font-size: 20px; color: #1e40af;">
                                        {{ $latestAssessment->rencana_dosis_frekuensi ?: '2' }}<span style="font-size: 13px; font-weight: 600; color: #64748b;">x / mgg</span>
                                    </div>
                                </div>
                                <div class="dosis-stat-box">
                                    <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px;">Durasi Sesi</div>
                                    <div class="font-w800 my-1" style="font-size: 20px; color: #1e40af;">
                                        {{ $latestAssessment->rencana_dosis_durasi ?: '45' }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Menit</span>
                                    </div>
                                </div>
                                <div class="dosis-stat-box">
                                    <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px;">Target Sesi</div>
                                    <div class="font-w800 my-1" style="font-size: 20px; color: #1e40af;">
                                        {{ $latestAssessment->rencana_dosis_total_sesi ?: '8' }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Sesi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Latihan Terapi Rumah & Stimulasi -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                        <i class="fa-solid fa-person-walking-arrow-right text-success mr-2"></i> Panduan Latihan Terapi Mandiri
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(!empty($latestAssessment->rencana_latihan_terapi) && is_array($latestAssessment->rencana_latihan_terapi))
                        <div class="border rounded mb-3" style="border-color: #f1f5f9;">
                            @foreach($latestAssessment->rencana_latihan_terapi as $latihan)
                                @if($latihan !== 'Lainnya')
                                    <div class="program-item d-flex align-items-center">
                                        <i class="fa-solid fa-circle-check text-success mr-3" style="font-size: 15px;"></i>
                                        <span class="font-w600 text-dark" style="font-size: 13px;">{{ $latihan }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted" style="font-size: 13px;">Latihan terapi teratur sesuai petunjuk lisan terapis.</p>
                    @endif

                    @if($latestAssessment->rencana_latihan_lainnya)
                        <div class="p-3 rounded" style="background: #f8fafc; border-left: 3px solid #10b981; font-size: 12.5px;">
                            <strong class="text-success d-block mb-1"><i class="fa-solid fa-circle-info mr-1"></i> Petunjuk Khusus Latihan:</strong>
                            <p class="mb-0 text-dark">{{ $latestAssessment->rencana_latihan_lainnya }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. Edukasi, Ergonomi & Pola Posisi -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                        <i class="fa-solid fa-graduation-cap text-primary mr-2"></i> Edukasi & Pengaturan Posisi di Rumah
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(!empty($latestAssessment->rencana_edukasi_konseling) && is_array($latestAssessment->rencana_edukasi_konseling))
                        <div class="border rounded mb-3" style="border-color: #f1f5f9;">
                            @foreach($latestAssessment->rencana_edukasi_konseling as $edukasi)
                                @if($edukasi !== 'Lainnya')
                                    <div class="program-item d-flex align-items-center">
                                        <i class="fa-solid fa-circle-info text-primary mr-3" style="font-size: 15px;"></i>
                                        <span class="font-w600 text-dark" style="font-size: 13px;">{{ $edukasi }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted" style="font-size: 13px;">Edukasi stimulasi anak di rumah sesuai arahan klinis terapis.</p>
                    @endif

                    @if($latestAssessment->rencana_edukasi_lainnya)
                        <div class="p-3 rounded" style="background: #f8fafc; border-left: 3px solid #2563eb; font-size: 12.5px;">
                            <strong class="text-primary d-block mb-1"><i class="fa-solid fa-circle-info mr-1"></i> Catatan Edukasi Tambahan:</strong>
                            <p class="mb-0 text-dark">{{ $latestAssessment->rencana_edukasi_lainnya }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 3. Modalitas Fisik & Manual Terapi Klinis (Jika Ada) -->
        @if((is_array($latestAssessment->rencana_modalitas_fisik) && count($latestAssessment->rencana_modalitas_fisik) > 0) || (is_array($latestAssessment->rencana_manual_terapi) && count($latestAssessment->rencana_manual_terapi) > 0))
            <div class="col-12 mb-4">
                <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                    <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                        <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                            <i class="fa-solid fa-hand-holding-medical text-primary mr-2"></i> Modalitas Klinis & Manual Terapi Pendukung
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            @if(is_array($latestAssessment->rencana_modalitas_fisik) && count($latestAssessment->rencana_modalitas_fisik) > 0)
                                <div class="col-md-6 col-12 mb-3 mb-md-0">
                                    <span class="text-muted d-block font-w700 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                                        <i class="fa-solid fa-plug text-primary mr-1"></i> Modalitas Fisik:
                                    </span>
                                    <div class="d-flex flex-wrap" style="gap: 6px;">
                                        @foreach($latestAssessment->rencana_modalitas_fisik as $mf)
                                            @if($mf !== 'Lainnya')
                                                <span class="badge font-w600" style="font-size: 11.5px; padding: 6px 12px; border-radius: 6px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0;">
                                                    <i class="fa-solid fa-check text-primary mr-1"></i> {{ $mf }}
                                                </span>
                                            @endif
                                        @endforeach
                                        @if($latestAssessment->rencana_modalitas_lainnya)
                                            <span class="badge font-w600" style="font-size: 11.5px; padding: 6px 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                Lainnya: {{ $latestAssessment->rencana_modalitas_lainnya }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if(is_array($latestAssessment->rencana_manual_terapi) && count($latestAssessment->rencana_manual_terapi) > 0)
                                <div class="col-md-6 col-12">
                                    <span class="text-muted d-block font-w700 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                                        <i class="fa-solid fa-hand-holding-medical text-primary mr-1"></i> Manual Terapi:
                                    </span>
                                    <div class="d-flex flex-wrap" style="gap: 6px;">
                                        @foreach($latestAssessment->rencana_manual_terapi as $mt)
                                            @if($mt !== 'Lainnya')
                                                <span class="badge font-w600" style="font-size: 11.5px; padding: 6px 12px; border-radius: 6px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0;">
                                                    <i class="fa-solid fa-check text-primary mr-1"></i> {{ $mt }}
                                                </span>
                                            @endif
                                        @endforeach
                                        @if($latestAssessment->rencana_manual_lainnya)
                                            <span class="badge font-w600" style="font-size: 11.5px; padding: 6px 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                Lainnya: {{ $latestAssessment->rencana_manual_lainnya }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- 4. Target Capaian & Rencana Intervensi Lanjutan -->
        @if($latestAssessment->rencana_terapi || $latestAssessment->kesimpulan)
            <div class="col-12 mb-4">
                <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                    <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                        <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                            <i class="fa-solid fa-bullseye text-primary mr-2"></i> Target Capaian & Rencana Intervensi
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @if($latestAssessment->rencana_terapi)
                            <div class="p-3 mb-3 rounded" style="background: #f8fafc; border-left: 3px solid #2563eb;">
                                <strong class="text-primary d-block mb-1 font-w700" style="font-size: 13px;">
                                    <i class="fa-solid fa-list-check mr-1"></i> Rencana Intervensi Lanjutan:
                                </strong>
                                <p class="text-dark mb-0" style="font-size: 13px; line-height: 1.6;">
                                    {{ $latestAssessment->rencana_terapi }}
                                </p>
                            </div>
                        @endif

                        @if($latestAssessment->kesimpulan)
                            <div class="p-3 rounded" style="background: #f8fafc; border-left: 3px solid #10b981;">
                                <strong class="text-success d-block mb-1 font-w700" style="font-size: 13px;">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Kesimpulan & Evaluasi Terapis:
                                </strong>
                                <p class="text-dark mb-0" style="font-size: 13px; line-height: 1.6;">
                                    {{ $latestAssessment->kesimpulan }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    @else
        <div class="col-12">
            <div class="card shadow-sm text-center p-5" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 72px; height: 72px; background: #eff6ff; color: #2563eb; font-size: 32px; border: 1px solid #bfdbfe; margin: 0 auto;">
                    <i class="fa-solid fa-house-chimney-medical"></i>
                </div>
                <h4 class="text-dark font-w700 mb-1">Belum Ada Program Terapi Rumah</h4>
                <p class="text-muted" style="max-width: 460px; margin: 0 auto; font-size: 13.5px;">
                    Program latihan mandiri di rumah akan ditampilkan setelah terapis menyusun perencanaan terapi dan dosis intervensi pada rekam medis pasien.
                </p>
            </div>
        </div>
    @endif
</div>
@endsection

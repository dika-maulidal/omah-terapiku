@extends('portal.layout.apps')

@section('title', 'Gross Motor Function Measure (GMFM)')

@section('style')
<style>
    /* Metric & Stat Cards (DESIGN.md Section 1 & 3) */
    .gmfm-stat-box {
        border-radius: 10px;
        padding: 16px 14px;
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .gmfm-stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(46, 75, 130, 0.08);
    }

    /* Dimension Summary Cards */
    .gmfm-dim-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s ease, border-color 0.25s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .gmfm-dim-card:hover {
        transform: translateY(-3px);
        border-color: #93c5fd;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.08);
    }

    /* Interactive Filter Tabs */
    .gmfm-filter-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none !important;
        white-space: nowrap;
    }
    .gmfm-filter-tab:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    .gmfm-filter-tab.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }
    .gmfm-filter-tab.active .badge-count {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    /* Task Table Styling */
    .gmfm-task-table th {
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #475569;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 12px 18px;
        vertical-align: middle;
    }
    .gmfm-task-table td {
        padding: 12px 18px;
        vertical-align: middle;
    }
    .gmfm-task-table tr:not(:last-child) td {
        border-bottom: 1px solid #f1f5f9;
    }
    .gmfm-task-table tr:hover td {
        background-color: #fafcff;
    }

    /* Score Badges */
    .score-badge-gmfm {
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.2px;
    }
    .score-3 {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .score-2 {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .score-1 {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }
    .score-0 {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .score-nt {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
    .score-empty {
        background: #f8fafc;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
    }

    /* Pill number indicator */
    .gmfm-num-pill {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        font-weight: 800;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #bfdbfe;
    }

    /* Universal Header Filter Dropdown (DESIGN.md Section 3A) */
    .gmfm-select-filter {
        height: 36px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        color: #2563eb;
        font-weight: 700;
        font-size: 13px;
        padding: 0 12px;
        background-color: #ffffff;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .gmfm-select-filter:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
</style>
@endsection

@section('content')
@php
    $hasGmfmData = $latestAssessment && (
        $latestAssessment->gmfm_total_persen !== null || 
        $latestAssessment->gmfm_total_score !== null ||
        !empty($latestAssessment->gmfm_dimensi_a_scores) ||
        !empty($latestAssessment->gmfm_dimensi_b_scores) ||
        !empty($latestAssessment->gmfm_dimensi_c_scores) ||
        !empty($latestAssessment->gmfm_dimensi_d_scores) ||
        !empty($latestAssessment->gmfm_dimensi_e_scores)
    );

    // Dimensions Data Setup
    $dimA_scores = is_array($latestAssessment?->gmfm_dimensi_a_scores) ? $latestAssessment->gmfm_dimensi_a_scores : [];
    $dimB_scores = is_array($latestAssessment?->gmfm_dimensi_b_scores) ? $latestAssessment->gmfm_dimensi_b_scores : [];
    $dimC_scores = is_array($latestAssessment?->gmfm_dimensi_c_scores) ? $latestAssessment->gmfm_dimensi_c_scores : [];
    $dimD_scores = is_array($latestAssessment?->gmfm_dimensi_d_scores) ? $latestAssessment->gmfm_dimensi_d_scores : [];
    $dimE_scores = is_array($latestAssessment?->gmfm_dimensi_e_scores) ? $latestAssessment->gmfm_dimensi_e_scores : [];

    $dimensions = [
        'A' => [
            'key' => 'A',
            'title' => 'Dimensi A: Berbaring & Berguling',
            'name' => 'Berbaring & Berguling',
            'sub' => 'Lying & Rolling',
            'total_items' => 17,
            'max_score' => 51,
            'scores' => $dimA_scores,
            'total' => $latestAssessment?->gmfm_dimensi_a_total,
            'persen' => $latestAssessment?->gmfm_dimensi_a_persen,
            'catatan' => $latestAssessment?->gmfm_dimensi_a_catatan,
            'icon' => 'fa-bed',
            'color' => '#2563eb',
            'bg' => '#eff6ff',
            'border' => '#bfdbfe',
            'items' => config('gmfm.dimensions.A.items', [])
        ],
        'B' => [
            'key' => 'B',
            'title' => 'Dimensi B: Duduk',
            'name' => 'Duduk',
            'sub' => 'Sitting',
            'total_items' => 20,
            'max_score' => 60,
            'scores' => $dimB_scores,
            'total' => $latestAssessment?->gmfm_dimensi_b_total,
            'persen' => $latestAssessment?->gmfm_dimensi_b_persen,
            'catatan' => $latestAssessment?->gmfm_dimensi_b_catatan,
            'icon' => 'fa-chair',
            'color' => '#0284c7',
            'bg' => '#e0f2fe',
            'border' => '#bae6fd',
            'items' => config('gmfm.dimensions.B.items', [])
        ],
        'C' => [
            'key' => 'C',
            'title' => 'Dimensi C: Merangkak & Berlutut',
            'name' => 'Merangkak & Berlutut',
            'sub' => 'Crawling & Kneeling',
            'total_items' => 14,
            'max_score' => 42,
            'scores' => $dimC_scores,
            'total' => $latestAssessment?->gmfm_dimensi_c_total,
            'persen' => $latestAssessment?->gmfm_dimensi_c_persen,
            'catatan' => $latestAssessment?->gmfm_dimensi_c_catatan,
            'icon' => 'fa-arrows-down-to-people',
            'color' => '#059669',
            'bg' => '#ecfdf5',
            'border' => '#a7f3d0',
            'items' => config('gmfm.dimensions.C.items', [])
        ],
        'D' => [
            'key' => 'D',
            'title' => 'Dimensi D: Berdiri',
            'name' => 'Berdiri',
            'sub' => 'Standing',
            'total_items' => 13,
            'max_score' => 39,
            'scores' => $dimD_scores,
            'total' => $latestAssessment?->gmfm_dimensi_d_total,
            'persen' => $latestAssessment?->gmfm_dimensi_d_persen,
            'catatan' => $latestAssessment?->gmfm_dimensi_d_catatan,
            'icon' => 'fa-person',
            'color' => '#d97706',
            'bg' => '#fffbeb',
            'border' => '#fde68a',
            'items' => config('gmfm.dimensions.D.items', [])
        ],
        'E' => [
            'key' => 'E',
            'title' => 'Dimensi E: Berjalan, Berlari & Melompat',
            'name' => 'Berjalan, Berlari & Melompat',
            'sub' => 'Walking, Running & Jumping',
            'total_items' => 24,
            'max_score' => 72,
            'scores' => $dimE_scores,
            'total' => $latestAssessment?->gmfm_dimensi_e_total,
            'persen' => $latestAssessment?->gmfm_dimensi_e_persen,
            'catatan' => $latestAssessment?->gmfm_dimensi_e_catatan,
            'icon' => 'fa-person-walking',
            'color' => '#6366f1',
            'bg' => '#e0e7ff',
            'border' => '#c7d2fe',
            'items' => config('gmfm.dimensions.E.items', [])
        ],
    ];

    // Compute Item Counts (Scores 3, 2, 1, 0, NT)
    $allScores = array_merge(
        array_values($dimA_scores),
        array_values($dimB_scores),
        array_values($dimC_scores),
        array_values($dimD_scores),
        array_values($dimE_scores)
    );

    $count3 = 0;
    $count2 = 0;
    $count1 = 0;
    $count0 = 0;
    $countNT = 0;

    foreach ($allScores as $s) {
        if ($s === '3' || $s === 3) $count3++;
        elseif ($s === '2' || $s === 2) $count2++;
        elseif ($s === '1' || $s === 1) $count1++;
        elseif ($s === '0' || $s === 0) $count0++;
        elseif ($s === 'NT' || $s === 'nt') $countNT++;
    }

    $totalScore = $latestAssessment?->gmfm_total_score ?? 0;
    $totalPersen = (float)($latestAssessment?->gmfm_total_persen ?? 0);
@endphp

<div class="row">
    <!-- Header Banner (Unified White Card - DESIGN.md Section 1 & 3) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 14px;">
                    <!-- Title & Icon -->
                    <div class="d-flex align-items-center">
                        <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                            <i class="fa-solid fa-child-reaching"></i>
                        </div>
                        <div>
                            <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                                Gross Motor Function Measure (GMFM)
                            </h3>
                            <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                                Pengukuran evaluasi fungsi motorik kasar Dimensi A sampai E
                            </p>
                        </div>
                    </div>

                    <!-- Actions & Filter (Standardized Dashboard Dropdown Filter) -->
                    @if($assessments && $assessments->count() > 0)
                        <div class="position-relative mt-2 mt-sm-0" style="min-width: 240px;">
                            <i class="fa fa-filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563eb; font-size: 12px; pointer-events: none; z-index: 2;"></i>
                            <select id="filterGmfmAssessment" class="form-control form-control-sm font-w700" onchange="if(this.value) window.location.href = '{{ route('portal.gmfm') }}?assessment_id=' + this.value;" style="color: #2563eb !important; padding-left: 32px; padding-right: 36px; height: 36px; font-size: 12.5px; border-radius: 8px; border-color: #cbd5e1; cursor: pointer; background-color: #ffffff; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232563eb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 14px center; background-size: 11px 11px;">
                                @foreach($assessments as $asm)
                                    <option value="{{ $asm->id }}" {{ $latestAssessment && $latestAssessment->id == $asm->id ? 'selected' : '' }}>
                                        {{ $asm->tgl_assessment ? \Carbon\Carbon::parse($asm->tgl_assessment)->isoFormat('D MMMM Y') : 'Sesi #' . $asm->id }}@if($asm->gmfm_total_persen !== null) ({{ $asm->gmfm_total_persen }}%)@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($hasGmfmData)
        <!-- Ringkasan Info Asesmen (Nuansa Evaluasi Nyeri) -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-calendar-check mr-2 text-primary" style="font-size: 16px;"></i>
                                    <div>
                                        <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase;">Tanggal Asesmen</div>
                                        <strong class="text-dark" style="font-size: 13.5px;">{{ $latestAssessment->tgl_assessment ? \Carbon\Carbon::parse($latestAssessment->tgl_assessment)->isoFormat('D MMMM Y') : '-' }}</strong>
                                    </div>
                                </div>
                                <div class="pl-md-3 d-flex align-items-center" style="border-left: 2px solid #f1f5f9;">
                                    <i class="fa-solid fa-user-doctor mr-2 text-primary" style="font-size: 16px;"></i>
                                    <div>
                                        <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase;">Terapis Pemeriksa</div>
                                        <strong class="text-dark" style="font-size: 13.5px;">{{ $latestAssessment->dokter ? $latestAssessment->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 text-lg-right">
                            <div class="d-flex align-items-center justify-content-lg-end flex-wrap" style="gap: 8px;">
                                <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; {{ $totalPersen >= 80 ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' : ($totalPersen >= 50 ? 'background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;' : ($totalPersen >= 25 ? 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;' : 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;')) }}">
                                    <i class="fa-solid fa-child-reaching mr-1"></i> GMFM: {{ number_format($totalPersen, 1) }}%
                                </span>
                                <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                    <i class="fa-solid fa-list-check mr-1"></i> Skor: {{ $totalScore }}/264
                                </span>
                                <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-layer-group mr-1"></i> 5 Dimensi Terdata
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluasi Capaian Skor GMFM (Card Style Nuansa Evaluasi Nyeri) -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700" style="color: var(--ot-navy, #1e40af); font-size: 16px; margin: 0;">
                        <i class="fa-solid fa-chart-line text-primary mr-2"></i> Evaluasi Capaian Fungsi Motorik Kasar (GMFM-88)
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-stretch" style="row-gap: 16px;">
                        <!-- Left Score Box (Hero Panel - Perfectly Balanced & Symmetrical) -->
                        <div class="col-lg-6 col-md-12 d-flex flex-column">
                            <div class="p-4 rounded h-100 d-flex flex-column justify-content-between text-center" style="background: #fafcff; border: 1px solid #e2e8f0; border-radius: 12px;">
                                <div>
                                    <div class="text-muted font-w700" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Tingkat Kemandirian Fungsi Motorik Kasar
                                    </div>
                                    <div class="font-w800 my-2" style="font-size: 42px; line-height: 1.1; color: {{ $totalPersen >= 80 ? '#059669' : ($totalPersen >= 50 ? '#2563eb' : ($totalPersen >= 25 ? '#d97706' : '#dc2626')) }};">
                                        {{ number_format($totalPersen, 1) }}<span style="font-size: 20px; font-weight: 700; color: #94a3b8;">%</span>
                                    </div>
                                    <div class="mb-3">
                                        @if($totalPersen >= 80)
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 14px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; box-shadow: 0 1px 2px rgba(5, 150, 105, 0.06);">
                                                <i class="fa-solid fa-circle-check mr-1.5"></i> Mandiri (Minimal Assistance)
                                            </span>
                                        @elseif($totalPersen >= 50)
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 14px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; box-shadow: 0 1px 2px rgba(37, 99, 235, 0.06);">
                                                <i class="fa-solid fa-circle-info mr-1.5"></i> Kemandirian Moderat &mdash; Perlu Stimulasi
                                            </span>
                                        @elseif($totalPersen >= 25)
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 14px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; box-shadow: 0 1px 2px rgba(217, 119, 6, 0.06);">
                                                <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Keterbatasan Fungsional &mdash; Perlu Bantuan Signifikan
                                            </span>
                                        @else
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 14px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; box-shadow: 0 1px 2px rgba(220, 38, 38, 0.06);">
                                                <i class="fa-solid fa-circle-exclamation mr-1.5"></i> Keterbatasan Motorik Berat &mdash; Ketergantungan Penuh
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Progress Bar Section -->
                                <div class="pt-3" style="border-top: 1px dashed #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center text-muted font-w600 mb-1.5" style="font-size: 12px;">
                                        <span>Capaian Total (88 Task)</span>
                                        <strong class="text-dark">{{ $totalScore }} / 264 Skor ({{ number_format($totalPersen, 1) }}%)</strong>
                                    </div>
                                    <div class="progress" style="height: 10px; border-radius: 6px; background: #e2e8f0;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ max(0, min(100, $totalPersen)) }}%; background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%); border-radius: 6px;" 
                                             aria-valuenow="{{ $totalPersen }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted mt-1.5 px-1" style="font-size: 10.5px; font-weight: 600;">
                                        <span>0% (Dasar)</span>
                                        <span>50% (Moderat)</span>
                                        <span>100% (Mandiri Penuh)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Stat Counter Boxes (2x2 Grid - Identical Height & Symmetrical) -->
                        <div class="col-lg-6 col-md-12 d-flex flex-column">
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); gap: 14px; height: 100%;">
                                <!-- Stat 1: Total Skor -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                                        <i class="fa-solid fa-calculator" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #1e40af; line-height: 1.2;">
                                        {{ $totalScore }}<span style="font-size: 13px; font-weight: 600; color: #94a3b8;">/264</span>
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">Total Skor</div>
                                </div>
                                
                                <!-- Stat 2: Persentase -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                        <i class="fa-solid fa-percent" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #059669; line-height: 1.2;">
                                        {{ number_format($totalPersen, 1) }}%
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">Persentase Mandiri</div>
                                </div>

                                <!-- Stat 3: Skor 3 (100%) -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;">
                                        <i class="fa-solid fa-circle-check" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #0284c7; line-height: 1.2;">
                                        {{ $count3 }} <span style="font-size: 12px; font-weight: 600; color: #94a3b8;">Task</span>
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">Skor 3 (100% Selesai)</div>
                                </div>

                                <!-- Stat 4: Cakupan Uji -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                        <i class="fa-solid fa-layer-group" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #334155; line-height: 1.2;">
                                        5 <span style="font-size: 12px; font-weight: 600; color: #94a3b8;">Dimensi</span>
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">Dimensi A &mdash; E</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5 Dimensi GMFM Overview Cards (DESIGN.md Section 1 & 3) -->
        <div class="col-12 mb-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="font-w700 mb-0 d-flex align-items-center" style="color: var(--ot-navy, #1e40af); font-size: 16.5px;">
                    <i class="fa-solid fa-chart-column mr-2 text-primary"></i>
                    <span>Ikhtisar Capaian 5 Dimensi GMFM</span>
                </h4>
                <span class="badge font-w600 text-muted" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; border-radius: 6px; padding: 5px 10px;">
                    Total 88 Task Penilaian
                </span>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="row">
                @foreach($dimensions as $dimKey => $dim)
                    @php
                        $dimPersen = $dim['persen'] !== null ? (float)$dim['persen'] : null;
                    @endphp
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="gmfm-dim-card h-100 p-4">
                            <!-- Card Header (Spacious Icon & Text) -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                                         style="width: 42px; height: 42px; border-radius: 10px; background: {{ $dim['bg'] }}; color: {{ $dim['color'] }}; border: 1px solid {{ $dim['border'] }}; font-size: 17px;">
                                        <i class="fa-solid {{ $dim['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-w700 mb-1 text-dark" style="font-size: 15px;">
                                            {{ $dim['title'] }}
                                        </h5>
                                        <span class="text-muted font-w500" style="font-size: 12px;">
                                            {{ $dim['sub'] }} &bull; {{ $dim['total_items'] }} Task
                                        </span>
                                    </div>
                                </div>
                                <span class="badge font-w800" style="font-size: 12.5px; background: {{ $dim['bg'] }}; color: {{ $dim['color'] }}; border: 1px solid {{ $dim['border'] }}; border-radius: 8px; padding: 5px 10px;">
                                    {{ $dimPersen !== null ? number_format($dimPersen, 1) . '%' : '-' }}
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="progress" style="height: 8px; border-radius: 4px; background: #f1f5f9;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $dimPersen ?? 0 }}%; background: {{ $dim['color'] }}; border-radius: 4px;" 
                                         aria-valuenow="{{ $dimPersen ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            <!-- Score details -->
                            <div class="d-flex justify-content-between text-muted font-w600 mb-3" style="font-size: 12.5px;">
                                <span>Skor: <strong class="text-dark">{{ $dim['total'] ?? 0 }}</strong> / {{ $dim['max_score'] }}</span>
                                <span>
                                    @if($dimPersen !== null)
                                        @if($dimPersen >= 80)
                                            <span class="badge badge-success px-2.5 py-1 font-w700" style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; border-radius: 6px;">Mandiri</span>
                                        @elseif($dimPersen >= 50)
                                            <span class="badge badge-info px-2.5 py-1 font-w700" style="font-size: 11px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 6px;">Sebagian</span>
                                        @else
                                            <span class="badge badge-warning px-2.5 py-1 font-w700" style="font-size: 11px; background: #fffbeb; color: #d97706; border: 1px solid #fde68a; border-radius: 6px;">Stimulasi</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </span>
                            </div>

                            <!-- Therapist notes (Spacious & Comfortable) -->
                            @if(!empty($dim['catatan']))
                                <div class="p-3 rounded mb-3" style="font-size: 12.5px; background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid {{ $dim['color'] }}; color: #334155; line-height: 1.5; border-radius: 8px;">
                                    <div class="d-flex align-items-start" style="gap: 8px;">
                                        <i class="fa-solid fa-comment-dots mt-1 flex-shrink-0" style="color: {{ $dim['color'] }}; font-size: 13.5px;"></i>
                                        <div>
                                            <strong style="color: #1e293b;">Catatan Terapis:</strong>
                                            <span class="d-block mt-0.5" style="color: #475569;">{{ $dim['catatan'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Quick Button to view table -->
                            <div class="mt-auto pt-3 border-top" style="border-color: #f1f5f9 !important;">
                                <a href="javascript:void(0);" onclick="switchToDimension('{{ $dimKey }}')" class="btn btn-sm btn-block text-primary font-w700 d-flex align-items-center justify-content-between p-0" style="font-size: 12.5px;">
                                    <span>Lihat Rincian Item Penilaian</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Detail Rincian Item Penilaian 88 Task (Interactive Section) -->
        <div class="col-12 mb-4" id="gmfm-detail-section">
            <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <!-- Card Header with Dimension Filter Tabs -->
                <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 18px 22px;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
                        <h4 class="card-title font-w700 mb-0 d-flex align-items-center" style="color: var(--ot-navy, #1e40af); font-size: 16.5px;">
                            <i class="fa-solid fa-list-check text-primary mr-2"></i>
                            <span>Rincian Evaluasi Seluruh Item GMFM</span>
                        </h4>
                        <span class="text-muted font-w600" style="font-size: 12.5px;">
                            Skala Skor: 0 (Tidak Memulai) s/d 3 (Selesai Sempurna)
                        </span>
                    </div>

                    <!-- Filter Pill Tabs -->
                    <div class="d-flex flex-wrap mt-3" style="gap: 8px;">
                        <button type="button" class="gmfm-filter-tab active" data-dim="all" onclick="filterGmfmTab('all', this)">
                            <i class="fa-solid fa-layer-group mr-1"></i> Semua Dimensi
                            <span class="badge badge-light badge-count ml-1" style="font-size: 11px; border-radius: 10px; padding: 2px 7px;">88</span>
                        </button>
                        @foreach($dimensions as $dimKey => $dim)
                            <button type="button" class="gmfm-filter-tab" data-dim="{{ $dimKey }}" onclick="filterGmfmTab('{{ $dimKey }}', this)">
                                <i class="fa-solid {{ $dim['icon'] }} mr-1"></i> Dimensi {{ $dimKey }}
                                <span class="badge badge-light badge-count ml-1" style="font-size: 11px; border-radius: 10px; padding: 2px 7px;">{{ $dim['total_items'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Tables for Each Dimension -->
                <div class="card-body p-0">
                    @foreach($dimensions as $dimKey => $dim)
                        <div class="gmfm-dimension-block" id="dim-block-{{ $dimKey }}">
                            <!-- Dimension Subheader -->
                            <div class="px-4 py-3 d-flex align-items-center justify-content-between flex-wrap" style="background: {{ $dim['bg'] }}; border-bottom: 1px solid {{ $dim['border'] }}; border-top: 1px solid {{ $dim['border'] }}; gap: 10px;">
                                <div class="d-flex align-items-center">
                                    <span class="mr-2 d-inline-flex align-items-center justify-content-center font-w800" style="width: 28px; height: 28px; border-radius: 6px; background: {{ $dim['color'] }}; color: #ffffff; font-size: 12px;">
                                        {{ $dimKey }}
                                    </span>
                                    <div>
                                        <strong style="color: {{ $dim['color'] }}; font-size: 14.5px;">{{ $dim['title'] }}</strong>
                                        <span class="text-muted ml-1" style="font-size: 12px;">({{ $dim['sub'] }} &bull; {{ $dim['total_items'] }} Task)</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center" style="gap: 8px;">
                                    <span class="badge font-w700" style="font-size: 12px; background: #ffffff; color: {{ $dim['color'] }}; border: 1px solid {{ $dim['border'] }}; padding: 4px 10px; border-radius: 6px;">
                                        Total Skor: {{ $dim['total'] ?? 0 }} / {{ $dim['max_score'] }} ({{ $dim['persen'] !== null ? number_format($dim['persen'], 1) . '%' : '-' }})
                                    </span>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table mb-0 gmfm-task-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%; text-align: center;">No.</th>
                                            <th style="width: 63%;">Posisi & Deskripsi Gerakan Motorik</th>
                                            <th style="width: 30%; text-align: center;">Hasil Evaluasi Klinis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($dim['items'] as $itemNo => $item)
                                            @php
                                                $val = $dim['scores'][$itemNo] ?? ($dim['scores'][(string)$itemNo] ?? null);
                                            @endphp
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span class="gmfm-num-pill">
                                                        {{ $item['no'] ?? $itemNo }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if(!empty($item['position']))
                                                        <div class="text-primary font-w700 mb-0.5" style="font-size: 12px;">
                                                            <i class="fa-solid fa-angles-right mr-1" style="font-size: 10px;"></i>{{ $item['position'] }}
                                                        </div>
                                                    @endif
                                                    <div class="text-dark font-w600" style="font-size: 13px; line-height: 1.45;">
                                                        {{ $item['action'] ?? $item['text'] ?? '-' }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center;">
                                                    @if($val === '3' || $val === 3)
                                                        <span class="score-badge-gmfm score-3">
                                                            <i class="fa-solid fa-circle-check"></i> <strong>3</strong> &bull; Selesai Sempurna (100%)
                                                        </span>
                                                    @elseif($val === '2' || $val === 2)
                                                        <span class="score-badge-gmfm score-2">
                                                            <i class="fa-solid fa-play"></i> <strong>2</strong> &bull; Sebagian (10% - <100%)
                                                        </span>
                                                    @elseif($val === '1' || $val === 1)
                                                        <span class="score-badge-gmfm score-1">
                                                            <i class="fa-solid fa-hourglass-half"></i> <strong>1</strong> &bull; Memulai (<10%)
                                                        </span>
                                                    @elseif($val === '0' || $val === 0)
                                                        <span class="score-badge-gmfm score-0">
                                                            <i class="fa-solid fa-circle-xmark"></i> <strong>0</strong> &bull; Tidak Memulai (0%)
                                                        </span>
                                                    @elseif($val === 'NT' || $val === 'nt')
                                                        <span class="score-badge-gmfm score-nt">
                                                            <i class="fa-solid fa-ban"></i> <strong>NT</strong> &bull; Tidak Diuji
                                                        </span>
                                                    @else
                                                        <span class="score-badge-gmfm score-empty">
                                                            Belum Dinilai (-)
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">
                                                    Tidak ada rincian item untuk dimensi ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if(!empty($dim['catatan']))
                                <div class="p-3 mx-4 my-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid {{ $dim['color'] }}; font-size: 13px; color: #334155; line-height: 1.55; border-radius: 8px;">
                                    <div class="d-flex align-items-start" style="gap: 10px;">
                                        <i class="fa-solid fa-comment-dots mt-1 flex-shrink-0" style="color: {{ $dim['color'] }}; font-size: 14px;"></i>
                                        <div>
                                            <strong style="color: #1e293b;">Catatan Khusus Dimensi {{ $dimKey }}:</strong>
                                            <span class="d-block mt-0.5" style="color: #475569;">{{ $dim['catatan'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>



    @else
        <!-- Empty State (DESIGN.md Section 4.2) -->
        <div class="col-12">
            <div class="card shadow-sm text-center p-5" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05); background: #ffffff;">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background: #eff6ff; color: #2563eb; font-size: 28px; margin: 0 auto; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-child-reaching"></i>
                </div>
                <h4 class="text-dark font-w700 mb-2" style="font-size: 18px;">Belum Ada Catatan GMFM</h4>
                <p class="text-muted mb-4" style="max-width: 440px; margin: 0 auto; font-size: 13.5px; line-height: 1.5;">
                    Penerima manfaat ini belum memiliki data pengukuran Gross Motor Function Measure (GMFM) yang direkam oleh terapis medis.
                </p>
                <div>
                    <a href="{{ route('portal.dashboard') }}" class="btn btn-primary font-w700" style="border-radius: 8px; padding: 9px 20px;">
                        <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    // Tab filtering for GMFM Dimensions (Semua Dimensi / Dimensi A - E)
    function filterGmfmTab(dimKey, btnElem) {
        $('.gmfm-filter-tab').removeClass('active');
        if (btnElem) {
            $(btnElem).addClass('active');
        } else {
            $('.gmfm-filter-tab[data-dim="' + dimKey + '"]').addClass('active');
        }

        if (dimKey === 'all') {
            $('.gmfm-dimension-block').show();
        } else {
            $('.gmfm-dimension-block').hide();
            $('#dim-block-' + dimKey).fadeIn(200);
        }
    }

    // Switch to specific dimension and scroll smoothly
    function switchToDimension(dimKey) {
        filterGmfmTab(dimKey);
        var targetSection = document.getElementById('gmfm-detail-section');
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
@endsection

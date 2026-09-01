@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap" style="gap: 12px;">
    <div>
        <h2 class="font-w700 text-primary mb-1" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">
            <i class="fa fa-file-text-o text-primary mr-2"></i> Hasil Assessment Penerima Manfaat
        </h2>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 2px; font-size: 12.5px;">
            <li class="breadcrumb-item"><a href="{{Route('rekam')}}">Rekam Medis</a></li>
            <li class="breadcrumb-item"><a href="{{Route('rekam.detail', $pasien->id)}}">{{ $pasien->nama }}</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Hasil Assessment</a></li>
        </ol>
    </div>
    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
        <a href="{{Route('rekam.detail', $pasien->id)}}" class="btn btn-sm btn-light" style="padding: 8px 16px; font-size: 12.5px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Rekam Medis
        </a>
        <a href="{{Route('rekam.assessment', $rekam->id)}}" class="btn btn-sm btn-info text-white shadow-sm" style="padding: 8px 16px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
            <i class="fa fa-pencil mr-1"></i> Edit Assessment
        </a>
        <a href="{{Route('rekam.assessment.print', $rekam->id)}}" target="_blank" class="btn btn-sm btn-primary shadow-sm" style="padding: 8px 16px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
            <i class="fa fa-print mr-1"></i> Cetak Lembar Assessment
        </a>
    </div>
</div>

<!-- Profil Pasien & Rekam Summary -->
<div class="card mb-4" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12 mb-2 mb-lg-0">
                <div class="d-flex align-items-center">
                    <div class="avatar-box mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #2e4b82 0%, #4a6fa5 100%); color: #fff; font-weight: 700; font-size: 18px; flex-shrink: 0;">
                        {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-w700 mb-0" style="font-size: 16px; color: #1e293b;">
                            {{ $pasien->nama }}
                            <span class="badge badge-primary light font-w600 ml-2" style="font-size: 11px;">RM# {{ $pasien->no_rm }}</span>
                        </h4>
                        <div class="text-muted font-w500" style="font-size: 12px;">
                            <span>NIK: {{ $pasien->nik ?: '-' }}</span> &bull;
                            <span>{{ $pasien->jk ?: '-' }} ({{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age . ' Thn' : '-' }})</span> &bull;
                            <span>Disabilitas: {{ $pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada' ? $pasien->jenis_disabilitas : 'Non-Disabilitas' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="d-flex justify-content-lg-end align-items-center flex-wrap" style="gap: 12px;">
                    <div>
                        <small class="text-muted d-block font-w600" style="font-size: 11px;">TANGGAL ASSESSMENT</small>
                        <strong class="text-primary font-w700" style="font-size: 13px;">{{ $assessment->tgl_assessment ? $assessment->tgl_assessment->format('d M Y') : '-' }}</strong>
                    </div>
                    <div class="pl-3" style="border-left: 2px solid #e2e8f0;">
                        <small class="text-muted d-block font-w600" style="font-size: 11px;">TERAPIS PEMERIKSA</small>
                        <strong class="text-dark font-w700" style="font-size: 13px;">{{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? '-') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- 1. Kemampuan Motorik -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-child text-primary mr-2"></i> 1. Kemampuan Motorik
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size: 13px;">
                    <tbody>
                        <tr>
                            <td style="width: 45%; font-weight: 600; color: #475569;">Mengangkat Kepala</td>
                            <td>:</td>
                            <td>
                                @if($assessment->motorik_mengangkat_kepala)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->motorik_mengangkat_kepala }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Posisi Tengkurap</td>
                            <td>:</td>
                            <td>
                                @if($assessment->motorik_posisi_tengkurap)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->motorik_posisi_tengkurap }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Posisi Duduk</td>
                            <td>:</td>
                            <td>
                                @if($assessment->motorik_posisi_duduk)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->motorik_posisi_duduk }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Merangkak</td>
                            <td>:</td>
                            <td>
                                @if($assessment->motorik_merangkak)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->motorik_merangkak }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Berlutut</td>
                            <td>:</td>
                            <td>
                                @if($assessment->motorik_berlutut)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->motorik_berlutut }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Berjalan</td>
                            <td>:</td>
                            <td>
                                @if($assessment->motorik_berjalan)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->motorik_berjalan }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if($assessment->motorik_catatan)
                    <div class="p-3" style="background: #fafcff; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600 mb-1">Catatan Motorik:</span>
                        <p class="mb-0 text-dark">{{ $assessment->motorik_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. GMFM-88 TERPADU (DIMENSI A s/d E) -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-th-list text-primary mr-2"></i> 2. GMFM-88 (Gross Motor Function Measure)
                </h5>
                @php
                    $has_gmfm = !is_null($assessment->gmfm_dimensi_a_total) || !is_null($assessment->gmfm_dimensi_b_total) || !is_null($assessment->gmfm_dimensi_c_total) || !is_null($assessment->gmfm_dimensi_d_total) || !is_null($assessment->gmfm_dimensi_e_total);
                @endphp
                @if($has_gmfm)
                    <span class="badge badge-primary font-w700" style="font-size: 11.5px; padding: 4px 8px;">
                        Total GMFM-88: {{ $assessment->gmfm_total_score ?? 0 }}/264 ({{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%)
                    </span>
                @endif
            </div>
            <div class="card-body p-3">
                @if($has_gmfm)
                    <!-- TOTAL GMFM-88 RECAP BANNER -->
                    <div class="mb-3 p-2 px-3 rounded d-flex justify-content-between align-items-center" style="background: #1e293b; color: white; border-radius: 8px;">
                        <div>
                            <small class="text-white-50 text-uppercase font-w600" style="font-size: 10.5px;">Rekapitulasi 5 Dimensi (88 Item)</small>
                            <div class="font-w700" style="font-size: 14px;">Total Skor: {{ $assessment->gmfm_total_score ?? 0 }} <span style="font-size: 11px; opacity: 0.8;">/ 264</span></div>
                        </div>
                        <div class="text-right">
                            <small class="text-white-50 d-block font-w600" style="font-size: 10.5px;">Rata-rata Capaian:</small>
                            <span class="badge badge-success font-w700" style="font-size: 13px;">{{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%</span>
                        </div>
                    </div>
                    <!-- DIMENSI A SECTION -->
                    <div class="mb-3 p-3 rounded" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <strong class="text-success font-w700" style="font-size: 13px;">Dimensi A: Berbaring & Berguling</strong>
                                <div class="text-muted" style="font-size: 11px;">Skor: <strong>{{ $assessment->gmfm_dimensi_a_total ?? 0 }} / 51</strong> ({{ number_format($assessment->gmfm_dimensi_a_persen ?? 0, 1) }}%)</div>
                            </div>
                            <span class="badge {{ ($assessment->gmfm_dimensi_a_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_a_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700" style="font-size: 11px;">
                                @if(($assessment->gmfm_dimensi_a_persen ?? 0) >= 80)
                                    Sangat Baik
                                @elseif(($assessment->gmfm_dimensi_a_persen ?? 0) >= 50)
                                    Sedang
                                @else
                                    Keterbatasan
                                @endif
                            </span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; border-radius: 3px; background: #dcfce7;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $assessment->gmfm_dimensi_a_persen ?? 0 }}%;"></div>
                        </div>

                        <!-- 17 Items Dimensi A Mini Table -->
                        @php
                            $gmfm_a_items = config('gmfm.dimensions.A.items', []);
                            $g_a_scores = is_array($assessment->gmfm_dimensi_a_scores) ? $assessment->gmfm_dimensi_a_scores : [];
                        @endphp
                        <div style="max-height: 140px; overflow-y: auto; border: 1px solid #dcfce7; border-radius: 4px; background: white;">
                            <table class="table table-sm table-hover mb-0" style="font-size: 11px;">
                                <tbody>
                                    @foreach($gmfm_a_items as $no => $item)
                                        @php $scA = $g_a_scores[$no] ?? null; @endphp
                                        <tr>
                                            <td class="text-center text-muted font-w700" style="width: 10%;">{{ $no }}</td>
                                            <td style="width: 75%;">{{ $item['action'] }}</td>
                                            <td class="text-center font-w700" style="width: 15%;">
                                                @if($scA === '3' || $scA === 3)
                                                    <span class="badge badge-success" style="font-size: 10px;">3</span>
                                                @elseif($scA === '2' || $scA === 2)
                                                    <span class="badge badge-primary" style="font-size: 10px;">2</span>
                                                @elseif($scA === '1' || $scA === 1)
                                                    <span class="badge badge-warning text-dark" style="font-size: 10px;">1</span>
                                                @elseif($scA === '0' || $scA === 0)
                                                    <span class="badge badge-danger" style="font-size: 10px;">0</span>
                                                @elseif($scA === 'NT')
                                                    <span class="badge badge-light border" style="font-size: 10px;">NT</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($assessment->gmfm_dimensi_a_catatan)
                            <small class="text-muted d-block mt-1 font-italic">Catatan A: {{ $assessment->gmfm_dimensi_a_catatan }}</small>
                        @endif
                    </div>

                    <!-- DIMENSI B SECTION -->
                    <div class="p-3 rounded" style="background: #f0fdfa; border: 1px solid #99f6e4;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <strong class="text-teal font-w700" style="font-size: 13px; color: #0d9488;">Dimensi B: Duduk (Sitting)</strong>
                                <div class="text-muted" style="font-size: 11px;">Skor: <strong>{{ $assessment->gmfm_dimensi_b_total ?? 0 }} / 60</strong> ({{ number_format($assessment->gmfm_dimensi_b_persen ?? 0, 1) }}%)</div>
                            </div>
                            <span class="badge {{ ($assessment->gmfm_dimensi_b_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_b_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700" style="font-size: 11px;">
                                @if(($assessment->gmfm_dimensi_b_persen ?? 0) >= 80)
                                    Sangat Baik
                                @elseif(($assessment->gmfm_dimensi_b_persen ?? 0) >= 50)
                                    Sedang
                                @else
                                    Keterbatasan
                                @endif
                            </span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; border-radius: 3px; background: #ccfbf1;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $assessment->gmfm_dimensi_b_persen ?? 0 }}%; background-color: #0d9488;"></div>
                        </div>

                        <!-- 20 Items Dimensi B Mini Table -->
                        @php
                            $gmfm_b_items = config('gmfm.dimensions.B.items', []);
                            $g_b_scores = is_array($assessment->gmfm_dimensi_b_scores) ? $assessment->gmfm_dimensi_b_scores : [];
                        @endphp
                        <div style="max-height: 140px; overflow-y: auto; border: 1px solid #ccfbf1; border-radius: 4px; background: white;">
                            <table class="table table-sm table-hover mb-0" style="font-size: 11px;">
                                <tbody>
                                    @foreach($gmfm_b_items as $no => $item)
                                        @php $scB = $g_b_scores[$no] ?? null; @endphp
                                        <tr>
                                            <td class="text-center text-muted font-w700" style="width: 10%;">{{ $no }}</td>
                                            <td style="width: 75%;">{{ $item['action'] }}</td>
                                            <td class="text-center font-w700" style="width: 15%;">
                                                @if($scB === '3' || $scB === 3)
                                                    <span class="badge badge-success" style="font-size: 10px;">3</span>
                                                @elseif($scB === '2' || $scB === 2)
                                                    <span class="badge badge-primary" style="font-size: 10px;">2</span>
                                                @elseif($scB === '1' || $scB === 1)
                                                    <span class="badge badge-warning text-dark" style="font-size: 10px;">1</span>
                                                @elseif($scB === '0' || $scB === 0)
                                                    <span class="badge badge-danger" style="font-size: 10px;">0</span>
                                                @elseif($scB === 'NT')
                                                    <span class="badge badge-light border" style="font-size: 10px;">NT</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($assessment->gmfm_dimensi_b_catatan)
                            <small class="text-muted d-block mt-1 font-italic">Catatan B: {{ $assessment->gmfm_dimensi_b_catatan }}</small>
                        @endif
                    </div>

                    <!-- DIMENSI C SECTION -->
                    <div class="mt-3 p-3 rounded" style="background: #f5f3ff; border: 1px solid #ddd6fe;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <strong class="font-w700" style="font-size: 13px; color: #7c3aed;">Dimensi C: Merangkak & Berlutut</strong>
                                <div class="text-muted" style="font-size: 11px;">Skor: <strong>{{ $assessment->gmfm_dimensi_c_total ?? 0 }} / 42</strong> ({{ number_format($assessment->gmfm_dimensi_c_persen ?? 0, 1) }}%)</div>
                            </div>
                            <span class="badge {{ ($assessment->gmfm_dimensi_c_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_c_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700" style="font-size: 11px;">
                                @if(($assessment->gmfm_dimensi_c_persen ?? 0) >= 80)
                                    Sangat Baik
                                @elseif(($assessment->gmfm_dimensi_c_persen ?? 0) >= 50)
                                    Sedang
                                @else
                                    Keterbatasan
                                @endif
                            </span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; border-radius: 3px; background: #ede9fe;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $assessment->gmfm_dimensi_c_persen ?? 0 }}%; background-color: #7c3aed;"></div>
                        </div>

                        <!-- 14 Items Dimensi C Mini Table -->
                        @php
                            $gmfm_c_items = config('gmfm.dimensions.C.items', []);
                            $g_c_scores = is_array($assessment->gmfm_dimensi_c_scores) ? $assessment->gmfm_dimensi_c_scores : [];
                        @endphp
                        <div style="max-height: 140px; overflow-y: auto; border: 1px solid #ede9fe; border-radius: 4px; background: white;">
                            <table class="table table-sm table-hover mb-0" style="font-size: 11px;">
                                <tbody>
                                    @foreach($gmfm_c_items as $no => $item)
                                        @php $scC = $g_c_scores[$no] ?? null; @endphp
                                        <tr>
                                            <td class="text-center text-muted font-w700" style="width: 10%;">{{ $no }}</td>
                                            <td style="width: 75%;">{{ $item['action'] }}</td>
                                            <td class="text-center font-w700" style="width: 15%;">
                                                @if($scC === '3' || $scC === 3)
                                                    <span class="badge badge-success" style="font-size: 10px;">3</span>
                                                @elseif($scC === '2' || $scC === 2)
                                                    <span class="badge badge-primary" style="font-size: 10px;">2</span>
                                                @elseif($scC === '1' || $scC === 1)
                                                    <span class="badge badge-warning text-dark" style="font-size: 10px;">1</span>
                                                @elseif($scC === '0' || $scC === 0)
                                                    <span class="badge badge-danger" style="font-size: 10px;">0</span>
                                                @elseif($scC === 'NT')
                                                    <span class="badge badge-light border" style="font-size: 10px;">NT</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($assessment->gmfm_dimensi_c_catatan)
                            <small class="text-muted d-block mt-1 font-italic">Catatan C: {{ $assessment->gmfm_dimensi_c_catatan }}</small>
                        @endif
                    </div>

                    <!-- DIMENSI D SECTION -->
                    <div class="mt-3 p-3 rounded" style="background: #fff7ed; border: 1px solid #fed7aa;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <strong class="font-w700" style="font-size: 13px; color: #ea580c;">Dimensi D: Berdiri (Standing)</strong>
                                <div class="text-muted" style="font-size: 11px;">Skor: <strong>{{ $assessment->gmfm_dimensi_d_total ?? 0 }} / 39</strong> ({{ number_format($assessment->gmfm_dimensi_d_persen ?? 0, 1) }}%)</div>
                            </div>
                            <span class="badge {{ ($assessment->gmfm_dimensi_d_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_d_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700" style="font-size: 11px;">
                                @if(($assessment->gmfm_dimensi_d_persen ?? 0) >= 80)
                                    Sangat Baik
                                @elseif(($assessment->gmfm_dimensi_d_persen ?? 0) >= 50)
                                    Sedang
                                @else
                                    Keterbatasan
                                @endif
                            </span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; border-radius: 3px; background: #ffedd5;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $assessment->gmfm_dimensi_d_persen ?? 0 }}%; background-color: #ea580c;"></div>
                        </div>

                        <!-- 13 Items Dimensi D Mini Table -->
                        @php
                            $gmfm_d_items = config('gmfm.dimensions.D.items', []);
                            $g_d_scores = is_array($assessment->gmfm_dimensi_d_scores) ? $assessment->gmfm_dimensi_d_scores : [];
                        @endphp
                        <div style="max-height: 140px; overflow-y: auto; border: 1px solid #fed7aa; border-radius: 4px; background: white;">
                            <table class="table table-sm table-hover mb-0" style="font-size: 11px;">
                                <tbody>
                                    @foreach($gmfm_d_items as $no => $item)
                                        @php $scD = $g_d_scores[$no] ?? null; @endphp
                                        <tr>
                                            <td class="text-center text-muted font-w700" style="width: 10%;">{{ $no }}</td>
                                            <td style="width: 75%;">{{ $item['action'] }}</td>
                                            <td class="text-center font-w700" style="width: 15%;">
                                                @if($scD === '3' || $scD === 3)
                                                    <span class="badge badge-success" style="font-size: 10px;">3</span>
                                                @elseif($scD === '2' || $scD === 2)
                                                    <span class="badge badge-primary" style="font-size: 10px;">2</span>
                                                @elseif($scD === '1' || $scD === 1)
                                                    <span class="badge badge-warning text-dark" style="font-size: 10px;">1</span>
                                                @elseif($scD === '0' || $scD === 0)
                                                    <span class="badge badge-danger" style="font-size: 10px;">0</span>
                                                @elseif($scD === 'NT')
                                                    <span class="badge badge-light border" style="font-size: 10px;">NT</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($assessment->gmfm_dimensi_d_catatan)
                            <small class="text-muted d-block mt-1 font-italic">Catatan D: {{ $assessment->gmfm_dimensi_d_catatan }}</small>
                        @endif
                    </div>

                    <!-- DIMENSI E SECTION -->
                    <div class="mt-3 p-3 rounded" style="background: #ecfdf5; border: 1px solid #a7f3d0;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <strong class="font-w700" style="font-size: 13px; color: #059669;">Dimensi E: Berjalan, Berlari & Melompat</strong>
                                <div class="text-muted" style="font-size: 11px;">Skor: <strong>{{ $assessment->gmfm_dimensi_e_total ?? 0 }} / 72</strong> ({{ number_format($assessment->gmfm_dimensi_e_persen ?? 0, 1) }}%)</div>
                            </div>
                            <span class="badge {{ ($assessment->gmfm_dimensi_e_persen ?? 0) >= 80 ? 'badge-success' : (($assessment->gmfm_dimensi_e_persen ?? 0) >= 50 ? 'badge-info' : 'badge-warning text-dark') }} font-w700" style="font-size: 11px;">
                                @if(($assessment->gmfm_dimensi_e_persen ?? 0) >= 80)
                                    Sangat Baik
                                @elseif(($assessment->gmfm_dimensi_e_persen ?? 0) >= 50)
                                    Sedang
                                @else
                                    Keterbatasan
                                @endif
                            </span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; border-radius: 3px; background: #d1fae5;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $assessment->gmfm_dimensi_e_persen ?? 0 }}%; background-color: #059669;"></div>
                        </div>

                        <!-- 24 Items Dimensi E Mini Table -->
                        @php
                            $gmfm_e_items = config('gmfm.dimensions.E.items', []);
                            $g_e_scores = is_array($assessment->gmfm_dimensi_e_scores) ? $assessment->gmfm_dimensi_e_scores : [];
                        @endphp
                        <div style="max-height: 140px; overflow-y: auto; border: 1px solid #a7f3d0; border-radius: 4px; background: white;">
                            <table class="table table-sm table-hover mb-0" style="font-size: 11px;">
                                <tbody>
                                    @foreach($gmfm_e_items as $no => $item)
                                        @php $scE = $g_e_scores[$no] ?? null; @endphp
                                        <tr>
                                            <td class="text-center text-muted font-w700" style="width: 10%;">{{ $no }}</td>
                                            <td style="width: 75%;">{{ $item['action'] }}</td>
                                            <td class="text-center font-w700" style="width: 15%;">
                                                @if($scE === '3' || $scE === 3)
                                                    <span class="badge badge-success" style="font-size: 10px;">3</span>
                                                @elseif($scE === '2' || $scE === 2)
                                                    <span class="badge badge-primary" style="font-size: 10px;">2</span>
                                                @elseif($scE === '1' || $scE === 1)
                                                    <span class="badge badge-warning text-dark" style="font-size: 10px;">1</span>
                                                @elseif($scE === '0' || $scE === 0)
                                                    <span class="badge badge-danger" style="font-size: 10px;">0</span>
                                                @elseif($scE === 'NT')
                                                    <span class="badge badge-light border" style="font-size: 10px;">NT</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($assessment->gmfm_dimensi_e_catatan)
                            <small class="text-muted d-block mt-1 font-italic">Catatan E: {{ $assessment->gmfm_dimensi_e_catatan }}</small>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fa fa-info-circle fa-2x mb-2 text-muted"></i>
                        <p class="mb-0 font-w500" style="font-size: 13px;">Item GMFM belum diuji / diisi.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 3. Kemampuan Aktivitas Sehari-hari (ADL) -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-tasks text-primary mr-2"></i> 3. Kemampuan Aktivitas Sehari-hari (ADL)
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size: 13px;">
                    <tbody>
                        <tr>
                            <td style="width: 50%; font-weight: 600; color: #475569;">Kontak Mata</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_kontak_mata)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_kontak_mata }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Duduk Tenang Saat Aktivitas</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_duduk_tenang)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_duduk_tenang }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Gerakan Berulang Tanpa Tujuan</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_gerakan_berulang)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_gerakan_berulang }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Respon Saat Dipanggil Nama</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_respon_nama)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_respon_nama }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Makan</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_makan)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_makan }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Mandi</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_mandi)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_mandi }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Berpakaian</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_berpakaian)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_berpakaian }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">BAK (Buang Air Kecil)</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_bak)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_bak }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">BAB (Buang Air Besar)</td>
                            <td>:</td>
                            <td>
                                @if($assessment->adl_bab)
                                    <span class="badge badge-primary font-w600" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->adl_bab }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if($assessment->adl_catatan)
                    <div class="p-3" style="background: #fafcff; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600 mb-1">Catatan ADL:</span>
                        <p class="mb-0 text-dark">{{ $assessment->adl_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 3. Kemampuan Wicara & Komunikasi -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-comments text-primary mr-2"></i> 3. Kemampuan Wicara & Komunikasi
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size: 13px;">
                    <tbody>
                        <tr>
                            <td style="width: 45%; font-weight: 600; color: #475569;">Kemampuan Berkomunikasi</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->wicara_komunikasi ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Organ Bicara & Pendengaran</td>
                            <td>:</td>
                            <td>
                                <strong class="text-primary">{{ $assessment->wicara_organ ?: '-' }}</strong>
                                @if($assessment->wicara_organ_keterangan)
                                    <br><small class="text-muted">({{ $assessment->wicara_organ_keterangan }})</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Makan, Minum, Mengunyah & Menelan</td>
                            <td>:</td>
                            <td>
                                <strong class="text-primary">{{ $assessment->wicara_makan_menelan ?: '-' }}</strong>
                                @if($assessment->wicara_makan_menelan_keterangan)
                                    <br><small class="text-muted">({{ $assessment->wicara_makan_menelan_keterangan }})</small>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if($assessment->wicara_catatan)
                    <div class="p-3" style="background: #fafcff; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600 mb-1">Catatan Wicara:</span>
                        <p class="mb-0 text-dark">{{ $assessment->wicara_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. Status Penglihatan (Netra) -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-eye text-primary mr-2"></i> 4. Status Penglihatan (Netra)
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size: 13px;">
                    <tbody>
                        <tr>
                            <td style="width: 45%; font-weight: 600; color: #475569;">Klasifikasi Penglihatan</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->penglihatan_klasifikasi ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Onset & Sisi</td>
                            <td>:</td>
                            <td>
                                <strong class="text-primary">{{ $assessment->penglihatan_onset ?: '-' }}</strong>
                                @if($assessment->penglihatan_sisi)
                                    <span class="badge badge-light">({{ $assessment->penglihatan_sisi }})</span>
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
                            <td style="font-weight: 600; color: #475569;">Progresif / Terakhir Periksa</td>
                            <td>:</td>
                            <td>
                                {{ $assessment->penglihatan_progresif ?: '-' }} 
                                {{ $assessment->penglihatan_terakhir_periksa ? ' (' . $assessment->penglihatan_terakhir_periksa . ')' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Visus OD / OS</td>
                            <td>:</td>
                            <td>OD: <strong>{{ $assessment->penglihatan_visus_od ?: '-' }}</strong> &bull; OS: <strong>{{ $assessment->penglihatan_visus_os ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Persepsi Cahaya / Sisi</td>
                            <td>:</td>
                            <td>Cahaya: {{ $assessment->penglihatan_persepsi_cahaya ?: '-' }} &bull; Sisi: {{ $assessment->penglihatan_preferensi_sisi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Alat Bantu</td>
                            <td>:</td>
                            <td>
                                @if(is_array($assessment->penglihatan_alat_bantu) && count($assessment->penglihatan_alat_bantu) > 0)
                                    <div class="d-flex flex-wrap" style="gap: 4px;">
                                        @foreach($assessment->penglihatan_alat_bantu as $alat)
                                            <span class="badge badge-light text-dark font-w600" style="font-size: 11px;">
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
                    <div class="p-3" style="background: #fafcff; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600 mb-1">Catatan Penglihatan:</span>
                        <p class="mb-0 text-dark">{{ $assessment->penglihatan_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 5. Intensitas Nyeri & Body Chart -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-heartbeat text-primary mr-2"></i> 5. Intensitas Nyeri & Body Chart
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                        <table class="table mb-0" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td style="width: 45%; font-weight: 600; color: #475569;">Skor Total Nyeri (VAS)</td>
                                    <td>:</td>
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
                                        Istirahat: <strong>{{ $assessment->nyeri_saat_istirahat !== null ? $assessment->nyeri_saat_istirahat . '/10' : '-' }}</strong> &bull; 
                                        Aktivitas: <strong>{{ $assessment->nyeri_saat_aktivitas !== null ? $assessment->nyeri_saat_aktivitas . '/10' : '-' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Sifat Nyeri</td>
                                    <td>:</td>
                                    <td>
                                        @if(is_array($assessment->nyeri_sifat) && count($assessment->nyeri_sifat) > 0)
                                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                                @foreach($assessment->nyeri_sifat as $sf)
                                                    <span class="badge badge-light text-dark font-w600" style="font-size: 11px;">
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
                            <div class="p-2 mt-2 rounded" style="background: #fafcff; border: 1px dashed #e2e8f0; font-size: 12px;">
                                <span class="text-muted d-block font-w600">Catatan Nyeri:</span>
                                <p class="mb-0 text-dark">{{ $assessment->nyeri_catatan }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-6 col-12 text-center">
                        <span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase;">Pemetaan Body Chart Anatomi:</span>
                        @if($assessment->nyeri_body_chart)
                            <div class="p-2 bg-white rounded d-inline-block" style="border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); max-width: 100%;">
                                <img src="{{ $assessment->nyeri_body_chart }}" alt="Body Chart Nyeri" style="max-height: 220px; max-width: 100%; border-radius: 4px;">
                            </div>
                        @else
                            <div class="p-2 bg-white rounded d-inline-block" style="border: 1.5px solid #e2e8f0; max-width: 100%;">
                                <img src="{{ asset('images/body.png') }}" alt="Body Chart" style="max-height: 220px; max-width: 100%; opacity: 0.7;">
                                <small class="text-muted d-block mt-1">(Belum ada tanda keluhan khusus)</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT) -->
    @php
        $rom_data = is_array($assessment->rom_mmt_data) ? $assessment->rom_mmt_data : [];
        $rom_labels = [
            'kanan'    => 'Kanan (Aktif/Pasif)',
            'kiri'     => 'Kiri (Aktif/Pasif)',
            'cervical' => 'Cervical (Leher)',
            'thoracal' => 'Thoracal (Punggung)',
            'lumbal'   => 'Lumbal (Pinggang)',
            'custom'   => 'Sendi Lainnya'
        ];
    @endphp
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-wheelchair text-primary mr-2"></i> 6. Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT)
                </h5>
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
                                <th style="width: 10%; background: #eef2ff;">MMT (0-5)</th>
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
                                    <td class="text-center font-w700" style="background: #f8faff; color: #3730a3;">
                                        {{ isset($item['mmt']) && $item['mmt'] !== '' ? 'Nilai ' . $item['mmt'] : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($assessment->rom_catatan)
                    <div class="p-3" style="background: #fafcff; border-top: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600 mb-1">Catatan ROM & Kekuatan Otot:</span>
                        <p class="mb-0 text-dark">{{ $assessment->rom_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 7. Pemeriksaan Neurologis (Sistem Saraf) -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-bolt text-primary mr-2"></i> 7. Pemeriksaan Neurologis (Sistem Saraf)
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- Sensasi & Tonus Otot -->
                    <div class="col-md-6 col-12 mb-3">
                        <table class="table table-borderless table-sm mb-0" style="font-size: 12.5px;">
                            <tbody>
                                <tr>
                                    <td style="width: 35%; font-weight: 600; color: #475569;">Sensasi</td>
                                    <td style="width: 3%;">:</td>
                                    <td>
                                        <span class="badge badge-primary light font-w600" style="font-size: 12px;">
                                            {{ $assessment->neuro_sensasi ?: '-' }}
                                        </span>
                                        @if($assessment->neuro_sensasi_area)
                                            <div class="text-muted mt-1" style="font-size: 11.5px;">
                                                <em>Area: {{ $assessment->neuro_sensasi_area }}</em>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Tonus Otot</td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge badge-info light font-w600" style="font-size: 12px;">
                                            {{ $assessment->neuro_tonus_otot ?: '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #475569;">Tes Koordinasi</td>
                                    <td>:</td>
                                    <td>
                                        @if(is_array($assessment->neuro_koordinasi) && count($assessment->neuro_koordinasi) > 0)
                                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                                @foreach($assessment->neuro_koordinasi as $k_item)
                                                    <span class="badge badge-light border font-w600" style="font-size: 11.5px;">
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
                    </div>

                    <!-- Refleks Tendon (D/S) -->
                    <div class="col-md-6 col-12 mb-3">
                        <span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase;">
                            Refleks Fisiologis Tendon (D / S):
                        </span>
                        <div class="table-responsive border rounded">
                            <table class="table table-bordered table-sm text-center mb-0" style="font-size: 12px; background: #ffffff;">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="text-align: left;">Tendon</th>
                                        <th style="width: 25%;">D (Kanan)</th>
                                        <th style="width: 25%;">S (Kiri)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Bisep (C5-C6)</td>
                                        <td>{{ $assessment->neuro_refleks_bisep_d ?: '-' }}</td>
                                        <td>{{ $assessment->neuro_refleks_bisep_s ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Trisep (C7)</td>
                                        <td>{{ $assessment->neuro_refleks_trisep_d ?: '-' }}</td>
                                        <td>{{ $assessment->neuro_refleks_trisep_s ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Patela (L3-L4)</td>
                                        <td>{{ $assessment->neuro_refleks_patela_d ?: '-' }}</td>
                                        <td>{{ $assessment->neuro_refleks_patela_s ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">Achilles (S1)</td>
                                        <td>{{ $assessment->neuro_refleks_achilles_d ?: '-' }}</td>
                                        <td>{{ $assessment->neuro_refleks_achilles_s ?: '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($assessment->neuro_catatan)
                    <div class="p-2 mt-2 rounded" style="background: #fafcff; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600">Catatan Neurologis:</span>
                        <p class="mb-0 text-dark">{{ $assessment->neuro_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 8. Pemeriksaan Postur & Keseimbangan -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-male text-primary mr-2"></i> 8. Pemeriksaan Postur & Keseimbangan
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- Temuan Postur -->
                    <div class="col-lg-5 col-12 mb-3">
                        <span class="text-muted d-block font-w600 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                            Temuan Postur (Observasi / Palpasi):
                        </span>
                        @if(is_array($assessment->postur_temuan) && count($assessment->postur_temuan) > 0)
                            <div class="d-flex flex-column" style="gap: 5px;">
                                @foreach($assessment->postur_temuan as $pt)
                                    <div class="p-2 rounded border bg-light font-w600 text-dark" style="font-size: 12px;">
                                        <i class="fa fa-check text-primary mr-1"></i> {{ $pt }}
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted" style="font-size: 12.5px;">- (Tidak ada kelainan postur khusus)</div>
                        @endif

                        <div class="mt-3 p-2 bg-white rounded border" style="font-size: 12px;">
                            <span class="text-muted font-w600 d-block">Postur Tangan Tongkat:</span>
                            <strong class="text-primary">{{ $assessment->postur_tangan_tongkat ?: '-' }}</strong>
                        </div>
                    </div>

                    <!-- Instrumen Keseimbangan Table -->
                    <div class="col-lg-7 col-12 mb-3">
                        <span class="text-muted d-block font-w600 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                            Hasil Uji Instrumen Keseimbangan:
                        </span>
                        <div class="table-responsive border rounded">
                            <table class="table table-bordered table-sm mb-0" style="font-size: 12px; background: #ffffff;">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Instrumen</th>
                                        <th style="width: 32%;">Skor / Hasil</th>
                                        <th style="width: 35%;">Interpretasi / Cut-off</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-w600">Berg Balance Scale (BBS)</td>
                                        <td><strong>{{ $assessment->keseimbangan_bbs_skor !== null ? $assessment->keseimbangan_bbs_skor . ' / 56' : '-' }}</strong></td>
                                        <td>
                                            @if($assessment->keseimbangan_bbs_skor !== null && $assessment->keseimbangan_bbs_skor < 45)
                                                <span class="badge badge-warning text-dark font-w600">&lt; 45 (Risiko jatuh tinggi)</span>
                                            @else
                                                <span class="text-muted">Cut-off &lt; 45</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Timed Up and Go (TUG)</td>
                                        <td><strong>{{ $assessment->keseimbangan_tug_detik ? $assessment->keseimbangan_tug_detik . ' Detik' : '-' }}</strong></td>
                                        <td>
                                            @if($assessment->keseimbangan_tug_detik && (float)$assessment->keseimbangan_tug_detik > 13.5)
                                                <span class="badge badge-warning text-dark font-w600">&gt; 13.5s (Risiko jatuh)</span>
                                            @else
                                                <span class="text-muted">Cut-off &gt; 13.5 Detik</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Romberg Test</td>
                                        <td><strong>{{ $assessment->keseimbangan_romberg ?: '-' }}</strong></td>
                                        <td>
                                            @if($assessment->keseimbangan_romberg == 'Positif')
                                                <span class="text-danger font-w600">Defisit vestibular / propriosepsi</span>
                                            @else
                                                <span class="text-muted">Mata tertutup</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">One-Leg Stance (OLS)</td>
                                        <td>
                                            Kanan: <strong>{{ $assessment->keseimbangan_ols_kanan ? $assessment->keseimbangan_ols_kanan . 's' : '-' }}</strong> &bull;
                                            Kiri: <strong>{{ $assessment->keseimbangan_ols_kiri ? $assessment->keseimbangan_ols_kiri . 's' : '-' }}</strong>
                                        </td>
                                        <td><span class="text-muted">Cut-off &lt; 5 Detik</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Dual-Task TUG</td>
                                        <td><strong>{{ $assessment->keseimbangan_dual_task_tug ? $assessment->keseimbangan_dual_task_tug . ' Detik' : '-' }}</strong></td>
                                        <td><span class="text-muted">Selisih &gt; 4.5s dari TUG</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Falls Efficacy (FES-I)</td>
                                        <td><strong>{{ $assessment->keseimbangan_fesi_skor !== null ? $assessment->keseimbangan_fesi_skor . ' / 64' : '-' }}</strong></td>
                                        <td>
                                            @if($assessment->keseimbangan_fesi_skor !== null && $assessment->keseimbangan_fesi_skor > 28)
                                                <span class="badge badge-danger light font-w600">&gt; 28 (Ketakutan jatuh tinggi)</span>
                                            @else
                                                <span class="text-muted">Cut-off &gt; 28</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($assessment->postur_keseimbangan_catatan)
                    <div class="p-2 mt-2 rounded" style="background: #fafcff; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600">Catatan Keseimbangan & Strategi Kompensasi:</span>
                        <p class="mb-0 text-dark">{{ $assessment->postur_keseimbangan_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 9. Pemeriksaan Gaya Berjalan (Gait) -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-blind text-primary mr-2"></i> 9. Pemeriksaan Gaya Berjalan (Gait)
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- Karakteristik Gait -->
                    <div class="col-lg-6 col-12 mb-3">
                        <span class="text-muted d-block font-w600 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                            Karakteristik Pola Berjalan:
                        </span>
                        @if(is_array($assessment->gait_karakteristik) && count($assessment->gait_karakteristik) > 0)
                            <div class="d-flex flex-column" style="gap: 5px;">
                                @foreach($assessment->gait_karakteristik as $gk)
                                    <div class="p-2 rounded border bg-light font-w600 text-dark" style="font-size: 12px;">
                                        <i class="fa fa-check text-primary mr-1"></i> {{ $gk }}
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted" style="font-size: 12.5px;">- (Pola berjalan dalam batas normal)</div>
                        @endif

                        <div class="mt-3 p-2 bg-white rounded border" style="font-size: 12px;">
                            <span class="text-muted font-w600 d-block">Deteksi Perubahan Tekstur Lantai:</span>
                            <strong class="{{ $assessment->gait_deteksi_lantai == 'Baik' ? 'text-success' : 'text-danger' }}">
                                {{ $assessment->gait_deteksi_lantai ?: '-' }}
                            </strong>
                        </div>
                    </div>

                    <!-- 10-Meter Walk Test (10MWT) -->
                    <div class="col-lg-6 col-12 mb-3">
                        <span class="text-muted d-block font-w600 mb-2" style="font-size: 11.5px; text-transform: uppercase;">
                            10-Meter Walk Test (10MWT):
                        </span>
                        <div class="table-responsive border rounded mb-2">
                            <table class="table table-bordered table-sm text-center mb-0" style="font-size: 12px; background: #ffffff;">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Kecepatan Nyaman</th>
                                        <th>Kecepatan Cepat</th>
                                        <th>Jumlah Langkah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-w700 text-primary" style="font-size: 13px;">
                                            {{ $assessment->gait_10mwt_kecepatan_nyaman ? $assessment->gait_10mwt_kecepatan_nyaman . ' m/s' : '-' }}
                                        </td>
                                        <td class="font-w700 text-info" style="font-size: 13px;">
                                            {{ $assessment->gait_10mwt_kecepatan_cepat ? $assessment->gait_10mwt_kecepatan_cepat . ' m/s' : '-' }}
                                        </td>
                                        <td class="font-w700 text-dark" style="font-size: 13px;">
                                            {{ $assessment->gait_10mwt_jumlah_langkah ? $assessment->gait_10mwt_jumlah_langkah . ' Langkah' : '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($assessment->gait_catatan)
                    <div class="p-2 mt-2 rounded" style="background: #fafcff; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600">Catatan Pola Berjalan (Gait):</span>
                        <p class="mb-0 text-dark">{{ $assessment->gait_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 10. Pemeriksaan Sensoris, Propriosepsi & Vestibular -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-hand-paper-o text-primary mr-2"></i> 10. Pemeriksaan Sensoris, Propriosepsi & Vestibular
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- A. Sensasi Taktil -->
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-hand-paper-o text-primary mr-1"></i> A. Sensasi Taktil
                            </span>
                            <table class="table table-sm table-borderless mb-0" style="font-size: 12.5px;">
                                <tbody>
                                    <tr>
                                        <td class="text-muted font-w600 py-1" style="width: 50%;">Raba Halus:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->sensoris_taktil_raba_halus == 'Normal' ? 'badge-success' : ($assessment->sensoris_taktil_raba_halus == 'Terganggu' ? 'badge-danger' : 'badge-light') }} font-w600">
                                                {{ $assessment->sensoris_taktil_raba_halus ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted font-w600 py-1">Pinprick:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->sensoris_taktil_pinprick == 'Normal' ? 'badge-success' : ($assessment->sensoris_taktil_pinprick == 'Terganggu' ? 'badge-danger' : 'badge-light') }} font-w600">
                                                {{ $assessment->sensoris_taktil_pinprick ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted font-w600 py-1">Suhu:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->sensoris_taktil_suhu == 'Normal' ? 'badge-success' : ($assessment->sensoris_taktil_suhu == 'Terganggu' ? 'badge-danger' : 'badge-light') }} font-w600">
                                                {{ $assessment->sensoris_taktil_suhu ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- B. Propriosepsi & Kinesthesia -->
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-compass text-primary mr-1"></i> B. Propriosepsi & Kinesthesia
                            </span>
                            <table class="table table-sm table-borderless mb-0" style="font-size: 12.5px;">
                                <tbody>
                                    <tr>
                                        <td class="text-muted font-w600 py-1" style="width: 55%;">Posisi Sendi:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->sensoris_posisi_sendi == 'Normal' ? 'badge-success' : ($assessment->sensoris_posisi_sendi == 'Terganggu' ? 'badge-danger' : 'badge-light') }} font-w600">
                                                {{ $assessment->sensoris_posisi_sendi ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted font-w600 py-1">Vibrasi:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->sensoris_vibrasi == 'Normal' ? 'badge-success' : ($assessment->sensoris_vibrasi == 'Terganggu' ? 'badge-danger' : 'badge-light') }} font-w600">
                                                {{ $assessment->sensoris_vibrasi ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted font-w600 py-1">Kinesthesia Jari:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->sensoris_kinesthesia_jari == 'Normal' ? 'badge-success' : ($assessment->sensoris_kinesthesia_jari == 'Terganggu' ? 'badge-danger' : 'badge-light') }} font-w600">
                                                {{ $assessment->sensoris_kinesthesia_jari ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- C. Skrining Vestibular Dasar -->
                    <div class="col-lg-4 col-md-12 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-refresh text-primary mr-1"></i> C. Skrining Vestibular Dasar
                            </span>
                            <table class="table table-sm table-borderless mb-0" style="font-size: 12.5px;">
                                <tbody>
                                    <tr>
                                        <td class="text-muted font-w600 py-1" style="width: 50%;">Head Impulse Test:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->vestibular_hit == 'Normal' ? 'badge-success' : ($assessment->vestibular_hit == 'Abnormal' ? 'badge-danger' : 'badge-light') }} font-w600">
                                                {{ $assessment->vestibular_hit ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted font-w600 py-1">Dix-Hallpike:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->vestibular_dix_hallpike == 'Positif' ? 'badge-warning text-dark' : ($assessment->vestibular_dix_hallpike == 'Negatif' ? 'badge-success' : 'badge-light') }} font-w600">
                                                {{ $assessment->vestibular_dix_hallpike ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted font-w600 py-1">Keluhan Pusing:</td>
                                        <td class="py-1">
                                            <span class="badge {{ $assessment->vestibular_keluhan_pusing == 'Ya' ? 'badge-warning text-dark' : ($assessment->vestibular_keluhan_pusing == 'Tidak' ? 'badge-success' : 'badge-light') }} font-w600">
                                                {{ $assessment->vestibular_keluhan_pusing ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($assessment->sensoris_defisit_lokasi)
                    <div class="p-3 mb-2 rounded" style="background: #fafcff; border: 1px dashed #cbd5e1; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600 mb-1">
                            <i class="fa fa-map-marker text-primary mr-1"></i> Lokasi & Deskripsi Defisit Sensoris (Dermatom / Pola):
                        </span>
                        <p class="mb-0 text-dark font-w500">{{ $assessment->sensoris_defisit_lokasi }}</p>
                    </div>
                @endif

                @if($assessment->sensoris_catatan)
                    <div class="p-2 mt-2 rounded" style="background: #f8fafc; border: 1px solid #edf2f7; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600">Catatan Observasi Sensoris & Vestibular:</span>
                        <p class="mb-0 text-dark">{{ $assessment->sensoris_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 11. Faktor Psikososial & Kontekstual -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-users text-primary mr-2"></i> 11. Faktor Psikososial & Kontekstual
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- Pekerjaan & Hobi -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-1" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-briefcase text-primary mr-1"></i> Pekerjaan / Hobi Terdampak:
                            </span>
                            <div class="font-w600 text-dark mt-1" style="font-size: 13px;">
                                {{ $assessment->psikososial_pekerjaan_hobi ?: '-' }}
                            </div>
                        </div>
                    </div>

                    <!-- Dukungan Sosial -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-1" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-home text-primary mr-1"></i> Dukungan Sosial:
                            </span>
                            <div class="mt-1">
                                <span class="badge {{ $assessment->psikososial_dukungan_sosial == 'Baik (keluarga mendukung)' ? 'badge-success' : ($assessment->psikososial_dukungan_sosial == 'Cukup' ? 'badge-info' : ($assessment->psikososial_dukungan_sosial ? 'badge-warning text-dark' : 'badge-light')) }} font-w600" style="font-size: 12px; padding: 5px 10px;">
                                    {{ $assessment->psikososial_dukungan_sosial ?: '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Faktor Psikologis -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-1" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-heart text-primary mr-1"></i> Faktor Psikologis & Emosional:
                            </span>
                            <div class="mt-1">
                                <span class="badge {{ $assessment->psikososial_faktor_psikologis == 'Tidak ada kekhawatiran' ? 'badge-success' : ($assessment->psikososial_faktor_psikologis ? 'badge-warning text-dark' : 'badge-light') }} font-w600" style="font-size: 12px; padding: 5px 10px;">
                                    {{ $assessment->psikososial_faktor_psikologis ?: '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Harapan / Ekspektasi Pasien -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-1" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-bullseye text-primary mr-1"></i> Harapan / Ekspektasi Pasien:
                            </span>
                            <div class="font-w600 text-dark mt-1" style="font-size: 13px;">
                                {{ $assessment->psikososial_harapan_pasien ?: '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                @if($assessment->psikososial_catatan)
                    <div class="p-2 mt-2 rounded" style="background: #f8fafc; border: 1px solid #edf2f7; font-size: 12.5px;">
                        <span class="text-muted d-block font-w600">Catatan Observasi Psikososial & Kontekstual:</span>
                        <p class="mb-0 text-dark">{{ $assessment->psikososial_catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 12. Perencanaan Terapi & Intervensi -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-calendar-check-o text-primary mr-2"></i> 12. Perencanaan Terapi & Program Intervensi
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Intervensi Grid -->
                <div class="row mb-3">
                    <!-- Modalitas Fisik -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-plug text-primary mr-1"></i> Modalitas Fisik:
                            </span>
                            @if(is_array($assessment->rencana_modalitas_fisik) && count($assessment->rencana_modalitas_fisik) > 0)
                                <div class="d-flex flex-wrap" style="gap: 5px;">
                                    @foreach($assessment->rencana_modalitas_fisik as $mf)
                                        <span class="badge badge-light font-w600 text-dark border" style="font-size: 11.5px; padding: 4px 8px;">
                                            <i class="fa fa-check text-primary mr-1"></i> {{ $mf }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 12.5px;">- (Tidak ada modalitas fisik khusus)</span>
                            @endif
                            @if($assessment->rencana_modalitas_lainnya)
                                <div class="mt-2 text-muted" style="font-size: 12px;">
                                    <em>Lainnya: {{ $assessment->rencana_modalitas_lainnya }}</em>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Manual Terapi -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-hand-paper-o text-primary mr-1"></i> Manual Terapi:
                            </span>
                            @if(is_array($assessment->rencana_manual_terapi) && count($assessment->rencana_manual_terapi) > 0)
                                <div class="d-flex flex-wrap" style="gap: 5px;">
                                    @foreach($assessment->rencana_manual_terapi as $mt)
                                        <span class="badge badge-light font-w600 text-dark border" style="font-size: 11.5px; padding: 4px 8px;">
                                            <i class="fa fa-check text-primary mr-1"></i> {{ $mt }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 12.5px;">- (Tidak ada manual terapi khusus)</span>
                            @endif
                            @if($assessment->rencana_manual_lainnya)
                                <div class="mt-2 text-muted" style="font-size: 12px;">
                                    <em>Lainnya: {{ $assessment->rencana_manual_lainnya }}</em>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Latihan Terapi -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-heartbeat text-primary mr-1"></i> Latihan Terapi:
                            </span>
                            @if(is_array($assessment->rencana_latihan_terapi) && count($assessment->rencana_latihan_terapi) > 0)
                                <div class="d-flex flex-wrap" style="gap: 5px;">
                                    @foreach($assessment->rencana_latihan_terapi as $lt)
                                        <span class="badge badge-light font-w600 text-dark border" style="font-size: 11.5px; padding: 4px 8px;">
                                            <i class="fa fa-check text-primary mr-1"></i> {{ $lt }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 12.5px;">- (Tidak ada latihan terapi khusus)</span>
                            @endif
                            @if($assessment->rencana_latihan_lainnya)
                                <div class="mt-2 text-muted" style="font-size: 12px;">
                                    <em>Lainnya: {{ $assessment->rencana_latihan_lainnya }}</em>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Edukasi & Konseling -->
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="p-3 bg-white rounded border h-100">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 12px; text-transform: uppercase;">
                                <i class="fa fa-graduation-cap text-primary mr-1"></i> Edukasi & Konseling:
                            </span>
                            @if(is_array($assessment->rencana_edukasi_konseling) && count($assessment->rencana_edukasi_konseling) > 0)
                                <div class="d-flex flex-wrap" style="gap: 5px;">
                                    @foreach($assessment->rencana_edukasi_konseling as $ek)
                                        <span class="badge badge-light font-w600 text-dark border" style="font-size: 11.5px; padding: 4px 8px;">
                                            <i class="fa fa-check text-primary mr-1"></i> {{ $ek }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 12.5px;">- (Tidak ada edukasi khusus)</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Program & Pengaturan Dosis Terapi Card -->
                <div class="card mb-0 border-0" style="background: #f8fafc; border-radius: 8px;">
                    <div class="card-body p-3">
                        <span class="text-muted font-w600 d-block mb-2" style="font-size: 12px; text-transform: uppercase;">
                            <i class="fa fa-sliders text-primary mr-1"></i> Program & Pengaturan Dosis Terapi:
                        </span>
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-2 mb-md-0">
                                <div class="p-2 bg-white rounded border">
                                    <small class="text-muted d-block" style="font-size: 11px;">Frekuensi Terapi</small>
                                    <strong class="text-primary font-w700" style="font-size: 13px;">{{ $assessment->rencana_dosis_frekuensi ? $assessment->rencana_dosis_frekuensi . ' x/minggu' : '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2 mb-md-0">
                                <div class="p-2 bg-white rounded border">
                                    <small class="text-muted d-block" style="font-size: 11px;">Durasi per Sesi</small>
                                    <strong class="text-info font-w700" style="font-size: 13px;">{{ $assessment->rencana_dosis_durasi ? $assessment->rencana_dosis_durasi . ' Menit' : '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="p-2 bg-white rounded border">
                                    <small class="text-muted d-block" style="font-size: 11px;">Estimasi Total Sesi</small>
                                    <strong class="text-dark font-w700" style="font-size: 13px;">{{ $assessment->rencana_dosis_total_sesi ?: '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="p-2 bg-white rounded border">
                                    <small class="text-muted d-block" style="font-size: 11px;">Jadwal Re-assessment</small>
                                    <strong class="text-success font-w700" style="font-size: 13px;">{{ $assessment->rencana_dosis_reassessment ?: '-' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 14. Kesimpulan & Rekomendasi Terapi -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-file-text-o text-primary mr-2"></i> 14. Evaluasi Klinis & Target Program Terapi
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 col-12 mb-3 mb-md-0">
                        <span class="text-muted font-w600 d-block mb-1" style="font-size: 12.5px; text-transform: uppercase;">
                            <i class="fa fa-user-md text-primary mr-1"></i> Kesimpulan & Evaluasi Klinis Terapis:
                        </span>
                        <div class="p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7; font-size: 13px; color: #1e293b; line-height: 1.6;">
                            {{ $assessment->kesimpulan ?: '-' }}
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <span class="text-muted font-w600 d-block mb-1" style="font-size: 12.5px; text-transform: uppercase;">
                            <i class="fa fa-bullseye text-primary mr-1"></i> Rencana Program Terapi Lanjutan & Target:
                        </span>
                        <div class="p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7; font-size: 13px; color: #1e293b; line-height: 1.6;">
                            {{ $assessment->rencana_terapi ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 15. SKALA DENVER (DDST II) -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7; gap: 8px;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-graduation-cap text-primary mr-2"></i> 15. Skala Perkembangan Denver II (DDST II)
                </h5>
                @php
                    $has_denver = !is_null($assessment->denver_pass_count) || !is_null($assessment->denver_fail_count) || !empty($assessment->denver_data);
                @endphp
                @if($has_denver)
                    <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                        <span class="badge badge-success font-w700" style="font-size: 11px; padding: 4px 7px;">P: {{ $assessment->denver_pass_count ?? 0 }}</span>
                        <span class="badge badge-danger font-w700" style="font-size: 11px; padding: 4px 7px;">F: {{ $assessment->denver_fail_count ?? 0 }}</span>
                        <span class="badge badge-warning font-w700" style="font-size: 11px; padding: 4px 7px;">R: {{ $assessment->denver_refusal_count ?? 0 }}</span>
                        <span class="badge badge-secondary font-w700" style="font-size: 11px; padding: 4px 7px;">NO: {{ $assessment->denver_no_count ?? 0 }}</span>
                        <span class="badge badge-primary font-w700 text-uppercase ml-2" style="font-size: 11.5px; padding: 4px 8px;">{{ $assessment->denver_kesimpulan ?: 'Evaluasi DDST II' }}</span>
                    </div>
                @endif
            </div>
            <div class="card-body p-4">
                @if($has_denver)
                    <!-- Top Summary Banner -->
                    <div class="mb-4 p-3 rounded d-flex justify-content-between align-items-center flex-wrap" style="background: #1e293b; color: white; border-radius: 8px; gap: 10px;">
                        <div>
                            <small class="text-white-50 text-uppercase font-w600" style="font-size: 11px;">Hasil Skrining Tumbuh Kembang Denver II</small>
                            <div class="font-w700 mt-1" style="font-size: 15px;">
                                Status Perkembangan: 
                                <span class="badge {{ $assessment->denver_kesimpulan == 'Normal (Sesuai Usia)' ? 'badge-success' : ($assessment->denver_kesimpulan == 'Suspect (Meragukan)' ? 'badge-warning' : 'badge-danger') }} font-w700 ml-1" style="font-size: 13px;">
                                    {{ $assessment->denver_kesimpulan ?: 'Tercatat' }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <div class="text-center px-2">
                                <small class="text-white-50 d-block font-w600" style="font-size: 10.5px;">Pass (P)</small>
                                <strong class="text-success" style="font-size: 16px;">{{ $assessment->denver_pass_count ?? 0 }}</strong>
                            </div>
                            <div class="text-center px-2" style="border-left: 1px solid rgba(255,255,255,0.15);">
                                <small class="text-white-50 d-block font-w600" style="font-size: 10.5px;">Fail (F)</small>
                                <strong class="text-danger" style="font-size: 16px;">{{ $assessment->denver_fail_count ?? 0 }}</strong>
                            </div>
                            <div class="text-center px-2" style="border-left: 1px solid rgba(255,255,255,0.15);">
                                <small class="text-white-50 d-block font-w600" style="font-size: 10.5px;">Refusal (R)</small>
                                <strong class="text-warning" style="font-size: 16px;">{{ $assessment->denver_refusal_count ?? 0 }}</strong>
                            </div>
                            <div class="text-center px-2" style="border-left: 1px solid rgba(255,255,255,0.15);">
                                <small class="text-white-50 d-block font-w600" style="font-size: 10.5px;">No Opp (NO)</small>
                                <strong class="text-white-50" style="font-size: 16px;">{{ $assessment->denver_no_count ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    @php
                        $denver_data = is_array($assessment->denver_data) ? $assessment->denver_data : [];
                        $denver_sectors = [
                            'A' => [
                                'title' => 'A. Personal Sosial',
                                'badge_color' => '#0284c7',
                                'tasks' => [
                                    'ps_1' => ['no' => 1, 'name' => 'Menatap Muka', 'age' => '0–6 Bln'],
                                    'ps_2' => ['no' => 2, 'name' => 'Tepuk Tangan', 'age' => '6–12 Bln'],
                                    'ps_3' => ['no' => 3, 'name' => 'Menggunakan Sendok/Garpu', 'age' => '12–24 Bln'],
                                    'ps_4' => ['no' => 4, 'name' => 'Menyebut Nama Teman', 'age' => '2–4 Thn'],
                                ]
                            ],
                            'B' => [
                                'title' => 'B. Motorik Halus - Adaptif',
                                'badge_color' => '#7c3aed',
                                'tasks' => [
                                    'mh_1' => ['no' => 1, 'name' => 'Memegang Mainan yang Bisa Digoyangkan', 'age' => '0–6 Bln'],
                                    'mh_2' => ['no' => 2, 'name' => 'Menjimpit (Ibu Jari & Jari)', 'age' => '6–12 Bln'],
                                    'mh_3' => ['no' => 3, 'name' => 'Menara 2 Kubus', 'age' => '12–24 Bln'],
                                    'mh_4' => ['no' => 4, 'name' => 'Meniru Garis Vertikal', 'age' => '2–4 Thn'],
                                    'mh_5' => ['no' => 5, 'name' => 'Menggambar Orang 6 Bagian', 'age' => '4–6 Thn'],
                                ]
                            ],
                            'C' => [
                                'title' => 'C. Bahasa',
                                'badge_color' => '#059669',
                                'tasks' => [
                                    'bh_1' => ['no' => 1, 'name' => 'Bereaksi Terhadap Bel', 'age' => '0–6 Bln'],
                                    'bh_2' => ['no' => 2, 'name' => 'Menyebut 1 Kata', 'age' => '6–12 Bln'],
                                    'bh_3' => ['no' => 3, 'name' => 'Menunjuk 2 Gambar', 'age' => '12–24 Bln'],
                                    'bh_4' => ['no' => 4, 'name' => 'Menyebut 1 Warna', 'age' => '2–4 Thn'],
                                    'bh_5' => ['no' => 5, 'name' => 'Menghitung 5 Kubus', 'age' => '4–6 Thn'],
                                ]
                            ],
                            'D' => [
                                'title' => 'D. Motorik Kasar',
                                'badge_color' => '#ea580c',
                                'tasks' => [
                                    'mk_1' => ['no' => 1, 'name' => 'Mengangkat Kepala', 'age' => '0–6 Bln'],
                                    'mk_2' => ['no' => 2, 'name' => 'Berjalan Dengan Baik', 'age' => '6–12 Bln'],
                                    'mk_3' => ['no' => 3, 'name' => 'Menendang Bola ke Depan', 'age' => '12–24 Bln'],
                                    'mk_4' => ['no' => 4, 'name' => 'Berdiri 1 Kaki (4 Detik)', 'age' => '2–4 Thn'],
                                    'mk_5' => ['no' => 5, 'name' => 'Berdiri 1 Kaki (6 Detik)', 'age' => '4–6 Thn'],
                                ]
                            ],
                        ];
                    @endphp

                    <div class="row">
                        @foreach($denver_sectors as $sector)
                            <div class="col-md-6 col-12 mb-3">
                                <div class="p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <h6 class="font-w700 mb-2" style="color: {{ $sector['badge_color'] }}; font-size: 13px;">
                                        {{ $sector['title'] }}
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0" style="font-size: 12px;">
                                            <tbody>
                                                @foreach($sector['tasks'] as $tKey => $task)
                                                    @php
                                                        $tScore = $denver_data[$tKey]['score'] ?? null;
                                                        $tNote = $denver_data[$tKey]['catatan'] ?? null;
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 55%;">
                                                            <strong class="text-dark">{{ $task['name'] }}</strong>
                                                            <small class="text-muted d-block">Rentang: {{ $task['age'] }}</small>
                                                            @if($tNote)
                                                                <small class="text-info font-italic d-block">Catatan: {{ $tNote }}</small>
                                                            @endif
                                                        </td>
                                                        <td class="text-right" style="width: 45%; vertical-align: middle;">
                                                            @if($tScore === 'P')
                                                                <span class="badge badge-success font-w700" style="font-size: 11px;">Pass (P)</span>
                                                            @elseif($tScore === 'F')
                                                                <span class="badge badge-danger font-w700" style="font-size: 11px;">Fail (F)</span>
                                                            @elseif($tScore === 'R')
                                                                <span class="badge badge-warning font-w700" style="font-size: 11px;">Refusal (R)</span>
                                                            @elseif($tScore === 'NO')
                                                                <span class="badge badge-light border font-w700" style="font-size: 11px;">No Opp (NO)</span>
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
                            </div>
                        @endforeach
                    </div>

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
    </div>
</div>

@endsection

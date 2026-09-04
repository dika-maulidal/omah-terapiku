@extends('layout.apps')
@section('content')

<!-- Page Header Banner (Unified Card Sesuai DESIGN.md) -->
<div class="card mb-3 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0; border: 1px solid #bfdbfe; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);">
                    <i class="fa-solid fa-file-waveform"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <h3 class="font-w700 mb-0" style="color: #1e40af; font-size: 20px;">Hasil Assessment Penerima Manfaat</h3>
                        <span class="badge font-w700" style="font-size: 12px; padding: 4px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                            <i class="fa-solid fa-id-card mr-1"></i> {{ $pasien->no_rm }}
                        </span>
                    </div>
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
                <a href="{{Route('rekam.assessment', $rekam->id)}}" class="btn btn-sm btn-info text-white font-w600" style="padding: 8px 16px; font-size: 12.5px; border-radius: 8px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important; border: none !important; box-shadow: 0 4px 10px rgba(2, 132, 199, 0.2);">
                    <i class="fa-solid fa-pencil mr-1"></i> Edit Assessment
                </a>
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
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <h4 class="font-w700 mb-0" style="font-size: 16.5px; color: #1e293b;">
                            {{ $pasien->nama }}
                        </h4>
                        <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                            {{ $pasien->no_rm }}
                        </span>
                        @if($pasien->status_display)
                            {!! $pasien->status_display !!}
                        @endif
                    </div>
                    <!-- Metadata Info Pasien -->
                    <div class="d-flex align-items-center flex-wrap mt-2" style="gap: 12px;">
                        <span class="badge badge-light border" style="padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #334155; background: #f8fafc;">
                            <i class="fa-solid fa-venus-mars mr-1.5 text-primary"></i> {{ $pasien->jk ?: '-' }}
                        </span>
                        <span class="badge badge-light border" style="padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #334155; background: #f8fafc;">
                            <i class="fa-solid fa-calendar mr-1.5 text-primary"></i> {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ?: '-' }} ({{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age . ' Thn' : '-' }})
                        </span>
                        <span class="badge font-w700" style="padding: 6px 14px; border-radius: 6px; font-size: 12px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                            <i class="fa-solid fa-wheelchair mr-1.5 text-primary"></i> {{ $pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada' ? $pasien->jenis_disabilitas : 'Non-Disabilitas' }}
                        </span>
                        @if($pasien->nik)
                            <span class="badge badge-light border" style="padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #475569; background: #f8fafc;">
                                <i class="fa-solid fa-id-card mr-1.5 text-primary"></i> NIK: {{ $pasien->nik }}
                            </span>
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

    <!-- 6 Modules Underline Tab Navigation Header -->
    <div class="card-header p-0 border-bottom" style="background: #ffffff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
        <ul class="nav nav-tabs ot-underline-tabs border-bottom-0 flex-nowrap" id="assessmentShowTab" role="tablist" style="overflow-x: auto; overflow-y: hidden; white-space: nowrap; -webkit-overflow-scrolling: touch; padding: 0 16px;">
            <li class="nav-item" role="presentation">
                <a class="nav-link module-tab-link active" id="tab-modul1-btn" data-toggle="tab" href="#modul-1" role="tab" aria-controls="modul-1" aria-selected="true" data-module-index="1">
                    <span class="tab-module-num">1</span>
                    <span class="tab-module-title">Penglihatan & Psikososial</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link module-tab-link" id="tab-modul2-btn" data-toggle="tab" href="#modul-2" role="tab" aria-controls="modul-2" aria-selected="false" data-module-index="2">
                    <span class="tab-module-num">2</span>
                    <span class="tab-module-title">Motorik & ADL</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link module-tab-link" id="tab-modul3-btn" data-toggle="tab" href="#modul-3" role="tab" aria-controls="modul-3" aria-selected="false" data-module-index="3">
                    <span class="tab-module-num">3</span>
                    <span class="tab-module-title">Fisik & Nyeri</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link module-tab-link" id="tab-modul4-btn" data-toggle="tab" href="#modul-4" role="tab" aria-controls="modul-4" aria-selected="false" data-module-index="4">
                    <span class="tab-module-num">4</span>
                    <span class="tab-module-title">Neurologis & Gait</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link module-tab-link" id="tab-modul5-btn" data-toggle="tab" href="#modul-5" role="tab" aria-controls="modul-5" aria-selected="false" data-module-index="5">
                    <span class="tab-module-num">5</span>
                    <span class="tab-module-title">GMFM & Denver II</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link module-tab-link" id="tab-modul6-btn" data-toggle="tab" href="#modul-6" role="tab" aria-controls="modul-6" aria-selected="false" data-module-index="6">
                    <span class="tab-module-num">6</span>
                    <span class="tab-module-title">Rencana Terapi & TTD</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Tab Content Panels -->
    <div class="card-body p-3 p-md-4">
        <div class="tab-content" id="assessmentShowTabContent">

            <!-- ======================================================== -->
            <!-- MODUL 1: STATUS PENGLIHATAN & PSIKOSOSIAL               -->
            <!-- ======================================================== -->
            <div class="tab-pane fade show active" id="modul-1" role="tabpanel" aria-labelledby="tab-modul1-btn">
                <div class="row">
                    <!-- Subtest 1.1: Status Penglihatan (Netra) -->
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-eye text-primary mr-1.5"></i> Subtest 1.1: Status Penglihatan (Netra)
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0" style="font-size: 13px;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 44%; font-weight: 600; color: #475569;">Klasifikasi Penglihatan</td>
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
                                            <td style="font-weight: 600; color: #475569;">Progresifitas</td>
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
                    </div>

                    <!-- Subtest 1.2: Faktor Psikososial & Kontekstual -->
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-users text-primary mr-1.5"></i> Subtest 1.2: Faktor Psikososial & Kontekstual
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-sm-6 col-12 mb-3">
                                        <div class="p-2.5 rounded border bg-light h-100">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Dukungan Keluarga</small>
                                            <strong class="text-primary font-w700" style="font-size: 13px;">{{ $assessment->psikososial_dukungan_keluarga ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12 mb-3">
                                        <div class="p-2.5 rounded border bg-light h-100">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Kondisi Finansial</small>
                                            <strong class="text-dark font-w700" style="font-size: 13px;">{{ $assessment->psikososial_kondisi_finansial ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12 mb-3">
                                        <div class="p-2.5 rounded border bg-light h-100">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Motivasi / Kepatuhan</small>
                                            <strong class="text-success font-w700" style="font-size: 13px;">{{ $assessment->psikososial_motivasi ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12 mb-3">
                                        <div class="p-2.5 rounded border bg-light h-100">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Interaksi Sosial</small>
                                            <strong class="text-info font-w700" style="font-size: 13px;">{{ $assessment->psikososial_interaksi_sosial ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="p-2.5 rounded border bg-white">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Hambatan Lingkungan Fisik</small>
                                            <div class="font-w600 text-dark" style="font-size: 12.5px;">{{ $assessment->psikososial_hambatan_lingkungan ?: '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-2.5 rounded border bg-white">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Harapan Penerima Manfaat / Keluarga</small>
                                            <div class="font-w600 text-dark" style="font-size: 12.5px;">{{ $assessment->psikososial_harapan_pasien ?: '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if($assessment->psikososial_catatan)
                                    <div class="p-3 mt-3 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12.5px;">
                                        <span class="text-muted d-block font-w600 mb-1">Catatan Observasi Psikososial:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->psikososial_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
                <div class="row">
                    <!-- Subtest 2.1: Kemampuan Motorik Dasar -->
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-child text-primary mr-1.5"></i> Subtest 2.1: Motorik Dasar
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0" style="font-size: 12.5px;">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Mengangkat Kepala</td>
                                            <td style="width: 2%;">:</td>
                                            <td>
                                                @if($assessment->motorik_mengangkat_kepala)
                                                    <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->motorik_mengangkat_kepala }}</span>
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
                                                    <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->motorik_posisi_tengkurap }}</span>
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
                                                    <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->motorik_posisi_duduk }}</span>
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
                                                    <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->motorik_merangkak }}</span>
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
                                                    <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->motorik_berlutut }}</span>
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
                                                    <span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->motorik_berjalan }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($assessment->motorik_catatan)
                                    <div class="p-2.5" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12px;">
                                        <span class="text-muted d-block font-w600 mb-0.5">Catatan Motorik:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->motorik_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Subtest 2.2: Kemampuan Aktivitas Sehari-hari (ADL) -->
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-list-check text-primary mr-1.5"></i> Subtest 2.2: Kemampuan ADL
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0" style="font-size: 12.5px;">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Kontak Mata</td>
                                            <td style="width: 2%;">:</td>
                                            <td><span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->adl_kontak_mata ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Duduk Tenang</td>
                                            <td>:</td>
                                            <td><span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->adl_duduk_tenang ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Gerakan Berulang</td>
                                            <td>:</td>
                                            <td><span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->adl_gerakan_berulang ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Respon Nama</td>
                                            <td>:</td>
                                            <td><span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->adl_respon_nama ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Makan & Minum</td>
                                            <td>:</td>
                                            <td><span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->adl_makan ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Mandi</td>
                                            <td>:</td>
                                            <td><span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->adl_mandi ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Berpakaian</td>
                                            <td>:</td>
                                            <td><span class="badge badge-primary font-w600" style="font-size: 11px; padding: 3px 6px;">{{ $assessment->adl_berpakaian ?: '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">BAK / BAB</td>
                                            <td>:</td>
                                            <td>{{ $assessment->adl_bak ?: '-' }} / {{ $assessment->adl_bab ?: '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($assessment->adl_catatan)
                                    <div class="p-2.5" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12px;">
                                        <span class="text-muted d-block font-w600 mb-0.5">Catatan ADL:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->adl_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Subtest 2.3: Kemampuan Wicara & Komunikasi -->
                    <div class="col-lg-4 col-md-12 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-comments text-primary mr-1.5"></i> Subtest 2.3: Wicara & Komunikasi
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0" style="font-size: 12.5px;">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Kemampuan Bicara</td>
                                            <td style="width: 2%;">:</td>
                                            <td><strong class="text-primary">{{ $assessment->wicara_komunikasi ?: '-' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Organ Bicara</td>
                                            <td>:</td>
                                            <td>
                                                <strong class="text-primary">{{ $assessment->wicara_organ ?: '-' }}</strong>
                                                @if($assessment->wicara_organ_keterangan)
                                                    <br><small class="text-muted">({{ $assessment->wicara_organ_keterangan }})</small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Makan, Mengunyah & Menelan</td>
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
                                    <div class="p-2.5" style="background: #f8fafc; border-top: 1px dashed #e2e8f0; font-size: 12px;">
                                        <span class="text-muted d-block font-w600 mb-0.5">Catatan Wicara:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->wicara_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
                <div class="row">
                    <!-- Subtest 4.1: Pemeriksaan Neurologis -->
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-brain text-primary mr-1.5"></i> Subtest 4.1: Pemeriksaan Neurologis
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <table class="table table-borderless table-sm mb-3" style="font-size: 12.5px;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 35%; font-weight: 600; color: #475569;">Sensasi</td>
                                            <td style="width: 3%;">:</td>
                                            <td>
                                                <span class="badge badge-primary light font-w600" style="font-size: 11.5px;">
                                                    {{ $assessment->neuro_sensasi ?: '-' }}
                                                </span>
                                                @if($assessment->neuro_sensasi_area)
                                                    <div class="text-muted mt-0.5" style="font-size: 11px;">
                                                        <em>Area: {{ $assessment->neuro_sensasi_area }}</em>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Tonus Otot</td>
                                            <td>:</td>
                                            <td>
                                                <span class="badge badge-info light font-w600" style="font-size: 11.5px;">
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
                                                            <span class="badge badge-light border font-w600" style="font-size: 11px;">
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

                                <span class="text-muted d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">
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

                                @if($assessment->neuro_catatan)
                                    <div class="p-2.5 mt-2 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12px;">
                                        <span class="text-muted d-block font-w600">Catatan Neurologis:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->neuro_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Subtest 4.2: Pemeriksaan Postur & Keseimbangan -->
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-person text-primary mr-1.5"></i> Subtest 4.2: Postur & Keseimbangan
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive border rounded mb-3">
                                    <table class="table table-bordered table-sm mb-0" style="font-size: 12px; background: #ffffff;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Instrumen Keseimbangan</th>
                                                <th style="width: 40%;">Skor / Hasil</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="font-w600">Berg Balance Scale (BBS)</td>
                                                <td><strong>{{ $assessment->keseimbangan_bbs_skor !== null ? $assessment->keseimbangan_bbs_skor . ' / 56' : '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="font-w600">Timed Up & Go (TUG)</td>
                                                <td><strong>{{ $assessment->keseimbangan_tug_detik !== null ? $assessment->keseimbangan_tug_detik . ' Detik' : '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="font-w600">Functional Reach Test (FRT)</td>
                                                <td><strong>{{ $assessment->keseimbangan_frt_cm !== null ? $assessment->keseimbangan_frt_cm . ' cm' : '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="font-w600">Romberg & Tandem Stance</td>
                                                <td>{{ $assessment->keseimbangan_romberg ?: '-' }} / {{ $assessment->keseimbangan_tandem ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-w600">Single Leg Stance (D / S)</td>
                                                <td>{{ $assessment->keseimbangan_single_leg_kanan ? $assessment->keseimbangan_single_leg_kanan . 's' : '-' }} / {{ $assessment->keseimbangan_single_leg_kiri ? $assessment->keseimbangan_single_leg_kiri . 's' : '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <small class="text-muted font-w600 d-block mb-1" style="font-size: 11px;">Temuan Postur:</small>
                                @if(is_array($assessment->postur_temuan) && count($assessment->postur_temuan) > 0)
                                    <div class="d-flex flex-wrap" style="gap: 4px;">
                                        @foreach($assessment->postur_temuan as $pt)
                                            <span class="badge badge-light border font-w600 text-dark" style="font-size: 11px;">{{ $pt }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size: 12px;">-</span>
                                @endif

                                @if($assessment->keseimbangan_catatan)
                                    <div class="p-2.5 mt-2 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12px;">
                                        <span class="text-muted d-block font-w600">Catatan Keseimbangan:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->keseimbangan_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Subtest 4.3: Pemeriksaan Gait -->
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-person-walking text-primary mr-1.5"></i> Subtest 4.3: Gaya Berjalan (Gait)
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <table class="table table-borderless table-sm mb-0" style="font-size: 12.5px;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 38%; font-weight: 600; color: #475569;">Fase Gait</td>
                                            <td style="width: 2%;">:</td>
                                            <td><strong class="text-primary">{{ $assessment->gait_fase ?: '-' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Pola Deviasi Gait</td>
                                            <td>:</td>
                                            <td>
                                                @if(is_array($assessment->gait_deviasi) && count($assessment->gait_deviasi) > 0)
                                                    <div class="d-flex flex-wrap" style="gap: 4px;">
                                                        @foreach($assessment->gait_deviasi as $gd)
                                                            <span class="badge badge-light border font-w600 text-dark" style="font-size: 11px;">{{ $gd }}</span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Penggunaan Alat Bantu</td>
                                            <td>:</td>
                                            <td><strong class="text-dark">{{ $assessment->gait_alat_bantu ?: '-' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600; color: #475569;">Jarak Uji 6MWT</td>
                                            <td>:</td>
                                            <td><strong class="text-success">{{ $assessment->gait_jarak_mwt ? $assessment->gait_jarak_mwt . ' Meter' : '-' }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($assessment->gait_catatan)
                                    <div class="p-2.5 mt-2 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12px;">
                                        <span class="text-muted d-block font-w600">Catatan Gait:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->gait_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Subtest 4.4: Sensoris & Vestibular -->
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card h-100 border shadow-none" style="border-radius: 10px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: #eff6ff; border-left: 4px solid #2563eb; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 1px solid #dbeafe;">
                                <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                                    <i class="fa-solid fa-fingerprint text-primary mr-1.5"></i> Subtest 4.4: Sensoris, Propriosepsi & Vestibular
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row" style="font-size: 12px;">
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded bg-light border">
                                            <small class="text-muted d-block font-w600">Taktil / Raba Halus</small>
                                            <strong class="text-primary">{{ $assessment->sensoris_taktil ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded bg-light border">
                                            <small class="text-muted d-block font-w600">Nyeri / Diskriminasi</small>
                                            <strong class="text-primary">{{ $assessment->sensoris_prosedur ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded bg-light border">
                                            <small class="text-muted d-block font-w600">Propriosepsi Sendi</small>
                                            <strong class="text-primary">{{ $assessment->sensoris_propriosepsi ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded bg-light border">
                                            <small class="text-muted d-block font-w600">Kinestetik Gerak</small>
                                            <strong class="text-primary">{{ $assessment->sensoris_kinestetik ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 rounded bg-light border">
                                            <small class="text-muted d-block font-w600">Head Thrust Test</small>
                                            <strong class="text-dark">{{ $assessment->sensoris_vestibular_head_thrust ?: '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 rounded bg-light border">
                                            <small class="text-muted d-block font-w600">Dix-Hallpike Maneuver</small>
                                            <strong class="text-dark">{{ $assessment->sensoris_vestibular_dix_hallpike ?: '-' }}</strong>
                                        </div>
                                    </div>
                                </div>
                                @if($assessment->sensoris_catatan)
                                    <div class="p-2.5 mt-2 rounded" style="background: #f8fafc; border: 1px dashed #e2e8f0; font-size: 12px;">
                                        <span class="text-muted d-block font-w600">Catatan Sensoris:</span>
                                        <p class="mb-0 text-dark">{{ $assessment->sensoris_catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-list-check text-primary mr-1.5"></i> Subtest 5.1: Gross Motor Function Measure (GMFM-88)
                        </h6>
                        @php
                            $has_gmfm = !is_null($assessment->gmfm_dimensi_a_total) || !is_null($assessment->gmfm_dimensi_b_total) || !is_null($assessment->gmfm_dimensi_c_total) || !is_null($assessment->gmfm_dimensi_d_total) || !is_null($assessment->gmfm_dimensi_e_total);
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
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 border-bottom" style="border-color: #e2e8f0; gap: 8px;">
                                <ul class="nav nav-tabs border-bottom-0 gmfm-dim-tabs" id="gmfmShowDimTabs" style="gap: 4px; margin-bottom: -1px;">
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-a" class="nav-link gmfm-dim-btn active" data-target-dim="#gmfm-show-pane-a">
                                            <i class="fa fa-bed mr-1 text-primary"></i> A: Berbaring & Berguling <span class="badge-counter">17</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-b" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-b">
                                            <i class="fa fa-street-view mr-1 text-muted"></i> B: Duduk <span class="badge-counter">20</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-c" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-c">
                                            <i class="fa fa-child mr-1 text-muted"></i> C: Merangkak & Berlutut <span class="badge-counter">14</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-d" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-d">
                                            <i class="fa fa-male mr-1 text-muted"></i> D: Berdiri <span class="badge-counter">13</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#gmfm-show-pane-e" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-show-pane-e">
                                            <i class="fa fa-running mr-1 text-muted"></i> E: Jalan, Lari & Lompat <span class="badge-counter">24</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="d-flex align-items-center p-1.5 px-3 mb-2 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; gap: 8px;">
                                    <span class="font-w700 text-dark" style="font-size: 11.5px;"><i class="fa-solid fa-calculator text-primary mr-1"></i> TOTAL GMFM-88:</span>
                                    <span class="badge badge-dark font-w700" style="font-size: 12px; padding: 4px 8px; border-radius: 6px;">{{ $assessment->gmfm_total_score ?? 0 }} / 264</span>
                                    <span class="badge badge-success font-w700" style="font-size: 12px; padding: 4px 8px; border-radius: 6px;">{{ number_format($assessment->gmfm_total_persen ?? 0, 1) }}%</span>
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
                        <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 13.5px;">
                            <i class="fa-solid fa-graduation-cap text-primary mr-1.5"></i> Subtest 5.2: Skala Perkembangan Denver II (DDST II)
                        </h6>
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
                                                <span class="badge px-3 py-2 font-w700" style="background: #10b981; color: white; font-size: 12px; border-radius: 6px;">
                                                    Pass (P): <strong>{{ $assessment->denver_pass_count ?? 0 }}</strong>
                                                </span>
                                                <span class="badge px-3 py-2 font-w700" style="background: #ef4444; color: white; font-size: 12px; border-radius: 6px;">
                                                    Fail (F): <strong>{{ $assessment->denver_fail_count ?? 0 }}</strong>
                                                </span>
                                                <span class="badge px-3 py-2 font-w700" style="background: #f59e0b; color: white; font-size: 12px; border-radius: 6px;">
                                                    Refusal (R): <strong>{{ $assessment->denver_refusal_count ?? 0 }}</strong>
                                                </span>
                                                <span class="badge px-3 py-2 font-w700" style="background: #64748b; color: white; font-size: 12px; border-radius: 6px;">
                                                    No Opp (NO): <strong>{{ $assessment->denver_no_count ?? 0 }}</strong>
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
                                                                <td style="width: 60%;">
                                                                    <strong class="text-dark">{{ $task['name'] }}</strong>
                                                                    <small class="text-muted d-block">Rentang: {{ $task['age'] }}</small>
                                                                    @if($tNote)
                                                                        <small class="text-info font-italic d-block">Catatan: {{ $tNote }}</small>
                                                                    @endif
                                                                </td>
                                                                <td class="text-right" style="width: 40%; vertical-align: middle;">
                                                                    @if($tScore === 'P') <span class="badge badge-success font-w700">Pass (P)</span>
                                                                    @elseif($tScore === 'F') <span class="badge badge-danger font-w700">Fail (F)</span>
                                                                    @elseif($tScore === 'R') <span class="badge badge-warning font-w700">Refusal (R)</span>
                                                                    @elseif($tScore === 'NO') <span class="badge badge-light border font-w700">No Opp (NO)</span>
                                                                    @else <span class="text-muted">-</span>
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
/* 6 Underline Tabs Navigation Sesuai DESIGN.md */
.ot-underline-tabs {
    border-bottom: 2px solid #e2e8f0 !important;
    display: flex;
    gap: 4px;
}
.ot-underline-tabs .nav-link {
    position: relative;
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    border: none !important;
    border-bottom: 2.5px solid transparent !important;
    background: transparent !important;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 8px 8px 0 0;
    text-decoration: none !important;
    margin-bottom: -2px;
}
.ot-underline-tabs .nav-link:hover {
    color: #2563eb !important;
    background: #f8fafc !important;
}
.ot-underline-tabs .nav-link.active {
    color: #1e40af !important;
    background: #eff6ff !important;
    border-bottom: 2.5px solid #2563eb !important;
    font-weight: 700 !important;
}
.ot-underline-tabs .tab-module-num {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    transition: all 0.2s ease;
}
.ot-underline-tabs .nav-link.active .tab-module-num {
    background: #2563eb;
    color: #ffffff;
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
.gmfm-dim-tabs .gmfm-dim-btn .badge-counter {
    font-size: 10.5px;
    padding: 2px 7px;
    border-radius: 999px;
    background: #e2e8f0;
    color: #475569;
    margin-left: 6px;
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
        $(this).addClass('active');
        $('.gmfm-show-pane').hide();
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
@extends('layout.apps')
@section('content')

<!-- Page Header Banner (Unified Card Sesuai DESIGN.md) -->
<div class="card mb-3 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0; border: 1px solid #bfdbfe; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <h3 class="font-w700 mb-0" style="color: #1e40af; font-size: 20px;">Form Assessment Terapis</h3>
                        <span class="badge font-w700" style="font-size: 12px; padding: 4px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                            <i class="fa-solid fa-id-card mr-1"></i> {{ $pasien->no_rm }}
                        </span>
                    </div>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px; margin-top: 4px;">
                        <li class="breadcrumb-item"><a href="{{Route('dashboard')}}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{Route('rekam')}}" style="color: #2563eb;">Rekam Medis</a></li>
                        <li class="breadcrumb-item"><a href="{{Route('rekam.detail', $pasien->id)}}" style="color: #2563eb;">{{ $pasien->nama }}</a></li>
                        <li class="breadcrumb-item active text-muted">Form Assessment</li>
                    </ol>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                @if(isset($riwayatAssessment) && count($riwayatAssessment) > 0)
                    <button type="button" class="btn btn-sm font-w600" data-toggle="modal" data-target="#modalRiwayatAssessment" style="padding: 8px 14px; font-size: 12.5px; border-radius: 8px; border: 1.5px solid #2563eb; background: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Riwayat Asesmen ({{ count($riwayatAssessment) }})
                    </button>
                @endif
                <a href="{{Route('rekam.detail', $pasien->id)}}" class="btn btn-sm btn-light font-w600" style="padding: 8px 16px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Rekam Medis
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Riwayat Assessment Pasien Sebelumnya -->
@if(isset($riwayatAssessment) && count($riwayatAssessment) > 0)
<div class="modal fade" id="modalRiwayatAssessment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid #edf2f7; background: #eff6ff;">
                <div class="d-flex align-items-center">
                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 10px; background: #ffffff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 16px;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" style="color: #1e40af; font-size: 16px;">
                            Riwayat Lembar Asesmen Pasien
                        </h5>
                        <small class="text-muted font-w500">Daftar re-evaluasi & baseline klinis {{ $pasien->nama }}</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="font-size: 12.5px; border-collapse: collapse;">
                        <thead class="bg-light">
                            <tr style="color: #1e293b;">
                                <th style="width: 5%; text-align: center;">#</th>
                                <th>Tanggal Asesmen</th>
                                <th>Terapis / Penguji</th>
                                <th>Jenis Asesmen</th>
                                <th>Evaluasi / Catatan</th>
                                <th style="width: 15%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatAssessment as $k => $hist)
                                <tr>
                                    <td class="text-center font-w600" style="vertical-align: middle;">{{ $k + 1 }}</td>
                                    <td style="vertical-align: middle;">
                                        <strong class="text-primary">{{ $hist->tgl_assessment ? $hist->tgl_assessment->format('d/m/Y') : '-' }}</strong>
                                        <br><small class="text-muted">REG# {{ $hist->rekam ? $hist->rekam->no_rekam : '-' }}</small>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b;">{{ $hist->dokter->nama ?? 'Terapis' }}</strong>
                                        <br><small class="text-muted">{{ $hist->rekam->poli ?? 'Omah Terapiku' }}</small>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge badge-info light font-w600" style="font-size: 11px;">{{ $hist->jenis_assessment ?: 'General' }}</span>
                                    </td>
                                    <td style="vertical-align: middle; max-width: 250px;" class="text-truncate" title="{{ $hist->kesimpulan }}">
                                        {{ $hist->kesimpulan ?: '-' }}
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <a href="{{Route('rekam.assessment.show', $hist->rekam_id)}}" target="_blank" class="btn btn-xs btn-primary font-w600 shadow-sm" style="border-radius: 6px; font-size: 11px; padding: 5px 10px; background: #2563eb;">
                                            Lihat Detail <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Identitas Penerima Manfaat Context Card -->
<div class="card mb-3 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
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
                    <!-- Metadata Info Pasien dengan Jarak Renggang & Rapi Sesuai Permintaan -->
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
                        <small class="text-muted d-block font-w600" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.3px;">Layanan & Tanggal Sesi</small>
                        <strong class="text-primary font-w700" style="font-size: 13px;">{{ $rekam->layanan_terapi ?: $rekam->poli }}</strong>
                        <small class="text-muted d-block font-w500">{{ $rekam->tgl_rekam }}</small>
                    </div>
                    <div class="pl-3" style="border-left: 2px solid #e2e8f0;">
                        <small class="text-muted d-block font-w600" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.3px;">Terapis Pemeriksa</small>
                        <strong style="color: #1e293b; font-size: 13px; font-weight: 700;">{{ $rekam->dokter->nama ?? auth()->user()->name }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{Route('rekam.assessment.store', $rekam->id)}}" method="POST" id="formAssessment">
    {{ csrf_field() }}
    <input type="hidden" name="tgl_assessment" value="{{ $assessment->tgl_assessment ? $assessment->tgl_assessment->format('Y-m-d') : ($rekam->tgl_rekam ?: date('Y-m-d')) }}">
    <input type="hidden" name="jenis_assessment" value="{{ $assessment->jenis_assessment ?: 'General' }}">
    <input type="hidden" name="nyeri_body_chart" id="input_nyeri_body_chart" value="{{ old('nyeri_body_chart', $assessment->nyeri_body_chart) }}">

    <!-- Main Card Container with 6 Module Underline Tabs Navigation -->
    <div class="card mb-4" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">

        <!-- Progress Bar & Draft Auto-Save Status Bar -->
        <div class="p-3 bg-white border-bottom" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <!-- Draft Restore Banner -->
            <div id="draftRestoreBanner" class="alert alert-warning py-2 px-3 mb-2 d-none align-items-center justify-content-between flex-wrap" style="border-radius: 8px; font-size: 12.5px; gap: 8px; border: 1px solid #fde68a; background: #fffbeb;">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-history text-warning mr-2" style="font-size: 16px;"></i>
                    <span>Ditemukan <strong>Draft Asesmen Tersimpan Lokal</strong> yang belum disimpan ke server.</span>
                </div>
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <button type="button" class="btn btn-xs btn-warning font-w700" id="btnRestoreDraft" style="padding: 4px 10px; border-radius: 6px;">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Pulihkan Draft
                    </button>
                    <button type="button" class="btn btn-xs btn-light font-w600" id="btnDiscardDraft" style="padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                        Hapus Draft
                    </button>
                </div>
            </div>

            <!-- Progress Meter & Status Header -->
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2" style="gap: 8px;">
                <div class="d-flex align-items-center">
                    <span class="font-w700 text-dark mr-2" style="font-size: 13px;">
                        <i class="fa-solid fa-list-check text-primary mr-1"></i> Progress Pengisian Asesmen:
                    </span>
                    <strong class="text-primary font-w700" id="progressPercentText" style="font-size: 13.5px;">0%</strong>
                    <small class="text-muted ml-1 font-w600" id="progressModulesText">(0/6 Modul Terisi)</small>
                </div>
                <div class="d-flex align-items-center" style="gap: 8px;">
                    <span id="draftStatusBadge" class="badge badge-light border text-muted font-w600" style="font-size: 11px; padding: 5px 10px; border-radius: 6px; background: #f8fafc;">
                        <i class="fa-solid fa-circle-check text-success mr-1"></i> Auto-Save Aktif
                    </span>
                </div>
            </div>
            
            <!-- Progress Bar Line -->
            <div class="progress" style="height: 7px; border-radius: 4px; background: #e2e8f0;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="formOverallProgressBar" role="progressbar" style="width: 0%; background: linear-gradient(90deg, #2563eb 0%, #38bdf8 100%);" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Tabs Navigation 6 Modul (Grid 3x2, Tanpa Perlu Geser) -->
        <div class="card-header p-3 bg-white" style="border-bottom: 2px solid #e2e8f0;">
            <ul class="nav assessment-modul-grid-tabs" id="modulTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-modul1-btn" data-toggle="tab" href="#modul-1" role="tab" data-module-index="1">
                        <div class="d-flex align-items-center justify-content-between w-100" style="gap: 8px;">
                            <span class="d-inline-flex align-items-center text-truncate font-w700" style="font-size: 13px;">
                                <i class="fa-solid fa-eye-low-vision mr-2 tab-mod-icon"></i>
                                <span class="tab-mod-title text-truncate">Modul 1: Penglihatan & Psikososial</span>
                            </span>
                            <span class="badge ml-1 counter-pill" id="badge-modul-1">0/2</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-modul2-btn" data-toggle="tab" href="#modul-2" role="tab" data-module-index="2">
                        <div class="d-flex align-items-center justify-content-between w-100" style="gap: 8px;">
                            <span class="d-inline-flex align-items-center text-truncate font-w700" style="font-size: 13px;">
                                <i class="fa-solid fa-child-reaching mr-2 tab-mod-icon"></i>
                                <span class="tab-mod-title text-truncate">Modul 2: Motorik Dasar & ADL</span>
                            </span>
                            <span class="badge ml-1 counter-pill" id="badge-modul-2">0/3</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-modul3-btn" data-toggle="tab" href="#modul-3" role="tab" data-module-index="3">
                        <div class="d-flex align-items-center justify-content-between w-100" style="gap: 8px;">
                            <span class="d-inline-flex align-items-center text-truncate font-w700" style="font-size: 13px;">
                                <i class="fa-solid fa-heart-pulse mr-2 tab-mod-icon"></i>
                                <span class="tab-mod-title text-truncate">Modul 3: Evaluasi Fisik & Nyeri</span>
                            </span>
                            <span class="badge ml-1 counter-pill" id="badge-modul-3">0/2</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-modul4-btn" data-toggle="tab" href="#modul-4" role="tab" data-module-index="4">
                        <div class="d-flex align-items-center justify-content-between w-100" style="gap: 8px;">
                            <span class="d-inline-flex align-items-center text-truncate font-w700" style="font-size: 13px;">
                                <i class="fa-solid fa-brain mr-2 tab-mod-icon"></i>
                                <span class="tab-mod-title text-truncate">Modul 4: Neurologis & Gait</span>
                            </span>
                            <span class="badge ml-1 counter-pill" id="badge-modul-4">0/4</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-modul5-btn" data-toggle="tab" href="#modul-5" role="tab" data-module-index="5">
                        <div class="d-flex align-items-center justify-content-between w-100" style="gap: 8px;">
                            <span class="d-inline-flex align-items-center text-truncate font-w700" style="font-size: 13px;">
                                <i class="fa-solid fa-clipboard-list mr-2 tab-mod-icon"></i>
                                <span class="tab-mod-title text-truncate">Modul 5: Instrumen Khusus</span>
                            </span>
                            <span class="badge ml-1 counter-pill" id="badge-modul-5">0/2</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-modul6-btn" data-toggle="tab" href="#modul-6" role="tab" data-module-index="6">
                        <div class="d-flex align-items-center justify-content-between w-100" style="gap: 8px;">
                            <span class="d-inline-flex align-items-center text-truncate font-w700" style="font-size: 13px;">
                                <i class="fa-solid fa-notes-medical mr-2 tab-mod-icon"></i>
                                <span class="tab-mod-title text-truncate">Modul 6: Rencana Terapi & TTD</span>
                            </span>
                            <span class="badge ml-1 counter-pill" id="badge-modul-6">0/2</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="tab-content" id="modulTabContent">

            <!-- ======================================================== -->
            <!-- MODUL 1: STATUS PENGLIHATAN & PSIKOSOSIAL -->
            <!-- ======================================================== -->
            <div class="tab-pane fade show active" id="modul-1" role="tabpanel" aria-labelledby="tab-modul1-btn">

                <!-- Subtest: Subtest 1.1 - Status Penglihatan -->
                <div class="assessment-subtest-card mb-4" id="subtest-penglihatan">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 1.1</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-eye mr-1 text-primary"></i> Status Penglihatan
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Pemeriksaan fungsi visual, fiksasi & respon rangsang cahaya</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <div class="row">
                        <!-- Klasifikasi -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Klasifikasi Penglihatan
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $vis_klas = old('penglihatan_klasifikasi', $assessment->penglihatan_klasifikasi); @endphp
                                    @foreach(['Low Vision', 'Buta Total'] as $opt)
                                        <label class="radio-pill-card {{ $vis_klas == $opt ? 'active' : '' }}">
                                            <input type="radio" name="penglihatan_klasifikasi" value="{{ $opt }}" {{ $vis_klas == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Onset -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Onset Terjadinya
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $vis_onset = old('penglihatan_onset', $assessment->penglihatan_onset); @endphp
                                    @foreach(['Kongenital (sejak lahir)', 'Acquired (didapat)'] as $opt)
                                        <label class="radio-pill-card {{ $vis_onset == $opt ? 'active' : '' }}">
                                            <input type="radio" name="penglihatan_onset" value="{{ $opt }}" {{ $vis_onset == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sisi -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Sisi Mata yang Terkena
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $vis_sisi = old('penglihatan_sisi', $assessment->penglihatan_sisi); @endphp
                                    @foreach(['Bilateral', 'Unilateral'] as $opt)
                                        <label class="radio-pill-card {{ $vis_sisi == $opt ? 'active' : '' }}">
                                            <input type="radio" name="penglihatan_sisi" value="{{ $opt }}" {{ $vis_sisi == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Progresif? -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Progresif?
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $vis_prog = old('penglihatan_progresif', $assessment->penglihatan_progresif); @endphp
                                    @foreach(['Ya', 'Tidak'] as $opt)
                                        <label class="radio-pill-card {{ $vis_prog == $opt ? 'active' : '' }}">
                                            <input type="radio" name="penglihatan_progresif" value="{{ $opt }}" {{ $vis_prog == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Usia Onset & Durasi -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                                            Usia Onset
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="penglihatan_usia_onset" class="form-control" value="{{ old('penglihatan_usia_onset', $assessment->penglihatan_usia_onset) }}" placeholder="Contoh: 3">
                                            <div class="input-group-append">
                                                <span class="input-group-text font-w600" style="font-size: 11px;">Tahun</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                                            Durasi
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="penglihatan_durasi" class="form-control" value="{{ old('penglihatan_durasi', $assessment->penglihatan_durasi) }}" placeholder="Contoh: 5">
                                            <div class="input-group-append">
                                                <span class="input-group-text font-w600" style="font-size: 11px;">Tahun</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Etiologi / Diagnosis Medis -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                                    Etiologi / Diagnosis Medis
                                </label>
                                <input type="text" name="penglihatan_etiologi" class="form-control form-control-sm" value="{{ old('penglihatan_etiologi', $assessment->penglihatan_etiologi) }}" placeholder="Contoh: Glaukoma Kongenital, Retinopati Prematuritas, Katarak..." style="height: 36px; font-size: 12.5px;">
                            </div>
                        </div>

                        <!-- Terakhir Diperiksakan -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                                    Terakhir Diperiksakan
                                </label>
                                <input type="text" name="penglihatan_terakhir_periksa" class="form-control form-control-sm" value="{{ old('penglihatan_terakhir_periksa', $assessment->penglihatan_terakhir_periksa) }}" placeholder="Contoh: Januari 2026 di Poli Mata RS..." style="height: 36px; font-size: 12.5px;">
                            </div>
                        </div>

                        <!-- Persepsi Cahaya & Preferensi Sisi Visual -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    Persepsi Cahaya
                                </label>
                                <div class="d-flex flex-wrap option-group mb-2" style="gap: 8px;">
                                    @php $vis_cahaya = old('penglihatan_persepsi_cahaya', $assessment->penglihatan_persepsi_cahaya); @endphp
                                    @foreach(['Ada', 'Tidak ada'] as $opt)
                                        <label class="radio-pill-card {{ $vis_cahaya == $opt ? 'active' : '' }}">
                                            <input type="radio" name="penglihatan_persepsi_cahaya" value="{{ $opt }}" {{ $vis_cahaya == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <label class="font-w700 text-dark mb-1 mt-2 d-block" style="font-size: 12.5px;">
                                    Preferensi Sisi Visual
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $vis_pref = old('penglihatan_preferensi_sisi', $assessment->penglihatan_preferensi_sisi); @endphp
                                    @foreach(['Kanan', 'Kiri', 'Tidak ada'] as $opt)
                                        <label class="radio-pill-card {{ $vis_pref == $opt ? 'active' : '' }}">
                                            <input type="radio" name="penglihatan_preferensi_sisi" value="{{ $opt }}" {{ $vis_pref == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Visus OD & Visus OS (Jika Low Vision) -->
                        <div class="col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    Pemeriksaan Visus Tajam Penglihatan <small class="text-muted font-w400">(Khususnya Low Vision)</small>
                                </label>
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                                        <label class="font-w600 text-dark mb-1" style="font-size: 12px;">Visus OD (Mata Kanan)</label>
                                        <input type="text" name="penglihatan_visus_od" class="form-control form-control-sm" value="{{ old('penglihatan_visus_od', $assessment->penglihatan_visus_od) }}" placeholder="Contoh: 6/60, 1/300, Hand Movement..." style="height: 36px; font-size: 12.5px;">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="font-w600 text-dark mb-1" style="font-size: 12px;">Visus OS (Mata Kiri)</label>
                                        <input type="text" name="penglihatan_visus_os" class="form-control form-control-sm" value="{{ old('penglihatan_visus_os', $assessment->penglihatan_visus_os) }}" placeholder="Contoh: 6/60, 1/300, No Light Perception..." style="height: 36px; font-size: 12.5px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alat Bantu yang Digunakan -->
                        <div class="col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-cube text-primary mr-1"></i> Alat Bantu yang Digunakan (Bisa pilih lebih dari satu):
                                </label>

                                @php
                                    $saved_alat = is_array($assessment->penglihatan_alat_bantu) ? $assessment->penglihatan_alat_bantu : [];
                                @endphp

                                <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @php
                                        $alatOpts = [
                                            'Tongkat putih',
                                            'Kacamata / Low Vision Aid',
                                            'Tidak menggunakan alat bantu',
                                            'Guide dog / Pendamping manusia',
                                            'Screen reader / Teknologi assistive',
                                        ];
                                    @endphp
                                    @foreach($alatOpts as $aOpt)
                                        <label class="check-pill-card {{ in_array($aOpt, $saved_alat) ? 'active' : '' }}">
                                            <input type="checkbox" name="penglihatan_alat_bantu[]" value="{{ $aOpt }}" {{ in_array($aOpt, $saved_alat) ? 'checked' : '' }} @if($aOpt == 'Tongkat putih') id="alat_tongkat" onchange="toggleTongkatTeknik(this.checked)" @endif>
                                            <span>{{ $aOpt }}</span>
                                        </label>
                                    @endforeach
                                    <label class="check-pill-card {{ in_array('Lainnya', $saved_alat) ? 'active' : '' }}">
                                        <input type="checkbox" name="penglihatan_alat_bantu[]" value="Lainnya" id="alat_lainnya" {{ in_array('Lainnya', $saved_alat) ? 'checked' : '' }} onchange="toggleAlatLainnya(this.checked)">
                                        <span>Lainnya</span>
                                    </label>
                                </div>

                                <!-- Wrap Teknik Tongkat Putih (Jika Tongkat Putih Dipilih) -->
                                <div id="wrap-teknik-tongkat" class="mt-2 p-2.5 rounded" style="background: #ffffff; border: 1px solid #bfdbfe; max-width: 520px; {{ in_array('Tongkat putih', $saved_alat) ? '' : 'display: none;' }}">
                                    <small class="text-primary d-block mb-1.5 font-w700" style="font-size: 12px;"><i class="fa fa-info-circle mr-1"></i> Teknik Tongkat Putih yang Dikuasai:</small>
                                    <div class="d-flex flex-wrap" style="gap: 6px;">
                                        @php $tek = old('penglihatan_teknik_tongkat', $assessment->penglihatan_teknik_tongkat); @endphp
                                        @foreach(['Sweep', 'Diagonal', 'Tidak tahu'] as $t_opt)
                                            <label class="radio-pill-card py-1 px-2.5 {{ $tek == $t_opt ? 'active' : '' }}" style="font-size: 12px;">
                                                <input type="radio" name="penglihatan_teknik_tongkat" value="{{ $t_opt }}" {{ $tek == $t_opt ? 'checked' : '' }}>
                                                <span>{{ $t_opt }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Wrap Alat Bantu Lainnya (Jika Lainnya Dipilih) -->
                                <div id="wrap-alat-lainnya" class="mt-2" style="max-width: 520px; {{ in_array('Lainnya', $saved_alat) ? '' : 'display: none;' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-w600 text-primary" style="font-size: 12px;">Alat Bantu Lainnya:</span>
                                        </div>
                                        <input type="text" name="penglihatan_alat_bantu_lainnya" class="form-control" value="{{ old('penglihatan_alat_bantu_lainnya', $assessment->penglihatan_alat_bantu_lainnya) }}" placeholder="Sebutkan alat bantu lainnya..." style="height: 38px; font-size: 12.5px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Status Penglihatan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa-solid fa-notes-medical text-primary mr-1"></i> Catatan Tambahan Asesmen Penglihatan (Opsional)
                        </label>
                        <textarea name="penglihatan_catatan" class="form-control" rows="3" placeholder="Tuliskan catatan khusus terkait kondisi lapang pandang, penglihatan, orientasi spasial / mobilitas..." style="font-size: 13px; min-height: 85px;">{{ old('penglihatan_catatan', $assessment->penglihatan_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 1.2 - Faktor Psikososial & Kontekstual -->
                <div class="assessment-subtest-card mb-4" id="subtest-psikososial">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 1.2</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-users mr-1 text-primary"></i> Faktor Psikososial & Kontekstual
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Kondisi keluarga, lingkungan tempat tinggal & kesiapan stimulasi</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <div class="row">
                        <!-- 1. Pekerjaan / Hobi Terdampak -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-briefcase text-primary mr-1"></i> Pekerjaan / Aktivitas / Hobi Terdampak
                                </label>
                                <textarea name="psikososial_pekerjaan_hobi" class="form-control" rows="3" placeholder="Sebutkan pekerjaan, sekolah, atau kegiatan/hobi pasien yang terganggu akibat kondisi saat ini..." style="font-size: 12.5px;">{{ old('psikososial_pekerjaan_hobi', $assessment->psikososial_pekerjaan_hobi) }}</textarea>
                            </div>
                        </div>

                        <!-- 2. Dukungan Sosial -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-home text-primary mr-1"></i> Dukungan Sosial & Lingkungan Keluarga
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $duk_sos = old('psikososial_dukungan_sosial', $assessment->psikososial_dukungan_sosial); @endphp
                                    @foreach(['Baik (keluarga mendukung)', 'Cukup', 'Kurang / tinggal sendiri'] as $opt)
                                        <label class="radio-pill-card {{ $duk_sos == $opt ? 'active' : '' }}">
                                            <input type="radio" name="psikososial_dukungan_sosial" value="{{ $opt }}" {{ $duk_sos == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- 3. Faktor Psikologis -->
                        <div class="col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-heart text-primary mr-1"></i> Faktor Psikologis & Respon Emosional
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $fak_psi = old('psikososial_faktor_psikologis', $assessment->psikososial_faktor_psikologis); @endphp
                                    @foreach(['Tidak ada kekhawatiran', 'Cemas / Anxiety', 'Depresi', 'Fear-avoidance behavior', 'Katastrofisasi', 'Stres tinggi'] as $opt)
                                        <label class="radio-pill-card {{ $fak_psi == $opt ? 'active' : '' }}">
                                            <input type="radio" name="psikososial_faktor_psikologis" value="{{ $opt }}" {{ $fak_psi == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- 4. Harapan / Ekspektasi Pasien -->
                        <div class="col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-bullseye text-primary mr-1"></i> Harapan / Ekspektasi Pasien & Keluarga Terhadap Terapi
                                </label>
                                <textarea name="psikososial_harapan_pasien" class="form-control" rows="3" placeholder="Tuliskan target atau ekspektasi yang ingin dicapai penerima manfaat / keluarga (misal: bisa berjalan mandiri, mengurangi nyeri, kembali beraktivitas normal)..." style="font-size: 13px; min-height: 85px;">{{ old('psikososial_harapan_pasien', $assessment->psikososial_harapan_pasien) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Tambahan Psikososial -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa-solid fa-notes-medical text-primary mr-1"></i> Catatan Observasi Psikososial & Kontekstual (Opsional)
                        </label>
                        <textarea name="psikososial_catatan" class="form-control" rows="3" placeholder="Tuliskan catatan tambahan mengenai kondisi lingkungan, kesiapan motivasi pasien, atau hambatan psikososial lainnya..." style="font-size: 13px; min-height: 85px;">{{ old('psikososial_catatan', $assessment->psikososial_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>
                <!-- Modul 1 Navigation Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 module-nav-footer" style="border-top: 1px solid #edf2f7;">
                    <div></div>
                    <button type="button" class="btn btn-primary font-w600 shadow-sm" onclick="goToModule(2)" style="padding: 9px 20px; font-size: 13px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                        Lanjut ke Modul 2: Motorik Dasar & ADL <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 2: MOTORIK DASAR & ADL -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-2" role="tabpanel" aria-labelledby="tab-modul2-btn">

                <!-- Subtest: Subtest 2.1 - Kemampuan Motorik Dasar -->
                <div class="assessment-subtest-card mb-4" id="subtest-motorik">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 2.1</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-child-reaching mr-1 text-primary"></i> Kemampuan Motorik Dasar
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Penilaian kontrol kepala, tengkurap, duduk, merangkak, berlutut & berjalan</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <div class="row">
                        <!-- Mengangkat Kepala -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Mengangkat Kepala
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $val1 = old('motorik_mengangkat_kepala', $assessment->motorik_mengangkat_kepala); @endphp
                                    @foreach(['Mampu', 'Tidak Mampu'] as $opt)
                                        <label class="radio-pill-card {{ $val1 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="motorik_mengangkat_kepala" value="{{ $opt }}" {{ $val1 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Posisi Tengkurap -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Posisi Tengkurap
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $val2 = old('motorik_posisi_tengkurap', $assessment->motorik_posisi_tengkurap); @endphp
                                    @foreach(['Mampu Sendiri', 'Sedikit Dibantu', 'Tidak Mampu'] as $opt)
                                        <label class="radio-pill-card {{ $val2 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="motorik_posisi_tengkurap" value="{{ $opt }}" {{ $val2 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Posisi Duduk -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Posisi Duduk
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $val3 = old('motorik_posisi_duduk', $assessment->motorik_posisi_duduk); @endphp
                                    @foreach(['Mampu Sendiri dan Stabil', 'Mampu Sendiri dan Tidak Stabil', 'Didudukkan', 'Tidak Mampu'] as $opt)
                                        <label class="radio-pill-card {{ $val3 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="motorik_posisi_duduk" value="{{ $opt }}" {{ $val3 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Merangkak -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Merangkak
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $val4 = old('motorik_merangkak', $assessment->motorik_merangkak); @endphp
                                    @foreach(['Mampu', 'Ngesot', 'Tidak Mampu'] as $opt)
                                        <label class="radio-pill-card {{ $val4 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="motorik_merangkak" value="{{ $opt }}" {{ $val4 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Berlutut -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Berlutut
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $val5 = old('motorik_berlutut', $assessment->motorik_berlutut); @endphp
                                    @foreach(['Mampu', 'Tidak Mampu'] as $opt)
                                        <label class="radio-pill-card {{ $val5 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="motorik_berlutut" value="{{ $opt }}" {{ $val5 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Berjalan -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Berjalan
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $val6 = old('motorik_berjalan', $assessment->motorik_berjalan); @endphp
                                    @foreach(['Mampu Mandiri', 'Pakai Alat Bantu', 'Dibantu Orang Lain'] as $opt)
                                        <label class="radio-pill-card {{ $val6 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="motorik_berjalan" value="{{ $opt }}" {{ $val6 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Motorik -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Motorik (Opsional)</label>
                        <textarea name="motorik_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait kemampuan motorik..." style="font-size: 12.5px;">{{ old('motorik_catatan', $assessment->motorik_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 2.2 - Kemampuan Aktivitas Sehari-hari (ADL) -->
                <div class="assessment-subtest-card mb-4" id="subtest-adl">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 2.2</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-person-walking mr-1 text-primary"></i> Kemampuan Aktivitas Sehari-hari (ADL)
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Skoring kemandirian aktivitas fungsional dasar & Indeks Barthel</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <div class="row">
                        <!-- Kontak Mata -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Kontak Mata
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl1 = old('adl_kontak_mata', $assessment->adl_kontak_mata); @endphp
                                    @foreach(['Ada', 'Tidak Ada'] as $opt)
                                        <label class="radio-pill-card {{ $adl1 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_kontak_mata" value="{{ $opt }}" {{ $adl1 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Bisa Duduk Tenang -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Bisa Duduk Tenang Saat Beraktivitas
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl2 = old('adl_duduk_tenang', $assessment->adl_duduk_tenang); @endphp
                                    @foreach(['Bisa', 'Tidak Bisa'] as $opt)
                                        <label class="radio-pill-card {{ $adl2 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_duduk_tenang" value="{{ $opt }}" {{ $adl2 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Gerakan Berulang dan Tidak Bertujuan -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Gerakan Berulang & Tanpa Tujuan
                                    <small class="text-muted font-w400 d-block">(Tepuk tangan, kibas tangan, dll.)</small>
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl3 = old('adl_gerakan_berulang', $assessment->adl_gerakan_berulang); @endphp
                                    @foreach(['Bisa', 'Tidak Bisa'] as $opt)
                                        <label class="radio-pill-card {{ $adl3 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_gerakan_berulang" value="{{ $opt }}" {{ $adl3 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Merespon Saat Dipanggil Nama -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Merespon Saat Dipanggil Nama
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl4 = old('adl_respon_nama', $assessment->adl_respon_nama); @endphp
                                    @foreach(['Bisa', 'Tidak Bisa'] as $opt)
                                        <label class="radio-pill-card {{ $adl4 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_respon_nama" value="{{ $opt }}" {{ $adl4 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Makan -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Makan
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl5 = old('adl_makan', $assessment->adl_makan); @endphp
                                    @foreach(['Mandiri', 'Dibantu Sebagian', 'Bergantung Kepada Orang Lain'] as $opt)
                                        <label class="radio-pill-card {{ $adl5 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_makan" value="{{ $opt }}" {{ $adl5 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Mandi -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Mandi
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl6 = old('adl_mandi', $assessment->adl_mandi); @endphp
                                    @foreach(['Mandiri', 'Dibantu Sebagian', 'Bergantung Kepada Orang Lain'] as $opt)
                                        <label class="radio-pill-card {{ $adl6 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_mandi" value="{{ $opt }}" {{ $adl6 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Berpakaian -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Berpakaian
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl7 = old('adl_berpakaian', $assessment->adl_berpakaian); @endphp
                                    @foreach(['Mandiri', 'Dibantu Sebagian', 'Bergantung Kepada Orang Lain'] as $opt)
                                        <label class="radio-pill-card {{ $adl7 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_berpakaian" value="{{ $opt }}" {{ $adl7 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- BAK -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> BAK (Buang Air Kecil)
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl8 = old('adl_bak', $assessment->adl_bak); @endphp
                                    @foreach(['Mandiri', 'Dibantu Sebagian', 'Bergantung Kepada Orang Lain'] as $opt)
                                        <label class="radio-pill-card {{ $adl8 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_bak" value="{{ $opt }}" {{ $adl8 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- BAB -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> BAB (Buang Air Besar)
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $adl9 = old('adl_bab', $assessment->adl_bab); @endphp
                                    @foreach(['Mandiri', 'Dibantu Sebagian', 'Bergantung Kepada Orang Lain'] as $opt)
                                        <label class="radio-pill-card {{ $adl9 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="adl_bab" value="{{ $opt }}" {{ $adl9 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan ADL -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Aktivitas Sehari-hari (Opsional)</label>
                        <textarea name="adl_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait kemandirian & aktivitas..." style="font-size: 12.5px;">{{ old('adl_catatan', $assessment->adl_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 2.3 - Kemampuan Wicara & Komunikasi -->
                <div class="assessment-subtest-card mb-4" id="subtest-wicara">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 2.3</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-comments mr-1 text-primary"></i> Kemampuan Wicara & Komunikasi
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Artikulasi, pemahaman bahasa, respon suara & komunikasi verbal/non-verbal</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <div class="row">
                        <!-- Kemampuan Berkomunikasi -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Kemampuan Berkomunikasi
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                    @php $wic1 = old('wicara_komunikasi', $assessment->wicara_komunikasi); @endphp
                                    @foreach(['Verbal (Lisan)', 'Non-Verbal (Gesture)', 'Bergantung Sepenuhnya dengan Orang Lain'] as $opt)
                                        <label class="radio-pill-card {{ $wic1 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="wicara_komunikasi" value="{{ $opt }}" {{ $wic1 == $opt ? 'checked' : '' }}>
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi Organ Bicara dan Pendengaran -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Kondisi Organ Bicara dan Pendengaran
                                </label>
                                <div class="d-flex flex-wrap option-group mb-2" style="gap: 8px;">
                                    @php $wic2 = old('wicara_organ', $assessment->wicara_organ); @endphp
                                    @foreach(['Normal', 'Ada Kelainan'] as $opt)
                                        <label class="radio-pill-card {{ $wic2 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="wicara_organ" value="{{ $opt }}" {{ $wic2 == $opt ? 'checked' : '' }} onchange="toggleOrganKelainan(this.value)">
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrap-organ-kelainan" class="mt-2" style="{{ $wic2 == 'Ada Kelainan' ? '' : 'display: none;' }}">
                                    <input type="text" name="wicara_organ_keterangan" class="form-control form-control-sm" value="{{ old('wicara_organ_keterangan', $assessment->wicara_organ_keterangan) }}" placeholder="Sebutkan kelainan (Gangguan Pendengaran, Bibir Sumbing, Air Liur Berlebih)..." style="font-size: 12.5px; height: 36px;">
                                </div>
                            </div>
                        </div>

                        <!-- Kemampuan Makan, Minum, Mengunyah, dan Menelan -->
                        <div class="col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-check-circle text-primary mr-1"></i> Kemampuan Makan, Minum, Mengunyah, dan Menelan
                                </label>
                                <div class="d-flex flex-wrap option-group mb-2" style="gap: 8px;">
                                    @php $wic3 = old('wicara_makan_menelan', $assessment->wicara_makan_menelan); @endphp
                                    @foreach(['Mampu', 'Mampu dengan Hambatan', 'Tidak Mampu'] as $opt)
                                        <label class="radio-pill-card {{ $wic3 == $opt ? 'active' : '' }}">
                                            <input type="radio" name="wicara_makan_menelan" value="{{ $opt }}" {{ $wic3 == $opt ? 'checked' : '' }} onchange="toggleMenelanKeterangan(this.value)">
                                            <span>
                                                {{ $opt }}
                                                @if($opt == 'Mampu dengan Hambatan')
                                                    <small class="font-w400 text-muted">(Tersedak, Sulit Menelan)</small>
                                                @elseif($opt == 'Tidak Mampu')
                                                    <small class="font-w400 text-muted">(Alat/Sonde)</small>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrap-menelan-keterangan" class="mt-2" style="{{ ($wic3 == 'Mampu dengan Hambatan' || $wic3 == 'Tidak Mampu') ? '' : 'display: none;' }}">
                                    <input type="text" name="wicara_makan_menelan_keterangan" class="form-control form-control-sm" value="{{ old('wicara_makan_menelan_keterangan', $assessment->wicara_makan_menelan_keterangan) }}" placeholder="Keterangan tambahan (Sering tersedak makanan padat, menggunakan NGT/sonde)..." style="font-size: 12.5px; height: 36px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Wicara -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Wicara (Opsional)</label>
                        <textarea name="wicara_catatan" class="form-control" rows="3" placeholder="Tuliskan catatan khusus terkait kemampuan wicara..." style="font-size: 12.5px; min-height: 85px;">{{ old('wicara_catatan', $assessment->wicara_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>
                <!-- Modul 2 Navigation Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 module-nav-footer" style="border-top: 1px solid #edf2f7;">
                    <button type="button" class="btn btn-light font-w600" onclick="goToModule(1)" style="padding: 9px 18px; font-size: 13px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Modul 1
                    </button>
                    <button type="button" class="btn btn-primary font-w600 shadow-sm" onclick="goToModule(3)" style="padding: 9px 20px; font-size: 13px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                        Lanjut ke Modul 3: Evaluasi Fisik & Nyeri <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 3: EVALUASI FISIK & NYERI -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-3" role="tabpanel" aria-labelledby="tab-modul3-btn">

                <!-- Subtest: Subtest 3.1 - Intensitas Nyeri & Anatomi Body Chart -->
                <div class="assessment-subtest-card mb-4" id="subtest-nyeri">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 3.1</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-heart-pulse mr-1 text-primary"></i> Intensitas Nyeri & Anatomi Body Chart
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Penilaian skala nyeri (VAS/Wong-Baker Faces) & penandaan area keluhan anatomis</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- Skala Nyeri 0 - 10 Visual Rating Card -->
                    <div class="assessment-box p-3 rounded mb-4" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap">
                            <label class="font-w700 text-dark mb-0" style="font-size: 13.5px;">
                                <i class="fa fa-tachometer text-primary mr-1"></i> Skala Intensitas Nyeri (Visual Analog Scale / NRS 0 - 10)
                            </label>
                            <span class="badge badge-info light font-w600" style="font-size: 11px;">0: Tidak Nyeri &bull; 1-3: Ringan &bull; 4-6: Sedang &bull; 7-9: Berat &bull; 10: Sangat Hebat</span>
                        </div>

                        <!-- 1. Skor Total Nyeri (VAS) -->
                        <div class="p-3 bg-white rounded mb-3" style="border: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-w700 text-dark" style="font-size: 13px;">Skor Total Nyeri (VAS) :</span>
                                <div>
                                    <span id="label-score-total" class="badge font-w700" style="font-size: 12.5px; padding: 4px 10px; background: #e2e8f0; color: #334155;">
                                        {{ old('nyeri_skor_total', $assessment->nyeri_skor_total) !== null ? old('nyeri_skor_total', $assessment->nyeri_skor_total) . ' / 10' : 'Belum Dipilih' }}
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" name="nyeri_skor_total" id="input-score-total" value="{{ old('nyeri_skor_total', $assessment->nyeri_skor_total) }}">
                            <div class="pain-scale-group d-flex justify-content-between" style="gap: 4px; overflow-x: auto; padding-bottom: 4px;">
                                @php $score_tot = old('nyeri_skor_total', $assessment->nyeri_skor_total); @endphp
                                @for($i = 0; $i <= 10; $i++)
                                    <button type="button" class="btn pain-scale-btn {{ $score_tot !== null && (string)$score_tot === (string)$i ? 'active' : '' }}" data-target="#input-score-total" data-label="#label-score-total" data-val="{{ $i }}">
                                        <span class="d-block font-w700 num">{{ $i }}</span>
                                        <small class="desc" style="font-size: 9px; line-height: 1;">
                                            @if($i == 0) Bebas Nyeri
                                            @elseif($i == 2) Ringan
                                            @elseif($i == 5) Sedang
                                            @elseif($i == 8) Berat
                                            @elseif($i == 10) Sangat Hebat
                                            @else &nbsp;
                                            @endif
                                        </small>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <!-- 2. Saat Istirahat & Saat Aktivitas (Row 2 Kolom) -->
                        <div class="row">
                            <!-- Saat Istirahat -->
                            <div class="col-md-6 col-12 mb-3 mb-md-0">
                                <div class="p-3 bg-white rounded h-100" style="border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-w700 text-dark" style="font-size: 12.5px;">Nyeri Saat Istirahat :</span>
                                        <span id="label-score-istirahat" class="badge font-w700" style="font-size: 11.5px; padding: 3px 8px; background: #e2e8f0; color: #334155;">
                                            {{ old('nyeri_saat_istirahat', $assessment->nyeri_saat_istirahat) !== null ? old('nyeri_saat_istirahat', $assessment->nyeri_saat_istirahat) . ' / 10' : '-' }}
                                        </span>
                                    </div>
                                    <input type="hidden" name="nyeri_saat_istirahat" id="input-score-istirahat" value="{{ old('nyeri_saat_istirahat', $assessment->nyeri_saat_istirahat) }}">
                                    <div class="pain-scale-group mini d-flex justify-content-between" style="gap: 3px; overflow-x: auto;">
                                        @php $score_ist = old('nyeri_saat_istirahat', $assessment->nyeri_saat_istirahat); @endphp
                                        @for($i = 0; $i <= 10; $i++)
                                            <button type="button" class="btn pain-scale-btn mini {{ $score_ist !== null && (string)$score_ist === (string)$i ? 'active' : '' }}" data-target="#input-score-istirahat" data-label="#label-score-istirahat" data-val="{{ $i }}">
                                                <span class="font-w700 num">{{ $i }}</span>
                                            </button>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <!-- Saat Aktivitas -->
                            <div class="col-md-6 col-12">
                                <div class="p-3 bg-white rounded h-100" style="border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-w700 text-dark" style="font-size: 12.5px;">Nyeri Saat Aktivitas :</span>
                                        <span id="label-score-aktivitas" class="badge font-w700" style="font-size: 11.5px; padding: 3px 8px; background: #e2e8f0; color: #334155;">
                                            {{ old('nyeri_saat_aktivitas', $assessment->nyeri_saat_aktivitas) !== null ? old('nyeri_saat_aktivitas', $assessment->nyeri_saat_aktivitas) . ' / 10' : '-' }}
                                        </span>
                                    </div>
                                    <input type="hidden" name="nyeri_saat_aktivitas" id="input-score-aktivitas" value="{{ old('nyeri_saat_aktivitas', $assessment->nyeri_saat_aktivitas) }}">
                                    <div class="pain-scale-group mini d-flex justify-content-between" style="gap: 3px; overflow-x: auto;">
                                        @php $score_akt = old('nyeri_saat_aktivitas', $assessment->nyeri_saat_aktivitas); @endphp
                                        @for($i = 0; $i <= 10; $i++)
                                            <button type="button" class="btn pain-scale-btn mini {{ $score_akt !== null && (string)$score_akt === (string)$i ? 'active' : '' }}" data-target="#input-score-aktivitas" data-label="#label-score-aktivitas" data-val="{{ $i }}">
                                                <span class="font-w700 num">{{ $i }}</span>
                                            </button>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sifat Nyeri Card -->
                    <div class="assessment-box p-3 rounded mb-4" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                            <i class="fa fa-list-ul text-primary mr-1"></i> Sifat Nyeri (Pilih yang sesuai):
                        </label>
                        @php
                            $saved_sifat = is_array($assessment->nyeri_sifat) ? $assessment->nyeri_sifat : [];
                            $sifat_opts = [
                                'Tajam / Sharp',
                                'Tumpul / Dull',
                                'Berdenyut / Throbbing',
                                'Terbakar / Burning',
                                'Nyeri dalam / Deep',
                                'Kesemutan / Tingling',
                                'Menjalar / Radiating'
                            ];
                        @endphp
                        <div class="d-flex flex-wrap" style="gap: 8px;">
                            @foreach($sifat_opts as $s_opt)
                                <label class="check-pill-card {{ in_array($s_opt, $saved_sifat) ? 'active' : '' }}">
                                    <input type="checkbox" name="nyeri_sifat[]" value="{{ $s_opt }}" {{ in_array($s_opt, $saved_sifat) ? 'checked' : '' }}>
                                    <span>{{ $s_opt }}</span>
                                </label>
                            @endforeach
                            <label class="check-pill-card {{ in_array('Lainnya', $saved_sifat) ? 'active' : '' }}">
                                <input type="checkbox" name="nyeri_sifat[]" value="Lainnya" id="check_sifat_lainnya" {{ in_array('Lainnya', $saved_sifat) ? 'checked' : '' }} onchange="toggleSifatLainnya(this.checked)">
                                <span>Lainnya</span>
                            </label>
                        </div>
                        <div id="wrap-sifat-lainnya" class="mt-2" style="{{ in_array('Lainnya', $saved_sifat) ? '' : 'display: none;' }}">
                            <input type="text" name="nyeri_sifat_lainnya" class="form-control form-control-sm" value="{{ old('nyeri_sifat_lainnya', $assessment->nyeri_sifat_lainnya) }}" placeholder="Sebutkan sifat keluhan nyeri lainnya..." style="font-size: 12.5px; height: 36px;">
                        </div>
                    </div>

                    <!-- Body Chart - Lokasi & Pola Keluhan -->
                    <div class="assessment-box p-3 rounded mb-3" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap" style="gap: 10px;">
                            <div>
                                <label class="font-w700 text-dark mb-0" style="font-size: 13.5px;">
                                    <i class="fa fa-user-md text-primary mr-1"></i> Body Chart - Lokasi & Pola Keluhan
                                </label>
                                <small class="text-muted d-block" style="font-size: 11.5px;">Klik pada gambar anatomi tubuh untuk menandai titik keluhan pasien</small>
                            </div>
                            <div class="d-flex align-items-center" style="gap: 6px;">
                                <button type="button" class="btn btn-xs btn-outline-danger font-w600" id="btn-clear-body-chart" style="padding: 4px 10px; font-size: 11px;">
                                    <i class="fa fa-trash mr-1"></i> Bersihkan Gambar
                                </button>
                                <button type="button" class="btn btn-xs btn-outline-secondary font-w600" id="btn-undo-body-chart" style="padding: 4px 10px; font-size: 11px;">
                                    <i class="fa fa-undo mr-1"></i> Undo
                                </button>
                            </div>
                        </div>

                        <!-- Petunjuk & Simbol Selector -->
                        <div class="p-2 mb-3 rounded d-flex align-items-center flex-wrap" style="background: #edf2f7; gap: 8px;">
                            <span class="font-w700 text-dark mr-1" style="font-size: 12px;">Pilih Simbol Penanda:</span>
                            
                            <button type="button" class="btn btn-xs symbol-btn active" data-symbol="~" data-color="#dc2626" data-label="Nyeri (Pain)" style="background: #ffffff; border: 1.5px solid #dc2626; color: #dc2626; font-weight: 700;">
                                <strong style="font-size: 14px;">~</strong> Nyeri <em>(Pain)</em>
                            </button>
                            <button type="button" class="btn btn-xs symbol-btn" data-symbol="#" data-color="#d97706" data-label="Kesemutan (Numbness)" style="background: #ffffff; border: 1.5px solid #d97706; color: #d97706; font-weight: 700;">
                                <strong style="font-size: 14px;">#</strong> Kesemutan <em>(Numbness)</em>
                            </button>
                            <button type="button" class="btn btn-xs symbol-btn" data-symbol="-" data-color="#2563eb" data-label="Kelemahan (Weakness)" style="background: #ffffff; border: 1.5px solid #2563eb; color: #2563eb; font-weight: 700;">
                                <strong style="font-size: 14px;">-</strong> Kelemahan <em>(Weakness)</em>
                            </button>
                            <button type="button" class="btn btn-xs symbol-btn" data-symbol="/" data-color="#16a34a" data-label="Bengkak (Swelling)" style="background: #ffffff; border: 1.5px solid #16a34a; color: #16a34a; font-weight: 700;">
                                <strong style="font-size: 14px;">/</strong> Bengkak <em>(Swelling)</em>
                            </button>
                            <button type="button" class="btn btn-xs symbol-btn" data-symbol="X" data-color="#9333ea" data-label="Kaku (Stiffness)" style="background: #ffffff; border: 1.5px solid #9333ea; color: #9333ea; font-weight: 700;">
                                <strong style="font-size: 14px;">X</strong> Kaku <em>(Stiffness)</em>
                            </button>
                        </div>

                        <!-- Canvas Interactive Container -->
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-12 text-center mb-3 mb-lg-0">
                                <div class="body-chart-canvas-wrapper d-inline-block position-relative" style="border: 1.5px solid #cbd5e1; border-radius: 8px; background: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; max-width: 100%;">
                                    <canvas id="bodyChartCanvas" width="480" height="380" style="display: block; cursor: crosshair; max-width: 100%; height: auto;"></canvas>
                                </div>
                            </div>

                            <div class="col-lg-5 col-12">
                                <div class="form-group mb-3">
                                    <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Deskripsi / Area Lokasi Keluhan</label>
                                    <textarea name="nyeri_lokasi_keluhan" class="form-control" rows="4" placeholder="Contoh: Bahu kanan menjalar ke siku, Pinggang bawah L4-L5, Lutut kiri bengkak..." style="font-size: 12.5px;">{{ old('nyeri_lokasi_keluhan', $assessment->nyeri_lokasi_keluhan) }}</textarea>
                                </div>
                                <div class="alert alert-info py-2 px-3 mb-0" style="font-size: 11.5px; border-radius: 6px; background: #eff6ff; border-color: #bfdbfe; color: #1e40af;">
                                    <i class="fa fa-info-circle mr-1"></i> Tanda yang Anda berikan pada gambar anatomi tubuh otomatis disimpan dan akan tercetak pada lembar asesmen rekam medis.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Intensitas Nyeri -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Keluhan Nyeri (Opsional)</label>
                        <textarea name="nyeri_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait faktor pemicu, durasi nyeri, respon kompres/terapi..." style="font-size: 12.5px;">{{ old('nyeri_catatan', $assessment->nyeri_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 3.2 - Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT) -->
                <div class="assessment-subtest-card mb-4" id="subtest-rom">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 3.2</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-bone mr-1 text-primary"></i> Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT)
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Pengukuran derajat rentang gerak sendi ekstremitas & grading Manual Muscle Testing (0-5)</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- Petunjuk Ringkas Medis -->
                    <div class="alert alert-light border py-2 px-3 mb-3" style="font-size: 12px; border-radius: 8px; background: #fafcff; border-color: #e2e8f0;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                            <div>
                                <strong><i class="fa fa-info-circle text-primary mr-1"></i> Keterangan Singkatan:</strong>
                                <span class="ml-2"><strong>Abd:</strong> Abduksi &bull; <strong>Add:</strong> Adduksi &bull; <strong>IR:</strong> Internal Rotation &bull; <strong>ER:</strong> External Rotation</span>
                            </div>
                            <div>
                                <span class="badge badge-primary light font-w600">MMT: Skala 0 (Lumpuh) s/d 5 (Normal)</span>
                            </div>
                        </div>
                    </div>

                    @php
                        $rom_data = is_array($assessment->rom_mmt_data) ? $assessment->rom_mmt_data : [];
                        $rows = config('assessment.rom_mmt.rows', []);
                    @endphp

                    <!-- Tabel ROM & MMT -->
                    <div class="table-responsive mb-3" style="border: 1px solid #e2e8f0; border-radius: 8px;">
                        <table class="table table-bordered table-striped mb-0 table-sm" style="font-size: 12px; background: #ffffff;">
                            <thead class="text-center" style="background: #f1f5f9; color: var(--ot-navy);">
                                <tr>
                                    <th style="vertical-align: middle; min-width: 150px; text-align: left;">Gerakan / Sendi</th>
                                    <th style="vertical-align: middle; min-width: 90px;">Fleksi</th>
                                    <th style="vertical-align: middle; min-width: 90px;">Ekstensi</th>
                                    <th style="vertical-align: middle; min-width: 85px;">Abd</th>
                                    <th style="vertical-align: middle; min-width: 85px;">Add</th>
                                    <th style="vertical-align: middle; min-width: 85px;">IR</th>
                                    <th style="vertical-align: middle; min-width: 85px;">ER</th>
                                    <th style="vertical-align: middle; min-width: 100px;">Lainnya</th>
                                    <th style="vertical-align: middle; min-width: 95px; background: #eef2ff;">MMT (0-5)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $key => $label)
                                    @php
                                        $val = isset($rom_data[$key]) ? $rom_data[$key] : [];
                                    @endphp
                                    <tr>
                                        <td class="font-w700 text-dark align-middle">
                                            @if($key === 'custom')
                                                <div class="d-flex flex-column">
                                                    <span class="mb-1">Sendi Lainnya:</span>
                                                    <input type="text" name="rom_mmt[{{ $key }}][nama]" class="form-control form-control-sm" value="{{ $val['nama'] ?? '' }}" placeholder="Contoh: Bahu Kanan / Lutut..." style="font-size: 11.5px; height: 30px;">
                                                </div>
                                            @else
                                                {{ $label }}
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="rom_mmt[{{ $key }}][fleksi]" class="form-control form-control-sm text-center" value="{{ $val['fleksi'] ?? '' }}" placeholder="0-120° / ✓" style="font-size: 11.5px; height: 30px;">
                                        </td>
                                        <td>
                                            <input type="text" name="rom_mmt[{{ $key }}][ekstensi]" class="form-control form-control-sm text-center" value="{{ $val['ekstensi'] ?? '' }}" placeholder="0-30° / ✓" style="font-size: 11.5px; height: 30px;">
                                        </td>
                                        <td>
                                            <input type="text" name="rom_mmt[{{ $key }}][abd]" class="form-control form-control-sm text-center" value="{{ $val['abd'] ?? '' }}" placeholder="0-90°" style="font-size: 11.5px; height: 30px;">
                                        </td>
                                        <td>
                                            <input type="text" name="rom_mmt[{{ $key }}][add]" class="form-control form-control-sm text-center" value="{{ $val['add'] ?? '' }}" placeholder="0-30°" style="font-size: 11.5px; height: 30px;">
                                        </td>
                                        <td>
                                            <input type="text" name="rom_mmt[{{ $key }}][ir]" class="form-control form-control-sm text-center" value="{{ $val['ir'] ?? '' }}" placeholder="0-45°" style="font-size: 11.5px; height: 30px;">
                                        </td>
                                        <td>
                                            <input type="text" name="rom_mmt[{{ $key }}][er]" class="form-control form-control-sm text-center" value="{{ $val['er'] ?? '' }}" placeholder="0-45°" style="font-size: 11.5px; height: 30px;">
                                        </td>
                                        <td>
                                            <input type="text" name="rom_mmt[{{ $key }}][lainnya]" class="form-control form-control-sm" value="{{ $val['lainnya'] ?? '' }}" placeholder="Catatan..." style="font-size: 11.5px; height: 30px;">
                                        </td>
                                        <td style="background: #f8faff;">
                                            <select name="rom_mmt[{{ $key }}][mmt]" class="form-control form-control-sm font-w700 text-center" style="font-size: 11.5px; height: 30px;">
                                                <option value="">-</option>
                                                @for($s = 0; $s <= 5; $s++)
                                                    <option value="{{ $s }}" {{ isset($val['mmt']) && (string)$val['mmt'] === (string)$s ? 'selected' : '' }}>
                                                        Nilai {{ $s }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Catatan ROM & MMT -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Khusus ROM & Kekuatan Otot (Opsional)</label>
                        <textarea name="rom_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait keterbatasan gerak, nyeri saat akhir gerakan, spasme otot..." style="font-size: 12.5px;">{{ old('rom_catatan', $assessment->rom_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>
                <!-- Modul 3 Navigation Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 module-nav-footer" style="border-top: 1px solid #edf2f7;">
                    <button type="button" class="btn btn-light font-w600" onclick="goToModule(2)" style="padding: 9px 18px; font-size: 13px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Modul 2
                    </button>
                    <button type="button" class="btn btn-primary font-w600 shadow-sm" onclick="goToModule(4)" style="padding: 9px 20px; font-size: 13px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                        Lanjut ke Modul 4: Pemeriksaan Neurologis & Gait <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 4: PEMERIKSAAN NEUROLOGIS & GAIT -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-4" role="tabpanel" aria-labelledby="tab-modul4-btn">

                <!-- Subtest: Subtest 4.1 - Pemeriksaan Neurologis -->
                <div class="assessment-subtest-card mb-4" id="subtest-neuro">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 4.1</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-brain mr-1 text-primary"></i> Pemeriksaan Neurologis
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Tonus otot (Skala Modifikasi Ashworth), refleks fisiologis & refleks patologis</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <div class="row">
                        <!-- 1. Sensasi -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-hand-paper-o text-primary mr-1"></i> Pemeriksaan Sensasi
                                </label>
                                <div class="d-flex flex-wrap option-group mb-2" style="gap: 6px;">
                                    @php $sen = old('neuro_sensasi', $assessment->neuro_sensasi); @endphp
                                    @foreach(['Normal', 'Hipoestesia', 'Hiperestesia', 'Allodynia', 'Parestesia', 'Anastesia'] as $s_opt)
                                        <label class="radio-pill-card {{ $sen == $s_opt ? 'active' : '' }}">
                                            <input type="radio" name="neuro_sensasi" value="{{ $s_opt }}" {{ $sen == $s_opt ? 'checked' : '' }}>
                                            <span>{{ $s_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="mt-2">
                                    <label class="font-w600 text-dark mb-1" style="font-size: 12px;">Area / Lokasi Sensasi Terganggu:</label>
                                    <input type="text" name="neuro_sensasi_area" class="form-control form-control-sm" value="{{ old('neuro_sensasi_area', $assessment->neuro_sensasi_area) }}" placeholder="Contoh: Dermatom C6-C7 kanan, Telapak kaki, dll..." style="font-size: 12px; height: 34px;">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Tonus Otot -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-child text-primary mr-1"></i> Pemeriksaan Tonus Otot
                                </label>
                                <div class="d-flex flex-wrap option-group" style="gap: 6px;">
                                    @php $ton = old('neuro_tonus_otot', $assessment->neuro_tonus_otot); @endphp
                                    @foreach(['Normal', 'Hipotonus', 'Hipertonus/Spastis', 'Klonus', 'Rigiditas'] as $t_opt)
                                        <label class="radio-pill-card {{ $ton == $t_opt ? 'active' : '' }}">
                                            <input type="radio" name="neuro_tonus_otot" value="{{ $t_opt }}" {{ $ton == $t_opt ? 'checked' : '' }}>
                                            <span>{{ $t_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- 3. Refleks Tendon (D/S) -->
                        <div class="col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap: 8px;">
                                    <label class="font-w700 text-dark mb-0" style="font-size: 13px;">
                                        <i class="fa fa-gavel text-primary mr-1"></i> Pemeriksaan Refleks Tendon Fisiologis (D / S)
                                    </label>
                                    <small class="text-muted"><strong>D:</strong> Dexter (Kanan) &bull; <strong>S:</strong> Sinister (Kiri) | Standar: <code>+2 (Normal)</code></small>
                                </div>

                                <div class="row">
                                    <!-- Bisep -->
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 bg-white rounded border">
                                            <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Bisep (C5-C6)</label>
                                            <div class="d-flex" style="gap: 4px;">
                                                <input type="text" name="neuro_refleks_bisep_d" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_bisep_d', $assessment->neuro_refleks_bisep_d) }}" placeholder="D: +2" title="Bisep Kanan (Dexter)" style="font-size: 11.5px; height: 32px;">
                                                <input type="text" name="neuro_refleks_bisep_s" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_bisep_s', $assessment->neuro_refleks_bisep_s) }}" placeholder="S: +2" title="Bisep Kiri (Sinister)" style="font-size: 11.5px; height: 32px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trisep -->
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 bg-white rounded border">
                                            <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Trisep (C7)</label>
                                            <div class="d-flex" style="gap: 4px;">
                                                <input type="text" name="neuro_refleks_trisep_d" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_trisep_d', $assessment->neuro_refleks_trisep_d) }}" placeholder="D: +2" title="Trisep Kanan (Dexter)" style="font-size: 11.5px; height: 32px;">
                                                <input type="text" name="neuro_refleks_trisep_s" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_trisep_s', $assessment->neuro_refleks_trisep_s) }}" placeholder="S: +2" title="Trisep Kiri (Sinister)" style="font-size: 11.5px; height: 32px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Patela -->
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 bg-white rounded border">
                                            <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Patela (L3-L4)</label>
                                            <div class="d-flex" style="gap: 4px;">
                                                <input type="text" name="neuro_refleks_patela_d" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_patela_d', $assessment->neuro_refleks_patela_d) }}" placeholder="D: +2" title="Patela Kanan (Dexter)" style="font-size: 11.5px; height: 32px;">
                                                <input type="text" name="neuro_refleks_patela_s" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_patela_s', $assessment->neuro_refleks_patela_s) }}" placeholder="S: +2" title="Patela Kiri (Sinister)" style="font-size: 11.5px; height: 32px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Achilles -->
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 bg-white rounded border">
                                            <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Achilles (S1)</label>
                                            <div class="d-flex" style="gap: 4px;">
                                                <input type="text" name="neuro_refleks_achilles_d" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_achilles_d', $assessment->neuro_refleks_achilles_d) }}" placeholder="D: +2" title="Achilles Kanan (Dexter)" style="font-size: 11.5px; height: 32px;">
                                                <input type="text" name="neuro_refleks_achilles_s" class="form-control form-control-sm text-center" value="{{ old('neuro_refleks_achilles_s', $assessment->neuro_refleks_achilles_s) }}" placeholder="S: +2" title="Achilles Kiri (Sinister)" style="font-size: 11.5px; height: 32px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Tes Koordinasi -->
                        <div class="col-12 mb-3">
                            <div class="assessment-box p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-compass text-primary mr-1"></i> Pemeriksaan Tes Koordinasi
                                </label>
                                @php
                                    $saved_koor = is_array($assessment->neuro_koordinasi) ? $assessment->neuro_koordinasi : [];
                                    $koor_opts = ['Normal', 'Ataksia', 'Dismetria', 'Disdiadokokinesia', 'Tremor'];
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($koor_opts as $k_opt)
                                        <label class="check-pill-card {{ in_array($k_opt, $saved_koor) ? 'active' : '' }}">
                                            <input type="checkbox" name="neuro_koordinasi[]" value="{{ $k_opt }}" {{ in_array($k_opt, $saved_koor) ? 'checked' : '' }}>
                                            <span>{{ $k_opt }}</span>
                                        </label>
                                    @endforeach
                                    <label class="check-pill-card {{ in_array('Lainnya', $saved_koor) ? 'active' : '' }}">
                                        <input type="checkbox" name="neuro_koordinasi[]" value="Lainnya" id="check_koor_lainnya" {{ in_array('Lainnya', $saved_koor) ? 'checked' : '' }} onchange="toggleKoorLainnya(this.checked)">
                                        <span>Lainnya</span>
                                    </label>
                                </div>
                                <div id="wrap-koor-lainnya" class="mt-2" style="{{ in_array('Lainnya', $saved_koor) ? '' : 'display: none;' }}">
                                    <input type="text" name="neuro_koordinasi_lainnya" class="form-control form-control-sm" value="{{ old('neuro_koordinasi_lainnya', $assessment->neuro_koordinasi_lainnya) }}" placeholder="Sebutkan hasil tes koordinasi lainnya..." style="font-size: 12px; height: 34px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Neurologis -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Neurologis (Opsional)</label>
                        <textarea name="neuro_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait pemeriksaan saraf, tes provokasi (Lasegue/Phalen), dll..." style="font-size: 12.5px;">{{ old('neuro_catatan', $assessment->neuro_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 4.2 - Pemeriksaan Postur & Keseimbangan -->
                <div class="assessment-subtest-card mb-4" id="subtest-postur">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 4.2</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-person mr-1 text-primary"></i> Pemeriksaan Postur & Keseimbangan
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Analisis deviasi postur tubuh, kesimetrisan & stabilitas keseimbangan statis/dinamis</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- 1. Temuan Postur (Palpasi & Observasi) -->
                    <div class="assessment-box p-3 rounded mb-4" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13.5px;">
                            <i class="fa fa-male text-primary mr-1"></i> 1. Temuan Postur (Palpasi & Observasi)
                        </label>
                        @php
                            $saved_postur = is_array($assessment->postur_temuan) ? $assessment->postur_temuan : [];
                            $postur_opts = [
                                'Forward head posture' => 'Forward head posture (Kepala condong ke depan)',
                                'Peningkatan kifosis torakal' => 'Peningkatan kifosis torakal (Bungkuk punggung atas)',
                                'Hiperlordosis lumbal' => 'Hiperlordosis lumbal (Lengkung pinggang berlebih)',
                                'Asimetri pelvis' => 'Asimetri pelvis (Kemiringan panggul)',
                                'Asimetri bahu / skapula' => 'Asimetri bahu / skapula (Tinggi bahu tidak rata)',
                                'Genu valgum / varum' => 'Genu valgum / varum (Kaki bentuk X atau O)',
                                'Flat foot / pes cavus' => 'Flat foot / pes cavus (Telapak kaki datar / cekung)',
                            ];
                        @endphp
                        <div class="row mb-3">
                            @foreach($postur_opts as $p_val => $p_desc)
                                <div class="col-md-6 col-12 mb-2">
                                    <label class="check-pill-card w-100 {{ in_array($p_val, $saved_postur) ? 'active' : '' }}">
                                        <input type="checkbox" name="postur_temuan[]" value="{{ $p_val }}" {{ in_array($p_val, $saved_postur) ? 'checked' : '' }}>
                                        <span>{{ $p_desc }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Postur Tangan Dominan Untuk Tongkat -->
                        <div class="p-3 bg-white rounded border">
                            <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                <i class="fa fa-hand-o-right text-primary mr-1"></i> Postur Tangan Dominan Untuk Tongkat:
                            </label>
                            <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                @php $p_tongkat = old('postur_tangan_tongkat', $assessment->postur_tangan_tongkat); @endphp
                                @foreach(['Baik', 'Tidak ergonomis', 'Tidak menggunakan tongkat'] as $pt_opt)
                                    <label class="radio-pill-card {{ $p_tongkat == $pt_opt ? 'active' : '' }}">
                                        <input type="radio" name="postur_tangan_tongkat" value="{{ $pt_opt }}" {{ $p_tongkat == $pt_opt ? 'checked' : '' }}>
                                        <span>{{ $pt_opt }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 2. Instrumen Keseimbangan (Tabel Standar) -->
                    <div class="assessment-box p-3 rounded mb-3" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap: 8px;">
                            <label class="font-w700 text-dark mb-0" style="font-size: 13.5px;">
                                <i class="fa fa-balance-scale text-primary mr-1"></i> 2. Instrumen Uji Keseimbangan & Risiko Jatuh
                            </label>
                            <small class="text-muted">Isi skor atau waktu uji klinis keseimbangan pasien</small>
                        </div>

                        <div class="table-responsive mb-3" style="border: 1px solid #e2e8f0; border-radius: 8px;">
                            <table class="table table-bordered table-striped mb-0" style="font-size: 12px; background: #ffffff;">
                                <thead style="background: #f1f5f9; color: var(--ot-navy);">
                                    <tr>
                                        <th style="width: 32%;">Instrumen</th>
                                        <th style="width: 30%;">Skor / Hasil Isian</th>
                                        <th style="width: 20%;">Nilai Normal / Cut-off</th>
                                        <th style="width: 18%;">Interpretasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Berg Balance Scale (BBS) -->
                                    <tr>
                                        <td class="font-w700 text-dark align-middle">Berg Balance Scale (BBS)</td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="keseimbangan_bbs_skor" class="form-control font-w700" value="{{ old('keseimbangan_bbs_skor', $assessment->keseimbangan_bbs_skor) }}" placeholder="0 - 56" min="0" max="56">
                                                <div class="input-group-append">
                                                    <span class="input-group-text font-w600" style="font-size: 11px;">/ 56</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">&lt; 45</td>
                                        <td class="align-middle"><span class="badge badge-warning text-dark font-w600">Risiko jatuh tinggi</span></td>
                                    </tr>

                                    <!-- Timed Up and Go (TUG) -->
                                    <tr>
                                        <td class="font-w700 text-dark align-middle">Timed Up and Go (TUG)</td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="keseimbangan_tug_detik" class="form-control font-w700" value="{{ old('keseimbangan_tug_detik', $assessment->keseimbangan_tug_detik) }}" placeholder="Contoh: 11.5">
                                                <div class="input-group-append">
                                                    <span class="input-group-text font-w600" style="font-size: 11px;">Detik</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">&gt; 13,5 detik</td>
                                        <td class="align-middle"><span class="badge badge-warning text-dark font-w600">Risiko jatuh</span></td>
                                    </tr>

                                    <!-- Romberg Test (mata tertutup) -->
                                    <tr>
                                        <td class="font-w700 text-dark align-middle">Romberg Test (Mata Tertutup)</td>
                                        <td>
                                            <div class="d-flex" style="gap: 6px;">
                                                @php $romb = old('keseimbangan_romberg', $assessment->keseimbangan_romberg); @endphp
                                                @foreach(['Positif', 'Negatif'] as $r_opt)
                                                    <label class="radio-pill-card py-1 px-2 mb-0 {{ $romb == $r_opt ? 'active' : '' }}" style="font-size: 11.5px;">
                                                        <input type="radio" name="keseimbangan_romberg" value="{{ $r_opt }}" {{ $romb == $r_opt ? 'checked' : '' }}>
                                                        <span>{{ $r_opt }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="align-middle">Positif</td>
                                        <td class="align-middle"><span class="text-danger font-w600" style="font-size: 11px;">Defisit vestibular / propriosepsi</span></td>
                                    </tr>

                                    <!-- One-Leg Stance (OLS) -->
                                    <tr>
                                        <td class="font-w700 text-dark align-middle">One-Leg Stance (OLS)</td>
                                        <td>
                                            <div class="row no-gutters" style="gap: 4px;">
                                                <div class="col">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend"><span class="input-group-text" style="font-size: 10.5px;">Kanan</span></div>
                                                        <input type="text" name="keseimbangan_ols_kanan" class="form-control" value="{{ old('keseimbangan_ols_kanan', $assessment->keseimbangan_ols_kanan) }}" placeholder="Detik">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend"><span class="input-group-text" style="font-size: 10.5px;">Kiri</span></div>
                                                        <input type="text" name="keseimbangan_ols_kiri" class="form-control" value="{{ old('keseimbangan_ols_kiri', $assessment->keseimbangan_ols_kiri) }}" placeholder="Detik">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">&lt; 5 detik</td>
                                        <td class="align-middle"><span class="badge badge-warning text-dark font-w600">Risiko jatuh</span></td>
                                    </tr>

                                    <!-- Dual-Task TUG -->
                                    <tr>
                                        <td class="font-w700 text-dark align-middle">
                                            Dual-Task TUG
                                            <small class="text-muted d-block font-w400">(TUG + menjawab verbal)</small>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="keseimbangan_dual_task_tug" class="form-control" value="{{ old('keseimbangan_dual_task_tug', $assessment->keseimbangan_dual_task_tug) }}" placeholder="Contoh: 16.2">
                                                <div class="input-group-append">
                                                    <span class="input-group-text font-w600" style="font-size: 11px;">Detik</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">Selisih &gt; 4,5 detik dari TUG</td>
                                        <td class="align-middle"><span class="badge badge-info light font-w600">Perlu perhatian</span></td>
                                    </tr>

                                    <!-- Falls Efficacy Scale – International (FES-I) -->
                                    <tr>
                                        <td class="font-w700 text-dark align-middle">Falls Efficacy Scale – Int. (FES-I)</td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="keseimbangan_fesi_skor" class="form-control font-w700" value="{{ old('keseimbangan_fesi_skor', $assessment->keseimbangan_fesi_skor) }}" placeholder="16 - 64" min="16" max="64">
                                                <div class="input-group-append">
                                                    <span class="input-group-text font-w600" style="font-size: 11px;">/ 64</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">&gt; 28</td>
                                        <td class="align-middle"><span class="badge badge-danger light font-w600">Ketakutan jatuh tinggi</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Catatan Keseimbangan & Strategi Kompensasi -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Keseimbangan & Strategi Kompensasi (Opsional)</label>
                        <textarea name="postur_keseimbangan_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait pola jalan, strategi kompensasi, penggunaan alat bantu jalan, dll..." style="font-size: 12.5px;">{{ old('postur_keseimbangan_catatan', $assessment->postur_keseimbangan_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 4.3 - Pemeriksaan Gaya Berjalan (Gait) -->
                <div class="assessment-subtest-card mb-4" id="subtest-gait">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 4.3</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-person-walking-arrow-right mr-1 text-primary"></i> Pemeriksaan Gaya Berjalan (Gait)
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Pola langkah, deviasi fase berjalan (stance/swing) & penggunaan alat bantu mobilitas</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- 1. Karakteristik Gait -->
                    <div class="assessment-box p-3 rounded mb-4" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13.5px;">
                            <i class="fa fa-blind text-primary mr-1"></i> 1. Karakteristik Pola Berjalan (Gait Pattern)
                        </label>
                        @php
                            $saved_gait = is_array($assessment->gait_karakteristik) ? $assessment->gait_karakteristik : [];
                            $gait_opts = [
                                'Panjang langkah memendek' => 'Panjang langkah memendek (Short step length)',
                                'Kecepatan berjalan menurun' => 'Kecepatan berjalan menurun (Slow gait speed)',
                                'Trunk sway berlebih' => 'Trunk sway berlebih (Tubuh oleng berlebih ke samping)',
                                'Heel strike tidak jelas' => 'Heel strike tidak jelas (Pendaratan tumit tidak tegas)',
                                'Respons baik terhadap panduan verbal' => 'Respons baik terhadap panduan verbal (Cues)',
                                'Base of support melebar' => 'Base of support melebar (Kaki terbuka lebar)',
                                'Head down / chin tuck posture' => 'Head down / chin tuck posture (Kepala menunduk)',
                                'Berhenti saat berbicara (dual task fail)' => 'Berhenti saat berbicara (Dual task fail)',
                                'Penggunaan tongkat tidak efisien / asimetris' => 'Penggunaan tongkat tidak efisien / asimetris',
                            ];
                        @endphp
                        <div class="row mb-3">
                            @foreach($gait_opts as $g_val => $g_desc)
                                <div class="col-md-6 col-12 mb-2">
                                    <label class="check-pill-card w-100 {{ in_array($g_val, $saved_gait) ? 'active' : '' }}">
                                        <input type="checkbox" name="gait_karakteristik[]" value="{{ $g_val }}" {{ in_array($g_val, $saved_gait) ? 'checked' : '' }}>
                                        <span>{{ $g_desc }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Deteksi Perubahan Tekstur Lantai -->
                        <div class="p-3 bg-white rounded border">
                            <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                <i class="fa fa-road text-primary mr-1"></i> Kemampuan Deteksi Perubahan Tekstur Lantai / Permukaan:
                            </label>
                            <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                @php $g_deteksi = old('gait_deteksi_lantai', $assessment->gait_deteksi_lantai); @endphp
                                @foreach(['Baik', 'Buruk', 'Tidak dapat dievaluasi'] as $gd_opt)
                                    <label class="radio-pill-card {{ $g_deteksi == $gd_opt ? 'active' : '' }}">
                                        <input type="radio" name="gait_deteksi_lantai" value="{{ $gd_opt }}" {{ $g_deteksi == $gd_opt ? 'checked' : '' }}>
                                        <span>{{ $gd_opt }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 2. 10-Meter Walk Test (10MWT) -->
                    <div class="assessment-box p-3 rounded mb-3" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap: 8px;">
                            <label class="font-w700 text-dark mb-0" style="font-size: 13.5px;">
                                <i class="fa fa-clock-o text-primary mr-1"></i> 2. 10-Meter Walk Test (10MWT)
                            </label>
                            <small class="text-muted">Uji kecepatan berjalan jarak 10 meter</small>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12 mb-2 mb-md-0">
                                <div class="p-3 bg-white rounded border h-100">
                                    <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">Kecepatan Nyaman (m/s)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="gait_10mwt_kecepatan_nyaman" class="form-control font-w700" value="{{ old('gait_10mwt_kecepatan_nyaman', $assessment->gait_10mwt_kecepatan_nyaman) }}" placeholder="Contoh: 1.1">
                                        <div class="input-group-append"><span class="input-group-text font-w600" style="font-size: 11px;">m/s</span></div>
                                    </div>
                                    <small class="text-muted font-w500 mt-1 d-block" style="font-size: 11px;">Kecepatan jalan santai biasa</small>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 mb-2 mb-md-0">
                                <div class="p-3 bg-white rounded border h-100">
                                    <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">Kecepatan Cepat (m/s)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="gait_10mwt_kecepatan_cepat" class="form-control font-w700" value="{{ old('gait_10mwt_kecepatan_cepat', $assessment->gait_10mwt_kecepatan_cepat) }}" placeholder="Contoh: 1.4">
                                        <div class="input-group-append"><span class="input-group-text font-w600" style="font-size: 11px;">m/s</span></div>
                                    </div>
                                    <small class="text-muted font-w500 mt-1 d-block" style="font-size: 11px;">Kecepatan jalan maksimal aman</small>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="p-3 bg-white rounded border h-100">
                                    <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">Jumlah Langkah</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="gait_10mwt_jumlah_langkah" class="form-control font-w700" value="{{ old('gait_10mwt_jumlah_langkah', $assessment->gait_10mwt_jumlah_langkah) }}" placeholder="Contoh: 14">
                                        <div class="input-group-append"><span class="input-group-text font-w600" style="font-size: 11px;">Langkah</span></div>
                                    </div>
                                    <small class="text-muted font-w500 mt-1 d-block" style="font-size: 11px;">Total langkah dalam 10 meter</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Gait -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">
                            Catatan Pola Berjalan / Gait (Opsional)
                            <small class="text-muted font-w400">(Orientasi spasial, respons auditif, ketakutan jatuh, teknik tongkat)</small>
                        </label>
                        <textarea name="gait_catatan" class="form-control" rows="3" placeholder="Tuliskan catatan khusus terkait orientasi spasial, adaptasi langkah, teknik ayunan tongkat..." style="font-size: 12.5px;">{{ old('gait_catatan', $assessment->gait_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 4.4 - Pemeriksaan Sensoris, Propriosepsi & Skrining Vestibular -->
                <div class="assessment-subtest-card mb-4" id="subtest-sensoris">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 4.4</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-hand mr-1 text-primary"></i> Pemeriksaan Sensoris, Propriosepsi & Skrining Vestibular
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Sensibilitas taktil, proprioseptif & skrining respon sistem vestibular</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- Sub-Bagian A: Sensasi Taktil -->
                    <div class="card mb-3 border-0" style="background: #f8fafc; border-radius: 8px;">
                        <div class="card-body p-3">
                            <h6 class="font-w700 text-dark mb-3" style="font-size: 13.5px;">
                                <i class="fa fa-hand-paper-o text-primary mr-1"></i> A. Sensasi Taktil
                            </h6>
                            <div class="row">
                                <!-- Raba Halus -->
                                <div class="col-md-4 col-12 mb-3 mb-md-0">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                            Raba Halus (Light Touch)
                                        </label>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $sen_raba = old('sensoris_taktil_raba_halus', $assessment->sensoris_taktil_raba_halus); @endphp
                                            @foreach(['Normal', 'Terganggu'] as $opt)
                                                <label class="radio-pill-card {{ $sen_raba == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="sensoris_taktil_raba_halus" value="{{ $opt }}" {{ $sen_raba == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Pinprick -->
                                <div class="col-md-4 col-12 mb-3 mb-md-0">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                            Pinprick (Nyeri Superfisial)
                                        </label>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $sen_pin = old('sensoris_taktil_pinprick', $assessment->sensoris_taktil_pinprick); @endphp
                                            @foreach(['Normal', 'Terganggu'] as $opt)
                                                <label class="radio-pill-card {{ $sen_pin == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="sensoris_taktil_pinprick" value="{{ $opt }}" {{ $sen_pin == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Suhu -->
                                <div class="col-md-4 col-12">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                            Suhu (Panas / Dingin)
                                        </label>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $sen_suhu = old('sensoris_taktil_suhu', $assessment->sensoris_taktil_suhu); @endphp
                                            @foreach(['Normal', 'Terganggu'] as $opt)
                                                <label class="radio-pill-card {{ $sen_suhu == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="sensoris_taktil_suhu" value="{{ $opt }}" {{ $sen_suhu == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-Bagian B: Propriosepsi & Kinesthesia -->
                    <div class="card mb-3 border-0" style="background: #f8fafc; border-radius: 8px;">
                        <div class="card-body p-3">
                            <h6 class="font-w700 text-dark mb-3" style="font-size: 13.5px;">
                                <i class="fa fa-compass text-primary mr-1"></i> B. Propriosepsi & Kinesthesia
                            </h6>
                            <div class="row">
                                <!-- Sensasi Posisi Sendi -->
                                <div class="col-md-4 col-12 mb-3 mb-md-0">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                            Sensasi Posisi Sendi
                                        </label>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $sen_pos = old('sensoris_posisi_sendi', $assessment->sensoris_posisi_sendi); @endphp
                                            @foreach(['Normal', 'Terganggu'] as $opt)
                                                <label class="radio-pill-card {{ $sen_pos == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="sensoris_posisi_sendi" value="{{ $opt }}" {{ $sen_pos == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Vibrasi -->
                                <div class="col-md-4 col-12 mb-3 mb-md-0">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                            Vibrasi (Garpu Tala)
                                        </label>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $sen_vib = old('sensoris_vibrasi', $assessment->sensoris_vibrasi); @endphp
                                            @foreach(['Normal', 'Terganggu'] as $opt)
                                                <label class="radio-pill-card {{ $sen_vib == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="sensoris_vibrasi" value="{{ $opt }}" {{ $sen_vib == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Kinesthesia Jari Kaki -->
                                <div class="col-md-4 col-12">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-2 d-block" style="font-size: 12.5px;">
                                            Kinesthesia Jari Kaki
                                        </label>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $sen_kin = old('sensoris_kinesthesia_jari', $assessment->sensoris_kinesthesia_jari); @endphp
                                            @foreach(['Normal', 'Terganggu'] as $opt)
                                                <label class="radio-pill-card {{ $sen_kin == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="sensoris_kinesthesia_jari" value="{{ $opt }}" {{ $sen_kin == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-Bagian C: Skrining Vestibular Dasar -->
                    <div class="card mb-3 border-0" style="background: #f8fafc; border-radius: 8px;">
                        <div class="card-body p-3">
                            <h6 class="font-w700 text-dark mb-3" style="font-size: 13.5px;">
                                <i class="fa fa-refresh text-primary mr-1"></i> C. Skrining Vestibular Dasar
                            </h6>
                            <div class="row">
                                <!-- Head Impulse Test (HIT) -->
                                <div class="col-md-4 col-12 mb-3 mb-md-0">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">
                                            Head Impulse Test (HIT)
                                        </label>
                                        <small class="text-muted d-block mb-2" style="font-size: 11px;">Abnormal: Disfungsi kanal semisirkular</small>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $vest_hit = old('vestibular_hit', $assessment->vestibular_hit); @endphp
                                            @foreach(['Normal', 'Abnormal'] as $opt)
                                                <label class="radio-pill-card {{ $vest_hit == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="vestibular_hit" value="{{ $opt }}" {{ $vest_hit == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Dix-Hallpike -->
                                <div class="col-md-4 col-12 mb-3 mb-md-0">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">
                                            Dix-Hallpike Test
                                        </label>
                                        <small class="text-muted d-block mb-2" style="font-size: 11px;">Jika ada keluhan vertigo (Positif: BPPV)</small>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $vest_dix = old('vestibular_dix_hallpike', $assessment->vestibular_dix_hallpike); @endphp
                                            @foreach(['Positif', 'Negatif', 'Tidak dilakukan'] as $opt)
                                                <label class="radio-pill-card {{ $vest_dix == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="vestibular_dix_hallpike" value="{{ $opt }}" {{ $vest_dix == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Keluhan Pusing / Vertigo -->
                                <div class="col-md-4 col-12">
                                    <div class="p-3 bg-white rounded border h-100">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">
                                            Keluhan Pusing / Vertigo Saat Bergerak
                                        </label>
                                        <small class="text-muted d-block mb-2" style="font-size: 11px;">Sensasi melayang/berputar saat transisi posisi</small>
                                        <div class="d-flex flex-wrap option-group" style="gap: 8px;">
                                            @php $vest_pus = old('vestibular_keluhan_pusing', $assessment->vestibular_keluhan_pusing); @endphp
                                            @foreach(['Ya', 'Tidak'] as $opt)
                                                <label class="radio-pill-card {{ $vest_pus == $opt ? 'active' : '' }}">
                                                    <input type="radio" name="vestibular_keluhan_pusing" value="{{ $opt }}" {{ $vest_pus == $opt ? 'checked' : '' }}>
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-Bagian D: Lokasi & Deskripsi Defisit Sensoris -->
                    <div class="assessment-box p-3 rounded mb-3" style="background: #f8fafc; border: 1px solid #edf2f7;">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa fa-map-marker text-primary mr-1"></i> Lokasi & Deskripsi Defisit Sensoris (Dermatom / Pola)
                        </label>
                        <textarea name="sensoris_defisit_lokasi" class="form-control" rows="3" placeholder="Sebutkan lokasi distribusi dermatom atau pola defisit sensoris yang ditemukan..." style="font-size: 12.5px;">{{ old('sensoris_defisit_lokasi', $assessment->sensoris_defisit_lokasi) }}</textarea>
                    </div>

                    <!-- Catatan Tambahan Sensoris & Vestibular -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Sensoris & Vestibular (Opsional)</label>
                        <textarea name="sensoris_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan tambahan terkait pemeriksaan sensoris, propriosepsi, atau skrining vestibular..." style="font-size: 12.5px;">{{ old('sensoris_catatan', $assessment->sensoris_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>
                <!-- Modul 4 Navigation Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 module-nav-footer" style="border-top: 1px solid #edf2f7;">
                    <button type="button" class="btn btn-light font-w600" onclick="goToModule(3)" style="padding: 9px 18px; font-size: 13px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Modul 3
                    </button>
                    <button type="button" class="btn btn-primary font-w600 shadow-sm" onclick="goToModule(5)" style="padding: 9px 20px; font-size: 13px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                        Lanjut ke Modul 5: Instrumen Khusus (GMFM & Denver) <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 5: INSTRUMEN KHUSUS (GMFM & DENVER) -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-5" role="tabpanel" aria-labelledby="tab-modul5-btn">

                <!-- Subtest: Subtest 5.1 - Gross Motor Function Measure (GMFM-88) -->
                <div class="assessment-subtest-card mb-4" id="subtest-gmfm">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 5.1</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-list-check mr-1 text-primary"></i> Gross Motor Function Measure (GMFM-88)
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Pengukuran fungsi motorik kasar 88-Item (Dimensi A, B, C, D, E) & kalkulasi otomatis</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- Keterangan Skala Penilaian & Konsep Medis -->
                    <div class="card mb-3 border-0" style="background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                <span class="font-w700 text-dark" style="font-size: 13px;">
                                    <i class="fa fa-info-circle text-primary mr-1"></i> Panduan Skala Skor GMFM (0 - 3):
                                </span>
                                <small class="text-muted">Skala Penilaian Baku GMFM-88</small>
                            </div>
                            <div class="row" style="font-size: 12px;">
                                <div class="col-md-3 col-6 mb-2">
                                    <div class="p-2 rounded bg-white border h-100">
                                        <strong class="text-danger d-block mb-1"><span class="badge badge-danger mr-1">0</span> Tidak Memulai</strong>
                                        <span class="text-muted" style="font-size: 11.5px; line-height: 1.3; display: block;">Tidak dapat memulai / melakukan gerakan sama sekali (0%).</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-2">
                                    <div class="p-2 rounded bg-white border h-100">
                                        <strong class="text-warning d-block mb-1"><span class="badge badge-warning text-dark mr-1">1</span> Memulai</strong>
                                        <span class="text-muted" style="font-size: 11.5px; line-height: 1.3; display: block;">Memulai gerakan tetapi menyelesaikan kurang dari 10% (< 10%).</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-2">
                                    <div class="p-2 rounded bg-white border h-100">
                                        <strong class="text-primary d-block mb-1"><span class="badge badge-primary mr-1">2</span> Selesai Sebagian</strong>
                                        <span class="text-muted" style="font-size: 11.5px; line-height: 1.3; display: block;">Menyelesaikan sebagian aktivitas gerakan (10% s/d < 100%).</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-2">
                                    <div class="p-2 rounded bg-white border h-100">
                                        <strong class="text-success d-block mb-1"><span class="badge badge-success mr-1">3</span> Selesai Sempurna</strong>
                                        <span class="text-muted" style="font-size: 11.5px; line-height: 1.3; display: block;">Menyelesaikan seluruh aktivitas mandiri & sempurna (100%).</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dimensi Navigasi Underline Tabs (A, B, C, D, E) & Total Summary -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 border-bottom" style="border-color: #e2e8f0; gap: 8px;">
                        <ul class="nav nav-tabs border-bottom-0 gmfm-dim-tabs" style="gap: 4px; margin-bottom: -1px;">
                            <li class="nav-item">
                                <a href="#gmfm-pane-a" class="nav-link gmfm-dim-btn active" data-target-dim="#gmfm-pane-a">
                                    <i class="fa fa-bed mr-1.5 text-primary"></i> A: Berbaring & Berguling
                                    <span class="badge-counter">17</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#gmfm-pane-b" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-pane-b">
                                    <i class="fa fa-street-view mr-1.5 text-muted"></i> B: Duduk
                                    <span class="badge-counter">20</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#gmfm-pane-c" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-pane-c">
                                    <i class="fa fa-child mr-1.5 text-muted"></i> C: Merangkak & Berlutut
                                    <span class="badge-counter">14</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#gmfm-pane-d" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-pane-d">
                                    <i class="fa fa-male mr-1.5 text-muted"></i> D: Berdiri
                                    <span class="badge-counter">13</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#gmfm-pane-e" class="nav-link gmfm-dim-btn" data-target-dim="#gmfm-pane-e">
                                    <i class="fa fa-running mr-1.5 text-muted"></i> E: Jalan, Lari & Lompat
                                    <span class="badge-counter">24</span>
                                </a>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center p-1.5 px-3 mb-2 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; gap: 8px;">
                            <span class="font-w700 text-dark" style="font-size: 11.5px;"><i class="fa-solid fa-calculator text-primary mr-1"></i> TOTAL GMFM-88:</span>
                            <span class="badge badge-dark font-w700" id="gmfm-total-live-badge-score" style="font-size: 12px; padding: 4px 8px; border-radius: 6px;">{{ old('gmfm_total_score', $assessment->gmfm_total_score ?? 0) }} / 264</span>
                            <span class="badge badge-success font-w700" id="gmfm-total-live-badge-persen" style="font-size: 12px; padding: 4px 8px; border-radius: 6px;">{{ number_format(old('gmfm_total_persen', $assessment->gmfm_total_persen ?? 0), 1) }}%</span>
                            <input type="hidden" name="gmfm_total_score" id="input-gmfm-total-score" value="{{ old('gmfm_total_score', $assessment->gmfm_total_score ?? 0) }}">
                            <input type="hidden" name="gmfm_total_persen" id="input-gmfm-total-persen" value="{{ old('gmfm_total_persen', $assessment->gmfm_total_persen ?? 0) }}">
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- SUB-PANE DIMENSI A: BERBARING & BERGULING     -->
                    <!-- ============================================== -->
                    <div class="gmfm-dim-pane" id="gmfm-pane-a">
                        @php
                            $saved_gmfm_a_scores = is_array($assessment->gmfm_dimensi_a_scores) ? $assessment->gmfm_dimensi_a_scores : [];
                            $saved_a_total = old('gmfm_dimensi_a_total', $assessment->gmfm_dimensi_a_total ?? 0);
                            $saved_a_persen = old('gmfm_dimensi_a_persen', $assessment->gmfm_dimensi_a_persen ?? 0);
                        @endphp
                        <!-- Summary Score Card Dimensi A (Light Blue Medis) -->
                        <div class="card mb-3 gmfm-dim-score-card">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px; letter-spacing: 0.5px;">
                                            <i class="fa fa-bed mr-1 text-primary"></i> Skor Dimensi A (Berbaring & Berguling)
                                        </small>
                                        <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 26px;">
                                            <span id="gmfm-a-live-total">{{ $saved_a_total ?: 0 }}</span> <span style="font-size: 15px; color: #64748b; font-weight: 600;">/ 51</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_a_total" id="input-gmfm-a-total" value="{{ $saved_a_total }}">
                                        <input type="hidden" name="gmfm_dimensi_a_persen" id="input-gmfm-a-persen" value="{{ $saved_a_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi A:</small>
                                            <strong class="text-primary font-w800" id="gmfm-a-live-persen" style="font-size: 13px;">{{ number_format($saved_a_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: #dbeafe;">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="gmfm-a-live-progress" role="progressbar" style="width: {{ $saved_a_persen }}%; background-color: #2563eb !important;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi Dimensi A:</small>
                                        <span class="badge font-w700 px-3 py-2" id="gmfm-a-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
                                            @if($saved_a_persen >= 80)
                                                Sangat Baik (Mandiri)
                                            @elseif($saved_a_persen >= 50)
                                                Sedang (Perlu Stimulasi)
                                            @elseif($saved_a_total > 0)
                                                Keterbatasan Signifikan
                                            @else
                                                Belum Dinilai
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 17 Item Dimensi A List (Matrix Grid) -->
                        @php $gmfm_a_items = config('gmfm.dimensions.A.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-bordered table-hover mb-0 matrix-grid-table" style="font-size: 12px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155; font-size: 11.5px;">
                                    <tr>
                                        <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                        <th style="width: 48%; vertical-align: middle;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi A)</th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fee2e2; color: #991b1b;">0<br><small class="font-w500">(Tidak)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fef3c7; color: #92400e;">1<br><small class="font-w500">(Mulai)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dbeafe; color: #1e40af;">2<br><small class="font-w500">(Sebagian)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dcfce7; color: #166534;">3<br><small class="font-w500">(Sempurna)</small></th>
                                        <th style="width: 10%; text-align: center; vertical-align: middle; background: #f8fafc; color: #64748b;">NT<br><small class="font-w500">(Tdk Diuji)</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_a_items as $no => $item)
                                        @php $valA = isset($saved_gmfm_a_scores[$no]) ? $saved_gmfm_a_scores[$no] : (old('gmfm_dimensi_a_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light text-primary font-w600 mb-1" style="font-size: 10.5px; border: 1px solid #cbd5e1;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.35; font-size: 12px;">{{ $item['action'] }}</div>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffdfd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="0" class="gmfm-a-radio matrix-input" {{ $valA === '0' || $valA === 0 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator danger">0</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffefb;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="1" class="gmfm-a-radio matrix-input" {{ $valA === '1' || $valA === 1 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator warning">1</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfdff;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="2" class="gmfm-a-radio matrix-input" {{ $valA === '2' || $valA === 2 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator info">2</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfffd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="3" class="gmfm-a-radio matrix-input" {{ $valA === '3' || $valA === 3 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator success">3</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="NT" class="gmfm-a-radio matrix-input" {{ $valA === 'NT' ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator muted">NT</span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Catatan Observasi Dimensi A -->
                        <div class="form-group mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi GMFM Dimensi A (Opsional)</label>
                            <textarea name="gmfm_dimensi_a_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait Dimensi A (kontrol kepala, berguling, prone on elbows)..." style="font-size: 12.5px;">{{ old('gmfm_dimensi_a_catatan', $assessment->gmfm_dimensi_a_catatan) }}</textarea>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- SUB-PANE DIMENSI B: DUDUK (SITTING)            -->
                    <!-- ============================================== -->
                    <div class="gmfm-dim-pane" id="gmfm-pane-b" style="display: none;">
                        @php
                            $saved_gmfm_b_scores = is_array($assessment->gmfm_dimensi_b_scores) ? $assessment->gmfm_dimensi_b_scores : [];
                            $saved_b_total = old('gmfm_dimensi_b_total', $assessment->gmfm_dimensi_b_total ?? 0);
                            $saved_b_persen = old('gmfm_dimensi_b_persen', $assessment->gmfm_dimensi_b_persen ?? 0);
                        @endphp
                        <!-- Summary Score Card Dimensi B (Light Blue Medis) -->
                        <div class="card mb-3 gmfm-dim-score-card">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px; letter-spacing: 0.5px;">
                                            <i class="fa fa-street-view mr-1 text-primary"></i> Skor Dimensi B (Duduk)
                                        </small>
                                        <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 26px;">
                                            <span id="gmfm-b-live-total">{{ $saved_b_total ?: 0 }}</span> <span style="font-size: 15px; color: #64748b; font-weight: 600;">/ 60</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_b_total" id="input-gmfm-b-total" value="{{ $saved_b_total }}">
                                        <input type="hidden" name="gmfm_dimensi_b_persen" id="input-gmfm-b-persen" value="{{ $saved_b_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi B:</small>
                                            <strong class="text-primary font-w800" id="gmfm-b-live-persen" style="font-size: 13px;">{{ number_format($saved_b_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: #dbeafe;">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="gmfm-b-live-progress" role="progressbar" style="width: {{ $saved_b_persen }}%; background-color: #2563eb !important;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi Dimensi B:</small>
                                        <span class="badge font-w700 px-3 py-2" id="gmfm-b-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
                                            @if($saved_b_persen >= 80)
                                                Sangat Baik (Mandiri)
                                            @elseif($saved_b_persen >= 50)
                                                Sedang (Perlu Stimulasi)
                                            @elseif($saved_b_total > 0)
                                                Keterbatasan Signifikan
                                            @else
                                                Belum Dinilai
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 20 Item Dimensi B List (Matrix Grid) -->
                        @php $gmfm_b_items = config('gmfm.dimensions.B.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-bordered table-hover mb-0 matrix-grid-table" style="font-size: 12px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155; font-size: 11.5px;">
                                    <tr>
                                        <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                        <th style="width: 48%; vertical-align: middle;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi B - Duduk)</th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fee2e2; color: #991b1b;">0<br><small class="font-w500">(Tidak)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fef3c7; color: #92400e;">1<br><small class="font-w500">(Mulai)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dbeafe; color: #1e40af;">2<br><small class="font-w500">(Sebagian)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dcfce7; color: #166534;">3<br><small class="font-w500">(Sempurna)</small></th>
                                        <th style="width: 10%; text-align: center; vertical-align: middle; background: #f8fafc; color: #64748b;">NT<br><small class="font-w500">(Tdk Diuji)</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_b_items as $no => $item)
                                        @php $valB = isset($saved_gmfm_b_scores[$no]) ? $saved_gmfm_b_scores[$no] : (old('gmfm_dimensi_b_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light text-primary font-w600 mb-1" style="font-size: 10.5px; border: 1px solid #cbd5e1;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.35; font-size: 12px;">{{ $item['action'] }}</div>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffdfd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="0" class="gmfm-b-radio matrix-input" {{ $valB === '0' || $valB === 0 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator danger">0</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffefb;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="1" class="gmfm-b-radio matrix-input" {{ $valB === '1' || $valB === 1 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator warning">1</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfdff;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="2" class="gmfm-b-radio matrix-input" {{ $valB === '2' || $valB === 2 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator info">2</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfffd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="3" class="gmfm-b-radio matrix-input" {{ $valB === '3' || $valB === 3 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator success">3</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="NT" class="gmfm-b-radio matrix-input" {{ $valB === 'NT' ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator muted">NT</span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Catatan Observasi Dimensi B -->
                        <div class="form-group mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi GMFM Dimensi B (Opsional)</label>
                            <textarea name="gmfm_dimensi_b_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait Dimensi B (kontrol duduk, protektif ekstensi, transisi merangkak)..." style="font-size: 12.5px;">{{ old('gmfm_dimensi_b_catatan', $assessment->gmfm_dimensi_b_catatan) }}</textarea>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- SUB-PANE DIMENSI C: MERANGKAK & BERLUTUT       -->
                    <!-- ============================================== -->
                    <div class="gmfm-dim-pane" id="gmfm-pane-c" style="display: none;">
                        @php
                            $saved_gmfm_c_scores = is_array($assessment->gmfm_dimensi_c_scores) ? $assessment->gmfm_dimensi_c_scores : [];
                            $saved_c_total = old('gmfm_dimensi_c_total', $assessment->gmfm_dimensi_c_total ?? 0);
                            $saved_c_persen = old('gmfm_dimensi_c_persen', $assessment->gmfm_dimensi_c_persen ?? 0);
                        @endphp
                        <!-- Summary Score Card Dimensi C (Light Blue Medis) -->
                        <div class="card mb-3 gmfm-dim-score-card">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px; letter-spacing: 0.5px;">
                                            <i class="fa fa-child mr-1 text-primary"></i> Skor Dimensi C (Merangkak & Berlutut)
                                        </small>
                                        <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 26px;">
                                            <span id="gmfm-c-live-total">{{ $saved_c_total ?: 0 }}</span> <span style="font-size: 15px; color: #64748b; font-weight: 600;">/ 42</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_c_total" id="input-gmfm-c-total" value="{{ $saved_c_total }}">
                                        <input type="hidden" name="gmfm_dimensi_c_persen" id="input-gmfm-c-persen" value="{{ $saved_c_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi C:</small>
                                            <strong class="text-primary font-w800" id="gmfm-c-live-persen" style="font-size: 13px;">{{ number_format($saved_c_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: #dbeafe;">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="gmfm-c-live-progress" role="progressbar" style="width: {{ $saved_c_persen }}%; background-color: #2563eb !important;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi Dimensi C:</small>
                                        <span class="badge font-w700 px-3 py-2" id="gmfm-c-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
                                            @if($saved_c_persen >= 80)
                                                Sangat Baik (Mandiri)
                                            @elseif($saved_c_persen >= 50)
                                                Sedang (Perlu Stimulasi)
                                            @elseif($saved_c_total > 0)
                                                Keterbatasan Signifikan
                                            @else
                                                Belum Dinilai
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 14 Item Dimensi C List (Matrix Grid) -->
                        @php $gmfm_c_items = config('gmfm.dimensions.C.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-bordered table-hover mb-0 matrix-grid-table" style="font-size: 12px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155; font-size: 11.5px;">
                                    <tr>
                                        <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                        <th style="width: 48%; vertical-align: middle;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi C - Merangkak & Berlutut)</th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fee2e2; color: #991b1b;">0<br><small class="font-w500">(Tidak)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fef3c7; color: #92400e;">1<br><small class="font-w500">(Mulai)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dbeafe; color: #1e40af;">2<br><small class="font-w500">(Sebagian)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dcfce7; color: #166534;">3<br><small class="font-w500">(Sempurna)</small></th>
                                        <th style="width: 10%; text-align: center; vertical-align: middle; background: #f8fafc; color: #64748b;">NT<br><small class="font-w500">(Tdk Diuji)</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_c_items as $no => $item)
                                        @php $valC = isset($saved_gmfm_c_scores[$no]) ? $saved_gmfm_c_scores[$no] : (old('gmfm_dimensi_c_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light text-primary font-w600 mb-1" style="font-size: 10.5px; border: 1px solid #cbd5e1;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.35; font-size: 12px;">{{ $item['action'] }}</div>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffdfd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="0" class="gmfm-c-radio matrix-input" {{ $valC === '0' || $valC === 0 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator danger">0</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffefb;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="1" class="gmfm-c-radio matrix-input" {{ $valC === '1' || $valC === 1 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator warning">1</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfdff;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="2" class="gmfm-c-radio matrix-input" {{ $valC === '2' || $valC === 2 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator info">2</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfffd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="3" class="gmfm-c-radio matrix-input" {{ $valC === '3' || $valC === 3 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator success">3</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="NT" class="gmfm-c-radio matrix-input" {{ $valC === 'NT' ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator muted">NT</span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Catatan Observasi Dimensi C -->
                        <div class="form-group mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi GMFM Dimensi C (Opsional)</label>
                            <textarea name="gmfm_dimensi_c_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait Dimensi C (stabilitas posisi 4-poin, pola merangkak resiprokal, keseimbangan berlutut)..." style="font-size: 12.5px;">{{ old('gmfm_dimensi_c_catatan', $assessment->gmfm_dimensi_c_catatan) }}</textarea>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- SUB-PANE DIMENSI D: BERDIRI (STANDING)         -->
                    <!-- ============================================== -->
                    <div class="gmfm-dim-pane" id="gmfm-pane-d" style="display: none;">
                        @php
                            $saved_gmfm_d_scores = is_array($assessment->gmfm_dimensi_d_scores) ? $assessment->gmfm_dimensi_d_scores : [];
                            $saved_d_total = old('gmfm_dimensi_d_total', $assessment->gmfm_dimensi_d_total ?? 0);
                            $saved_d_persen = old('gmfm_dimensi_d_persen', $assessment->gmfm_dimensi_d_persen ?? 0);
                        @endphp
                        <!-- Summary Score Card Dimensi D (Light Blue Medis) -->
                        <div class="card mb-3 gmfm-dim-score-card">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px; letter-spacing: 0.5px;">
                                            <i class="fa fa-male mr-1 text-primary"></i> Skor Dimensi D (Berdiri)
                                        </small>
                                        <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 26px;">
                                            <span id="gmfm-d-live-total">{{ $saved_d_total ?: 0 }}</span> <span style="font-size: 15px; color: #64748b; font-weight: 600;">/ 39</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_d_total" id="input-gmfm-d-total" value="{{ $saved_d_total }}">
                                        <input type="hidden" name="gmfm_dimensi_d_persen" id="input-gmfm-d-persen" value="{{ $saved_d_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi D:</small>
                                            <strong class="text-primary font-w800" id="gmfm-d-live-persen" style="font-size: 13px;">{{ number_format($saved_d_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: #dbeafe;">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="gmfm-d-live-progress" role="progressbar" style="width: {{ $saved_d_persen }}%; background-color: #2563eb !important;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi Dimensi D:</small>
                                        <span class="badge font-w700 px-3 py-2" id="gmfm-d-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
                                            @if($saved_d_persen >= 80)
                                                Sangat Baik (Mandiri)
                                            @elseif($saved_d_persen >= 50)
                                                Sedang (Perlu Stimulasi)
                                            @elseif($saved_d_total > 0)
                                                Keterbatasan Signifikan
                                            @else
                                                Belum Dinilai
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 13 Item Dimensi D List (Matrix Grid) -->
                        @php $gmfm_d_items = config('gmfm.dimensions.D.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-bordered table-hover mb-0 matrix-grid-table" style="font-size: 12px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155; font-size: 11.5px;">
                                    <tr>
                                        <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                        <th style="width: 48%; vertical-align: middle;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi D - Berdiri)</th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fee2e2; color: #991b1b;">0<br><small class="font-w500">(Tidak)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fef3c7; color: #92400e;">1<br><small class="font-w500">(Mulai)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dbeafe; color: #1e40af;">2<br><small class="font-w500">(Sebagian)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dcfce7; color: #166534;">3<br><small class="font-w500">(Sempurna)</small></th>
                                        <th style="width: 10%; text-align: center; vertical-align: middle; background: #f8fafc; color: #64748b;">NT<br><small class="font-w500">(Tdk Diuji)</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_d_items as $no => $item)
                                        @php $valD = isset($saved_gmfm_d_scores[$no]) ? $saved_gmfm_d_scores[$no] : (old('gmfm_dimensi_d_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light text-primary font-w600 mb-1" style="font-size: 10.5px; border: 1px solid #cbd5e1;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.35; font-size: 12px;">{{ $item['action'] }}</div>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffdfd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="0" class="gmfm-d-radio matrix-input" {{ $valD === '0' || $valD === 0 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator danger">0</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffefb;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="1" class="gmfm-d-radio matrix-input" {{ $valD === '1' || $valD === 1 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator warning">1</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfdff;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="2" class="gmfm-d-radio matrix-input" {{ $valD === '2' || $valD === 2 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator info">2</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfffd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="3" class="gmfm-d-radio matrix-input" {{ $valD === '3' || $valD === 3 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator success">3</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="NT" class="gmfm-d-radio matrix-input" {{ $valD === 'NT' ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator muted">NT</span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Catatan Observasi Dimensi D -->
                        <div class="form-group mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi GMFM Dimensi D (Opsional)</label>
                            <textarea name="gmfm_dimensi_d_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait Dimensi D (keseimbangan statis/dinamis berdiri, single leg stance, sit-to-stand, jongkok)..." style="font-size: 12.5px;">{{ old('gmfm_dimensi_d_catatan', $assessment->gmfm_dimensi_d_catatan) }}</textarea>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- SUB-PANE DIMENSI E: BERJALAN, BERLARI & LOMPAT -->
                    <!-- ============================================== -->
                    <div class="gmfm-dim-pane" id="gmfm-pane-e" style="display: none;">
                        @php
                            $saved_gmfm_e_scores = is_array($assessment->gmfm_dimensi_e_scores) ? $assessment->gmfm_dimensi_e_scores : [];
                            $saved_e_total = old('gmfm_dimensi_e_total', $assessment->gmfm_dimensi_e_total ?? 0);
                            $saved_e_persen = old('gmfm_dimensi_e_persen', $assessment->gmfm_dimensi_e_persen ?? 0);
                        @endphp
                        <!-- Summary Score Card Dimensi E (Light Blue Medis) -->
                        <div class="card mb-3 gmfm-dim-score-card">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px; letter-spacing: 0.5px;">
                                            <i class="fa fa-running mr-1 text-primary"></i> Skor Dimensi E (Jalan, Lari & Lompat)
                                        </small>
                                        <h3 class="mb-0 font-w800" style="color: #1e3a8a; font-size: 26px;">
                                            <span id="gmfm-e-live-total">{{ $saved_e_total ?: 0 }}</span> <span style="font-size: 15px; color: #64748b; font-weight: 600;">/ 72</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_e_total" id="input-gmfm-e-total" value="{{ $saved_e_total }}">
                                        <input type="hidden" name="gmfm_dimensi_e_persen" id="input-gmfm-e-persen" value="{{ $saved_e_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="font-w700" style="color: #334155; font-size: 12px;">Capaian Dimensi E:</small>
                                            <strong class="text-primary font-w800" id="gmfm-e-live-persen" style="font-size: 13px;">{{ number_format($saved_e_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: #dbeafe;">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="gmfm-e-live-progress" role="progressbar" style="width: {{ $saved_e_persen }}%; background-color: #2563eb !important;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi Dimensi E:</small>
                                        <span class="badge font-w700 px-3 py-2" id="gmfm-e-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
                                            @if($saved_e_persen >= 80)
                                                Sangat Baik (Mandiri)
                                            @elseif($saved_e_persen >= 50)
                                                Sedang (Perlu Stimulasi)
                                            @elseif($saved_e_total > 0)
                                                Keterbatasan Signifikan
                                            @else
                                                Belum Dinilai
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 24 Item Dimensi E List (Matrix Grid) -->
                        @php $gmfm_e_items = config('gmfm.dimensions.E.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-bordered table-hover mb-0 matrix-grid-table" style="font-size: 12px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155; font-size: 11.5px;">
                                    <tr>
                                        <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                        <th style="width: 48%; vertical-align: middle;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi E - Jalan, Lari & Melompat)</th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fee2e2; color: #991b1b;">0<br><small class="font-w500">(Tidak)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #fef3c7; color: #92400e;">1<br><small class="font-w500">(Mulai)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dbeafe; color: #1e40af;">2<br><small class="font-w500">(Sebagian)</small></th>
                                        <th style="width: 9%; text-align: center; vertical-align: middle; background: #dcfce7; color: #166534;">3<br><small class="font-w500">(Sempurna)</small></th>
                                        <th style="width: 10%; text-align: center; vertical-align: middle; background: #f8fafc; color: #64748b;">NT<br><small class="font-w500">(Tdk Diuji)</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_e_items as $no => $item)
                                        @php $valE = isset($saved_gmfm_e_scores[$no]) ? $saved_gmfm_e_scores[$no] : (old('gmfm_dimensi_e_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light text-primary font-w600 mb-1" style="font-size: 10.5px; border: 1px solid #cbd5e1;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.35; font-size: 12px;">{{ $item['action'] }}</div>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffdfd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="0" class="gmfm-e-radio matrix-input" {{ $valE === '0' || $valE === 0 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator danger">0</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffefb;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="1" class="gmfm-e-radio matrix-input" {{ $valE === '1' || $valE === 1 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator warning">1</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfdff;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="2" class="gmfm-e-radio matrix-input" {{ $valE === '2' || $valE === 2 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator info">2</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfffd;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="3" class="gmfm-e-radio matrix-input" {{ $valE === '3' || $valE === 3 ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator success">3</span>
                                                </label>
                                            </td>
                                            <td class="text-center matrix-cell" style="vertical-align: middle;">
                                                <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                    <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="NT" class="gmfm-e-radio matrix-input" {{ $valE === 'NT' ? 'checked' : '' }}>
                                                    <span class="matrix-score-indicator muted">NT</span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Catatan Observasi Dimensi E -->
                        <div class="form-group mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi GMFM Dimensi E (Opsional)</label>
                            <textarea name="gmfm_dimensi_e_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait Dimensi E (pola jalan menyamping/mundur, kemampuan melompat, menendang bola, naik/turun tangga tanpa pegangan)..." style="font-size: 12.5px;">{{ old('gmfm_dimensi_e_catatan', $assessment->gmfm_dimensi_e_catatan) }}</textarea>
                        </div>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 5.2 - Skala Perkembangan Denver II (DDST II) -->
                <div class="assessment-subtest-card mb-4" id="subtest-denver">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 5.2</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-graduation-cap mr-1 text-primary"></i> Skala Perkembangan Denver II (DDST II)
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Skrining 19 task tumbuh kembang anak (Personal-Sosial, Motorik Halus, Bahasa, Motorik Kasar)</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        @php
                        $saved_denver_data = is_array($assessment->denver_data) ? $assessment->denver_data : [];
                        $saved_denver_pass = old('denver_pass_count', $assessment->denver_pass_count ?? 0);
                        $saved_denver_fail = old('denver_fail_count', $assessment->denver_fail_count ?? 0);
                        $saved_denver_refusal = old('denver_refusal_count', $assessment->denver_refusal_count ?? 0);
                        $saved_denver_no = old('denver_no_count', $assessment->denver_no_count ?? 0);
                        $saved_denver_kesimpulan = old('denver_kesimpulan', $assessment->denver_kesimpulan ?? 'Belum Dinilai');

                        $denver_sectors = config('denver.sectors', []);
                    @endphp

                    <!-- Summary Score Card Skala Denver (Light Blue Medis Sesuai Header) -->
                    <div class="card mb-4 gmfm-dim-score-card">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-12 mb-3 mb-lg-0">
                                    <small class="font-w700 text-uppercase d-block mb-1" style="color: #1e40af; font-size: 11px; letter-spacing: 0.5px;">
                                        <i class="fa-solid fa-chart-pie mr-1 text-primary"></i> Rekapitulasi Hasil Skrining DDST II (19 Task)
                                    </small>
                                    <div class="d-flex align-items-center flex-wrap mt-2" style="gap: 8px;">
                                        <span class="badge px-3 py-2 font-w700" style="background: #10b981; color: white; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 3px rgba(16, 185, 129, 0.2);">
                                            <i class="fa fa-check mr-1"></i> Pass (P): <strong id="denver-live-p">{{ $saved_denver_pass }}</strong>
                                        </span>
                                        <span class="badge px-3 py-2 font-w700" style="background: #ef4444; color: white; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 3px rgba(239, 68, 68, 0.2);">
                                            <i class="fa fa-times mr-1"></i> Fail (F): <strong id="denver-live-f">{{ $saved_denver_fail }}</strong>
                                        </span>
                                        <span class="badge px-3 py-2 font-w700" style="background: #f59e0b; color: white; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 3px rgba(245, 158, 11, 0.2);">
                                            <i class="fa fa-ban mr-1"></i> Refusal (R): <strong id="denver-live-r">{{ $saved_denver_refusal }}</strong>
                                        </span>
                                        <span class="badge px-3 py-2 font-w700" style="background: #64748b; color: white; font-size: 12px; border-radius: 6px;">
                                            <i class="fa fa-minus-circle mr-1"></i> No Opp (NO): <strong id="denver-live-no">{{ $saved_denver_no }}</strong>
                                        </span>
                                    </div>
                                    <input type="hidden" name="denver_pass_count" id="input-denver-pass" value="{{ $saved_denver_pass }}">
                                    <input type="hidden" name="denver_fail_count" id="input-denver-fail" value="{{ $saved_denver_fail }}">
                                    <input type="hidden" name="denver_refusal_count" id="input-denver-refusal" value="{{ $saved_denver_refusal }}">
                                    <input type="hidden" name="denver_no_count" id="input-denver-no" value="{{ $saved_denver_no }}">
                                    <input type="hidden" name="denver_kesimpulan" id="input-denver-kesimpulan" value="{{ $saved_denver_kesimpulan }}">
                                </div>
                                <div class="col-lg-5 col-12 text-lg-right">
                                    <small class="text-muted d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi Klinis Otomatis:</small>
                                    <span class="badge px-3 py-2 font-w700 text-uppercase" id="denver-live-badge-kesimpulan" style="font-size: 12.5px; border-radius: 6px; {{ $saved_denver_kesimpulan == 'Normal (Sesuai Usia)' ? 'background:#10b981;color:white;' : ($saved_denver_kesimpulan == 'Suspect (Meragukan)' ? 'background:#f59e0b;color:white;' : ($saved_denver_kesimpulan == 'Keterlambatan Perkembangan' ? 'background:#ef4444;color:white;' : 'background:#e2e8f0;color:#1e293b;')) }}">
                                        {{ $saved_denver_kesimpulan ?: 'Belum Dinilai' }}
                                    </span>
                                    <div class="text-muted font-w600 mt-1" id="denver-live-desc-kesimpulan" style="font-size: 11.5px; line-height: 1.35;">
                                        @if($saved_denver_kesimpulan == 'Normal (Sesuai Usia)')
                                            Semua task perkembangan tercapai sesuai kelompok usia.
                                        @elseif($saved_denver_kesimpulan == 'Suspect (Meragukan)')
                                            Ditemukan 1-2 kegagalan task. Disarankan re-screening 1-2 minggu.
                                        @elseif($saved_denver_kesimpulan == 'Keterlambatan Perkembangan')
                                            Ditemukan ≥3 kegagalan task lintas sektor. Perlu program terapi intensif.
                                        @elseif($saved_denver_kesimpulan == 'Untestable (Menolak Pengujian)')
                                            Anak menolak ≥2 pengujian. Uji ulang saat kooperatif.
                                        @else
                                            Pilih status task (P/F/R/NO) di bawah untuk memicu kalkulasi.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Sectors Task List (Matrix Grid) -->
                    @foreach($denver_sectors as $sKey => $sector)
                        <div class="card mb-3 border" style="border-radius: 8px; border-color: #e2e8f0;">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" style="background: {{ $sector['bg_header'] }}; border-bottom: 1px solid #e2e8f0;">
                                <h6 class="font-w700 mb-0" style="color: {{ $sector['badge_color'] }}; font-size: 13.5px;">
                                    {{ $sector['title'] }}
                                </h6>
                                <span class="badge badge-light border font-w600" style="font-size: 11px;">{{ count($sector['tasks']) }} Task</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 matrix-grid-table" style="font-size: 12px; vertical-align: middle;">
                                        <thead style="background: #fafafa; color: #475569; font-size: 11.5px;">
                                            <tr>
                                                <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                                <th style="width: 32%; vertical-align: middle;">Nama Task Perkembangan</th>
                                                <th style="width: 12%; text-align: center; vertical-align: middle;">Rentang Usia</th>
                                                <th style="width: 8%; text-align: center; vertical-align: middle; background: #dcfce7; color: #166534;">Pass<br><small class="font-w700">(P)</small></th>
                                                <th style="width: 8%; text-align: center; vertical-align: middle; background: #fee2e2; color: #991b1b;">Fail<br><small class="font-w700">(F)</small></th>
                                                <th style="width: 8%; text-align: center; vertical-align: middle; background: #fef3c7; color: #92400e;">Refusal<br><small class="font-w700">(R)</small></th>
                                                <th style="width: 8%; text-align: center; vertical-align: middle; background: #f1f5f9; color: #475569;">No Opp<br><small class="font-w700">(NO)</small></th>
                                                <th style="width: 20%; vertical-align: middle;">Catatan Terapis</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sector['tasks'] as $tKey => $task)
                                                @php
                                                    $itemVal = $saved_denver_data[$tKey]['score'] ?? (old('denver_data.'.$tKey.'.score', ''));
                                                    $itemNote = $saved_denver_data[$tKey]['catatan'] ?? (old('denver_data.'.$tKey.'.catatan', ''));
                                                @endphp
                                                <tr>
                                                    <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $task['no'] }}</td>
                                                    <td style="vertical-align: middle;">
                                                        <strong class="text-dark" style="font-size: 12.5px;">{{ $task['name'] }}</strong>
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <span class="badge badge-light border font-w600" style="font-size: 11px; color: #475569;">{{ $task['age'] }}</span>
                                                    </td>
                                                    <td class="text-center matrix-cell" style="vertical-align: middle; background: #fbfffd;">
                                                        <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                            <input type="radio" name="denver_data[{{ $tKey }}][score]" value="P" class="denver-radio matrix-input" {{ $itemVal === 'P' ? 'checked' : '' }}>
                                                            <span class="matrix-score-indicator success">P</span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffdfd;">
                                                        <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                            <input type="radio" name="denver_data[{{ $tKey }}][score]" value="F" class="denver-radio matrix-input" {{ $itemVal === 'F' ? 'checked' : '' }}>
                                                            <span class="matrix-score-indicator danger">F</span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center matrix-cell" style="vertical-align: middle; background: #fffefb;">
                                                        <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                            <input type="radio" name="denver_data[{{ $tKey }}][score]" value="R" class="denver-radio matrix-input" {{ $itemVal === 'R' ? 'checked' : '' }}>
                                                            <span class="matrix-score-indicator warning">R</span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center matrix-cell" style="vertical-align: middle; background: #f8fafc;">
                                                        <label class="matrix-radio-label mb-0 py-1 d-block cursor-pointer">
                                                            <input type="radio" name="denver_data[{{ $tKey }}][score]" value="NO" class="denver-radio matrix-input" {{ $itemVal === 'NO' ? 'checked' : '' }}>
                                                            <span class="matrix-score-indicator muted">NO</span>
                                                        </label>
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        <input type="text" name="denver_data[{{ $tKey }}][catatan]" value="{{ $itemNote }}" class="form-control form-control-sm" placeholder="Catatan respon..." style="font-size: 11.5px;">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Catatan Khusus Skala Denver -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Skala Denver / DDST II (Opsional)</label>
                        <textarea name="denver_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait skrining perkembangan Denver II, respon adaptasi anak, stimulasi orang tua..." style="font-size: 12.5px;">{{ old('denver_catatan', $assessment->denver_catatan) }}</textarea>
                    </div>
                        
                    </div>
                </div>
                <!-- Modul 5 Navigation Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 module-nav-footer" style="border-top: 1px solid #edf2f7;">
                    <button type="button" class="btn btn-light font-w600" onclick="goToModule(4)" style="padding: 9px 18px; font-size: 13px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Modul 4
                    </button>
                    <button type="button" class="btn btn-primary font-w600 shadow-sm" onclick="goToModule(6)" style="padding: 9px 20px; font-size: 13px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                        Lanjut ke Modul 6: Rencana Terapi & TTD <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODUL 6: RENCANA TERAPI & TTD -->
            <!-- ======================================================== -->
            <div class="tab-pane fade" id="modul-6" role="tabpanel" aria-labelledby="tab-modul6-btn">

                <!-- Subtest: Subtest 6.1 - Perencanaan Terapi & Modalitas Intervensi -->
                <div class="assessment-subtest-card mb-4" id="subtest-perencanaan">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 6.1</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-notes-medical mr-1 text-primary"></i> Perencanaan Terapi & Modalitas Intervensi
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Penetapan tujuan intervensi klinis, modalitas terapi & frekuensi latihan program</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- Kategori Intervensi Terapi Grid -->
                    <div class="row">
                        <!-- 1. Modalitas Fisik -->
                        <div class="col-lg-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-plug text-primary mr-1"></i> Modalitas Fisik (Elektrofisika & Termal)
                                </label>
                                @php
                                    $saved_modalitas = is_array($assessment->rencana_modalitas_fisik) ? $assessment->rencana_modalitas_fisik : [];
                                    $has_modalitas_lainnya = in_array('Lainnya', $saved_modalitas) || !empty($assessment->rencana_modalitas_lainnya) || !empty(old('rencana_modalitas_lainnya'));
                                    if ($has_modalitas_lainnya && !in_array('Lainnya', $saved_modalitas)) {
                                        $saved_modalitas[] = 'Lainnya';
                                    }
                                    $modalitas_opts = config('assessment.rencana.modalitas_fisik', []);
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($modalitas_opts as $m_opt)
                                        <label class="check-pill-card {{ in_array($m_opt, $saved_modalitas) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_modalitas_fisik[]" value="{{ $m_opt }}" {{ in_array($m_opt, $saved_modalitas) ? 'checked' : '' }}>
                                            <span>{{ $m_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrap_modalitas_lainnya" class="mt-2 {{ $has_modalitas_lainnya ? '' : 'd-none' }}">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-w600 text-primary" style="font-size: 11.5px; background: #edf3fc; border-color: #cbd5e1;">Modalitas Lainnya:</span>
                                        </div>
                                        <input type="text" name="rencana_modalitas_lainnya" id="input_modalitas_lainnya" class="form-control" value="{{ old('rencana_modalitas_lainnya', $assessment->rencana_modalitas_lainnya) }}" placeholder="Contoh: IR (Infra Red), Biofeedback, Cryotherapy, dsb..." style="font-size: 12px; height: 34px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Manual Terapi -->
                        <div class="col-lg-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-hand-paper-o text-primary mr-1"></i> Manual Terapi
                                </label>
                                @php
                                    $saved_manual = is_array($assessment->rencana_manual_terapi) ? $assessment->rencana_manual_terapi : [];
                                    $has_manual_lainnya = in_array('Lainnya', $saved_manual) || !empty($assessment->rencana_manual_lainnya) || !empty(old('rencana_manual_lainnya'));
                                    if ($has_manual_lainnya && !in_array('Lainnya', $saved_manual)) {
                                        $saved_manual[] = 'Lainnya';
                                    }
                                    $manual_opts = config('assessment.rencana.manual_terapi', []);
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($manual_opts as $man_opt)
                                        <label class="check-pill-card {{ in_array($man_opt, $saved_manual) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_manual_terapi[]" value="{{ $man_opt }}" {{ in_array($man_opt, $saved_manual) ? 'checked' : '' }}>
                                            <span>{{ $man_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrap_manual_lainnya" class="mt-2 {{ $has_manual_lainnya ? '' : 'd-none' }}">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-w600 text-primary" style="font-size: 11.5px; background: #edf3fc; border-color: #cbd5e1;">Manual Lainnya:</span>
                                        </div>
                                        <input type="text" name="rencana_manual_lainnya" id="input_manual_lainnya" class="form-control" value="{{ old('rencana_manual_lainnya', $assessment->rencana_manual_lainnya) }}" placeholder="Contoh: Massage terapi khusus, Graston, Cupping, dsb..." style="font-size: 12px; height: 34px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Latihan Terapi -->
                        <div class="col-lg-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-heartbeat text-primary mr-1"></i> Latihan Terapi (Therapeutic Exercise)
                                </label>
                                @php
                                    $saved_latihan = is_array($assessment->rencana_latihan_terapi) ? $assessment->rencana_latihan_terapi : [];
                                    $has_latihan_lainnya = in_array('Lainnya', $saved_latihan) || !empty($assessment->rencana_latihan_lainnya) || !empty(old('rencana_latihan_lainnya'));
                                    if ($has_latihan_lainnya && !in_array('Lainnya', $saved_latihan)) {
                                        $saved_latihan[] = 'Lainnya';
                                    }
                                    $latihan_opts = config('assessment.rencana.latihan_terapi', []);
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($latihan_opts as $lat_opt)
                                        <label class="check-pill-card {{ in_array($lat_opt, $saved_latihan) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_latihan_terapi[]" value="{{ $lat_opt }}" {{ in_array($lat_opt, $saved_latihan) ? 'checked' : '' }}>
                                            <span>{{ $lat_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrap_latihan_lainnya" class="mt-2 {{ $has_latihan_lainnya ? '' : 'd-none' }}">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-w600 text-primary" style="font-size: 11.5px; background: #edf3fc; border-color: #cbd5e1;">Latihan Lainnya:</span>
                                        </div>
                                        <input type="text" name="rencana_latihan_lainnya" id="input_latihan_lainnya" class="form-control" value="{{ old('rencana_latihan_lainnya', $assessment->rencana_latihan_lainnya) }}" placeholder="Contoh: Gait training, Transfer training, Bobath, dsb..." style="font-size: 12px; height: 34px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Edukasi & Konseling -->
                        <div class="col-lg-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-graduation-cap text-primary mr-1"></i> Edukasi, Konseling & Home Program
                                </label>
                                @php
                                    $saved_edukasi = is_array($assessment->rencana_edukasi_konseling) ? $assessment->rencana_edukasi_konseling : [];
                                    $has_edukasi_lainnya = in_array('Lainnya', $saved_edukasi) || !empty($assessment->rencana_edukasi_lainnya) || !empty(old('rencana_edukasi_lainnya'));
                                    if ($has_edukasi_lainnya && !in_array('Lainnya', $saved_edukasi)) {
                                        $saved_edukasi[] = 'Lainnya';
                                    }
                                    $edukasi_opts = config('assessment.rencana.edukasi_konseling', []);
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($edukasi_opts as $ed_opt)
                                        <label class="check-pill-card {{ in_array($ed_opt, $saved_edukasi) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_edukasi_konseling[]" value="{{ $ed_opt }}" {{ in_array($ed_opt, $saved_edukasi) ? 'checked' : '' }}>
                                            <span>{{ $ed_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrap_edukasi_lainnya" class="mt-2 {{ $has_edukasi_lainnya ? '' : 'd-none' }}">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-w600 text-primary" style="font-size: 11.5px; background: #edf3fc; border-color: #cbd5e1;">Edukasi Lainnya:</span>
                                        </div>
                                        <input type="text" name="rencana_edukasi_lainnya" id="input_edukasi_lainnya" class="form-control" value="{{ old('rencana_edukasi_lainnya', $assessment->rencana_edukasi_lainnya) }}" placeholder="Contoh: Konseling psikososial keluarga, Pola tidur anak, dsb..." style="font-size: 12px; height: 34px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program & Pengaturan Dosis Terapi -->
                    <div class="card mb-3 border-0" style="background: #f8fafc; border-radius: 8px;">
                        <div class="card-body p-3">
                            <h6 class="font-w700 text-dark mb-3" style="font-size: 13.5px;">
                                <i class="fa fa-sliders text-primary mr-1"></i> Program & Pengaturan Dosis Terapi
                            </h6>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12 mb-2 mb-lg-0">
                                    <div class="p-2 bg-white rounded border">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Frekuensi Terapi</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="rencana_dosis_frekuensi" class="form-control text-center font-w700" value="{{ old('rencana_dosis_frekuensi', $assessment->rencana_dosis_frekuensi) }}" placeholder="Contoh: 2">
                                            <div class="input-group-append"><span class="input-group-text font-w600" style="font-size: 11px;">x / minggu</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12 mb-2 mb-lg-0">
                                    <div class="p-2 bg-white rounded border">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Durasi per Sesi</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="rencana_dosis_durasi" class="form-control text-center font-w700" value="{{ old('rencana_dosis_durasi', $assessment->rencana_dosis_durasi) }}" placeholder="Contoh: 45">
                                            <div class="input-group-append"><span class="input-group-text font-w600" style="font-size: 11px;">Menit</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12 mb-2 mb-lg-0">
                                    <div class="p-2 bg-white rounded border">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Estimasi Total Sesi</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="rencana_dosis_total_sesi" class="form-control text-center font-w700" value="{{ old('rencana_dosis_total_sesi', $assessment->rencana_dosis_total_sesi) }}" placeholder="Contoh: 8 - 12 Sesi">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="p-2 bg-white rounded border">
                                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12px;">Jadwal Re-assessment</label>
                                        <input type="text" name="rencana_dosis_reassessment" class="form-control form-control-sm text-center font-w700" value="{{ old('rencana_dosis_reassessment', $assessment->rencana_dosis_reassessment) }}" placeholder="Contoh: Evaluasi Sesi ke-4" style="font-size: 12px; height: 31px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                </div>

                <!-- Subtest: Subtest 6.2 - Kesimpulan Klinis, Rekomendasi & Konfirmasi Terapis -->
                <div class="assessment-subtest-card mb-4" id="subtest-evaluasi">
                    <div class="subtest-header d-flex align-items-center justify-content-between flex-wrap p-3" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px 8px 0 0; border-top: 1px solid #dbeafe; border-right: 1px solid #dbeafe; gap: 8px;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary mr-2" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; background: #2563eb;">Subtest 6.2</span>
                            <h5 class="font-w700 mb-0" style="font-size: 15px; color: #1e40af;">
                                <i class="fa-solid fa-signature mr-1 text-primary"></i> Kesimpulan Klinis, Rekomendasi & Konfirmasi Terapis
                            </h5>
                        </div>
                        <small class="text-muted font-w600">Ringkasan evaluasi menyeluruh, target program lanjutan, Home Exercise & verifikasi terapis</small>
                    </div>
                    <div class="p-3 p-md-4 bg-white border" style="border-top: none !important; border-radius: 0 0 8px 8px; border-color: #e2e8f0 !important;">
                        <!-- Kesimpulan & Target Program Bebas -->
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13.5px;">
                                    <i class="fa fa-file-text-o text-primary mr-1"></i> Kesimpulan & Evaluasi Klinis Terapis
                                </label>
                                <textarea name="kesimpulan" class="form-control" rows="7" placeholder="Ringkasan hasil evaluasi asesmen klinis menyeluruh, temuan utama fisioterapi/terapi okupasi/wicara..." style="font-size: 13.5px; min-height: 160px; line-height: 1.6;">{{ old('kesimpulan', $assessment->kesimpulan) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13.5px;">
                                    <i class="fa fa-calendar-check-o text-primary mr-1"></i> Rencana Program Terapi Lanjutan & Target
                                </label>
                                <textarea name="rencana_terapi" class="form-control" rows="7" placeholder="Target jangka pendek & panjang, panduan latihan mandiri di rumah (Home Exercise Program), jadwal supervisi lanjutan..." style="font-size: 13.5px; min-height: 160px; line-height: 1.6;">{{ old('rencana_terapi', $assessment->rencana_terapi) }}</textarea>
                            </div>
                        </div>
                    </div>
                        
                    <!-- Konfirmasi Verifikasi Terapis -->
                    <div class="mt-4 p-3 rounded" style="background: #eff6ff; border: 1px solid #bfdbfe;">
                        <div class="row align-items-center">
                            <div class="col-md-7 col-12 mb-2 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 10px; background: #ffffff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 18px; flex-shrink: 0;">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                    <div>
                                        <strong style="color: #1e40af; font-size: 13.5px;" class="d-block">Konfirmasi & Tanda Tangan Terapis Pemeriksa</strong>
                                        <small class="text-muted">Asesmen klinis akan divalidasi dan tersimpan di riwayat rekam medis pasien.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-12 text-md-right">
                                <span class="badge font-w700 mr-2" style="font-size: 12px; padding: 6px 12px; border-radius: 6px; background: #ffffff; color: #1e40af; border: 1px solid #bfdbfe;">
                                    <i class="fa-solid fa-user-check mr-1 text-primary"></i> {{ $rekam->dokter->nama ?? auth()->user()->name }}
                                </span>
                                <small class="text-muted d-block mt-1">Tanggal: <strong>{{ $assessment->tgl_assessment ? $assessment->tgl_assessment->format('d/m/Y') : date('d/m/Y') }}</strong></small>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Modul 6 Navigation Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 module-nav-footer" style="border-top: 1px solid #edf2f7;">
                    <button type="button" class="btn btn-light font-w600" onclick="goToModule(5)" style="padding: 9px 18px; font-size: 13px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569;">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Modul 5: Instrumen Khusus (GMFM & Denver)
                    </button>
                    <small class="text-muted font-w600">
                        <i class="fa-solid fa-check-double text-success mr-1"></i> Modul Terakhir (Simpan data melalui tombol di bawah)
                    </small>
                </div>
            </div>
            </div>
        </div>

        <!-- Card Footer Note -->
        <div class="card-footer py-3 px-4 d-flex align-items-center justify-content-between flex-wrap" style="background: #fafbfd; border-top: 1px solid #edf2f7; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; gap: 8px;">
            <div class="text-muted font-w500" style="font-size: 12.5px;">
                <i class="fa-solid fa-lock text-success mr-1"></i> Seluruh data asesmen tersimpan langsung ke rekam medis penerima manfaat.
            </div>
            <small class="text-muted font-w500">
                <i class="fa-solid fa-shield-halved text-primary mr-1"></i> Terenkripsi & Validasi Rekam Medis Digital
            </small>
        </div>
    </div>


    <!-- Floating Sticky Bottom Action Bar (Selalu Terlihat di Layar) -->
    <div class="assessment-sticky-action-bar mb-4" style="position: sticky; bottom: 15px; z-index: 1040; background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(12px); border: 1px solid #cbd5e1; border-radius: 12px; box-shadow: 0 8px 30px rgba(37, 99, 235, 0.12); padding: 12px 20px;">
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
            <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                <span class="badge font-w700" style="font-size: 12px; padding: 6px 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-list-check mr-1 text-primary"></i> Progress: <span class="sticky-progress-percent text-primary font-w700">0%</span>
                </span>
                <span class="badge font-w700" id="stickyModuleBadge" style="font-size: 12px; padding: 6px 12px; border-radius: 6px; background: #f8fafc; color: #475569; border: 1px solid #cbd5e1;">
                    <i class="fa-solid fa-layer-group mr-1 text-primary"></i> Modul <span id="stickyCurrentModuleNumber">1</span> dari 6
                </span>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <button type="button" class="btn btn-sm btn-light font-w600" id="stickyBtnPrevModul" onclick="stepModule(-1)" style="padding: 8px 14px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;" title="Modul Sebelumnya" disabled>
                    <i class="fa-solid fa-chevron-left mr-1"></i> Prev Modul
                </button>
                <button type="button" class="btn btn-sm btn-light font-w600" id="stickyBtnNextModul" onclick="stepModule(1)" style="padding: 8px 14px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;" title="Modul Berikutnya">
                    Next Modul <i class="fa-solid fa-chevron-right ml-1"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light font-w600" onclick="$('html, body').animate({scrollTop: 0}, 250)" style="padding: 8px 14px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;" title="Ke Atas">
                    <i class="fa-solid fa-arrow-up"></i>
                </button>
                <a href="{{Route('rekam.detail', $pasien->id)}}" class="btn btn-sm btn-light font-w600" style="padding: 8px 16px; font-size: 12.5px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569;">
                    Batal
                </a>
                <button type="submit" name="action" value="save" class="btn btn-sm btn-primary font-w700 shadow-sm" style="padding: 8px 22px; font-size: 12.5px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan
                </button>
                <button type="submit" name="action" value="save_and_print" class="btn btn-sm btn-success font-w700 text-white shadow-sm" style="padding: 8px 20px; font-size: 12.5px; border-radius: 8px; background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                    <i class="fa-solid fa-print mr-1"></i> Simpan & Cetak
                </button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('style')
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

.assessment-modul-grid-tabs .nav-link .tab-mod-icon {
    font-size: 15px !important;
    color: #2563eb !important;
    transition: transform 0.2s ease !important;
}

.assessment-modul-grid-tabs .nav-link:hover {
    background: #eff6ff !important;
    color: #1d4ed8 !important;
    border-color: #93c5fd !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 3px 8px rgba(37, 99, 235, 0.1) !important;
}

.assessment-modul-grid-tabs .nav-link:hover .tab-mod-icon {
    transform: scale(1.1) !important;
}

.assessment-modul-grid-tabs .nav-link.active {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
    border-color: #2563eb !important;
    border-left: 4px solid #2563eb !important;
    color: #1e40af !important;
    font-weight: 700 !important;
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.15) !important;
}

.assessment-modul-grid-tabs .nav-link.active .tab-mod-icon {
    color: #1d4ed8 !important;
}

.assessment-modul-grid-tabs .nav-link .counter-pill {
    font-size: 11px !important;
    padding: 3px 8px !important;
    border-radius: 9999px !important;
    background: #ffffff !important;
    color: #475569 !important;
    font-weight: 700 !important;
    flex-shrink: 0 !important;
    border: 1px solid #cbd5e1 !important;
    transition: all 0.2s ease !important;
}

.assessment-modul-grid-tabs .nav-link:hover .counter-pill {
    background: #ffffff !important;
    color: #1d4ed8 !important;
    border-color: #93c5fd !important;
}

.assessment-modul-grid-tabs .nav-link.active .counter-pill {
    background: #2563eb !important;
    color: #ffffff !important;
    border-color: #1d4ed8 !important;
    box-shadow: 0 2px 5px rgba(37, 99, 235, 0.3) !important;
}

/* Subtest Card Styling */
.assessment-subtest-card {
    transition: all 0.2s ease;
}
.assessment-subtest-card .subtest-header {
    transition: all 0.2s ease;
}

/* Radio & Checkbox Card Pills - Sesuai Standar Penerima Manfaat Baru */
.radio-pill-card, .check-pill-card {
    display: inline-flex;
    align-items: center;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    padding: 7px 16px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    background: #ffffff;
    color: #334155;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    user-select: none;
    margin-bottom: 0;
    position: relative;
}

.radio-pill-card:hover, .check-pill-card:hover {
    background: #f8fafc;
    border-color: #93c5fd;
    color: #1e40af;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1);
}

/* Custom Styled Radio */
.radio-pill-card input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 17px;
    height: 17px;
    min-width: 17px;
    border: 1.8px solid #94a3b8;
    border-radius: 50%;
    outline: none;
    cursor: pointer;
    margin: 0 9px 0 0;
    background-color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
    transition: all 0.15s ease;
    position: relative;
    flex-shrink: 0;
}

.radio-pill-card:hover input[type="radio"] {
    border-color: #2563eb;
}

.radio-pill-card input[type="radio"]:checked {
    border-color: #2563eb !important;
    background-color: #2563eb !important;
    box-shadow: inset 0 0 0 3.5px #ffffff !important;
}

.radio-pill-card.active,
.radio-pill-card:has(input:checked) {
    background: #eff6ff !important;
    border-color: #2563eb !important;
    color: #1e40af !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.14) !important;
}

/* Custom Styled Checkbox - IDENTIK DENGAN PENERIMA MANFAAT BARU */
.check-pill-card input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 17px;
    height: 17px;
    min-width: 17px;
    border: 1.8px solid #94a3b8;
    border-radius: 4px;
    outline: none;
    cursor: pointer;
    margin: 0 9px 0 0;
    background-color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
    transition: all 0.15s ease;
    position: relative;
    flex-shrink: 0;
}

.check-pill-card:hover input[type="checkbox"] {
    border-color: #2563eb;
}

.check-pill-card input[type="checkbox"]:checked {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
}

/* Custom Crisp White Checkmark inside the Blue Box */
.check-pill-card input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    width: 5px;
    height: 9px;
    border: solid #ffffff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    top: 1px;
    left: 4.5px;
}

.check-pill-card.active,
.check-pill-card:has(input:checked) {
    background: #eff6ff !important;
    border-color: #2563eb !important;
    color: #1e40af !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.14) !important;
}

/* Bootstrap custom-checkbox enhancement */
.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
}

/* Global Textarea & Notes Enhancement */
#formAssessment textarea.form-control {
    font-size: 13px !important;
    line-height: 1.6 !important;
    border-radius: 8px !important;
    border: 1.5px solid #cbd5e1 !important;
    padding: 10px 14px !important;
    min-height: 85px;
    transition: all 0.2s ease !important;
    background-color: #ffffff !important;
    color: #1e293b !important;
}

#formAssessment textarea.form-control:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
    background-color: #ffffff !important;
}

#formAssessment textarea.form-control::placeholder {
    color: #94a3b8 !important;
    font-size: 12.5px !important;
}

.assessment-box {
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.assessment-box:hover {
    border-color: #cbd5e1 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

/* Pain Scale Buttons */
.pain-scale-btn {
    transition: all 0.15s ease;
    font-weight: 600;
}
.pain-scale-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}
.pain-scale-btn.active {
    transform: scale(1.08);
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    outline: 2.5px solid #2563eb;
}

/* Matrix table styling */
.matrix-grid-table th {
    background: #f1f5f9;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
    vertical-align: middle;
}

.matrix-grid-table td {
    vertical-align: middle;
    font-size: 12.5px;
}

.matrix-grid-table tbody tr:hover {
    background-color: #f8fafc;
}

/* GMFM Matrix Buttons */
.gmfm-score-btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s ease;
}

.gmfm-score-btn:hover {
    border-color: #2563eb;
    color: #2563eb;
    background: #eff6ff;
}

.gmfm-score-btn.active {
    background: #2563eb !important;
    color: #ffffff !important;
    border-color: #2563eb !important;
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
}

.gmfm-score-btn.score-0.active { background: #64748b !important; border-color: #64748b !important; }
.gmfm-score-btn.score-1.active { background: #f59e0b !important; border-color: #f59e0b !important; }
.gmfm-score-btn.score-2.active { background: #3b82f6 !important; border-color: #3b82f6 !important; }
.gmfm-score-btn.score-3.active { background: #10b981 !important; border-color: #10b981 !important; }

/* Sticky bottom action bar shadow */
.assessment-sticky-action-bar {
    transition: all 0.25s ease;
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

/* GMFM Dimension Score Summary Card (Light Blue Medis Sesuai Header) */
.gmfm-dim-score-card {
    background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%) !important;
    border: 1px solid #bfdbfe !important;
    border-left: 4px solid #2563eb !important;
    border-radius: 10px !important;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.05) !important;
    color: #1e293b !important;
}

/* Denver DDST II Interactive Badges */
.denver-badge-opt {
    cursor: pointer;
    user-select: none;
    transition: all 0.15s ease;
    border: 1px solid #cbd5e1;
    opacity: 0.65;
}
.denver-badge-opt:hover {
    opacity: 0.9;
    transform: scale(1.05);
}
.denver-badge-opt.active {
    opacity: 1 !important;
    transform: scale(1.1);
    box-shadow: 0 2px 6px rgba(0,0,0,0.18);
    font-weight: 800 !important;
}
</style>
@endsection

@section('script')
<script>
var currentModule = 1;
var totalModules = 6;
var draftStorageKey = 'omahterapi_draft_assessment_' + {{ $rekam->id }};
var autoSaveTimer = null;

// Module to Subtests Mapping
var moduleSubtests = {
    1: ['subtest-penglihatan', 'subtest-psikososial'],
    2: ['subtest-motorik', 'subtest-adl', 'subtest-wicara'],
    3: ['subtest-nyeri', 'subtest-rom'],
    4: ['subtest-neuro', 'subtest-postur', 'subtest-gait', 'subtest-sensoris'],
    5: ['subtest-gmfm', 'subtest-denver'],
    6: ['subtest-perencanaan', 'subtest-evaluasi']
};

function goToModule(moduleIndex) {
    if (moduleIndex < 1 || moduleIndex > totalModules) return;
    currentModule = moduleIndex;

    // Trigger tab activation
    $('#tab-modul' + moduleIndex + '-btn').tab('show');

    // Update Sticky Module Counter & Buttons
    $('#stickyCurrentModuleNumber').text(moduleIndex);
    $('#stickyBtnPrevModul').prop('disabled', moduleIndex === 1);
    $('#stickyBtnNextModul').prop('disabled', moduleIndex === totalModules);

    // Scroll to top of main card smoothly
    $('html, body').animate({
        scrollTop: $('#formAssessment').offset().top - 80
    }, 250);
}

function stepModule(direction) {
    goToModule(currentModule + direction);
}

// ----------------------------------------------------
// SUBTEST FILL STATUS CHECKER
// ----------------------------------------------------
function isSubtestFilled(subtestId) {
    var pane = $('#' + subtestId);
    if (!pane.length) return false;

    // Check GMFM specifically
    if (subtestId === 'subtest-gmfm') {
        return pane.find('.gmfm-a-radio:checked, .gmfm-b-radio:checked, .gmfm-c-radio:checked, .gmfm-d-radio:checked, .gmfm-e-radio:checked').length > 0;
    }
    // Check Denver specifically
    if (subtestId === 'subtest-denver') {
        return pane.find('.denver-radio:checked').length > 0;
    }
    // Check Nyeri & Body Chart specifically
    if (subtestId === 'subtest-nyeri') {
        if ($('#input_nyeri_body_chart').val() || $('#input-score-istirahat').val() || $('#input-score-aktivitas').val()) {
            return true;
        }
    }

    // Generic check for inputs/textareas/radios/checkboxes
    var hasChecked = pane.find('input[type="radio"]:checked, input[type="checkbox"]:checked').length > 0;
    if (hasChecked) return true;

    var hasText = false;
    pane.find('textarea, select, input[type="text"]:not(#input_nyeri_body_chart)').each(function() {
        if ($(this).val() && $(this).val().trim() !== '') {
            hasText = true;
            return false;
        }
    });
    return hasText;
}

function updateFormOverallProgress() {
    var totalSubtests = 15;
    var filledSubtestsCount = 0;
    var filledModulesCount = 0;

    for (var m = 1; m <= totalModules; m++) {
        var subtests = moduleSubtests[m];
        var moduleFilledCount = 0;
        
        subtests.forEach(function(sId) {
            if (isSubtestFilled(sId)) {
                moduleFilledCount++;
                filledSubtestsCount++;
            }
        });

        // Update Module Tab Badge
        $('#badge-modul-' + m).text(moduleFilledCount + '/' + subtests.length);
        if (moduleFilledCount === subtests.length) {
            $('#badge-modul-' + m).removeClass('badge-light').addClass('badge-success text-white');
        } else {
            $('#badge-modul-' + m).removeClass('badge-success text-white').addClass('badge-light');
        }

        if (moduleFilledCount > 0) {
            filledModulesCount++;
        }
    }

    var pct = Math.round((filledSubtestsCount / totalSubtests) * 100);
    $('#progressPercentText').text(pct + '%');
    $('.sticky-progress-percent').text(pct + '%');
    $('#progressModulesText').text('(' + filledModulesCount + '/' + totalModules + ' Modul Terisi)');
    $('#formOverallProgressBar').css('width', pct + '%').attr('aria-valuenow', pct);
}
// ----------------------------------------------------
// LOCALSTORAGE AUTO-SAVE DRAFT & RESTORE
// ----------------------------------------------------
function saveDraftToLocalStorage() {
    try {
        var formData = {};
        $('#formAssessment').find('input, textarea, select').each(function() {
            var name = $(this).attr('name');
            if (!name || name === '_token') return;

            var type = $(this).attr('type');
            if (type === 'radio') {
                if ($(this).is(':checked')) {
                    formData[name] = $(this).val();
                }
            } else if (type === 'checkbox') {
                if ($(this).is(':checked')) {
                    if (!formData[name]) formData[name] = [];
                    formData[name].push($(this).val());
                }
            } else {
                formData[name] = $(this).val();
            }
        });

        localStorage.setItem(draftStorageKey, JSON.stringify({
            timestamp: new Date().toISOString(),
            data: formData
        }));

        var timeStr = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        $('#draftStatusBadge').html('<i class="fa fa-check-circle text-success mr-1"></i> Draft tersimpan (' + timeStr + ')');
    } catch(e) {
        console.error('Auto-save draft error:', e);
    }
}

function triggerAutoSave() {
    $('#draftStatusBadge').html('<i class="fa fa-spinner fa-spin text-warning mr-1"></i> Menyimpan draft...');
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(function() {
        saveDraftToLocalStorage();
    }, 1200);
}

function checkExistingDraft() {
    try {
        var saved = localStorage.getItem(draftStorageKey);
        if (saved) {
            var parsed = JSON.parse(saved);
            if (parsed && parsed.data) {
                $('#draftRestoreBanner').removeClass('d-none').addClass('d-flex');
            }
        }
    } catch(e) {}
}

function restoreDraftData() {
    try {
        var saved = localStorage.getItem(draftStorageKey);
        if (!saved) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'info', title: 'Tidak Ada Draft', text: 'Tidak ditemukan data draft yang tersimpan di peramban ini.', timer: 2000, showConfirmButton: false });
            } else {
                alert('Tidak ada data draft yang ditemukan.');
            }
            return;
        }
        var parsed = JSON.parse(saved);
        var data = parsed.data;
        if (!data) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'warning', title: 'Draft Kosong', text: 'Data draft yang tersimpan kosong atau tidak valid.', timer: 2000, showConfirmButton: false });
            } else {
                alert('Data draft kosong atau tidak valid.');
            }
            return;
        }

        // 1. Reset all radios and checkboxes first
        $('#formAssessment input[type="checkbox"]').prop('checked', false);
        $('#formAssessment input[type="radio"]').prop('checked', false);
        $('.radio-pill-card, .check-pill-card, .denver-badge-opt').removeClass('active');

        // 2. Iterate and fill form data
        for (var name in data) {
            var val = data[name];
            var elem = $('[name="' + name + '"]');
            if (!elem.length) continue;

            if (elem.is(':radio')) {
                var targetRadio = elem.filter('[value="' + val + '"]');
                if (targetRadio.length) {
                    targetRadio.prop('checked', true);
                    targetRadio.closest('.radio-pill-card').addClass('active');
                }
            } else if (Array.isArray(val)) {
                // Checkbox array
                elem.each(function() {
                    if (val.indexOf($(this).val()) !== -1) {
                        $(this).prop('checked', true);
                        $(this).closest('.check-pill-card').addClass('active');
                    }
                });
            } else if (elem.is(':checkbox')) {
                if (val && val !== '0' && val !== 0) {
                    elem.prop('checked', true);
                    elem.closest('.check-pill-card').addClass('active');
                }
            } else {
                elem.val(val);
            }
        }

        // 3. Update Pain Scale UI buttons
        if (data.nyeri_skala_istirahat !== undefined && data.nyeri_skala_istirahat !== null && data.nyeri_skala_istirahat !== '') {
            var valIst = data.nyeri_skala_istirahat;
            var btnIst = $('.pain-scale-btn[data-target="#input-score-istirahat"][data-val="' + valIst + '"]');
            if (btnIst.length) {
                btnIst.closest('.pain-scale-group').find('.pain-scale-btn').removeClass('active');
                btnIst.addClass('active');
                var bgIst = valIst == 0 ? '#10b981' : (valIst <= 3 ? '#3b82f6' : (valIst <= 6 ? '#f59e0b' : '#ef4444'));
                $('#badge-skala-istirahat').text(valIst + ' / 10').css({ 'background': bgIst, 'color': '#ffffff' });
            }
        }
        if (data.nyeri_skala_aktivitas !== undefined && data.nyeri_skala_aktivitas !== null && data.nyeri_skala_aktivitas !== '') {
            var valAkt = data.nyeri_skala_aktivitas;
            var btnAkt = $('.pain-scale-btn[data-target="#input-score-aktivitas"][data-val="' + valAkt + '"]');
            if (btnAkt.length) {
                btnAkt.closest('.pain-scale-group').find('.pain-scale-btn').removeClass('active');
                btnAkt.addClass('active');
                var bgAkt = valAkt == 0 ? '#10b981' : (valAkt <= 3 ? '#3b82f6' : (valAkt <= 6 ? '#f59e0b' : '#ef4444'));
                $('#badge-skala-aktivitas').text(valAkt + ' / 10').css({ 'background': bgAkt, 'color': '#ffffff' });
            }
        }

        // 4. Restore Denver Badge UI buttons
        $('.denver-radio:checked').each(function() {
            var group = $(this).closest('.denver-btn-group');
            var val = $(this).val();
            group.find('.denver-badge-opt').removeClass('active');
            group.find('.denver-badge-opt[data-val="' + val + '"]').addClass('active');
        });

        // 5. Restore Body Chart Image if present
        if (data.nyeri_body_chart) {
            existingChartData = data.nyeri_body_chart;
            hasLoadedExisting = false;
            loadExistingChartImage();
        }

        // 6. Run calculations
        updateGmfmALiveScore();
        updateGmfmBLiveScore();
        updateGmfmCLiveScore();
        updateGmfmDLiveScore();
        updateGmfmELiveScore();
        updateGmfmTotalScore();
        updateDenverLiveScore();
        togglePerencanaanLainnya();

        // 7. Sync toggle wrappers
        toggleTongkatTeknik($('#alat_tongkat').is(':checked'));
        toggleAlatLainnya($('#alat_lainnya').is(':checked'));
        toggleSifatLainnya($('#check_sifat_lainnya').is(':checked'));
        toggleKoorLainnya($('#check_koor_lainnya').is(':checked'));
        toggleOrganKelainan($('input[name="wicara_organ_bicara"]:checked').val());
        toggleMenelanKeterangan($('input[name="wicara_makan_menelan"]:checked').val());

        // 8. Update overall progress
        updateFormOverallProgress();

        // 9. Hide restore banner & notify user
        $('#draftRestoreBanner').removeClass('d-flex').addClass('d-none');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Draft Dipulihkan!',
                text: 'Seluruh isian asesmen dari penyimpanan lokal berhasil dimuat kembali.',
                timer: 2200,
                showConfirmButton: false
            });
        } else {
            alert('Draft asesmen berhasil dipulihkan!');
        }
    } catch(e) {
        console.error('Draft restore error:', e);
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Gagal Memulihkan Draft', text: e.message });
        } else {
            alert('Gagal memulihkan draft: ' + e.message);
        }
    }
}

function discardDraftData() {
    var proceed = function() {
        localStorage.removeItem(draftStorageKey);
        $('#draftRestoreBanner').removeClass('d-flex').addClass('d-none');
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'info', title: 'Draft Dihapus', text: 'Draft lokal telah dibersihkan.', timer: 1500, showConfirmButton: false });
        }
    };

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Hapus Draft?',
            text: 'Draft lokal akan dihapus permanen dari peramban.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Draft',
            cancelButtonText: 'Batal'
        }).then(function(res) {
            if (res.isConfirmed) {
                proceed();
            }
        });
    } else {
        if (confirm('Hapus draft asesmen yang tersimpan secara lokal?')) {
            proceed();
        }
    }
}

// ----------------------------------------------------
// ACCELERATOR "SET ALL NORMAL" PRESET HANDLERS
// ----------------------------------------------------
function setAllRomNormal() {
    $('#tab-rom input[type="radio"]').each(function() {
        var val = $(this).val();
        if (val === 'Full / Bebas' || val === 'Normal (5/5)' || val === '5' || val === 'Normal') {
            $(this).prop('checked', true).closest('.radio-pill-card').addClass('active');
        }
    });
    $('#tab-rom select').each(function() {
        var opt = $(this).find('option').filter(function() {
            var t = $(this).text().toLowerCase();
            return t.indexOf('normal') !== -1 || t.indexOf('5/5') !== -1 || t.indexOf('full') !== -1;
        });
        if (opt.length > 0) {
            $(this).val(opt.val());
        }
    });
    updateFormOverallProgress();
    triggerAutoSave();
}

function setAllNeuroNormal() {
    $('#tab-neuro input[type="radio"]').each(function() {
        var val = $(this).val();
        if (val === 'Normal (++)' || val === 'Negatif (-)' || val === 'Normal (Eutoni)' || val === 'Negatif' || val === 'Normal') {
            $(this).prop('checked', true).closest('.radio-pill-card').addClass('active');
        }
    });
    updateFormOverallProgress();
    triggerAutoSave();
}

function setAllGaitNormal() {
    $('#tab-gait input[type="radio"]').each(function() {
        var val = $(this).val();
        if (val === 'Normal' || val === 'Lengkap (Heel strike s/d Push-off)' || val === 'Mandiri Tanpa Alat Bantu' || val === 'Baik (Stabil)') {
            $(this).prop('checked', true).closest('.radio-pill-card').addClass('active');
        }
    });
    updateFormOverallProgress();
    triggerAutoSave();
}

function setAllSensorisNormal() {
    $('#tab-sensoris input[type="radio"]').each(function() {
        var val = $(this).val();
        if (val === 'Normal' || val === 'Negatif' || val === 'Responsif') {
            $(this).prop('checked', true).closest('.radio-pill-card').addClass('active');
        }
    });
    updateFormOverallProgress();
    triggerAutoSave();
}

// ----------------------------------------------------
// BODY CHART CANVAS LOGIC (Interactive & Persistent)
// ----------------------------------------------------
var canvas = document.getElementById('bodyChartCanvas');
var ctx = canvas ? canvas.getContext('2d') : null;
var bodyImg = new Image();
bodyImg.src = "{{ asset('images/body.png') }}";

var currentSymbol = '~';
var currentColor = '#dc2626';
var markers = []; // Array of {x, y, symbol, color}
var existingChartData = @json(old('nyeri_body_chart', $assessment->nyeri_body_chart));
var hasLoadedExisting = false;

bodyImg.onload = function() {
    if (existingChartData && existingChartData.indexOf('data:image') === 0 && !hasLoadedExisting) {
        loadExistingChartImage();
    } else {
        drawBodyChart();
    }
};

function loadExistingChartImage() {
    if (!existingChartData || !ctx) return;
    var savedImg = new Image();
    savedImg.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(savedImg, 0, 0, canvas.width, canvas.height);
        $('#input_nyeri_body_chart').val(existingChartData);
        hasLoadedExisting = true;
    };
    savedImg.src = existingChartData;
}

function drawBodyChart() {
    if (!ctx || !canvas) return;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Fill white background for clean PNG export
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Draw background anatomy image centered
    if (bodyImg.complete && bodyImg.naturalWidth > 0) {
        var hRatio = canvas.width / bodyImg.naturalWidth;
        var vRatio = canvas.height / bodyImg.naturalHeight;
        var ratio  = Math.min(hRatio, vRatio);
        var centerShift_x = (canvas.width - bodyImg.naturalWidth * ratio) / 2;
        var centerShift_y = (canvas.height - bodyImg.naturalHeight * ratio) / 2;
        
        ctx.drawImage(bodyImg, 0, 0, bodyImg.naturalWidth, bodyImg.naturalHeight,
                      centerShift_x, centerShift_y, bodyImg.naturalWidth * ratio, bodyImg.naturalHeight * ratio);
    }
    
    // Draw all markers with crisp visual badges
    markers.forEach(function(m) {
        ctx.save();
        
        // Circular white badge with drop shadow
        ctx.shadowColor = 'rgba(0, 0, 0, 0.28)';
        ctx.shadowBlur = 4;
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 2;
        
        ctx.beginPath();
        ctx.arc(m.x, m.y, 12, 0, 2 * Math.PI);
        ctx.fillStyle = '#ffffff';
        ctx.fill();
        
        // Border ring in symbol color
        ctx.shadowColor = 'transparent';
        ctx.lineWidth = 2;
        ctx.strokeStyle = m.color;
        ctx.stroke();
        
        // Symbol text
        ctx.fillStyle = m.color;
        ctx.font = 'bold 15px Arial, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(m.symbol, m.x, m.y + 0.5);
        
        ctx.restore();
    });

    // Update hidden input if markers exist
    if (markers.length > 0) {
        $('#input_nyeri_body_chart').val(canvas.toDataURL('image/png'));
    }
}

function addMarkerAt(clientX, clientY) {
    if (!canvas) return;
    var rect = canvas.getBoundingClientRect();
    if (rect.width <= 0 || rect.height <= 0) return;
    
    var scaleX = canvas.width / rect.width;
    var scaleY = canvas.height / rect.height;
    
    var x = (clientX - rect.left) * scaleX;
    var y = (clientY - rect.top) * scaleY;
    
    markers.push({
        x: x,
        y: y,
        symbol: currentSymbol,
        color: currentColor
    });
    
    drawBodyChart();
    updateFormOverallProgress();
    triggerAutoSave();
}

if (canvas) {
    canvas.addEventListener('click', function(e) {
        addMarkerAt(e.clientX, e.clientY);
    });

    // Touch support for tablets / mobile
    canvas.addEventListener('touchend', function(e) {
        if (e.changedTouches && e.changedTouches.length > 0) {
            e.preventDefault();
            var touch = e.changedTouches[0];
            addMarkerAt(touch.clientX, touch.clientY);
        }
    });
}

// ====================================================
// GLOBAL GMFM & DENVER CALCULATION FUNCTIONS
// ====================================================
function updateGmfmALiveScore() {
    var totalScore = 0;
    var answeredCount = 0;
    $('.gmfm-a-radio:checked').each(function() {
        var val = $(this).val();
        if (val !== 'NT' && !isNaN(val)) {
            totalScore += parseInt(val, 10);
            answeredCount++;
        }
    });
    var maxScore = 51;
    var percentage = ((totalScore / maxScore) * 100).toFixed(1);
    $('#gmfm-a-live-total').text(totalScore);
    $('#gmfm-a-live-persen').text(percentage + '%');
    $('#gmfm-a-live-progress').css('width', percentage + '%');
    $('#input-gmfm-a-total').val(totalScore);
    $('#input-gmfm-a-persen').val(percentage);

    var badgeText = 'Belum Dinilai';
    var badgeClass = 'badge-light text-dark';
    if (percentage >= 80) {
        badgeText = 'Sangat Baik (Mandiri)'; badgeClass = 'badge-success text-white';
    } else if (percentage >= 50) {
        badgeText = 'Sedang (Perlu Stimulasi)'; badgeClass = 'badge-info text-white';
    } else if (totalScore > 0 || answeredCount > 0) {
        badgeText = 'Keterbatasan Signifikan'; badgeClass = 'badge-warning text-dark';
    }
    $('#gmfm-a-live-interpretation').text(badgeText).removeClass('badge-light badge-success badge-info badge-warning text-dark text-white').addClass(badgeClass);
    updateGmfmTotalScore();
}

function updateGmfmBLiveScore() {
    var totalScore = 0;
    var answeredCount = 0;
    $('.gmfm-b-radio:checked').each(function() {
        var val = $(this).val();
        if (val !== 'NT' && !isNaN(val)) {
            totalScore += parseInt(val, 10);
            answeredCount++;
        }
    });
    var maxScore = 60;
    var percentage = ((totalScore / maxScore) * 100).toFixed(1);
    $('#gmfm-b-live-total').text(totalScore);
    $('#gmfm-b-live-persen').text(percentage + '%');
    $('#gmfm-b-live-progress').css('width', percentage + '%');
    $('#input-gmfm-b-total').val(totalScore);
    $('#input-gmfm-b-persen').val(percentage);

    var badgeText = 'Belum Dinilai';
    var badgeClass = 'badge-light text-dark';
    if (percentage >= 80) {
        badgeText = 'Sangat Baik (Mandiri)'; badgeClass = 'badge-success text-white';
    } else if (percentage >= 50) {
        badgeText = 'Sedang (Perlu Stimulasi)'; badgeClass = 'badge-info text-white';
    } else if (totalScore > 0 || answeredCount > 0) {
        badgeText = 'Keterbatasan Signifikan'; badgeClass = 'badge-warning text-dark';
    }
    $('#gmfm-b-live-interpretation').text(badgeText).removeClass('badge-light badge-success badge-info badge-warning text-dark text-white').addClass(badgeClass);
    updateGmfmTotalScore();
}

function updateGmfmCLiveScore() {
    var totalScore = 0;
    var answeredCount = 0;
    $('.gmfm-c-radio:checked').each(function() {
        var val = $(this).val();
        if (val !== 'NT' && !isNaN(val)) {
            totalScore += parseInt(val, 10);
            answeredCount++;
        }
    });
    var maxScore = 42;
    var percentage = ((totalScore / maxScore) * 100).toFixed(1);
    $('#gmfm-c-live-total').text(totalScore);
    $('#gmfm-c-live-persen').text(percentage + '%');
    $('#gmfm-c-live-progress').css('width', percentage + '%');
    $('#input-gmfm-c-total').val(totalScore);
    $('#input-gmfm-c-persen').val(percentage);

    var badgeText = 'Belum Dinilai';
    var badgeClass = 'badge-light text-dark';
    if (percentage >= 80) {
        badgeText = 'Sangat Baik (Mandiri)'; badgeClass = 'badge-success text-white';
    } else if (percentage >= 50) {
        badgeText = 'Sedang (Perlu Stimulasi)'; badgeClass = 'badge-info text-white';
    } else if (totalScore > 0 || answeredCount > 0) {
        badgeText = 'Keterbatasan Signifikan'; badgeClass = 'badge-warning text-dark';
    }
    $('#gmfm-c-live-interpretation').text(badgeText).removeClass('badge-light badge-success badge-info badge-warning text-dark text-white').addClass(badgeClass);
    updateGmfmTotalScore();
}

function updateGmfmDLiveScore() {
    var totalScore = 0;
    var answeredCount = 0;
    $('.gmfm-d-radio:checked').each(function() {
        var val = $(this).val();
        if (val !== 'NT' && !isNaN(val)) {
            totalScore += parseInt(val, 10);
            answeredCount++;
        }
    });
    var maxScore = 39;
    var percentage = ((totalScore / maxScore) * 100).toFixed(1);
    $('#gmfm-d-live-total').text(totalScore);
    $('#gmfm-d-live-persen').text(percentage + '%');
    $('#gmfm-d-live-progress').css('width', percentage + '%');
    $('#input-gmfm-d-total').val(totalScore);
    $('#input-gmfm-d-persen').val(percentage);

    var badgeText = 'Belum Dinilai';
    var badgeClass = 'badge-light text-dark';
    if (percentage >= 80) {
        badgeText = 'Sangat Baik (Mandiri)'; badgeClass = 'badge-success text-white';
    } else if (percentage >= 50) {
        badgeText = 'Sedang (Perlu Stimulasi)'; badgeClass = 'badge-info text-white';
    } else if (totalScore > 0 || answeredCount > 0) {
        badgeText = 'Keterbatasan Signifikan'; badgeClass = 'badge-warning text-dark';
    }
    $('#gmfm-d-live-interpretation').text(badgeText).removeClass('badge-light badge-success badge-info badge-warning text-dark text-white').addClass(badgeClass);
    updateGmfmTotalScore();
}

function updateGmfmELiveScore() {
    var totalScore = 0;
    var answeredCount = 0;
    $('.gmfm-e-radio:checked').each(function() {
        var val = $(this).val();
        if (val !== 'NT' && !isNaN(val)) {
            totalScore += parseInt(val, 10);
            answeredCount++;
        }
    });
    var maxScore = 72;
    var percentage = ((totalScore / maxScore) * 100).toFixed(1);
    $('#gmfm-e-live-total').text(totalScore);
    $('#gmfm-e-live-persen').text(percentage + '%');
    $('#gmfm-e-live-progress').css('width', percentage + '%');
    $('#input-gmfm-e-total').val(totalScore);
    $('#input-gmfm-e-persen').val(percentage);

    var badgeText = 'Belum Dinilai';
    var badgeClass = 'badge-light text-dark';
    if (percentage >= 80) {
        badgeText = 'Sangat Baik (Mandiri)'; badgeClass = 'badge-success text-white';
    } else if (percentage >= 50) {
        badgeText = 'Sedang (Perlu Stimulasi)'; badgeClass = 'badge-info text-white';
    } else if (totalScore > 0 || answeredCount > 0) {
        badgeText = 'Keterbatasan Signifikan'; badgeClass = 'badge-warning text-dark';
    }
    $('#gmfm-e-live-interpretation').text(badgeText).removeClass('badge-light badge-success badge-info badge-warning text-dark text-white').addClass(badgeClass);
    updateGmfmTotalScore();
}

function updateGmfmTotalScore() {
    var aTot = parseInt($('#input-gmfm-a-total').val() || 0, 10);
    var bTot = parseInt($('#input-gmfm-b-total').val() || 0, 10);
    var cTot = parseInt($('#input-gmfm-c-total').val() || 0, 10);
    var dTot = parseInt($('#input-gmfm-d-total').val() || 0, 10);
    var eTot = parseInt($('#input-gmfm-e-total').val() || 0, 10);

    var aPct = parseFloat($('#input-gmfm-a-persen').val() || 0);
    var bPct = parseFloat($('#input-gmfm-b-persen').val() || 0);
    var cPct = parseFloat($('#input-gmfm-c-persen').val() || 0);
    var dPct = parseFloat($('#input-gmfm-d-persen').val() || 0);
    var ePct = parseFloat($('#input-gmfm-e-persen').val() || 0);

    var totalScore = aTot + bTot + cTot + dTot + eTot;
    var avgPct = ((aPct + bPct + cPct + dPct + ePct) / 5).toFixed(1);

    $('#gmfm-total-live-badge-score').text(totalScore + ' / 264');
    $('#gmfm-total-live-badge-persen').text(avgPct + '%');
    $('#input-gmfm-total-score').val(totalScore);
    $('#input-gmfm-total-persen').val(avgPct);
}

function updateDenverLiveScore() {
    var pCount = 0;
    var fCount = 0;
    var rCount = 0;
    var noCount = 0;

    $('.denver-radio:checked').each(function() {
        var val = $(this).val();
        if (val === 'P') pCount++;
        else if (val === 'F') fCount++;
        else if (val === 'R') rCount++;
        else if (val === 'NO') noCount++;
    });

    $('#denver-live-p').text(pCount);
    $('#denver-live-f').text(fCount);
    $('#denver-live-r').text(rCount);
    $('#denver-live-no').text(noCount);

    $('#input-denver-pass').val(pCount);
    $('#input-denver-fail').val(fCount);
    $('#input-denver-refusal').val(rCount);
    $('#input-denver-no').val(noCount);

    var totalTested = pCount + fCount + rCount + noCount;
    var kesimpulan = 'Belum Dinilai';
    var desc = 'Pilih status task (P/F/R/NO) di bawah untuk memicu kalkulasi.';
    var badgeStyle = 'background: #e2e8f0; color: #1e293b;';

    if (totalTested > 0) {
        if (rCount >= 2) {
            kesimpulan = 'Untestable (Menolak Pengujian)';
            desc = 'Anak menolak ≥2 pengujian. Disarankan uji ulang saat anak lebih tenang/kooperatif.';
            badgeStyle = 'background: #475569; color: white;';
        } else if (fCount >= 3) {
            kesimpulan = 'Keterlambatan Perkembangan';
            desc = 'Ditemukan ≥3 kegagalan task lintas sektor. Direkomendasikan evaluasi diagnostik & program terapi intensif.';
            badgeStyle = 'background: #ef4444; color: white;';
        } else if (fCount >= 1) {
            kesimpulan = 'Suspect (Meragukan)';
            desc = 'Ditemukan 1-2 kegagalan task. Disarankan re-screening ulang dalam 1–2 minggu atau stimulasi terarah.';
            badgeStyle = 'background: #f59e0b; color: white;';
        } else if (pCount > 0) {
            kesimpulan = 'Normal (Sesuai Usia)';
            desc = 'Semua task perkembangan tercapai dengan baik sesuai kelompok usia anak.';
            badgeStyle = 'background: #10b981; color: white;';
        }
    }

    $('#denver-live-badge-kesimpulan').text(kesimpulan).attr('style', 'font-size: 13px; border-radius: 6px; ' + badgeStyle);
    $('#denver-live-desc-kesimpulan').text(desc);
    $('#input-denver-kesimpulan').val(kesimpulan);
}

function togglePerencanaanLainnya() {
    var isModalitasLainnya = $('input[name="rencana_modalitas_fisik[]"][value="Lainnya"]').is(':checked');
    if (isModalitasLainnya) {
        $('#wrap_modalitas_lainnya').removeClass('d-none');
    } else {
        $('#wrap_modalitas_lainnya').addClass('d-none');
    }

    var isManualLainnya = $('input[name="rencana_manual_terapi[]"][value="Lainnya"]').is(':checked');
    if (isManualLainnya) {
        $('#wrap_manual_lainnya').removeClass('d-none');
    } else {
        $('#wrap_manual_lainnya').addClass('d-none');
    }

    var isLatihanLainnya = $('input[name="rencana_latihan_terapi[]"][value="Lainnya"]').is(':checked');
    if (isLatihanLainnya) {
        $('#wrap_latihan_lainnya').removeClass('d-none');
    } else {
        $('#wrap_latihan_lainnya').addClass('d-none');
    }

    var isEdukasiLainnya = $('input[name="rencana_edukasi_konseling[]"][value="Lainnya"]').is(':checked');
    if (isEdukasiLainnya) {
        $('#wrap_edukasi_lainnya').removeClass('d-none');
    } else {
        $('#wrap_edukasi_lainnya').addClass('d-none');
    }
}

function toggleOrganKelainan(val) {
    if (val === 'Ada Kelainan') {
        $('#wrap-organ-kelainan').slideDown(150);
    } else {
        $('#wrap-organ-kelainan').slideUp(150);
    }
}

function toggleMenelanKeterangan(val) {
    if (val === 'Mampu dengan Hambatan' || val === 'Tidak Mampu') {
        $('#wrap-menelan-keterangan').slideDown(150);
    } else {
        $('#wrap-menelan-keterangan').slideUp(150);
    }
}

function toggleTongkatTeknik(isChecked) {
    if (isChecked) {
        $('#wrap-teknik-tongkat').slideDown(150);
    } else {
        $('#wrap-teknik-tongkat').slideUp(150);
        $('input[name="penglihatan_teknik_tongkat"]').prop('checked', false).closest('.radio-pill-card').removeClass('active');
    }
}

function toggleAlatLainnya(isChecked) {
    if (isChecked) {
        $('#wrap-alat-lainnya').slideDown(150);
    } else {
        $('#wrap-alat-lainnya').slideUp(150);
    }
}

function toggleSifatLainnya(isChecked) {
    if (isChecked) {
        $('#wrap-sifat-lainnya').slideDown(150);
    } else {
        $('#wrap-sifat-lainnya').slideUp(150);
    }
}

function toggleKoorLainnya(isChecked) {
    if (isChecked) {
        $('#wrap-koor-lainnya').slideDown(150);
    } else {
        $('#wrap-koor-lainnya').slideUp(150);
    }
}

// ----------------------------------------------------
// DOCUMENT READY INITIALIZATION
// ----------------------------------------------------
$(document).ready(function() {
    // 1. Module Underline Tabs Navigation
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var modIdx = parseInt($(e.target).data('module-index')) || 1;
        currentModule = modIdx;
        $('#stickyCurrentModuleNumber').text(modIdx);
        $('#stickyBtnPrevModul').prop('disabled', modIdx === 1);
        $('#stickyBtnNextModul').prop('disabled', modIdx === totalModules);
        updateFormOverallProgress();

        if (modIdx === 3) {
            setTimeout(function() {
                if (markers.length > 0 || !existingChartData) {
                    drawBodyChart();
                }
            }, 100);
        }
    });

    // 2. Set All Normal Accelerator Buttons
    $(document).on('click', '.btn-preset-rom-normal', function() {
        setAllRomNormal();
    });
    $(document).on('click', '.btn-preset-neuro-normal', function() {
        setAllNeuroNormal();
    });
    $(document).on('click', '.btn-preset-gait-normal', function() {
        setAllGaitNormal();
    });
    $(document).on('click', '.btn-preset-sensoris-normal', function() {
        setAllSensorisNormal();
    });

    // 3. Draft Restore & Discard Handlers
    $(document).on('click', '#btnRestoreDraft', function() {
        restoreDraftData();
    });
    $(document).on('click', '#btnDiscardDraft', function() {
        discardDraftData();
    });

    // 4. Symbol Picker Selection
    $(document).on('click', '.symbol-btn', function() {
        $('.symbol-btn').each(function() {
            var col = $(this).data('color');
            $(this).removeClass('active').css({
                'background': '#ffffff',
                'color': col
            });
        });
        
        var sym = $(this).data('symbol');
        var col = $(this).data('color');
        currentSymbol = sym;
        currentColor = col;
        
        $(this).addClass('active').css({
            'background': col,
            'color': '#ffffff'
        });
    });

    // 5. Clear Body Chart Button
    $(document).on('click', '#btn-clear-body-chart', function() {
        var clearAction = function() {
            markers = [];
            existingChartData = null;
            $('#input_nyeri_body_chart').val('');
            drawBodyChart();
            updateFormOverallProgress();
            triggerAutoSave();
        };

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Bersihkan Gambar Tubuh?',
                text: 'Semua tanda simbol pada gambar tubuh akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Bersihkan',
                cancelButtonText: 'Batal'
            }).then(function(res) {
                if (res.isConfirmed) {
                    clearAction();
                }
            });
        } else {
            if (confirm('Bersihkan semua tanda pada gambar tubuh?')) {
                clearAction();
            }
        }
    });

    // 6. Undo Body Chart Button
    $(document).on('click', '#btn-undo-body-chart', function() {
        if (markers.length > 0) {
            markers.pop();
            if (markers.length === 0 && !existingChartData) {
                $('#input_nyeri_body_chart').val('');
            }
            drawBodyChart();
            updateFormOverallProgress();
            triggerAutoSave();
        }
    });

    // 7. Form Submit Sync for Body Chart Canvas & LocalStorage clear
    $('form').on('submit', function() {
        if (canvas && markers.length > 0) {
            drawBodyChart();
            $('#input_nyeri_body_chart').val(canvas.toDataURL('image/png'));
        }
        localStorage.removeItem(draftStorageKey);
    });

    // 8. Pain Scale 0 - 10 Visual Rating Button Handler
    $(document).on('click', '.pain-scale-btn', function() {
        var targetInput = $(this).data('target');
        var targetLabel = $(this).data('label');
        var val = $(this).data('val');
        
        $(this).closest('.pain-scale-group').find('.pain-scale-btn').removeClass('active');
        $(this).addClass('active');
        
        $(targetInput).val(val);
        var bg = val == 0 ? '#10b981' : (val <= 3 ? '#3b82f6' : (val <= 6 ? '#f59e0b' : '#ef4444'));
        $(targetLabel).text(val + ' / 10').css({
            'background': bg,
            'color': '#ffffff'
        });
        updateFormOverallProgress();
        triggerAutoSave();
    });

    // 9. Radio Pill Selection
    $(document).on('change', '.radio-pill-card input[type="radio"]', function() {
        var groupName = this.name;
        if (groupName) {
            $('input[type="radio"]').filter(function() {
                return this.name === groupName;
            }).each(function() {
                if (this.checked) {
                    $(this).closest('.radio-pill-card').addClass('active');
                } else {
                    $(this).closest('.radio-pill-card').removeClass('active');
                }
            });
        }
        updateFormOverallProgress();
        triggerAutoSave();
    });

    $(document).on('click', '.radio-pill-card', function(e) {
        var radio = $(this).find('input[type="radio"]')[0];
        if (radio) {
            if (!radio.checked) {
                radio.checked = true;
                $(radio).trigger('change');
            }
        }
    });

    // 10. Checkbox Pill Selection
    $(document).on('change', '.check-pill-card input[type="checkbox"]', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.check-pill-card').addClass('active');
        } else {
            $(this).closest('.check-pill-card').removeClass('active');
        }
        updateFormOverallProgress();
        triggerAutoSave();
    });

    // 11. Denver Badge Option Buttons
    $(document).on('click', '.denver-badge-opt', function() {
        var val = $(this).data('val');
        var group = $(this).closest('.denver-btn-group');
        group.find('.denver-badge-opt').removeClass('active');
        $(this).addClass('active');
        var radio = group.find('input[type="radio"][value="' + val + '"]');
        radio.prop('checked', true).trigger('change');
    });

    // 12. Form inputs change trigger auto-save & progress update
    $(document).on('input change', '#formAssessment input, #formAssessment textarea, #formAssessment select', function() {
        updateFormOverallProgress();
        triggerAutoSave();
    });

    // 13. GMFM Sub-Dimension Switcher
    $(document).on('click', '.gmfm-dim-btn', function(e) {
        e.preventDefault();
        var targetPane = $(this).data('target-dim');
        $('.gmfm-dim-btn').removeClass('active');
        $(this).addClass('active');
        $('.gmfm-dim-pane').hide();
        $(targetPane).fadeIn(150);
    });

    // 14. Event listeners for GMFM
    $(document).on('change', '.gmfm-a-radio', updateGmfmALiveScore);
    $(document).on('change', '.gmfm-b-radio', updateGmfmBLiveScore);
    $(document).on('change', '.gmfm-c-radio', updateGmfmCLiveScore);
    $(document).on('change', '.gmfm-d-radio', updateGmfmDLiveScore);
    $(document).on('change', '.gmfm-e-radio', updateGmfmELiveScore);

    // 15. Event listeners for Denver
    $(document).on('change', '.denver-radio', updateDenverLiveScore);

    // 16. Event listeners for Perencanaan Terapi
    $(document).on('change', 'input[name="rencana_modalitas_fisik[]"], input[name="rencana_manual_terapi[]"], input[name="rencana_latihan_terapi[]"], input[name="rencana_edukasi_konseling[]"]', togglePerencanaanLainnya);
    togglePerencanaanLainnya();

    // 17. Initial calculations on load
    updateGmfmALiveScore();
    updateGmfmBLiveScore();
    updateGmfmCLiveScore();
    updateGmfmDLiveScore();
    updateGmfmELiveScore();
    updateDenverLiveScore();
    updateFormOverallProgress();
    checkExistingDraft();
});
</script>

@endsection

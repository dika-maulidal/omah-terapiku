@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap" style="gap: 10px;">
    <div>
        <h2 class="font-w700 text-primary mb-1" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 21px;">
            <i class="fa fa-clipboard-check text-primary mr-2"></i> Form Assessment Terapis
        </h2>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 2px; font-size: 12px;">
            <li class="breadcrumb-item"><a href="{{Route('rekam')}}">Rekam Medis</a></li>
            <li class="breadcrumb-item"><a href="{{Route('rekam.detail', $pasien->id)}}">{{ $pasien->nama }}</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Form Assessment</a></li>
        </ol>
    </div>
    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
        @if(isset($riwayatAssessment) && count($riwayatAssessment) > 0)
            <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalRiwayatAssessment" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
                <i class="fa fa-history mr-1"></i> Riwayat Asesmen ({{ count($riwayatAssessment) }})
            </button>
        @endif
        <a href="{{Route('rekam.detail', $pasien->id)}}" class="btn btn-sm btn-light" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Rekam Medis
        </a>
        @if($assessment->exists)
            <a href="{{Route('rekam.assessment.print', $rekam->id)}}" target="_blank" class="btn btn-sm btn-info text-white shadow-sm" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
                <i class="fa fa-print mr-1"></i> Cetak Lembar Asesmen
            </a>
        @endif
    </div>
</div>

<!-- Modal Riwayat Assessment Pasien Sebelumnya -->
@if(isset($riwayatAssessment) && count($riwayatAssessment) > 0)
<div class="modal fade" id="modalRiwayatAssessment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header py-3" style="border-bottom: 1px solid #edf2f7; background: #f8fafc;">
                <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                    <i class="fa fa-history text-primary mr-2"></i> Riwayat Asesmen Pasien Sebelumnya
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="font-size: 12.5px;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Tanggal Asesmen</th>
                                <th>Terapis / Dokter</th>
                                <th>Jenis</th>
                                <th>Evaluasi / Catatan</th>
                                <th style="width: 15%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatAssessment as $k => $hist)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td><strong>{{ $hist->tgl_assessment ? $hist->tgl_assessment->format('d M Y') : '-' }}</strong></td>
                                    <td>{{ $hist->dokter->nama ?? 'Terapis' }}</td>
                                    <td><span class="badge badge-light">{{ $hist->jenis_assessment ?: 'General' }}</span></td>
                                    <td style="max-width: 250px;" class="text-truncate">{{ $hist->kesimpulan ?: '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{Route('rekam.assessment.show', $hist->rekam_id)}}" target="_blank" class="btn btn-xs btn-primary font-w600" style="border-radius: 4px; font-size: 11px;">
                                            Lihat Detail <i class="fa fa-external-link"></i>
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

<!-- Identitas Penerima Manfaat Card -->
<div class="card mb-3" style="border-radius: 10px; border: none; box-shadow: 0 2px 10px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 mb-2 mb-lg-0">
                <div class="d-flex align-items-center">
                    <div class="avatar-box mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #2e4b82 0%, #4a6fa5 100%); color: #fff; font-weight: 700; font-size: 17px; flex-shrink: 0;">
                        {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-w700 mb-0" style="font-size: 15.5px; color: #1e293b;">
                            {{ $pasien->nama }}
                            <span class="badge badge-primary light font-w600 ml-2" style="font-size: 11px;">RM# {{ $pasien->no_rm }}</span>
                        </h4>
                        <div class="text-muted font-w500 mt-1" style="font-size: 12px;">
                            <span><i class="fa fa-user mr-1 text-primary"></i>{{ $pasien->jk ?: '-' }}</span> &bull;
                            <span><i class="fa fa-calendar mr-1 text-primary"></i>{{ $pasien->tgl_lahir ?: '-' }} ({{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age . ' Thn' : '-' }})</span> &bull;
                            <span><i class="fa fa-wheelchair mr-1 text-primary"></i>{{ $pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada' ? $pasien->jenis_disabilitas : 'Umum' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="d-flex justify-content-lg-end align-items-center flex-wrap" style="gap: 12px;">
                    <div class="text-lg-right">
                        <small class="text-muted d-block font-w600" style="font-size: 10.5px; text-transform: uppercase;">Layanan & Tanggal</small>
                        <strong class="text-primary font-w700" style="font-size: 12.5px;">{{ $rekam->layanan_terapi ?: $rekam->poli }}</strong>
                        <small class="text-muted d-block font-w500">{{ $rekam->tgl_rekam }}</small>
                    </div>
                    <div class="pl-3" style="border-left: 2px solid #e2e8f0;">
                        <small class="text-muted d-block font-w600" style="font-size: 10.5px; text-transform: uppercase;">Terapis Pemeriksa</small>
                        <strong class="text-dark font-w700" style="font-size: 12.5px;">{{ $rekam->dokter->nama ?? auth()->user()->name }}</strong>
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

    <!-- Main Card Container with Top Tab Navigation -->
    <div class="card mb-4" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
        <!-- Top Navigasi Bagian Penilaian & Switcher Mode -->
        <div class="card-header p-2 px-3 d-flex align-items-center justify-content-between flex-wrap" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7; gap: 8px;">
            <!-- Tab Links -->
            <ul class="nav nav-pills assessment-tabs flex-wrap mb-0" id="assessmentTab" style="gap: 4px;">
                <li class="nav-item">
                    <a class="nav-link active font-w600" id="tab-motorik-btn" href="#tab-motorik" data-target-section="#tab-motorik">
                        <i class="fa fa-child mr-1"></i> 1. Motorik <span class="badge badge-primary light font-w600 ml-1">6</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-gmfm-btn" href="#tab-gmfm" data-target-section="#tab-gmfm">
                        <i class="fa fa-th-list mr-1"></i> 2. GMFM-88 <span class="badge badge-primary light font-w600 ml-1">88 Item</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-adl-btn" href="#tab-adl" data-target-section="#tab-adl">
                        <i class="fa fa-tasks mr-1"></i> 3. Aktivitas (ADL) <span class="badge badge-primary light font-w600 ml-1">9</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-wicara-btn" href="#tab-wicara" data-target-section="#tab-wicara">
                        <i class="fa fa-comments mr-1"></i> 4. Wicara <span class="badge badge-primary light font-w600 ml-1">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-penglihatan-btn" href="#tab-penglihatan" data-target-section="#tab-penglihatan">
                        <i class="fa fa-eye mr-1"></i> 5. Penglihatan <span class="badge badge-primary light font-w600 ml-1">Netra</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-nyeri-btn" href="#tab-nyeri" data-target-section="#tab-nyeri">
                        <i class="fa fa-heartbeat mr-1"></i> 6. Nyeri & Anatomi <span class="badge badge-primary light font-w600 ml-1">0-10</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-rom-btn" href="#tab-rom" data-target-section="#tab-rom">
                        <i class="fa fa-wheelchair mr-1"></i> 7. ROM & MMT
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-neuro-btn" href="#tab-neuro" data-target-section="#tab-neuro">
                        <i class="fa fa-bolt mr-1"></i> 8. Neurologis <span class="badge badge-primary light font-w600 ml-1">Saraf</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-postur-btn" href="#tab-postur" data-target-section="#tab-postur">
                        <i class="fa fa-male mr-1"></i> 9. Postur & Keseimbangan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-gait-btn" href="#tab-gait" data-target-section="#tab-gait">
                        <i class="fa fa-blind mr-1"></i> 10. Gait (Pola Jalan)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-sensoris-btn" href="#tab-sensoris" data-target-section="#tab-sensoris">
                        <i class="fa fa-hand-paper-o mr-1"></i> 11. Sensoris & Vestibular
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-psikososial-btn" href="#tab-psikososial" data-target-section="#tab-psikososial">
                        <i class="fa fa-users mr-1"></i> 12. Psikososial
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-perencanaan-btn" href="#tab-perencanaan" data-target-section="#tab-perencanaan">
                        <i class="fa fa-calendar-check-o mr-1"></i> 13. Perencanaan Terapi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-evaluasi-btn" href="#tab-evaluasi" data-target-section="#tab-evaluasi">
                        <i class="fa fa-file-text-o mr-1"></i> 14. Evaluasi & Target
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-denver-btn" href="#tab-denver" data-target-section="#tab-denver">
                        <i class="fa fa-graduation-cap mr-1"></i> 15. Skala Denver (DDST II) <span class="badge badge-primary light font-w600 ml-1">19 Task</span>
                    </a>
                </li>
            </ul>

            <!-- Switcher Mode Per Tab vs Tampilkan Semua -->
            <div class="btn-group btn-group-sm" role="group" style="box-shadow: 0 1px 4px rgba(0,0,0,0.05); border-radius: 6px;">
                <button type="button" class="btn btn-primary active font-w600" id="btn-mode-tab" onclick="switchViewMode('tab')" style="padding: 5px 12px; font-size: 11.5px;">
                    <i class="fa fa-columns mr-1"></i> Mode Per Tab
                </button>
                <button type="button" class="btn btn-outline-secondary font-w600" id="btn-mode-all" onclick="switchViewMode('all')" style="padding: 5px 12px; font-size: 11.5px;">
                    <i class="fa fa-bars mr-1"></i> Tampilkan Semua Bagian
                </button>
            </div>
        </div>

        <div class="card-body p-4">
            <div id="assessmentTabContent">

                <!-- 1. BAGIAN KEMAMPUAN MOTORIK -->
                <div class="tab-pane-box" id="tab-motorik">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            1. Kemampuan Motorik
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">1</span>
                            Kemampuan Motorik
                        </h5>
                        <small class="text-muted">Pilih opsi penilaian kemampuan gerak & motorik</small>
                    </div>

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
                                        <label class="radio-pill-card {{ $val4 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $val5 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $val6 == $opt ? 'active' : '' }}>
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

                    <div class="d-flex justify-content-end mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-gmfm-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 2 (GMFM-88) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 2. BAGIAN GMFM-88 TERPADU (DIMENSI A s/d E) -->
                <div class="tab-pane-box" id="tab-gmfm" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            2. Gross Motor Function Measure (GMFM-88) Terpadu
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <div>
                            <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                                <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">2</span>
                                Gross Motor Function Measure (GMFM-88)
                            </h5>
                            <small class="text-muted">Instrumen evaluasi motorik kasar standar emas (Gold Standard) pediatrik & neuromotor</small>
                        </div>
                    </div>

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

                    <!-- Dimensi Navigasi Sub-Pills (A, B, C, D, E) -->
                    <div class="d-flex align-items-center flex-wrap mb-3 p-2 rounded justify-content-between" style="background: #f1f5f9; gap: 8px;">
                        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                            <button type="button" class="btn btn-sm btn-primary active font-w700 gmfm-dim-btn" data-target-dim="#gmfm-pane-a" style="border-radius: 6px; font-size: 12px; padding: 6px 12px;">
                                <i class="fa fa-bed mr-1"></i> A: Berbaring & Berguling <span class="badge badge-light text-primary ml-1">17</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary font-w700 gmfm-dim-btn" data-target-dim="#gmfm-pane-b" style="border-radius: 6px; font-size: 12px; padding: 6px 12px;">
                                <i class="fa fa-street-view mr-1"></i> B: Duduk <span class="badge badge-light text-primary ml-1">20</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary font-w700 gmfm-dim-btn" data-target-dim="#gmfm-pane-c" style="border-radius: 6px; font-size: 12px; padding: 6px 12px;">
                                <i class="fa fa-child mr-1"></i> C: Merangkak & Berlutut <span class="badge badge-light text-primary ml-1">14</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary font-w700 gmfm-dim-btn" data-target-dim="#gmfm-pane-d" style="border-radius: 6px; font-size: 12px; padding: 6px 12px;">
                                <i class="fa fa-male mr-1"></i> D: Berdiri <span class="badge badge-light text-primary ml-1">13</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary font-w700 gmfm-dim-btn" data-target-dim="#gmfm-pane-e" style="border-radius: 6px; font-size: 12px; padding: 6px 12px;">
                                <i class="fa fa-running mr-1"></i> E: Jalan, Lari & Melompat <span class="badge badge-light text-primary ml-1">24</span>
                            </button>
                        </div>
                        <div class="d-flex align-items-center ml-auto p-1 px-2 rounded" style="background: white; border: 1px solid #cbd5e1;">
                            <span class="font-w700 text-dark mr-2" style="font-size: 11.5px;">TOTAL GMFM-88:</span>
                            <span class="badge badge-dark font-w700 mr-1" id="gmfm-total-live-badge-score" style="font-size: 12px;">{{ old('gmfm_total_score', $assessment->gmfm_total_score ?? 0) }} / 264</span>
                            <span class="badge badge-success font-w700" id="gmfm-total-live-badge-persen" style="font-size: 12px;">{{ number_format(old('gmfm_total_persen', $assessment->gmfm_total_persen ?? 0), 1) }}%</span>
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
                        <!-- Summary Score Card Dimensi A -->
                        <div class="card mb-3 border-0" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.15);">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="text-white-50 text-uppercase font-w600" style="letter-spacing: 0.5px;">Skor Dimensi A (Berbaring & Berguling)</small>
                                        <h3 class="mb-0 text-white font-w700" style="font-size: 24px;">
                                            <span id="gmfm-a-live-total">{{ $saved_a_total ?: 0 }}</span> <span style="font-size: 15px; opacity: 0.8;">/ 51</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_a_total" id="input-gmfm-a-total" value="{{ $saved_a_total }}">
                                        <input type="hidden" name="gmfm_dimensi_a_persen" id="input-gmfm-a-persen" value="{{ $saved_a_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-white font-w600">Capaian Dimensi A:</small>
                                            <strong class="text-white" id="gmfm-a-live-persen">{{ number_format($saved_a_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: rgba(255,255,255,0.25);">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" id="gmfm-a-live-progress" role="progressbar" style="width: {{ $saved_a_persen }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-white-50 d-block font-w600 mb-1">Interpretasi Dimensi A:</small>
                                        <span class="badge badge-light font-w700 text-dark px-3 py-2" id="gmfm-a-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
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

                        <!-- 17 Item Dimensi A List -->
                        @php $gmfm_a_items = config('gmfm.dimensions.A.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-hover mb-0" style="font-size: 12.5px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155;">
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="width: 55%;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi A)</th>
                                        <th style="width: 40%; text-align: center;">Skor Evaluasi (0 - 3)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_a_items as $no => $item)
                                        @php $valA = isset($saved_gmfm_a_scores[$no]) ? $saved_gmfm_a_scores[$no] : (old('gmfm_dimensi_a_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light text-primary font-w600 mb-1" style="font-size: 11px; border: 1px solid #cbd5e1;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.4;">{{ $item['action'] }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="d-flex justify-content-center flex-wrap gmfm-score-group" data-item="{{ $no }}" style="gap: 4px;">
                                                    <label class="radio-pill-card gmfm-pill {{ $valA === '0' || $valA === 0 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="0 = Tidak Memulai">
                                                        <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="0" class="gmfm-a-radio" {{ $valA === '0' || $valA === 0 ? 'checked' : '' }}>
                                                        <span><strong>0</strong> Tidak</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valA === '1' || $valA === 1 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="1 = Memulai (< 10%)">
                                                        <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="1" class="gmfm-a-radio" {{ $valA === '1' || $valA === 1 ? 'checked' : '' }}>
                                                        <span><strong>1</strong> Mulai</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valA === '2' || $valA === 2 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="2 = Selesai Sebagian (10% - <100%)">
                                                        <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="2" class="gmfm-a-radio" {{ $valA === '2' || $valA === 2 ? 'checked' : '' }}>
                                                        <span><strong>2</strong> Sebagian</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valA === '3' || $valA === 3 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="3 = Selesai Sempurna (100%)">
                                                        <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="3" class="gmfm-a-radio" {{ $valA === '3' || $valA === 3 ? 'checked' : '' }}>
                                                        <span><strong>3</strong> Sempurna</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valA === 'NT' ? 'active' : '' }}" style="padding: 4px 7px; font-size: 11px; border-radius: 4px;" title="NT = Tidak Diuji">
                                                        <input type="radio" name="gmfm_dimensi_a_scores[{{ $no }}]" value="NT" class="gmfm-a-radio" {{ $valA === 'NT' ? 'checked' : '' }}>
                                                        <span>NT</span>
                                                    </label>
                                                </div>
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
                        <!-- Summary Score Card Dimensi B -->
                        <div class="card mb-3 border-0" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.15);">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="text-white-50 text-uppercase font-w600" style="letter-spacing: 0.5px;">Skor Dimensi B (Duduk)</small>
                                        <h3 class="mb-0 text-white font-w700" style="font-size: 24px;">
                                            <span id="gmfm-b-live-total">{{ $saved_b_total ?: 0 }}</span> <span style="font-size: 15px; opacity: 0.8;">/ 60</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_b_total" id="input-gmfm-b-total" value="{{ $saved_b_total }}">
                                        <input type="hidden" name="gmfm_dimensi_b_persen" id="input-gmfm-b-persen" value="{{ $saved_b_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-white font-w600">Capaian Dimensi B:</small>
                                            <strong class="text-white" id="gmfm-b-live-persen">{{ number_format($saved_b_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: rgba(255,255,255,0.25);">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" id="gmfm-b-live-progress" role="progressbar" style="width: {{ $saved_b_persen }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-white-50 d-block font-w600 mb-1">Interpretasi Dimensi B:</small>
                                        <span class="badge badge-light font-w700 text-dark px-3 py-2" id="gmfm-b-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
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

                        <!-- 20 Item Dimensi B List -->
                        @php $gmfm_b_items = config('gmfm.dimensions.B.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-hover mb-0" style="font-size: 12.5px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155;">
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="width: 55%;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi B: Duduk)</th>
                                        <th style="width: 40%; text-align: center;">Skor Evaluasi (0 - 3)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_b_items as $no => $item)
                                        @php $valB = isset($saved_gmfm_b_scores[$no]) ? $saved_gmfm_b_scores[$no] : (old('gmfm_dimensi_b_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light text-info font-w600 mb-1" style="font-size: 11px; border: 1px solid #cbd5e1;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.4;">{{ $item['action'] }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="d-flex justify-content-center flex-wrap gmfm-score-group" data-item="{{ $no }}" style="gap: 4px;">
                                                    <label class="radio-pill-card gmfm-pill {{ $valB === '0' || $valB === 0 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="0 = Tidak Memulai">
                                                        <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="0" class="gmfm-b-radio" {{ $valB === '0' || $valB === 0 ? 'checked' : '' }}>
                                                        <span><strong>0</strong> Tidak</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valB === '1' || $valB === 1 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="1 = Memulai (< 10%)">
                                                        <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="1" class="gmfm-b-radio" {{ $valB === '1' || $valB === 1 ? 'checked' : '' }}>
                                                        <span><strong>1</strong> Mulai</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valB === '2' || $valB === 2 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="2 = Selesai Sebagian (10% - <100%)">
                                                        <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="2" class="gmfm-b-radio" {{ $valB === '2' || $valB === 2 ? 'checked' : '' }}>
                                                        <span><strong>2</strong> Sebagian</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valB === '3' || $valB === 3 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="3 = Selesai Sempurna (100%)">
                                                        <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="3" class="gmfm-b-radio" {{ $valB === '3' || $valB === 3 ? 'checked' : '' }}>
                                                        <span><strong>3</strong> Sempurna</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valB === 'NT' ? 'active' : '' }}" style="padding: 4px 7px; font-size: 11px; border-radius: 4px;" title="NT = Tidak Diuji">
                                                        <input type="radio" name="gmfm_dimensi_b_scores[{{ $no }}]" value="NT" class="gmfm-b-radio" {{ $valB === 'NT' ? 'checked' : '' }}>
                                                        <span>NT</span>
                                                    </label>
                                                </div>
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
                        <!-- Summary Score Card Dimensi C -->
                        <div class="card mb-3 border-0" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(109, 40, 217, 0.15);">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="text-white-50 text-uppercase font-w600" style="letter-spacing: 0.5px;">Skor Dimensi C (Merangkak & Berlutut)</small>
                                        <h3 class="mb-0 text-white font-w700" style="font-size: 24px;">
                                            <span id="gmfm-c-live-total">{{ $saved_c_total ?: 0 }}</span> <span style="font-size: 15px; opacity: 0.8;">/ 42</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_c_total" id="input-gmfm-c-total" value="{{ $saved_c_total }}">
                                        <input type="hidden" name="gmfm_dimensi_c_persen" id="input-gmfm-c-persen" value="{{ $saved_c_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-white font-w600">Capaian Dimensi C:</small>
                                            <strong class="text-white" id="gmfm-c-live-persen">{{ number_format($saved_c_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: rgba(255,255,255,0.25);">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" id="gmfm-c-live-progress" role="progressbar" style="width: {{ $saved_c_persen }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-white-50 d-block font-w600 mb-1">Interpretasi Dimensi C:</small>
                                        <span class="badge badge-light font-w700 text-dark px-3 py-2" id="gmfm-c-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
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

                        <!-- 14 Item Dimensi C List -->
                        @php $gmfm_c_items = config('gmfm.dimensions.C.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-hover mb-0" style="font-size: 12.5px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155;">
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="width: 55%;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi C: Merangkak & Berlutut)</th>
                                        <th style="width: 40%; text-align: center;">Skor Evaluasi (0 - 3)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_c_items as $no => $item)
                                        @php $valC = isset($saved_gmfm_c_scores[$no]) ? $saved_gmfm_c_scores[$no] : (old('gmfm_dimensi_c_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light font-w600 mb-1" style="font-size: 11px; border: 1px solid #cbd5e1; color: #7c3aed;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.4;">{{ $item['action'] }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="d-flex justify-content-center flex-wrap gmfm-score-group" data-item="{{ $no }}" style="gap: 4px;">
                                                    <label class="radio-pill-card gmfm-pill {{ $valC === '0' || $valC === 0 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="0 = Tidak Memulai">
                                                        <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="0" class="gmfm-c-radio" {{ $valC === '0' || $valC === 0 ? 'checked' : '' }}>
                                                        <span><strong>0</strong> Tidak</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valC === '1' || $valC === 1 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="1 = Memulai (< 10%)">
                                                        <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="1" class="gmfm-c-radio" {{ $valC === '1' || $valC === 1 ? 'checked' : '' }}>
                                                        <span><strong>1</strong> Mulai</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valC === '2' || $valC === 2 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="2 = Selesai Sebagian (10% - <100%)">
                                                        <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="2" class="gmfm-c-radio" {{ $valC === '2' || $valC === 2 ? 'checked' : '' }}>
                                                        <span><strong>2</strong> Sebagian</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valC === '3' || $valC === 3 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="3 = Selesai Sempurna (100%)">
                                                        <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="3" class="gmfm-c-radio" {{ $valC === '3' || $valC === 3 ? 'checked' : '' }}>
                                                        <span><strong>3</strong> Sempurna</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valC === 'NT' ? 'active' : '' }}" style="padding: 4px 7px; font-size: 11px; border-radius: 4px;" title="NT = Tidak Diuji">
                                                        <input type="radio" name="gmfm_dimensi_c_scores[{{ $no }}]" value="NT" class="gmfm-c-radio" {{ $valC === 'NT' ? 'checked' : '' }}>
                                                        <span>NT</span>
                                                    </label>
                                                </div>
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
                        <!-- Summary Score Card Dimensi D -->
                        <div class="card mb-3 border-0" style="background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%); color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.15);">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="text-white-50 text-uppercase font-w600" style="letter-spacing: 0.5px;">Skor Dimensi D (Berdiri)</small>
                                        <h3 class="mb-0 text-white font-w700" style="font-size: 24px;">
                                            <span id="gmfm-d-live-total">{{ $saved_d_total ?: 0 }}</span> <span style="font-size: 15px; opacity: 0.8;">/ 39</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_d_total" id="input-gmfm-d-total" value="{{ $saved_d_total }}">
                                        <input type="hidden" name="gmfm_dimensi_d_persen" id="input-gmfm-d-persen" value="{{ $saved_d_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-white font-w600">Capaian Dimensi D:</small>
                                            <strong class="text-white" id="gmfm-d-live-persen">{{ number_format($saved_d_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: rgba(255,255,255,0.25);">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" id="gmfm-d-live-progress" role="progressbar" style="width: {{ $saved_d_persen }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-white-50 d-block font-w600 mb-1">Interpretasi Dimensi D:</small>
                                        <span class="badge badge-light font-w700 text-dark px-3 py-2" id="gmfm-d-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
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

                        <!-- 13 Item Dimensi D List -->
                        @php $gmfm_d_items = config('gmfm.dimensions.D.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-hover mb-0" style="font-size: 12.5px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155;">
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="width: 55%;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi D: Berdiri)</th>
                                        <th style="width: 40%; text-align: center;">Skor Evaluasi (0 - 3)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_d_items as $no => $item)
                                        @php $valD = isset($saved_gmfm_d_scores[$no]) ? $saved_gmfm_d_scores[$no] : (old('gmfm_dimensi_d_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light font-w600 mb-1" style="font-size: 11px; border: 1px solid #cbd5e1; color: #ea580c;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.4;">{{ $item['action'] }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="d-flex justify-content-center flex-wrap gmfm-score-group" data-item="{{ $no }}" style="gap: 4px;">
                                                    <label class="radio-pill-card gmfm-pill {{ $valD === '0' || $valD === 0 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="0 = Tidak Memulai">
                                                        <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="0" class="gmfm-d-radio" {{ $valD === '0' || $valD === 0 ? 'checked' : '' }}>
                                                        <span><strong>0</strong> Tidak</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valD === '1' || $valD === 1 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="1 = Memulai (< 10%)">
                                                        <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="1" class="gmfm-d-radio" {{ $valD === '1' || $valD === 1 ? 'checked' : '' }}>
                                                        <span><strong>1</strong> Mulai</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valD === '2' || $valD === 2 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="2 = Selesai Sebagian (10% - <100%)">
                                                        <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="2" class="gmfm-d-radio" {{ $valD === '2' || $valD === 2 ? 'checked' : '' }}>
                                                        <span><strong>2</strong> Sebagian</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valD === '3' || $valD === 3 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="3 = Selesai Sempurna (100%)">
                                                        <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="3" class="gmfm-d-radio" {{ $valD === '3' || $valD === 3 ? 'checked' : '' }}>
                                                        <span><strong>3</strong> Sempurna</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valD === 'NT' ? 'active' : '' }}" style="padding: 4px 7px; font-size: 11px; border-radius: 4px;" title="NT = Tidak Diuji">
                                                        <input type="radio" name="gmfm_dimensi_d_scores[{{ $no }}]" value="NT" class="gmfm-d-radio" {{ $valD === 'NT' ? 'checked' : '' }}>
                                                        <span>NT</span>
                                                    </label>
                                                </div>
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
                        <!-- Summary Score Card Dimensi E -->
                        <div class="card mb-3 border-0" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.15);">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-12 text-center text-md-left mb-2 mb-md-0">
                                        <small class="text-white-50 text-uppercase font-w600" style="letter-spacing: 0.5px;">Skor Dimensi E (Jalan, Lari & Lompat)</small>
                                        <h3 class="mb-0 text-white font-w700" style="font-size: 24px;">
                                            <span id="gmfm-e-live-total">{{ $saved_e_total ?: 0 }}</span> <span style="font-size: 15px; opacity: 0.8;">/ 72</span>
                                        </h3>
                                        <input type="hidden" name="gmfm_dimensi_e_total" id="input-gmfm-e-total" value="{{ $saved_e_total }}">
                                        <input type="hidden" name="gmfm_dimensi_e_persen" id="input-gmfm-e-persen" value="{{ $saved_e_persen }}">
                                    </div>
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-white font-w600">Capaian Dimensi E:</small>
                                            <strong class="text-white" id="gmfm-e-live-persen">{{ number_format($saved_e_persen, 1) }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 5px; background: rgba(255,255,255,0.25);">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" id="gmfm-e-live-progress" role="progressbar" style="width: {{ $saved_e_persen }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-center text-md-right">
                                        <small class="text-white-50 d-block font-w600 mb-1">Interpretasi Dimensi E:</small>
                                        <span class="badge badge-light font-w700 text-dark px-3 py-2" id="gmfm-e-live-interpretation" style="font-size: 11.5px; border-radius: 6px;">
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

                        <!-- 24 Item Dimensi E List -->
                        @php $gmfm_e_items = config('gmfm.dimensions.E.items', []); @endphp
                        <div class="table-responsive mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                            <table class="table table-hover mb-0" style="font-size: 12.5px; vertical-align: middle;">
                                <thead style="background: #f1f5f9; color: #334155;">
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="width: 55%;">Posisi & Deskripsi Gerakan Aktivitas (Dimensi E: Berjalan, Berlari & Melompat)</th>
                                        <th style="width: 40%; text-align: center;">Skor Evaluasi (0 - 3)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gmfm_e_items as $no => $item)
                                        @php $valE = isset($saved_gmfm_e_scores[$no]) ? $saved_gmfm_e_scores[$no] : (old('gmfm_dimensi_e_scores.'.$no, '')); @endphp
                                        <tr>
                                            <td class="text-center font-w700 text-muted" style="vertical-align: middle;">{{ $no }}</td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge badge-light font-w600 mb-1" style="font-size: 11px; border: 1px solid #cbd5e1; color: #059669;">{{ $item['position'] }}</span>
                                                <div class="font-w600 text-dark" style="line-height: 1.4;">{{ $item['action'] }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="d-flex justify-content-center flex-wrap gmfm-score-group" data-item="{{ $no }}" style="gap: 4px;">
                                                    <label class="radio-pill-card gmfm-pill {{ $valE === '0' || $valE === 0 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="0 = Tidak Memulai">
                                                        <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="0" class="gmfm-e-radio" {{ $valE === '0' || $valE === 0 ? 'checked' : '' }}>
                                                        <span><strong>0</strong> Tidak</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valE === '1' || $valE === 1 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="1 = Memulai (< 10%)">
                                                        <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="1" class="gmfm-e-radio" {{ $valE === '1' || $valE === 1 ? 'checked' : '' }}>
                                                        <span><strong>1</strong> Mulai</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valE === '2' || $valE === 2 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="2 = Selesai Sebagian (10% - <100%)">
                                                        <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="2" class="gmfm-e-radio" {{ $valE === '2' || $valE === 2 ? 'checked' : '' }}>
                                                        <span><strong>2</strong> Sebagian</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valE === '3' || $valE === 3 ? 'active' : '' }}" style="padding: 4px 9px; font-size: 11.5px; border-radius: 4px;" title="3 = Selesai Sempurna (100%)">
                                                        <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="3" class="gmfm-e-radio" {{ $valE === '3' || $valE === 3 ? 'checked' : '' }}>
                                                        <span><strong>3</strong> Sempurna</span>
                                                    </label>
                                                    <label class="radio-pill-card gmfm-pill {{ $valE === 'NT' ? 'active' : '' }}" style="padding: 4px 7px; font-size: 11px; border-radius: 4px;" title="NT = Tidak Diuji">
                                                        <input type="radio" name="gmfm_dimensi_e_scores[{{ $no }}]" value="NT" class="gmfm-e-radio" {{ $valE === 'NT' ? 'checked' : '' }}>
                                                        <span>NT</span>
                                                    </label>
                                                </div>
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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-motorik-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Motorik Kasar & Halus
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-adl-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 3 (ADL) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 3. BAGIAN KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL) -->
                <div class="tab-pane-box" id="tab-adl" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            3. Kemampuan Aktivitas Sehari-hari (ADL)
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">3</span>
                            Kemampuan Aktivitas Sehari-hari (ADL)
                        </h5>
                        <small class="text-muted">Pilih opsi kemandirian aktivitas sehari-hari</small>
                    </div>

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
                                        <label class="radio-pill-card {{ $adl2 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $adl3 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $adl4 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $adl5 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $adl6 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $adl7 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $adl8 == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $adl9 == $opt ? 'active' : '' }}>
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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-gmfm-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke GMFM-88
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-wicara-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 4 (Wicara) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 4. BAGIAN KEMAMPUAN WICARA -->
                <div class="tab-pane-box" id="tab-wicara" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            4. Kemampuan Wicara & Komunikasi
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">4</span>
                            Kemampuan Wicara & Komunikasi
                        </h5>
                        <small class="text-muted">Pilih opsi komunikasi, organ bicara, dan fungsi menelan</small>
                    </div>

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
                        <textarea name="wicara_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait kemampuan wicara..." style="font-size: 12.5px;">{{ old('wicara_catatan', $assessment->wicara_catatan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-adl-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke ADL
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-penglihatan-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 4 (Penglihatan) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 4. BAGIAN STATUS PENGLIHATAN (NETRA) -->
                <div class="tab-pane-box" id="tab-penglihatan" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            4. Status Penglihatan
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">4</span>
                            Status Penglihatan (Asesmen Netra)
                        </h5>
                        <small class="text-muted">Kondisi fungsi visual, onset, visus, dan alat bantu</small>
                    </div>

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
                                        <label class="radio-pill-card {{ $vis_onset == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $vis_sisi == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $vis_prog == $opt ? 'active' : '' }}>
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
                                        <label class="radio-pill-card {{ $vis_pref == $opt ? 'active' : '' }}>
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

                                <div class="row">
                                    <!-- Tongkat Putih -->
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="p-2 rounded" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="penglihatan_alat_bantu[]" value="Tongkat putih" class="custom-control-input" id="alat_tongkat" {{ in_array('Tongkat putih', $saved_alat) ? 'checked' : '' }} onchange="toggleTongkatTeknik(this.checked)">
                                                <label class="custom-control-label font-w700 text-dark" for="alat_tongkat" style="cursor: pointer; font-size: 12.5px;">
                                                    Tongkat putih
                                                </label>
                                            </div>
                                            <div id="wrap-teknik-tongkat" class="mt-2 pl-4" style="{{ in_array('Tongkat putih', $saved_alat) ? '' : 'display: none;' }}">
                                                <small class="text-muted d-block mb-1 font-w600">Teknik Tongkat:</small>
                                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                                    @php $tek = old('penglihatan_teknik_tongkat', $assessment->penglihatan_teknik_tongkat); @endphp
                                                    @foreach(['Sweep', 'Diagonal', 'Tidak tahu'] as $t_opt)
                                                        <label class="radio-pill-card py-1 px-2 {{ $tek == $t_opt ? 'active' : '' }}" style="font-size: 11.5px;">
                                                            <input type="radio" name="penglihatan_teknik_tongkat" value="{{ $t_opt }}" {{ $tek == $t_opt ? 'checked' : '' }}>
                                                            <span>{{ $t_opt }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kacamata / Low Vision Aid -->
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="p-2 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; height: 100%;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="penglihatan_alat_bantu[]" value="Kacamata / Low Vision Aid" class="custom-control-input" id="alat_kacamata" {{ in_array('Kacamata / Low Vision Aid', $saved_alat) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-w600 text-dark" for="alat_kacamata" style="cursor: pointer; font-size: 12.5px;">
                                                    Kacamata / Low Vision Aid
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tidak menggunakan alat bantu -->
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="p-2 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; height: 100%;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="penglihatan_alat_bantu[]" value="Tidak menggunakan alat bantu" class="custom-control-input" id="alat_tidak_ada" {{ in_array('Tidak menggunakan alat bantu', $saved_alat) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-w600 text-dark" for="alat_tidak_ada" style="cursor: pointer; font-size: 12.5px;">
                                                    Tidak menggunakan alat bantu
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Guide dog / Pendamping manusia -->
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="p-2 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; height: 100%;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="penglihatan_alat_bantu[]" value="Guide dog / Pendamping manusia" class="custom-control-input" id="alat_guide" {{ in_array('Guide dog / Pendamping manusia', $saved_alat) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-w600 text-dark" for="alat_guide" style="cursor: pointer; font-size: 12.5px;">
                                                    Guide dog / Pendamping manusia
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Screen reader / Teknologi assistive -->
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="p-2 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; height: 100%;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="penglihatan_alat_bantu[]" value="Screen reader / Teknologi assistive" class="custom-control-input" id="alat_screen" {{ in_array('Screen reader / Teknologi assistive', $saved_alat) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-w600 text-dark" for="alat_screen" style="cursor: pointer; font-size: 12.5px;">
                                                    Screen reader / Teknologi assistive
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lainnya -->
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="p-2 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; height: 100%;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="penglihatan_alat_bantu[]" value="Lainnya" class="custom-control-input" id="alat_lainnya" {{ in_array('Lainnya', $saved_alat) ? 'checked' : '' }} onchange="toggleAlatLainnya(this.checked)">
                                                <label class="custom-control-label font-w600 text-dark" for="alat_lainnya" style="cursor: pointer; font-size: 12.5px;">
                                                    Lainnya
                                                </label>
                                            </div>
                                            <div id="wrap-alat-lainnya" class="mt-1" style="{{ in_array('Lainnya', $saved_alat) ? '' : 'display: none;' }}">
                                                <input type="text" name="penglihatan_alat_bantu_lainnya" class="form-control form-control-sm" value="{{ old('penglihatan_alat_bantu_lainnya', $assessment->penglihatan_alat_bantu_lainnya) }}" placeholder="Sebutkan alat bantu lainnya..." style="font-size: 12px; height: 34px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Status Penglihatan -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Tambahan Asesmen Penglihatan (Opsional)</label>
                        <textarea name="penglihatan_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan khusus terkait kondisi penglihatan / orientasi mobilitas..." style="font-size: 12.5px;">{{ old('penglihatan_catatan', $assessment->penglihatan_catatan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-wicara-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Wicara
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-nyeri-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 5 (Nyeri) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 5. BAGIAN INTENSITAS NYERI & BODY CHART -->
                <div class="tab-pane-box" id="tab-nyeri" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            5. Intensitas Nyeri & Body Chart
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">5</span>
                            Intensitas Nyeri & Body Chart
                        </h5>
                        <small class="text-muted">Skala Nyeri (0 - 10 VAS / NRS), Sifat Nyeri, dan Pemetaan Lokasi Tubuh</small>
                    </div>

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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-penglihatan-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Status Penglihatan
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-rom-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 6 (ROM & MMT) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 6. BAGIAN LINGKUP GERAK SENDI (ROM) & KEKUATAN OTOT (MMT) -->
                <div class="tab-pane-box" id="tab-rom" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            6. Lingkup Gerak Sendi (ROM) & Kekuatan Otot
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">6</span>
                            Lingkup Gerak Sendi (ROM) & Kekuatan Otot
                        </h5>
                        <small class="text-muted">Pemeriksaan Range of Motion & Manual Muscle Testing (MMT 0-5)</small>
                    </div>

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
                        $rows = [
                            'kanan'    => 'Kanan (Aktif/Pasif)',
                            'kiri'     => 'Kiri (Aktif/Pasif)',
                            'cervical' => 'Cervical (Leher)',
                            'thoracal' => 'Thoracal (Punggung)',
                            'lumbal'   => 'Lumbal (Pinggang)',
                            'custom'   => 'Sendi Lainnya'
                        ];
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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-nyeri-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Intensitas Nyeri
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-neuro-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 7 (Neurologis) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 7. BAGIAN PEMERIKSAAN NEUROLOGIS -->
                <div class="tab-pane-box" id="tab-neuro" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            7. Pemeriksaan Neurologis
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">7</span>
                            Pemeriksaan Neurologis (Sistem Saraf)
                        </h5>
                        <small class="text-muted">Sensasi, Refleks Fisiologis Tendon (D/S), Tes Koordinasi, dan Tonus Otot</small>
                    </div>

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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-rom-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke ROM & MMT
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-postur-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 8 (Postur & Keseimbangan) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 8. BAGIAN PEMERIKSAAN POSTUR & KESEIMBANGAN -->
                <div class="tab-pane-box" id="tab-postur" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            8. Pemeriksaan Postur & Keseimbangan
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">8</span>
                            Pemeriksaan Postur & Keseimbangan
                        </h5>
                        <small class="text-muted">Observasi Postur Tubuh & Uji Risiko Jatuh (BBS, TUG, Romberg, OLS, FES-I)</small>
                    </div>

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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-neuro-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Neurologis
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-gait-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 9 (Gait) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 9. BAGIAN PEMERIKSAAN GAYA BERJALAN (GAIT) -->
                <div class="tab-pane-box" id="tab-gait" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            9. Pemeriksaan Gaya Berjalan (Gait)
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">9</span>
                            Pemeriksaan Gaya Berjalan (Gait)
                        </h5>
                        <small class="text-muted">Karakteristik Siklus Berjalan, Uji 10-Meter Walk Test (10MWT), dan Catatan Khusus</small>
                    </div>

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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-postur-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Postur & Keseimbangan
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-sensoris-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 10 (Sensoris & Vestibular) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 10. BAGIAN PEMERIKSAAN SENSORIS, PROPRIOSEPSI & VESTIBULAR -->
                <div class="tab-pane-box" id="tab-sensoris" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            10. Pemeriksaan Sensoris, Propriosepsi & Vestibular
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">10</span>
                            Pemeriksaan Sensoris, Propriosepsi & Vestibular
                        </h5>
                        <small class="text-muted">Sensasi taktil, uji propriosepsi & kinesthesia, skrining vestibular, serta lokasi defisit sensoris</small>
                    </div>

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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-gait-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Gaya Berjalan (Gait)
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-psikososial-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 11 (Psikososial) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 11. BAGIAN FAKTOR PSIKOSOSIAL & KONTEKSTUAL -->
                <div class="tab-pane-box" id="tab-psikososial" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            11. Faktor Psikososial & Kontekstual
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">11</span>
                            Faktor Psikososial & Kontekstual
                        </h5>
                        <small class="text-muted">Pekerjaan/hobi terdampak, faktor psikologis, dukungan keluarga/sosial, dan ekspektasi pemulihan</small>
                    </div>

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
                                <textarea name="psikososial_harapan_pasien" class="form-control" rows="2" placeholder="Tuliskan target atau ekspektasi yang ingin dicapai penerima manfaat / keluarga (misal: bisa berjalan mandiri, mengurangi nyeri, kembali beraktivitas normal)..." style="font-size: 12.5px;">{{ old('psikososial_harapan_pasien', $assessment->psikososial_harapan_pasien) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Tambahan Psikososial -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">Catatan Observasi Psikososial & Kontekstual (Opsional)</label>
                        <textarea name="psikososial_catatan" class="form-control" rows="2" placeholder="Tuliskan catatan tambahan mengenai kondisi lingkungan, kesiapan motivasi pasien, atau hambatan psikososial lainnya..." style="font-size: 12.5px;">{{ old('psikososial_catatan', $assessment->psikososial_catatan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-sensoris-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Sensoris & Vestibular
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-perencanaan-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 12 (Perencanaan Terapi) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 12. BAGIAN PERENCANAAN TERAPI -->
                <div class="tab-pane-box" id="tab-perencanaan" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            12. Perencanaan Terapi & Intervensi
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">12</span>
                            Perencanaan Terapi & Program Intervensi
                        </h5>
                        <small class="text-muted">Pilih opsi modalitas fisik, manual terapi, latihan terapi, edukasi, dan dosis terapi</small>
                    </div>

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
                                    $modalitas_opts = ['TENS / EStim', 'Ultrasound', 'SWD / MWD', 'Hot Pack', 'Cold Pack', 'LASER', 'Paraffin Bath', 'Traksi mekanik', 'Hidroterapi'];
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($modalitas_opts as $m_opt)
                                        <label class="check-pill-card {{ in_array($m_opt, $saved_modalitas) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_modalitas_fisik[]" value="{{ $m_opt }}" {{ in_array($m_opt, $saved_modalitas) ? 'checked' : '' }}>
                                            <span>{{ $m_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <input type="text" name="rencana_modalitas_lainnya" class="form-control form-control-sm" value="{{ old('rencana_modalitas_lainnya', $assessment->rencana_modalitas_lainnya) }}" placeholder="Modalitas lainnya (IR, Biofeedback, dsb)..." style="font-size: 12px; height: 34px;">
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
                                    $manual_opts = ['Joint mobilization', 'Soft tissue mobilization', 'Myofascial release', 'PNF', 'Dry needling', 'Kinesio taping', 'Neural mobilization', 'Manipulasi'];
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($manual_opts as $man_opt)
                                        <label class="check-pill-card {{ in_array($man_opt, $saved_manual) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_manual_terapi[]" value="{{ $man_opt }}" {{ in_array($man_opt, $saved_manual) ? 'checked' : '' }}>
                                            <span>{{ $man_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <input type="text" name="rencana_manual_lainnya" class="form-control form-control-sm" value="{{ old('rencana_manual_lainnya', $assessment->rencana_manual_lainnya) }}" placeholder="Teknik manual lainnya (Massage terapi, Graston, dsb)..." style="font-size: 12px; height: 34px;">
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
                                    $latihan_opts = ['Stretching / flexibility', 'Strengthening', 'Stabilisasi core', 'Propriosepsi / keseimbangan', 'Aerobik / kardio', 'Latihan fungsional', 'Home exercise program'];
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($latihan_opts as $lat_opt)
                                        <label class="check-pill-card {{ in_array($lat_opt, $saved_latihan) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_latihan_terapi[]" value="{{ $lat_opt }}" {{ in_array($lat_opt, $saved_latihan) ? 'checked' : '' }}>
                                            <span>{{ $lat_opt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <input type="text" name="rencana_latihan_lainnya" class="form-control form-control-sm" value="{{ old('rencana_latihan_lainnya', $assessment->rencana_latihan_lainnya) }}" placeholder="Latihan terapi lainnya (Gait training, Transfer training, dsb)..." style="font-size: 12px; height: 34px;">
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
                                    $edukasi_opts = ['Postur & ergonomi', 'Manajemen nyeri mandiri', 'Modifikasi aktivitas', 'Pencegahan cedera ulang', 'Nutrisi & gaya hidup', 'Penggunaan alat bantu'];
                                @endphp
                                <div class="d-flex flex-wrap mb-2" style="gap: 6px;">
                                    @foreach($edukasi_opts as $ed_opt)
                                        <label class="check-pill-card {{ in_array($ed_opt, $saved_edukasi) ? 'active' : '' }}">
                                            <input type="checkbox" name="rencana_edukasi_konseling[]" value="{{ $ed_opt }}" {{ in_array($ed_opt, $saved_edukasi) ? 'checked' : '' }}>
                                            <span>{{ $ed_opt }}</span>
                                        </label>
                                    @endforeach
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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-psikososial-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Faktor Psikososial
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-evaluasi-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 13 (Evaluasi & Target) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 13. BAGIAN EVALUASI & TARGET TERAPI -->
                <div class="tab-pane-box" id="tab-evaluasi" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            13. Evaluasi Klinis & Target Program
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">13</span>
                            Kesimpulan, Evaluasi Klinis & Target Terapi
                        </h5>
                        <small class="text-muted">Tuliskan kesimpulan klinis komprehensif terapis dan target program terapi lanjutan</small>
                    </div>

                    <!-- Kesimpulan & Target Program Bebas -->
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-file-text-o text-primary mr-1"></i> Kesimpulan & Evaluasi Klinis Terapis
                                </label>
                                <textarea name="kesimpulan" class="form-control" rows="6" placeholder="Ringkasan hasil evaluasi asesmen klinis menyeluruh, temuan utama fisioterapi/terapi okupasi/wicara..." style="font-size: 13px;">{{ old('kesimpulan', $assessment->kesimpulan) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <div class="assessment-box p-3 rounded h-100" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                <label class="font-w700 text-dark mb-2 d-block" style="font-size: 13px;">
                                    <i class="fa fa-calendar-check-o text-primary mr-1"></i> Rencana Program Terapi Lanjutan & Target
                                </label>
                                <textarea name="rencana_terapi" class="form-control" rows="6" placeholder="Target jangka pendek & panjang, panduan latihan mandiri di rumah (Home Exercise Program), jadwal supervisi lanjutan..." style="font-size: 13px;">{{ old('rencana_terapi', $assessment->rencana_terapi) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-perencanaan-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Perencanaan Terapi
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-denver-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 15 (Skala Denver) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 15. BAGIAN SKALA DENVER (DDST II) -->
                <div class="tab-pane-box" id="tab-denver" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            15. Skala Perkembangan Denver II (DDST II)
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">15</span>
                            Skala Perkembangan Denver (DDST II)
                        </h5>
                        <small class="text-muted">Skrining perkembangan anak pada 4 domain: Personal Sosial, Motorik Halus, Bahasa, dan Motorik Kasar</small>
                    </div>

                    @php
                        $saved_denver_data = is_array($assessment->denver_data) ? $assessment->denver_data : [];
                        $saved_denver_pass = old('denver_pass_count', $assessment->denver_pass_count ?? 0);
                        $saved_denver_fail = old('denver_fail_count', $assessment->denver_fail_count ?? 0);
                        $saved_denver_refusal = old('denver_refusal_count', $assessment->denver_refusal_count ?? 0);
                        $saved_denver_no = old('denver_no_count', $assessment->denver_no_count ?? 0);
                        $saved_denver_kesimpulan = old('denver_kesimpulan', $assessment->denver_kesimpulan ?? 'Belum Dinilai');

                        $denver_sectors = [
                            'A' => [
                                'title' => 'A. Personal Sosial',
                                'badge_color' => '#0284c7',
                                'bg_header' => '#f0f9ff',
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
                                'bg_header' => '#f5f3ff',
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
                                'bg_header' => '#ecfdf5',
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
                                'bg_header' => '#fff7ed',
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

                    <!-- Summary Score Card Skala Denver -->
                    <div class="card mb-4 border-0" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; border-radius: 12px; box-shadow: 0 4px 18px rgba(15, 23, 42, 0.15);">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-12 mb-3 mb-lg-0">
                                    <small class="text-white-50 text-uppercase font-w600" style="letter-spacing: 0.5px; font-size: 11px;">Rekapitulasi Hasil Skrining DDST II (19 Task)</small>
                                    <div class="d-flex align-items-center flex-wrap mt-2" style="gap: 8px;">
                                        <span class="badge px-3 py-2 font-w700" style="background: #10b981; color: white; font-size: 12px; border-radius: 6px;">
                                            <i class="fa fa-check mr-1"></i> Pass (P): <strong id="denver-live-p">{{ $saved_denver_pass }}</strong>
                                        </span>
                                        <span class="badge px-3 py-2 font-w700" style="background: #ef4444; color: white; font-size: 12px; border-radius: 6px;">
                                            <i class="fa fa-times mr-1"></i> Fail (F): <strong id="denver-live-f">{{ $saved_denver_fail }}</strong>
                                        </span>
                                        <span class="badge px-3 py-2 font-w700" style="background: #f59e0b; color: white; font-size: 12px; border-radius: 6px;">
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
                                    <small class="text-white-50 d-block font-w600 mb-1" style="font-size: 11px;">Interpretasi Klinis Otomatis:</small>
                                    <span class="badge px-3 py-2 font-w700 text-uppercase" id="denver-live-badge-kesimpulan" style="font-size: 13px; border-radius: 6px; {{ $saved_denver_kesimpulan == 'Normal (Sesuai Usia)' ? 'background:#10b981;color:white;' : ($saved_denver_kesimpulan == 'Suspect (Meragukan)' ? 'background:#f59e0b;color:white;' : ($saved_denver_kesimpulan == 'Keterlambatan Perkembangan' ? 'background:#ef4444;color:white;' : 'background:#e2e8f0;color:#1e293b;')) }}">
                                        {{ $saved_denver_kesimpulan ?: 'Belum Dinilai' }}
                                    </span>
                                    <div class="text-white-50 mt-1" id="denver-live-desc-kesimpulan" style="font-size: 11px;">
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

                    <!-- 4 Sectors Task List -->
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
                                    <table class="table table-hover mb-0" style="font-size: 12.5px; vertical-align: middle;">
                                        <thead style="background: #fafafa; color: #475569; font-size: 11.5px;">
                                            <tr>
                                                <th style="width: 5%; text-align: center;">No</th>
                                                <th style="width: 35%;">Nama Task Perkembangan</th>
                                                <th style="width: 15%; text-align: center;">Rentang Usia</th>
                                                <th style="width: 25%; text-align: center;">Status Penilaian</th>
                                                <th style="width: 20%;">Catatan Terapis</th>
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
                                                        <strong class="text-dark">{{ $task['name'] }}</strong>
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <span class="badge badge-light border font-w600" style="font-size: 11px; color: #475569;">{{ $task['age'] }}</span>
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        <div class="d-flex justify-content-center flex-wrap denver-score-group" data-task="{{ $tKey }}" style="gap: 4px;">
                                                            <label class="radio-pill-card denver-pill {{ $itemVal === 'P' ? 'active' : '' }}" style="padding: 3px 8px; font-size: 11px; border-radius: 4px;" title="Pass (Lolos)">
                                                                <input type="radio" name="denver_data[{{ $tKey }}][score]" value="P" class="denver-radio" {{ $itemVal === 'P' ? 'checked' : '' }}>
                                                                <span class="text-success font-w700">P</span>
                                                            </label>
                                                            <label class="radio-pill-card denver-pill {{ $itemVal === 'F' ? 'active' : '' }}" style="padding: 3px 8px; font-size: 11px; border-radius: 4px;" title="Fail (Gagal)">
                                                                <input type="radio" name="denver_data[{{ $tKey }}][score]" value="F" class="denver-radio" {{ $itemVal === 'F' ? 'checked' : '' }}>
                                                                <span class="text-danger font-w700">F</span>
                                                            </label>
                                                            <label class="radio-pill-card denver-pill {{ $itemVal === 'R' ? 'active' : '' }}" style="padding: 3px 8px; font-size: 11px; border-radius: 4px;" title="Refusal (Menolak)">
                                                                <input type="radio" name="denver_data[{{ $tKey }}][score]" value="R" class="denver-radio" {{ $itemVal === 'R' ? 'checked' : '' }}>
                                                                <span class="text-warning font-w700">R</span>
                                                            </label>
                                                            <label class="radio-pill-card denver-pill {{ $itemVal === 'NO' ? 'active' : '' }}" style="padding: 3px 8px; font-size: 11px; border-radius: 4px;" title="No Opportunity (Tidak Ada Kesempatan)">
                                                                <input type="radio" name="denver_data[{{ $tKey }}][score]" value="NO" class="denver-radio" {{ $itemVal === 'NO' ? 'checked' : '' }}>
                                                                <span class="text-muted font-w700">NO</span>
                                                            </label>
                                                        </div>
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

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-evaluasi-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Evaluasi & Target
                        </button>
                        <button type="submit" name="action" value="save" class="btn btn-sm btn-primary font-w600" style="padding: 7px 20px; font-size: 12.5px;">
                            <i class="fa fa-save mr-1"></i> Simpan Assessment
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Unified Card Footer Action Buttons -->
        <div class="card-footer py-3 px-4 d-flex align-items-center justify-content-between flex-wrap" style="background: #fafbfd; border-top: 1px solid #edf2f7; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; gap: 10px;">
            <div class="text-muted font-w500" style="font-size: 12px;">
                <i class="fa fa-lock text-success mr-1"></i> Data asesmen tersimpan langsung ke rekam medis penerima manfaat.
            </div>
            <div class="d-flex align-items-center" style="gap: 8px;">
                <a href="{{Route('rekam.detail', $pasien->id)}}" class="btn btn-sm btn-light" style="padding: 7px 16px; font-weight: 600; font-size: 12.5px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    Batal
                </a>
                <button type="submit" name="action" value="save" class="btn btn-sm btn-primary" style="padding: 7px 20px; font-weight: 600; font-size: 12.5px; border-radius: 6px;">
                    <i class="fa fa-save mr-1"></i> Simpan Assessment
                </button>
                <button type="submit" name="action" value="save_and_print" class="btn btn-sm btn-success text-white" style="padding: 7px 18px; font-weight: 600; font-size: 12.5px; border-radius: 6px;">
                    <i class="fa fa-print mr-1"></i> Simpan & Cetak
                </button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('style')
<style>
/* Custom Assessment Tab Navigation */
.assessment-tabs .nav-link {
    background: #ffffff;
    color: #475569;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px !important;
    padding: 6px 9px;
    font-size: 11.5px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.assessment-tabs .nav-link:hover {
    background: #f1f5fb;
    color: #0f172a;
    border-color: #cbd5e1;
}

.assessment-tabs .nav-link.active {
    background: #2e4b82 !important;
    color: #ffffff !important;
    border-color: #2e4b82 !important;
    box-shadow: 0 2px 8px rgba(46, 75, 130, 0.2);
}

.assessment-tabs .nav-link.active .badge {
    background: #ffffff !important;
    color: #2e4b82 !important;
}

/* Radio & Checkbox Interactive Pill Cards with Visible Bullet & Checkbox Indicator */
.radio-pill-card, .check-pill-card {
    display: inline-flex;
    align-items: center;
    padding: 7px 14px;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    font-size: 12.5px;
    font-weight: 500;
    color: #334155;
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
    user-select: none;
    margin-bottom: 0;
    position: relative;
}

.radio-pill-card:hover, .check-pill-card:hover {
    background: #f8fafc;
    border-color: #3b82f6;
    color: #1e3a8a;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(59, 130, 246, 0.12);
}

.radio-pill-card input[type="radio"], .check-pill-card input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    pointer-events: none;
    margin: 0;
}

/* Visible Radio Bullet Icon ( ) -> (•) */
.radio-pill-card::before {
    content: "";
    display: inline-block;
    width: 16px;
    height: 16px;
    min-width: 16px;
    border: 2px solid #94a3b8;
    border-radius: 50%;
    margin-right: 8px;
    background: #ffffff;
    transition: all 0.18s ease;
    box-sizing: border-box;
    vertical-align: middle;
}

.radio-pill-card:hover::before {
    border-color: #2563eb;
}

.radio-pill-card.active {
    background: #eff6ff !important;
    border-color: #2563eb !important;
    color: #1d4ed8 !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.18) !important;
}

.radio-pill-card.active::before {
    border-color: #2563eb !important;
    background: #2563eb !important;
    box-shadow: inset 0 0 0 3.5px #ffffff !important;
}

/* Visible Checkbox Square Icon [ ] -> [✓] */
.check-pill-card::before {
    content: "";
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 16px;
    height: 16px;
    min-width: 16px;
    border: 2px solid #94a3b8;
    border-radius: 4px;
    margin-right: 8px;
    background: #ffffff;
    transition: all 0.18s ease;
    box-sizing: border-box;
    font-family: FontAwesome;
    font-size: 10.5px;
    color: transparent;
    vertical-align: middle;
}

.check-pill-card:hover::before {
    border-color: #2563eb;
}

.check-pill-card.active {
    background: #eff6ff !important;
    border-color: #2563eb !important;
    color: #1d4ed8 !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.18) !important;
}

.check-pill-card.active::before {
    content: "\f00c";
    border-color: #2563eb !important;
    background: #2563eb !important;
    color: #ffffff !important;
}

/* Special Badge Exceptions */
.denver-pill::before {
    display: none !important;
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
    flex: 1;
    min-width: 36px;
    padding: 6px 2px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 6px;
    color: #334155;
    transition: all 0.15s ease;
}

.pain-scale-btn:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    transform: translateY(-1px);
}

.pain-scale-btn.active {
    background: #2e4b82;
    border-color: #2e4b82;
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(46, 75, 130, 0.25);
}

.pain-scale-btn.mini {
    padding: 4px 1px;
    min-width: 26px;
    font-size: 11px;
}

/* Symbol Selector Buttons */
.symbol-btn {
    border-radius: 6px;
    padding: 4px 8px;
    font-size: 11.5px;
    transition: all 0.15s ease;
}
.symbol-btn.active {
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    filter: brightness(0.95);
    font-weight: 800 !important;
}
</style>
@endsection

@section('script')
<script>
var currentViewMode = 'tab'; // 'tab' or 'all'

function switchViewMode(mode) {
    currentViewMode = mode;

    if (mode === 'all') {
        // Mode Tampilkan Semua Bagian
        $('#btn-mode-all').addClass('btn-primary active text-white').removeClass('btn-outline-secondary');
        $('#btn-mode-tab').removeClass('btn-primary active text-white').addClass('btn-outline-secondary');
        
        $('.tab-pane-box').show().addClass('mb-4 pb-3').css({
            'border-bottom': '2px dashed #edf2f7'
        });
        $('.tab-pane-box:last').css('border-bottom', 'none');
        
        $('.tab-navigation-footer').hide();
        $('.section-header-tab').hide();
        $('.section-title-banner').show();
        $('.assessment-tabs .nav-link').removeClass('active');
    } else {
        // Mode Per Tab
        $('#btn-mode-tab').addClass('btn-primary active text-white').removeClass('btn-outline-secondary');
        $('#btn-mode-all').removeClass('btn-primary active text-white').addClass('btn-outline-secondary');
        
        $('.tab-pane-box').removeClass('mb-4 pb-3').css({
            'border-bottom': 'none'
        }).hide();
        
        $('.tab-navigation-footer').show();
        $('.section-header-tab').show();
        $('.section-title-banner').hide();
        
        // Aktifkan tab pertama atau yang sedang dipilih
        var activeBtn = $('.assessment-tabs .nav-link.active');
        if (activeBtn.length === 0) {
            $('#tab-motorik-btn').addClass('active');
            $('#tab-motorik').fadeIn(150);
        } else {
            var targetPaneId = activeBtn.attr('href');
            $(targetPaneId).fadeIn(150);
        }
    }
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

// ----------------------------------------------------
// DOCUMENT READY INITIALIZATION
// ----------------------------------------------------
$(document).ready(function() {
    // 1. Direct Tab Clicking
    $('.assessment-tabs .nav-link').on('click', function(e) {
        e.preventDefault();
        var targetPaneId = $(this).attr('href');

        if (currentViewMode === 'all') {
            $('.assessment-tabs .nav-link').removeClass('active');
            $(this).addClass('active');
            $('html, body').animate({
                scrollTop: $(targetPaneId).offset().top - 90
            }, 300);
            return;
        }

        // Mode Per Tab
        $('.assessment-tabs .nav-link').removeClass('active');
        $(this).addClass('active');

        $('.tab-pane-box').hide();
        $(targetPaneId).fadeIn(150, function() {
            // If opening Nyeri tab, redraw canvas if needed
            if (targetPaneId === '#tab-nyeri') {
                if (markers.length > 0 || !existingChartData) {
                    drawBodyChart();
                }
            }
        });

        $('html, body').animate({
            scrollTop: $('#assessmentTab').offset().top - 80
        }, 200);
    });

    // 2. Next / Prev Tab Buttons
    $('.next-tab-btn, .prev-tab-btn').on('click', function() {
        var targetTabBtnId = $(this).data('target-tab');
        $(targetTabBtnId).trigger('click');
    });

    // Symbol Picker Selection
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

    // Clear Body Chart Button
    $(document).on('click', '#btn-clear-body-chart', function() {
        if (confirm('Bersihkan semua tanda pada gambar tubuh?')) {
            markers = [];
            existingChartData = null;
            $('#input_nyeri_body_chart').val('');
            drawBodyChart();
        }
    });

    // Undo Body Chart Button
    $(document).on('click', '#btn-undo-body-chart', function() {
        if (markers.length > 0) {
            markers.pop();
            if (markers.length === 0 && !existingChartData) {
                $('#input_nyeri_body_chart').val('');
            }
            drawBodyChart();
        }
    });

    // Form Submit Sync for Body Chart Canvas
    $('form').on('submit', function() {
        if (canvas && markers.length > 0) {
            drawBodyChart();
            $('#input_nyeri_body_chart').val(canvas.toDataURL('image/png'));
        }
    });

    // Pain Scale 0 - 10 Visual Rating Button Handler
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
    });

    // 3. Radio Pill Selection (Robust handler safe for all names including brackets)
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

    // 4. Checkbox Pill Selection
    $(document).on('change', '.check-pill-card input[type="checkbox"]', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.check-pill-card').addClass('active');
        } else {
            $(this).closest('.check-pill-card').removeClass('active');
        }
    });

    $(document).on('click', '.check-pill-card', function(e) {
        if (e.target.tagName.toLowerCase() !== 'input') {
            var chk = $(this).find('input[type="checkbox"]')[0];
            if (chk) {
                chk.checked = !chk.checked;
                $(chk).trigger('change');
            }
        }
    });

    // Sync initial active state for radio & checkbox pills on page load
    $('.radio-pill-card input[type="radio"]:checked').each(function() {
        $(this).closest('.radio-pill-card').addClass('active');
    });
    $('.check-pill-card input[type="checkbox"]:checked').each(function() {
        $(this).closest('.check-pill-card').addClass('active');
    });

    // 4b. GMFM Sub-Dimension Switcher (Dimensi A vs Dimensi B)
    $(document).on('click', '.gmfm-dim-btn', function(e) {
        e.preventDefault();
        var targetPane = $(this).data('target-dim');
        $('.gmfm-dim-btn').removeClass('btn-primary active').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary active');
        $('.gmfm-dim-pane').hide();
        $(targetPane).fadeIn(150);
    });

    // 4c. GMFM Dimensi A Live Scoring Calculation (17 items, max 51)
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

        var maxScore = 51; // 17 items x 3
        var percentage = ((totalScore / maxScore) * 100).toFixed(1);

        $('#gmfm-a-live-total').text(totalScore);
        $('#gmfm-a-live-persen').text(percentage + '%');
        $('#gmfm-a-live-progress').css('width', percentage + '%');
        $('#input-gmfm-a-total').val(totalScore);
        $('#input-gmfm-a-persen').val(percentage);

        var badgeText = 'Belum Dinilai';
        var badgeClass = 'badge-light text-dark';
        if (percentage >= 80) {
            badgeText = 'Sangat Baik (Mandiri)';
            badgeClass = 'badge-success text-white';
        } else if (percentage >= 50) {
            badgeText = 'Sedang (Perlu Stimulasi)';
            badgeClass = 'badge-info text-white';
        } else if (totalScore > 0 || answeredCount > 0) {
            badgeText = 'Keterbatasan Signifikan';
            badgeClass = 'badge-warning text-dark';
        }

        $('#gmfm-a-live-interpretation')
            .text(badgeText)
            .removeClass('badge-light badge-success badge-info badge-warning text-dark text-white')
            .addClass(badgeClass);

        updateGmfmTotalScore();
    }

    $(document).on('change', '.gmfm-a-radio', function() {
        updateGmfmALiveScore();
    });

    // 4d. GMFM Dimensi B Live Scoring Calculation (20 items, max 60)
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

        var maxScore = 60; // 20 items x 3
        var percentage = ((totalScore / maxScore) * 100).toFixed(1);

        $('#gmfm-b-live-total').text(totalScore);
        $('#gmfm-b-live-persen').text(percentage + '%');
        $('#gmfm-b-live-progress').css('width', percentage + '%');
        $('#input-gmfm-b-total').val(totalScore);
        $('#input-gmfm-b-persen').val(percentage);

        var badgeText = 'Belum Dinilai';
        var badgeClass = 'badge-light text-dark';
        if (percentage >= 80) {
            badgeText = 'Sangat Baik (Mandiri)';
            badgeClass = 'badge-success text-white';
        } else if (percentage >= 50) {
            badgeText = 'Sedang (Perlu Stimulasi)';
            badgeClass = 'badge-info text-white';
        } else if (totalScore > 0 || answeredCount > 0) {
            badgeText = 'Keterbatasan Signifikan';
            badgeClass = 'badge-warning text-dark';
        }

        $('#gmfm-b-live-interpretation')
            .text(badgeText)
            .removeClass('badge-light badge-success badge-info badge-warning text-dark text-white')
            .addClass(badgeClass);

        updateGmfmTotalScore();
    }

    $(document).on('change', '.gmfm-b-radio', function() {
        updateGmfmBLiveScore();
    });

    // 4e. GMFM Dimensi C Live Scoring Calculation (14 items, max 42)
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

        var maxScore = 42; // 14 items x 3
        var percentage = ((totalScore / maxScore) * 100).toFixed(1);

        $('#gmfm-c-live-total').text(totalScore);
        $('#gmfm-c-live-persen').text(percentage + '%');
        $('#gmfm-c-live-progress').css('width', percentage + '%');
        $('#input-gmfm-c-total').val(totalScore);
        $('#input-gmfm-c-persen').val(percentage);

        var badgeText = 'Belum Dinilai';
        var badgeClass = 'badge-light text-dark';
        if (percentage >= 80) {
            badgeText = 'Sangat Baik (Mandiri)';
            badgeClass = 'badge-success text-white';
        } else if (percentage >= 50) {
            badgeText = 'Sedang (Perlu Stimulasi)';
            badgeClass = 'badge-info text-white';
        } else if (totalScore > 0 || answeredCount > 0) {
            badgeText = 'Keterbatasan Signifikan';
            badgeClass = 'badge-warning text-dark';
        }

        $('#gmfm-c-live-interpretation')
            .text(badgeText)
            .removeClass('badge-light badge-success badge-info badge-warning text-dark text-white')
            .addClass(badgeClass);

        updateGmfmTotalScore();
    }

    $(document).on('change', '.gmfm-c-radio', function() {
        updateGmfmCLiveScore();
    });

    // 4f. GMFM Dimensi D Live Scoring Calculation (13 items, max 39)
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

        var maxScore = 39; // 13 items x 3
        var percentage = ((totalScore / maxScore) * 100).toFixed(1);

        $('#gmfm-d-live-total').text(totalScore);
        $('#gmfm-d-live-persen').text(percentage + '%');
        $('#gmfm-d-live-progress').css('width', percentage + '%');
        $('#input-gmfm-d-total').val(totalScore);
        $('#input-gmfm-d-persen').val(percentage);

        var badgeText = 'Belum Dinilai';
        var badgeClass = 'badge-light text-dark';
        if (percentage >= 80) {
            badgeText = 'Sangat Baik (Mandiri)';
            badgeClass = 'badge-success text-white';
        } else if (percentage >= 50) {
            badgeText = 'Sedang (Perlu Stimulasi)';
            badgeClass = 'badge-info text-white';
        } else if (totalScore > 0 || answeredCount > 0) {
            badgeText = 'Keterbatasan Signifikan';
            badgeClass = 'badge-warning text-dark';
        }

        $('#gmfm-d-live-interpretation')
            .text(badgeText)
            .removeClass('badge-light badge-success badge-info badge-warning text-dark text-white')
            .addClass(badgeClass);

        updateGmfmTotalScore();
    }

    $(document).on('change', '.gmfm-d-radio', function() {
        updateGmfmDLiveScore();
    });

    // 4g. GMFM Dimensi E Live Scoring Calculation (24 items, max 72)
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

        var maxScore = 72; // 24 items x 3
        var percentage = ((totalScore / maxScore) * 100).toFixed(1);

        $('#gmfm-e-live-total').text(totalScore);
        $('#gmfm-e-live-persen').text(percentage + '%');
        $('#gmfm-e-live-progress').css('width', percentage + '%');
        $('#input-gmfm-e-total').val(totalScore);
        $('#input-gmfm-e-persen').val(percentage);

        var badgeText = 'Belum Dinilai';
        var badgeClass = 'badge-light text-dark';
        if (percentage >= 80) {
            badgeText = 'Sangat Baik (Mandiri)';
            badgeClass = 'badge-success text-white';
        } else if (percentage >= 50) {
            badgeText = 'Sedang (Perlu Stimulasi)';
            badgeClass = 'badge-info text-white';
        } else if (totalScore > 0 || answeredCount > 0) {
            badgeText = 'Keterbatasan Signifikan';
            badgeClass = 'badge-warning text-dark';
        }

        $('#gmfm-e-live-interpretation')
            .text(badgeText)
            .removeClass('badge-light badge-success badge-info badge-warning text-dark text-white')
            .addClass(badgeClass);

        updateGmfmTotalScore();
    }

    $(document).on('change', '.gmfm-e-radio', function() {
        updateGmfmELiveScore();
    });

    // 4h. GMFM Overall Total Score Calculation (Sum of A-E, avg %)
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

    // 4i. Skala Denver (DDST II) Live Scoring & Automated Interpretation
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

    $(document).on('change', '.denver-radio', function() {
        updateDenverLiveScore();
    });

    // 5. Pain Scale 0-10 Button Selection
    $('.pain-scale-btn').on('click', function() {
        var targetInput = $(this).data('target');
        var targetLabel = $(this).data('label');
        var val = $(this).data('val');

        $(this).closest('.pain-scale-group').find('.pain-scale-btn').removeClass('active');
        $(this).addClass('active');
        $(targetInput).val(val);

        var descText = '';
        var colorBadge = '#e2e8f0';
        var textCol = '#1e293b';

        if (val == 0) {
            descText = '0/10 (Tidak Nyeri)';
            colorBadge = '#dcfce7'; textCol = '#166534';
        } else if (val <= 3) {
            descText = val + '/10 (Nyeri Ringan)';
            colorBadge = '#fef9c3'; textCol = '#854d0e';
        } else if (val <= 6) {
            descText = val + '/10 (Nyeri Sedang)';
            colorBadge = '#ffedd5'; textCol = '#9a3412';
        } else if (val <= 9) {
            descText = val + '/10 (Nyeri Berat)';
            colorBadge = '#fee2e2'; textCol = '#991b1b';
        } else if (val == 10) {
            descText = '10/10 (Sangat Hebat)';
            colorBadge = '#7f1d1d'; textCol = '#ffffff';
        }

        $(targetLabel).text(descText).css({
            'background': colorBadge,
            'color': textCol
        });
    });

    // 6. Symbol Selector in Body Chart
    $('.symbol-btn').on('click', function() {
        $('.symbol-btn').removeClass('active');
        $(this).addClass('active');
        currentSymbol = $(this).data('symbol');
        currentColor = $(this).data('color');
    });

    // 7. Clear & Undo Body Chart
    $('#btn-clear-body-chart').on('click', function() {
        if (confirm('Bersihkan semua penanda pada gambar anatomi?')) {
            markers = [];
            drawBodyChart();
        }
    });

    $('#btn-undo-body-chart').on('click', function() {
        if (markers.length > 0) {
            markers.pop();
            drawBodyChart();
        }
    });
});

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
</script>
@endsection

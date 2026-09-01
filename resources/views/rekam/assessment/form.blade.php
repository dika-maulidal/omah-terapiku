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
                    <a class="nav-link font-w600" id="tab-adl-btn" href="#tab-adl" data-target-section="#tab-adl">
                        <i class="fa fa-tasks mr-1"></i> 2. Aktivitas (ADL) <span class="badge badge-primary light font-w600 ml-1">9</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-wicara-btn" href="#tab-wicara" data-target-section="#tab-wicara">
                        <i class="fa fa-comments mr-1"></i> 3. Wicara <span class="badge badge-primary light font-w600 ml-1">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-penglihatan-btn" href="#tab-penglihatan" data-target-section="#tab-penglihatan">
                        <i class="fa fa-eye mr-1"></i> 4. Penglihatan <span class="badge badge-primary light font-w600 ml-1">Netra</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-nyeri-btn" href="#tab-nyeri" data-target-section="#tab-nyeri">
                        <i class="fa fa-heartbeat mr-1"></i> 5. Nyeri & Anatomi <span class="badge badge-primary light font-w600 ml-1">0-10</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-rom-btn" href="#tab-rom" data-target-section="#tab-rom">
                        <i class="fa fa-wheelchair mr-1"></i> 6. ROM & MMT
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-neuro-btn" href="#tab-neuro" data-target-section="#tab-neuro">
                        <i class="fa fa-bolt mr-1"></i> 7. Neurologis <span class="badge badge-primary light font-w600 ml-1">Saraf</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-postur-btn" href="#tab-postur" data-target-section="#tab-postur">
                        <i class="fa fa-male mr-1"></i> 8. Postur & Keseimbangan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-gait-btn" href="#tab-gait" data-target-section="#tab-gait">
                        <i class="fa fa-blind mr-1"></i> 9. Gait (Pola Jalan)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-w600" id="tab-evaluasi-btn" href="#tab-evaluasi" data-target-section="#tab-evaluasi">
                        <i class="fa fa-medkit mr-1"></i> 10. Evaluasi & Terapi
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
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-adl-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 2 (ADL) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 2. BAGIAN KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL) -->
                <div class="tab-pane-box" id="tab-adl" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            2. Kemampuan Aktivitas Sehari-hari (ADL)
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">2</span>
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
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-motorik-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Motorik
                        </button>
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-wicara-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 3 (Wicara) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 3. BAGIAN KEMAMPUAN WICARA -->
                <div class="tab-pane-box" id="tab-wicara" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            3. Kemampuan Wicara & Komunikasi
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">3</span>
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
                        <button type="button" class="btn btn-sm btn-primary next-tab-btn" data-target-tab="#tab-evaluasi-btn" style="padding: 7px 18px; font-size: 12.5px;">
                            Lanjut ke Bagian 10 (Evaluasi) <i class="fa fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- 10. BAGIAN EVALUASI & RENCANA TERAPI -->
                <div class="tab-pane-box" id="tab-evaluasi" style="display: none;">
                    <div class="section-title-banner p-2 px-3 rounded mb-3" style="background: #edf3fc; border-left: 4px solid #2e4b82; display: none;">
                        <h5 class="font-w700 mb-0 text-primary" style="font-size: 15px;">
                            10. Kesimpulan & Rekomendasi Terapi
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 section-header-tab" style="border-bottom: 1px solid #edf2f7;">
                        <h5 class="font-w700 mb-0" style="font-size: 15.5px; color: var(--ot-navy) !important;">
                            <span class="badge badge-primary mr-2" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">10</span>
                            Kesimpulan & Rekomendasi Terapi
                        </h5>
                        <small class="text-muted">Tuliskan kesimpulan klinis terapis dan rencana program terapi lanjutan</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                                <i class="fa fa-file-text-o text-primary mr-1"></i> Kesimpulan & Evaluasi Klinis
                            </label>
                            <textarea name="kesimpulan" class="form-control" rows="4" placeholder="Ringkasan hasil evaluasi asesmen klinis penerima manfaat..." style="font-size: 13px;">{{ old('kesimpulan', $assessment->kesimpulan) }}</textarea>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                                <i class="fa fa-calendar-check-o text-primary mr-1"></i> Rencana Program Terapi Lanjutan
                            </label>
                            <textarea name="rencana_terapi" class="form-control" rows="4" placeholder="Target intervensi, rekomendasi frekuensi terapi, saran latihan..." style="font-size: 13px;">{{ old('rencana_terapi', $assessment->rencana_terapi) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3 pt-2 tab-navigation-footer" style="border-top: 1px solid #edf2f7;">
                        <button type="button" class="btn btn-sm btn-light prev-tab-btn" data-target-tab="#tab-gait-btn" style="padding: 7px 16px; font-size: 12.5px;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Gaya Berjalan (Gait)
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

/* Custom Radio & Check Pill Card Styling */
.radio-pill-card, .check-pill-card {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 7px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 500;
    color: #334155;
    transition: all 0.18s ease-in-out;
    user-select: none;
    margin-bottom: 0;
}

.radio-pill-card:hover, .check-pill-card:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    transform: translateY(-1px);
}

.radio-pill-card input[type="radio"], .check-pill-card input[type="checkbox"] {
    display: none;
}

.radio-pill-card.active, .check-pill-card.active {
    background: #ebf5ff;
    border-color: #2e4b82;
    color: #2e4b82;
    font-weight: 700;
    box-shadow: 0 2px 6px rgba(46, 75, 130, 0.15);
}

.radio-pill-card.active::before, .check-pill-card.active::before {
    content: "\f00c";
    font-family: FontAwesome;
    margin-right: 5px;
    font-size: 11px;
    color: #2e4b82;
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
// BODY CHART CANVAS LOGIC
// ----------------------------------------------------
var canvas = document.getElementById('bodyChartCanvas');
var ctx = canvas ? canvas.getContext('2d') : null;
var bodyImg = new Image();
bodyImg.src = "{{ asset('images/body.png') }}";

var currentSymbol = '~';
var currentColor = '#dc2626';
var markers = []; // Array of {x, y, symbol, color}

bodyImg.onload = function() {
    drawBodyChart();
};

function drawBodyChart() {
    if (!ctx) return;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Draw background anatomy image centered
    var hRatio = canvas.width / bodyImg.width;
    var vRatio = canvas.height / bodyImg.height;
    var ratio  = Math.min(hRatio, vRatio);
    var centerShift_x = (canvas.width - bodyImg.width * ratio) / 2;
    var centerShift_y = (canvas.height - bodyImg.height * ratio) / 2;
    
    ctx.drawImage(bodyImg, 0, 0, bodyImg.width, bodyImg.height,
                  centerShift_x, centerShift_y, bodyImg.width * ratio, bodyImg.height * ratio);
    
    // Draw all markers
    markers.forEach(function(m) {
        ctx.save();
        ctx.fillStyle = m.color;
        ctx.font = 'bold 18px Arial, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        
        // Circular backdrop for high contrast
        ctx.beginPath();
        ctx.arc(m.x, m.y, 11, 0, 2 * Math.PI);
        ctx.fillStyle = 'rgba(255, 255, 255, 0.85)';
        ctx.fill();
        ctx.lineWidth = 1.5;
        ctx.strokeStyle = m.color;
        ctx.stroke();
        
        // Draw symbol
        ctx.fillStyle = m.color;
        ctx.fillText(m.symbol, m.x, m.y + 1);
        ctx.restore();
    });

    // Update hidden input with canvas dataURL
    $('#input_nyeri_body_chart').val(canvas.toDataURL('image/png'));
}

if (canvas) {
    canvas.addEventListener('click', function(e) {
        var rect = canvas.getBoundingClientRect();
        var scaleX = canvas.width / rect.width;
        var scaleY = canvas.height / rect.height;
        
        var x = (e.clientX - rect.left) * scaleX;
        var y = (e.clientY - rect.top) * scaleY;
        
        markers.push({
            x: x,
            y: y,
            symbol: currentSymbol,
            color: currentColor
        });
        
        drawBodyChart();
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
        $(targetPaneId).fadeIn(150);

        $('html, body').animate({
            scrollTop: $('#assessmentTab').offset().top - 80
        }, 200);
    });

    // 2. Next / Prev Tab Buttons
    $('.next-tab-btn, .prev-tab-btn').on('click', function() {
        var targetTabBtnId = $(this).data('target-tab');
        $(targetTabBtnId).trigger('click');
    });

    // 3. Radio Pill Selection
    $(document).on('click', '.radio-pill-card', function() {
        var radio = $(this).find('input[type="radio"]');
        var groupName = radio.attr('name');
        $('input[name="' + groupName + '"]').closest('.radio-pill-card').removeClass('active');
        radio.prop('checked', true);
        $(this).addClass('active');
        radio.trigger('change');
    });

    // 4. Checkbox Pill Selection
    $(document).on('change', '.check-pill-card input[type="checkbox"]', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.check-pill-card').addClass('active');
        } else {
            $(this).closest('.check-pill-card').removeClass('active');
        }
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

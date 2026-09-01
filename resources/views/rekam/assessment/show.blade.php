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
                            <td><strong class="text-primary">{{ $assessment->motorik_mengangkat_kepala ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Posisi Tengkurap</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->motorik_posisi_tengkurap ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Posisi Duduk</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->motorik_posisi_duduk ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Merangkak</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->motorik_merangkak ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Berlutut</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->motorik_berlutut ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Berjalan</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->motorik_berjalan ?: '-' }}</strong></td>
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

    <!-- 2. Kemampuan Aktivitas Sehari-hari (ADL) -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-tasks text-primary mr-2"></i> 2. Kemampuan Aktivitas Sehari-hari (ADL)
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size: 13px;">
                    <tbody>
                        <tr>
                            <td style="width: 50%; font-weight: 600; color: #475569;">Kontak Mata</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_kontak_mata ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Duduk Tenang Saat Aktivitas</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_duduk_tenang ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Gerakan Berulang Tanpa Tujuan</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_gerakan_berulang ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Respon Saat Dipanggil Nama</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_respon_nama ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Makan</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_makan ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Mandi</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_mandi ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">Berpakaian</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_berpakaian ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">BAK (Buang Air Kecil)</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_bak ?: '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #475569;">BAB (Buang Air Besar)</td>
                            <td>:</td>
                            <td><strong class="text-primary">{{ $assessment->adl_bab ?: '-' }}</strong></td>
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

    <!-- 10. Kesimpulan & Rekomendasi Terapi -->
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header py-3" style="background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: 1px solid #edf2f7;">
                <h5 class="font-w700 mb-0" style="font-size: 15px; color: var(--ot-navy) !important;">
                    <i class="fa fa-medkit text-primary mr-2"></i> 10. Evaluasi & Rencana Terapi
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <span class="text-muted font-w600 d-block mb-1" style="font-size: 12.5px; text-transform: uppercase;">
                        Kesimpulan & Evaluasi Klinis:
                    </span>
                    <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7; font-size: 13px; color: #1e293b; line-height: 1.5;">
                        {{ $assessment->kesimpulan ?: '-' }}
                    </div>
                </div>

                <div>
                    <span class="text-muted font-w600 d-block mb-1" style="font-size: 12.5px; text-transform: uppercase;">
                        Rencana Program Terapi Lanjutan:
                    </span>
                    <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7; font-size: 13px; color: #1e293b; line-height: 1.5;">
                        {{ $assessment->rencana_terapi ?: '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

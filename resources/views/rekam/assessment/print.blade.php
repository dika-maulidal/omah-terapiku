<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Assessment - {{ $pasien->nama }} (RM# {{ $pasien->no_rm }})</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f1f5f9;
            color: #1e293b;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 13px;
        }

        .print-container {
            max-width: 850px;
            margin: 20px auto;
            background: #fff;
            padding: 35px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .kop-header {
            border-bottom: 2.5px solid #2e4b82;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .section-title {
            background: #f1f5f9;
            color: #2e4b82;
            font-weight: 700;
            font-size: 13.5px;
            padding: 6px 12px;
            border-radius: 4px;
            margin-top: 18px;
            margin-bottom: 10px;
            border-left: 4px solid #2e4b82;
        }

        .table-assessment {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-assessment th, .table-assessment td {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            font-size: 12.5px;
        }

        .table-assessment th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 600;
        }

        .badge-val {
            display: inline-block;
            font-weight: 600;
            color: #0f172a;
        }

        @media print {
            body {
                background: #fff;
                color: #000;
            }
            .print-container {
                max-width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="container no-print mt-3 text-center">
    <button onclick="window.print()" class="btn btn-primary btn-sm px-4 mr-2" style="font-weight: 600;">
        <i class="fa fa-print mr-1"></i> Cetak Dokumen / Simpan PDF
    </button>
    <a href="{{ route('rekam.detail', $pasien->id) }}" class="btn btn-outline-secondary btn-sm px-3">
        <i class="fa fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="print-container">
    <!-- Kop Header -->
    <div class="kop-header d-flex align-items-center justify-content-between">
        <div>
            <h3 style="font-weight: 800; color: #2e4b82; margin: 0; font-size: 22px; letter-spacing: 0.5px;">OMAH TERAPIKU</h3>
            <p style="margin: 2px 0 0 0; font-size: 12px; color: #64748b;">
                Pusat Pelayanan Terapi & Rehabilitasi Disabilitas
            </p>
            <small style="color: #64748b; font-size: 11px;">
                Lokasi: {{ $rekam->poli }} &bull; Layanan: {{ $rekam->layanan_terapi ?: 'Terapi Terpadu' }}
            </small>
        </div>
        <div class="text-right">
            <div style="font-size: 15px; font-weight: 700; color: #2e4b82;">LEMBAR ASSESSMENT KLINIS</div>
            <div style="font-size: 11.5px; color: #475569;">Tgl Asesmen: <strong>{{ $assessment->tgl_assessment ? $assessment->tgl_assessment->format('d/m/Y') : date('d/m/Y') }}</strong></div>
            <div style="font-size: 11.5px; color: #475569;">No. RM: <strong>{{ $pasien->no_rm }}</strong></div>
        </div>
    </div>

    <!-- Data Pasien -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 15px;">
        <div class="row">
            <div class="col-6">
                <table style="width: 100%; font-size: 12px;">
                    <tr>
                        <td style="width: 35%; color: #64748b;">Nama Penerima</td>
                        <td style="width: 3%;">:</td>
                        <td><strong>{{ $pasien->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">NIK</td>
                        <td>:</td>
                        <td>{{ $pasien->nik ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">TTL / Usia</td>
                        <td>:</td>
                        <td>{{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ?: '-' }} ({{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->age . ' Tahun' : '-' }})</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ $pasien->jk ?: '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table style="width: 100%; font-size: 12px;">
                    <tr>
                        <td style="width: 35%; color: #64748b;">Wali / Orang Tua</td>
                        <td style="width: 3%;">:</td>
                        <td>{{ $pasien->nama_wali ? $pasien->nama_wali . ' (' . ($pasien->hubungan_wali ?: 'Wali') . ')' : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Disabilitas</td>
                        <td>:</td>
                        <td>{{ $pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada' ? $pasien->jenis_disabilitas : 'Non-Disabilitas' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">No. HP</td>
                        <td>:</td>
                        <td>{{ $pasien->no_hp ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Terapis Pemeriksa</td>
                        <td>:</td>
                        <td><strong>{{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? '-') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- 1. Kemampuan Motorik -->
    <div class="section-title">1. KEMAMPUAN MOTORIK</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Mengangkat Kepala</td>
                <td><span class="badge-val">{{ $assessment->motorik_mengangkat_kepala ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Posisi Tengkurap</td>
                <td><span class="badge-val">{{ $assessment->motorik_posisi_tengkurap ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Posisi Duduk</td>
                <td><span class="badge-val">{{ $assessment->motorik_posisi_duduk ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Merangkak</td>
                <td><span class="badge-val">{{ $assessment->motorik_merangkak ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Berlutut</td>
                <td><span class="badge-val">{{ $assessment->motorik_berlutut ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Berjalan</td>
                <td><span class="badge-val">{{ $assessment->motorik_berjalan ?: '-' }}</span></td>
            </tr>
        </tbody>
    </table>
    @if($assessment->motorik_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan Motorik: {{ $assessment->motorik_catatan }}</em>
        </div>
    @endif

    <!-- 2. Kemampuan Aktivitas Sehari-hari -->
    <div class="section-title">2. KEMAMPUAN AKTIVITAS SEHARI-HARI (ADL)</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Kontak Mata</td>
                <td><span class="badge-val">{{ $assessment->adl_kontak_mata ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Bisa Duduk Tenang Saat Melakukan Aktivitas</td>
                <td><span class="badge-val">{{ $assessment->adl_duduk_tenang ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Gerakan Berulang dan Tidak Bertujuan</td>
                <td><span class="badge-val">{{ $assessment->adl_gerakan_berulang ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Merespon Saat Dipanggil Nama</td>
                <td><span class="badge-val">{{ $assessment->adl_respon_nama ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Makan</td>
                <td><span class="badge-val">{{ $assessment->adl_makan ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Mandi</td>
                <td><span class="badge-val">{{ $assessment->adl_mandi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td>Berpakaian</td>
                <td><span class="badge-val">{{ $assessment->adl_berpakaian ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">8</td>
                <td>BAK (Buang Air Kecil)</td>
                <td><span class="badge-val">{{ $assessment->adl_bak ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">9</td>
                <td>BAB (Buang Air Besar)</td>
                <td><span class="badge-val">{{ $assessment->adl_bab ?: '-' }}</span></td>
            </tr>
        </tbody>
    </table>
    @if($assessment->adl_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan ADL: {{ $assessment->adl_catatan }}</em>
        </div>
    @endif

    <!-- 3. Kemampuan Wicara -->
    <div class="section-title">3. KEMAMPUAN WICARA & KOMUNIKASI</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Kemampuan Berkomunikasi</td>
                <td><span class="badge-val">{{ $assessment->wicara_komunikasi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Kondisi Organ Bicara & Pendengaran</td>
                <td>
                    <span class="badge-val">{{ $assessment->wicara_organ ?: '-' }}</span>
                    @if($assessment->wicara_organ_keterangan)
                        <br><small class="text-muted">({{ $assessment->wicara_organ_keterangan }})</small>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Kemampuan Makan, Minum, Mengunyah & Menelan</td>
                <td>
                    <span class="badge-val">{{ $assessment->wicara_makan_menelan ?: '-' }}</span>
                    @if($assessment->wicara_makan_menelan_keterangan)
                        <br><small class="text-muted">({{ $assessment->wicara_makan_menelan_keterangan }})</small>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if($assessment->wicara_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan Wicara: {{ $assessment->wicara_catatan }}</em>
        </div>
    @endif

    <!-- 4. Status Penglihatan (Netra) -->
    <div class="section-title">4. STATUS PENGLIHATAN (ASESMEN NETRA)</div>
    <table class="table-assessment">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 44%;">Indikator Penilaian</th>
                <th style="width: 50%;">Hasil Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Klasifikasi Penglihatan</td>
                <td><span class="badge-val">{{ $assessment->penglihatan_klasifikasi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Onset & Sisi</td>
                <td>
                    <span class="badge-val">{{ $assessment->penglihatan_onset ?: '-' }}</span>
                    @if($assessment->penglihatan_sisi)
                        <span class="badge-val">({{ $assessment->penglihatan_sisi }})</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Usia Onset & Durasi</td>
                <td>
                    {{ $assessment->penglihatan_usia_onset ? $assessment->penglihatan_usia_onset . ' Thn' : '-' }} / 
                    {{ $assessment->penglihatan_durasi ? 'Durasi: ' . $assessment->penglihatan_durasi . ' Thn' : '-' }}
                </td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Etiologi / Diagnosis Medis</td>
                <td><span class="badge-val">{{ $assessment->penglihatan_etiologi ?: '-' }}</span></td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Progresif? & Terakhir Periksa</td>
                <td>
                    Progresif: {{ $assessment->penglihatan_progresif ?: '-' }} 
                    {{ $assessment->penglihatan_terakhir_periksa ? ' &bull; Terakhir: ' . $assessment->penglihatan_terakhir_periksa : '' }}
                </td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Visus OD & OS (Low Vision)</td>
                <td>OD: {{ $assessment->penglihatan_visus_od ?: '-' }} &bull; OS: {{ $assessment->penglihatan_visus_os ?: '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td>Persepsi Cahaya & Sisi Visual</td>
                <td>
                    Persepsi Cahaya: {{ $assessment->penglihatan_persepsi_cahaya ?: '-' }} &bull; 
                    Preferensi: {{ $assessment->penglihatan_preferensi_sisi ?: '-' }}
                </td>
            </tr>
            <tr>
                <td class="text-center">8</td>
                <td>Alat Bantu yang Digunakan</td>
                <td>
                    @if(is_array($assessment->penglihatan_alat_bantu) && count($assessment->penglihatan_alat_bantu) > 0)
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach($assessment->penglihatan_alat_bantu as $alat)
                                <li>
                                    {{ $alat }}
                                    @if($alat == 'Tongkat putih' && $assessment->penglihatan_teknik_tongkat)
                                        (Teknik: {{ $assessment->penglihatan_teknik_tongkat }})
                                    @elseif($alat == 'Lainnya' && $assessment->penglihatan_alat_bantu_lainnya)
                                        ({{ $assessment->penglihatan_alat_bantu_lainnya }})
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span>-</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if($assessment->penglihatan_catatan)
        <div style="font-size: 12px; color: #334155; margin-bottom: 10px;">
            <em>Catatan Penglihatan: {{ $assessment->penglihatan_catatan }}</em>
        </div>
    @endif

    <!-- 5. Intensitas Nyeri & Body Chart -->
    <div class="section-title">5. INTENSITAS NYERI & BODY CHART</div>
    <div class="row mb-3" style="page-break-inside: avoid;">
        <div class="col-7">
            <table class="table-assessment">
                <thead>
                    <tr>
                        <th style="width: 45%;">Indikator Nyeri</th>
                        <th style="width: 55%;">Hasil Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Skor Total Nyeri (VAS)</strong></td>
                        <td>
                            @if($assessment->nyeri_skor_total !== null)
                                <span class="badge-val">
                                    {{ $assessment->nyeri_skor_total }} / 10
                                    @if($assessment->nyeri_skor_total == 0) (Tidak Nyeri)
                                    @elseif($assessment->nyeri_skor_total <= 3) (Nyeri Ringan)
                                    @elseif($assessment->nyeri_skor_total <= 6) (Nyeri Sedang)
                                    @elseif($assessment->nyeri_skor_total <= 9) (Nyeri Berat)
                                    @elseif($assessment->nyeri_skor_total == 10) (Sangat Hebat)
                                    @endif
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Saat Istirahat</td>
                        <td>{{ $assessment->nyeri_saat_istirahat !== null ? $assessment->nyeri_saat_istirahat . ' / 10' : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Saat Aktivitas</td>
                        <td>{{ $assessment->nyeri_saat_aktivitas !== null ? $assessment->nyeri_saat_aktivitas . ' / 10' : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Sifat Nyeri</td>
                        <td>
                            @if(is_array($assessment->nyeri_sifat) && count($assessment->nyeri_sifat) > 0)
                                {{ implode(', ', array_map(function($s) use ($assessment) {
                                    return $s == 'Lainnya' && $assessment->nyeri_sifat_lainnya ? 'Lainnya (' . $assessment->nyeri_sifat_lainnya . ')' : $s;
                                }, $assessment->nyeri_sifat)) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Deskripsi Area Keluhan</td>
                        <td>{{ $assessment->nyeri_lokasi_keluhan ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>
            @if($assessment->nyeri_catatan)
                <div style="font-size: 11.5px; color: #334155; margin-top: 4px;">
                    <em>Catatan Nyeri: {{ $assessment->nyeri_catatan }}</em>
                </div>
            @endif
        </div>
        <div class="col-5 text-center">
            <div style="border: 1px solid #cbd5e1; border-radius: 4px; padding: 6px; background: #fafafa;">
                <div style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px;">PETA LOKASI KELUHAN (BODY CHART)</div>
                @if($assessment->nyeri_body_chart)
                    <img src="{{ $assessment->nyeri_body_chart }}" alt="Body Chart" style="max-height: 170px; max-width: 100%;">
                @else
                    <img src="{{ asset('images/body.png') }}" alt="Body Chart" style="max-height: 170px; max-width: 100%; opacity: 0.6;">
                @endif
                <div style="font-size: 9.5px; color: #64748b; margin-top: 3px;">
                    Simbol: <strong>~</strong> Nyeri | <strong>#</strong> Kesemutan | <strong>-</strong> Kelemahan | <strong>/</strong> Bengkak | <strong>X</strong> Kaku
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
    <div class="section-title">6. LINGKUP GERAK SENDI (ROM) & KEKUATAN OTOT (MMT)</div>
    <table class="table-assessment" style="font-size: 11px;">
        <thead>
            <tr>
                <th style="text-align: left; width: 24%;">Gerakan / Sendi</th>
                <th style="width: 10%; text-align: center;">Fleksi</th>
                <th style="width: 10%; text-align: center;">Ekstensi</th>
                <th style="width: 9%; text-align: center;">Abd</th>
                <th style="width: 9%; text-align: center;">Add</th>
                <th style="width: 9%; text-align: center;">IR</th>
                <th style="width: 9%; text-align: center;">ER</th>
                <th style="width: 10%; text-align: center;">Lainnya</th>
                <th style="width: 10%; text-align: center;">MMT (0-5)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rom_labels as $key => $lbl)
                @php $item = $rom_data[$key] ?? []; @endphp
                <tr>
                    <td><strong>{{ $key === 'custom' && !empty($item['nama']) ? 'Sendi: ' . $item['nama'] : $lbl }}</strong></td>
                    <td class="text-center">{{ $item['fleksi'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['ekstensi'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['abd'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['add'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['ir'] ?? '-' }}</td>
                    <td class="text-center">{{ $item['er'] ?? '-' }}</td>
                    <td>{{ $item['lainnya'] ?? '-' }}</td>
                    <td class="text-center"><strong>{{ isset($item['mmt']) && $item['mmt'] !== '' ? 'Nilai ' . $item['mmt'] : '-' }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($assessment->rom_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan ROM & MMT: {{ $assessment->rom_catatan }}</em>
        </div>
    @endif

    <!-- 7. Pemeriksaan Neurologis -->
    <div class="section-title">7. PEMERIKSAAN NEUROLOGIS (SISTEM SARAF)</div>
    <table class="table-assessment" style="margin-bottom: 8px;">
        <thead>
            <tr>
                <th style="width: 25%;">Indikator Neurologis</th>
                <th style="width: 75%;">Hasil Pemeriksaan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Sensasi</strong></td>
                <td>
                    {{ $assessment->neuro_sensasi ?: '-' }}
                    @if($assessment->neuro_sensasi_area)
                        &bull; <em>Area: {{ $assessment->neuro_sensasi_area }}</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Tonus Otot</strong></td>
                <td>{{ $assessment->neuro_tonus_otot ?: '-' }}</td>
            </tr>
            <tr>
                <td><strong>Refleks Tendon (D/S)</strong></td>
                <td>
                    Bisep: <strong>{{ $assessment->neuro_refleks_bisep_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_bisep_s ?: '-' }}</strong> &bull;
                    Trisep: <strong>{{ $assessment->neuro_refleks_trisep_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_trisep_s ?: '-' }}</strong> &bull;
                    Patela: <strong>{{ $assessment->neuro_refleks_patela_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_patela_s ?: '-' }}</strong> &bull;
                    Achilles: <strong>{{ $assessment->neuro_refleks_achilles_d ?: '-' }}</strong> / <strong>{{ $assessment->neuro_refleks_achilles_s ?: '-' }}</strong>
                    <span style="font-size: 10px; color: #64748b;">(D: Kanan / S: Kiri)</span>
                </td>
            </tr>
            <tr>
                <td><strong>Tes Koordinasi</strong></td>
                <td>
                    @if(is_array($assessment->neuro_koordinasi) && count($assessment->neuro_koordinasi) > 0)
                        {{ implode(', ', array_map(function($k) use ($assessment) {
                            return $k == 'Lainnya' && $assessment->neuro_koordinasi_lainnya ? 'Lainnya (' . $assessment->neuro_koordinasi_lainnya . ')' : $k;
                        }, $assessment->neuro_koordinasi)) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if($assessment->neuro_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Neurologis: {{ $assessment->neuro_catatan }}</em>
        </div>
    @endif

    <!-- 8. Pemeriksaan Postur & Keseimbangan -->
    <div class="section-title">8. PEMERIKSAAN POSTUR & KESEIMBANGAN</div>
    <div class="row mb-2">
        <div class="col-5">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th>Temuan Postur (Observasi / Palpasi)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if(is_array($assessment->postur_temuan) && count($assessment->postur_temuan) > 0)
                                <ul style="margin: 0; padding-left: 16px;">
                                    @foreach($assessment->postur_temuan as $pt)
                                        <li>{{ $pt }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>- Tidak ada kelainan postur khusus</span>
                            @endif
                            <div style="margin-top: 4px; border-top: 1px dashed #e2e8f0; padding-top: 3px;">
                                <strong>Postur Tangan Tongkat:</strong> {{ $assessment->postur_tangan_tongkat ?: '-' }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-7">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th>Instrumen Keseimbangan</th>
                        <th style="width: 25%; text-align: center;">Skor / Waktu</th>
                        <th style="width: 35%;">Nilai Normal / Cut-off</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Berg Balance Scale (BBS)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_bbs_skor !== null ? $assessment->keseimbangan_bbs_skor . '/56' : '-' }}</strong></td>
                        <td>&lt; 45 (Risiko jatuh tinggi)</td>
                    </tr>
                    <tr>
                        <td>Timed Up and Go (TUG)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_tug_detik ? $assessment->keseimbangan_tug_detik . 's' : '-' }}</strong></td>
                        <td>&gt; 13,5s (Risiko jatuh)</td>
                    </tr>
                    <tr>
                        <td>Romberg Test (Mata Tertutup)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_romberg ?: '-' }}</strong></td>
                        <td>Positif (Defisit propriosepsi)</td>
                    </tr>
                    <tr>
                        <td>One-Leg Stance (OLS)</td>
                        <td class="text-center">
                            D: {{ $assessment->keseimbangan_ols_kanan ? $assessment->keseimbangan_ols_kanan . 's' : '-' }} &bull;
                            S: {{ $assessment->keseimbangan_ols_kiri ? $assessment->keseimbangan_ols_kiri . 's' : '-' }}
                        </td>
                        <td>&lt; 5s (Risiko jatuh)</td>
                    </tr>
                    <tr>
                        <td>Dual-Task TUG</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_dual_task_tug ? $assessment->keseimbangan_dual_task_tug . 's' : '-' }}</strong></td>
                        <td>Selisih &gt; 4,5s dari TUG</td>
                    </tr>
                    <tr>
                        <td>Falls Efficacy Scale (FES-I)</td>
                        <td class="text-center"><strong>{{ $assessment->keseimbangan_fesi_skor !== null ? $assessment->keseimbangan_fesi_skor . '/64' : '-' }}</strong></td>
                        <td>&gt; 28 (Ketakutan jatuh tinggi)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if($assessment->postur_keseimbangan_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Keseimbangan & Kompensasi: {{ $assessment->postur_keseimbangan_catatan }}</em>
        </div>
    @endif

    <!-- 9. Pemeriksaan Gaya Berjalan (Gait) -->
    <div class="section-title">9. PEMERIKSAAN GAYA BERJALAN (GAIT)</div>
    <div class="row mb-2">
        <div class="col-6">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th>Karakteristik Pola Berjalan (Gait)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if(is_array($assessment->gait_karakteristik) && count($assessment->gait_karakteristik) > 0)
                                <ul style="margin: 0; padding-left: 16px;">
                                    @foreach($assessment->gait_karakteristik as $gk)
                                        <li>{{ $gk }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>- Pola berjalan dalam batas normal</span>
                            @endif
                            <div style="margin-top: 4px; border-top: 1px dashed #e2e8f0; padding-top: 3px;">
                                <strong>Deteksi Tekstur Lantai:</strong> {{ $assessment->gait_deteksi_lantai ?: '-' }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <table class="table-assessment" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">10-Meter Walk Test (10MWT)</th>
                    </tr>
                    <tr>
                        <th style="width: 33%; text-align: center;">Kecepatan Nyaman</th>
                        <th style="width: 33%; text-align: center;">Kecepatan Cepat</th>
                        <th style="width: 34%; text-align: center;">Jumlah Langkah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"><strong>{{ $assessment->gait_10mwt_kecepatan_nyaman ? $assessment->gait_10mwt_kecepatan_nyaman . ' m/s' : '-' }}</strong></td>
                        <td class="text-center"><strong>{{ $assessment->gait_10mwt_kecepatan_cepat ? $assessment->gait_10mwt_kecepatan_cepat . ' m/s' : '-' }}</strong></td>
                        <td class="text-center"><strong>{{ $assessment->gait_10mwt_jumlah_langkah ? $assessment->gait_10mwt_jumlah_langkah . ' langkah' : '-' }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if($assessment->gait_catatan)
        <div style="font-size: 11.5px; color: #334155; margin-bottom: 8px;">
            <em>Catatan Pola Berjalan: {{ $assessment->gait_catatan }}</em>
        </div>
    @endif

    <!-- 10. Kesimpulan & Rencana Terapi -->
    <div class="section-title">10. KESIMPULAN & RENCANA TERAPI</div>
    <div style="border: 1px solid #cbd5e1; border-radius: 4px; padding: 8px 12px; margin-bottom: 12px; font-size: 12.5px;">
        <div style="margin-bottom: 6px;">
            <strong>Kesimpulan & Evaluasi Klinis:</strong>
            <p style="margin: 3px 0 0 0; color: #334155;">{{ $assessment->kesimpulan ?: '-' }}</p>
        </div>
        <div style="border-top: 1px dashed #e2e8f0; padding-top: 6px;">
            <strong>Rencana Terapi Lanjutan:</strong>
            <p style="margin: 3px 0 0 0; color: #334155;">{{ $assessment->rencana_terapi ?: '-' }}</p>
        </div>
    </div>

    <!-- Tanda Tangan Section -->
    <div class="row mt-4 pt-2" style="page-break-inside: avoid;">
        <div class="col-6"></div>
        <div class="col-6 text-center">
            <div style="font-size: 12px; color: #475569;">
                {{ $rekam->poli ?: 'Omah Terapiku' }}, {{ date('d F Y') }}
            </div>
            <div style="font-size: 12.5px; font-weight: 600; margin-top: 4px;">Terapis / Tenaga Medis Pemeriksa,</div>
            <div style="height: 65px;"></div>
            <div style="font-weight: 700; text-decoration: underline; font-size: 13px;">
                {{ $assessment->dokter->nama ?? ($rekam->dokter->nama ?? 'Terapis Omah Terapiku') }}
            </div>
            @if(isset($assessment->dokter->nip) || (isset($rekam->dokter) && $rekam->dokter->nip))
                <div style="font-size: 11.5px; color: #64748b;">
                    NIP: {{ $assessment->dokter->nip ?? $rekam->dokter->nip }}
                </div>
            @endif
        </div>
    </div>

</div>

</body>
</html>

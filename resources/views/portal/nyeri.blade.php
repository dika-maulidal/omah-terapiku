@extends('portal.layout.apps')

@section('title', 'Evaluasi Nyeri & Fisik')

@section('style')
<style>
    .nyeri-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .nyeri-table th {
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #475569;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 11px 16px;
    }
    .nyeri-table td {
        padding: 11px 16px;
        vertical-align: middle;
    }
    .vas-bar-container {
        height: 10px;
        border-radius: 6px;
        background: linear-gradient(to right, #10b981 0%, #84cc16 30%, #eab308 60%, #f97316 80%, #ef4444 100%);
        position: relative;
        margin: 18px 6px 12px 6px;
    }
    .vas-indicator-pin {
        position: absolute;
        top: -6px;
        width: 22px;
        height: 22px;
        background: #ffffff;
        border: 3px solid #1e40af;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        transform: translateX(-50%);
        transition: left 0.3s ease;
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
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                            Evaluasi Nyeri, Gerak Sendi & Keseimbangan
                        </h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                            Pemeriksaan intensitas nyeri (VAS), lingkup gerak sendi (ROM), kekuatan otot (MMT), dan postur
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($latestAssessment)
        @php
            $skorNyeri = $latestAssessment->nyeri_skor_total;
            $rom_data = is_array($latestAssessment->rom_mmt_data) ? $latestAssessment->rom_mmt_data : [];
            $rom_labels = config('assessment.rom_mmt.rows', [
                'kanan'    => 'Kanan (Aktif/Pasif)',
                'kiri'     => 'Kiri (Aktif/Pasif)',
                'cervical' => 'Cervical (Leher)',
                'thoracal' => 'Thoracal (Punggung)',
                'lumbal'   => 'Lumbal (Pinggang)',
                'custom'   => 'Sendi Lainnya',
            ]);
        @endphp

        <!-- Ringkasan Info Asesmen -->
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
                                <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; {{ $skorNyeri === 0 ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' : ($skorNyeri <= 3 ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' : ($skorNyeri <= 6 ? 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;' : 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;')) }}">
                                    <i class="fa-solid fa-heart-pulse mr-1"></i> Nyeri VAS: {{ $skorNyeri !== null ? $skorNyeri . '/10' : '-' }}
                                </span>
                                @if($latestAssessment->keseimbangan_bbs_skor !== null)
                                    <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                        <i class="fa-solid fa-scale-balanced mr-1"></i> BBS: {{ $latestAssessment->keseimbangan_bbs_skor }}/56
                                    </span>
                                @endif
                                @if(!empty($rom_data))
                                    <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;">
                                        <i class="fa-solid fa-bone mr-1"></i> ROM & MMT Terdata
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Intensitas Nyeri (VAS) -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700" style="color: var(--ot-navy, #1e40af); font-size: 16px; margin: 0;">
                        <i class="fa-solid fa-face-frown text-danger mr-2"></i> Skala Intensitas Nyeri (VAS 0–10)
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Score Box -->
                    <div class="text-center p-3 mb-3 rounded" style="background: #fafcff; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px;">Tingkat Nyeri Keseluruhan</div>
                        <div class="font-w800 my-1" style="font-size: 36px; color: {{ $skorNyeri >= 7 ? '#dc2626' : ($skorNyeri >= 4 ? '#d97706' : ($skorNyeri > 0 ? '#16a34a' : '#059669')) }};">
                            {{ $skorNyeri !== null ? $skorNyeri : '-' }}<span style="font-size: 18px; color: #94a3b8;">/10</span>
                        </div>
                        <div class="font-w700 mb-2" style="font-size: 13.5px; color: {{ $skorNyeri >= 7 ? '#dc2626' : ($skorNyeri >= 4 ? '#d97706' : ($skorNyeri > 0 ? '#16a34a' : '#059669')) }};">
                            @if($skorNyeri === 0)
                                <i class="fa-solid fa-face-smile mr-1"></i> Tidak Ada Nyeri (Normal)
                            @elseif($skorNyeri >= 1 && $skorNyeri <= 3)
                                <i class="fa-solid fa-face-meh mr-1"></i> Nyeri Ringan (Mild)
                            @elseif($skorNyeri >= 4 && $skorNyeri <= 6)
                                <i class="fa-solid fa-face-frown mr-1"></i> Nyeri Sedang (Moderate)
                            @elseif($skorNyeri >= 7)
                                <i class="fa-solid fa-face-sad-tear mr-1"></i> Nyeri Berat (Severe)
                            @else
                                Belum dinilai
                            @endif
                        </div>

                        <!-- Visual VAS Meter -->
                        @if($skorNyeri !== null)
                            <div class="vas-bar-container">
                                <div class="vas-indicator-pin" style="left: {{ max(0, min(100, $skorNyeri * 10)) }}%;"></div>
                            </div>
                            <div class="d-flex justify-content-between text-muted mt-1 px-1" style="font-size: 10.5px; font-weight: 600;">
                                <span>0 (Tidak Nyeri)</span>
                                <span>5 (Sedang)</span>
                                <span>10 (Berat/Hebat)</span>
                            </div>
                        @endif
                    </div>

                    <!-- Details Table -->
                    <table class="table table-hover mb-3" style="font-size: 13px;">
                        <tbody>
                            <tr>
                                <td class="text-muted font-w600" style="width: 44%; border-top: none;">Saat Istirahat</td>
                                <td style="border-top: none;">
                                    <strong class="text-dark">{{ $latestAssessment->nyeri_saat_istirahat !== null ? $latestAssessment->nyeri_saat_istirahat . ' / 10' : '-' }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted font-w600">Saat Beraktivitas</td>
                                <td>
                                    <strong class="text-dark">{{ $latestAssessment->nyeri_saat_aktivitas !== null ? $latestAssessment->nyeri_saat_aktivitas . ' / 10' : '-' }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted font-w600">Sifat / Karakter Nyeri</td>
                                <td>
                                    @if(!empty($latestAssessment->nyeri_sifat) && is_array($latestAssessment->nyeri_sifat))
                                        <div class="d-flex flex-wrap" style="gap: 4px;">
                                            @foreach($latestAssessment->nyeri_sifat as $sifat)
                                                <span class="badge badge-light border text-dark font-w600" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">{{ $sifat }}</span>
                                            @endforeach
                                            @if($latestAssessment->nyeri_sifat_lainnya)
                                                <span class="badge badge-light border text-dark font-w600" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">{{ $latestAssessment->nyeri_sifat_lainnya }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted font-w600">Lokasi Keluhan Nyeri</td>
                                <td>
                                    @if($latestAssessment->nyeri_lokasi_keluhan)
                                        <span class="text-dark font-w600">
                                            <i class="fa-solid fa-location-dot text-danger mr-1"></i> {{ $latestAssessment->nyeri_lokasi_keluhan }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if($latestAssessment->nyeri_body_chart)
                        <div class="text-center p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <span class="text-muted d-block font-w600 mb-2" style="font-size: 11.5px; text-transform: uppercase;">Pemetaan Body Chart Anatomi:</span>
                            <img src="{{ $latestAssessment->nyeri_body_chart }}" alt="Body Chart Nyeri" style="max-height: 180px; max-width: 100%; border-radius: 6px; border: 1px solid #e2e8f0; background: #ffffff;">
                        </div>
                    @endif

                    @if($latestAssessment->nyeri_catatan)
                        <div class="p-3 rounded" style="background: #f8fafc; border-left: 3px solid #2563eb; font-size: 12.5px;">
                            <strong class="text-primary d-block mb-1"><i class="fa-solid fa-circle-info mr-1"></i> Catatan Nyeri:</strong>
                            <p class="mb-0 text-dark">{{ $latestAssessment->nyeri_catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. Keseimbangan & Postur -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700" style="color: var(--ot-navy, #1e40af); font-size: 16px; margin: 0;">
                        <i class="fa-solid fa-scale-balanced text-primary mr-2"></i> Instrumen Keseimbangan & Postur
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered mb-0" style="font-size: 13px;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #475569;">Instrumen Tes</th>
                                    <th style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #475569;">Hasil Pengukuran</th>
                                    <th style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #475569;">Standar Klinis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Berg Balance Scale (BBS)</strong></td>
                                    <td>
                                        @if($latestAssessment->keseimbangan_bbs_skor !== null)
                                            <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 8px; {{ $latestAssessment->keseimbangan_bbs_skor >= 45 ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' : 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;' }}">
                                                {{ $latestAssessment->keseimbangan_bbs_skor }} / 56
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-muted" style="font-size: 12px;">&lt; 45 (Risiko jatuh)</td>
                                </tr>
                                <tr>
                                    <td><strong>Timed Up and Go (TUG)</strong></td>
                                    <td>
                                        @if($latestAssessment->keseimbangan_tug_detik)
                                            <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 8px; {{ $latestAssessment->keseimbangan_tug_detik <= 13.5 ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' : 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;' }}">
                                                {{ $latestAssessment->keseimbangan_tug_detik }} detik
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-muted" style="font-size: 12px;">&gt; 13,5 detik (Risiko)</td>
                                </tr>
                                <tr>
                                    <td><strong>Romberg Test (Mata Tertutup)</strong></td>
                                    <td>
                                        @if($latestAssessment->keseimbangan_romberg == 'Positif')
                                            <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 8px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">Positif</span>
                                        @elseif($latestAssessment->keseimbangan_romberg == 'Negatif')
                                            <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 8px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">Negatif (Normal)</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-muted" style="font-size: 12px;">Negatif (Normal)</td>
                                </tr>
                                <tr>
                                    <td><strong>One-Leg Stance (OLS)</strong></td>
                                    <td>
                                        <div class="font-w600" style="font-size: 12.5px;">
                                            Kanan: <span class="text-primary">{{ $latestAssessment->keseimbangan_ols_kanan ? $latestAssessment->keseimbangan_ols_kanan . 's' : '-' }}</span> &bull; 
                                            Kiri: <span class="text-primary">{{ $latestAssessment->keseimbangan_ols_kiri ? $latestAssessment->keseimbangan_ols_kiri . 's' : '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted" style="font-size: 12px;">&ge; 5 detik</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if(!empty($latestAssessment->postur_temuan) && is_array($latestAssessment->postur_temuan))
                        <div class="mb-3">
                            <label class="font-w700 text-dark mb-1.5" style="font-size: 12.5px;">Temuan Postur Tubuh:</label>
                            <div class="d-flex flex-wrap" style="gap: 5px;">
                                @foreach($latestAssessment->postur_temuan as $postur)
                                    <span class="badge font-w600" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                        <i class="fa-solid fa-person mr-1"></i> {{ $postur }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($latestAssessment->postur_keseimbangan_catatan)
                        <div class="p-3 rounded" style="background: #f8fafc; border-left: 3px solid #2563eb; font-size: 12.5px;">
                            <strong class="text-primary d-block mb-1"><i class="fa-solid fa-circle-info mr-1"></i> Catatan Postur & Keseimbangan:</strong>
                            <p class="mb-0 text-dark">{{ $latestAssessment->postur_keseimbangan_catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 3. Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT) -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <div>
                        <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                            <i class="fa-solid fa-bone text-primary mr-2"></i> Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT)
                        </h4>
                        <p class="text-muted mb-0 mt-1" style="font-size: 12.5px;">
                            Evaluasi derajat mobilitas sendi aktif/pasif dan skala kekuatan otot Manual Muscle Testing (0–5)
                        </p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(!empty($rom_data))
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nyeri-table mb-0" style="font-size: 12.5px;">
                                <thead>
                                    <tr class="text-center">
                                        <th style="text-align: left; width: 22%;">Gerakan / Sendi</th>
                                        <th style="width: 10%;">Fleksi</th>
                                        <th style="width: 10%;">Ekstensi</th>
                                        <th style="width: 9%;">Abduksi</th>
                                        <th style="width: 9%;">Adduksi</th>
                                        <th style="width: 9%;">Rot. Internal</th>
                                        <th style="width: 9%;">Rot. Eksternal</th>
                                        <th style="width: 11%;">Lainnya</th>
                                        <th style="width: 11%; background: #eff6ff; color: #1e40af;">MMT (0–5)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rom_labels as $key => $lbl)
                                        @php
                                            $item = $rom_data[$key] ?? [];
                                            $mmtVal = isset($item['mmt']) && $item['mmt'] !== '' ? $item['mmt'] : null;
                                        @endphp
                                        <tr>
                                            <td class="font-w600 text-dark">
                                                {{ $key === 'custom' && !empty($item['nama']) ? 'Sendi: ' . $item['nama'] : $lbl }}
                                            </td>
                                            <td class="text-center font-w600 {{ !empty($item['fleksi']) && $item['fleksi'] !== '-' ? 'text-primary' : 'text-muted' }}">{{ $item['fleksi'] ?? '-' }}</td>
                                            <td class="text-center font-w600 {{ !empty($item['ekstensi']) && $item['ekstensi'] !== '-' ? 'text-primary' : 'text-muted' }}">{{ $item['ekstensi'] ?? '-' }}</td>
                                            <td class="text-center {{ !empty($item['abd']) && $item['abd'] !== '-' ? 'text-dark' : 'text-muted' }}">{{ $item['abd'] ?? '-' }}</td>
                                            <td class="text-center {{ !empty($item['add']) && $item['add'] !== '-' ? 'text-dark' : 'text-muted' }}">{{ $item['add'] ?? '-' }}</td>
                                            <td class="text-center {{ !empty($item['ir']) && $item['ir'] !== '-' ? 'text-dark' : 'text-muted' }}">{{ $item['ir'] ?? '-' }}</td>
                                            <td class="text-center {{ !empty($item['er']) && $item['er'] !== '-' ? 'text-dark' : 'text-muted' }}">{{ $item['er'] ?? '-' }}</td>
                                            <td class="text-center text-muted">{{ $item['lainnya'] ?? '-' }}</td>
                                            <td class="text-center" style="background: #f8faff;">
                                                @if($mmtVal !== null)
                                                    <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 8px; border-radius: 6px; {{ $mmtVal >= 5 ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' : ($mmtVal == 4 ? 'background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;' : ($mmtVal == 3 ? 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;' : 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;')) }}">
                                                        Nilai {{ $mmtVal }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($latestAssessment->rom_catatan)
                            <div class="p-3 mt-3 rounded" style="background: #f8fafc; border-left: 3px solid #2563eb; font-size: 12.5px;">
                                <strong class="text-primary d-block mb-1"><i class="fa-solid fa-circle-info mr-1"></i> Catatan ROM & Kekuatan Otot:</strong>
                                <p class="mb-0 text-dark">{{ $latestAssessment->rom_catatan }}</p>
                            </div>
                        @endif
                    @else
                        <div class="text-muted p-4 text-center" style="font-size: 13px;">
                            <i class="fa-solid fa-circle-check text-success mr-1.5"></i> Data pergerakan sendi (ROM) dan kekuatan otot (MMT) tercatat normal atau belum memerlukan pemeriksaan khusus.
                        </div>
                    @endif
                </div>
            </div>
        </div>

    @else
        <div class="col-12">
            <div class="card shadow-sm text-center p-5" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 72px; height: 72px; background: #eff6ff; color: #2563eb; font-size: 32px; border: 1px solid #bfdbfe; margin: 0 auto;">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <h4 class="text-dark font-w700 mb-1">Belum Ada Data Evaluasi Fisik & Nyeri</h4>
                <p class="text-muted" style="max-width: 460px; margin: 0 auto; font-size: 13.5px;">
                    Data pemeriksaan intensitas nyeri (VAS), lingkup gerak sendi (ROM), dan instrumen keseimbangan akan dicatat oleh terapis saat sesi evaluasi klinis.
                </p>
            </div>
        </div>
    @endif
</div>
@endsection

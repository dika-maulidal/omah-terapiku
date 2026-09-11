@php
    $totalDesilPasien = array_sum($data['desil_breakdown']);
    $desil12Count = ($data['desil_breakdown']['Desil 1'] ?? 0) + ($data['desil_breakdown']['Desil 2'] ?? 0);
    $desil12Pct = $totalDesilPasien > 0 ? round(($desil12Count / $totalDesilPasien) * 100, 1) : 0;
@endphp

<!-- Info Ringkasan Periode Aktif -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="font-size: 12.5px; gap: 8px;">
            <div class="d-flex flex-wrap align-items-center" style="gap: 8px;">
                <span class="text-muted font-w600"><i class="fa-solid fa-filter text-primary mr-1"></i> Filter Aktif:</span>
                <span class="badge badge-primary light font-w600" style="font-size: 11.5px; padding: 5px 10px;">
                    <i class="fa-regular fa-calendar-check mr-1"></i> {{ $meta['periode_text'] }}
                </span>
                <span class="badge badge-info light font-w600" style="font-size: 11.5px; padding: 5px 10px;">
                    <i class="fa-solid fa-hospital-user mr-1"></i> {{ $meta['upt_text'] }}
                </span>
                @if($meta['layanan'] !== 'all')
                    <span class="badge badge-warning light font-w600" style="font-size: 11.5px; padding: 5px 10px;">
                        <i class="fa-solid fa-tag mr-1"></i> {{ $meta['layanan'] }}
                    </span>
                @endif
            </div>
            <div class="text-muted">
                Rentang Data: <strong class="text-dark">{{ $meta['start_date']->format('d M Y') }}</strong> s/d <strong class="text-dark">{{ $meta['end_date']->format('d M Y') }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 1. EXECUTIVE KPI SUMMARY CARDS -->
<!-- ========================================================================= -->
<div class="row">
    <!-- Card 1: Total Sesi Pelayanan -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="ot-stat-card ot-navy">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Total Sesi Terapi</p>
                    <h2 class="ot-stat-number">{{ number_format($data['total_sesi'], 0, ',', '.') }}</h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span class="badge badge-pill badge-primary light">{{ $data['total_sesi_selesai'] }} Selesai</span>
                <span>{{ $data['total_sesi_proses'] }} On-going</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Penerima Manfaat Terlayani -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="ot-stat-card ot-cyan">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Penerima Manfaat</p>
                    <h2 class="ot-stat-number">{{ number_format($data['total_pasien_terlayani'], 0, ',', '.') }}</h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-wheelchair"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span class="badge badge-pill badge-info light">{{ $data['total_pasien_baru'] }} Baru Terdaftar</span>
                <span>Kumulatif: {{ $data['total_pasien_kumulatif'] }}</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Rata-Rata Sesi per Hari Rabu Operasional -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="ot-stat-card ot-green">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Sesi / Hari Operasional</p>
                    <h2 class="ot-stat-number">{{ $data['avg_sesi_per_rabu'] }} <span style="font-size: 14px; font-weight: 600; color: #64748b;">sesi/Rabu</span></h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span class="badge badge-pill badge-primary light">Total: {{ $data['rabu_count'] }} Hari Rabu</span>
                <span>Jam 08.00 - 13.00</span>
            </div>
        </div>
    </div>

    <!-- Card 4: Ketepatan Sasaran DTKS -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="ot-stat-card ot-yellow">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Prioritas Desil 1 & 2</p>
                    <h2 class="ot-stat-number">{{ $desil12Pct }}%</h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span class="badge badge-pill badge-warning light">{{ $desil12Count }} Pasien Desil 1-2</span>
                <span>Tepat Sasaran</span>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 2. ANALYTICS & BREAKDOWN CARDS -->
<!-- ========================================================================= -->
<div class="row">
    
    <!-- 2A. Distribusi Desil DTKS / DTSEN -->
    <div class="col-xl-6 col-lg-12 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
            <div class="card-header py-3 px-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15px;">
                        <i class="fa-solid fa-ranking-star mr-1.5" style="color: #2563eb;"></i> Distribusi Kategori Desil DTKS / DTSEN
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                @php
                    $desilColors = [
                        'Desil 1' => ['bar' => '#ef4444', 'bg' => '#fef2f2', 'text' => 'Sangat Miskin'],
                        'Desil 2' => ['bar' => '#f97316', 'bg' => '#fff7ed', 'text' => 'Miskin'],
                        'Desil 3' => ['bar' => '#eab308', 'bg' => '#fefce8', 'text' => 'Hampir Miskin'],
                        'Desil 4' => ['bar' => '#3b82f6', 'bg' => '#eff6ff', 'text' => 'Rentan Miskin'],
                        'Desil 5' => ['bar' => '#10b981', 'bg' => '#ecfdf5', 'text' => 'Menengah Bawah'],
                        'Non-Desil / Belum Terdata' => ['bar' => '#94a3b8', 'bg' => '#f8fafc', 'text' => 'Non-Desil / Terdata Mandiri'],
                    ];
                @endphp

                <div class="d-flex flex-column" style="gap: 14px;">
                    @foreach($data['desil_breakdown'] as $desilName => $count)
                        @php
                            $pct = $totalDesilPasien > 0 ? round(($count / $totalDesilPasien) * 100, 1) : 0;
                            $cfg = $desilColors[$desilName] ?? ['bar' => '#3b82f6', 'bg' => '#eff6ff', 'text' => ''];
                        @endphp
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 12.5px;">
                                <div class="d-flex align-items-center">
                                    <strong class="text-dark font-w700 mr-2">{{ $desilName }}</strong>
                                    <small class="text-muted font-w500">({{ $cfg['text'] }})</small>
                                </div>
                                <div class="text-right">
                                    <strong class="text-dark font-w700">{{ $count }}</strong>
                                    <span class="text-muted ml-1" style="font-size: 11.5px;">({{ $pct }}%)</span>
                                </div>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 4px; background: #f1f5f9;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%; background-color: {{ $cfg['bar'] }}; border-radius: 4px;" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 2B. Breakdown Layanan Terapi & Demografi Penerima Manfaat -->
    <div class="col-xl-6 col-lg-12 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-header py-3 px-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15px;">
                        <i class="fa-solid fa-chart-pie mr-2" style="color: #2563eb;"></i> Ragam Layanan Terapi & Demografi
                    </h5>
                </div>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                
                <!-- 1. Distribusi Layanan Terapi Grid -->
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="font-w700 text-dark" style="font-size: 13px;">
                            <i class="fa-solid fa-hand-holding-medical text-primary mr-2"></i> Distribusi Ragam Layanan Terapi:
                        </span>
                        <small class="text-muted font-w600" style="font-size: 11.5px;">{{ count($data['layanan_breakdown']) }} Disiplin Layanan</small>
                    </div>

                    <div class="row mb-1" style="row-gap: 10px;">
                        @forelse($data['layanan_breakdown'] as $layanan)
                            @php
                                $pctLayanan = $data['total_sesi'] > 0 ? round(($layanan->total / $data['total_sesi']) * 100, 1) : 0;
                                $layName = strtolower($layanan->layanan_terapi ?? '');
                                $iconClass = 'fa-stethoscope';
                                $themeColor = '#2563eb';
                                $themeBg = '#eff6ff';
                                $themeBorder = '#bfdbfe';
                                
                                if (str_contains($layName, 'fisio')) {
                                    $iconClass = 'fa-person-walking';
                                    $themeColor = '#2563eb';
                                    $themeBg = '#eff6ff';
                                    $themeBorder = '#bfdbfe';
                                } elseif (str_contains($layName, 'okupasi')) {
                                    $iconClass = 'fa-hands-holding-child';
                                    $themeColor = '#0284c7';
                                    $themeBg = '#f0f9ff';
                                    $themeBorder = '#bae6fd';
                                } elseif (str_contains($layName, 'wicara')) {
                                    $iconClass = 'fa-comments';
                                    $themeColor = '#0d9488';
                                    $themeBg = '#f0fdfa';
                                    $themeBorder = '#99f6e4';
                                } elseif (str_contains($layName, 'netra') || str_contains($layName, 'sensori')) {
                                    $iconClass = 'fa-eye';
                                    $themeColor = '#7c3aed';
                                    $themeBg = '#f5f3ff';
                                    $themeBorder = '#ddd6fe';
                                }
                            @endphp
                            <div class="col-sm-6">
                                <div class="rounded d-flex flex-column justify-content-between h-100" style="padding: 10px 13px; background: {{ $themeBg }}; border: 1px solid {{ $themeBorder }}; border-radius: 9px;">
                                    <div class="d-flex align-items-center justify-content-between mb-1.5">
                                        <div class="d-flex align-items-center text-truncate mr-2">
                                            <i class="fa-solid {{ $iconClass }} flex-shrink-0" style="color: {{ $themeColor }}; font-size: 13px; margin-right: 8px;"></i>
                                            <strong class="text-dark font-w700 text-truncate" style="font-size: 12px;">{{ $layanan->layanan_terapi }}</strong>
                                        </div>
                                        <span class="badge font-w700 flex-shrink-0" style="font-size: 10.5px; padding: 2.5px 7px; background: {{ $themeColor }}; color: #ffffff; border-radius: 5px;">
                                            {{ $layanan->total }} Sesi
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 11px;">
                                        <span class="text-muted font-w500">Porsi Pelayanan</span>
                                        <strong style="color: {{ $themeColor }}; font-size: 11px;">{{ $pctLayanan }}%</strong>
                                    </div>
                                    <div class="progress" style="height: 5px; border-radius: 3px; background: rgba(0,0,0,0.06);">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $pctLayanan }}%; background-color: {{ $themeColor }}; border-radius: 3px;" aria-valuenow="{{ $pctLayanan }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-3 text-muted" style="font-size: 12px;">Belum ada data sesi terapi pada periode ini.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Pemisah Halus Antar Seksi -->
                <div class="my-3" style="border-top: 1px dashed #e2e8f0;"></div>

                <!-- 2. Demografi Usia & Gender -->
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="font-w700 text-dark" style="font-size: 13px;">
                            <i class="fa-solid fa-users-rectangle mr-2 text-primary"></i> Demografi Penerima Manfaat:
                        </span>
                        <small class="text-muted font-w600" style="font-size: 11.5px;">Usia & Rasio Gender</small>
                    </div>

                    @php
                        $totalGender = ($data['demografi']['laki'] ?? 0) + ($data['demografi']['perempuan'] ?? 0);
                        $pctLaki = $totalGender > 0 ? round((($data['demografi']['laki'] ?? 0) / $totalGender) * 100, 1) : 0;
                        $pctPerempuan = $totalGender > 0 ? round((($data['demografi']['perempuan'] ?? 0) / $totalGender) * 100, 1) : 0;
                    @endphp

                    <div class="row" style="row-gap: 10px;">
                        <!-- Kelompok Usia -->
                        <div class="col-lg-7 col-md-12">
                            <div class="d-flex flex-column" style="gap: 8px;">
                                <!-- Anak-Anak / ABK -->
                                <div class="d-flex align-items-center justify-content-between" style="padding: 8px 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 9px;">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center text-primary" style="width: 32px; height: 32px; border-radius: 7px; background: #dbeafe; font-size: 13.5px; flex-shrink: 0; margin-right: 12px;">
                                            <i class="fa-solid fa-child"></i>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block font-w700" style="font-size: 12px; line-height: 1.2;">Anak-Anak / ABK</strong>
                                            <small class="text-muted font-w500" style="font-size: 10.5px;">&lt; 18 Tahun</small>
                                        </div>
                                    </div>
                                    <span class="badge font-w700 flex-shrink-0" style="font-size: 11px; padding: 4px 9px; background: #2563eb; color: #ffffff; border-radius: 5px;">
                                        {{ $data['demografi']['anak'] }} Orang
                                    </span>
                                </div>

                                <!-- Dewasa -->
                                <div class="d-flex align-items-center justify-content-between" style="padding: 8px 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 9px;">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center text-success" style="width: 32px; height: 32px; border-radius: 7px; background: #dcfce7; font-size: 13.5px; flex-shrink: 0; margin-right: 12px;">
                                            <i class="fa-solid fa-person"></i>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block font-w700" style="font-size: 12px; line-height: 1.2;">Dewasa</strong>
                                            <small class="text-muted font-w500" style="font-size: 10.5px;">18 - 59 Tahun</small>
                                        </div>
                                    </div>
                                    <span class="badge font-w700 flex-shrink-0" style="font-size: 11px; padding: 4px 9px; background: #16a34a; color: #ffffff; border-radius: 5px;">
                                        {{ $data['demografi']['dewasa'] }} Orang
                                    </span>
                                </div>

                                <!-- Lansia -->
                                <div class="d-flex align-items-center justify-content-between" style="padding: 8px 12px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 9px;">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 7px; background: #fef3c7; font-size: 13.5px; flex-shrink: 0; color: #d97706; margin-right: 12px;">
                                            <i class="fa-solid fa-person-cane"></i>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block font-w700" style="font-size: 12px; line-height: 1.2;">Lansia (Geriatri)</strong>
                                            <small class="text-muted font-w500" style="font-size: 10.5px;">&ge; 60 Tahun</small>
                                        </div>
                                    </div>
                                    <span class="badge font-w700 flex-shrink-0" style="font-size: 11px; padding: 4px 9px; background: #d97706; color: #ffffff; border-radius: 5px;">
                                        {{ $data['demografi']['lansia'] }} Orang
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Gender Ratio Card -->
                        <div class="col-lg-5 col-md-12">
                            <div class="rounded h-100 d-flex flex-column justify-content-between" style="padding: 10px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 9px;">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <small class="text-muted font-w700 text-uppercase" style="font-size: 10.5px; letter-spacing: 0.3px;">
                                            <i class="fa-solid fa-venus-mars mr-1.5 text-primary" style="margin-right: 6px;"></i> Rasio Gender
                                        </small>
                                        <span class="badge font-w700" style="font-size: 10px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 2px 6px; border-radius: 4px;">{{ $totalGender }} Jiwa</span>
                                    </div>

                                    <!-- Laki-laki -->
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 11.5px;">
                                            <span class="font-w600 text-dark">
                                                <i class="fa-solid fa-mars" style="color: #2563eb; margin-right: 6px;"></i> Laki-laki
                                            </span>
                                            <div>
                                                <strong class="font-w700" style="color: #2563eb;">{{ $data['demografi']['laki'] }}</strong>
                                                <span class="text-muted font-w500">({{ $pctLaki }}%)</span>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 6px; border-radius: 6px; background: #e2e8f0; overflow: hidden; margin-bottom: 0;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $pctLaki }}%; background: linear-gradient(90deg, #1e40af, #3b82f6); border-radius: 6px;" aria-valuenow="{{ $pctLaki }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <!-- Perempuan -->
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 11.5px;">
                                            <span class="font-w600 text-dark">
                                                <i class="fa-solid fa-venus" style="color: #db2777; margin-right: 6px;"></i> Perempuan
                                            </span>
                                            <div>
                                                <strong class="font-w700" style="color: #db2777;">{{ $data['demografi']['perempuan'] }}</strong>
                                                <span class="text-muted font-w500">({{ $pctPerempuan }}%)</span>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 6px; border-radius: 6px; background: #e2e8f0; overflow: hidden; margin-bottom: 0;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $pctPerempuan }}%; background: linear-gradient(90deg, #db2777, #f43f5e); border-radius: 6px;" aria-valuenow="{{ $pctPerempuan }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-1.5 mt-1.5 border-top text-center" style="border-color: #e2e8f0 !important;">
                                    <small class="text-muted font-w500" style="font-size: 10.5px;">
                                        Total: <strong class="text-dark font-w700">{{ $totalGender }}</strong> Penerima Manfaat
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- 3. SEBARAN GEOGRAFIS & PROFIL KLINIS DISABILITAS -->
<!-- ========================================================================= -->
<div class="row">
    
    <!-- 3A. Sebaran Geografis Asal Pasien (Kabupaten / Kota) -->
    <div class="col-xl-6 col-lg-12 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
            <div class="card-header py-3 px-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between" style="gap: 8px;">
                <div>
                    <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15px;">
                        <i class="fa-solid fa-map-location-dot mr-1.5" style="color: #2563eb;"></i> Sebaran Geografis Asal Pasien
                    </h5>
                </div>
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <button type="button" class="btn btn-xs btn-primary font-w600" id="btnToggleMap" onclick="switchGeoView('map')" style="border-radius: 6px; padding: 4px 10px; font-size: 11px;">
                        <i class="fa-solid fa-map mr-1"></i> Peta
                    </button>
                    <button type="button" class="btn btn-xs btn-light font-w600" id="btnToggleList" onclick="switchGeoView('list')" style="border-radius: 6px; padding: 4px 10px; font-size: 11px; border: 1px solid #cbd5e1; color: #475569;">
                        <i class="fa-solid fa-list-ol mr-1"></i> Daftar
                    </button>
                </div>
            </div>
            <div class="card-body p-3 p-md-4">
                
                <!-- TAB 1: PETA INTERAKTIF LEAFLET -->
                <div id="geoMapView">
                    <div id="mapJatim" style="height: 330px; width: 100%; border-radius: 8px; border: 1.5px solid #cbd5e1; box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);"></div>
                    
                    <!-- Map Legend -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between pt-2.5 mt-2 border-top" style="border-color: #f1f5f9; font-size: 11.5px;">
                        <div class="d-flex align-items-center mr-3 mb-1">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444; border: 1.5px solid #ffffff; box-shadow: 0 0 0 1.5px #ef4444; display: inline-block; margin-right: 6px;"></span>
                            <strong class="text-dark font-w600">3 Balai / UPT Omah Terapi-KU</strong>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #2563eb; display: inline-block; margin-right: 6px;"></span>
                            <span class="text-muted font-w600">Klaster Pasien ({{ count($data['wilayah_breakdown']) }} Kab/Kota)</span>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: DAFTAR RANKING WILAYAH -->
                <div id="geoListView" style="display: none;">
                    @php
                        $totalPasienWilayah = array_sum($data['wilayah_breakdown']);
                    @endphp
                    <div class="d-flex flex-column" style="gap: 12px; max-height: 370px; overflow-y: auto;">
                        @forelse($data['wilayah_breakdown'] as $kabName => $kabTotal)
                            @php
                                $pctKab = $totalPasienWilayah > 0 ? round(($kabTotal / $totalPasienWilayah) * 100, 1) : 0;
                            @endphp
                            <div class="p-2.5 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <div class="d-flex align-items-center justify-content-between mb-1.5" style="font-size: 12.5px;">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-location-dot mr-2 text-danger"></i>
                                        <strong class="text-dark font-w700">{{ $kabName }}</strong>
                                    </div>
                                    <div class="text-right">
                                        <strong class="text-primary font-w700">{{ $kabTotal }} Pasien</strong>
                                        <span class="text-muted ml-1" style="font-size: 11.5px;">({{ $pctKab }}%)</span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 6px; border-radius: 3px; background: #e2e8f0;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $pctKab }}%; background: linear-gradient(90deg, #2563eb, #3b82f6); border-radius: 3px;" aria-valuenow="{{ $pctKab }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted" style="font-size: 12px;">
                                <i class="fa-solid fa-map-location-dot fa-2x mb-2 text-muted" style="opacity: 0.4;"></i>
                                <p class="mb-0">Belum ada data wilayah domisili tercatat pada periode ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 3B. Top Tindakan & Profil Disabilitas Terlayani -->
    <div class="col-xl-6 col-lg-12 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
            <div class="card-header py-3 px-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15px;">
                        <i class="fa-solid fa-stethoscope mr-1.5" style="color: #2563eb;"></i> Tindakan Terapi & Ragam Disabilitas
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                
                <!-- Tindakan Terbanyak -->
                <h6 class="font-w700 text-dark mb-2.5" style="font-size: 13px;">Tindakan Terapi Paling Sering Diberikan:</h6>
                <div class="d-flex flex-column mb-3.5" style="gap: 6px;">
                    @forelse($data['top_tindakan'] as $tt)
                        <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px;">
                            <span class="font-w600 text-dark"><i class="fa-solid fa-check-circle text-success mr-1.5"></i> {{ $tt->tindakan }}</span>
                            <span class="badge badge-primary font-w700" style="font-size: 11px; background: #2563eb;">{{ $tt->total }} Sesi</span>
                        </div>
                    @empty
                        <small class="text-muted text-center py-2">Belum ada tindakan tercatat.</small>
                    @endforelse
                </div>

                <!-- Ragam Disabilitas -->
                <h6 class="font-w700 text-dark mb-2" style="font-size: 13px;">Profil Ragam Disabilitas Terlayani:</h6>
                <div class="d-flex flex-wrap" style="gap: 6px;">
                    @forelse($data['disabilitas_breakdown'] as $disName => $disCount)
                        <span class="badge font-w600" style="font-size: 11.5px; padding: 5px 10px; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                            {{ $disName }}: <strong class="text-primary font-w700 ml-1">{{ $disCount }}</strong>
                        </span>
                    @empty
                        <small class="text-muted">Data disabilitas belum tercatat.</small>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- 4. REKAPITULASI KONSOLIDASI PER UPT OMAH TERAPI-KU -->
<!-- ========================================================================= -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
            <div class="card-header py-3 px-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15.5px;">
                        <i class="fa-solid fa-hospital-user mr-1.5" style="color: #2563eb;"></i> Rekapitulasi Pelayanan per Lokasi UPT Omah Terapi-KU
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; color: #475569; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 12px 16px;">Nama UPT / Balai</th>
                                <th style="padding: 12px 14px;">Kontak & Hotline</th>
                                <th style="padding: 12px 14px;">Fokus Layanan</th>
                                <th style="padding: 12px 14px; text-align: center;">Terapis Bertugas</th>
                                <th style="padding: 12px 14px; text-align: center;">Pasien Terlayani</th>
                                <th style="padding: 12px 14px; text-align: center;">Total Sesi</th>
                                <th style="padding: 12px 16px; text-align: center;">Selesai (Tuntas)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['upt_rekap'] as $u)
                                <tr>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <strong class="text-dark d-block font-w700" style="font-size: 13.5px;">{{ $u['nama'] }}</strong>
                                        <small class="text-muted" style="font-size: 11.5px;">
                                            <i class="fa-solid fa-location-dot text-muted mr-1"></i> {{ $u['alamat'] }}
                                        </small>
                                    </td>
                                    <td style="padding: 14px 14px; vertical-align: middle;">
                                        @if($u['no_telp'] && $u['no_telp'] !== '-')
                                            <span class="badge font-w600" style="font-size: 11.5px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; padding: 4px 8px;">
                                                <i class="fa-solid fa-phone mr-1"></i> {{ $u['no_telp'] }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 14px 14px; vertical-align: middle;">
                                        <span class="badge badge-light font-w600" style="font-size: 11.5px; border: 1px solid #e2e8f0;">
                                            {{ $u['fokus'] }}
                                        </span>
                                    </td>
                                    <td style="padding: 14px 14px; vertical-align: middle; text-align: center;">
                                        <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 10px; background: #f8fafc; border: 1px solid #cbd5e1; color: #334155;">
                                            <i class="fa-solid fa-user-doctor mr-1"></i> {{ $u['total_terapis'] }}
                                        </span>
                                    </td>
                                    <td style="padding: 14px 14px; vertical-align: middle; text-align: center;">
                                        <strong class="text-dark font-w700" style="font-size: 14px;">{{ $u['total_pasien'] }}</strong>
                                    </td>
                                    <td style="padding: 14px 14px; vertical-align: middle; text-align: center;">
                                        <strong class="text-primary font-w700" style="font-size: 14px;">{{ $u['total_sesi'] }}</strong>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; text-align: center;">
                                        <span class="badge badge-success font-w700" style="font-size: 11.5px; padding: 4px 10px; background: #10b981;">
                                            {{ $u['selesai_sesi'] }} Sesi
                                        </span>
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

<!-- ========================================================================= -->
<!-- 5. REKAPITULASI KINERJA TERAPIS -->
<!-- ========================================================================= -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
            <div class="card-header py-3 px-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15px;">
                        <i class="fa-solid fa-user-doctor mr-1.5" style="color: #2563eb;"></i> Rekap Kinerja Tenaga Terapis & Medis
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size: 12.5px;">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 11.5px; text-transform: uppercase; color: #475569;">
                                <th style="padding: 12px 16px;">Nama Terapis</th>
                                <th style="padding: 12px 14px;">NIP / No. Registrasi</th>
                                <th style="padding: 12px 14px;">Penempatan UPT</th>
                                <th style="padding: 12px 14px; text-align: center;">Pasien Unik</th>
                                <th style="padding: 12px 14px; text-align: center;">Total Sesi</th>
                                <th style="padding: 12px 16px; text-align: center;">Selesai (Tuntas)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['terapis_rekap'] as $t)
                                <tr>
                                    <td style="padding: 12px 16px; vertical-align: middle;">
                                        <strong class="text-dark d-block font-w700" style="font-size: 13px;">{{ $t['nama'] }}</strong>
                                    </td>
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span class="text-muted font-w500">{{ $t['nip'] }}</span>
                                    </td>
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span class="badge badge-light font-w500" style="font-size: 11.5px; border: 1px solid #e2e8f0;">{{ $t['penempatan'] }}</span>
                                    </td>
                                    <td style="padding: 12px 14px; vertical-align: middle; text-align: center;">
                                        <strong class="text-dark font-w700">{{ $t['pasien_unik'] }}</strong> Org
                                    </td>
                                    <td style="padding: 12px 14px; vertical-align: middle; text-align: center;">
                                        <strong class="text-primary font-w700" style="font-size: 13.5px;">{{ $t['total_sesi'] }}</strong>
                                    </td>
                                    <td style="padding: 12px 16px; vertical-align: middle; text-align: center;">
                                        <span class="badge badge-success font-w700" style="font-size: 11.5px; padding: 4px 10px; background: #10b981;">{{ $t['selesai'] }} Sesi</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada data terapis bertugas pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

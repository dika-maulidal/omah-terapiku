@inject('query', 'App\Models\DashboardQuery')

@extends('layout.apps')
@section('content')
    @php
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date('w')];
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][date('n') - 1];
        $tanggalFormatted = $hari . ', ' . date('j') . ' ' . $bulan . ' ' . date('Y');

        $availableYears = $query->getAvailableYears();
        $allYearsPasienData = $query->getAllYearsPasienData();
        $statusAntrian = $query->getStatusAntrianData();
        $trenPelayananAll = $query->getTrenPelayananAll();
        $tren7Hari = $trenPelayananAll['7'];
        $pasienOmah = $query->getPasienPerOmahTerapiku();
        $demografi = $query->getDemografiPenerimaManfaat();
        $distribusiTerapi = $query->getDistribusiJenisTerapi();
        $allTopTindakan = $query->getTopTindakanAll(5);
        $topTindakan = $allTopTindakan['bulan'];
        $allTopDiagnosa = $query->getTopDiagnosaAll(10);
        $topDiagnosa = $allTopDiagnosa['bulan'];
    @endphp

    <!-- Dashboard Header Banner (Unified White Card) -->
    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3 class="font-w700 mb-1" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Dashboard Pendaftaran</h3>
                    <p class="fs-13 text-muted mb-0">Selamat Datang, <strong class="font-w700" style="color: #2563eb;">{{ auth()->user()->name }}</strong> &bull; Loket Pendaftaran Omah Terapiku</p>
                </div>
                <div class="mt-2 mt-sm-0">
                    <div class="d-flex align-items-center px-3 py-2 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 13px; font-weight: 600; color: #334155; border-radius: 8px;">
                        <i class="fa fa-calendar mr-2" style="color: #2563eb; font-size: 14px;"></i> {{ $tanggalFormatted }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Widgets (Top Row - DESIGN.md Section 4.B) -->
    <div class="row">
        <!-- Card 1: Pendaftaran Hari Ini (Ocean Navy #2D4B7A) -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-navy">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Pendaftaran Hari Ini</p>
                        <h2 class="ot-stat-number">{{ $query->perikaHariini() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-primary light">Hari Ini</span>
                    <span>Bulan Ini: {{ $query->perikaBulanini() }}</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Penerima Manfaat (Sky Blue #38A5DB) -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-cyan">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Total Penerima Manfaat</p>
                        <h2 class="ot-stat-number">{{ $query->totalPasien() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa-solid fa-wheelchair"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-info light">Terdaftar</span>
                    <span>Penerima Manfaat</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Terapis -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-green">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Total Terapis</p>
                        <h2 class="ot-stat-number">{{ $query->totalDoktor() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-primary light">Aktif</span>
                    <span>Terapis Medis</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Riwayat Periksa -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-yellow">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Total Riwayat Periksa</p>
                        <h2 class="ot-stat-number">{{ $query->totalPeriksa() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-info light">Akumulasi</span>
                    <span>Tahun {{ date('Y') }}: {{ $query->perikaTahunini() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Tren Pelayanan Section (7 / 30 Hari Filter) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-line-chart mr-2" style="color: #2563eb;"></i> Grafik Tren Pelayanan
                        </h4>
                    </div>
                    <div class="position-relative mt-2 mt-sm-0" style="width: 175px;">
                        <i class="fa fa-filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563eb; font-size: 12px; pointer-events: none; z-index: 2;"></i>
                        <select id="filterRentangTren" class="form-control form-control-sm font-w700" style="color: #2563eb !important; padding-left: 32px; padding-right: 36px; height: 36px; font-size: 12.5px; border-radius: 8px; border-color: #cbd5e1; cursor: pointer; background-color: #ffffff; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232563eb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 14px center; background-size: 11px 11px;">
                            <option value="7" selected>7 Hari Terakhir</option>
                            <option value="30">30 Hari Terakhir</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Ringkasan Metrik Tren (Di Atas Grafik) -->
                    <div class="row text-center mb-3 pb-3" style="border-bottom: 1px dashed #e2e8f0;">
                        <div class="col-sm-3 col-6 mb-2 mb-sm-0">
                            <small class="text-muted d-block font-w600 fs-12">Total Pelayanan (<span class="badgeRentangText">7 Hari</span>)</small>
                            <span class="font-w700 fs-16" id="statTotalPeriksaTren" style="color: #1e40af !important;">{{ $tren7Hari['total_periksa'] }} Pasien</span>
                        </div>
                        <div class="col-sm-3 col-6 mb-2 mb-sm-0" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Rata-rata Harian</small>
                            <span class="font-w700 fs-16" id="statAvgPeriksaTren" style="color: #2563eb !important;">{{ $tren7Hari['avg_periksa'] }} / hari</span>
                        </div>
                        <div class="col-sm-3 col-6" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Penerima Baru (<span class="badgeRentangText">7 Hari</span>)</small>
                            <span class="font-w700 fs-16" id="statTotalPasienBaruTren" style="color: #0284c7 !important;">{{ $tren7Hari['total_pasien_baru'] }} Orang</span>
                        </div>
                        <div class="col-sm-3 col-6" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Puncak Tertinggi</small>
                            <span class="font-w700 text-info fs-16" id="statHariTertinggiTren">{{ $tren7Hari['hari_tertinggi'] }}</span>
                        </div>
                    </div>

                    <!-- Canvas Grafik -->
                    <div style="position: relative; height: 260px;">
                        <canvas id="chartTren7Hari"></canvas>
                    </div>

                    <!-- Legend (Di Bawah Grafik) -->
                    <div class="d-flex align-items-center justify-content-center flex-wrap mt-3 pt-3" style="border-top: 1px dashed #e2e8f0; gap: 24px;">
                        <div class="d-flex align-items-center font-w600 fs-12" style="color: #1e40af;">
                            <span style="display: inline-block; width: 12px; height: 12px; background: #1e40af; border-radius: 3px; margin-right: 8px;"></span>
                            Pelayanan Rekam Medis
                        </div>
                        <div class="d-flex align-items-center font-w600 fs-12" style="color: #0284c7;">
                            <span style="display: inline-block; width: 12px; height: 12px; background: #38bdf8; border-radius: 3px; margin-right: 8px;"></span>
                            Penerima Manfaat Baru
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics & Visualisasi Grafik Section (Charts Row) -->
    <div class="row mb-4">
        <!-- Kolom Kiri: Grafik Total Penerima Manfaat per Bulan -->
        <div class="col-xl-6 col-lg-12 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-bar-chart mr-2" style="color: #2563eb;"></i> Grafik Total Penerima Manfaat per Bulan
                        </h4>
                    </div>
                    <div class="position-relative mt-2 mt-sm-0" style="width: 145px;">
                        <i class="fa fa-filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563eb; font-size: 12px; pointer-events: none; z-index: 2;"></i>
                        <select id="filterTahunPenerima" class="form-control form-control-sm font-w700" style="color: #2563eb !important; padding-left: 32px; padding-right: 34px; height: 36px; font-size: 12.5px; border-radius: 8px; border-color: #cbd5e1; cursor: pointer; background-color: #ffffff; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232563eb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 14px center; background-size: 11px 11px;">
                            @foreach ($availableYears as $yr)
                                <option value="{{ $yr }}" {{ $yr == date('Y') ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Stat Ringkasan di Atas Grafik -->
                    <div class="row text-center mb-3 pb-3" style="border-bottom: 1px dashed #e2e8f0;">
                        <div class="col-4">
                            <small class="text-muted d-block font-w600 fs-12">Total Tahun <span class="badgeYear">{{ date('Y') }}</span></small>
                            <span class="font-w700 fs-15" id="statTotalTahun" style="color: #2563eb !important;">-</span>
                        </div>
                        <div class="col-4" style="border-left: 1px solid #edf2f7; border-right: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Rata-rata / Bulan</small>
                            <span class="font-w700 text-primary fs-15" id="statRataRata" style="color: #2563eb !important;">-</span>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block font-w600 fs-12">Bulan Tertinggi</small>
                            <span class="font-w700 text-info fs-15" id="statTertinggi">-</span>
                        </div>
                    </div>
                    <!-- Canvas Grafik -->
                    <div style="position: relative; height: 210px;">
                        <canvas id="chartPenerimaManfaat"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Donut Chart Distribusi Penerima Manfaat per Omah Terapiku -->
        <div class="col-xl-6 col-lg-12">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-pie-chart mr-2" style="color: #2563eb;"></i> Penerima Manfaat per Omah Terapiku
                        </h4>
                    </div>
                    <span class="badge badge-primary light font-w600" style="font-size: 11.5px;">
                        Total: {{ $pasienOmah['total_pasien'] }} Pasien
                    </span>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <!-- Sisi Kiri: Donut Chart -->
                        <div class="col-md-5 col-12 mb-3 mb-md-0">
                            <div style="position: relative; height: 200px;">
                                <canvas id="chartOmahTerapiku"></canvas>
                            </div>
                        </div>
                        <!-- Sisi Kanan: List Rincian Unit & Progress Bar -->
                        <div class="col-md-7 col-12">
                            <div class="dz-scroll" style="max-height: 210px; overflow-y: auto; padding-right: 4px;">
                                @forelse($pasienOmah['items'] as $item)
                                    <div class="p-2 mb-2 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="d-flex align-items-center text-truncate" style="max-width: 65%;">
                                                <span style="display: inline-block; width: 10px; height: 10px; background: {{ $item['color'] }}; border-radius: 50%; margin-right: 6px; flex-shrink: 0;"></span>
                                                <strong class="fs-12 text-black text-truncate" title="{{ $item['nama'] }}">{{ $item['nama'] }}</strong>
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                <span class="badge badge-light font-w700 text-dark" style="font-size: 11px;">
                                                    {{ $item['total_pasien'] }} Pasien ({{ $item['persentase'] }}%)
                                                </span>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 5px; background: #e2e8f0; border-radius: 4px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $item['persentase'] }}%; background-color: {{ $item['color'] }}; border-radius: 4px;" aria-valuenow="{{ $item['persentase'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <p class="fs-12 mb-0">Belum ada data unit Omah Terapiku.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         SECTION: DISTRIBUSI LAYANAN TERAPI & TOP TINDAKAN TERAPI
         ========================================================================= -->
    <div class="row mb-4">
        <!-- Kolom 1: Diagram Distribusi Jenis Terapi (Donut/Pie Chart) -->
        <div class="col-xl-6 col-lg-12 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-pie-chart mr-2" style="color: #2563eb;"></i> Distribusi Jenis Layanan Terapi
                        </h4>
                    </div>
                    <span class="badge badge-primary light font-w600" style="font-size: 11.5px;">
                        Total: {{ $distribusiTerapi['total'] }} Sesi Pelayanan
                    </span>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-5 col-12 mb-3 mb-md-0">
                            <div style="position: relative; height: 200px;">
                                <canvas id="chartDistribusiTerapi"></canvas>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="dz-scroll" style="max-height: 210px; overflow-y: auto; padding-right: 4px;">
                                @forelse($distribusiTerapi['items'] as $item)
                                    <div class="p-2 mb-2 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="d-flex align-items-center text-truncate" style="max-width: 65%;">
                                                <span style="display: inline-block; width: 10px; height: 10px; background: {{ $item['color'] }}; border-radius: 50%; margin-right: 6px; flex-shrink: 0;"></span>
                                                <i class="fa {{ $item['icon'] }} mr-1" style="color: {{ $item['color'] }}; font-size: 12px;"></i>
                                                <strong class="fs-12 text-black text-truncate" title="{{ $item['nama'] }}">{{ $item['nama'] }}</strong>
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                <span class="badge badge-light font-w700 text-dark" style="font-size: 11px;">
                                                    {{ $item['total'] }} Sesi ({{ $item['persentase'] }}%)
                                                </span>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 5px; background: #e2e8f0; border-radius: 4px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $item['persentase'] }}%; background-color: {{ $item['color'] }}; border-radius: 4px;" aria-valuenow="{{ $item['persentase'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <p class="fs-12 mb-0">Belum ada data sesi layanan terapi.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom 2: Top Tindakan & Intervensi Terbanyak -->
        <div class="col-xl-6 col-lg-12">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-list-ol mr-2" style="color: #2563eb;"></i> Top 5 Rencana Tindakan & Intervensi
                        </h4>
                    </div>
                    <div class="position-relative mt-2 mt-sm-0" style="width: 145px;">
                        <i class="fa fa-filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563eb; font-size: 12px; pointer-events: none; z-index: 2;"></i>
                        <select id="filterPeriodeTindakan" class="form-control form-control-sm font-w700" style="color: #2563eb !important; padding-left: 32px; padding-right: 34px; height: 36px; font-size: 12.5px; border-radius: 8px; border-color: #cbd5e1; cursor: pointer; background-color: #ffffff; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232563eb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 14px center; background-size: 11px 11px;">
                            <option value="bulan" selected>Bulan Ini</option>
                            <option value="tahun">Tahun Ini</option>
                            <option value="semua">Semua Waktu</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                        <span class="fs-12 text-muted font-w600" id="labelPeriodeTindakan">Periode: <strong class="text-primary">{{ $bulan }} {{ date('Y') }}</strong></span>
                        <span class="badge badge-primary light font-w700" id="badgeTotalTindakan" style="font-size: 11px;">Total: {{ $topTindakan['total'] }} Tindakan</span>
                    </div>
                    <div class="dz-scroll" id="containerTopTindakan" style="max-height: 220px; overflow-y: auto;">
                        @forelse($topTindakan['items'] as $index => $tdk)
                            <div class="p-2 mb-2 rounded" style="background: #ffffff; border: 1px solid #edf2f7; transition: all 0.2s ease;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="d-flex align-items-center text-truncate" style="max-width: 70%;">
                                        <span class="badge badge-pill badge-primary mr-2 font-w700" style="width: 22px; height: 22px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; background: {{ $tdk['color'] }};">
                                            #{{ $index + 1 }}
                                        </span>
                                        <span class="fs-12 text-dark font-w600 text-truncate" title="{{ $tdk['nama'] }}">
                                            {{ $tdk['nama'] }}
                                        </span>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <span class="badge badge-light font-w700 text-primary" style="font-size: 11px; background: #f1f5f9;">
                                            {{ $tdk['total'] }} Kali
                                        </span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 6px; background: #f1f5f9; border-radius: 4px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $tdk['bar_persen'] }}%; background-color: {{ $tdk['color'] }}; border-radius: 4px;" aria-valuenow="{{ $tdk['bar_persen'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="fa-solid fa-clipboard-list fa-2x mb-2 text-muted" style="opacity: 0.5;"></i>
                                <p class="fs-12 mb-0">Belum ada data tindakan terapi pada periode ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         SECTION: DEMOGRAFI PENERIMA MANFAAT (USIA, GENDER, DISABILITAS)
         ========================================================================= -->
    <div class="row mb-4">
        <!-- Kolom 1: Grafik Demografi Kelompok Usia -->
        <div class="col-xl-7 col-lg-12 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-users mr-2" style="color: #2563eb;"></i> Demografi Kelompok Usia Penerima Manfaat
                        </h4>
                    </div>
                    <span class="badge badge-info light font-w600" style="font-size: 11.5px;">
                        Total: {{ $demografi['total'] }} Pasien
                    </span>
                </div>
                <div class="card-body p-3">
                    <!-- Ringkasan Usia (Di Atas Grafik) -->
                    <div class="row text-center mb-3 pb-3" style="border-bottom: 1px dashed #e2e8f0;">
                        <div class="col-3">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Balita & Anak</small>
                            <span class="font-w700 fs-14" style="color: #2563eb !important;">
                                {{ $demografi['usia']['counts'][0] + $demografi['usia']['counts'][1] }} Orang
                            </span>
                        </div>
                        <div class="col-3" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Remaja</small>
                            <span class="font-w700 fs-14" style="color: #0284c7 !important;">
                                {{ $demografi['usia']['counts'][2] }} Orang
                            </span>
                        </div>
                        <div class="col-3" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Dewasa</small>
                            <span class="font-w700 fs-14" style="color: #1e40af !important;">
                                {{ $demografi['usia']['counts'][3] }} Orang
                            </span>
                        </div>
                        <div class="col-3" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Lansia (60+)</small>
                            <span class="font-w700 fs-14" style="color: #475569 !important;">
                                {{ $demografi['usia']['counts'][4] }} Orang
                            </span>
                        </div>
                    </div>
                    <!-- Canvas Grafik -->
                    <div style="position: relative; height: 180px;">
                        <canvas id="chartDemografiUsia"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom 2: Rasio Gender (L/P) & Ragam Disabilitas -->
        <div class="col-xl-5 col-lg-12">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-venus-mars mr-2" style="color: #2563eb;"></i> Gender & Ragam Disabilitas
                        </h4>
                    </div>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <!-- Gender Split Bar -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-primary mr-2" style="background: #1e40af; padding: 5px 8px;"><i class="fa fa-mars"></i> Laki-laki</span>
                                <strong class="fs-13 text-dark">{{ $demografi['jk']['laki'] }} ({{ $demografi['jk']['persen_laki'] }}%)</strong>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong class="fs-13 text-dark mr-2">{{ $demografi['jk']['perempuan'] }} ({{ $demografi['jk']['persen_perempuan'] }}%)</strong>
                                <span class="badge badge-info" style="background: #38bdf8; color: #fff; padding: 5px 8px;"><i class="fa fa-venus"></i> Perempuan</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 10px; background: #e2e8f0; border-radius: 6px; overflow: hidden;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $demografi['jk']['persen_laki'] }}%; background-color: #1e40af;" aria-valuenow="{{ $demografi['jk']['persen_laki'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar" role="progressbar" style="width: {{ $demografi['jk']['persen_perempuan'] }}%; background-color: #38bdf8;" aria-valuenow="{{ $demografi['jk']['persen_perempuan'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Ragam Disabilitas Terbanyak -->
                    <div class="mt-3 pt-3" style="border-top: 1px dashed #e2e8f0;">
                        <small class="text-muted font-w700 text-uppercase d-block mb-2" style="font-size: 11px; letter-spacing: 0.3px;">
                            <i class="fa fa-wheelchair mr-1" style="color: #2563eb;"></i> Ragam Disabilitas Penerima Manfaat:
                        </small>
                        <div class="d-flex flex-wrap" style="gap: 6px;">
                            @forelse($demografi['disabilitas'] as $dis)
                                <span class="badge badge-light text-dark font-w600" style="padding: 6px 10px; font-size: 11.5px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 6px;">
                                    {{ $dis->jenis_disabilitas }}: <strong class="text-primary ml-1">{{ $dis->total }}</strong>
                                </span>
                            @empty
                                <span class="text-muted fs-12">Belum ada data jenis disabilitas.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row (3 Columns: Status Antrian, Pendaftaran Hari Ini, Top Diagnosa) -->
    <div class="row mb-4">
        <!-- Kolom 1: Status Antrian Pasien -->
        <div class="col-xl-4 col-lg-12 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-circle-o-notch mr-2" style="color: #2563eb;"></i> Status Antrian Pasien
                        </h4>
                    </div>
                    <span class="badge badge-primary light font-w600" style="font-size: 11.5px;">
                        Total: {{ $statusAntrian['total'] }}
                    </span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div style="position: relative; height: 170px;">
                        <canvas id="chartStatusAntrian"></canvas>
                    </div>
                    <!-- Custom Interactive Legend with counts -->
                    <div class="mt-3 pt-2" style="border-top: 1px dashed #e2e8f0; font-size: 12px;">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #eff6ff; border: 1px solid #dbeafe;">
                                    <span class="font-w600 text-primary" style="font-size: 11.5px; color: #2563eb !important;">
                                        <i class="fa fa-circle mr-1" style="color: #60a5fa;"></i> Antrian
                                    </span>
                                    <strong class="text-dark">{{ $statusAntrian['antrian'] }}</strong>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #ebf5ff; border: 1px solid #bfdbfe;">
                                    <span class="font-w600 text-primary" style="font-size: 11.5px; color: #1d4ed8 !important;">
                                        <i class="fa fa-circle mr-1" style="color: #2563eb;"></i> Periksa
                                    </span>
                                    <strong class="text-dark">{{ $statusAntrian['pemeriksaan'] }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #f0f9ff; border: 1px solid #e0f2fe;">
                                    <span class="font-w600" style="color: #0284c7 !important; font-size: 11.5px;">
                                        <i class="fa fa-circle mr-1" style="color: #93c5fd;"></i> Menunggu
                                    </span>
                                    <strong class="text-dark">{{ $statusAntrian['menunggu'] }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #eef2ff; border: 1px solid #c7d2fe;">
                                    <span class="font-w600" style="color: #1e3a8a !important; font-size: 11.5px;">
                                        <i class="fa fa-circle mr-1" style="color: #1e40af;"></i> Selesai
                                    </span>
                                    <strong class="text-dark">{{ $statusAntrian['selesai'] }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom 2: Pendaftaran Hari Ini -->
        <div class="col-xl-4 col-lg-12 mb-3 mb-xl-0">
            <div class="card h-100 mb-0 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                        <i class="fa fa-user-plus mr-1" style="color: #2563eb;"></i> Pendaftaran Hari Ini
                    </h4>
                    <span class="badge badge-primary light font-w600">
                        {{ $query->rekam_day()->count() }} Pasien
                    </span>
                </div>
                <div class="card-body p-3">
                    <div class="dz-scroll" id="appointment-schedule" style="overflow-y: auto; max-height: 380px; padding-right: 4px;">
                        @if ($query->rekam_day()->count() > 0)
                            @foreach ($query->rekam_day() as $item)
                                <div class="ot-schedule-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center" style="min-width: 0;">
                                        <div class="ot-patient-avatar">
                                            {{ strtoupper(substr($item->pasien->nama ?? 'P', 0, 2)) }}
                                        </div>
                                        <div style="min-width: 0;">
                                            <div class="patient-name text-truncate">
                                                <a href="{{ Route('rekam.detail', $item->pasien_id) }}">
                                                    {{ $item->pasien->nama ?? '-' }}
                                                </a>
                                            </div>
                                            <ul class="ot-meta-list">
                                                <li>
                                                    <i class="fa fa-clock-o text-muted"></i>
                                                    {{ $item->created_at ? $item->created_at->diffForHumans() : '-' }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-user-md text-muted"></i>
                                                    {{ $item->dokter->nama ?? 'Terapis' }}
                                                </li>
                                                @if($item->keluhan)
                                                <li class="text-truncate" style="max-width: 180px;" title="{{ $item->keluhan }}">
                                                    {{ $item->keluhan }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-shrink-0 ml-2">
                                         <div class="mr-2 text-right">
                                             {!! $item->status_display() !!}
                                         </div>
                                         <a href="{{ Route('rekam.detail', $item->pasien_id) }}" class="btn btn-xs btn-primary shadow-sm d-inline-flex align-items-center justify-content-center" title="Lihat Rekam Medis" style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-size: 11px;">
                                             <i class="fa fa-arrow-right"></i>
                                         </a>
                                     </div>
                                 </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-calendar-check-o text-muted fs-24 mb-2 d-block"></i>
                                <p class="fs-13 mb-2">Belum ada pendaftaran pasien hari ini.</p>
                                <a href="{{ Route('rekam.add') }}" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; border-radius: 8px; font-size: 12.5px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                    <i class="fa fa-plus-circle mr-1"></i> + Tambah Rekam Medis
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Top Diagnosa (Col 3) -->
        <div class="col-xl-4 col-lg-12">
            <div class="card h-100 mb-0 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-stethoscope mr-1" style="color: #2563eb;"></i> Top Diagnosa Kasus
                        </h4>
                    </div>
                    <div class="position-relative mt-2 mt-sm-0" style="width: 145px;">
                        <i class="fa fa-filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563eb; font-size: 12px; pointer-events: none; z-index: 2;"></i>
                        <select id="filterPeriodeDiagnosa" class="form-control form-control-sm font-w700" style="color: #2563eb !important; padding-left: 32px; padding-right: 34px; height: 36px; font-size: 12.5px; border-radius: 8px; border-color: #cbd5e1; cursor: pointer; background-color: #ffffff; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232563eb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 14px center; background-size: 11px 11px;">
                            <option value="bulan" selected>Bulan Ini</option>
                            <option value="tahun">Tahun Ini</option>
                            <option value="semua">Semua Waktu</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                        <span class="fs-12 text-muted font-w600" id="labelPeriodeDiagnosa">Periode: <strong class="text-primary">{{ $bulan }} {{ date('Y') }}</strong></span>
                        <span class="badge badge-primary light font-w700" id="badgeTotalDiagnosa" style="font-size: 11px;">Total: {{ $topDiagnosa['total'] }} Kasus</span>
                    </div>
                    <div class="dz-scroll" id="containerTopDiagnosa" style="overflow-y: auto; max-height: 380px; padding-right: 4px;">
                        @forelse($topDiagnosa['items'] as $index => $dg)
                            <div class="p-2 mb-2 rounded" style="background: #ffffff; border: 1px solid #edf2f7; transition: all 0.2s ease;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="d-flex align-items-center text-truncate" style="max-width: 72%;">
                                        <span class="badge badge-pill badge-primary mr-2 font-w700" style="width: 22px; height: 22px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; background: {{ $dg['color'] }};">
                                            #{{ $index + 1 }}
                                        </span>
                                        <span class="badge badge-info light font-w700 mr-1" style="font-size: 10.5px; padding: 2px 6px;">
                                            {{ $dg['code'] }}
                                        </span>
                                        <span class="fs-12 text-dark font-w600 text-truncate" title="{{ $dg['nama'] }}">
                                            {{ $dg['nama'] }}
                                        </span>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <span class="badge badge-light font-w700 text-primary" style="font-size: 11px; background: #f1f5f9;">
                                            {{ $dg['total'] }} Kasus
                                        </span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 6px; background: #f1f5f9; border-radius: 4px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $dg['bar_persen'] }}%; background-color: {{ $dg['color'] }}; border-radius: 4px;" aria-valuenow="{{ $dg['bar_persen'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-stethoscope text-muted fs-24 mb-2 d-block" style="opacity: 0.5;"></i>
                                <p class="fs-12 mb-0">Belum ada data diagnosa pada periode ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    var allYearsData = {!! json_encode($allYearsPasienData) !!};
    var bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    var namaBulanLengkap = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    var currentYear = $('#filterTahunPenerima').val() || "{{ date('Y') }}";

    function getYearDataset(year) {
        return allYearsData[year] || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }

    function updateSummaryStats(year, data) {
        var total = data.reduce(function(a, b) { return a + b; }, 0);
        var avg = (total / 12).toFixed(1);
        var max = Math.max.apply(Math, data);
        var maxIndex = data.indexOf(max);
        var bulanMax = max > 0 ? namaBulanLengkap[maxIndex] + ' (' + max + ')' : '-';
        
        $('.badgeYear').text(year);
        $('#statTotalTahun').text(total + ' Orang');
        $('#statRataRata').text(avg + ' / bln');
        $('#statTertinggi').text(bulanMax);
    }

    // 1. Chart Bar Penerima Manfaat
    var ctxBar = document.getElementById('chartPenerimaManfaat').getContext('2d');
    
    var gradientFill = ctxBar.createLinearGradient(0, 0, 0, 240);
    gradientFill.addColorStop(0, 'rgba(37, 99, 235, 0.9)');
    gradientFill.addColorStop(1, 'rgba(37, 99, 235, 0.15)');

    var initialData = getYearDataset(currentYear);
    updateSummaryStats(currentYear, initialData);

    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Jumlah Penerima Manfaat',
                data: initialData,
                backgroundColor: gradientFill,
                borderColor: '#2563eb',
                borderWidth: 1.5,
                borderRadius: 6,
                barPercentage: 0.6,
                categoryPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: '#1e293b',
                titleFontSize: 13,
                bodyFontSize: 12,
                xPadding: 10,
                yPadding: 10,
                displayColors: false,
                callbacks: {
                    title: function(tooltipItem) {
                        var idx = tooltipItem[0].index;
                        return 'Bulan: ' + namaBulanLengkap[idx] + ' ' + $('#filterTahunPenerima').val();
                    },
                    label: function(tooltipItem) {
                        return ' Total: ' + tooltipItem.yLabel + ' Penerima Manfaat';
                    }
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        fontColor: '#64748b',
                        fontSize: 12,
                        fontStyle: '600'
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                        fontColor: '#64748b',
                        fontSize: 11
                    }
                }]
            }
        }
    });

    $('#filterTahunPenerima').on('change', function() {
        var selectedYear = $(this).val();
        var newData = getYearDataset(selectedYear);
        barChart.data.datasets[0].data = newData;
        barChart.update();
        updateSummaryStats(selectedYear, newData);
    });

    // 2. Donut / Pie Chart Status Antrian Pasien (Blue Palette)
    var ctxPie = document.getElementById('chartStatusAntrian').getContext('2d');
    var statusData = {!! json_encode($statusAntrian) !!};

    var pieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Antrian', 'Pemeriksaan', 'Menunggu', 'Selesai'],
            datasets: [{
                data: [
                    statusData.antrian,
                    statusData.pemeriksaan,
                    statusData.menunggu,
                    statusData.selesai
                ],
                backgroundColor: [
                    '#60a5fa', // Antrian (Sky Blue)
                    '#2563eb', // Pemeriksaan (Royal Blue)
                    '#93c5fd', // Menunggu (Light Blue)
                    '#1e40af'  // Selesai (Deep Navy Blue)
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 68,
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: '#1e293b',
                titleFontSize: 13,
                bodyFontSize: 12,
                xPadding: 10,
                yPadding: 10,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var val = data.datasets[0].data[tooltipItem.index] || 0;
                        var total = data.datasets[0].data.reduce(function(a, b) { return a + b; }, 0);
                        var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                        return ' ' + label + ': ' + val + ' Pasien (' + pct + '%)';
                    }
                }
            }
        }
    });

    // 3. Chart Tren Pelayanan (7 / 30 Hari - Blue Palette)
    var ctxTren = document.getElementById('chartTren7Hari').getContext('2d');
    var allTrenData = {!! json_encode($trenPelayananAll) !!};
    var currentRentang = '7';
    var tren7HariData = allTrenData['7'];

    var gradientPeriksa = ctxTren.createLinearGradient(0, 0, 0, 240);
    gradientPeriksa.addColorStop(0, 'rgba(30, 64, 175, 0.35)');
    gradientPeriksa.addColorStop(1, 'rgba(30, 64, 175, 0.02)');

    var gradientPasien = ctxTren.createLinearGradient(0, 0, 0, 240);
    gradientPasien.addColorStop(0, 'rgba(56, 189, 248, 0.35)');
    gradientPasien.addColorStop(1, 'rgba(56, 189, 248, 0.01)');

    var chart7Hari = new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: tren7HariData.labels,
            datasets: [
                {
                    label: 'Pelayanan Rekam Medis',
                    data: tren7HariData.periksa,
                    borderColor: '#1e40af',
                    backgroundColor: gradientPeriksa,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#1e40af',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    lineTension: 0.35,
                    fill: true
                },
                {
                    label: 'Penerima Manfaat Baru',
                    data: tren7HariData.pasien_baru,
                    borderColor: '#38bdf8',
                    backgroundColor: gradientPasien,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#38bdf8',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    lineTension: 0.35,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                backgroundColor: '#1e293b',
                titleFontSize: 13,
                bodyFontSize: 12,
                xPadding: 12,
                yPadding: 10,
                callbacks: {
                    title: function(tooltipItem) {
                        var idx = tooltipItem[0].index;
                        var activeObj = allTrenData[currentRentang] || tren7HariData;
                        return (activeObj.full_labels && activeObj.full_labels[idx]) ? activeObj.full_labels[idx] : tooltipItem[0].xLabel;
                    },
                    label: function(tooltipItem, data) {
                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                        return ' ' + datasetLabel + ': ' + tooltipItem.yLabel + ' orang/pelayanan';
                    }
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        fontColor: '#64748b',
                        fontSize: 11,
                        fontStyle: '600'
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                        fontColor: '#64748b',
                        fontSize: 11
                    }
                }]
            }
        }
    });

    $('#filterRentangTren').on('change', function() {
        var range = $(this).val();
        currentRentang = range;
        var dataObj = allTrenData[range];
        if (!dataObj) return;

        chart7Hari.data.labels = dataObj.labels;
        chart7Hari.data.datasets[0].data = dataObj.periksa;
        chart7Hari.data.datasets[1].data = dataObj.pasien_baru;
        chart7Hari.update();

        var labelText = range === '30' ? '30 Hari Terakhir' : '7 Hari Terakhir';
        var badgeText = range === '30' ? '30 Hari' : '7 Hari';
        $('#labelRentangTren').text(labelText);
        $('.badgeRentangText').text(badgeText);

        $('#statTotalPeriksaTren').text(dataObj.total_periksa + ' Pasien');
        $('#statAvgPeriksaTren').text(dataObj.avg_periksa + ' / hari');
        $('#statTotalPasienBaruTren').text(dataObj.total_pasien_baru + ' Orang');
        $('#statHariTertinggiTren').text(dataObj.hari_tertinggi);
    });

    // 4. Donut Chart Penerima Manfaat per Omah Terapiku
    var ctxOmah = document.getElementById('chartOmahTerapiku').getContext('2d');
    var omahData = {!! json_encode($pasienOmah) !!};

    var chartOmah = new Chart(ctxOmah, {
        type: 'doughnut',
        data: {
            labels: omahData.labels,
            datasets: [{
                data: omahData.counts,
                backgroundColor: omahData.colors,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 65,
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: '#1e293b',
                titleFontSize: 13,
                bodyFontSize: 12,
                xPadding: 10,
                yPadding: 10,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var val = data.datasets[0].data[tooltipItem.index] || 0;
                        var total = data.datasets[0].data.reduce(function(a, b) { return a + b; }, 0);
                        var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                        return ' ' + label + ': ' + val + ' Pasien (' + pct + '%)';
                    }
                }
            }
        }
    });

    // 5. Donut / Pie Chart Distribusi Jenis Layanan Terapi
    var ctxTerapi = document.getElementById('chartDistribusiTerapi').getContext('2d');
    var terapiData = {!! json_encode($distribusiTerapi) !!};

    var chartTerapi = new Chart(ctxTerapi, {
        type: 'doughnut',
        data: {
            labels: terapiData.labels,
            datasets: [{
                data: terapiData.counts,
                backgroundColor: terapiData.colors,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 65,
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: '#1e293b',
                titleFontSize: 13,
                bodyFontSize: 12,
                xPadding: 10,
                yPadding: 10,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var val = data.datasets[0].data[tooltipItem.index] || 0;
                        var total = data.datasets[0].data.reduce(function(a, b) { return a + b; }, 0);
                        var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                        return ' ' + label + ': ' + val + ' Sesi (' + pct + '%)';
                    }
                }
            }
        }
    });

    // 6. Bar Chart Demografi Kelompok Usia
    var ctxUsia = document.getElementById('chartDemografiUsia').getContext('2d');
    var usiaData = {!! json_encode($demografi['usia']) !!};

    var chartUsia = new Chart(ctxUsia, {
        type: 'bar',
        data: {
            labels: usiaData.labels,
            datasets: [{
                label: 'Jumlah Pasien',
                data: usiaData.counts,
                backgroundColor: usiaData.colors,
                borderRadius: 6,
                barPercentage: 0.55,
                categoryPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: '#1e293b',
                titleFontSize: 13,
                bodyFontSize: 12,
                xPadding: 10,
                yPadding: 10,
                displayColors: false,
                callbacks: {
                    label: function(tooltipItem) {
                        return ' ' + tooltipItem.yLabel + ' Orang Pasien';
                    }
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        fontColor: '#64748b',
                        fontSize: 11,
                        fontStyle: '600'
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                        fontColor: '#64748b',
                        fontSize: 11
                    }
                }]
            }
        }
    });

    // 7. Interactive Filter Top 5 Rencana Tindakan & Intervensi
    var allTopTindakan = {!! json_encode($allTopTindakan) !!};
    var labelBulanIniTindakan = "{{ $bulan }} {{ date('Y') }}";
    var labelTahunIniTindakan = "Tahun {{ date('Y') }}";

    function renderTopTindakan(periode) {
        var data = allTopTindakan[periode] || { items: [], total: 0 };
        var container = $('#containerTopTindakan');
        var badgeTotal = $('#badgeTotalTindakan');
        var labelPeriode = $('#labelPeriodeTindakan');

        badgeTotal.text('Total: ' + (data.total || 0) + ' Tindakan');

        if (periode === 'bulan') {
            labelPeriode.html('Periode: <strong class="text-primary">' + labelBulanIniTindakan + '</strong>');
        } else if (periode === 'tahun') {
            labelPeriode.html('Periode: <strong class="text-primary">' + labelTahunIniTindakan + '</strong>');
        } else {
            labelPeriode.html('Periode: <strong class="text-primary">Semua Waktu</strong>');
        }

        if (!data.items || data.items.length === 0 || data.total === 0) {
            container.html(
                '<div class="text-center py-4 text-muted">' +
                    '<i class="fa-solid fa-clipboard-list fa-2x mb-2 text-muted" style="opacity: 0.5;"></i>' +
                    '<p class="fs-12 mb-0">Belum ada data tindakan terapi pada periode ini.</p>' +
                '</div>'
            );
            return;
        }

        var html = '';
        data.items.forEach(function(tdk, index) {
            var safeNama = $('<div>').text(tdk.nama).html();
            html += '<div class="p-2 mb-2 rounded" style="background: #ffffff; border: 1px solid #edf2f7; transition: all 0.2s ease;">' +
                '<div class="d-flex justify-content-between align-items-center mb-1">' +
                    '<div class="d-flex align-items-center text-truncate" style="max-width: 70%;">' +
                        '<span class="badge badge-pill badge-primary mr-2 font-w700" style="width: 22px; height: 22px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; background: ' + tdk.color + ';">' +
                            '#' + (index + 1) +
                        '</span>' +
                        '<span class="fs-12 text-dark font-w600 text-truncate" title="' + safeNama + '">' +
                            safeNama +
                        '</span>' +
                    '</div>' +
                    '<div class="text-right flex-shrink-0">' +
                        '<span class="badge badge-light font-w700 text-primary" style="font-size: 11px; background: #f1f5f9;">' +
                            tdk.total + ' Kali' +
                        '</span>' +
                    '</div>' +
                '</div>' +
                '<div class="progress" style="height: 6px; background: #f1f5f9; border-radius: 4px;">' +
                    '<div class="progress-bar" role="progressbar" style="width: ' + tdk.bar_persen + '%; background-color: ' + tdk.color + '; border-radius: 4px;" aria-valuenow="' + tdk.bar_persen + '" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
            '</div>';
        });

        container.html(html);
    }

    $('#filterPeriodeTindakan').on('change', function() {
        var selectedPeriode = $(this).val();
        renderTopTindakan(selectedPeriode);
    });

    // 8. Interactive Filter Top Diagnosa
    var allTopDiagnosa = {!! json_encode($allTopDiagnosa) !!};
    var labelBulanIniDiagnosa = "{{ $bulan }} {{ date('Y') }}";
    var labelTahunIniDiagnosa = "Tahun {{ date('Y') }}";

    function renderTopDiagnosa(periode) {
        var data = allTopDiagnosa[periode] || { items: [], total: 0 };
        var container = $('#containerTopDiagnosa');
        var badgeTotal = $('#badgeTotalDiagnosa');
        var labelPeriode = $('#labelPeriodeDiagnosa');

        badgeTotal.text('Total: ' + (data.total || 0) + ' Kasus');

        if (periode === 'bulan') {
            labelPeriode.html('Periode: <strong class="text-primary">' + labelBulanIniDiagnosa + '</strong>');
        } else if (periode === 'tahun') {
            labelPeriode.html('Periode: <strong class="text-primary">' + labelTahunIniDiagnosa + '</strong>');
        } else {
            labelPeriode.html('Periode: <strong class="text-primary">Semua Waktu</strong>');
        }

        if (!data.items || data.items.length === 0 || data.total === 0) {
            container.html(
                '<div class="text-center py-5 text-muted">' +
                    '<i class="fa fa-stethoscope text-muted fs-24 mb-2 d-block" style="opacity: 0.5;"></i>' +
                    '<p class="fs-12 mb-0">Belum ada data diagnosa pada periode ini.</p>' +
                '</div>'
            );
            return;
        }

        var html = '';
        data.items.forEach(function(dg, index) {
            var safeCode = $('<div>').text(dg.code).html();
            var safeNama = $('<div>').text(dg.nama).html();
            html += '<div class="p-2 mb-2 rounded" style="background: #ffffff; border: 1px solid #edf2f7; transition: all 0.2s ease;">' +
                '<div class="d-flex justify-content-between align-items-center mb-1">' +
                    '<div class="d-flex align-items-center text-truncate" style="max-width: 72%;">' +
                        '<span class="badge badge-pill badge-primary mr-2 font-w700" style="width: 22px; height: 22px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; background: ' + dg.color + ';">' +
                            '#' + (index + 1) +
                        '</span>' +
                        '<span class="badge badge-info light font-w700 mr-1" style="font-size: 10.5px; padding: 2px 6px;">' +
                            safeCode +
                        '</span>' +
                        '<span class="fs-12 text-dark font-w600 text-truncate" title="' + safeNama + '">' +
                            safeNama +
                        '</span>' +
                    '</div>' +
                    '<div class="text-right flex-shrink-0">' +
                        '<span class="badge badge-light font-w700 text-primary" style="font-size: 11px; background: #f1f5f9;">' +
                            dg.total + ' Kasus' +
                        '</span>' +
                    '</div>' +
                '</div>' +
                '<div class="progress" style="height: 6px; background: #f1f5f9; border-radius: 4px;">' +
                    '<div class="progress-bar" role="progressbar" style="width: ' + dg.bar_persen + '%; background-color: ' + dg.color + '; border-radius: 4px;" aria-valuenow="' + dg.bar_persen + '" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
            '</div>';
        });

        container.html(html);
    }

    $('#filterPeriodeDiagnosa').on('change', function() {
        var selectedPeriode = $(this).val();
        renderTopDiagnosa(selectedPeriode);
    });
});
</script>
@endsection
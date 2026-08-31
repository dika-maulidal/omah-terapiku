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
        $tren7Hari = $query->getTren7HariTerakhir();
        $pasienOmah = $query->getPasienPerOmahTerapiku();
    @endphp

    <!-- Dashboard Header -->
    <div class="form-head d-flex flex-wrap align-items-center justify-content-between mb-3">
        <div class="mr-auto">
            <h3 class="font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Dashboard Pendaftaran</h3>
            <p class="fs-13 text-muted mb-0">Selamat Datang, <strong>{{ auth()->user()->name }}</strong> &bull; Loket Pendaftaran Omah Terapiku</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-light text-dark font-w600" style="padding: 8px 16px; font-size: 12.5px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-radius: 8px;">
                <i class="fa fa-calendar text-primary mr-1"></i> {{ $tanggalFormatted }}
            </span>
        </div>
    </div>

    <!-- Stat Widgets (Top Row) -->
    <div class="row">
        <!-- Pendaftaran Hari Ini -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-navy">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Pendaftaran Hari Ini</p>
                        <h2 class="ot-stat-number">{{ $query->perikaHariini() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-calendar-check-o"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-primary light">Hari Ini</span>
                    <span>Bulan Ini: {{ $query->perikaBulanini() }}</span>
                </div>
            </div>
        </div>

        <!-- Total Penerima Manfaat -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-cyan">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Total Penerima Manfaat</p>
                        <h2 class="ot-stat-number">{{ $query->totalPasien() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-info light">Terdaftar</span>
                    <span>Penerima Manfaat</span>
                </div>
            </div>
        </div>

        <!-- Total Terapis -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-yellow">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Total Terapis</p>
                        <h2 class="ot-stat-number">{{ $query->totalDoktor() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-user-md"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-warning light">Aktif</span>
                    <span>Terapis Medis</span>
                </div>
            </div>
        </div>

        <!-- Total Riwayat Periksa -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-green">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Total Riwayat Periksa</p>
                        <h2 class="ot-stat-number">{{ $query->totalPeriksa() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-success light">Akumulasi</span>
                    <span>Tahun {{ date('Y') }}: {{ $query->perikaTahunini() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Tren 7 Hari Terakhir Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-line-chart text-primary mr-2"></i> Grafik Tren Pelayanan & Pendaftaran (7 Hari Terakhir)
                        </h4>
                        <p class="fs-12 text-muted mb-0">Pergerakan jumlah pelayanan rekam medis dan penerima manfaat baru dalam 7 hari terakhir</p>
                    </div>
                    <div class="d-flex align-items-center flex-wrap mt-2 mt-sm-0" style="gap: 14px;">
                        <div class="d-flex align-items-center font-w600 fs-12" style="color: var(--ot-navy);">
                            <span style="display: inline-block; width: 12px; height: 12px; background: #2e4b82; border-radius: 3px; margin-right: 6px;"></span>
                            Pelayanan Rekam Medis
                        </div>
                        <div class="d-flex align-items-center font-w600 fs-12" style="color: #d98f18;">
                            <span style="display: inline-block; width: 12px; height: 12px; background: #f5a623; border-radius: 3px; margin-right: 6px;"></span>
                            Penerima Manfaat Baru
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div style="position: relative; height: 260px;">
                        <canvas id="chartTren7Hari"></canvas>
                    </div>
                    <!-- Ringkasan Metrik 7 Hari -->
                    <div class="row text-center mt-3 pt-3" style="border-top: 1px dashed #e2e8f0;">
                        <div class="col-sm-3 col-6 mb-2 mb-sm-0">
                            <small class="text-muted d-block font-w600 fs-12">Total Pelayanan 7 Hari</small>
                            <span class="font-w700 text-primary fs-16">{{ $tren7Hari['total_periksa'] }} Pasien</span>
                        </div>
                        <div class="col-sm-3 col-6 mb-2 mb-sm-0" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Rata-rata Harian</small>
                            <span class="font-w700 text-success fs-16">{{ $tren7Hari['avg_periksa'] }} / hari</span>
                        </div>
                        <div class="col-sm-3 col-6" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Penerima Baru 7 Hari</small>
                            <span class="font-w700 text-warning fs-16">{{ $tren7Hari['total_pasien_baru'] }} Orang</span>
                        </div>
                        <div class="col-sm-3 col-6" style="border-left: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Puncak Tertinggi</small>
                            <span class="font-w700 text-info fs-16">{{ $tren7Hari['hari_tertinggi'] }}</span>
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
                            <i class="fa fa-bar-chart text-primary mr-2"></i> Grafik Total Penerima Manfaat per Bulan
                        </h4>
                        <p class="fs-12 text-muted mb-0">Tren pendaftaran penerima manfaat berdasarkan bulan</p>
                    </div>
                    <div class="d-flex align-items-center mt-2 mt-sm-0" style="gap: 8px;">
                        <label class="mb-0 text-muted font-w600" style="font-size: 12px;"><i class="fa fa-filter mr-1"></i> Filter Tahun:</label>
                        <select id="filterTahunPenerima" class="form-control form-control-sm font-w700 text-primary" style="width: 110px; height: 34px; font-size: 12.5px; border-radius: 6px; border-color: #cbd5e1; cursor: pointer;">
                            @foreach ($availableYears as $yr)
                                <option value="{{ $yr }}" {{ $yr == date('Y') ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div style="position: relative; height: 210px;">
                        <canvas id="chartPenerimaManfaat"></canvas>
                    </div>
                    <!-- Stat Ringkasan di Bawah Grafik -->
                    <div class="row text-center mt-3 pt-3" style="border-top: 1px dashed #e2e8f0;">
                        <div class="col-4">
                            <small class="text-muted d-block font-w600 fs-12">Total Tahun <span class="badgeYear">{{ date('Y') }}</span></small>
                            <span class="font-w700 text-primary fs-15" id="statTotalTahun">-</span>
                        </div>
                        <div class="col-4" style="border-left: 1px solid #edf2f7; border-right: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600 fs-12">Rata-rata / Bulan</small>
                            <span class="font-w700 text-success fs-15" id="statRataRata">-</span>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block font-w600 fs-12">Bulan Tertinggi</small>
                            <span class="font-w700 text-info fs-15" id="statTertinggi">-</span>
                        </div>
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
                            <i class="fa fa-pie-chart text-primary mr-2"></i> Penerima Manfaat per Omah Terapiku
                        </h4>
                        <p class="fs-12 text-muted mb-0">Distribusi penerima manfaat di setiap unit pelayanan</p>
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

    <!-- Main Content Row (3 Columns: Status Antrian, Pendaftaran Hari Ini, Top Diagnosa) -->
    <div class="row mb-4">
        <!-- Kolom 1: Status Antrian Pasien -->
        <div class="col-xl-4 col-lg-12 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
                <div class="card-header d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid #edf2f7;">
                    <div>
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-circle-o-notch text-primary mr-2"></i> Status Antrian Pasien
                        </h4>
                        <p class="fs-12 text-muted mb-0">Distribusi status pelayanan rekam medis</p>
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
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #fff8eb; border: 1px solid #ffe8cc;">
                                    <span class="font-w600 text-warning" style="font-size: 11.5px;">
                                        <i class="fa fa-circle mr-1"></i> Antrian
                                    </span>
                                    <strong class="text-dark">{{ $statusAntrian['antrian'] }}</strong>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #ebf5ff; border: 1px solid #cce5ff;">
                                    <span class="font-w600 text-primary" style="font-size: 11.5px;">
                                        <i class="fa fa-circle mr-1"></i> Periksa
                                    </span>
                                    <strong class="text-dark">{{ $statusAntrian['pemeriksaan'] }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #f5f0ff; border: 1px solid #e0d4fc;">
                                    <span class="font-w600" style="color: #7367f0; font-size: 11.5px;">
                                        <i class="fa fa-circle mr-1"></i> Menunggu
                                    </span>
                                    <strong class="text-dark">{{ $statusAntrian['menunggu'] }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: #ebfaf0; border: 1px solid #c3e6cb;">
                                    <span class="font-w600 text-success" style="font-size: 11.5px;">
                                        <i class="fa fa-circle mr-1"></i> Selesai
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
                        <i class="fa fa-user-plus text-primary mr-1"></i> Pendaftaran Hari Ini
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
                                        <a href="{{ Route('rekam.detail', $item->pasien_id) }}" class="btn btn-xs btn-primary shadow-sm" title="Lihat Rekam Medis">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-calendar-check-o text-muted fs-24 mb-2 d-block"></i>
                                <p class="fs-13 mb-2">Belum ada pendaftaran pasien hari ini.</p>
                                <a href="{{ Route('rekam.add') }}" class="btn btn-xs btn-primary font-w600" style="padding: 6px 14px; border-radius: 6px;">
                                    <i class="fa fa-plus mr-1"></i> + Tambah Rekam Medis
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
                    <div class="mr-auto">
                        <h4 class="fs-15 font-w700 text-primary mb-0" style="color: var(--ot-navy) !important; font-weight: 700;">
                            <i class="fa fa-medkit text-primary mr-1"></i> Top Diagnosa & Statistik
                        </h4>
                    </div>
                    <div class="ot-card-tabs mt-1 mt-sm-0">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#MonthlyDiagnosa" role="tab">Bulan Ini</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#YearlyDiagnosa" role="tab">Tahun Ini</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="tab-content">
                        <!-- Tab 1: Monthly Diagnosa -->
                        <div class="tab-pane fade show active" id="MonthlyDiagnosa" role="tabpanel">
                            @php $diagnosaBulan = $query->diagnosaBulanan(); @endphp
                            @if (count($diagnosaBulan) > 0)
                                <div class="d-flex flex-column" style="gap: 8px;">
                                    @foreach ($diagnosaBulan as $index => $item)
                                        <div class="ot-diagnosa-item">
                                            <div class="d-flex align-items-center" style="min-width: 0;">
                                                <span class="badge badge-primary light font-w600 mr-2" style="font-size: 11px; min-width: 24px; text-align: center;">
                                                    {{ $index + 1 }}
                                                </span>
                                                <div style="min-width: 0;">
                                                    <span class="badge badge-info light font-w600 mr-1" style="font-size: 11px;">
                                                        {{ $item->diagnosa }}
                                                    </span>
                                                    <span class="fs-12 text-black font-w500 text-truncate d-inline-block" style="max-width: 260px; vertical-align: middle;" title="{{ $item->name_id ?? '-' }}">
                                                        {{ $item->name_id ?? '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center flex-shrink-0 ml-2">
                                                <span class="badge badge-primary font-w600" style="font-size: 11px;">
                                                    {{ $item->total }} Kasus
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fa fa-stethoscope text-muted fs-24 mb-2 d-block"></i>
                                    <p class="fs-12 mb-0">Belum ada data diagnosa untuk bulan ini.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tab 2: Yearly Diagnosa -->
                        <div class="tab-pane fade" id="YearlyDiagnosa" role="tabpanel">
                            @php $diagnosaTahun = $query->diagnosaYearly(); @endphp
                            @if (count($diagnosaTahun) > 0)
                                <div class="d-flex flex-column" style="gap: 8px;">
                                    @foreach ($diagnosaTahun as $index => $item)
                                        <div class="ot-diagnosa-item">
                                            <div class="d-flex align-items-center" style="min-width: 0;">
                                                <span class="badge badge-success light font-w600 mr-2" style="font-size: 11px; min-width: 24px; text-align: center;">
                                                    {{ $index + 1 }}
                                                </span>
                                                <div style="min-width: 0;">
                                                    <span class="badge badge-info light font-w600 mr-1" style="font-size: 11px;">
                                                        {{ $item->diagnosa }}
                                                    </span>
                                                    <span class="fs-12 text-black font-w500 text-truncate d-inline-block" style="max-width: 260px; vertical-align: middle;" title="{{ $item->name_id ?? '-' }}">
                                                        {{ $item->name_id ?? '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center flex-shrink-0 ml-2">
                                                <span class="badge badge-success font-w600" style="font-size: 11px;">
                                                    {{ $item->total }} Kasus
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fa fa-stethoscope text-muted fs-24 mb-2 d-block"></i>
                                    <p class="fs-12 mb-0">Belum ada data diagnosa untuk tahun ini.</p>
                                </div>
                            @endif
                        </div>
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
    gradientFill.addColorStop(0, 'rgba(46, 75, 130, 0.9)');
    gradientFill.addColorStop(1, 'rgba(46, 75, 130, 0.2)');

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
                borderColor: '#2e4b82',
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

    // 2. Donut / Pie Chart Status Antrian Pasien
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
                    '#ff9f43',
                    '#2e4b82',
                    '#7367f0',
                    '#28c76f'
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

    // 3. Chart Tren 7 Hari Terakhir
    var ctxTren = document.getElementById('chartTren7Hari').getContext('2d');
    var tren7HariData = {!! json_encode($tren7Hari) !!};

    var gradientPeriksa = ctxTren.createLinearGradient(0, 0, 0, 240);
    gradientPeriksa.addColorStop(0, 'rgba(46, 75, 130, 0.35)');
    gradientPeriksa.addColorStop(1, 'rgba(46, 75, 130, 0.02)');

    var gradientPasien = ctxTren.createLinearGradient(0, 0, 0, 240);
    gradientPasien.addColorStop(0, 'rgba(245, 166, 35, 0.3)');
    gradientPasien.addColorStop(1, 'rgba(245, 166, 35, 0.01)');

    var chart7Hari = new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: tren7HariData.labels,
            datasets: [
                {
                    label: 'Pelayanan Rekam Medis',
                    data: tren7HariData.periksa,
                    borderColor: '#2e4b82',
                    backgroundColor: gradientPeriksa,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2e4b82',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    lineTension: 0.35,
                    fill: true
                },
                {
                    label: 'Penerima Manfaat Baru',
                    data: tren7HariData.pasien_baru,
                    borderColor: '#f5a623',
                    backgroundColor: gradientPasien,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#f5a623',
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
                        return tren7HariData.full_labels[idx] || tooltipItem[0].xLabel;
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
});
</script>
@endsection
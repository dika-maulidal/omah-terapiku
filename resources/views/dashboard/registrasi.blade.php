@inject('query', 'App\Models\DashboardQuery')

@extends('layout.apps')
@section('content')
    @php
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date('w')];
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][date('n') - 1];
        $tanggalFormatted = $hari . ', ' . date('j') . ' ' . $bulan . ' ' . date('Y');
    @endphp

    <!-- Dashboard Header -->
    <div class="form-head d-flex flex-wrap align-items-center justify-content-between mb-3">
        <div class="mr-auto">
            <h3 class="text-black font-w600 mb-0" style="font-size: 20px;">Dashboard Pendaftaran</h3>
            <p class="fs-13 text-muted mb-0">Selamat Datang, <strong>{{ auth()->user()->name }}</strong></p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-light text-dark font-w500" style="padding: 7px 12px; font-size: 12px; border: 1px solid #e2e8f0; background: #fff;">
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
                    <span>Terapis Siap Melayani</span>
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

    <!-- Main Content Row (Side by Side, Equal Height & Clean Spacing) -->
    <div class="row mb-4">
        <!-- Left Column: Perawatan Hari Ini -->
        <div class="col-xl-6 col-lg-12 mb-3 mb-xl-0">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h4 class="fs-15 font-w600 text-black mb-0">
                        <i class="fa fa-heartbeat text-primary mr-1"></i> Perawatan Hari Ini
                    </h4>
                    <div class="d-flex align-items-center">
                        <a href="{{ Route('penerima-manfaat.add') }}" class="btn btn-xs btn-primary mr-2">
                            <i class="fa fa-plus mr-1"></i> Pasien Baru
                        </a>
                        <span class="badge badge-primary light font-w600">
                            {{ $query->rekam_day()->count() }} Pasien
                        </span>
                    </div>
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
                                <p class="fs-13 mb-2">Belum ada pelayanan pasien hari ini.</p>
                                <a href="{{ Route('penerima-manfaat.add') }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-user-plus mr-1"></i> Daftarkan Pasien
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Top Diagnosa & Statistik (Side by Side with Perawatan Hari Ini) -->
        <div class="col-xl-6 col-lg-12">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3">
                    <div class="mr-auto">
                        <h4 class="fs-15 font-w600 text-black mb-0">
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
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#StatistikTab" role="tab">Statistik</a>
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
                                <div class="ot-diagnosa-list" style="max-height: 380px; overflow-y: auto; padding-right: 2px;">
                                    @foreach ($diagnosaBulan as $index => $item)
                                        <div class="ot-diagnosa-item">
                                            <div class="d-flex align-items-center" style="min-width: 0; flex: 1;">
                                                <span class="ot-rank-badge mr-2">#{{ $index + 1 }}</span>
                                                <span class="ot-diagnosa-code mr-2">{{ $item->diagnosa }}</span>
                                                <span class="ot-diagnosa-name text-truncate" title="{{ $item->name_id ?? $item->diagnosa }}">
                                                    {{ $item->name_id ?? $item->diagnosa }}
                                                </span>
                                            </div>
                                            <span class="ot-diagnosa-count">{{ $item->total }} Kasus</span>
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
                                <div class="ot-diagnosa-list" style="max-height: 380px; overflow-y: auto; padding-right: 2px;">
                                    @foreach ($diagnosaTahun as $index => $item)
                                        <div class="ot-diagnosa-item">
                                            <div class="d-flex align-items-center" style="min-width: 0; flex: 1;">
                                                <span class="ot-rank-badge mr-2">#{{ $index + 1 }}</span>
                                                <span class="ot-diagnosa-code mr-2">{{ $item->diagnosa }}</span>
                                                <span class="ot-diagnosa-name text-truncate" title="{{ $item->name_id ?? $item->diagnosa }}">
                                                    {{ $item->name_id ?? $item->diagnosa }}
                                                </span>
                                            </div>
                                            <span class="ot-diagnosa-count">{{ $item->total }} Kasus</span>
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

                        <!-- Tab 3: Statistik Ringkasan -->
                        <div class="tab-pane fade" id="StatistikTab" role="tabpanel">
                            <div class="d-flex flex-column" style="gap: 10px;">
                                <div class="ot-stat-highlight">
                                    <div>
                                        <p class="fs-12 text-muted mb-0 font-w500">Pemeriksaan Hari Ini</p>
                                        <h2 class="fs-22 text-primary font-w700 mb-0">{{ $query->perikaHariini() }}</h2>
                                        <span class="fs-11 text-muted">{{ date('d M Y') }}</span>
                                    </div>
                                    <div class="ot-stat-highlight-icon">
                                        <i class="fa fa-calendar-check-o"></i>
                                    </div>
                                </div>
                                <div class="ot-stat-highlight">
                                    <div>
                                        <p class="fs-12 text-muted mb-0 font-w500">Pemeriksaan Bulan Ini</p>
                                        <h2 class="fs-22 text-primary font-w700 mb-0">{{ $query->perikaBulanini() }}</h2>
                                        <span class="fs-11 text-muted">Periode {{ date('F Y') }}</span>
                                    </div>
                                    <div class="ot-stat-highlight-icon" style="background-color: var(--ot-cyan);">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <div class="ot-stat-highlight">
                                    <div>
                                        <p class="fs-12 text-muted mb-0 font-w500">Pemeriksaan Tahun Ini</p>
                                        <h2 class="fs-22 text-primary font-w700 mb-0">{{ $query->perikaTahunini() }}</h2>
                                        <span class="fs-11 text-muted">Tahun {{ date('Y') }}</span>
                                    </div>
                                    <div class="ot-stat-highlight-icon" style="background-color: var(--ot-yellow);">
                                        <i class="fa fa-trophy"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
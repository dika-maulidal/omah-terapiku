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
            <h3 class="text-black font-w600 mb-0" style="font-size: 20px;">Dashboard Terapis</h3>
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
        <!-- Antrian Menunggu -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-yellow">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Pasien Sedang Antri</p>
                        <h2 class="ot-stat-number">{{ $query->pasienAntri() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-warning light">Menunggu</span>
                    <span>Antrian Hari Ini</span>
                </div>
            </div>
        </div>

        <!-- Periksa Hari Ini -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-navy">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Periksa Hari Ini</p>
                        <h2 class="ot-stat-number">{{ $query->perikaHariini() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-calendar-check-o"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-primary light">Selesai</span>
                    <span>Pelayanan Anda</span>
                </div>
            </div>
        </div>

        <!-- Total Penerima Manfaat -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-cyan">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Penerima Manfaat</p>
                        <h2 class="ot-stat-number">{{ $query->totalPasien() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-info light">Terdaftar</span>
                    <span>Database Pasien</span>
                </div>
            </div>
        </div>

        <!-- Total Anda Memeriksa -->
        <div class="col-xl-3 col-sm-6">
            <div class="ot-stat-card ot-green">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="ot-stat-title">Total Anda Memeriksa</p>
                        <h2 class="ot-stat-number">{{ $query->totalPeriksa() }}</h2>
                    </div>
                    <div class="ot-stat-icon-wrap">
                        <i class="fa fa-stethoscope"></i>
                    </div>
                </div>
                <div class="ot-stat-footer">
                    <span class="badge badge-pill badge-success light">Total</span>
                    <span>Riwayat Pemeriksaan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column: Antrian Pasien Perlu Diperiksa -->
        <div class="col-xl-7 mb-4">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h4 class="fs-15 font-w600 text-black mb-0">
                            <i class="fa fa-user-md text-primary mr-1"></i> Antrian Perlu Diperiksa
                        </h4>
                    </div>
                    <span class="badge badge-warning light font-w600">
                        {{ $query->rekam_antrian()->count() }} Menunggu
                    </span>
                </div>
                <div class="card-body p-3">
                    <div class="dz-scroll" style="overflow-y: auto; max-height: 420px; padding-right: 4px;">
                        <div id="antrian-list-notif">
                            @if ($query->rekam_antrian()->count() > 0)
                                @foreach ($query->rekam_antrian() as $item)
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
                                                        {{ $item->updated_at ? $item->updated_at->diffForHumans() : '-' }}
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-user-md text-muted"></i>
                                                        {{ $item->dokter->nama ?? 'Terapis' }}
                                                    </li>
                                                    @if($item->keluhan)
                                                    <li class="text-truncate" style="max-width: 200px;" title="{{ $item->keluhan }}">
                                                        <i class="fa fa-stethoscope text-muted"></i>
                                                        {{ $item->keluhan }}
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-shrink-0 ml-2">
                                            <div class="mr-2 text-right d-none d-sm-block">
                                                {!! $item->status_display() !!}
                                            </div>
                                            <a href="{{ Route('rekam.detail', $item->pasien_id) }}" class="btn btn-xs btn-primary shadow-sm">
                                                <i class="fa fa-user-md mr-1"></i> Periksa
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fa fa-check-circle-o text-success fs-24 mb-2 d-block"></i>
                                    <p class="fs-13 mb-0">Tidak ada antrian pasien yang sedang menunggu saat ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Pelayanan Hari Ini -->
        <div class="col-xl-5 mb-4">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h4 class="fs-15 font-w600 text-black mb-0">
                            <i class="fa fa-history text-primary mr-1"></i> Pelayanan Hari Ini
                        </h4>
                    </div>
                    <span class="badge badge-primary light font-w600">
                        {{ $query->rekam_day()->count() }} Selesai
                    </span>
                </div>
                <div class="card-body p-3">
                    <div class="dz-scroll" style="overflow-y: auto; max-height: 420px; padding-right: 4px;">
                        @if ($query->rekam_day()->count() > 0)
                            @foreach ($query->rekam_day() as $item)
                                <div class="ot-schedule-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center" style="min-width: 0;">
                                        <div class="ot-patient-avatar" style="background: var(--ot-green-light); color: var(--ot-green);">
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
                                                    {{ $item->created_at ? $item->created_at->format('H:i') : '-' }} WIB
                                                </li>
                                                @if($item->keluhan)
                                                <li class="text-truncate" style="max-width: 140px;" title="{{ $item->keluhan }}">
                                                    {{ $item->keluhan }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-2">
                                        {!! $item->status_display() !!}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-clock-o text-muted fs-24 mb-2 d-block"></i>
                                <p class="fs-13 mb-0">Belum ada pelayanan yang diselesaikan hari ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
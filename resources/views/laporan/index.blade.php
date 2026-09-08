@extends('layout.apps')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: 1px solid #e2e8f0;
    }
    .leaflet-popup-content {
        margin: 12px 14px;
        line-height: 1.4;
    }
    .custom-balai-marker {
        background: #ef4444;
        border: 2px solid #ffffff;
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(239, 68, 68, 0.45);
        font-size: 11.5px;
    }
    .custom-pulse-ring {
        position: absolute;
        border: 2px solid #ef4444;
        border-radius: 50%;
        animation: pulseMap 1.8s infinite;
        opacity: 0.8;
    }
    @keyframes pulseMap {
        0% { transform: scale(0.9); opacity: 0.8; }
        70% { transform: scale(2.2); opacity: 0; }
        100% { transform: scale(2.2); opacity: 0; }
    }
</style>
@endsection

@section('content')
    @php
        $totalDesilPasien = array_sum($data['desil_breakdown']);
        $desil12Count = ($data['desil_breakdown']['Desil 1'] ?? 0) + ($data['desil_breakdown']['Desil 2'] ?? 0);
        $desil12Pct = $totalDesilPasien > 0 ? round(($desil12Count / $totalDesilPasien) * 100, 1) : 0;
    @endphp

    <!-- Header Section (Unified White Card) -->
    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Laporan Eksekutif & Statistik Dinas Sosial</h3>
                        <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                            <li class="breadcrumb-item text-muted">Laporan & Evaluasi</li>
                            <li class="breadcrumb-item active text-muted">Executive Dashboard</li>
                        </ol>
                    </div>
                </div>
                <div>
                    <!-- Tombol Cetak PDF Resmi -->
                    <a href="{{ route('laporan.eksekutif.print', request()->all()) }}" target="_blank" class="btn btn-sm btn-primary font-w700 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                        <i class="fa-solid fa-print mr-1"></i> Cetak Laporan Resmi (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar Filter Periode & Layanan Card (Format Semula) -->
    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
        <div class="card-body p-3 p-md-4">
            <form method="GET" action="{{ route('laporan.eksekutif') }}" id="filterForm">
                <div class="row align-items-end">
                    <!-- 1. Tipe Periode -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-calendar-days mr-1 text-primary"></i> Jenis Periode Laporan:
                        </label>
                        <select name="tipe_periode" id="tipePeriodeSelect" class="form-control form-control-sm" style="height: 40px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 600;" onchange="togglePeriodeInput(this.value)">
                            <option value="bulanan" {{ $meta['tipe'] == 'bulanan' ? 'selected' : '' }}>Rekap Bulanan</option>
                            <option value="triwulan" {{ $meta['tipe'] == 'triwulan' ? 'selected' : '' }}>Triwulan (3 Bulan)</option>
                            <option value="semester" {{ $meta['tipe'] == 'semester' ? 'selected' : '' }}>Semester (6 Bulan)</option>
                            <option value="tahunan" {{ $meta['tipe'] == 'tahunan' ? 'selected' : '' }}>Tahunan (1 Tahun)</option>
                            <option value="custom" {{ $meta['tipe'] == 'custom' ? 'selected' : '' }}>Kustom Rentang Tanggal</option>
                        </select>
                    </div>

                    <!-- 2. Parameter Bulan (Bulanan) -->
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3 filter-input-group" id="inputBulan" style="{{ $meta['tipe'] == 'bulanan' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Bulan:</label>
                        <select name="bulan" class="form-control form-control-sm" style="height: 40px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            @foreach($meta['nama_bulan'] as $num => $nama)
                                <option value="{{ $num }}" {{ $meta['bulan'] == $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Parameter Triwulan (Triwulan) -->
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3 filter-input-group" id="inputTriwulan" style="{{ $meta['tipe'] == 'triwulan' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Triwulan:</label>
                        <select name="triwulan" class="form-control form-control-sm" style="height: 40px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            <option value="1" {{ $meta['triwulan'] == 1 ? 'selected' : '' }}>Triwulan I (Jan-Mar)</option>
                            <option value="2" {{ $meta['triwulan'] == 2 ? 'selected' : '' }}>Triwulan II (Apr-Jun)</option>
                            <option value="3" {{ $meta['triwulan'] == 3 ? 'selected' : '' }}>Triwulan III (Jul-Sep)</option>
                            <option value="4" {{ $meta['triwulan'] == 4 ? 'selected' : '' }}>Triwulan IV (Okt-Des)</option>
                        </select>
                    </div>

                    <!-- 4. Parameter Semester (Semester) -->
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3 filter-input-group" id="inputSemester" style="{{ $meta['tipe'] == 'semester' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Semester:</label>
                        <select name="semester" class="form-control form-control-sm" style="height: 40px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            <option value="1" {{ $meta['semester'] == 1 ? 'selected' : '' }}>Semester 1 (Jan-Jun)</option>
                            <option value="2" {{ $meta['semester'] == 2 ? 'selected' : '' }}>Semester 2 (Jul-Des)</option>
                        </select>
                    </div>

                    <!-- 5. Parameter Custom Range -->
                    <div class="col-lg-4 col-md-6 mb-3 filter-input-group" id="inputCustom" style="{{ $meta['tipe'] == 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Rentang Tanggal:</label>
                        <div class="d-flex align-items-center" style="gap: 6px;">
                            <input type="date" name="tgl_awal" value="{{ $meta['tgl_awal'] }}" class="form-control form-control-sm" style="height: 40px; font-size: 12px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                            <span class="text-muted font-w600">s/d</span>
                            <input type="date" name="tgl_akhir" value="{{ $meta['tgl_akhir'] }}" class="form-control form-control-sm" style="height: 40px; font-size: 12px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                        </div>
                    </div>

                    <!-- 6. Parameter Tahun -->
                    <div class="col-lg-2 col-md-3 col-sm-6 mb-3 filter-input-group" id="inputTahun" style="{{ $meta['tipe'] != 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Tahun:</label>
                        <select name="tahun" class="form-control form-control-sm" style="height: 40px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            @foreach($availableYears as $yr)
                                <option value="{{ $yr }}" {{ $meta['tahun'] == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 7. Filter UPT -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-hospital-user mr-1 text-primary"></i> Cakupan Lokasi UPT:
                        </label>
                        <select name="upt" class="form-control form-control-sm" style="height: 40px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            <option value="all" {{ $meta['upt'] == 'all' ? 'selected' : '' }}>Seluruh UPT (Provinsi Jatim)</option>
                            @foreach($allUpts as $u)
                                <option value="{{ $u->nama }}" {{ $meta['upt'] == $u->nama ? 'selected' : '' }}>{{ $u->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 8. Filter Layanan -->
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-tag mr-1 text-primary"></i> Ragam Layanan:
                        </label>
                        <select name="layanan" class="form-control form-control-sm" style="height: 40px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            <option value="all" {{ $meta['layanan'] == 'all' ? 'selected' : '' }}>Semua Layanan</option>
                            <option value="Fisioterapi" {{ $meta['layanan'] == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                            <option value="Terapi Wicara" {{ $meta['layanan'] == 'Terapi Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                            <option value="Terapi Okupasi" {{ $meta['layanan'] == 'Terapi Okupasi' ? 'selected' : '' }}>Terapi Okupasi</option>
                            <option value="Sensori Integrasi" {{ $meta['layanan'] == 'Sensori Integrasi' ? 'selected' : '' }}>Sensori Integrasi</option>
                        </select>
                    </div>

                    <!-- 9. Tombol Filter & Reset -->
                    <div class="col-lg-2 col-md-4 col-sm-12 mb-3 d-flex" style="gap: 6px;">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 font-w700 shadow-sm" style="height: 40px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none; font-size: 12.5px;">
                            <i class="fa-solid fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('laporan.eksekutif') }}" class="btn btn-light btn-sm font-w600" style="height: 40px; border-radius: 8px; border: 1.5px solid #cbd5e1; color: #64748b; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Info Ringkasan Periode Aktif -->
                <div class="d-flex flex-wrap align-items-center justify-content-between pt-2 border-top" style="border-color: #f1f5f9 !important; font-size: 12px;">
                    <div class="d-flex flex-wrap align-items-center" style="gap: 8px;">
                        <span class="text-muted font-w600">Filter Aktif:</span>
                        <span class="badge badge-primary light font-w600" style="font-size: 11.5px; padding: 4px 10px;">
                            <i class="fa-regular fa-calendar-check mr-1"></i> {{ $meta['periode_text'] }}
                        </span>
                        <span class="badge badge-info light font-w600" style="font-size: 11.5px; padding: 4px 10px;">
                            <i class="fa-solid fa-hospital-user mr-1"></i> {{ $meta['upt_text'] }}
                        </span>
                        @if($meta['layanan'] !== 'all')
                            <span class="badge badge-warning light font-w600" style="font-size: 11.5px; padding: 4px 10px;">
                                <i class="fa-solid fa-tag mr-1"></i> {{ $meta['layanan'] }}
                            </span>
                        @endif
                    </div>
                    <div class="text-muted mt-1 mt-md-0">
                        Rentang Data: <strong class="text-dark">{{ $meta['start_date']->format('d M Y') }}</strong> s/d <strong class="text-dark">{{ $meta['end_date']->format('d M Y') }}</strong>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 1. EXECUTIVE KPI SUMMARY CARDS (Nuansa Dashboard Utama) -->
    <!-- ========================================================================= -->
    <div class="row">
        <!-- Card 1: Total Sesi Pelayanan (Ocean Navy) -->
        <div class="col-xl-3 col-sm-6">
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

        <!-- Card 2: Total Penerima Manfaat Terlayani (Sky Cyan) -->
        <div class="col-xl-3 col-sm-6">
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

        <!-- Card 3: Rata-Rata Sesi per Hari Rabu Operasional (Fresh Green) -->
        <div class="col-xl-3 col-sm-6">
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

        <!-- Card 4: Ketepatan Sasaran DTKS (Warm Yellow / Amber) -->
        <div class="col-xl-3 col-sm-6">
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
        
        <!-- 2A. Distribusi Desil DTKS / DTSEN (Ketepatan Sasaran Bansos) -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
                <div class="card-header py-3 px-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15px;">
                            <i class="fa-solid fa-ranking-star mr-1.5" style="color: #2563eb;"></i> Distribusi Kategori Desil DTKS / DTSEN
                        </h5>
                    </div>
                    <span class="badge badge-primary light font-w700" style="font-size: 11px;">
                        {{ $totalDesilPasien }} Pasien
                    </span>
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

        <!-- 2B. Breakdown Layanan Terapi & Demografi Usia -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff;">
                <div class="card-header py-3 px-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="font-w700 mb-0" style="color: #1e40af; font-size: 15px;">
                            <i class="fa-solid fa-chart-pie mr-1.5" style="color: #2563eb;"></i> Ragam Layanan Terapi & Demografi Pasien
                        </h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Layanan Terapi Pills -->
                    <h6 class="font-w700 text-dark mb-3" style="font-size: 13px;">Distribusi Layanan Terapi:</h6>
                    <div class="row mb-3">
                        @forelse($data['layanan_breakdown'] as $layanan)
                            @php
                                $pctLayanan = $data['total_sesi'] > 0 ? round(($layanan->total / $data['total_sesi']) * 100, 1) : 0;
                            @endphp
                            <div class="col-sm-6 mb-3">
                                <div class="p-3 rounded d-flex align-items-center justify-content-between h-100" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 8px;">
                                    <div class="mr-2">
                                        <strong class="text-dark d-block font-w700" style="font-size: 12.5px;">{{ $layanan->layanan_terapi }}</strong>
                                        <small class="text-muted font-w500" style="font-size: 11px;">{{ $pctLayanan }}% dari total sesi</small>
                                    </div>
                                    <span class="badge badge-primary font-w700 flex-shrink-0" style="font-size: 12px; padding: 5px 10px; background: #2563eb; border-radius: 6px;">
                                        {{ $layanan->total }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-3 text-muted" style="font-size: 12px;">Belum ada data sesi terapi pada periode ini.</div>
                        @endforelse
                    </div>

                    <!-- Demografi Usia & Gender -->
                    <h6 class="font-w700 text-dark mb-3" style="font-size: 13.5px;">
                        <i class="fa-solid fa-users-rectangle mr-1.5 text-primary"></i> Kelompok Usia & Gender Pasien:
                    </h6>
                    <div class="row">
                        <!-- Kelompok Usia -->
                        <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
                            <div class="d-flex flex-column" style="gap: 12px;">
                                <!-- Anak-Anak / ABK -->
                                <div class="d-flex align-items-center justify-content-between transition-all" style="padding: 15px 18px; background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 12px; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.05);">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 d-flex align-items-center justify-content-center text-primary" style="width: 40px; height: 40px; border-radius: 10px; background: #dbeafe; font-size: 17px; flex-shrink: 0;">
                                            <i class="fa-solid fa-child"></i>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block font-w700" style="font-size: 13.5px; line-height: 1.3;">Anak-Anak / ABK</strong>
                                            <small class="text-muted font-w600" style="font-size: 11.5px;">&lt; 18 Tahun</small>
                                        </div>
                                    </div>
                                    <span class="badge badge-primary font-w700 flex-shrink-0" style="font-size: 13px; padding: 7px 14px; background: #2563eb; border-radius: 8px;">
                                        {{ $data['demografi']['anak'] }} Pasien
                                    </span>
                                </div>

                                <!-- Dewasa -->
                                <div class="d-flex align-items-center justify-content-between transition-all" style="padding: 15px 18px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 d-flex align-items-center justify-content-center text-secondary" style="width: 40px; height: 40px; border-radius: 10px; background: #e2e8f0; font-size: 17px; flex-shrink: 0;">
                                            <i class="fa-solid fa-person"></i>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block font-w700" style="font-size: 13.5px; line-height: 1.3;">Dewasa</strong>
                                            <small class="text-muted font-w600" style="font-size: 11.5px;">18 - 59 Tahun</small>
                                        </div>
                                    </div>
                                    <span class="badge badge-secondary font-w700 flex-shrink-0" style="font-size: 13px; padding: 7px 14px; background: #475569; border-radius: 8px;">
                                        {{ $data['demografi']['dewasa'] }} Pasien
                                    </span>
                                </div>

                                <!-- Lansia -->
                                <div class="d-flex align-items-center justify-content-between transition-all" style="padding: 15px 18px; background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; box-shadow: 0 1px 3px rgba(217, 119, 6, 0.05);">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 d-flex align-items-center justify-content-center text-warning" style="width: 40px; height: 40px; border-radius: 10px; background: #fef3c7; font-size: 17px; flex-shrink: 0; color: #d97706 !important;">
                                            <i class="fa-solid fa-person-cane"></i>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block font-w700" style="font-size: 13.5px; line-height: 1.3;">Lansia (Geriatri)</strong>
                                            <small class="text-muted font-w600" style="font-size: 11.5px;">&ge; 60 Tahun</small>
                                        </div>
                                    </div>
                                    <span class="badge badge-warning font-w700 flex-shrink-0" style="font-size: 13px; padding: 7px 14px; background: #d97706; color: #ffffff; border-radius: 8px;">
                                        {{ $data['demografi']['lansia'] }} Pasien
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Gender Ratio -->
                        <div class="col-lg-5 col-md-12">
                            <div class="rounded h-100 d-flex flex-column justify-content-between text-center" style="padding: 20px 18px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; min-height: 195px;">
                                <div>
                                    <small class="text-muted font-w700 d-block mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <i class="fa-solid fa-venus-mars mr-1 text-primary"></i> Rasio Gender
                                    </small>
                                </div>
                                <div class="d-flex justify-content-around align-items-center my-auto py-2">
                                    <div class="px-2">
                                        <div class="font-w800 text-primary" style="font-size: 26px; line-height: 1.2;">{{ $data['demografi']['laki'] }}</div>
                                        <small class="text-muted font-w600 d-block mt-1" style="font-size: 12px;"><i class="fa-solid fa-mars mr-1 text-primary"></i> Laki-laki</small>
                                    </div>
                                    <div style="height: 48px; width: 1.5px; background: #cbd5e1;"></div>
                                    <div class="px-2">
                                        <div class="font-w800 text-danger" style="font-size: 26px; line-height: 1.2;">{{ $data['demografi']['perempuan'] }}</div>
                                        <small class="text-muted font-w600 d-block mt-1" style="font-size: 12px;"><i class="fa-solid fa-venus mr-1 text-danger"></i> Perempuan</small>
                                    </div>
                                </div>
                                <div class="pt-2 border-top" style="border-color: #e2e8f0 !important;">
                                    <small class="text-muted font-w500" style="font-size: 11.5px;">
                                        Total: <strong class="text-dark">{{ $data['demografi']['laki'] + $data['demografi']['perempuan'] }}</strong> Pasien
                                    </small>
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

@endsection

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let mapJatim = null;
    const patientPoints = @json($data['map_patient_points'] ?? []);
    const balaiPoints = @json($data['map_balai_points'] ?? []);

    function initMapJatim() {
        if (mapJatim !== null) {
            mapJatim.invalidateSize();
            return;
        }

        const mapEl = document.getElementById('mapJatim');
        if (!mapEl) return;

        // Inisialisasi Peta Jawa Timur
        mapJatim = L.map('mapJatim', {
            center: [-7.70, 112.65],
            zoom: 8,
            scrollWheelZoom: false,
            attributionControl: false
        });

        // Tile layer CartoDB Voyager / OpenStreetMap (Sangat bersih dan elegan untuk executive dashboard)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 18,
            subdomains: 'abcd',
        }).addTo(mapJatim);

        // Custom Red Icon untuk Balai UPT
        const balaiIcon = L.divIcon({
            className: 'custom-balai-icon-wrapper',
            html: `
                <div style="position: relative; width: 28px; height: 28px;">
                    <div class="custom-pulse-ring" style="width: 28px; height: 28px; top: 0; left: 0;"></div>
                    <div class="custom-balai-marker" style="width: 28px; height: 28px; position: relative; z-index: 2;">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                </div>
            `,
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });

        // Tambahkan Titik Balai Omah Terapi-KU
        balaiPoints.forEach(function(b) {
            const marker = L.marker([b.lat, b.lng], { icon: balaiIcon }).addTo(mapJatim);
            marker.bindPopup(`
                <div style="font-size: 12px; min-width: 190px;">
                    <span class="badge badge-danger text-white mb-1" style="font-size: 10px; padding: 3px 6px;">${b.badge}</span>
                    <strong style="color: #1e40af; display: block; font-size: 13px; font-weight: 700;">${b.nama}</strong>
                    <div style="color: #475569; font-size: 11px; margin-top: 3px;"><i class="fa-solid fa-location-dot text-danger mr-1"></i>${b.alamat}</div>
                    <div style="color: #059669; font-size: 11px; font-weight: 600; margin-top: 4px;"><i class="fa-solid fa-check-circle mr-1"></i>Fokus: ${b.fokus}</div>
                </div>
            `);
        });

        // Tambahkan Circle Bubble untuk Titik Pasien Asal Kab/Kota
        patientPoints.forEach(function(p) {
            const radius = Math.max(12, Math.min(32, p.total * 5));
            const circle = L.circleMarker([p.lat, p.lng], {
                radius: radius,
                fillColor: '#2563eb',
                fillOpacity: 0.65,
                color: '#1d4ed8',
                weight: 2
            }).addTo(mapJatim);

            circle.bindTooltip(`<strong>${p.nama}</strong>: ${p.total} Pasien (${p.percentage}%)`, {
                direction: 'top',
                offset: [0, -8]
            });

            circle.bindPopup(`
                <div style="font-size: 12px; min-width: 170px;">
                    <span class="badge badge-primary text-white mb-1" style="font-size: 10px; padding: 3px 6px; background: #2563eb;">Domisili Penerima Manfaat</span>
                    <strong style="color: #0f172a; display: block; font-size: 13px; font-weight: 700;">${p.nama}</strong>
                    <div style="margin-top: 4px; font-size: 12px;">
                        Total Penerima: <strong style="color: #2563eb; font-size: 13px;">${p.total} Pasien</strong>
                    </div>
                    <div style="color: #64748b; font-size: 11px;">Proporsi: <strong>${p.percentage}%</strong> dari seluruh pasien</div>
                </div>
            `);
        });
    }

    function switchGeoView(type) {
        if (type === 'map') {
            $('#geoMapView').show();
            $('#geoListView').hide();
            $('#btnToggleMap').removeClass('btn-light').addClass('btn-primary');
            $('#btnToggleList').removeClass('btn-primary').addClass('btn-light');
            setTimeout(function() {
                if (mapJatim) mapJatim.invalidateSize();
            }, 100);
        } else {
            $('#geoMapView').hide();
            $('#geoListView').show();
            $('#btnToggleList').removeClass('btn-light').addClass('btn-primary');
            $('#btnToggleMap').removeClass('btn-primary').addClass('btn-light');
        }
    }

    $(document).ready(function() {
        initMapJatim();
    });

    function togglePeriodeInput(tipe) {
        $('.filter-input-group').hide();
        if (tipe === 'bulanan') {
            $('#inputBulan').show();
            $('#inputTahun').show();
        } else if (tipe === 'triwulan') {
            $('#inputTriwulan').show();
            $('#inputTahun').show();
        } else if (tipe === 'semester') {
            $('#inputSemester').show();
            $('#inputTahun').show();
        } else if (tipe === 'tahunan') {
            $('#inputTahun').show();
        } else if (tipe === 'custom') {
            $('#inputCustom').show();
        }
    }
</script>
@endsection

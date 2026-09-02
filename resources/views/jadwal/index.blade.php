@extends('layout.apps')

@section('style')
<link href="{{ asset('vendor/fullcalendar/css/fullcalendar.min.css') }}" rel="stylesheet">
<style>
    /* Styling Custom Kalender & Timeline Jadwal */
    .fc-event {
        cursor: pointer;
        padding: 4px 6px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        border: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .fc-toolbar h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--ot-navy);
        text-transform: capitalize;
    }
    .fc-button-primary {
        background-color: var(--ot-navy) !important;
        border-color: var(--ot-navy) !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 12.5px !important;
        text-transform: capitalize !important;
    }
    .fc-button-primary:hover, .fc-button-primary:focus {
        background-color: #1e355b !important;
        border-color: #1e355b !important;
    }
    .fc-day-header {
        padding: 10px 0 !important;
        font-weight: 700;
        font-size: 12.5px;
        background-color: #f8fafc;
        color: #334155;
    }
    .fc-day-today {
        background-color: #f0f7ff !important;
    }

    /* Slot Timeline Styles */
    .slot-session-card {
        border-radius: 10px;
        border: 1px solid #edf2f7;
        background: #ffffff;
        transition: all 0.2s ease-in-out;
    }
    .slot-session-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(45, 75, 122, 0.08);
    }
    .patient-session-item {
        border-radius: 8px;
        border-left: 4px solid var(--ot-navy);
        background: #f8fafc;
        transition: transform 0.15s ease;
    }
    .patient-session-item:hover {
        background: #f1f5f9;
        transform: translateX(2px);
    }
</style>
@endsection

@section('content')

<!-- Header Section -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap: 12px;">
    <div>
        <h2 class="font-w700 text-primary mb-1" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">
            <i class="fa-solid fa-calendar-days text-primary mr-2"></i> Jadwal & Kalender Terapi
        </h2>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 2px; font-size: 12.5px;">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Pelayanan</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Jadwal Terapi</a></li>
        </ol>
    </div>
    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
        <button type="button" class="btn btn-sm btn-light" onclick="window.print()" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
            <i class="fa-solid fa-print mr-1"></i> Cetak Jadwal
        </button>
        <a href="{{ Route('rekam.add') }}" class="btn btn-sm btn-primary shadow-sm font-w600" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px;">
            <i class="fa-solid fa-circle-plus mr-1"></i> + Input Sesi Terapi Baru
        </a>
    </div>
</div>

<!-- Filter & Quick Select Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-xs" style="border-radius: 12px; border: 1px solid #edf2f7;">
            <div class="card-body p-3 p-md-4">
                <form action="{{ Route('jadwal.index') }}" method="GET" id="filterForm">
                    <div class="row align-items-end">
                        
                        <!-- Filter Tanggal -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                <i class="fa-solid fa-calendar mr-1 text-primary"></i> Pilih Tanggal Periksa:
                            </label>
                            <input type="date" name="tanggal" id="inputTanggal" class="form-control" value="{{ $tanggal }}" style="height: 40px; font-size: 13px;" onchange="this.form.submit()">
                        </div>

                        <!-- Filter Omah Terapiku (UPT) -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                <i class="fa-solid fa-hospital mr-1 text-primary"></i> Omah Terapiku (UPT):
                            </label>
                            <select name="upt" class="form-control" style="height: 40px; font-size: 13px;" onchange="this.form.submit()">
                                <option value="all">Semua Omah Terapiku (UPT)</option>
                                @foreach($polis as $p)
                                    <option value="{{ $p->nama }}" {{ $uptFilter == $p->nama ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Layanan Terapi -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                <i class="fa-solid fa-stethoscope mr-1 text-primary"></i> Jenis Layanan:
                            </label>
                            <select name="layanan" class="form-control" style="height: 40px; font-size: 13px;" onchange="this.form.submit()">
                                <option value="all">Semua Layanan Terapi</option>
                                <option value="Fisioterapi" {{ $layananFilter == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                                <option value="Terapi Okupasi / Sensorik Integrasi" {{ $layananFilter == 'Terapi Okupasi / Sensorik Integrasi' ? 'selected' : '' }}>Terapi Okupasi / SI</option>
                                <option value="Terapi Wicara" {{ $layananFilter == 'Terapi Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                                <option value="Terapi Netra (Orientasi & Mobilitas)" {{ $layananFilter == 'Terapi Netra (Orientasi & Mobilitas)' ? 'selected' : '' }}>Terapi Netra (O&M)</option>
                            </select>
                        </div>

                        <!-- Filter Terapis -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                <i class="fa-solid fa-user-doctor mr-1 text-primary"></i> Terapis Pemeriksa:
                            </label>
                            <select name="dokter_id" class="form-control" style="height: 40px; font-size: 13px;" onchange="this.form.submit()">
                                <option value="all">Semua Terapis</option>
                                @foreach($dokters as $d)
                                    <option value="{{ $d->id }}" {{ $dokterFilter == $d->id ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- Quick Date Presets (Rabu Rutin & Hari Ini) -->
                    <div class="d-flex align-items-center flex-wrap pt-2 mt-1" style="border-top: 1px dashed #e2e8f0; gap: 8px;">
                        <span class="text-muted font-w600 mr-2" style="font-size: 12px;">
                            <i class="fa-solid fa-bolt text-warning mr-1"></i> Quick Jump:
                        </span>
                        
                        <a href="{{ Route('jadwal.index', array_merge(request()->except('tanggal'), ['tanggal' => date('Y-m-d')])) }}" 
                           class="btn btn-xs {{ $tanggal == date('Y-m-d') ? 'btn-primary' : 'btn-outline-primary' }}" style="border-radius: 20px; padding: 4px 12px; font-size: 11.5px; font-weight: 600;">
                            Hari Ini ({{ date('d M') }})
                        </a>

                        @foreach($rabuDates as $index => $rDate)
                            @php $rStr = $rDate->format('Y-m-d'); @endphp
                            <a href="{{ Route('jadwal.index', array_merge(request()->except('tanggal'), ['tanggal' => $rStr])) }}" 
                               class="btn btn-xs {{ $tanggal == $rStr ? 'btn-info text-white' : 'btn-outline-info' }}" style="border-radius: 20px; padding: 4px 12px; font-size: 11.5px; font-weight: 600;">
                                <i class="fa-solid fa-calendar-check mr-1"></i> 
                                {{ $index == 0 ? 'Rabu Terdekat' : 'Rabu (+'.($index).' Mgg)' }} ({{ $rDate->format('d M') }})
                            </a>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row for Selected Date -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 col-12 mb-3">
        <div class="card mb-0 shadow-xs" style="border-radius: 10px; border-left: 4px solid #2D4B7A;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w600 d-block" style="font-size: 11.5px;">TOTAL SESI TERJADWAL</small>
                    <h3 class="font-w800 mb-0" style="color: #2D4B7A; font-size: 22px;">{{ $stats['total'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</small>
                </div>
                <div class="avatar-sm d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: #edf4ff; color: #2D4B7A; font-size: 18px;">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-3">
        <div class="card mb-0 shadow-xs" style="border-radius: 10px; border-left: 4px solid #f59e0b;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w600 d-block" style="font-size: 11.5px;">MENUNGGU / ANTREAN</small>
                    <h3 class="font-w800 mb-0" style="color: #f59e0b; font-size: 22px;">{{ $stats['antrian'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">Belum dipanggil</small>
                </div>
                <div class="avatar-sm d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: #fff8e6; color: #f59e0b; font-size: 18px;">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-3">
        <div class="card mb-0 shadow-xs" style="border-radius: 10px; border-left: 4px solid #0284c7;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w600 d-block" style="font-size: 11.5px;">SEDANG PEMERIKSAAN</small>
                    <h3 class="font-w800 mb-0" style="color: #0284c7; font-size: 22px;">{{ $stats['pemeriksaan'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">Dalam proses terapi</small>
                </div>
                <div class="avatar-sm d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: #e0f2fe; color: #0284c7; font-size: 18px;">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-3">
        <div class="card mb-0 shadow-xs" style="border-radius: 10px; border-left: 4px solid #10b981;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w600 d-block" style="font-size: 11.5px;">SELESAI DITANGANI</small>
                    <h3 class="font-w800 mb-0" style="color: #10b981; font-size: 22px;">{{ $stats['selesai'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">Sesi tuntas</small>
                </div>
                <div class="avatar-sm d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #10b981; font-size: 18px;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Dual-View Card (Tab 1: Timeline Sesi Jam & Tab 2: Kalender Interaktif) -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            
            <div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap" style="padding: 16px 20px; gap: 12px;">
                <ul class="nav nav-pills" id="pills-tab-jadwal" role="tablist" style="gap: 8px;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active font-w700" id="tab-timeline-link" data-toggle="pill" href="#tab-timeline" role="tab" aria-controls="tab-timeline" aria-selected="true" style="border-radius: 8px; font-size: 13px; padding: 8px 18px;">
                            <i class="fa-solid fa-timeline mr-2"></i> 1. Timeline Slot Jam ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }})
                            <span class="badge badge-light text-primary ml-1" style="font-size: 11px;">{{ $stats['total'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link font-w700" id="tab-kalender-link" data-toggle="pill" href="#tab-kalender" role="tab" aria-controls="tab-kalender" aria-selected="false" style="border-radius: 8px; font-size: 13px; padding: 8px 18px;">
                            <i class="fa-solid fa-calendar-days mr-2"></i> 2. Kalender Visual Bulanan
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <span class="badge badge-light border text-dark font-w600" style="font-size: 12px; padding: 6px 12px;">
                        <i class="fa-solid fa-calendar-day mr-1 text-primary"></i>
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="pills-tabContent-jadwal">
                    
                    <!-- ============================================================= -->
                    <!-- TAB 1: AGENDA TIMELINE SLOT SESI (08.00 - 13.00) -->
                    <!-- ============================================================= -->
                    <div class="tab-pane fade show active" id="tab-timeline" role="tabpanel" aria-labelledby="tab-timeline-link">
                        
                        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4 p-3" style="border-radius: 8px; font-size: 12.5px; background-color: #f8fafc;">
                            <div>
                                <i class="fa-solid fa-circle-info text-primary mr-2"></i>
                                Menampilkan pemetaan penerima manfaat per slot waktu pada <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong>.
                                Setiap sesi berdurasi 30 - 45 menit.
                            </div>
                            <span class="text-muted font-w600">Total: {{ $stats['total'] }} Pasien</span>
                        </div>

                        <div class="row">
                            @foreach($masterSlots as $slotName => $meta)
                                @php
                                    $pasienDiSlot = $jadwalPerSlot[$slotName] ?? [];
                                    $hasPasien = count($pasienDiSlot) > 0;
                                @endphp

                                <div class="col-xl-6 col-12 mb-4">
                                    <div class="slot-session-card h-100 p-3" style="{{ $hasPasien ? 'border-top: 3px solid var(--ot-navy); background: #ffffff;' : 'background: #fbfcfe;' }}">
                                        
                                        <!-- Header Slot Sesi -->
                                        <div class="d-flex justify-content-between align-items-center pb-2 mb-3" style="border-bottom: 1px solid #edf2f7;">
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ $meta['badge'] }} font-w700 mr-2 py-1 px-2" style="font-size: 12px; border-radius: 6px;">
                                                    <i class="fa-solid {{ $meta['icon'] }} mr-1"></i> {{ explode(' (', $slotName)[0] }}
                                                </span>
                                                <strong class="text-dark" style="font-size: 13.5px;">{{ $meta['jam'] }}</strong>
                                            </div>
                                            <span class="badge {{ $hasPasien ? 'badge-primary' : 'badge-light text-muted' }} font-w600" style="font-size: 11.5px;">
                                                {{ count($pasienDiSlot) }} Penerima Manfaat
                                            </span>
                                        </div>

                                        <!-- Pasien List di Slot Ini -->
                                        @if($hasPasien)
                                            <div class="d-flex flex-column" style="gap: 10px;">
                                                @foreach($pasienDiSlot as $pRecord)
                                                    @php
                                                        $p = $pRecord->pasien;
                                                        $layanan = $pRecord->layanan_terapi ?: 'Fisioterapi';
                                                        
                                                        // Color badge border
                                                        $borderClr = '#2D4B7A';
                                                        $layananBadge = 'badge-primary';
                                                        if (str_contains($layanan, 'Okupasi')) {
                                                            $borderClr = '#059669';
                                                            $layananBadge = 'badge-success';
                                                        } elseif (str_contains($layanan, 'Wicara')) {
                                                            $borderClr = '#d97706';
                                                            $layananBadge = 'badge-warning';
                                                        } elseif (str_contains($layanan, 'Netra')) {
                                                            $borderClr = '#7c3aed';
                                                            $layananBadge = 'badge-info';
                                                        }
                                                    @endphp

                                                    <div class="patient-session-item p-3 shadow-xs" style="border-left-color: {{ $borderClr }}; border-radius: 8px;">
                                                        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 8px;">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm mr-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 50%; background: {{ $borderClr }}; color: #fff; font-weight: 700; font-size: 15px; flex-shrink: 0;">
                                                                    {{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <a href="{{ Route('rekam.detail', $pRecord->pasien_id) }}" class="font-w700 text-dark hover-primary mb-0 d-block" style="font-size: 14px;">
                                                                        {{ $p->nama ?? 'Pasien Tidak Ditemukan' }}
                                                                    </a>
                                                                    <div class="d-flex align-items-center flex-wrap" style="gap: 6px; font-size: 11.5px;">
                                                                        <span class="badge badge-light border text-primary font-w600" style="font-size: 10.5px;">RM# {{ $p->no_rm ?? '-' }}</span>
                                                                        <span class="badge {{ $layananBadge }} font-w600" style="font-size: 10.5px;">{{ $layanan }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="text-right">
                                                                {!! $pRecord->status_display() !!}
                                                            </div>
                                                        </div>

                                                        <div class="row mt-2 pt-2" style="border-top: 1px dashed #cbd5e1; font-size: 12px;">
                                                            <div class="col-sm-6 mb-1">
                                                                <span class="text-muted"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Terapis:</span>
                                                                <strong class="text-dark">{{ $pRecord->dokter->nama ?? '-' }}</strong>
                                                            </div>
                                                            <div class="col-sm-6 mb-1">
                                                                <span class="text-muted"><i class="fa-solid fa-hospital text-success mr-1"></i> UPT:</span>
                                                                <span class="text-dark font-w500">{{ $pRecord->upt_lokasi ?: ($pRecord->poli ?: 'Omah Terapiku') }}</span>
                                                            </div>
                                                            @if($pRecord->keluhan)
                                                                <div class="col-12 mt-1">
                                                                    <span class="text-muted"><i class="fa-solid fa-comment-dots text-warning mr-1"></i> Keluhan:</span>
                                                                    <span class="text-dark font-italic">{{ Str::limit($pRecord->keluhan, 70) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        <div class="d-flex justify-content-end align-items-center mt-2 pt-2" style="border-top: 1px solid #edf2f7; gap: 6px;">
                                                            @if($pRecord->assessment)
                                                                <a href="{{ Route('rekam.assessment.show', $pRecord->id) }}" class="btn btn-xs btn-outline-info font-w600" style="font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                                                                    <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                                                                </a>
                                                            @endif
                                                            <a href="{{ Route('rekam.detail', $pRecord->pasien_id) }}" class="btn btn-xs btn-primary font-w600" style="font-size: 11px; padding: 3px 10px; border-radius: 4px;">
                                                                <i class="fa-solid fa-folder-open mr-1"></i> Detail Sesi & SOAP
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4 text-muted" style="border: 1px dashed #e2e8f0; border-radius: 8px; background: #fafbfc;">
                                                <i class="fa-solid fa-calendar-xmark text-muted mb-1" style="font-size: 20px; opacity: 0.5;"></i>
                                                <p class="mb-0" style="font-size: 12px;">Slot waktu kosong &bull; Belum ada penerima manfaat</p>
                                                <a href="{{ Route('rekam.add') }}" class="btn btn-xs btn-link text-primary font-w600 mt-1" style="font-size: 11.5px;">
                                                    + Jadwalkan di Slot Ini
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <!-- ============================================================= -->
                    <!-- TAB 2: KALENDER INTERAKTIF (FULLCALENDAR) -->
                    <!-- ============================================================= -->
                    <div class="tab-pane fade" id="tab-kalender" role="tabpanel" aria-labelledby="tab-kalender-link">
                        
                        <!-- Legend Layanan Terapi -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap p-3 mb-4 rounded" style="background: #f8fafc; border: 1px solid #edf2f7; gap: 10px;">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 15px; font-size: 12px; font-weight: 600;">
                                <span class="text-muted">Kategori Layanan:</span>
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #2D4B7A; display: inline-block; margin-right: 6px;"></span> Fisioterapi</span>
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #059669; display: inline-block; margin-right: 6px;"></span> Terapi Okupasi / SI</span>
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #d97706; display: inline-block; margin-right: 6px;"></span> Terapi Wicara</span>
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #7c3aed; display: inline-block; margin-right: 6px;"></span> Terapi Netra (O&M)</span>
                            </div>
                            <small class="text-muted"><i class="fa-solid fa-hand-pointer mr-1"></i> Klik pada event untuk melihat rincian sesi</small>
                        </div>

                        <!-- Calendar Container -->
                        <div id="calendar" class="app-fullcalendar"></div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL DETAIL EVENT JADWAL DARI KALENDER -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalDetailJadwalSesi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #2D4B7A 0%, #1e355b 100%); padding: 14px 20px;">
                <div>
                    <h5 class="modal-title font-w700 text-white mb-0" id="mJadwalNama" style="font-size: 16px;">Detail Sesi Terapi</h5>
                    <small class="text-white-50" id="mJadwalNoRm">No. RM: -</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.85;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #f8fafc;">
                
                <div class="row mb-3">
                    <div class="col-6 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Tanggal Periksa</small>
                            <span class="font-w700 text-dark" id="mJadwalTanggal" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Slot Jadwal Sesi</small>
                            <span class="font-w700 text-primary" id="mJadwalSesi" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Layanan Terapi</small>
                            <span class="font-w700 text-dark" id="mJadwalLayanan" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Omah Terapiku (UPT)</small>
                            <span class="font-w700 text-dark" id="mJadwalUpt" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Terapis Pemeriksa</small>
                            <span class="font-w700 text-dark" id="mJadwalTerapis" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-xs" style="border-radius: 8px;">
                    <div class="card-header py-2 px-3 border-bottom bg-light">
                        <strong class="text-dark" style="font-size: 12.5px;"><i class="fa-solid fa-comment-dots text-warning mr-1"></i> Anamnesa / Keluhan Awal</strong>
                    </div>
                    <div class="card-body p-3">
                        <div id="mJadwalKeluhan" style="font-size: 13px; line-height: 1.5; color: #1e293b;">-</div>
                    </div>
                </div>

            </div>

            <div class="modal-footer py-2 px-3 bg-light d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-sm btn-secondary font-w600" data-dismiss="modal" style="font-size: 12px; border-radius: 6px;">
                    Tutup
                </button>
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <a href="#" id="mJadwalAsesmenBtn" class="btn btn-sm btn-outline-info font-w600" style="font-size: 12px; border-radius: 6px;">
                        <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                    </a>
                    <a href="#" id="mJadwalDetailBtn" class="btn btn-sm btn-primary font-w600" style="font-size: 12px; border-radius: 6px;">
                        <i class="fa-solid fa-folder-open mr-1"></i> Buka Rekam Medis
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar/js/fullcalendar.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');
        var calendarInitialized = false;

        function initCalendar() {
            if (calendarInitialized) return;

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                editable: false,
                eventLimit: true,
                events: function(start, end, timezone, callback) {
                    var filterData = {
                        start: start.format('YYYY-MM-DD'),
                        end: end.format('YYYY-MM-DD'),
                        upt: "{{ $uptFilter }}",
                        layanan: "{{ $layananFilter }}",
                        dokter_id: "{{ $dokterFilter }}"
                    };

                    $.ajax({
                        url: "{{ route('jadwal.events') }}",
                        type: 'GET',
                        data: filterData,
                        success: function(response) {
                            callback(response);
                        },
                        error: function() {
                            toastr.error('Gagal memuat event jadwal kalender');
                        }
                    });
                },
                eventClick: function(event) {
                    var props = event.extendedProps;
                    $("#mJadwalNama").text(props.pasien_nama);
                    $("#mJadwalNoRm").text("No. RM: " + props.no_rm + " | " + props.no_rekam);
                    $("#mJadwalTanggal").text(props.tgl_rekam);
                    $("#mJadwalSesi").text(props.sesi_waktu);
                    $("#mJadwalLayanan").text(props.layanan_terapi);
                    $("#mJadwalUpt").text(props.upt);
                    $("#mJadwalTerapis").text(props.terapis);
                    $("#mJadwalKeluhan").text(props.keluhan);

                    $("#mJadwalDetailBtn").attr('href', props.detail_url);
                    $("#mJadwalAsesmenBtn").attr('href', props.assessment_url);

                    $("#modalDetailJadwalSesi").modal('show');
                }
            });

            calendarInitialized = true;
        }

        // Initialize calendar when tab is shown
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            if (e.target.id === 'tab-kalender-link') {
                if (!calendarInitialized) {
                    initCalendar();
                } else {
                    $('#calendar').fullCalendar('render');
                }
            }
        });
    });
</script>
@endsection

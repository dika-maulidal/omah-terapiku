@extends('layout.apps')

@section('style')
<link href="{{ asset('vendor/fullcalendar/css/fullcalendar.min.css') }}" rel="stylesheet">
<style>
    /* Styling Custom Kalender & Timeline Jadwal */
    .fc-event {
        cursor: pointer;
        padding: 5px 8px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        border: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .fc-toolbar h2 {
        font-size: 17px;
        font-weight: 700;
        color: #1e40af;
        text-transform: capitalize;
    }
    .fc-button-primary, .fc button {
        background: #2563eb !important;
        border-color: #2563eb !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-transform: capitalize !important;
        color: #ffffff !important;
        box-shadow: none !important;
        text-shadow: none !important;
        padding: 5px 12px !important;
        height: auto !important;
    }
    .fc-button-primary:hover, .fc-button-primary:focus, .fc button:hover {
        background: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
    }
    .fc-state-active, .fc button.fc-state-active {
        background: #1e40af !important;
        border-color: #1e40af !important;
    }
    .fc-day-header {
        padding: 10px 0 !important;
        font-weight: 700;
        font-size: 12px;
        background-color: #f8fafc;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-color: #e2e8f0 !important;
    }
    .fc-day-today {
        background-color: #eff6ff !important;
    }

    /* Underline Tabs Navigation */
    .ot-underline-tabs {
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        gap: 24px;
        margin-bottom: 20px;
        padding-left: 0;
        list-style: none;
        flex-wrap: wrap;
    }
    .ot-underline-tabs .nav-item {
        margin-bottom: 0;
    }
    .ot-underline-tabs .nav-link {
        background: transparent !important;
        border: none !important;
        border-bottom: 2.5px solid transparent !important;
        margin-bottom: -2px;
        padding: 10px 4px 12px 4px;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
        border-radius: 0 !important;
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
        cursor: pointer;
    }
    .ot-underline-tabs .nav-link:hover {
        color: #1e40af;
    }
    .ot-underline-tabs .nav-link.active {
        color: #2563eb !important;
        font-weight: 700 !important;
        border-bottom: 2.5px solid #2563eb !important;
    }
    .ot-underline-tabs .nav-link i {
        font-size: 14px;
        color: #94a3b8;
        transition: color 0.2s ease;
    }
    .ot-underline-tabs .nav-link:hover i {
        color: #1e40af;
    }
    .ot-underline-tabs .nav-link.active i {
        color: #2563eb !important;
    }

    /* Slot Session Card Styles */
    .slot-session-card {
        border-radius: 12px;
        border: 1px solid #edf2f7;
        background: #ffffff;
        transition: all 0.2s ease;
    }
    .slot-session-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px rgba(46, 75, 130, 0.06);
    }
    .patient-session-item {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        border-left-width: 4px;
        background: #f8fafc;
        transition: all 0.15s ease;
    }
    .patient-session-item:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
</style>
@endsection

@section('content')

<!-- Header Section (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
            <div class="d-flex align-items-center">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Jadwal & Kalender Terapi</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Pelayanan</li>
                        <li class="breadcrumb-item active text-muted">Jadwal Terapi</li>
                    </ol>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <button type="button" class="btn btn-sm btn-light font-w600" onclick="window.print()" style="padding: 8px 14px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                    <i class="fa-solid fa-print mr-1"></i> Cetak Jadwal
                </button>
                <a href="{{ Route('rekam.add') }}" class="btn btn-sm btn-primary font-w700 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-circle-plus mr-1"></i> + Input Sesi Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Quick Select Section -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <form action="{{ Route('jadwal.index') }}" method="GET" id="filterForm">
            <div class="row align-items-end" style="row-gap: 12px;">
                
                <!-- Filter Tanggal -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                        <i class="fa-solid fa-calendar mr-1 text-primary"></i> Tanggal Periksa:
                    </label>
                    <input type="date" name="tanggal" id="inputTanggal" class="form-control" value="{{ $tanggal }}" style="height: 42px; font-size: 13px; border-radius: 8px;" onchange="this.form.submit()">
                </div>

                <!-- Filter Omah Terapiku (UPT) -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                        <i class="fa-solid fa-hospital-user mr-1 text-primary"></i> Penempatan UPT:
                    </label>
                    <select name="upt" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;" onchange="this.form.submit()">
                        <option value="all">Semua Omah Terapiku (UPT)</option>
                        @foreach($polis as $p)
                            <option value="{{ $p->nama }}" {{ $uptFilter == $p->nama ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Layanan Terapi -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                        <i class="fa-solid fa-stethoscope mr-1 text-primary"></i> Kategori Layanan:
                    </label>
                    <select name="layanan" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;" onchange="this.form.submit()">
                        <option value="all">Semua Layanan Terapi</option>
                        <option value="Fisioterapi" {{ $layananFilter == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                        <option value="Terapi Okupasi / Sensorik Integrasi" {{ $layananFilter == 'Terapi Okupasi / Sensorik Integrasi' ? 'selected' : '' }}>Terapi Okupasi / SI</option>
                        <option value="Terapi Wicara" {{ $layananFilter == 'Terapi Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                        <option value="Terapi Netra (Orientasi & Mobilitas)" {{ $layananFilter == 'Terapi Netra (Orientasi & Mobilitas)' ? 'selected' : '' }}>Terapi Netra (O&M)</option>
                    </select>
                </div>

                <!-- Filter Terapis -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                        <i class="fa-solid fa-user-doctor mr-1 text-primary"></i> Terapis Pemeriksa:
                    </label>
                    <select name="dokter_id" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;" onchange="this.form.submit()">
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
            <div class="d-flex align-items-center flex-wrap pt-3 mt-3" style="border-top: 1px dashed #e2e8f0; gap: 8px;">
                <span class="text-muted font-w600 mr-2" style="font-size: 12px;">
                    <i class="fa-solid fa-bolt text-warning mr-1"></i> Akses Cepat Tanggal:
                </span>
                
                <a href="{{ Route('jadwal.index', array_merge(request()->except('tanggal'), ['tanggal' => date('Y-m-d')])) }}" 
                   class="btn btn-xs {{ $tanggal == date('Y-m-d') ? 'btn-primary font-w700 text-white' : 'btn-light font-w600' }}" style="border-radius: 20px; padding: 5px 14px; font-size: 11.5px; border: 1px solid {{ $tanggal == date('Y-m-d') ? '#2563eb' : '#cbd5e1' }};">
                    Hari Ini ({{ date('d M') }})
                </a>

                @foreach($rabuDates as $index => $rDate)
                    @php $rStr = $rDate->format('Y-m-d'); @endphp
                    <a href="{{ Route('jadwal.index', array_merge(request()->except('tanggal'), ['tanggal' => $rStr])) }}" 
                       class="btn btn-xs {{ $tanggal == $rStr ? 'btn-primary font-w700 text-white' : 'btn-light font-w600' }}" style="border-radius: 20px; padding: 5px 14px; font-size: 11.5px; border: 1px solid {{ $tanggal == $rStr ? '#2563eb' : '#cbd5e1' }};">
                        <i class="fa-solid fa-calendar-check mr-1" style="{{ $tanggal == $rStr ? 'color:#fff;' : 'color:#2563eb;' }}"></i> 
                        {{ $index == 0 ? 'Rabu Terdekat' : 'Rabu (+'.($index).' Mgg)' }} ({{ $rDate->format('d M') }})
                    </a>
                @endforeach
            </div>
        </form>
    </div>
</div>

<!-- Stats Row for Selected Date (4 Clean Metric Cards) -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 col-12 mb-3 mb-xl-0">
        <div class="card mb-0 shadow-sm h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; border-left: 4px solid #1e40af; background: #ffffff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w700 d-block" style="font-size: 11px; letter-spacing: 0.3px;">TOTAL SESI TERJADWAL</small>
                    <h3 class="font-w800 mb-0" style="color: #1e40af; font-size: 22px;">{{ $stats['total'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</small>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #1e40af; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-3 mb-xl-0">
        <div class="card mb-0 shadow-sm h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; border-left: 4px solid #f59e0b; background: #ffffff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w700 d-block" style="font-size: 11px; letter-spacing: 0.3px;">MENUNGGU / ANTREAN</small>
                    <h3 class="font-w800 mb-0" style="color: #f59e0b; font-size: 22px;">{{ $stats['antrian'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">Belum dipanggil ke ruangan</small>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-3 mb-xl-0">
        <div class="card mb-0 shadow-sm h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; border-left: 4px solid #0284c7; background: #ffffff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w700 d-block" style="font-size: 11px; letter-spacing: 0.3px;">SEDANG TERAPI</small>
                    <h3 class="font-w800 mb-0" style="color: #0284c7; font-size: 22px;">{{ $stats['pemeriksaan'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">Dalam proses penanganan</small>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-3 mb-xl-0">
        <div class="card mb-0 shadow-sm h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; border-left: 4px solid #10b981; background: #ffffff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted font-w700 d-block" style="font-size: 11px; letter-spacing: 0.3px;">SELESAI DITANGANI</small>
                    <h3 class="font-w800 mb-0" style="color: #10b981; font-size: 22px;">{{ $stats['selesai'] }}</h3>
                    <small class="text-muted" style="font-size: 11px;">Sesi terapi tuntas</small>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Dual-View Card (Tab 1: Timeline Sesi Jam & Tab 2: Kalender Interaktif) -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                
                <!-- Underline Tabs Header -->
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 12px;">
                    <ul class="nav ot-underline-tabs mb-0" id="jadwalTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tab-timeline-link" data-toggle="tab" href="#tab-timeline" role="tab" aria-controls="tab-timeline" aria-selected="true">
                                <i class="fa-solid fa-timeline mr-2"></i> Timeline Sesi Waktu
                                <span class="badge font-w700 ml-2" style="font-size: 11px; padding: 3px 8px; border-radius: 12px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                    {{ $stats['total'] }} Sesi
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-kalender-link" data-toggle="tab" href="#tab-kalender" role="tab" aria-controls="tab-kalender" aria-selected="false">
                                <i class="fa-solid fa-calendar-days mr-2"></i> Kalender Visual Bulanan
                            </a>
                        </li>
                    </ul>

                    <div>
                        <span class="badge font-w600" style="font-size: 12px; padding: 6px 12px; border-radius: 8px; background: #f8fafc; color: #334155; border: 1px solid #cbd5e1;">
                            <i class="fa-solid fa-calendar-day mr-1 text-primary"></i>
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                </div>

                <div class="tab-content pt-4" id="jadwalTabsContent">
                    
                    <!-- ============================================================= -->
                    <!-- TAB 1: AGENDA TIMELINE SLOT SESI (08.00 - 13.00) -->
                    <!-- ============================================================= -->
                    <div class="tab-pane fade show active" id="tab-timeline" role="tabpanel" aria-labelledby="tab-timeline-link">
                        
                        <!-- Alert Informasi Ringkas -->
                        <div class="p-3 mb-4 d-flex justify-content-between align-items-center flex-wrap" style="background: #eff6ff; border-left: 4px solid #2563eb; border-radius: 8px; gap: 8px;">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-circle-info text-primary mr-2" style="font-size: 16px;"></i>
                                <span style="font-size: 12.5px; color: #1e3a8a;">
                                    Pemetaan penerima manfaat per slot waktu sesi terapi pada <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong> (Durasi 30 - 45 menit/sesi).
                                </span>
                            </div>
                            <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 10px; border-radius: 6px; background: #ffffff; color: #1e40af; border: 1px solid #bfdbfe;">
                                Total: {{ $stats['total'] }} Pasien
                            </span>
                        </div>

                        <div class="row">
                            @foreach($masterSlots as $slotName => $meta)
                                @php
                                    $pasienDiSlot = $jadwalPerSlot[$slotName] ?? [];
                                    $hasPasien = count($pasienDiSlot) > 0;
                                @endphp

                                <div class="col-xl-6 col-12 mb-4">
                                    <div class="slot-session-card h-100 p-3" style="{{ $hasPasien ? 'border-top: 3.5px solid #2563eb; background: #ffffff;' : 'background: #fafbfc;' }}">
                                        
                                        <!-- Header Slot Sesi -->
                                        <div class="d-flex justify-content-between align-items-center pb-2 mb-3" style="border-bottom: 1px solid #edf2f7;">
                                            <div class="d-flex align-items-center">
                                                <span class="badge font-w700 mr-2 py-1 px-2" style="font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                    <i class="fa-solid {{ $meta['icon'] }} mr-1"></i> {{ explode(' (', $slotName)[0] }}
                                                </span>
                                                <strong class="text-dark" style="font-size: 13.5px;">{{ $meta['jam'] }}</strong>
                                            </div>
                                            <span class="badge {{ $hasPasien ? 'font-w700' : 'font-w600 text-muted' }}" style="font-size: 11.5px; padding: 4px 10px; border-radius: 20px; {{ $hasPasien ? 'background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;' : 'background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;' }}">
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
                                                        $borderClr = '#2563eb';
                                                        $layananBadge = 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;';
                                                        if (str_contains($layanan, 'Okupasi')) {
                                                            $borderClr = '#d97706';
                                                            $layananBadge = 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;';
                                                        } elseif (str_contains($layanan, 'Wicara')) {
                                                            $borderClr = '#059669';
                                                            $layananBadge = 'background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;';
                                                        } elseif (str_contains($layanan, 'Netra')) {
                                                            $borderClr = '#7c3aed';
                                                            $layananBadge = 'background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;';
                                                        }
                                                    @endphp

                                                    <div class="patient-session-item p-3" style="border-left-color: {{ $borderClr }};">
                                                        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 8px;">
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; background: #eff6ff; color: {{ $borderClr }}; font-weight: 700; font-size: 14px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                                                                    {{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <a href="{{ Route('rekam.detail', $pRecord->pasien_id) }}" class="font-w700 text-dark mb-0 d-block" style="font-size: 13.5px; transition: color 0.15s ease;">
                                                                        {{ $p->nama ?? 'Pasien Tidak Ditemukan' }}
                                                                    </a>
                                                                    <div class="d-flex align-items-center flex-wrap mt-1" style="gap: 6px; font-size: 11px;">
                                                                        <span class="badge font-w600" style="font-size: 10.5px; padding: 2px 6px; border-radius: 4px; background: #f8fafc; color: #334155; border: 1px solid #cbd5e1;">
                                                                            RM# {{ $p->no_rm ?? '-' }}
                                                                        </span>
                                                                        <span class="badge font-w600" style="font-size: 10.5px; padding: 2px 8px; border-radius: 4px; {{ $layananBadge }}">
                                                                            {{ $layanan }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="text-right">
                                                                @if($pRecord->status == 1)
                                                                    <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">
                                                                        <i class="fa-solid fa-clock mr-1"></i> Antrean
                                                                    </span>
                                                                @elseif($pRecord->status == 2)
                                                                    <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                                                        <i class="fa-solid fa-stethoscope mr-1"></i> Sedang Terapi
                                                                    </span>
                                                                @else
                                                                    <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                                        <i class="fa-solid fa-circle-check mr-1"></i> Selesai
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row mt-2 pt-2" style="border-top: 1px dashed #cbd5e1; font-size: 12px;">
                                                            <div class="col-sm-6 mb-1">
                                                                <span class="text-muted"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Terapis:</span>
                                                                <strong class="text-dark">{{ $pRecord->dokter->nama ?? '-' }}</strong>
                                                            </div>
                                                            <div class="col-sm-6 mb-1">
                                                                <span class="text-muted"><i class="fa-solid fa-hospital-user text-primary mr-1"></i> UPT:</span>
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
                                                                <a href="{{ Route('rekam.assessment.show', $pRecord->id) }}" class="btn btn-xs font-w600" style="font-size: 11px; padding: 4px 9px; border-radius: 6px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                                                                    <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                                                                </a>
                                                            @endif
                                                            <a href="{{ Route('rekam.detail', $pRecord->pasien_id) }}" class="btn btn-xs font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                                                                <i class="fa-solid fa-folder-open mr-1"></i> Detail Sesi
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4 text-muted" style="border: 1px dashed #cbd5e1; border-radius: 8px; background: #ffffff;">
                                                <i class="fa-solid fa-calendar-xmark text-muted mb-1" style="font-size: 20px; opacity: 0.4;"></i>
                                                <p class="mb-0 text-muted" style="font-size: 12px;">Slot waktu kosong &bull; Belum ada penerima manfaat</p>
                                                <a href="{{ Route('rekam.add') }}" class="btn btn-xs btn-link text-primary font-w700 mt-1" style="font-size: 11.5px; text-decoration: none;">
                                                    <i class="fa-solid fa-plus mr-1"></i> Jadwalkan di Slot Ini
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
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #2563eb; display: inline-block; margin-right: 6px;"></span> Fisioterapi</span>
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #d97706; display: inline-block; margin-right: 6px;"></span> Terapi Okupasi / SI</span>
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #059669; display: inline-block; margin-right: 6px;"></span> Terapi Wicara</span>
                                <span class="d-flex align-items-center"><span style="width: 12px; height: 12px; border-radius: 3px; background: #7c3aed; display: inline-block; margin-right: 6px;"></span> Terapi Netra (O&M)</span>
                            </div>
                            <small class="text-muted"><i class="fa-solid fa-hand-pointer mr-1 text-primary"></i> Klik pada event untuk melihat rincian sesi</small>
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
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); padding: 16px 20px;">
                <div>
                    <h5 class="modal-title font-w700 text-white mb-0" id="mJadwalNama" style="font-size: 16px;">Detail Sesi Terapi</h5>
                    <small class="text-white-50" id="mJadwalNoRm">No. RM: -</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #ffffff;">
                
                <div class="row mb-3" style="row-gap: 8px;">
                    <div class="col-6">
                        <div class="p-2 px-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;"><i class="fa-solid fa-calendar mr-1 text-primary"></i> Tanggal Periksa</small>
                            <span class="font-w700 text-dark" id="mJadwalTanggal" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 px-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;"><i class="fa-solid fa-clock mr-1 text-primary"></i> Slot Sesi</small>
                            <span class="font-w700 text-primary" id="mJadwalSesi" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 px-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;"><i class="fa-solid fa-tag mr-1 text-primary"></i> Layanan Terapi</small>
                            <span class="font-w700 text-dark" id="mJadwalLayanan" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 px-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;"><i class="fa-solid fa-hospital-user mr-1 text-primary"></i> UPT Lokasi</small>
                            <span class="font-w700 text-dark" id="mJadwalUpt" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-2 px-3 rounded" style="background: #f8fafc; border: 1px solid #edf2f7;">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;"><i class="fa-solid fa-user-doctor mr-1 text-primary"></i> Terapis Pemeriksa</small>
                            <span class="font-w700 text-dark" id="mJadwalTerapis" style="font-size: 13px;">-</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-0 border-0" style="border-radius: 8px; background: #f8fafc; border: 1px solid #edf2f7 !important;">
                    <div class="card-header py-2 px-3 border-bottom" style="background: transparent;">
                        <strong class="text-dark" style="font-size: 12.5px;"><i class="fa-solid fa-comment-dots text-warning mr-1"></i> Anamnesa / Keluhan Awal</strong>
                    </div>
                    <div class="card-body p-3">
                        <div id="mJadwalKeluhan" style="font-size: 13px; line-height: 1.5; color: #1e293b;">-</div>
                    </div>
                </div>

            </div>

            <div class="modal-footer py-3 px-4 bg-light d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; padding: 7px 16px;">
                    Tutup
                </button>
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <a href="#" id="mJadwalAsesmenBtn" class="btn btn-sm font-w600" style="font-size: 12.5px; padding: 7px 14px; border-radius: 8px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                        <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                    </a>
                    <a href="#" id="mJadwalDetailBtn" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; font-size: 12.5px; padding: 7px 16px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
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
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
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

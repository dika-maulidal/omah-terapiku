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
    .fc .fc-button-group {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
    }
    .fc .fc-button-group > * {
        float: none !important;
        margin: 0 !important;
    }
    .fc-button-primary, .fc button, .fc .fc-button {
        background: #2563eb !important;
        border-color: #2563eb !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-transform: capitalize !important;
        color: #ffffff !important;
        box-shadow: none !important;
        text-shadow: none !important;
        padding: 6px 14px !important;
        height: auto !important;
        margin: 0 4px !important;
        display: inline-block !important;
        float: none !important;
        transition: all 0.15s ease !important;
    }
    .fc-button-primary:hover, .fc-button-primary:focus, .fc button:hover {
        background: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
        color: #ffffff !important;
    }
    .fc-state-active, .fc button.fc-state-active {
        background: #1e40af !important;
        border-color: #1e40af !important;
        color: #ffffff !important;
    }
    .fc-state-disabled, .fc button.fc-state-disabled {
        opacity: 0.65 !important;
        cursor: not-allowed !important;
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
                <a href="{{ $inputSesiUrl }}" id="btnInputSesiBaru" class="btn btn-sm btn-primary font-w700 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-circle-plus mr-1"></i> Input Sesi Baru
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
                    <input type="date" name="tanggal" id="inputTanggal" class="form-control filter-control" value="{{ $tanggal }}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                </div>

                <!-- Filter Omah Terapiku (UPT) -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                        <i class="fa-solid fa-hospital-user mr-1 text-primary"></i> Penempatan UPT:
                    </label>
                    <select name="upt" id="selectUpt" class="form-control filter-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
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
                    <select name="layanan" id="selectLayanan" class="form-control filter-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                        <option value="all">Semua Layanan Terapi</option>
                        <option value="Fisioterapi" {{ $layananFilter == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                        <option value="Terapi Okupasi / Sensorik Integrasi" {{ $layananFilter == 'Terapi Okupasi / Sensorik Integrasi' ? 'selected' : '' }}>Terapi Okupasi / SI</option>
                        <option value="Terapi Wicara" {{ $layananFilter == 'Terapi Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                        <option value="Terapi Netra (Orientasi & Mobilitas)" {{ $layananFilter == 'Terapi Netra (Orientasi & Mobilitas)' ? 'selected' : '' }}>Terapi Netra (O&M)</option>
                    </select>
                </div>

                <!-- Filter Terapis + Reset Button Inline -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                        <i class="fa-solid fa-user-doctor mr-1 text-primary"></i> Terapis Pemeriksa:
                    </label>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <select name="dokter_id" id="selectDokter" class="form-control filter-control flex-grow-1" style="height: 42px; font-size: 13px; border-radius: 8px;">
                            <option value="all">Semua Terapis</option>
                            @foreach($dokters as $d)
                                <option value="{{ $d->id }}" {{ $dokterFilter == $d->id ? 'selected' : '' }}>
                                    {{ $d->nama }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Tombol Reset Filter (Icon-Only 38x38px) -->
                        <div id="resetButtonWrapper" style="{{ $hasFilters ? '' : 'display: none;' }}">
                            <button type="button" id="btnResetFilter" class="btn btn-sm btn-light" style="width: 42px; height: 42px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #cbd5e1; border-radius: 8px; color: #64748b; font-size: 13px; transition: all 0.2s ease; flex-shrink: 0;" title="Reset Filter">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Quick Date Presets (Rabu Rutin & Hari Ini) -->
            <div class="d-flex align-items-center flex-wrap pt-3 mt-3" id="quickDatePresets" style="border-top: 1px dashed #e2e8f0; gap: 8px;">
                <span class="text-muted font-w600 mr-2" style="font-size: 12px;">
                    <i class="fa-solid fa-calendar-days text-primary mr-1"></i> Akses Cepat Tanggal:
                </span>
                
                <button type="button" 
                   data-tanggal="{{ date('Y-m-d') }}"
                   class="quick-date-btn btn btn-xs {{ $tanggal == date('Y-m-d') ? 'btn-primary font-w700 text-white active' : 'btn-light font-w600' }}" 
                   style="border-radius: 20px; padding: 5px 14px; font-size: 11.5px; border: 1px solid {{ $tanggal == date('Y-m-d') ? '#2563eb' : '#cbd5e1' }}; transition: all 0.15s ease;">
                    <i class="fa-solid fa-calendar-day mr-1" style="{{ $tanggal == date('Y-m-d') ? 'color:#fff;' : 'color:#2563eb;' }}"></i> Hari Ini ({{ date('d M') }})
                </button>

                @foreach($rabuDates as $index => $rDate)
                    @php $rStr = $rDate->format('Y-m-d'); @endphp
                    <button type="button" 
                       data-tanggal="{{ $rStr }}"
                       class="quick-date-btn btn btn-xs {{ $tanggal == $rStr ? 'btn-primary font-w700 text-white active' : 'btn-light font-w600' }}" 
                       style="border-radius: 20px; padding: 5px 14px; font-size: 11.5px; border: 1px solid {{ $tanggal == $rStr ? '#2563eb' : '#cbd5e1' }}; transition: all 0.15s ease;">
                        <i class="fa-solid fa-calendar-check mr-1" style="{{ $tanggal == $rStr ? 'color:#fff;' : 'color:#2563eb;' }}"></i> 
                        {{ $index == 0 ? 'Rabu Terdekat' : 'Rabu (+'.($index).' Mgg)' }} ({{ $rDate->format('d M') }})
                    </button>
                @endforeach
            </div>
        </form>
    </div>
</div>

<!-- Main Dual-View Card (Tab 1: Timeline Sesi Jam & Tab 2: Kalender Interaktif) -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                
                <!-- Underline Tabs Header -->
                <div class="d-flex justify-content-between align-items-center flex-wrap pb-0 mb-3" style="gap: 16px; border-bottom: 2px solid #edf2f7;">
                    <ul class="nav ot-underline-tabs mb-0" id="jadwalTabs" role="tablist" style="border-bottom: none; margin-bottom: -2px; gap: 28px;">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tab-timeline-link" data-toggle="tab" href="#tab-timeline" role="tab" aria-controls="tab-timeline" aria-selected="true" style="padding: 10px 8px 14px 8px; font-size: 14.5px;">
                                <i class="fa-solid fa-timeline mr-2"></i> Timeline Sesi Waktu
                                <span class="badge font-w700 ml-2" id="totalSesiBadge" style="font-size: 11px; padding: 3px 8px; border-radius: 12px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                    {{ $stats['total'] }} Sesi
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-kalender-link" data-toggle="tab" href="#tab-kalender" role="tab" aria-controls="tab-kalender" aria-selected="false" style="padding: 10px 8px 14px 8px; font-size: 14.5px;">
                                <i class="fa-solid fa-calendar-days mr-2"></i> Kalender Visual Bulanan
                            </a>
                        </li>
                    </ul>

                    <div class="pb-2">
                        <span class="badge font-w600" id="currentDateBadge" style="font-size: 12px; padding: 7px 14px; border-radius: 8px; background: #f8fafc; color: #334155; border: 1px solid #cbd5e1;">
                            <i class="fa-solid fa-calendar-day mr-1 text-primary"></i>
                            <span id="currentDateText">{{ $formattedDate }}</span>
                        </span>
                    </div>
                </div>

                <div class="tab-content pt-4" id="jadwalTabsContent">
                    
                    <!-- ============================================================= -->
                    <!-- TAB 1: AGENDA TIMELINE SLOT SESI (08.00 - 13.00) -->
                    <!-- ============================================================= -->
                    <div class="tab-pane fade show active" id="tab-timeline" role="tabpanel" aria-labelledby="tab-timeline-link">
                        
                        <!-- Timeline Data Container with Loading Overlay -->
                        <div id="timelineDataContainer" style="position: relative; min-height: 280px;">
                            <!-- Loading Processing Overlay -->
                            <div id="timelineLoadingOverlay" class="d-none" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.88); z-index: 20; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                <div class="spinner-border text-primary" role="status" style="width: 2.5rem; height: 2.5rem; border-width: 3px;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <span class="mt-2 text-primary font-w600" style="font-size: 13px; letter-spacing: 0.2px;">Memuat jadwal sesi terapi...</span>
                            </div>

                            <!-- Timeline Content Wrapper -->
                            <div id="timelineContentWrapper">
                                @include('jadwal.partial.timeline')
                            </div>
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
            
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%) !important; background-color: #1e40af !important; padding: 16px 20px; border-bottom: none !important;">
                <div>
                    <h5 class="modal-title font-w700 text-white mb-0" id="mJadwalNama" style="font-size: 16px; color: #ffffff !important;">Detail Sesi Terapi</h5>
                    <small class="text-white" id="mJadwalNoRm" style="opacity: 0.85; color: #ffffff !important;">No. RM: -</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9; color: #ffffff !important;">
                    <span aria-hidden="true" style="color: #ffffff !important;">&times;</span>
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
        var calendarInitialized = false;
        var currentAjax = null;

        // Function to fetch Jadwal & Timeline data via AJAX
        function fetchJadwalData(updateUrl = true) {
            var formData = $('#filterForm').serializeArray();

            // Build clean params for URL
            var cleanParams = $.param(formData.filter(function(item) {
                if (!item.value) return false;
                if (item.name === 'upt' && item.value === 'all') return false;
                if (item.name === 'layanan' && item.value === 'all') return false;
                if (item.name === 'dokter_id' && item.value === 'all') return false;
                return true;
            }));
            var targetUrl = "{{ Route('jadwal.index') }}" + (cleanParams ? '?' + cleanParams : '');

            if (currentAjax) {
                currentAjax.abort();
            }

            // Show loading overlay
            $('#timelineLoadingOverlay').removeClass('d-none').addClass('d-flex');

            currentAjax = $.ajax({
                url: "{{ Route('jadwal.index') }}",
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    $('#timelineContentWrapper').html(res.html);

                    // Update total sesi badge
                    if (res.total !== undefined) {
                        $('#totalSesiBadge').text(res.total + ' Sesi');
                    }

                    // Update header formatted date
                    if (res.formatted_date) {
                        $('#currentDateText').text(res.formatted_date);
                    }

                    // Update input sesi url
                    if (res.input_sesi_url) {
                        $('#btnInputSesiBaru').attr('href', res.input_sesi_url);
                    }

                    // Toggle Reset Button
                    if (res.has_filters) {
                        $('#resetButtonWrapper').fadeIn(150);
                    } else {
                        $('#resetButtonWrapper').fadeOut(150);
                    }

                    // Update active state of quick date presets
                    var currentTgl = res.tanggal || $('#inputTanggal').val();
                    $('.quick-date-btn').each(function() {
                        var btnTgl = $(this).data('tanggal');
                        if (btnTgl === currentTgl) {
                            $(this).removeClass('btn-light font-w600').addClass('btn-primary font-w700 text-white active')
                                   .css({ 'border-color': '#2563eb' });
                            $(this).find('i').css('color', '#fff');
                        } else {
                            $(this).removeClass('btn-primary font-w700 text-white active').addClass('btn-light font-w600')
                                   .css({ 'border-color': '#cbd5e1' });
                            $(this).find('i').css('color', '#2563eb');
                        }
                    });

                    // Update browser URL
                    if (updateUrl && window.history.pushState) {
                        window.history.pushState({ path: targetUrl }, '', targetUrl);
                    }

                    // Refetch Calendar events if initialized
                    if (calendarInitialized) {
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                },
                error: function(xhr, status, error) {
                    if (status !== 'abort') {
                        console.error('AJAX Error:', error);
                    }
                },
                complete: function() {
                    $('#timelineLoadingOverlay').addClass('d-none').removeClass('d-flex');
                }
            });
        }

        // 1. Trigger fetch on filter control changes (Tanggal, UPT, Layanan, Terapis)
        $('.filter-control').on('change', function() {
            fetchJadwalData(true);
        });

        // 2. Click Quick Date Presets
        $(document).on('click', '.quick-date-btn', function(e) {
            e.preventDefault();
            var targetTgl = $(this).data('tanggal');
            if (targetTgl) {
                $('#inputTanggal').val(targetTgl);
                fetchJadwalData(true);
            }
        });

        // 3. Click Reset Filter Button
        $(document).on('click', '#btnResetFilter', function(e) {
            e.preventDefault();
            $('#inputTanggal').val("{{ date('Y-m-d') }}");
            $('#selectUpt').val('all');
            $('#selectLayanan').val('all');
            $('#selectDokter').val('all');
            fetchJadwalData(true);
        });

        // 4. Handle browser Back/Forward (popstate)
        window.addEventListener('popstate', function() {
            var params = new URLSearchParams(window.location.search);
            $('#inputTanggal').val(params.get('tanggal') || "{{ date('Y-m-d') }}");
            $('#selectUpt').val(params.get('upt') || 'all');
            $('#selectLayanan').val(params.get('layanan') || 'all');
            $('#selectDokter').val(params.get('dokter_id') || 'all');
            fetchJadwalData(false);
        });

        // 5. Initialize FullCalendar
        function initCalendar() {
            if (calendarInitialized) return;

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                },
                defaultView: 'month',
                editable: false,
                eventLimit: true,
                events: function(start, end, timezone, callback) {
                    var filterData = {
                        start: start.format('YYYY-MM-DD'),
                        end: end.format('YYYY-MM-DD'),
                        upt: $('#selectUpt').val() || 'all',
                        layanan: $('#selectLayanan').val() || 'all',
                        dokter_id: $('#selectDokter').val() || 'all'
                    };

                    $.ajax({
                        url: "{{ route('jadwal.events') }}",
                        type: 'GET',
                        data: filterData,
                        success: function(response) {
                            callback(response);
                        },
                        error: function() {
                            if (typeof toastr !== 'undefined') {
                                toastr.error('Gagal memuat event jadwal kalender');
                            }
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
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            if (e.target.id === 'tab-kalender-link') {
                if (!calendarInitialized) {
                    initCalendar();
                } else {
                    $('#calendar').fullCalendar('render');
                    $('#calendar').fullCalendar('refetchEvents');
                }
            }
        });
    });
</script>
@endsection

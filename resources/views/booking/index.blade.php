@extends('layout.apps')

@section('title', 'Persetujuan & Antrean Booking Sesi Terapi')

@section('style')
<style>
    .ot-modal-content {
        border-radius: 14px !important;
        border: 1px solid #dbeafe !important;
        box-shadow: 0 14px 40px rgba(30, 64, 175, 0.12) !important;
        overflow: hidden !important;
    }
    .ot-modal-header {
        background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%) !important;
        border-bottom: 1.5px solid #bfdbfe !important;
        padding: 16px 22px !important;
    }
    .ot-modal-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 19px;
        border: 1px solid #bfdbfe;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1);
        flex-shrink: 0;
    }
    .ot-modal-title {
        color: #1e40af !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        margin-bottom: 2px;
    }
    .ot-modal-subtitle {
        color: #64748b !important;
        font-size: 11.5px !important;
        font-weight: 500 !important;
    }
    .ot-modal-header-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fff1f2 100%) !important;
        border-bottom: 1.5px solid #fecaca !important;
        padding: 16px 22px !important;
    }
    .ot-modal-icon-danger {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        font-size: 19px;
        border: 1px solid #fecaca;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.1);
        flex-shrink: 0;
    }
    .ot-input-modern {
        height: 42px !important;
        font-size: 13px !important;
        border-radius: 8px !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #1e293b !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }
    .ot-input-modern:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15) !important;
        outline: none !important;
    }
</style>
@endsection

@section('content')

<!-- Page Header Banner (Unified White Card - Matches Data Penerima Manfaat, Rekam Medis & Pendaftaran) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1 d-flex align-items-center flex-wrap" style="color: #1e40af; font-weight: 700; font-size: 20px; gap: 8px;">
                        <span>Persetujuan & Antrean Booking Sesi Terapi</span>
                        @if(isset($counts['menunggu']) && $counts['menunggu'] > 0)
                            <span class="badge font-w700" id="headerBadgeMenungguBooking" style="font-size: 11.5px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; border-radius: 8px; padding: 4px 10px; display: inline-flex; align-items: center;">
                                <i class="fa-solid fa-hourglass-half mr-1"></i> <span id="headerCountMenungguBooking">{{ number_format($counts['menunggu']) }}</span> Menunggu ACC
                            </span>
                        @else
                            <span class="badge font-w700" id="headerBadgeMenungguBooking" style="font-size: 11.5px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; border-radius: 8px; padding: 4px 10px; display: none; align-items: center;">
                                <i class="fa-solid fa-hourglass-half mr-1"></i> <span id="headerCountMenungguBooking">0</span> Menunggu ACC
                            </span>
                        @endif
                    </h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{Route('dashboard')}}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Pendaftaran Online</li>
                        <li class="breadcrumb-item active text-muted">Antrean Booking Sesi</li>
                    </ol>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <a href="{{ route('booking.export-csv', request()->all()) }}" id="btnExportCsv" class="btn btn-sm btn-success font-w600" style="background: #10b981 !important; border: none !important; color: #ffffff !important; font-size: 12.5px; padding: 8px 16px; border-radius: 8px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);" title="Download data antrean booking sesi ke CSV">
                    <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stat Cards (Top Row) -->
<div class="row">
    <!-- Card 1: Total Permohonan -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card p-3 shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; box-shadow: 0 4px 14px rgba(46, 75, 130, 0.04);">
            <div class="d-flex align-items-center">
                <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 18px; border-radius: 10px; border: 1px solid #bfdbfe; flex-shrink: 0;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div>
                    <span class="text-muted font-w600" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;">Total Permohonan</span>
                    <h4 class="font-w800 mb-0 text-dark" id="statTotalBooking" style="font-size: 20px;">{{ number_format($counts['total']) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Menunggu ACC -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card p-3 shadow-sm h-100" style="border: 1px solid #fde68a; border-radius: 10px; background: #fffbeb; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.06);">
            <div class="d-flex align-items-center">
                <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fef3c7; color: #d97706; font-size: 18px; border-radius: 10px; border: 1px solid #fde68a; flex-shrink: 0;">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div>
                    <span class="font-w700" style="font-size: 11.5px; text-transform: uppercase; color: #b45309; letter-spacing: 0.3px;">Menunggu ACC</span>
                    <h4 class="font-w800 mb-0" id="statMenungguBooking" style="font-size: 20px; color: #b45309;">{{ number_format($counts['menunggu']) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Terkonfirmasi -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card p-3 shadow-sm h-100" style="border: 1px solid #a7f3d0; border-radius: 10px; background: #ecfdf5; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.06);">
            <div class="d-flex align-items-center">
                <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #d1fae5; color: #059669; font-size: 18px; border-radius: 10px; border: 1px solid #a7f3d0; flex-shrink: 0;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="font-w700" style="font-size: 11.5px; text-transform: uppercase; color: #047857; letter-spacing: 0.3px;">Terkonfirmasi</span>
                    <h4 class="font-w800 mb-0" id="statTerkonfirmasiBooking" style="font-size: 20px; color: #047857;">{{ number_format($counts['disetujui']) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Ditolak -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card p-3 shadow-sm h-100" style="border: 1px solid #fecaca; border-radius: 10px; background: #fef2f2; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.06);">
            <div class="d-flex align-items-center">
                <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fee2e2; color: #dc2626; font-size: 18px; border-radius: 10px; border: 1px solid #fecaca; flex-shrink: 0;">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div>
                    <span class="font-w700" style="font-size: 11.5px; text-transform: uppercase; color: #b91c1c; letter-spacing: 0.3px;">Ditolak</span>
                    <h4 class="font-w800 mb-0" id="statDitolakBooking" style="font-size: 20px; color: #b91c1c;">{{ number_format($counts['ditolak']) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Section -->
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <!-- Toolbar Filter & Search Sejajar (Matches Dashboard Utama, Data Penerima Manfaat & Rekam Medis) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700" id="totalBookingCount">{{ number_format($bookings->total(), 0, ',', '.') }}</strong> Permohonan Booking
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form id="filterForm" method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            <!-- 0. Filter Lokasi UPT -->
                            <div class="ot-filter-wrapper" style="width: 175px;">
                                <i class="fa-solid fa-hospital-user"></i>
                                <select name="upt" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Lokasi UPT" style="width: 100%;">
                                    <option value="all" {{ (!request('upt') || request('upt') == 'all') ? 'selected' : '' }}>Semua Lokasi UPT</option>
                                    @if(isset($activeUpts))
                                        @foreach($activeUpts as $u)
                                            <option value="{{ $u->nama }}" {{ (request('upt') == $u->nama || (!request('upt') && isset($selectedUpt) && $selectedUpt == $u->nama)) ? 'selected' : '' }}>
                                                {{ $u->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- 1. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 155px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Status Permohonan" style="width: 100%;">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu ACC</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Terkonfirmasi</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <!-- 2. Filter Layanan Terapi -->
                            <div class="ot-filter-wrapper" style="width: 155px;">
                                <i class="fa-solid fa-hand-holding-medical"></i>
                                <select name="layanan" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Layanan Terapi" style="width: 100%;">
                                    <option value="">Semua Layanan</option>
                                    <option value="Fisioterapi" {{ request('layanan') == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                                    <option value="Okupasi" {{ request('layanan') == 'Okupasi' ? 'selected' : '' }}>Terapi Okupasi / SI</option>
                                    <option value="Wicara" {{ request('layanan') == 'Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                                    <option value="Netra" {{ request('layanan') == 'Netra' ? 'selected' : '' }}>Terapi Netra</option>
                                </select>
                            </div>

                            <!-- 3. Filter Shows (Per Page Limit) -->
                            <div class="ot-filter-wrapper" style="width: 120px;" title="Tampilkan jumlah baris data per halaman">
                                <i class="fa-solid fa-list-ol"></i>
                                <select name="per_page" class="form-control form-control-sm ot-filter-select filter-select" style="width: 100%;">
                                    <option value="10" {{ request('per_page', 10) == '10' ? 'selected' : '' }}>Show 10</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>Show 25</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>Show 50</option>
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>Show 100</option>
                                    <option value="250" {{ request('per_page') == '250' ? 'selected' : '' }}>Show 250</option>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Show Semua</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 185px; max-width: 220px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" id="keywordInput" name="keyword" value="{{request('keyword')}}" placeholder="Cari kode, nama, RM..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            <div id="resetButtonWrapper" style="{{ (request('keyword') || request('status') || request('layanan') || (request('upt') && request('upt') != 'all') || (request('per_page') && request('per_page') != '10')) ? '' : 'display: none;' }}">
                                <button type="button" id="btnResetFilter" class="btn btn-sm btn-light" style="width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #cbd5e1; border-radius: 8px; color: #64748b; font-size: 13px; transition: all 0.2s ease; flex-shrink: 0;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Container Tabel dengan Loading Processing Overlay -->
                <div id="tableDataContainer" style="position: relative; min-height: 250px;">
                    <!-- Loading Processing Overlay -->
                    <div id="tableLoadingOverlay" class="d-none" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.88); z-index: 20; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                        <div class="spinner-border text-primary" role="status" style="width: 2.5rem; height: 2.5rem; border-width: 3px;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="mt-2 text-primary font-w600" style="font-size: 13px; letter-spacing: 0.2px;">Memuat permohonan booking...</span>
                    </div>

                    <!-- Table Partial Content -->
                    <div id="tableContentWrapper">
                        @include('booking.partial.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL SETUJUI BOOKING SESI TERAPI (MATCHES UPT STYLE)                    -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalApproveBooking" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content">
            <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon mr-3" style="color: #059669; border-color: #a7f3d0; background: #ecfdf5;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h5 class="modal-title ot-modal-title">Konfirmasi Jadwal & Penugasan Terapis</h5>
                        <small class="ot-modal-subtitle">Tetapkan jadwal sesi terapi dan otomatis buat data sesi rekam medis</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formApproveBooking" method="POST" action="">
                {{ csrf_field() }}
                <div class="modal-body p-4 text-left" style="background: #ffffff;">
                    <div class="p-3 rounded mb-3" style="background: #f0f7ff; border: 1.5px solid #bfdbfe; font-size: 13px; border-radius: 10px;">
                        <div class="text-dark">Pasien: <strong class="text-primary font-w700" id="bkgModalPasien">-</strong></div>
                        <div class="text-dark mt-1">Layanan Terapi: <strong class="text-primary font-w700" id="bkgModalLayanan">-</strong></div>
                    </div>

                    <!-- Lokasi UPT Pelayanan -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa-solid fa-hospital-user text-primary mr-1"></i> Lokasi UPT Pelayanan <span class="text-danger">*</span>
                        </label>
                        <select name="upt_lokasi" id="bkgModalUpt" class="form-control ot-input-modern font-w600">
                            @if(isset($polis))
                                @foreach($polis as $poli)
                                    <option value="{{ $poli->nama }}">{{ $poli->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Pilih Terapis / Dokter (Filtered by UPT) -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa-solid fa-user-doctor text-primary mr-1"></i> Terapis Penanggung Jawab <span class="text-danger">*</span>
                        </label>
                        <select name="dokter_id" id="bkgModalDokterId" class="form-control ot-input-modern font-w600" required>
                            <option value="">-- Pilih Terapis Medis --</option>
                            @if(isset($dokters) && $dokters->count() > 0)
                                @foreach($dokters as $dok)
                                    <option value="{{ $dok->id }}">{{ $dok->nama }} ({{ $dok->keahlian ?: 'Terapis' }})</option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted font-w500 mt-1 d-block" id="bkgModalDokterHint" style="font-size: 11px;">
                            <i class="fa-solid fa-filter text-primary mr-1"></i> Menampilkan terapis yang bertugas pada UPT yang dipilih.
                        </small>
                    </div>

                    <div class="row">
                        <!-- Tanggal Sesi -->
                        <div class="col-md-6 form-group mb-0">
                            <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                                <i class="fa-regular fa-calendar text-primary mr-1"></i> Tanggal Sesi <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tgl_rekam" id="bkgModalTgl" class="form-control ot-input-modern font-w600" required>
                        </div>

                        <!-- Jam Sesi -->
                        <div class="col-md-6 form-group mb-0">
                            <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                                <i class="fa-regular fa-clock text-primary mr-1"></i> Jam Sesi Terapi <span class="text-danger">*</span> <small class="text-muted font-w400">(Maks 45 mnt)</small>
                            </label>
                            <select id="bkgModalJamSesiSelect" class="form-control ot-input-modern font-w600" required>
                                <option value="">--Pilih Slot Sesi Waktu--</option>
                                <option value="Sesi 1 (08.00 - 08.45 WIB)" data-base-label="Sesi 1 (08.00 - 08.45 WIB)">Sesi 1 (08.00 - 08.45 WIB)</option>
                                <option value="Sesi 2 (08.45 - 09.30 WIB)" data-base-label="Sesi 2 (08.45 - 09.30 WIB)">Sesi 2 (08.45 - 09.30 WIB)</option>
                                <option value="Sesi 3 (09.30 - 10.15 WIB)" data-base-label="Sesi 3 (09.30 - 10.15 WIB)">Sesi 3 (09.30 - 10.15 WIB)</option>
                                <option value="Sesi 4 (10.15 - 11.00 WIB)" data-base-label="Sesi 4 (10.15 - 11.00 WIB)">Sesi 4 (10.15 - 11.00 WIB)</option>
                                <option value="Sesi 5 (11.00 - 11.45 WIB)" data-base-label="Sesi 5 (11.00 - 11.45 WIB)">Sesi 5 (11.00 - 11.45 WIB)</option>
                                <option value="Sesi 6 (11.45 - 12.30 WIB)" data-base-label="Sesi 6 (11.45 - 12.30 WIB)">Sesi 6 (11.45 - 12.30 WIB)</option>
                                <option value="Sesi 7 (12.30 - 13.00 WIB)" data-base-label="Sesi 7 (12.30 - 13.00 WIB)">Sesi 7 (12.30 - 13.00 WIB)</option>
                                <option value="Sesi Khusus / Fleksibel" data-base-label="Sesi Khusus / Fleksibel">Sesi Khusus / Fleksibel (Input Jam Sendiri)</option>
                            </select>
                            <input type="hidden" name="jam_sesi" id="bkgModalJamSesi" value="Sesi 1 (08.00 - 08.45 WIB)">
                        </div>
                    </div>
                    <div id="bkgModalConflictHint" class="mt-2" style="display: none;"></div>

                    <!-- Input Jam Sesi Khusus / Fleksibel (Maksimal 45 Menit) -->
                    <div class="form-group mb-0 mt-3 d-none" id="wrapper_bkg_modal_sesi_khusus">
                        <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #eff6ff 100%); border: 1.5px solid #93c5fd; border-radius: 12px; padding: 14px 18px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.05);">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-2" style="gap: 8px;">
                                <div style="font-size: 13px; font-weight: 700; color: #1e40af;">
                                    <i class="fa-solid fa-clock mr-1 text-primary"></i> Atur Jam Sesi Khusus Petugas
                                </div>
                                <span class="badge" id="badge_bkg_modal_durasi" style="background: #e0f2fe; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11.5px; font-weight: 700; padding: 5px 12px; border-radius: 8px;">
                                    Durasi: 45 Menit (Maks. 45 Mnt)
                                </span>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-6 mb-2 mb-sm-0">
                                    <label class="form-label font-w600 mb-1" style="font-size: 12px; color: #1e40af;">Jam Mulai (WIB):</label>
                                    <input type="time" id="bkg_modal_custom_mulai" class="form-control form-control-sm ot-input-modern" value="13:00" style="height: 38px; font-size: 13px; font-weight: 600; background: #ffffff; border: 1.5px solid #bfdbfe; border-radius: 8px; color: #1e293b;">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label font-w600 mb-1" style="font-size: 12px; color: #1e40af;">Jam Selesai (Maks +45 Menit):</label>
                                    <input type="time" id="bkg_modal_custom_selesai" class="form-control form-control-sm ot-input-modern" value="13:45" style="height: 38px; font-size: 13px; font-weight: 600; background: #ffffff; border: 1.5px solid #bfdbfe; border-radius: 8px; color: #1e293b;">
                                </div>
                            </div>
                            <small class="d-block mt-2 font-w500" style="font-size: 11.5px; color: #2563eb; line-height: 1.4;">
                                <i class="fa-solid fa-circle-info mr-1 text-primary"></i> Standar pelayanan terapi dibatasi <strong>maksimal 45 menit per sesi</strong>.
                            </small>
                        </div>
                    </div>

                    <!-- Catatan Persetujuan Petugas (Opsional) -->
                    <div class="form-group mb-0 mt-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa-solid fa-comment-dots text-success mr-1"></i> Catatan Persetujuan Petugas <small class="text-muted font-w400">(Opsional / Muncul di Lacak Status Pasien)</small>:
                        </label>
                        <input type="text" name="catatan_petugas" class="form-control ot-input-modern" placeholder="Contoh: Jadwal telah dikonfirmasi, harap hadir 15 menit sebelum sesi.">
                    </div>
                </div>
                <div class="modal-footer py-2.5 px-4" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 7px 16px;">Batal</button>
                    <button type="submit" class="btn btn-sm btn-success font-w700 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                        <i class="fa-solid fa-check mr-1"></i> Konfirmasi & Buat Sesi Rekam
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL TOLAK BOOKING (MATCHES UPT STYLE)                                   -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalRejectBooking" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content" style="border-color: #fecaca !important;">
            <div class="modal-header ot-modal-header-danger d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon-danger mr-3">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 text-danger mb-0" style="font-size: 16px;">Tolak Permohonan Booking</h5>
                        <small class="ot-modal-subtitle" style="color: #991b1b !important;">Berikan catatan alasan penolakan jadwal kepada penerima manfaat</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #991b1b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRejectBooking" method="POST" action="">
                {{ csrf_field() }}
                <div class="modal-body p-4 text-left" style="background: #ffffff;">
                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 12px;">
                        Tolak permohonan booking sesi atas nama <strong id="rejectBkgPasien" class="text-dark font-w700">-</strong>?
                    </p>
                    <div class="form-group mb-0">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">Alasan Penolakan <span class="text-danger">*</span>:</label>
                        <textarea name="catatan_petugas" class="form-control" rows="3" required placeholder="Contoh: Kuota jadwal terapis penuh pada tanggal tersebut, silakan ajukan tanggal lain." style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2.5 px-4" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 7px 16px;">Batal</button>
                    <button type="submit" class="btn btn-sm btn-danger font-w700 shadow-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);">
                        <i class="fa-solid fa-ban mr-1"></i> Tolak Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        let currentAjax = null;
        let searchDebounceTimer = null;

        // Function to fetch data via AJAX
        function fetchBookingData(page = 1, updateUrl = true) {
            let form = $('#filterForm');
            let formData = form.serializeArray();
            
            // Check if page parameter is needed
            let hasPage = false;
            for (let i = 0; i < formData.length; i++) {
                if (formData[i].name === 'page') {
                    formData[i].value = page;
                    hasPage = true;
                    break;
                }
            }
            if (!hasPage && page) {
                formData.push({ name: 'page', value: page });
            }

            // Filter out empty / default params for clean URL query
            let cleanParams = $.param(formData.filter(item => item.value !== '' && !(item.name === 'per_page' && item.value === '10') && !(item.name === 'page' && item.value == '1') && !(item.name === 'upt' && item.value === 'all')));
            let targetUrl = "{{ Route('booking.index') }}" + (cleanParams ? '?' + cleanParams : '');

            if (currentAjax) {
                currentAjax.abort();
            }

            // Show loading overlay
            $('#tableLoadingOverlay').removeClass('d-none').addClass('d-flex');

            currentAjax = $.ajax({
                url: "{{ Route('booking.index') }}",
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    $('#tableContentWrapper').html(res.html);
                    
                    // Update total counter
                    if (res.total !== undefined) {
                        let formattedTotal = new Intl.NumberFormat('id-ID').format(res.total);
                        $('#totalBookingCount').text(formattedTotal);
                    }

                    // Update stat cards if returned
                    if (res.counts !== undefined) {
                        $('#statTotalBooking').text(new Intl.NumberFormat('id-ID').format(res.counts.total));
                        $('#statMenungguBooking').text(new Intl.NumberFormat('id-ID').format(res.counts.menunggu));
                        $('#statTerkonfirmasiBooking').text(new Intl.NumberFormat('id-ID').format(res.counts.disetujui));
                        $('#statDitolakBooking').text(new Intl.NumberFormat('id-ID').format(res.counts.ditolak));

                        if (res.counts.menunggu > 0) {
                            $('#headerCountMenungguBooking').text(new Intl.NumberFormat('id-ID').format(res.counts.menunggu));
                            $('#headerBadgeMenungguBooking').css('display', 'inline-flex');
                        } else {
                            $('#headerBadgeMenungguBooking').hide();
                        }
                    }

                    // Update export CSV URL
                    if (res.export_url) {
                        $('#btnExportCsv').attr('href', res.export_url);
                    }

                    // Toggle Reset Button
                    if (res.has_filters) {
                        $('#resetButtonWrapper').fadeIn(150);
                    } else {
                        $('#resetButtonWrapper').fadeOut(150);
                    }

                    // Update browser URL
                    if (updateUrl && window.history.pushState) {
                        window.history.pushState({ path: targetUrl }, '', targetUrl);
                    }
                },
                error: function (xhr, status, error) {
                    if (status !== 'abort') {
                        console.error('AJAX Error:', error);
                    }
                },
                complete: function () {
                    $('#tableLoadingOverlay').addClass('d-none').removeClass('d-flex');
                }
            });
        }

        // 1. Debounce on search keyword input
        $('#keywordInput').on('input', function () {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(function () {
                fetchBookingData(1);
            }, 350);
        });

        // 2. Submit form on Enter or Search Button
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            clearTimeout(searchDebounceTimer);
            fetchBookingData(1);
        });

        // 3. Trigger fetch on filter select changes
        $('.filter-select').on('change', function () {
            fetchBookingData(1);
        });

        // 4. Reset Filter Button click
        $(document).on('click', '#btnResetFilter', function (e) {
            e.preventDefault();
            $('#filterForm select[name="upt"]').val('all');
            $('#filterForm select[name="status"]').val('');
            $('#filterForm select[name="layanan"]').val('');
            $('#filterForm select[name="per_page"]').val('10');
            $('#keywordInput').val('');
            fetchBookingData(1);
        });

        // 5. AJAX Pagination click delegation
        $(document).on('click', '#tableContentWrapper .pagination a', function (e) {
            e.preventDefault();
            let pageUrl = $(this).attr('href');
            let urlParams = new URLSearchParams(pageUrl.split('?')[1]);
            let page = urlParams.get('page') || 1;
            fetchBookingData(page);
            $('html, body').animate({
                scrollTop: $("#tableDataContainer").offset().top - 120
            }, 300);
        });

        const allDokters = @json($dokters);

        function updateDokterDropdown(targetSelectId, hintElemId, uptName, selectedDokterId = '') {
            let selectElem = $(targetSelectId);
            selectElem.empty();

            let filtered = [];
            if (uptName && uptName.trim() !== '' && uptName.trim().toLowerCase() !== 'all') {
                let cleanUpt = uptName.trim().toLowerCase();
                filtered = allDokters.filter(function(d) {
                    if (!d.poli) return false;
                    let p = d.poli.trim().toLowerCase();
                    return p === cleanUpt || p.includes(cleanUpt) || cleanUpt.includes(p);
                });
            }

            if (filtered.length > 0) {
                selectElem.append('<option value="">-- Pilih Terapis di ' + uptName + ' (' + filtered.length + ' Terapis Tersedia) --</option>');
                filtered.forEach(function(d) {
                    let sel = (selectedDokterId && selectedDokterId == d.id) ? 'selected' : '';
                    selectElem.append('<option value="' + d.id + '" ' + sel + '>' + d.nama + (d.keahlian ? ' (' + d.keahlian + ')' : '') + '</option>');
                });
                if (hintElemId) {
                    $(hintElemId).html('<i class="fa-solid fa-circle-check text-success mr-1"></i> Menampilkan <strong>' + filtered.length + ' terapis</strong> yang bertugas di <strong>' + uptName + '</strong>.');
                }
            } else {
                let headerTxt = (uptName && uptName.trim() !== '' && uptName.trim().toLowerCase() !== 'all') 
                    ? ('-- Belum ada terapis khusus di ' + uptName + ' (Menampilkan Semua Terapis) --') 
                    : '-- Pilih Terapis Medis --';
                selectElem.append('<option value="">' + headerTxt + '</option>');
                allDokters.forEach(function(d) {
                    let sel = (selectedDokterId && selectedDokterId == d.id) ? 'selected' : '';
                    selectElem.append('<option value="' + d.id + '" ' + sel + '>' + d.nama + (d.poli ? ' [' + d.poli + ']' : '') + '</option>');
                });
                if (hintElemId) {
                    $(hintElemId).html('<i class="fa-solid fa-circle-info text-primary mr-1"></i> Menampilkan semua terapis aktif dalam sistem.');
                }
            }
        }

        // Function to check slot clash in approval modal
        function checkBkgModalConflict() {
            var dokterId = $('#bkgModalDokterId').val();
            var tanggal = $('#bkgModalTgl').val();
            var selectedSesi = $('#bkgModalJamSesi').val();
            var hintContainer = $('#bkgModalConflictHint');
            var submitBtn = $('#formApproveBooking button[type="submit"]');

            if (!dokterId || !tanggal) {
                $('#bkgModalJamSesiSelect option').each(function() {
                    var baseLabel = $(this).data('base-label') || $(this).val();
                    if ($(this).val() !== '') {
                        $(this).text(baseLabel).prop('disabled', false).css({'color': '', 'background-color': ''});
                    }
                });
                hintContainer.hide().empty();
                submitBtn.prop('disabled', false);
                return;
            }

            $.get("{{ route('jadwal.check-terapis') }}", {
                dokter_id: dokterId,
                tanggal: tanggal,
                sesi_waktu: selectedSesi
            }, function(res) {
                if (!res.success) return;

                var occupied = res.occupied_slots || {};

                // Update each option in sesi_waktu dropdown
                $('#bkgModalJamSesiSelect option').each(function() {
                    var val = $(this).val();
                    if (!val) return;

                    var baseLabel = $(this).data('base-label') || val;

                    if (occupied[val]) {
                        var occ = occupied[val];
                        $(this).text(baseLabel + " [TERISI - " + occ.pasien_nama + " (RM#" + occ.no_rm + ")]");
                        $(this).prop('disabled', true);
                        $(this).css({'color': '#dc2626', 'background-color': '#fef2f2'});
                    } else {
                        $(this).text(baseLabel);
                        $(this).prop('disabled', false);
                        $(this).css({'color': '', 'background-color': ''});
                    }
                });

                // If currently selected slot is occupied, show alert and disable button
                if (selectedSesi && occupied[selectedSesi]) {
                    var occ = occupied[selectedSesi];
                    hintContainer.html(`
                        <div class="alert alert-danger py-2 px-3 mb-0 d-flex align-items-center" style="font-size: 12px; border-radius: 8px; border: 1.5px solid #fecaca; background: #fef2f2; color: #b91c1c;">
                            <i class="fa-solid fa-triangle-exclamation mr-2" style="font-size: 14px; flex-shrink: 0;"></i>
                            <div>
                                <strong>Jadwal Bentrok:</strong> ${res.terapis_nama} sudah memiliki jadwal sesi dengan <strong>${occ.pasien_nama} (RM# ${occ.no_rm})</strong> pada tanggal ${res.tanggal_formatted} di sesi ini. Satu terapis hanya dapat melayani 1 penerima manfaat per sesi.
                            </div>
                        </div>
                    `).fadeIn(150);
                    submitBtn.prop('disabled', true);
                } else if (selectedSesi && !occupied[selectedSesi]) {
                    hintContainer.html(`
                        <div class="text-success font-w600" style="font-size: 12px;">
                            <i class="fa-solid fa-circle-check mr-1"></i> Terapis ${res.terapis_nama} tersedia pada sesi ini (1 terapis 1 penerima manfaat).
                        </div>
                    `).fadeIn(150);
                    submitBtn.prop('disabled', false);
                } else {
                    hintContainer.hide().empty();
                    submitBtn.prop('disabled', false);
                }
            });
        }

        // Sesi Khusus in Booking Approve Modal Handler
        function syncBkgModalCustomSesi(isMulaiChanged) {
            var $mulai = $('#bkg_modal_custom_mulai');
            var $selesai = $('#bkg_modal_custom_selesai');
            var $badge = $('#badge_bkg_modal_durasi');
            var $hidden = $('#bkgModalJamSesi');

            var mVal = $mulai.val();
            var sVal = $selesai.val();

            if (!mVal) return;

            var mParts = mVal.split(':').map(Number);
            var mMnt = mParts[0] * 60 + mParts[1];

            if (isMulaiChanged || !sVal) {
                var newSelesaiMnt = mMnt + 45;
                var sH = Math.floor(newSelesaiMnt / 60) % 24;
                var sM = newSelesaiMnt % 60;
                sVal = String(sH).padStart(2, '0') + ':' + String(sM).padStart(2, '0');
                $selesai.val(sVal);
            }

            var sParts = sVal.split(':').map(Number);
            var sMnt = sParts[0] * 60 + sParts[1];
            var diff = sMnt - mMnt;

            if (diff <= 0) {
                diff = 45;
                var sTot = mMnt + 45;
                var calcH = Math.floor(sTot / 60) % 24;
                var calcM = sTot % 60;
                sVal = String(calcH).padStart(2, '0') + ':' + String(calcM).padStart(2, '0');
                $selesai.val(sVal);
            } else if (diff > 45) {
                diff = 45;
                var sTot = mMnt + 45;
                var calcH = Math.floor(sTot / 60) % 24;
                var calcM = sTot % 60;
                sVal = String(calcH).padStart(2, '0') + ':' + String(calcM).padStart(2, '0');
                $selesai.val(sVal);
                if (typeof toastr !== 'undefined') {
                    toastr.info('Durasi per sesi dibatasi maksimal 45 menit.', 'Info Sesi', { timeOut: 2000 });
                }
            }

            if ($badge.length) {
                $badge.text('Durasi: ' + diff + ' Menit (Maks. 45 Mnt)');
            }

            var fMulai = $mulai.val().replace(':', '.');
            var fSelesai = $selesai.val().replace(':', '.');
            $hidden.val('Sesi Khusus (' + fMulai + ' - ' + fSelesai + ' WIB)');
            checkBkgModalConflict();
        }

        $('#bkgModalJamSesiSelect').on('change', function() {
            var val = $(this).val();
            if (val === 'Sesi Khusus / Fleksibel') {
                $('#wrapper_bkg_modal_sesi_khusus').removeClass('d-none');
                syncBkgModalCustomSesi(false);
            } else {
                $('#wrapper_bkg_modal_sesi_khusus').addClass('d-none');
                $('#bkgModalJamSesi').val(val);
                checkBkgModalConflict();
            }
        });

        $('#bkg_modal_custom_mulai').on('change input', function() { syncBkgModalCustomSesi(true); });
        $('#bkg_modal_custom_selesai').on('change input', function() { syncBkgModalCustomSesi(false); });

        // On UPT Selection change inside Approve Modal, re-filter doctors
        $('#bkgModalUpt').on('change', function() {
            updateDokterDropdown('#bkgModalDokterId', '#bkgModalDokterHint', $(this).val());
            checkBkgModalConflict();
        });

        $('#bkgModalDokterId, #bkgModalTgl, #bkgModalJamSesi').on('change input', function() {
            checkBkgModalConflict();
        });

        // Approve Booking Modal Handler (Delegated)
        $(document).on('click', '.btn-approve-booking', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var layanan = $(this).data('layanan');
            var tgl = $(this).data('tgl');
            var jam = $(this).data('jam');
            var upt = $(this).data('upt');

            $('#bkgModalPasien').text(nama);
            $('#bkgModalLayanan').text(layanan || 'Layanan Terapi Terpadu');
            $('#bkgModalTgl').val(tgl);

            var isCustom = jam && (jam.indexOf('Sesi Khusus') !== -1 || jam === 'Sesi Khusus / Fleksibel');
            if (isCustom) {
                $('#bkgModalJamSesiSelect').val('Sesi Khusus / Fleksibel');
                $('#wrapper_bkg_modal_sesi_khusus').removeClass('d-none');
                var match = jam.match(/(\d{2})[.:](\d{2})\s*-\s*(\d{2})[.:](\d{2})/);
                if (match) {
                    $('#bkg_modal_custom_mulai').val(match[1] + ':' + match[2]);
                    $('#bkg_modal_custom_selesai').val(match[3] + ':' + match[4]);
                } else {
                    $('#bkg_modal_custom_mulai').val('13:00');
                    $('#bkg_modal_custom_selesai').val('13:45');
                }
                syncBkgModalCustomSesi(false);
            } else if (jam) {
                $('#bkgModalJamSesiSelect').val(jam);
                $('#wrapper_bkg_modal_sesi_khusus').addClass('d-none');
                $('#bkgModalJamSesi').val(jam);
            }

            if (upt) {
                $('#bkgModalUpt').val(upt);
            }
            
            // Re-filter therapist list according to current UPT
            var currentUpt = $('#bkgModalUpt').val();
            updateDokterDropdown('#bkgModalDokterId', '#bkgModalDokterHint', currentUpt);
            checkBkgModalConflict();

            $('#formApproveBooking').attr('action', '/booking-sesi/' + id + '/approve');
            $('#modalApproveBooking').modal('show');
        });

        // Reject Booking Modal Handler (Delegated)
        $(document).on('click', '.btn-reject-booking', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#rejectBkgPasien').text(nama);
            $('#formRejectBooking').attr('action', '/booking-sesi/' + id + '/reject');
            $('#modalRejectBooking').modal('show');
        });
    });
</script>
@endsection

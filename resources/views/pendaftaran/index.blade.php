@extends('layout.apps')

@section('title', 'Verifikasi Pendaftaran Penerima Manfaat Baru')

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

<!-- Page Header Banner (Unified White Card - Matches Data Penerima Manfaat & Rekam Medis) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1 d-flex align-items-center flex-wrap" style="color: #1e40af; font-weight: 700; font-size: 20px; gap: 8px;">
                        <span>Verifikasi Pendaftaran Penerima Manfaat Baru</span>
                        @if(isset($counts['menunggu']) && $counts['menunggu'] > 0)
                            <span class="badge font-w700" id="headerBadgeMenungguPendaftaran" style="font-size: 11.5px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; border-radius: 8px; padding: 4px 10px; display: inline-flex; align-items: center;">
                                <i class="fa-solid fa-hourglass-half mr-1"></i> <span id="headerCountMenungguPendaftaran">{{ number_format($counts['menunggu']) }}</span> Menunggu Verifikasi
                            </span>
                        @else
                            <span class="badge font-w700" id="headerBadgeMenungguPendaftaran" style="font-size: 11.5px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; border-radius: 8px; padding: 4px 10px; display: none; align-items: center;">
                                <i class="fa-solid fa-hourglass-half mr-1"></i> <span id="headerCountMenungguPendaftaran">0</span> Menunggu Verifikasi
                            </span>
                        @endif
                    </h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{Route('dashboard')}}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Pendaftaran Online</li>
                        <li class="breadcrumb-item active text-muted">Verifikasi Pasien Baru</li>
                    </ol>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <a href="{{ route('portal.index') }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm font-w600" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; font-size: 12.5px; padding: 7px 14px; border-radius: 8px;" title="Buka form pendaftaran online publik">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Form Online
                </a>
                <a href="{{ route('pendaftaran.export-csv', request()->all()) }}" id="btnExportCsv" class="btn btn-sm btn-success font-w600" style="background: #10b981 !important; border: none !important; color: #ffffff !important; font-size: 12.5px; padding: 8px 16px; border-radius: 8px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);" title="Download data antrean pendaftaran ke CSV">
                    <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stat Cards (Top Row) -->
<div class="row">
    <!-- Card 1: Total Registrasi -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card p-3 shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; box-shadow: 0 4px 14px rgba(46, 75, 130, 0.04);">
            <div class="d-flex align-items-center">
                <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 18px; border-radius: 10px; border: 1px solid #bfdbfe; flex-shrink: 0;">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-muted font-w600" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;">Total Registrasi</span>
                    <h4 class="font-w800 mb-0 text-dark" id="statTotalRegistrasi" style="font-size: 20px;">{{ number_format($counts['total']) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Menunggu Verifikasi -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card p-3 shadow-sm h-100" style="border: 1px solid #fde68a; border-radius: 10px; background: #fffbeb; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.06);">
            <div class="d-flex align-items-center">
                <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fef3c7; color: #d97706; font-size: 18px; border-radius: 10px; border: 1px solid #fde68a; flex-shrink: 0;">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div>
                    <span class="font-w700" style="font-size: 11.5px; text-transform: uppercase; color: #b45309; letter-spacing: 0.3px;">Menunggu Verifikasi</span>
                    <h4 class="font-w800 mb-0" id="statMenungguVerifikasi" style="font-size: 20px; color: #b45309;">{{ number_format($counts['menunggu']) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Telah Disetujui -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card p-3 shadow-sm h-100" style="border: 1px solid #a7f3d0; border-radius: 10px; background: #ecfdf5; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.06);">
            <div class="d-flex align-items-center">
                <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #d1fae5; color: #059669; font-size: 18px; border-radius: 10px; border: 1px solid #a7f3d0; flex-shrink: 0;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="font-w700" style="font-size: 11.5px; text-transform: uppercase; color: #047857; letter-spacing: 0.3px;">Telah Disetujui</span>
                    <h4 class="font-w800 mb-0" id="statTelahDisetujui" style="font-size: 20px; color: #047857;">{{ number_format($counts['disetujui']) }}</h4>
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
                    <h4 class="font-w800 mb-0" id="statDitolak" style="font-size: 20px; color: #b91c1c;">{{ number_format($counts['ditolak']) }}</h4>
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
                            Total: <strong class="text-primary font-w700" id="totalPendaftaranCount">{{ number_format($pendaftarans->total(), 0, ',', '.') }}</strong> Antrean Pendaftaran
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
                            <div class="ot-filter-wrapper" style="width: 150px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Status Verifikasi" style="width: 100%;">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Telah Disetujui</option>
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
                                <input type="text" class="ot-search-input" id="keywordInput" name="keyword" value="{{request('keyword')}}" placeholder="Cari kode, nama, NIK..." autocomplete="off">
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
                        <span class="mt-2 text-primary font-w600" style="font-size: 13px; letter-spacing: 0.2px;">Memuat antrean pendaftaran...</span>
                    </div>

                    <!-- Table Partial Content -->
                    <div id="tableContentWrapper">
                        @include('pendaftaran.partial.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL DETAIL & VERIFIKASI BERKAS PENDAFTARAN (MATCHES UPT STYLE)          -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalDetailPendaftaran" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content">
            <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon mr-3">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <div>
                        <h5 class="modal-title ot-modal-title">Detail Pendaftaran Penerima Manfaat Baru</h5>
                        <small class="ot-modal-subtitle">Informasi lengkap data registrasi & lampiran berkas persyaratan</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" id="detailModalBody" style="background: #ffffff;">
                <div class="text-center py-4">
                    <i class="fa-solid fa-spinner fa-spin fa-2x text-primary"></i>
                    <div class="mt-2 text-muted font-w500">Memuat data pendaftaran...</div>
                </div>
            </div>
            <div class="modal-footer py-2.5 px-4" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 7px 16px;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL ACC PENDAFTARAN (MATCHES UPT STYLE)                                 -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalApproveConfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content">
            <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon mr-3" style="color: #059669; border-color: #a7f3d0; background: #ecfdf5;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <h5 class="modal-title ot-modal-title">Verifikasi & Setujui Pendaftaran</h5>
                        <small class="ot-modal-subtitle">Tentukan terapis penanggung jawab & terbitkan No. RM resmi</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formApprovePendaftaran" method="POST" action="">
                {{ csrf_field() }}
                <div class="modal-body p-4 text-left" style="background: #ffffff;">
                    <div class="p-3 rounded mb-3" style="background: #f0f7ff; border: 1.5px solid #bfdbfe; font-size: 13px; border-radius: 10px;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 8px;">
                            <div>
                                <span class="text-muted font-w600" style="font-size: 12px;">Penerima Manfaat:</span>
                                <div class="text-primary font-w700" id="approveNamaPasien" style="font-size: 14.5px;">-</div>
                            </div>
                            <div>
                                <span class="badge" style="background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; font-size: 12px; padding: 4px 10px; border-radius: 6px;">
                                    <i class="fa-solid fa-hospital-user mr-1"></i> <span id="approveUptText">UPT Terkait</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-2.5 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; color: #475569; line-height: 1.5; border-radius: 8px;">
                        <i class="fa-solid fa-circle-info mr-1 text-primary"></i> <strong>Sistem otomatis:</strong> Menerbitkan <strong>No. RM resmi</strong> ke master data & membuat <strong>Sesi Rekam Medis Pertama</strong> pada terapis terpilih.
                    </div>

                    <!-- Pilih Terapis (Filtered by UPT) -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa-solid fa-user-doctor text-primary mr-1"></i> Terapis Penanggung Jawab <span class="text-danger">*</span>
                        </label>
                        <select name="dokter_id" id="approveDokterId" class="form-control ot-input-modern font-w600" required>
                            <option value="">-- Pilih Terapis Medis --</option>
                            @if(isset($dokters) && $dokters->count() > 0)
                                @foreach($dokters as $dok)
                                    <option value="{{ $dok->id }}">{{ $dok->nama }} ({{ $dok->keahlian ?: 'Terapis' }})</option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted font-w500 mt-1 d-block" id="approveDokterHint" style="font-size: 11px;">
                            <i class="fa-solid fa-filter text-primary mr-1"></i> Menampilkan terapis yang bertugas pada UPT yang dipilih.
                        </small>
                    </div>

                    <div class="row">
                        <!-- Tanggal Sesi -->
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                                <i class="fa-regular fa-calendar text-primary mr-1"></i> Tanggal Sesi <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tgl_sesi" id="approveTglSesi" class="form-control ot-input-modern font-w600" required>
                        </div>

                        <!-- Jam Sesi -->
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                                <i class="fa-regular fa-clock text-primary mr-1"></i> Sesi Waktu Terapi <small class="text-muted font-w400">(Rabu, 30-45 mnt)</small>
                            </label>
                            <select name="jam_sesi" id="approveJamSesi" class="form-control ot-input-modern font-w600">
                                <option value="">--Pilih Slot Sesi Waktu--</option>
                                <option value="Sesi 1 (08.00 - 08.45 WIB)">Sesi 1 (08.00 - 08.45 WIB)</option>
                                <option value="Sesi 2 (08.45 - 09.30 WIB)">Sesi 2 (08.45 - 09.30 WIB)</option>
                                <option value="Sesi 3 (09.30 - 10.15 WIB)">Sesi 3 (09.30 - 10.15 WIB)</option>
                                <option value="Sesi 4 (10.15 - 11.00 WIB)">Sesi 4 (10.15 - 11.00 WIB)</option>
                                <option value="Sesi 5 (11.00 - 11.45 WIB)">Sesi 5 (11.00 - 11.45 WIB)</option>
                                <option value="Sesi 6 (11.45 - 12.30 WIB)">Sesi 6 (11.45 - 12.30 WIB)</option>
                                <option value="Sesi 7 (12.30 - 13.00 WIB)">Sesi 7 (12.30 - 13.00 WIB)</option>
                                <option value="Sesi Khusus / Fleksibel">Sesi Khusus / Fleksibel</option>
                            </select>
                        </div>
                    </div>

                    <!-- Layanan Terapi -->
                    <div class="form-group mb-3">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">
                            <i class="fa-solid fa-shapes text-primary mr-1"></i> Layanan Terapi
                        </label>
                        <input type="text" name="layanan_terapi" id="approveLayananTerapi" class="form-control ot-input-modern font-w600">
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">Catatan Persetujuan (Opsional):</label>
                        <input type="text" name="catatan_petugas" class="form-control ot-input-modern" placeholder="Contoh: Berkas lengkap, siap asesmen awal.">
                    </div>
                </div>
                <div class="modal-footer py-2.5 px-4" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 7px 16px;">Batal</button>
                    <button type="submit" class="btn btn-sm btn-success font-w700 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                        <i class="fa-solid fa-check mr-1"></i> Setujui & Terbitkan No. RM
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL TOLAK PENDAFTARAN (MATCHES UPT STYLE)                               -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalRejectConfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content" style="border-color: #fecaca !important;">
            <div class="modal-header ot-modal-header-danger d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon-danger mr-3">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 text-danger mb-0" style="font-size: 16px;">Tolak Pendaftaran Pasien</h5>
                        <small class="ot-modal-subtitle" style="color: #991b1b !important;">Berikan alasan penolakan berkas registrasi</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #991b1b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRejectPendaftaran" method="POST" action="">
                {{ csrf_field() }}
                <div class="modal-body p-4 text-left" style="background: #ffffff;">
                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 12px;">
                        Tolak pendaftaran atas nama <strong id="rejectNamaPasien" class="text-dark font-w700">-</strong>?
                    </p>
                    <div class="form-group mb-0">
                        <label class="font-w600 text-dark mb-1" style="font-size: 13px;">Alasan Penolakan <span class="text-danger">*</span>:</label>
                        <textarea name="catatan_petugas" class="form-control" rows="3" required placeholder="Contoh: Foto KK buram/tidak terbaca atau domisili di luar wilayah layanan." style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2.5 px-4" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 7px 16px;">Batal</button>
                    <button type="submit" class="btn btn-sm btn-danger font-w700 shadow-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);">
                        <i class="fa-solid fa-ban mr-1"></i> Tolak Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ========================================================================= -->
<!-- MODAL PREVIEW BERKAS DOKUMEN (KK, RESUME & DOKUMEN MEDIS)                 -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalPreviewBerkas" tabindex="-1" role="dialog" aria-hidden="true" style="backdrop-filter: blur(4px); z-index: 1065;">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 880px; z-index: 1066;" role="document">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 14px 45px rgba(15, 23, 42, 0.3); overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-header d-flex justify-content-between align-items-center py-3 px-4" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color: #ffffff;">
                <div class="d-flex align-items-center">
                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 10px; background: rgba(255, 255, 255, 0.16); color: #ffffff; font-size: 18px; flex-shrink: 0; backdrop-filter: blur(4px);">
                        <i id="previewDocIcon" class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 text-white mb-0" id="previewDocTitle" style="font-size: 16px;">Preview Berkas</h5>
                        <small class="text-white-50" style="font-size: 11.5px;">
                            <span id="previewDocPatient">-</span> &bull; Reg: <span id="previewDocReg">-</span> &bull; NIK: <span id="previewDocNik">-</span>
                        </small>
                    </div>
                </div>

                <!-- Controls & Actions -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <!-- Zoom Controls (for images) -->
                    <div class="btn-group btn-group-sm" id="previewZoomControls" style="background: rgba(255, 255, 255, 0.16); border-radius: 6px; padding: 2px;">
                        <button type="button" class="btn btn-xs text-white" id="btnPreviewZoomOut" title="Perkecil (-)" style="border: none; padding: 4px 8px;">
                            <i class="fa-solid fa-magnifying-glass-minus"></i>
                        </button>
                        <button type="button" class="btn btn-xs text-white font-w600" id="btnPreviewZoomReset" title="Reset Ukuran (100%)" style="border: none; padding: 4px 8px; font-size: 11px;">
                            100%
                        </button>
                        <button type="button" class="btn btn-xs text-white" id="btnPreviewZoomIn" title="Perbesar (+)" style="border: none; padding: 4px 8px;">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                        <button type="button" class="btn btn-xs text-white" id="btnPreviewRotate" title="Putar Gambar (90°)" style="border: none; padding: 4px 8px;">
                            <i class="fa-solid fa-rotate-right"></i>
                        </button>
                    </div>

                    <!-- Open in New Tab -->
                    <a href="#" target="_blank" id="btnPreviewNewTab" class="btn btn-xs btn-light font-w600 shadow-sm" title="Buka di Tab Baru" style="border-radius: 6px; padding: 5px 10px; font-size: 11.5px;">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka Tab
                    </a>

                    <!-- Download Button -->
                    <a href="#" download id="btnPreviewDownload" class="btn btn-xs btn-success font-w600 text-white shadow-sm" title="Download Berkas" style="border-radius: 6px; padding: 5px 12px; font-size: 11.5px; background: #10b981 !important; border: none !important;">
                        <i class="fa-solid fa-download mr-1"></i> Unduh
                    </a>

                    <!-- Close Button -->
                    <button type="button" class="close text-white ml-2" data-dismiss="modal" aria-label="Close" style="opacity: 0.9; text-shadow: none; font-size: 24px; line-height: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body (Viewer Canvas) -->
            <div class="modal-body p-0" style="background: #0f172a; min-height: 480px; max-height: 72vh; overflow: auto; position: relative; display: flex; align-items: center; justify-content: center;">
                
                <!-- Image View Surface -->
                <div id="previewImageWrapper" style="width: 100%; height: 100%; min-height: 480px; display: flex; align-items: center; justify-content: center; overflow: auto; padding: 24px; user-select: none;">
                    <img id="previewImageElement" src="" alt="Berkas Preview" style="max-width: 100%; max-height: 65vh; object-fit: contain; border-radius: 6px; box-shadow: 0 10px 30px rgba(0,0,0,0.6); transition: transform 0.2s ease-out; transform-origin: center center;" />
                </div>

                <!-- PDF / Iframe View Surface -->
                <div id="previewPdfWrapper" style="width: 100%; height: 68vh; display: none;">
                    <iframe id="previewPdfElement" src="" style="width: 100%; height: 100%; border: none; background: #ffffff;"></iframe>
                </div>
            </div>

            <!-- Modal Footer Information Strip -->
            <div class="modal-footer py-2.5 px-4 d-flex justify-content-between align-items-center" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                <div class="d-flex align-items-center text-muted" style="font-size: 12px; gap: 15px;">
                    <div>
                        <i class="fa-solid fa-file-circle-check text-success mr-1"></i>
                        <span id="previewDocFileName" class="font-w600 text-dark">-</span>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fa-solid fa-shield-halved text-primary mr-1"></i> Dokumen Persyaratan Pendaftaran Rahasia
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap: 8px;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 5px 16px; font-size: 12px;">
                        Tutup
                    </button>
                </div>
            </div>

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
        function fetchPendaftaranData(page = 1, updateUrl = true) {
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
            let targetUrl = "{{ Route('pendaftaran.index') }}" + (cleanParams ? '?' + cleanParams : '');

            if (currentAjax) {
                currentAjax.abort();
            }

            // Show loading overlay
            $('#tableLoadingOverlay').removeClass('d-none').addClass('d-flex');

            currentAjax = $.ajax({
                url: "{{ Route('pendaftaran.index') }}",
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    $('#tableContentWrapper').html(res.html);
                    
                    // Update total counter
                    if (res.total !== undefined) {
                        let formattedTotal = new Intl.NumberFormat('id-ID').format(res.total);
                        $('#totalPendaftaranCount').text(formattedTotal);
                    }

                    // Update stat cards if returned
                    if (res.counts !== undefined) {
                        $('#statTotalRegistrasi').text(new Intl.NumberFormat('id-ID').format(res.counts.total));
                        $('#statMenungguVerifikasi').text(new Intl.NumberFormat('id-ID').format(res.counts.menunggu));
                        $('#statTelahDisetujui').text(new Intl.NumberFormat('id-ID').format(res.counts.disetujui));
                        $('#statDitolak').text(new Intl.NumberFormat('id-ID').format(res.counts.ditolak));

                        if (res.counts.menunggu > 0) {
                            $('#headerCountMenungguPendaftaran').text(new Intl.NumberFormat('id-ID').format(res.counts.menunggu));
                            $('#headerBadgeMenungguPendaftaran').css('display', 'inline-flex');
                        } else {
                            $('#headerBadgeMenungguPendaftaran').hide();
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
                fetchPendaftaranData(1);
            }, 350);
        });

        // 2. Submit form on Enter or Search Button
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            clearTimeout(searchDebounceTimer);
            fetchPendaftaranData(1);
        });

        // 3. Trigger fetch on filter select changes
        $('.filter-select').on('change', function () {
            fetchPendaftaranData(1);
        });

        // 4. Reset Filter Button click
        $(document).on('click', '#btnResetFilter', function (e) {
            e.preventDefault();
            $('#filterForm select[name="upt"]').val('all');
            $('#filterForm select[name="status"]').val('');
            $('#filterForm select[name="layanan"]').val('');
            $('#filterForm select[name="per_page"]').val('10');
            $('#keywordInput').val('');
            fetchPendaftaranData(1);
        });

        // 5. AJAX Pagination click delegation
        $(document).on('click', '#tableContentWrapper .pagination a', function (e) {
            e.preventDefault();
            let pageUrl = $(this).attr('href');
            let urlParams = new URLSearchParams(pageUrl.split('?')[1]);
            let page = urlParams.get('page') || 1;
            fetchPendaftaranData(page);
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

        // Detail Modal Handler (Delegated)
        $(document).on('click', '.btn-detail-pendaftaran', function() {
            var id = $(this).data('id');
            var modal = $('#modalDetailPendaftaran');
            modal.modal('show');
            $('#detailModalBody').html('<div class="text-center py-5"><i class="fa-solid fa-spinner fa-spin fa-2x text-primary"></i><div class="mt-2 text-muted font-w600" style="font-size: 13px;">Memuat rincian data pendaftaran...</div></div>');

            $.ajax({
                url: "/pendaftaran-online/" + id + "/show",
                type: "GET",
                success: function(res) {
                    if (res.success) {
                        var d = res.data;
                        var cleanHp = (d.no_hp || '').replace(/[^0-9]/g, '');
                        if (cleanHp.startsWith('0')) {
                            cleanHp = '62' + cleanHp.substring(1);
                        }

                        var html = '';
                        
                        // Grid Data Lengkap Pendaftaran (Clean spacious card grid with comfortable padding)
                        html += '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(235px, 1fr)); gap: 14px; margin-bottom: 18px;">';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-ticket text-primary mr-1"></i> Kode Registrasi:</span> <strong class="text-primary font-w800" style="font-size: 14.5px;">' + d.kode_pendaftaran + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-calendar-day text-primary mr-1"></i> Tanggal Mendaftar:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + res.tgl_daftar_formatted + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-user text-primary mr-1"></i> Nama Lengkap:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + d.nama + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-address-card text-primary mr-1"></i> NIK:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.nik || '-') + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-id-card-clip text-primary mr-1"></i> No. BPJS / KIS:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.no_bpjs || '-') + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-venus-mars text-primary mr-1"></i> Jenis Kelamin:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.jk || '-') + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-calendar text-primary mr-1"></i> Tanggal Lahir:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.tmp_lahir ? d.tmp_lahir + ', ' : '') + res.tgl_lahir_formatted + '</strong></div>';

                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-person-praying text-primary mr-1"></i> Agama:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.agama || '-') + '</strong></div>';

                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-graduation-cap text-primary mr-1"></i> Pendidikan Terakhir:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.pendidikan || '-') + '</strong></div>';
                        
                        var desilHtml = d.desil ? d.desil : 'Non-Desil / Umum';
                        if (d.desil && ['Desil 1', 'Desil 2', 'Desil 3', 'Desil 4'].indexOf(d.desil) !== -1) {
                            desilHtml = '<span class="badge badge-success light font-w800" style="font-size: 12px; padding: 4px 8px; border-radius: 6px;"><i class="fa-solid fa-check-circle mr-1"></i>' + d.desil + ' (Prioritas)</span>';
                        } else if (d.desil) {
                            desilHtml = '<span class="badge badge-warning light font-w700" style="font-size: 12px; padding: 4px 8px; border-radius: 6px;">' + d.desil + '</span>';
                        }
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-layer-group text-primary mr-1"></i> Tingkat Desil:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + desilHtml + '</strong></div>';

                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-wheelchair text-primary mr-1"></i> Ragam Disabilitas:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.jenis_disabilitas || 'Tidak Ada') + '</strong></div>';

                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-crutch text-primary mr-1"></i> Alat Bantu Mobilitas:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.alat_bantu || 'Tidak Ada / Mandiri') + '</strong></div>';
                        
                        var waliText = (d.nama_wali || '-') + (d.no_hp ? ' (' + d.no_hp + ')' : '');
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-circle-user text-primary mr-1"></i> Nama Wali / Kontak:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + waliText + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-people-roof text-primary mr-1"></i> Hubungan Wali:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + (d.hubungan_wali || '-') + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-hospital-user text-primary mr-1"></i> Pilihan UPT:</span> <strong class="text-primary font-w700" style="font-size: 13.5px;">' + (d.upt_lokasi || '-') + '</strong></div>';

                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-shapes text-primary mr-1"></i> Layanan Terapi:</span> <strong class="text-primary font-w700" style="font-size: 13.5px;">' + (d.layanan_terapi || '-') + '</strong></div>';
                        
                        html += '  <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px 18px;"><span class="text-muted d-block font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-clock text-primary mr-1"></i> Rencana Kunjungan:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + res.tgl_rencana_formatted + ' (' + (d.jam_rencana_kunjungan || 'Sesi 1 (08.00 - 08.45 WIB)') + ')</strong></div>';
                        
                        if (d.status === 'disetujui') {
                            html += '  <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 10px; padding: 14px 18px;"><span class="text-success d-block font-w700 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-user-doctor mr-1"></i> Terapis Ditugaskan:</span> <strong class="text-success font-w800" style="font-size: 13.5px;">' + res.terapis_nama + '</strong></div>';
                            html += '  <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 10px; padding: 14px 18px;"><span class="text-success d-block font-w700 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;"><i class="fa-solid fa-calendar-check mr-1"></i> Sesi Disetujui:</span> <strong class="text-dark font-w700" style="font-size: 13.5px;">' + res.tgl_sesi_disetujui_formatted + ' (' + (d.jam_sesi_disetujui || '-') + ')</strong></div>';
                        }
                        html += '</div>';

                        // Alamat Domisili Pasien
                        html += '<div class="mb-3 rounded" style="background: #f8fafc; border: 1.5px solid #e2e8f0; font-size: 13px; border-radius: 10px; padding: 14px 18px;">';
                        html += '  <div class="font-w700 text-dark mb-1"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Alamat Domisili Pasien:</div>';
                        html += '  <div class="text-secondary font-w600">' + (d.alamat_lengkap || '-') + '</div>';
                        if (d.kelurahan || d.kecamatan || d.kabupaten) {
                            html += '  <div class="mt-1 text-muted" style="font-size: 12px;">';
                            html += '    Kel/Desa: <strong>' + (d.kelurahan || '-') + '</strong> &bull; ';
                            html += '    Kecamatan: <strong>' + (d.kecamatan || '-') + '</strong> &bull; ';
                            html += '    Kab/Kota: <strong>' + (d.kabupaten || '-') + '</strong>';
                            if (d.kodepos) {
                                html += ' (' + d.kodepos + ')';
                            }
                            html += '  </div>';
                        }
                        html += '</div>';

                        // Keluhan & Kebutuhan Terapi Pasien
                        var keluhanVal = d.keluhan_utama ? d.keluhan_utama : '<span class="text-muted font-italic font-w500">Tidak ada catatan keluhan khusus yang dicantumkan.</span>';
                        html += '<div class="mb-3 rounded" style="background: #eff6ff; border: 1.5px solid #bfdbfe; font-size: 13px; border-radius: 10px; padding: 14px 18px;">';
                        html += '  <div class="font-w700 mb-1" style="color: #1e40af;"><i class="fa-solid fa-notes-medical mr-1 text-primary"></i> Keluhan & Kebutuhan Terapi:</div>';
                        html += '  <div class="text-dark font-w600" style="line-height: 1.6; font-size: 13px;">' + keluhanVal + '</div>';
                        html += '</div>';

                        // Catatan Persetujuan / Penolakan Petugas
                        if (d.status === 'disetujui' && d.catatan_petugas) {
                            html += '<div class="mb-3 rounded" style="background: #ecfdf5; border: 1.5px solid #a7f3d0; font-size: 13px; border-radius: 10px; padding: 14px 18px;">';
                            html += '  <div class="font-w700 mb-1" style="color: #047857;"><i class="fa-solid fa-clipboard-check mr-1 text-success"></i> Catatan Persetujuan Petugas:</div>';
                            html += '  <div class="text-dark font-w600" style="line-height: 1.6; font-size: 13px;">' + d.catatan_petugas + '</div>';
                            html += '</div>';
                        } else if (d.status === 'ditolak' && d.catatan_petugas) {
                            html += '<div class="mb-3 rounded" style="background: #fef2f2; border: 1.5px solid #fecaca; font-size: 13px; border-radius: 10px; padding: 14px 18px;">';
                            html += '  <div class="font-w700 mb-1" style="color: #b91c1c;"><i class="fa-solid fa-circle-xmark mr-1 text-danger"></i> Alasan Penolakan:</div>';
                            html += '  <div class="text-dark font-w600" style="line-height: 1.6; font-size: 13px;">' + d.catatan_petugas + '</div>';
                            html += '</div>';
                        }

                        // Berkas Dokumen (Dengan popup modal interaktif sama persis seperti di Data Sosial & Berkas Pendukung di Detail Penerima Manfaat)
                        html += '<div class="mt-3 pt-3" style="border-top: 1.5px solid #e2e8f0;">';
                        html += '  <div class="font-w700 text-dark mb-2.5" style="font-size: 13px;"><i class="fa-solid fa-folder-open text-primary mr-1"></i> Berkas Pendukung:</div>';
                        html += '  <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">';
                        if (res.file_kk_url) {
                            html += '    <button type="button" class="btn btn-xs btn-info text-white shadow-sm font-w600 btn-open-preview-berkas" data-type="kk" data-title="Kartu Keluarga (KK)" data-url="' + res.file_kk_url + '" data-filename="' + (d.file_kk || 'KK_' + d.nama) + '" data-patient="' + d.nama + '" data-nik="' + (d.nik || '-') + '" data-reg="' + d.kode_pendaftaran + '" style="border-radius: 6px; font-size: 11.5px; padding: 6px 14px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;"><i class="fa-solid fa-id-card mr-1"></i> Lihat KK</button>';
                        } else {
                            html += '    <span class="badge badge-light text-muted font-w500 border" style="font-size: 11px; padding: 6px 12px; border-radius: 6px;"><i class="fa-solid fa-circle-xmark mr-1 text-muted"></i> KK: Belum Ada</span>';
                        }
                        if (res.file_resume_url) {
                            html += '    <button type="button" class="btn btn-xs btn-primary text-white shadow-sm font-w600 btn-open-preview-berkas" data-type="resume" data-title="Resume Berobat / Rujukan Medis" data-url="' + res.file_resume_url + '" data-filename="' + (d.file_resume || 'Resume_' + d.nama) + '" data-patient="' + d.nama + '" data-nik="' + (d.nik || '-') + '" data-reg="' + d.kode_pendaftaran + '" style="border-radius: 6px; font-size: 11.5px; padding: 6px 14px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important;"><i class="fa-solid fa-file-medical mr-1"></i> Resume Berobat</button>';
                        } else {
                            html += '    <span class="badge badge-light text-muted font-w500 border" style="font-size: 11px; padding: 6px 12px; border-radius: 6px;"><i class="fa-solid fa-circle-xmark mr-1 text-muted"></i> Resume: Belum Ada</span>';
                        }
                        html += '  </div>';
                        html += '</div>';

                        $('#detailModalBody').html(html);
                    }
                }
            });
        });

        // Interactive Document / Berkas Previewer Handler (Same as Detail Pasien Rekam Medis)
        var currentZoom = 1;
        var currentRotation = 0;

        function updateImageTransform() {
            $('#previewImageElement').css('transform', 'scale(' + currentZoom + ') rotate(' + currentRotation + 'deg)');
            $('#btnPreviewZoomReset').text(Math.round(currentZoom * 100) + '%');
        }

        $(document).on('click', '.btn-open-preview-berkas', function(e) {
            e.preventDefault();
            var btn = $(this);
            var docType = btn.data('type');
            var docTitle = btn.data('title') || 'Berkas Dokumen';
            var docUrl = btn.data('url');
            var docFileName = btn.data('filename') || 'dokumen';
            var docPatient = btn.data('patient') || '-';
            var docNik = btn.data('nik') || '-';
            var docReg = btn.data('reg') || '-';

            currentZoom = 1;
            currentRotation = 0;
            updateImageTransform();

            $('#previewDocTitle').text(docTitle);
            $('#previewDocFileName').text(docFileName);
            $('#previewDocPatient').text(docPatient);
            $('#previewDocReg').text(docReg);
            $('#previewDocNik').text(docNik);
            $('#btnPreviewNewTab').attr('href', docUrl);
            $('#btnPreviewDownload').attr('href', docUrl).attr('download', docFileName);

            if (docType === 'kk') {
                $('#previewDocIcon').attr('class', 'fa-solid fa-id-card');
            } else {
                $('#previewDocIcon').attr('class', 'fa-solid fa-file-medical');
            }

            var isPdf = docUrl && (docUrl.toLowerCase().indexOf('.pdf') !== -1 || docFileName.toLowerCase().indexOf('.pdf') !== -1);

            if (isPdf) {
                $('#previewZoomControls').hide();
                $('#previewImageWrapper').hide();
                $('#previewPdfWrapper').show();
                $('#previewPdfElement').attr('src', docUrl);
            } else {
                $('#previewZoomControls').show();
                $('#previewPdfWrapper').hide();
                $('#previewImageWrapper').show();
                $('#previewImageElement').attr('src', docUrl);
            }

            $('#modalPreviewBerkas').modal('show');
        });

        // Zoom & Rotate Controls
        $(document).on('click', '#btnPreviewZoomIn', function() {
            if (currentZoom < 3) {
                currentZoom = Math.min(3, currentZoom + 0.25);
                updateImageTransform();
            }
        });

        $(document).on('click', '#btnPreviewZoomOut', function() {
            if (currentZoom > 0.5) {
                currentZoom = Math.max(0.5, currentZoom - 0.25);
                updateImageTransform();
            }
        });

        $(document).on('click', '#btnPreviewZoomReset', function() {
            currentZoom = 1;
            currentRotation = 0;
            updateImageTransform();
        });

        $(document).on('click', '#btnPreviewRotate', function() {
            currentRotation = (currentRotation + 90) % 360;
            updateImageTransform();
        });

        // Re-add modal-open class to body when closing preview modal if detail modal is still open
        $('#modalPreviewBerkas').on('hidden.bs.modal', function () {
            if ($('#modalDetailPendaftaran').hasClass('show')) {
                $('body').addClass('modal-open');
            }
        });

        // Approve Modal Handler (Delegated)
        $(document).on('click', '.btn-approve-pendaftaran', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var layanan = $(this).data('layanan');
            var tgl = $(this).data('tgl');
            var jam = $(this).data('jam');
            var upt = $(this).data('upt');

            $('#approveNamaPasien').text(nama);
            $('#approveUptText').text(upt || 'Semua UPT');
            $('#approveLayananTerapi').val(layanan || 'Fisioterapi Pediatrik');
            $('#approveTglSesi').val(tgl);
            if (jam) {
                $('#approveJamSesi').val(jam);
            }

            // Filter therapist dropdown specifically for this UPT
            updateDokterDropdown('#approveDokterId', '#approveDokterHint', upt);

            $('#formApprovePendaftaran').attr('action', '/pendaftaran-online/' + id + '/approve');
            $('#modalApproveConfirm').modal('show');
        });

        // Reject Modal Handler (Delegated)
        $(document).on('click', '.btn-reject-pendaftaran', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#rejectNamaPasien').text(nama);
            $('#formRejectPendaftaran').attr('action', '/pendaftaran-online/' + id + '/reject');
            $('#modalRejectConfirm').modal('show');
        });
    });
</script>
@endsection

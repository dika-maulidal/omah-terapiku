@extends('layout.apps')

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
    .ot-input-modern {
        height: 44px !important;
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
    .ot-file-upload-box {
        height: 44px !important;
        position: relative;
        border-radius: 8px !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #ffffff !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 0 0 14px !important;
        cursor: pointer;
        transition: all 0.2s ease;
        overflow: hidden !important;
    }
    .ot-file-upload-box:focus-within, .ot-file-upload-box:hover {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15) !important;
    }
    .ot-file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }
    .ot-file-btn {
        height: 44px;
        padding: 0 18px;
        border-radius: 0;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-shrink: 0;
        border-left: 1.5px solid #2563eb;
        pointer-events: none;
        transition: all 0.2s ease;
    }
    .ot-file-upload-box:hover .ot-file-btn {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    }
    .quick-tag-btn {
        font-size: 11.5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.15s ease;
        border: 1px solid #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .quick-tag-btn:hover {
        background: #dbeafe;
        border-color: #93c5fd;
        color: #1e40af;
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
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Data Terapis & Tenaga Medis</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item active text-muted">Data Terapis</li>
                    </ol>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary font-w700 shadow-sm" data-toggle="modal" data-target="#addOrderModal" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-user-plus mr-1"></i> Tambah Terapis
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Terapis Baru -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content">
            <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon mr-3">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <h5 class="modal-title ot-modal-title">Tambah Data Terapis Baru</h5>
                        <small class="ot-modal-subtitle">Daftarkan terapis dan akun login penanganan pasien</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" style="background: #ffffff;">
                <form action="{{Route('dokter.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Nama Lengkap Terapis <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" required class="form-control ot-input-modern" value="{{ old('nama') }}" placeholder="Contoh: dr. Ahmad Fauzi, Sp.KFR / Sdr. Budi Santoso, S.Tr.Kes">
                        @error('nama')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    NIP / Nomor Registrasi Pegawai
                                </label>
                                <input type="text" name="nip" class="form-control ot-input-modern" value="{{ old('nip') }}" placeholder="Contoh: 198902152014021001">
                                @error('nip')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Penempatan Omah Terapiku <span class="text-danger">*</span>
                                </label>
                                <select name="poli" class="form-control ot-input-modern" required>
                                    <option value="">-- Pilih Lokasi UPT --</option>
                                    @foreach ($poli as $item)
                                        <option value="{{$item->nama}}" {{ old('poli') == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                                    @endforeach
                                </select>
                                @error('poli')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Seksi Sertifikasi STR (Surat Tanda Registrasi) -->
                    <div class="p-3 mb-3" style="background: #f8fafc; border: 1.5px solid #dbeafe; border-radius: 10px;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <label class="form-label font-w700 mb-0" style="color: #1e40af; font-size: 13px;">
                                <i class="fa-solid fa-certificate mr-1 text-primary"></i> Legalitas & Sertifikat STR Terapis
                            </label>
                            <span class="badge font-w600" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11px; padding: 3px 8px; border-radius: 6px;">
                                KTKI / Kemenkes
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                        Nomor STR Terapis
                                    </label>
                                    <input type="text" name="no_str" class="form-control ot-input-modern" value="{{ old('no_str') }}" placeholder="Contoh: 12 04 5 2 1 19-1234567" style="height: 44px; font-size: 13px;">
                                    @error('no_str')
                                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                        Masa Berlaku STR
                                    </label>
                                    <input type="text" name="masa_berlaku_str" class="form-control ot-input-modern" value="{{ old('masa_berlaku_str') }}" placeholder="Contoh: Seumur Hidup / 31 Desember 2028" style="height: 44px; font-size: 13px;">
                                    @error('masa_berlaku_str')
                                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-1">
                            <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                Upload Scan Dokumen STR
                                <span class="text-muted font-w400" style="font-size: 11px;">(PDF, JPG, PNG &bull; Maks. 5MB)</span>
                            </label>
                            <div class="ot-file-upload-box">
                                <input type="file" name="file_str" class="ot-file-upload-input" id="file_str_add" accept=".pdf,.jpg,.jpeg,.png" onchange="var fn = this.files[0] ? this.files[0].name : 'Pilih file scan dokumen STR...'; $(this).closest('.ot-file-upload-box').find('.file-label-text').text(fn); $(this).closest('.ot-file-upload-box').find('.file-label-icon').removeClass('fa-cloud-arrow-up text-primary').addClass('fa-file-circle-check text-success');">
                                <span class="text-truncate mr-2" style="font-size: 13px; color: #475569; font-weight: 500;">
                                    <i class="fa-solid fa-cloud-arrow-up mr-1 text-primary file-label-icon"></i>
                                    <span class="file-label-text">Pilih file scan dokumen STR...</span>
                                </span>
                                <span class="ot-file-btn">
                                    <i class="fa-solid fa-folder-open"></i> Browse
                                </span>
                            </div>
                            @error('file_str')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    No. HP / WhatsApp (Login) <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="no_hp" required class="form-control ot-input-modern" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890">
                                @error('no_hp')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Password Login <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password" required class="form-control ot-input-modern" placeholder="Minimal 4 karakter">
                                @error('password')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Alamat Domisili / Keterangan Spesialisasi
                        </label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat tinggal atau keterangan spesialisasi terapis..." style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top" style="margin: 0 -24px -24px -24px; padding: 14px 24px !important; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Terapis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                
                <!-- Toolbar Filter & Search Sejajar (Single-Row Inline) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700" id="totalTerapisCount">{{ number_format($datas->total(), 0, ',', '.') }}</strong> Terapis & Tenaga Medis
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form id="filterForm" method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            
                            <!-- 1. Filter Penempatan Omah Terapi -->
                            <div class="ot-filter-wrapper" style="width: 175px;">
                                <i class="fa-solid fa-hospital-user"></i>
                                <select name="poli" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Penempatan Lokasi" style="width: 100%;">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($poli as $item)
                                        <option value="{{$item->nama}}" {{ request('poli') == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 2. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 140px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Status Akun" style="width: 100%;">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
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
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Show Semua</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 190px; max-width: 230px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" id="keywordInput" name="keyword" value="{{request('keyword')}}" placeholder="Cari terapis, HP, NIP..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter (Icon-Only 38x38px) -->
                            <div id="resetButtonWrapper" style="{{ (request('keyword') || request('poli') || (request('status') !== null && request('status') !== '') || (request('per_page') && request('per_page') != '10')) ? '' : 'display: none;' }}">
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
                        <span class="mt-2 text-primary font-w600" style="font-size: 13px; letter-spacing: 0.2px;">Memuat data terapis & tenaga medis...</span>
                    </div>

                    <!-- Table Partial Content -->
                    <div id="tableContentWrapper">
                        @include('terapis.partial.table')
                    </div>
                </div>

            </div>
        </div>
    </div>
<!-- ========================================================================= -->
<!-- MODAL PREVIEW BERKAS DOKUMEN (STR & DOKUMEN MEDIS)                         -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalPreviewBerkas" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1065;">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 880px; z-index: 1066;" role="document">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #bfdbfe; box-shadow: 0 16px 45px rgba(15, 23, 42, 0.25); overflow: hidden;">
            
            <!-- Modal Header (Sesuai DESIGN.md - Clean Medical Royal Blue & Ocean Navy) -->
            <div class="modal-header d-flex justify-content-between align-items-center py-3 px-4" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: #ffffff; color: #2563eb; font-size: 19px; flex-shrink: 0; border: 1.5px solid #bfdbfe; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12);">
                        <i id="previewDocIcon" class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" id="previewDocTitle" style="color: #1e40af !important; font-size: 16px; line-height: 1.2;">Preview Berkas STR</h5>
                        <small class="text-muted" id="previewDocSubtitle" style="font-size: 11.5px;">Surat Tanda Registrasi Tenaga Medis</small>
                    </div>
                </div>

                <!-- Controls & Actions Toolbar -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <!-- Zoom & Rotate Controls (for images) -->
                    <div class="btn-group btn-group-sm" id="previewZoomControls" style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 3px; box-shadow: 0 2px 6px rgba(0,0,0,0.04); display: inline-flex; align-items: center; gap: 2px;">
                        <button type="button" class="btn btn-xs" id="btnPreviewZoomOut" title="Perkecil (-)" style="border: none; background: transparent; color: #1e40af; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.15s;" onmouseover="this.style.background='#eff6ff'; this.style.color='#2563eb';" onmouseout="this.style.background='transparent'; this.style.color='#1e40af';">
                            <i class="fa-solid fa-magnifying-glass-minus"></i>
                        </button>
                        <button type="button" class="btn btn-xs font-w700" id="btnPreviewZoomReset" title="Reset Ukuran (100%)" style="border: 1px solid #bfdbfe; background: #eff6ff; color: #1e40af; padding: 3px 8px; font-size: 11px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; min-width: 46px; transition: all 0.15s;" onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#93c5fd';" onmouseout="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe';">
                            100%
                        </button>
                        <button type="button" class="btn btn-xs" id="btnPreviewZoomIn" title="Perbesar (+)" style="border: none; background: transparent; color: #1e40af; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.15s;" onmouseover="this.style.background='#eff6ff'; this.style.color='#2563eb';" onmouseout="this.style.background='transparent'; this.style.color='#1e40af';">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                        <div style="width: 1px; height: 18px; background: #e2e8f0; margin: 0 2px;"></div>
                        <button type="button" class="btn btn-xs font-w600" id="btnPreviewRotate" title="Putar Gambar (90°)" style="border: 1px solid #bfdbfe; background: #eff6ff; color: #2563eb; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.15s;" onmouseover="this.style.background='#2563eb'; this.style.color='#ffffff'; this.style.borderColor='#2563eb';" onmouseout="this.style.background='#eff6ff'; this.style.color='#2563eb'; this.style.borderColor='#bfdbfe';">
                            <i class="fa-solid fa-rotate-right"></i>
                        </button>
                    </div>

                    <!-- Download Button -->
                    <a href="#" download id="btnPreviewDownload" class="btn btn-xs font-w700 text-white shadow-sm d-inline-flex align-items-center" title="Download Berkas" style="border-radius: 8px; padding: 6px 14px; font-size: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);">
                        <i class="fa-solid fa-download mr-1"></i> Unduh
                    </a>

                    <!-- Vertical Separator Before Close Button -->
                    <div style="width: 1.5px; height: 26px; background: #cbd5e1; margin: 0 4px;"></div>

                    <!-- Separated Distinct Close Button -->
                    <button type="button" class="btn btn-xs font-w600 d-inline-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close" title="Tutup Preview" style="width: 34px; height: 34px; border-radius: 8px; border: 1.5px solid #cbd5e1; background: #ffffff; color: #64748b; padding: 0; margin: 0 !important; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'; this.style.color='#dc2626'; this.style.borderColor='#fca5a5';" onmouseout="this.style.background='#ffffff'; this.style.color='#64748b'; this.style.borderColor='#cbd5e1';">
                        <i class="fa-solid fa-xmark" style="font-size: 15px;"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body (Viewer Canvas) -->
            <div class="modal-body p-0" style="background: #0f172a; min-height: 480px; max-height: 72vh; overflow: auto; position: relative; display: flex; align-items: center; justify-content: center;">
                
                <!-- Loading Indicator Overlay for PDF & Image Rendering -->
                <div id="previewLoadingIndicator" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: #0f172a; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #ffffff; gap: 14px;">
                    <div class="spinner-border text-primary" role="status" style="width: 2.8rem; height: 2.8rem; border-width: 3px;">
                        <span class="sr-only">Memuat...</span>
                    </div>
                    <div style="font-size: 13px; font-weight: 600; color: #cbd5e1; letter-spacing: 0.3px;">
                        <i class="fa-solid fa-circle-notch fa-spin text-primary mr-1"></i> <span id="previewLoadingText">Memuat dokumen STR...</span>
                    </div>
                </div>

                <!-- Image View Surface -->
                <div id="previewImageWrapper" style="width: 100%; height: 100%; min-height: 480px; display: flex; align-items: center; justify-content: center; overflow: auto; padding: 24px; user-select: none; cursor: grab;">
                    <img id="previewImageElement" src="" alt="Berkas Preview" style="max-width: 100%; max-height: 65vh; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.6); transition: transform 0.2s ease-out; transform-origin: center center;" />
                </div>

                <!-- PDF / Iframe View Surface -->
                <div id="previewPdfWrapper" style="width: 100%; height: 68vh; display: none; position: relative; width: 100%;">
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
                        <span class="badge badge-light border text-muted font-w600" style="font-size: 11px; padding: 4px 8px; border-radius: 5px;">
                            <i class="fa-solid fa-certificate text-primary mr-1"></i> Dokumen Legalitas STR Terapis Terverifikasi
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap: 8px;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 6px 18px; font-size: 12.5px; color: #475569;">
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

        // Preview Berkas STR State
        var currentZoom = 1;
        var currentRotation = 0;

        function updateImageTransform() {
            $('#previewImageElement').css('transform', 'scale(' + currentZoom + ') rotate(' + currentRotation + 'deg)');
            $('#btnPreviewZoomReset').text(Math.round(currentZoom * 100) + '%');
        }

        $(document).on('click', '.btn-open-preview-berkas', function(e) {
            e.preventDefault();
            var btn = $(this);
            var docType = btn.data('type') || 'str';
            var docTitle = btn.data('title') || 'Berkas Dokumen STR';
            var docUrl = btn.data('url');
            var docFileName = btn.data('filename') || 'Dokumen_STR';

            currentZoom = 1;
            currentRotation = 0;
            updateImageTransform();

            $('#previewDocTitle').text(docTitle);
            $('#previewDocFileName').text(docFileName);
            $('#btnPreviewDownload').attr('href', docUrl).attr('download', docFileName);

            var isPdf = docUrl && (docUrl.toLowerCase().indexOf('.pdf') !== -1 || docFileName.toLowerCase().indexOf('.pdf') !== -1);

            $('#previewLoadingIndicator').show();

            if (isPdf) {
                $('#previewLoadingText').text('Memuat dokumen PDF STR...');
                $('#previewZoomControls').hide();
                $('#previewImageWrapper').hide();
                $('#previewPdfWrapper').show();

                $('#previewPdfElement').off('load').on('load', function() {
                    $('#previewLoadingIndicator').fadeOut(200);
                });
                $('#previewPdfElement').attr('src', docUrl);

                setTimeout(function() {
                    $('#previewLoadingIndicator').fadeOut(200);
                }, 1200);
            } else {
                $('#previewLoadingText').text('Memuat scan gambar STR...');
                $('#previewZoomControls').show();
                $('#previewPdfWrapper').hide();
                $('#previewImageWrapper').show();

                $('#previewImageElement').off('load').on('load', function() {
                    $('#previewLoadingIndicator').fadeOut(200);
                });
                $('#previewImageElement').attr('src', docUrl);

                setTimeout(function() {
                    $('#previewLoadingIndicator').fadeOut(200);
                }, 1000);
            }

            $('#modalPreviewBerkas').modal('show');
        });

        // Zoom & Rotate Controls
        $(document).on('click', '#btnPreviewZoomIn', function() {
            if (currentZoom < 4) {
                currentZoom = Math.min(4, Math.round((currentZoom + 0.25) * 100) / 100);
                updateImageTransform();
            }
        });

        $(document).on('click', '#btnPreviewZoomOut', function() {
            if (currentZoom > 0.4) {
                currentZoom = Math.max(0.4, Math.round((currentZoom - 0.25) * 100) / 100);
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

        // Mouse Wheel Zoom on image canvas
        $('#previewImageWrapper').on('wheel', function(e) {
            e.preventDefault();
            if (e.originalEvent.deltaY < 0) {
                if (currentZoom < 4) {
                    currentZoom = Math.min(4, Math.round((currentZoom + 0.15) * 100) / 100);
                    updateImageTransform();
                }
            } else {
                if (currentZoom > 0.4) {
                    currentZoom = Math.max(0.4, Math.round((currentZoom - 0.15) * 100) / 100);
                    updateImageTransform();
                }
            }
        });

        // Double click to reset zoom
        $('#previewImageWrapper').on('dblclick', function(e) {
            currentZoom = 1;
            currentRotation = 0;
            updateImageTransform();
        });

        // Fix modal scroll when preview modal is closed while another modal is still open
        $('#modalPreviewBerkas').on('hidden.bs.modal', function () {
            if ($('.modal.show').length > 0) {
                $('body').addClass('modal-open');
            }
        });

        // Function to fetch Terapis data via AJAX
        function fetchTerapisData(page = 1, updateUrl = true) {
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

            // Filter out default params for clean URL query
            let cleanParams = $.param(formData.filter(item => item.value !== '' && !(item.name === 'per_page' && item.value === '10') && !(item.name === 'page' && item.value == '1')));
            let targetUrl = "{{ Route('terapis') }}" + (cleanParams ? '?' + cleanParams : '');

            if (currentAjax) {
                currentAjax.abort();
            }

            // Show loading overlay
            $('#tableLoadingOverlay').removeClass('d-none').addClass('d-flex');

            currentAjax = $.ajax({
                url: "{{ Route('terapis') }}",
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    $('#tableContentWrapper').html(res.html);
                    
                    // Update total count
                    if (res.total !== undefined) {
                        let formattedTotal = new Intl.NumberFormat('id-ID').format(res.total);
                        $('#totalTerapisCount').text(formattedTotal);
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
                fetchTerapisData(1);
            }, 350);
        });

        // 2. Submit form on Enter or Search Button
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            clearTimeout(searchDebounceTimer);
            fetchTerapisData(1);
        });

        // 3. Trigger fetch on filter select changes
        $('.filter-select').on('change', function () {
            fetchTerapisData(1);
        });

        // 4. Reset Filter Button click
        $(document).on('click', '#btnResetFilter', function (e) {
            e.preventDefault();
            $('#filterForm select[name="poli"]').val('');
            $('#filterForm select[name="status"]').val('');
            $('#filterForm select[name="per_page"]').val('10');
            $('#keywordInput').val('');
            fetchTerapisData(1);
        });

        // 5. Intercept pagination link clicks
        $(document).on('click', '#tableDataContainer .pagination a', function (e) {
            e.preventDefault();
            let href = $(this).attr('href');
            if (href) {
                let urlObj = new URL(href, window.location.origin);
                let page = urlObj.searchParams.get('page') || 1;
                fetchTerapisData(page);

                // Smooth scroll to top of table
                $('html, body').animate({
                    scrollTop: $('#tableDataContainer').offset().top - 100
                }, 300);
            }
        });

        // 6. Handle browser Back/Forward (popstate)
        window.addEventListener('popstate', function () {
            let params = new URLSearchParams(window.location.search);
            $('#filterForm select[name="poli"]').val(params.get('poli') || '');
            $('#filterForm select[name="status"]').val(params.get('status') || '');
            $('#filterForm select[name="per_page"]').val(params.get('per_page') || '10');
            $('#keywordInput').val(params.get('keyword') || '');
            let page = params.get('page') || 1;
            fetchTerapisData(page, false);
        });

        // 7. Delete Button Confirmation (Event Delegation)
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');

            Swal.fire({
                title: 'Hapus / Nonaktifkan Terapis?',
                text: "Yakin ingin menghapus atau menonaktifkan terapis: " + name + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    window.location = link;
                }
            });
        });
    });
</script>
@endsection

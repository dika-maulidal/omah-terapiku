@extends('layout.apps')

@section('style')
<style>
    .focus-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .terapis-check-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        background: #ffffff;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .terapis-check-card:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .terapis-check-card input[type="checkbox"]:checked + label {
        color: #1e40af;
        font-weight: 700;
    }
    .ot-sticky-col-right {
        position: sticky;
        right: 0;
        background: #ffffff;
        z-index: 2;
        box-shadow: -4px 0 8px rgba(0, 0, 0, 0.04);
    }
    .table thead th.ot-sticky-col-right {
        background: #f8fafc;
        z-index: 3;
    }
    .quick-tag-btn {
        font-size: 11px;
        padding: 3px 9px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.15s ease;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
    }
    .quick-tag-btn:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
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
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Master Data Omah Terapi-KU</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item active text-muted">Omah Terapi-KU (UPT)</li>
                    </ol>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary font-w700 shadow-sm" data-toggle="modal" data-target="#addUptModal" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-circle-plus mr-1"></i> + Tambah UPT Baru
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                
                <!-- Toolbar Filter & Search Sejajar (Single-Row Inline) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700">{{ $datas->total() }}</strong> Unit Omah Terapi-KU
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            
                            <!-- 1. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 140px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Status Operasional" style="width: 100%;">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>

                            <!-- 2. Filter Fokus Layanan -->
                            <div class="ot-filter-wrapper" style="width: 180px;">
                                <i class="fa-solid fa-tag"></i>
                                <select name="fokus" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Fokus Layanan" style="width: 100%;">
                                    <option value="">Semua Fokus</option>
                                    <option value="ABK" {{ request('fokus') == 'ABK' ? 'selected' : '' }}>Anak (ABK)</option>
                                    <option value="ODGJ" {{ request('fokus') == 'ODGJ' ? 'selected' : '' }}>Dewasa / Stroke / ODGJ</option>
                                    <option value="Netra" {{ request('fokus') == 'Netra' ? 'selected' : '' }}>Netra & Olahraga</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 185px; max-width: 220px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" name="keyword" value="{{request('keyword')}}" placeholder="Cari UPT, alamat..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            @if(request('keyword') || request('status') !== null || request('fokus'))
                                <a href="{{ Route('omahterapiku') }}" class="btn btn-sm btn-light font-w600" style="height: 38px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 12px; transition: all 0.2s ease;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right mr-1" style="color: #64748b;"></i> Reset
                                </a>
                            @endif

                        </form>
                    </div>
                </div>

                <!-- Tabel Utama Master Data UPT -->
                <div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;"> 
                    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 1000px; width: 100%;">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 12px 14px; width: 45px; text-align: center;">#</th>
                                <th style="padding: 12px 14px; min-width: 220px;">Nama UPT / Lokasi</th>
                                <th style="padding: 12px 14px; min-width: 230px;">Alamat</th>
                                <th style="padding: 12px 14px; min-width: 180px;">Fokus Layanan</th>
                                <th style="padding: 12px 14px; width: 110px; text-align: center;">Terapis</th>
                                <th style="padding: 12px 14px; width: 110px; text-align: center;">Status</th>
                                <th style="padding: 12px 14px; width: 130px; text-align: center; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($datas) > 0)
                                @foreach ($datas as $key => $row)
                                    @php
                                        $fokus = $row->fokus_layanan;
                                        if (!$fokus) {
                                            if (str_contains($row->nama, 'PPSAB')) {
                                                $fokus = 'Anak (ABK)';
                                            } elseif (str_contains($row->nama, 'PMKS')) {
                                                $fokus = 'Dewasa, ODGJ, Stroke';
                                            } elseif (str_contains($row->nama, 'RSBN')) {
                                                $fokus = 'Disabilitas Netra & Olahraga';
                                            } else {
                                                $fokus = 'Pelayanan Terapi Terpadu';
                                            }
                                        }

                                        // Badge color based on focus
                                        if (str_contains($fokus, 'ABK') || str_contains($fokus, 'Anak')) {
                                            $badgeStyle = 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;';
                                        } elseif (str_contains($fokus, 'ODGJ') || str_contains($fokus, 'Stroke')) {
                                            $badgeStyle = 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;';
                                        } elseif (str_contains($fokus, 'Netra') || str_contains($fokus, 'Olahraga')) {
                                            $badgeStyle = 'background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;';
                                        } else {
                                            $badgeStyle = 'background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0;';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center font-w600 text-muted" style="vertical-align: middle;">
                                            {{ $datas->firstItem() + $key }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;">
                                                    <i class="fa-solid fa-hospital"></i>
                                                </div>
                                                <div>
                                                    <strong class="text-dark d-block" style="font-size: 13.5px; font-weight: 700;">
                                                        {{ $row->nama }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span style="color: #475569; font-size: 12.5px;">
                                                <i class="fa-solid fa-location-dot text-muted mr-1" style="font-size: 11px;"></i> {{ $row->alamat ?: '-' }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span class="focus-badge" style="{{ $badgeStyle }}">
                                                <i class="fa-solid fa-tag mr-1" style="font-size: 10px;"></i> {{ $fokus }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <span class="badge font-w700" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                <i class="fa-solid fa-user-doctor mr-1"></i> {{ $row->terapis->count() }} Terapis
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            @if($row->status == 1)
                                                <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                    <i class="fa-solid fa-circle mr-1" style="font-size: 7px; color: #10b981;"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                                    <i class="fa-solid fa-circle mr-1" style="font-size: 7px; color: #ef4444;"></i> Non-Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle; text-align: center; white-space: nowrap; position: sticky; right: 0; background: #fff; z-index: 1; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">
                                            <div class="btn-group" role="group" style="gap: 4px;">
                                                <!-- Tombol Detail -->
                                                <button type="button" class="btn btn-xs font-w600" data-toggle="modal" data-target="#detailModal{{ $row->id }}" style="padding: 5px 9px; font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;" title="Lihat Detail UPT">
                                                    <i class="fa-solid fa-eye mr-1"></i> Detail
                                                </button>
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-xs font-w600" data-toggle="modal" data-target="#editModal{{ $row->id }}" style="padding: 5px 9px; font-size: 11.5px; border-radius: 6px; background: #fef3c7; color: #d97706; border: 1px solid #fde68a;" title="Edit UPT">
                                                    <i class="fa-solid fa-pencil mr-1"></i> Edit
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <a href="#" class="btn btn-xs font-w600 delete" r-link="{{ Route('omahterapiku.delete', $row->id) }}" r-name="{{ $row->nama }}" r-id="{{ $row->id }}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" title="Hapus UPT">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>

                                            <!-- ========================================================= -->
                                            <!-- MODAL DETAIL UPT (SHOW) -->
                                            <!-- ========================================================= -->
                                            <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        
                                                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); padding: 16px 20px;">
                                                            <div>
                                                                <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                                                                    <i class="fa-solid fa-hospital mr-2"></i> Detail Omah Terapi-KU
                                                                </h5>
                                                                <small class="text-white-50">Informasi Unit Pelaksana Teknis & Tenaga Terapis</small>
                                                            </div>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body p-4 text-left" style="background: #f8fafc;">
                                                            
                                                            <!-- 1. Informasi UPT -->
                                                            <div class="card border-0 shadow-xs mb-3" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                                                                <div class="card-header py-2 px-3 bg-white border-bottom">
                                                                    <strong class="text-dark" style="font-size: 13px;">
                                                                        <i class="fa-solid fa-building text-primary mr-1"></i> 1. Informasi UPT
                                                                    </strong>
                                                                </div>
                                                                <div class="card-body p-3">
                                                                    <div class="mb-2">
                                                                        <small class="text-muted d-block font-w600" style="font-size: 11px;">Nama UPT:</small>
                                                                        <strong class="text-dark" style="font-size: 14px;">{{ $row->nama }}</strong>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <small class="text-muted d-block font-w600" style="font-size: 11px;">Alamat Lengkap:</small>
                                                                        <span class="text-dark" style="font-size: 13px;">{{ $row->alamat ?: '-' }}</span>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <small class="text-muted d-block font-w600" style="font-size: 11px;">Fokus Layanan:</small>
                                                                        <span class="focus-badge mt-1" style="{{ $badgeStyle }}">
                                                                            <i class="fa-solid fa-tag mr-1"></i> {{ $fokus }}
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <small class="text-muted d-block font-w600" style="font-size: 11px;">Status Operasional:</small>
                                                                        <span class="font-w700 {{ $row->status == 1 ? 'text-success' : 'text-danger' }}" style="font-size: 12.5px;">
                                                                            ● {{ $row->status_display() }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- 2. Daftar Terapis Bertugas -->
                                                            <div class="card border-0 shadow-xs mb-0" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                                                                <div class="card-header py-2 px-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                                                                    <strong class="text-dark" style="font-size: 13px;">
                                                                        <i class="fa-solid fa-user-doctor text-primary mr-1"></i> 2. Tenaga Terapis di UPT Ini
                                                                    </strong>
                                                                    <span class="badge badge-primary font-w600" style="font-size: 11px;">
                                                                        {{ $row->terapis->count() }} Terapis
                                                                    </span>
                                                                </div>
                                                                <div class="card-body p-3">
                                                                    @if($row->terapis->count() > 0)
                                                                        <div class="d-flex flex-column" style="gap: 8px;">
                                                                            @foreach($row->terapis as $terapis)
                                                                                <div class="d-flex align-items-center justify-content-between p-2 rounded bg-white border">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="avatar-sm d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px; border-radius: 50%; background: #2563eb; color: #fff; font-weight: 700; font-size: 13px;">
                                                                                            {{ strtoupper(substr($terapis->nama, 0, 1)) }}
                                                                                        </div>
                                                                                        <div>
                                                                                            <strong class="text-dark d-block" style="font-size: 13px;">{{ $terapis->nama }}</strong>
                                                                                            <small class="text-muted">{{ $terapis->no_hp ? 'Telp: ' . $terapis->no_hp : 'Terapis Klinis' }}</small>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span class="badge badge-success light font-w600" style="font-size: 10.5px;">Aktif</span>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <div class="text-center py-3 text-muted">
                                                                            <i class="fa-solid fa-user-slash mb-1" style="font-size: 20px; opacity: 0.5;"></i>
                                                                            <p class="mb-0" style="font-size: 12px;">Belum ada terapis yang ditugaskan di UPT ini.</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer py-2 px-3 bg-light d-flex justify-content-between align-items-center">
                                                            <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                                                                Tutup
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-warning font-w700 text-white" data-dismiss="modal" data-toggle="modal" data-target="#editModal{{ $row->id }}" style="font-size: 12.5px; border-radius: 8px;">
                                                                <i class="fa-solid fa-pencil mr-1"></i> Edit Data UPT
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ========================================================= -->
                                            <!-- MODAL FORM EDIT UPT -->
                                            <!-- ========================================================= -->
                                            <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        
                                                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); padding: 16px 20px;">
                                                            <div>
                                                                <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                                                                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Omah Terapi-KU
                                                                </h5>
                                                                <small class="text-white-50">Kelola informasi lokasi, fokus layanan, dan penugasan terapis</small>
                                                            </div>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body p-4 text-left" style="background: #ffffff;">
                                                            <form action="{{ Route('omahterapiku.update', $row->id) }}" method="POST">
                                                                {{ csrf_field() }}

                                                                <!-- 1. Nama UPT -->
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        Nama UPT / Lokasi <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text" name="nama" value="{{ $row->nama }}" required class="form-control" placeholder="Contoh: UPT PPSAB Sidoarjo" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                </div>

                                                                <!-- 2. Alamat Lengkap -->
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        Alamat Lengkap
                                                                    </label>
                                                                    <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo..." style="font-size: 13px; border-radius: 8px;">{{ $row->alamat }}</textarea>
                                                                </div>

                                                                <!-- 3. Fokus Layanan -->
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        Fokus Layanan Utama
                                                                    </label>
                                                                    <input type="text" name="fokus_layanan" id="fokusEditInput{{ $row->id }}" value="{{ $row->fokus_layanan ?: $fokus }}" class="form-control mb-2" placeholder="Contoh: Anak Berkebutuhan Khusus (ABK)" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                    
                                                                    <div class="d-flex flex-wrap" style="gap: 5px;">
                                                                        <button type="button" class="quick-tag-btn" onclick="$('#fokusEditInput{{ $row->id }}').val('Anak Berkebutuhan Khusus (ABK)')">
                                                                            + ABK
                                                                        </button>
                                                                        <button type="button" class="quick-tag-btn" onclick="$('#fokusEditInput{{ $row->id }}').val('Dewasa, Lansia, ODGJ, Pasca-Stroke')">
                                                                            + Dewasa / ODGJ / Stroke
                                                                        </button>
                                                                        <button type="button" class="quick-tag-btn" onclick="$('#fokusEditInput{{ $row->id }}').val('Disabilitas Netra & Olahraga')">
                                                                            + Netra & Olahraga
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <!-- 4. Pilih Terapis Bertugas -->
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1 d-block" style="font-size: 13px;">
                                                                        Pilih Terapis Bertugas di UPT Ini:
                                                                    </label>
                                                                    <div class="p-2 bg-light rounded border" style="max-height: 160px; overflow-y: auto;">
                                                                        @if(isset($allTerapis) && count($allTerapis) > 0)
                                                                            @foreach($allTerapis as $terapisOpt)
                                                                                @php
                                                                                    $isAssigned = ($terapisOpt->poli === $row->nama);
                                                                                @endphp
                                                                                <div class="terapis-check-card mb-1">
                                                                                    <div class="custom-control custom-checkbox w-100">
                                                                                        <input type="checkbox" name="terapis_ids[]" value="{{ $terapisOpt->id }}" class="custom-control-input" id="tEdit_{{ $row->id }}_{{ $terapisOpt->id }}" {{ $isAssigned ? 'checked' : '' }}>
                                                                                        <label class="custom-control-label font-w600 text-dark d-flex justify-content-between align-items-center" for="tEdit_{{ $row->id }}_{{ $terapisOpt->id }}" style="cursor: pointer; font-size: 12.5px;">
                                                                                            <span>👨‍⚕️ {{ $terapisOpt->nama }}</span>
                                                                                            @if($terapisOpt->poli && $terapisOpt->poli !== $row->nama)
                                                                                                <small class="text-muted" style="font-size: 10.5px;">(Saat ini di {{ $terapisOpt->poli }})</small>
                                                                                            @endif
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <small class="text-muted">Tidak ada data master terapis aktif.</small>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <!-- 5. Status (Radio Button) -->
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1 d-block" style="font-size: 13px;">
                                                                        Status Operasional:
                                                                    </label>
                                                                    <div class="d-flex align-items-center" style="gap: 20px;">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" id="statusAktif_{{ $row->id }}" name="status" value="1" class="custom-control-input" {{ $row->status == 1 ? 'checked' : '' }}>
                                                                            <label class="custom-control-label font-w600 text-success" for="statusAktif_{{ $row->id }}" style="cursor: pointer; font-size: 13px;">
                                                                                <i class="fa-solid fa-circle text-success mr-1" style="font-size: 8px;"></i> Aktif
                                                                            </label>
                                                                        </div>
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" id="statusNon_{{ $row->id }}" name="status" value="0" class="custom-control-input" {{ $row->status == 0 ? 'checked' : '' }}>
                                                                            <label class="custom-control-label font-w600 text-danger" for="statusNon_{{ $row->id }}" style="cursor: pointer; font-size: 13px;">
                                                                                <i class="fa-solid fa-circle text-danger mr-1" style="font-size: 8px;"></i> Non-Aktif
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
                                                                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 22px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                                                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-2" style="width: 50px; height: 50px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 22px;">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </div>
                                            <strong class="text-dark mb-1" style="font-size: 14px;">Tidak ada data Omah Terapi-KU</strong>
                                            <p class="mb-0 text-muted" style="font-size: 12.5px;">Coba ubah kata kunci pencarian atau reset filter untuk melihat data lainnya.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="d-flex justify-content-between align-items-center flex-wrap pt-3 mt-2" style="font-size: 12.5px;">
                    <div class="text-muted mb-2 mb-md-0">
                        Menampilkan <strong class="text-dark">{{ $datas->firstItem() ?? 0 }}</strong> - <strong class="text-dark">{{ $datas->firstItem() ? ($datas->firstItem() + count($datas) - 1) : 0 }}</strong> dari <strong class="text-dark">{{ $datas->total() }}</strong> unit UPT
                    </div>
                    <div>
                        {{ $datas->appends(request()->except('page'))->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ============================================================= -->
<!-- MODAL TAMBAH UPT BARU -->
<!-- ============================================================= -->
<div class="modal fade" id="addUptModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); padding: 16px 20px;">
                <div>
                    <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                        <i class="fa-solid fa-hospital-user mr-2"></i> Tambah Omah Terapi-KU Baru
                    </h5>
                    <small class="text-white-50">Daftarkan lokasi UPT / Balai pelayanan terapi baru</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" style="background: #ffffff;">
                <form action="{{ Route('omahterapiku.store') }}" method="POST">
                    {{ csrf_field() }}

                    <!-- 1. Nama UPT -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Nama UPT / Lokasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" required class="form-control" placeholder="Contoh: UPT PPSAB Sidoarjo" style="height: 42px; font-size: 13px; border-radius: 8px;">
                    </div>

                    <!-- 2. Alamat Lengkap -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Alamat Lengkap
                        </label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo..." style="font-size: 13px; border-radius: 8px;"></textarea>
                    </div>

                    <!-- 3. Fokus Layanan -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Fokus Layanan Utama
                        </label>
                        <input type="text" name="fokus_layanan" id="fokusAddInput" class="form-control mb-2" placeholder="Contoh: Anak Berkebutuhan Khusus (ABK)" style="height: 42px; font-size: 13px; border-radius: 8px;">
                        <div class="d-flex flex-wrap" style="gap: 5px;">
                            <button type="button" class="quick-tag-btn" onclick="$('#fokusAddInput').val('Anak Berkebutuhan Khusus (ABK)')">
                                + ABK
                            </button>
                            <button type="button" class="quick-tag-btn" onclick="$('#fokusAddInput').val('Dewasa, Lansia, ODGJ, Pasca-Stroke')">
                                + Dewasa / ODGJ / Stroke
                            </button>
                            <button type="button" class="quick-tag-btn" onclick="$('#fokusAddInput').val('Disabilitas Netra & Olahraga')">
                                + Netra & Olahraga
                            </button>
                        </div>
                    </div>

                    <!-- 4. Pilih Terapis Bertugas -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1 d-block" style="font-size: 13px;">
                            Pilih Terapis Bertugas di UPT Ini:
                        </label>
                        <div class="p-2 bg-light rounded border" style="max-height: 160px; overflow-y: auto;">
                            @if(isset($allTerapis) && count($allTerapis) > 0)
                                @foreach($allTerapis as $terapisOpt)
                                    <div class="terapis-check-card mb-1">
                                        <div class="custom-control custom-checkbox w-100">
                                            <input type="checkbox" name="terapis_ids[]" value="{{ $terapisOpt->id }}" class="custom-control-input" id="tAdd_{{ $terapisOpt->id }}">
                                            <label class="custom-control-label font-w600 text-dark d-flex justify-content-between align-items-center" for="tAdd_{{ $terapisOpt->id }}" style="cursor: pointer; font-size: 12.5px;">
                                                <span>👨‍⚕️ {{ $terapisOpt->nama }}</span>
                                                @if($terapisOpt->poli)
                                                    <small class="text-muted" style="font-size: 10.5px;">(Di {{ $terapisOpt->poli }})</small>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <small class="text-muted">Tidak ada data master terapis aktif.</small>
                            @endif
                        </div>
                    </div>

                    <!-- 5. Status (Radio Button) -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1 d-block" style="font-size: 13px;">
                            Status Operasional:
                        </label>
                        <div class="d-flex align-items-center" style="gap: 20px;">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="statusAddAktif" name="status" value="1" class="custom-control-input" checked>
                                <label class="custom-control-label font-w600 text-success" for="statusAddAktif" style="cursor: pointer; font-size: 13px;">
                                    <i class="fa-solid fa-circle text-success mr-1" style="font-size: 8px;"></i> Aktif
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="statusAddNon" name="status" value="0" class="custom-control-input">
                                <label class="custom-control-label font-w600 text-danger" for="statusAddNon" style="cursor: pointer; font-size: 13px;">
                                    <i class="fa-solid fa-circle text-danger mr-1" style="font-size: 8px;"></i> Non-Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 22px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        $(".delete").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');

            Swal.fire({
                title: 'Hapus Omah Terapi-KU?',
                text: "Yakin ingin menghapus unit UPT: " + name + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Hapus!',
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

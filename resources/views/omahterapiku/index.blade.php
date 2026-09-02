@extends('layout.apps')

@section('style')
<style>
    .focus-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        background: #eef4ff;
        color: #2D4B7A;
        border: 1px solid #d0e1fd;
    }
    .terapis-check-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        background: #f8fafc;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .terapis-check-card:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
</style>
@endsection

@section('content')

<!-- Header Section -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap: 12px;">
    <div>
        <h2 class="font-w700 text-primary mb-1" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">
            <i class="fa-solid fa-hospital-user mr-2 text-primary"></i> Master Data Omah Terapi-KU
        </h2>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 2px; font-size: 12.5px;">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Master Data</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Omah Terapiku (UPT)</a></li>
        </ol>
    </div>
    <div class="d-flex align-items-center" style="gap: 8px;">
        <button type="button" class="btn btn-sm btn-primary font-w600 shadow-sm" data-toggle="modal" data-target="#addUptModal" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px;">
            <i class="fa-solid fa-circle-plus mr-1"></i> + Tambah UPT Baru
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-body p-4">
                
                <!-- Toolbar Pencarian -->
                <div class="row mb-3 align-items-center">
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                        <p class="text-muted mb-0" style="font-size: 13px;">
                            Daftar unit pelaksana teknis (UPT) & balai pelayanan Omah Terapi-KU di lingkungan Dinas Sosial Provinsi Jawa Timur.
                        </p>
                    </div>

                    <div class="col-md-6 col-12">
                        <form method="get" action="{{ url()->current() }}">
                            <div class="d-flex align-items-center justify-content-md-end flex-wrap" style="gap: 6px;">
                                <div class="input-group" style="max-width: 300px;">
                                    <input type="text" class="form-control form-control-sm" name="keyword" value="{{ request('keyword') }}" placeholder="Cari UPT, alamat, atau fokus..." autocomplete="off" style="height: 38px; font-size: 12.5px;">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary btn-sm" style="height: 38px; padding: 0 14px;">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>

                                @if(request('keyword'))
                                    <a href="{{ Route('omahterapiku') }}" class="btn btn-sm btn-light" style="height: 38px; display: inline-flex; align-items: center; justify-content: center; padding: 0 12px; border: 1px solid #e2e8f0;" title="Reset Filter">
                                        <i class="fa-solid fa-rotate-right"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Utama Master Data UPT -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="border-collapse: collapse; font-size: 13px;">
                        <thead class="bg-light">
                            <tr style="color: #1e293b; font-size: 12.5px;">
                                <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                <th style="width: 25%; vertical-align: middle;">Nama UPT / Lokasi</th>
                                <th style="width: 26%; vertical-align: middle;">Alamat</th>
                                <th style="width: 20%; vertical-align: middle;">Fokus Layanan</th>
                                <th style="width: 11%; text-align: center; vertical-align: middle;">Total Terapis</th>
                                <th style="width: 9%; text-align: center; vertical-align: middle;">Status</th>
                                <th style="width: 15%; text-align: center; vertical-align: middle;">Aksi</th>
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
                                        $focusClass = 'focus-badge';
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
                                        <td class="text-center font-w600" style="vertical-align: middle;">
                                            {{ $datas->firstItem() + $key }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <strong class="text-dark d-block" style="font-size: 13.5px;">
                                                <i class="fa-solid fa-hospital text-primary mr-1"></i> {{ $row->nama }}
                                            </strong>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span style="color: #475569; font-size: 12.5px;">{{ $row->alamat ?: '-' }}</span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span class="focus-badge" style="{{ $badgeStyle }}">
                                                <i class="fa-solid fa-tag mr-1"></i> {{ $fokus }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <span class="badge badge-light border text-primary font-w700" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px;">
                                                <i class="fa-solid fa-user-doctor mr-1"></i> {{ $row->terapis->count() }} Terapis
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            @if($row->status == 1)
                                                <span class="badge badge-success light font-w600" style="font-size: 11px; padding: 4px 8px;">
                                                    <i class="fa-solid fa-circle text-success mr-1" style="font-size: 8px;"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge badge-danger light font-w600" style="font-size: 11px; padding: 4px 8px;">
                                                    <i class="fa-solid fa-circle text-danger mr-1" style="font-size: 8px;"></i> Non-Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle; text-align: center; white-space: nowrap;">
                                            <div class="btn-group" role="group" style="gap: 4px;">
                                                <!-- Tombol Detail -->
                                                <button type="button" class="btn btn-xs btn-info font-w600 text-white shadow-xs" data-toggle="modal" data-target="#detailModal{{ $row->id }}" style="padding: 5px 10px; font-size: 11.5px; border-radius: 5px;">
                                                    <i class="fa-solid fa-eye mr-1"></i> Detail
                                                </button>
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-xs btn-warning font-w600 text-white shadow-xs" data-toggle="modal" data-target="#editModal{{ $row->id }}" style="padding: 5px 10px; font-size: 11.5px; border-radius: 5px;">
                                                    <i class="fa-solid fa-pencil mr-1"></i> Edit
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <a href="#" class="btn btn-xs btn-outline-danger font-w600 delete" r-link="{{ Route('omahterapiku.delete', $row->id) }}" r-name="{{ $row->nama }}" r-id="{{ $row->id }}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 5px;" title="Hapus UPT">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>

                                            <!-- ========================================================= -->
                                            <!-- MODAL DETAIL UPT (SHOW) -->
                                            <!-- ========================================================= -->
                                            <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        
                                                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #2D4B7A 0%, #1e355b 100%); padding: 14px 20px;">
                                                            <div>
                                                                <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                                                                    <i class="fa-solid fa-hospital mr-2"></i> Detail Omah Terapi-KU
                                                                </h5>
                                                                <small class="text-white-50">Informasi Unit Pelaksana Teknis & Tenaga Terapis</small>
                                                            </div>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.85;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body p-4 text-left" style="background: #f8fafc;">
                                                            
                                                            <!-- 1. Informasi UPT -->
                                                            <div class="card border-0 shadow-xs mb-3" style="border-radius: 8px;">
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
                                                                        <small class="text-muted d-block font-w600" style="font-size: 11px;">Fokus Utama:</small>
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
                                                            <div class="card border-0 shadow-xs mb-0" style="border-radius: 8px;">
                                                                <div class="card-header py-2 px-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                                                                    <strong class="text-dark" style="font-size: 13px;">
                                                                        <i class="fa-solid fa-user-doctor text-primary mr-1"></i> 2. Daftar Terapis Bertugas di UPT Ini
                                                                    </strong>
                                                                    <span class="badge badge-primary font-w600" style="font-size: 11px;">
                                                                        {{ $row->terapis->count() }} Terapis
                                                                    </span>
                                                                </div>
                                                                <div class="card-body p-3">
                                                                    @if($row->terapis->count() > 0)
                                                                        <div class="d-flex flex-column" style="gap: 8px;">
                                                                            @foreach($row->terapis as $terapis)
                                                                                <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light border">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="avatar-sm d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px; border-radius: 50%; background: #2D4B7A; color: #fff; font-weight: 700; font-size: 13px;">
                                                                                            {{ strtoupper(substr($terapis->nama, 0, 1)) }}
                                                                                        </div>
                                                                                        <div>
                                                                                            <strong class="text-dark d-block" style="font-size: 13px;">{{ $terapis->nama }}</strong>
                                                                                            <small class="text-muted">{{ $terapis->no_hp ? 'Telp: ' . $terapis->no_hp : 'Terapis Klinis' }}</small>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span class="badge badge-success light font-w600" style="font-size: 10.5px;">Aktif Bertugas</span>
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
                                                            <button type="button" class="btn btn-sm btn-secondary font-w600" data-dismiss="modal" style="font-size: 12px; border-radius: 6px;">
                                                                Tutup
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-warning font-w600 text-white" data-dismiss="modal" data-toggle="modal" data-target="#editModal{{ $row->id }}" style="font-size: 12px; border-radius: 6px;">
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
                                                        
                                                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #2D4B7A 0%, #1e355b 100%); padding: 14px 20px;">
                                                            <div>
                                                                <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                                                                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Omah Terapi-KU
                                                                </h5>
                                                                <small class="text-white-50">Kelola informasi lokasi, fokus layanan, dan penugasan terapis</small>
                                                            </div>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.85;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body p-4 text-left" style="background: #f8fafc;">
                                                            <form action="{{ Route('omahterapiku.update', $row->id) }}" method="POST">
                                                                {{ csrf_field() }}

                                                                <!-- 1. Nama UPT -->
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                                                                        Nama UPT / Lokasi <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text" name="nama" value="{{ $row->nama }}" required class="form-control" placeholder="Contoh: UPT PPSAB Sidoarjo" style="height: 40px; font-size: 13px;">
                                                                </div>

                                                                <!-- 2. Alamat Lengkap -->
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                                                                        Alamat Lengkap
                                                                    </label>
                                                                    <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo..." style="font-size: 13px;">{{ $row->alamat }}</textarea>
                                                                </div>

                                                                <!-- 3. Fokus Layanan -->
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                                                                        Fokus Layanan <small class="text-muted font-w400">(Sesuai CONTEXT.md)</small>
                                                                    </label>
                                                                    <input type="text" name="fokus_layanan" id="fokusEditInput{{ $row->id }}" value="{{ $row->fokus_layanan ?: $fokus }}" class="form-control mb-2" placeholder="Contoh: Anak Berkebutuhan Khusus (ABK)" style="height: 40px; font-size: 13px;">
                                                                    
                                                                    <div class="d-flex flex-wrap" style="gap: 5px;">
                                                                        <button type="button" class="btn btn-xs btn-outline-primary" style="font-size: 11px; padding: 2px 8px; border-radius: 4px;" onclick="$('#fokusEditInput{{ $row->id }}').val('Anak Berkebutuhan Khusus (ABK)')">
                                                                            + ABK
                                                                        </button>
                                                                        <button type="button" class="btn btn-xs btn-outline-warning" style="font-size: 11px; padding: 2px 8px; border-radius: 4px;" onclick="$('#fokusEditInput{{ $row->id }}').val('Dewasa, Lansia, ODGJ, Pasca-Stroke')">
                                                                            + Dewasa / ODGJ / Stroke
                                                                        </button>
                                                                        <button type="button" class="btn btn-xs btn-outline-info" style="font-size: 11px; padding: 2px 8px; border-radius: 4px;" onclick="$('#fokusEditInput{{ $row->id }}').val('Disabilitas Netra & Olahraga')">
                                                                            + Netra & Olahraga
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <!-- 4. Pilih Terapis Bertugas -->
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                                                                        Pilih Terapis Bertugas di UPT Ini:
                                                                    </label>
                                                                    <div class="p-2 bg-white rounded border" style="max-height: 150px; overflow-y: auto;">
                                                                        @if(isset($allTerapis) && count($allTerapis) > 0)
                                                                            @foreach($allTerapis as $terapisOpt)
                                                                                @php
                                                                                    $isAssigned = ($terapisOpt->poli === $row->nama);
                                                                                @endphp
                                                                                <div class="custom-control custom-checkbox mb-1 terapis-check-card">
                                                                                    <input type="checkbox" name="terapis_ids[]" value="{{ $terapisOpt->id }}" class="custom-control-input" id="tEdit_{{ $row->id }}_{{ $terapisOpt->id }}" {{ $isAssigned ? 'checked' : '' }}>
                                                                                    <label class="custom-control-label font-w600 text-dark d-flex justify-content-between align-items-center" for="tEdit_{{ $row->id }}_{{ $terapisOpt->id }}" style="cursor: pointer; font-size: 12.5px;">
                                                                                        <span>👨‍⚕️ {{ $terapisOpt->nama }}</span>
                                                                                        @if($terapisOpt->poli && $terapisOpt->poli !== $row->nama)
                                                                                            <small class="text-muted" style="font-size: 10.5px;">(Saat ini di {{ $terapisOpt->poli }})</small>
                                                                                        @endif
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <small class="text-muted">Tidak ada data master terapis aktif.</small>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <!-- 5. Status (Radio Button) -->
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                                                                        Status Operasional:
                                                                    </label>
                                                                    <div class="d-flex align-items-center" style="gap: 20px;">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" id="statusAktif_{{ $row->id }}" name="status" value="1" class="custom-control-input" {{ $row->status == 1 ? 'checked' : '' }}>
                                                                            <label class="custom-control-label font-w600 text-success" for="statusAktif_{{ $row->id }}" style="cursor: pointer; font-size: 13px;">
                                                                                <i class="fa-solid fa-circle text-success mr-1" style="font-size: 9px;"></i> Aktif
                                                                            </label>
                                                                        </div>
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" id="statusNon_{{ $row->id }}" name="status" value="0" class="custom-control-input" {{ $row->status == 0 ? 'checked' : '' }}>
                                                                            <label class="custom-control-label font-w600 text-danger" for="statusNon_{{ $row->id }}" style="cursor: pointer; font-size: 13px;">
                                                                                <i class="fa-solid fa-circle text-danger mr-1" style="font-size: 9px;"></i> Non-Aktif
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex align-items-center justify-content-end mt-4 pt-2 border-top" style="gap: 8px;">
                                                                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" style="padding: 7px 16px; font-size: 12.5px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-primary" style="padding: 7px 20px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
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
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-folder-open mb-1" style="font-size: 24px; opacity: 0.5;"></i>
                                        <p class="mb-0 fs-13">Tidak ada data Omah Terapiku yang sesuai.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center flex-wrap pt-2" style="font-size: 12.5px;">
                        <div class="text-muted">
                            Showing {{ $datas->firstItem() ?? 0 }} to {{ $datas->firstItem() ? ($datas->firstItem() + count($datas) - 1) : 0 }} of {{ $datas->total() }} entries
                        </div>
                        <div>
                            {{ $datas->appends(request()->except('page'))->links() }}
                        </div>
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
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #2D4B7A 0%, #1e355b 100%); padding: 14px 20px;">
                <div>
                    <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                        <i class="fa-solid fa-hospital-user mr-2"></i> Tambah Omah Terapi-KU Baru
                    </h5>
                    <small class="text-white-50">Daftarkan lokasi UPT / Balai pelayanan baru</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.85;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" style="background: #f8fafc;">
                <form action="{{ Route('omahterapiku.store') }}" method="POST">
                    {{ csrf_field() }}

                    <!-- 1. Nama UPT -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            Nama UPT / Lokasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" required class="form-control" placeholder="Contoh: UPT PPSAB Sidoarjo" style="height: 40px; font-size: 13px;">
                    </div>

                    <!-- 2. Alamat Lengkap -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            Alamat Lengkap
                        </label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo..." style="font-size: 13px;"></textarea>
                    </div>

                    <!-- 3. Fokus Layanan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            Fokus Layanan <small class="text-muted font-w400">(Sesuai CONTEXT.md)</small>
                        </label>
                        <input type="text" name="fokus_layanan" id="fokusAddInput" class="form-control mb-2" placeholder="Contoh: Anak Berkebutuhan Khusus (ABK)" style="height: 40px; font-size: 13px;">
                        <div class="d-flex flex-wrap" style="gap: 5px;">
                            <button type="button" class="btn btn-xs btn-outline-primary" style="font-size: 11px; padding: 2px 8px; border-radius: 4px;" onclick="$('#fokusAddInput').val('Anak Berkebutuhan Khusus (ABK)')">
                                + ABK
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-warning" style="font-size: 11px; padding: 2px 8px; border-radius: 4px;" onclick="$('#fokusAddInput').val('Dewasa, Lansia, ODGJ, Pasca-Stroke')">
                                + Dewasa / ODGJ / Stroke
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-info" style="font-size: 11px; padding: 2px 8px; border-radius: 4px;" onclick="$('#fokusAddInput').val('Disabilitas Netra & Olahraga')">
                                + Netra & Olahraga
                            </button>
                        </div>
                    </div>

                    <!-- 4. Pilih Terapis Bertugas -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                            Pilih Terapis Bertugas di UPT Ini:
                        </label>
                        <div class="p-2 bg-white rounded border" style="max-height: 150px; overflow-y: auto;">
                            @if(isset($allTerapis) && count($allTerapis) > 0)
                                @foreach($allTerapis as $terapisOpt)
                                    <div class="custom-control custom-checkbox mb-1 terapis-check-card">
                                        <input type="checkbox" name="terapis_ids[]" value="{{ $terapisOpt->id }}" class="custom-control-input" id="tAdd_{{ $terapisOpt->id }}">
                                        <label class="custom-control-label font-w600 text-dark d-flex justify-content-between align-items-center" for="tAdd_{{ $terapisOpt->id }}" style="cursor: pointer; font-size: 12.5px;">
                                            <span>👨‍⚕️ {{ $terapisOpt->nama }}</span>
                                            @if($terapisOpt->poli)
                                                <small class="text-muted" style="font-size: 10.5px;">(Di {{ $terapisOpt->poli }})</small>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <small class="text-muted">Tidak ada data master terapis aktif.</small>
                            @endif
                        </div>
                    </div>

                    <!-- 5. Status (Radio Button) -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 13px;">
                            Status Operasional:
                        </label>
                        <div class="d-flex align-items-center" style="gap: 20px;">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="statusAddAktif" name="status" value="1" class="custom-control-input" checked>
                                <label class="custom-control-label font-w600 text-success" for="statusAddAktif" style="cursor: pointer; font-size: 13px;">
                                    <i class="fa-solid fa-circle text-success mr-1" style="font-size: 9px;"></i> Aktif
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="statusAddNon" name="status" value="0" class="custom-control-input">
                                <label class="custom-control-label font-w600 text-danger" for="statusAddNon" style="cursor: pointer; font-size: 13px;">
                                    <i class="fa-solid fa-circle text-danger mr-1" style="font-size: 9px;"></i> Non-Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end mt-4 pt-2 border-top" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" style="padding: 7px 16px; font-size: 12.5px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary" style="padding: 7px 20px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
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
                confirmButtonColor: '#2D4B7A',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
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

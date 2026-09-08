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
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Data Petugas & Pengguna Sistem</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item active text-muted">Petugas & Pengguna</li>
                    </ol>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary font-w700 shadow-sm" data-toggle="modal" data-target="#addOrderModal" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-user-plus mr-1"></i> Tambah Petugas
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Petugas Baru -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content">
            <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon mr-3">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div>
                        <h5 class="modal-title ot-modal-title">Tambah Petugas Baru</h5>
                        <small class="ot-modal-subtitle">Daftarkan akun Admin atau Petugas Pendaftaran baru</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" style="background: #ffffff;">
                <form action="{{Route('petugas.store')}}" method="POST">
                    {{ csrf_field() }}
                   
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Nama Petugas / Pengguna <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" required class="form-control ot-input-modern" value="{{ old('name') }}" placeholder="Contoh: Siti Rahmawati, S.Tr.Kes">
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            NIP / Username (Identitas Login)
                        </label>
                        <input type="text" name="nip" class="form-control ot-input-modern" value="{{ old('nip') }}" placeholder="Contoh: 198501012010012001 atau sitir">
                        <small class="text-muted" style="font-size: 11px;">Dapat digunakan sebagai identitas login masuk ke aplikasi.</small>
                        @error('nip')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            No. HP / WhatsApp
                        </label>
                        <input type="text" name="phone" class="form-control ot-input-modern" value="{{ old('phone') }}" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Password Login <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password" required class="form-control ot-input-modern" placeholder="Minimal 4 karakter">
                        @error('password')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Role Akses <span class="text-danger">*</span>
                        </label>
                        <select name="role" class="form-control ot-input-modern" required>
                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin (Akses Penuh Master Data & Laporan)</option>
                            <option value="2" {{ old('role') == '2' || old('role') === null ? 'selected' : '' }}>Pendaftaran (Akses Penerima Manfaat & Pendaftaran Rekam)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top" style="margin: 0 -24px -24px -24px; padding: 14px 24px !important; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Petugas
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
                            Total: <strong class="text-primary font-w700">{{ $datas->total() }}</strong> Akun Petugas
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            
                            <!-- Filter Role -->
                            <div class="ot-filter-wrapper" style="width: 160px;">
                                <i class="fa-solid fa-user-shield"></i>
                                <select name="role" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Role Akses" style="width: 100%;">
                                    <option value="">Semua Role</option>
                                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Pendaftaran</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 200px; max-width: 240px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" name="keyword" value="{{request('keyword')}}" placeholder="Cari nama, NIP, HP..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            @if(request('keyword') || request('role'))
                                <a href="{{ Route('petugas') }}" class="btn btn-sm btn-light font-w600" style="height: 38px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 12px; transition: all 0.2s ease;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right mr-1" style="color: #64748b;"></i> Reset
                                </a>
                            @endif

                        </form>
                    </div>
                </div>

                <!-- Tabel Data Petugas -->
                <div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;">
                    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 950px; width: 100%;">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 12px 14px; width: 50px; text-align: center;">#</th>
                                <th style="padding: 12px 14px; min-width: 260px;">Nama Petugas / Pengguna</th>
                                <th style="padding: 12px 14px; min-width: 170px;">NIP / Identitas Login</th>
                                <th style="padding: 12px 14px; min-width: 160px;">No. HP / WhatsApp</th>
                                <th style="padding: 12px 14px; width: 140px;">Role Akses</th>
                                <th style="padding: 12px 14px; width: 110px; text-align: center;">Status</th>
                                <th style="padding: 12px 14px; width: 150px; text-align: center; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($datas) > 0)
                                @foreach ($datas as $key => $row)
                                    <tr>
                                        <td class="text-center font-w600 text-muted" style="vertical-align: middle;">
                                            {{ $datas->firstItem() + $key }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div>
                                                <strong class="text-dark d-block font-w700" style="font-size: 13.5px;">
                                                    {{$row->name}}
                                                </strong>
                                                @if($row->email && !str_contains($row->email, '@omah-terapiku.local'))
                                                    <small class="text-muted" style="font-size: 11.5px;">{{$row->email}}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span class="badge font-w600" style="font-size: 11.5px; padding: 4px 8px; border-radius: 6px; background: #f8fafc; color: #334155; border: 1px solid #cbd5e1;">
                                                <i class="fa-solid fa-id-card text-muted mr-1" style="font-size: 10px;"></i> {{$row->nip ?: '-'}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span style="color: #475569; font-size: 12.5px;">
                                                <i class="fa-brands fa-whatsapp text-success mr-1"></i> {{$row->phone ?: '-'}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if($row->role == 1)
                                                <span class="badge font-w700" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                    <i class="fa-solid fa-shield-halved mr-1"></i> Admin
                                                </span>
                                            @elseif($row->role == 2)
                                                <span class="badge font-w700" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                                                    <i class="fa-solid fa-user-pen mr-1"></i> Pendaftaran
                                                </span>
                                            @else
                                                <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                                    {{$row->role_display()}}
                                                </span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            @if($row->status == 1)
                                                <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                    <i class="fa-solid fa-circle mr-1" style="font-size: 7px; color: #10b981;"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                                    <i class="fa-solid fa-circle mr-1" style="font-size: 7px; color: #ef4444;"></i> Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle; text-align: center; white-space: nowrap; position: sticky; right: 0; background: #fff; z-index: 1; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">
                                            <div class="btn-group" role="group" style="gap: 4px;">
                                                <!-- Tombol Ganti Password -->
                                                <button type="button" data-toggle="modal" data-target="#key{{$row->id}}" class="btn btn-xs font-w600" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;" title="Ganti Password">
                                                    <i class="fa-solid fa-key"></i>
                                                </button>

                                                <!-- Tombol Edit -->
                                                <button type="button" data-toggle="modal" data-target="#edit{{$row->id}}" class="btn btn-xs font-w600" style="padding: 5px 9px; font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;" title="Edit Petugas">
                                                    <i class="fa-solid fa-pencil mr-1"></i> Edit
                                                </button>

                                                <!-- Tombol Hapus (Kecuali Akun Sendiri) -->
                                                @if(auth()->id() != $row->id)
                                                    <a href="#" class="btn btn-xs font-w600 delete" r-link="{{Route('petugas.delete',$row->id)}}"
                                                       r-name="{{$row->name}}" r-id="{{$row->id}}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" title="Hapus Petugas">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endif
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
                                            <strong class="text-dark mb-1" style="font-size: 14px;">Tidak ada data petugas yang sesuai</strong>
                                            <p class="mb-0 text-muted" style="font-size: 12.5px;">Coba ubah kata kunci pencarian atau filter role untuk melihat data lainnya.</p>
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
                        Menampilkan <strong class="text-dark">{{ $datas->firstItem() ?? 0 }}</strong> - <strong class="text-dark">{{ $datas->firstItem() ? ($datas->firstItem() + count($datas) - 1) : 0 }}</strong> dari <strong class="text-dark">{{ $datas->total() }}</strong> petugas
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
<!-- MODAL PER PETUGAS (OUTSIDE TABLE FOR MODAL BACKDROP) -->
<!-- ============================================================= -->
@if(isset($datas) && count($datas) > 0)
    @foreach ($datas as $row)
        <!-- Modal Ganti Password -->
        <div class="modal fade" id="key{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3" style="color: #d97706; border-color: #fde68a; background: #fffbeb;">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Ganti Password Akun</h5>
                                <small class="ot-modal-subtitle">Perbarui kata sandi untuk: {{$row->name}}</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        <form action="{{Route('gantipassword',$row->id)}}" method="POST">
                            {{ csrf_field() }}
                           
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Password Baru <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password" required class="form-control ot-input-modern" placeholder="Minimal 6 karakter">
                                @error('password')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Konfirmasi Password Baru <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password_konfirm" required class="form-control ot-input-modern" placeholder="Ulangi password baru">
                                @error('password_konfirm')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top" style="margin: 0 -24px -24px -24px; padding: 14px 24px !important; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                                <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-sm btn-warning font-w700 text-white" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important; border: none !important; padding: 9px 24px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);">
                                    <i class="fa-solid fa-key mr-1"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Petugas -->
        <div class="modal fade" id="edit{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Edit Data Petugas</h5>
                                <small class="ot-modal-subtitle">Perbarui rincian profil dan hak akses pengguna</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        <form action="{{Route('petugas.update',$row->id)}}" method="POST">
                            {{ csrf_field() }}
                           
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Nama Petugas / Pengguna <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" value="{{$row->name}}" required class="form-control ot-input-modern">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    NIP / Username (Identitas Login)
                                </label>
                                <input type="text" name="nip" value="{{$row->nip}}" class="form-control ot-input-modern">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    No. HP / WhatsApp
                                </label>
                                <input type="text" name="phone" value="{{$row->phone}}" class="form-control ot-input-modern">
                            </div>
                           
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Role Akses <span class="text-danger">*</span>
                                </label>
                                <select name="role" class="form-control ot-input-modern" required>
                                    <option value="1" {{$row->role == 1 ? 'selected' : ''}}>Admin (Akses Penuh Master Data & Laporan)</option>
                                    <option value="2" {{$row->role == 2 ? 'selected' : ''}}>Pendaftaran (Akses Penerima Manfaat & Pendaftaran Rekam)</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Password Baru (Opsional)
                                </label>
                                <input type="password" name="password" class="form-control ot-input-modern" placeholder="Kosongkan jika tidak ingin mengubah password">
                                <small class="text-muted" style="font-size: 11px;">Isi hanya jika ingin memperbarui kata sandi akun ini.</small>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top" style="margin: 0 -24px -24px -24px; padding: 14px 24px !important; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                                <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">
                                    <i class="fa-solid fa-floppy-disk mr-1"></i> Update Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

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
                title: 'Hapus Akun Petugas?',
                text: "Yakin ingin menghapus data petugas: " + name + "?",
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

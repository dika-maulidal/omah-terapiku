@extends('layout.apps')

@section('style')
<style>
    .tindakan-badge-layanan {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
    }
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
                    <i class="fa-solid fa-hand-holding-medical"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Data Tindakan Terapi</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item active text-muted">Tindakan Terapi</li>
                    </ol>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary font-w700 shadow-sm" data-toggle="modal" data-target="#addOrderModal" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-circle-plus mr-1"></i> Tambah Tindakan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tindakan Baru -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content">
            <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon mr-3">
                        <i class="fa-solid fa-hand-holding-medical"></i>
                    </div>
                    <div>
                        <h5 class="modal-title ot-modal-title">Tambah Tindakan Terapi Baru</h5>
                        <small class="ot-modal-subtitle">Daftarkan item rencana intervensi dan tindakan terapi</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" style="background: #ffffff;">
                <form action="{{Route('tindakan.store')}}" method="POST">
                    {{ csrf_field() }}
                    
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Kode Tindakan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="kode" required class="form-control ot-input-modern" value="{{ old('kode') }}" placeholder="Contoh: TDK01, FIS01, OKP01, WCR01">
                        @error('kode')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Nama Tindakan Terapi <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" required class="form-control ot-input-modern" value="{{ old('nama') }}" placeholder="Contoh: Terapi Wicara Motorik Anak">
                        @error('nama')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Layanan / Kategori Terapi <span class="text-danger">*</span>
                        </label>
                        <select name="poli" id="poliAddSelect" class="form-control ot-input-modern" required>
                            <option value="">-- Pilih Layanan Terapi --</option>
                            @foreach ($layananList as $layanan)
                                <option value="{{$layanan}}" {{ old('poli') == $layanan ? 'selected' : '' }}>{{$layanan}}</option>
                            @endforeach
                        </select>
                        <div class="d-flex flex-wrap mt-2" style="gap: 6px;">
                            <button type="button" class="quick-tag-btn" onclick="$('#poliAddSelect').val('Fisioterapi')">
                                <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Fisioterapi
                            </button>
                            <button type="button" class="quick-tag-btn" onclick="$('#poliAddSelect').val('Terapi Okupasi / Sensorik Integrasi')">
                                <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Okupasi
                            </button>
                            <button type="button" class="quick-tag-btn" onclick="$('#poliAddSelect').val('Terapi Wicara')">
                                <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Wicara
                            </button>
                            <button type="button" class="quick-tag-btn" onclick="$('#poliAddSelect').val('Terapi Netra (Orientasi & Mobilitas)')">
                                <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Netra
                            </button>
                        </div>
                        @error('poli')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top" style="margin: 0 -24px -24px -24px; padding: 14px 24px !important; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Tindakan
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
                            Total: <strong class="text-primary font-w700">{{ $datas->total() }}</strong> Tindakan Terapi
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            
                            <!-- Filter Layanan Terapi -->
                            <div class="ot-filter-wrapper" style="width: 200px;">
                                <i class="fa-solid fa-hand-holding-medical"></i>
                                <select name="poli" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Layanan Terapi" style="width: 100%;">
                                    <option value="">Semua Layanan</option>
                                    @foreach ($layananList as $layanan)
                                        <option value="{{$layanan}}" {{ request('poli') == $layanan ? 'selected' : '' }}>{{$layanan}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 190px; max-width: 230px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" name="keyword" value="{{request('keyword')}}" placeholder="Cari kode, tindakan..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            @if(request('keyword') || request('poli'))
                                <a href="{{ Route('tindakan') }}" class="btn btn-sm btn-light font-w600" style="height: 38px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 12px; transition: all 0.2s ease;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right mr-1" style="color: #64748b;"></i> Reset
                                </a>
                            @endif

                        </form>
                    </div>
                </div>

                <!-- Tabel Data Tindakan -->
                <div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;">
                    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 850px; width: 100%;">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 12px 14px; width: 50px; text-align: center;">#</th>
                                <th style="padding: 12px 14px; width: 150px;">Kode Tindakan</th>
                                <th style="padding: 12px 14px; min-width: 280px;">Nama Tindakan Terapi</th>
                                <th style="padding: 12px 14px; min-width: 220px;">Layanan / Kategori Terapi</th>
                                <th style="padding: 12px 14px; width: 120px; text-align: center; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($datas) > 0)
                                @foreach ($datas as $key => $row)
                                    @php
                                        $poliName = $row->poli ?: 'Umum';
                                        if (str_contains($poliName, 'Fisio')) {
                                            $badgeClass = 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;';
                                        } elseif (str_contains($poliName, 'Okupasi')) {
                                            $badgeClass = 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;';
                                        } elseif (str_contains($poliName, 'Wicara')) {
                                            $badgeClass = 'background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;';
                                        } elseif (str_contains($poliName, 'Netra')) {
                                            $badgeClass = 'background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;';
                                        } else {
                                            $badgeClass = 'background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0;';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center font-w600 text-muted" style="vertical-align: middle;">
                                            {{ $datas->firstItem() + $key }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span class="badge font-w700" style="font-size: 12px; letter-spacing: 0.5px; padding: 5px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                {{$row->kode}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;">
                                                    <i class="fa-solid fa-stethoscope"></i>
                                                </div>
                                                <strong style="font-size: 13.5px; color: #1e293b; font-weight: 700;">
                                                    {{$row->nama}}
                                                </strong>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span class="tindakan-badge-layanan" style="{{ $badgeClass }}">
                                                <i class="fa-solid fa-tag mr-1" style="font-size: 10px;"></i> {{$row->poli ?: '-'}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center; white-space: nowrap; position: sticky; right: 0; background: #fff; z-index: 1; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">
                                            <div class="btn-group" role="group" style="gap: 4px;">
                                                <!-- Tombol Edit -->
                                                <button type="button" data-toggle="modal" data-target="#edit{{$row->id}}" class="btn btn-xs font-w600" style="padding: 5px 9px; font-size: 11.5px; border-radius: 6px; background: #fef3c7; color: #d97706; border: 1px solid #fde68a;" title="Edit Tindakan">
                                                    <i class="fa-solid fa-pencil mr-1"></i> Edit
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <a href="#" class="btn btn-xs font-w600 delete" r-link="{{Route('tindakan.delete',$row->id)}}"
                                                   r-name="{{$row->nama}}" r-id="{{$row->id}}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" title="Hapus Tindakan">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-2" style="width: 50px; height: 50px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 22px;">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </div>
                                            <strong class="text-dark mb-1" style="font-size: 14px;">Tidak ada data tindakan terapi</strong>
                                            <p class="mb-0 text-muted" style="font-size: 12.5px;">Coba ubah kata kunci pencarian atau filter layanan untuk melihat data lainnya.</p>
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
                        Menampilkan <strong class="text-dark">{{ $datas->firstItem() ?? 0 }}</strong> - <strong class="text-dark">{{ $datas->firstItem() ? ($datas->firstItem() + count($datas) - 1) : 0 }}</strong> dari <strong class="text-dark">{{ $datas->total() }}</strong> tindakan
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
<!-- MODAL PER TINDAKAN (OUTSIDE TABLE FOR MODAL BACKDROP) -->
<!-- ============================================================= -->
@if(isset($datas) && count($datas) > 0)
    @foreach ($datas as $row)
        <!-- Modal Edit Tindakan -->
        <div class="modal fade" id="edit{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Edit Tindakan Terapi</h5>
                                <small class="ot-modal-subtitle">Perbarui rincian kode dan nama tindakan terapi</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        <form action="{{Route('master.tindakan.update',$row->id)}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Kode Tindakan <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="kode" value="{{$row->kode}}" required class="form-control ot-input-modern">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Nama Tindakan Terapi <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" value="{{$row->nama}}" required class="form-control ot-input-modern">
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Layanan / Kategori Terapi <span class="text-danger">*</span>
                                </label>
                                <select name="poli" id="poliEditSelect{{$row->id}}" class="form-control ot-input-modern" required>
                                    @foreach ($layananList as $layanan)
                                        <option value="{{$layanan}}" {{ $layanan == $row->poli ? 'selected' : '' }}>{{$layanan}}</option>
                                    @endforeach
                                </select>
                                <div class="d-flex flex-wrap mt-2" style="gap: 6px;">
                                    <button type="button" class="quick-tag-btn" onclick="$('#poliEditSelect{{$row->id}}').val('Fisioterapi')">
                                        <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Fisioterapi
                                    </button>
                                    <button type="button" class="quick-tag-btn" onclick="$('#poliEditSelect{{$row->id}}').val('Terapi Okupasi / Sensorik Integrasi')">
                                        <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Okupasi
                                    </button>
                                    <button type="button" class="quick-tag-btn" onclick="$('#poliEditSelect{{$row->id}}').val('Terapi Wicara')">
                                        <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Wicara
                                    </button>
                                    <button type="button" class="quick-tag-btn" onclick="$('#poliEditSelect{{$row->id}}').val('Terapi Netra (Orientasi & Mobilitas)')">
                                        <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Netra
                                    </button>
                                </div>
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
                title: 'Hapus Tindakan Terapi?',
                text: "Yakin ingin menghapus tindakan: " + name + "?",
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

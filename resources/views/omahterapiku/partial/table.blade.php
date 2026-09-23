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
                            <div style="color: #475569; font-size: 12.5px;">
                                <i class="fa-solid fa-location-dot text-muted mr-1" style="font-size: 11px;"></i> {{ $row->alamat ?: '-' }}
                            </div>
                            @if($row->no_telp)
                                <div class="mt-1" style="color: #2563eb; font-size: 11.5px; font-weight: 600;">
                                    <i class="fa-solid fa-phone mr-1" style="font-size: 10px;"></i> {{ $row->no_telp }}
                                </div>
                            @endif
                            @if($row->latitude && $row->longitude)
                                <div class="mt-1 text-muted" style="font-size: 11px;">
                                    <i class="fa-solid fa-crosshairs text-primary mr-1" style="font-size: 10px;"></i>
                                    <span style="font-family: monospace; color: #64748b;">{{ $row->latitude }}, {{ $row->longitude }}</span>
                                </div>
                            @endif
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
                                <button type="button" class="btn btn-xs font-w600" data-toggle="modal" data-target="#detailModal{{ $row->id }}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;" title="Lihat Detail UPT">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-xs font-w600" data-toggle="modal" data-target="#editModal{{ $row->id }}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fef3c7; color: #d97706; border: 1px solid #fde68a;" title="Edit UPT">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <a href="#" class="btn btn-xs font-w600 delete" r-link="{{ Route('omahterapiku.delete', $row->id) }}" r-name="{{ $row->nama }}" r-id="{{ $row->id }}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" title="Hapus UPT">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
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
    <div class="pagination-wrapper">
        {{ $datas->appends(request()->except('page'))->links() }}
    </div>
</div>

<!-- ============================================================= -->
<!-- MODAL DETAIL & EDIT PER UPT DI DALAM PARTIAL -->
<!-- ============================================================= -->
@if(isset($datas) && count($datas) > 0)
    @foreach ($datas as $row)
        @php
            $fokus = $row->fokus_layanan;
            if (!$fokus) {
                if (str_contains($row->nama, 'PPSAB')) {
                    $fokus = 'Anak Berkebutuhan Khusus (ABK)';
                } elseif (str_contains($row->nama, 'PMKS')) {
                    $fokus = 'Dewasa, ODGJ, Stroke';
                } elseif (str_contains($row->nama, 'RSBN')) {
                    $fokus = 'Disabilitas Netra & Olahraga';
                } else {
                    $fokus = 'Pelayanan Terapi Terpadu';
                }
            }

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

        <!-- MODAL DETAIL UPT (SHOW) -->
        <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3">
                                <i class="fa-solid fa-hospital"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Detail Omah Terapi-KU</h5>
                                <small class="ot-modal-subtitle">Informasi Unit Pelaksana Teknis &amp; Tenaga Terapis</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-4 text-left" style="background: #f8fafc;">
                        <!-- 1. Informasi UPT -->
                        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px; border: 1px solid #e2e8f0; background: #ffffff;">
                            <div class="card-header py-2.5 px-3 bg-white border-bottom" style="border-bottom: 1.5px solid #edf2f7 !important;">
                                <strong class="text-primary font-w700" style="font-size: 13px; color: #1e40af !important;">
                                    <i class="fa-solid fa-building mr-1" style="color: #2563eb;"></i> Informasi UPT
                                </strong>
                            </div>
                            <div class="card-body p-3">
                                <div class="mb-2.5">
                                    <small class="text-muted d-block font-w600" style="font-size: 11px;">Nama UPT / Lokasi:</small>
                                    <strong class="text-dark" style="font-size: 14px;">{{ $row->nama }}</strong>
                                </div>
                                <div class="mb-2.5">
                                    <small class="text-muted d-block font-w600" style="font-size: 11px;">Alamat Lengkap:</small>
                                    <span class="text-dark font-w500" style="font-size: 13px;">{{ $row->alamat ?: '-' }}</span>
                                </div>
                                <div class="mb-2.5">
                                    <small class="text-muted d-block font-w600" style="font-size: 11px;">No. Telp / Hotline UPT:</small>
                                    <span class="text-dark font-w500" style="font-size: 13px;">
                                        @if($row->no_telp)
                                            <i class="fa-solid fa-phone text-primary mr-1" style="font-size: 11px;"></i> <strong class="text-dark">{{ $row->no_telp }}</strong>
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="mb-2.5">
                                    <small class="text-muted d-block font-w600" style="font-size: 11px;">Titik Koordinat Lokasi:</small>
                                    @if($row->latitude && $row->longitude)
                                        <div class="d-flex align-items-center justify-content-between mt-1 flex-wrap" style="gap: 6px;">
                                            <span class="badge badge-light font-w600 text-dark" style="font-size: 12px; border: 1.5px solid #cbd5e1; font-family: monospace;">
                                                <i class="fa-solid fa-location-crosshairs text-primary mr-1"></i> {{ $row->latitude }}, {{ $row->longitude }}
                                            </span>
                                            <a href="https://www.google.com/maps?q={{ $row->latitude }},{{ $row->longitude }}" target="_blank" class="btn btn-xs btn-outline-primary font-w600" style="border-radius: 6px; font-size: 11px; padding: 3px 8px;">
                                                <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka Google Maps
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted font-w500" style="font-size: 12px;">Belum diatur koordinat</span>
                                    @endif
                                </div>
                                <div class="mb-2.5">
                                    <small class="text-muted d-block font-w600" style="font-size: 11px;">Fokus Layanan:</small>
                                    <span class="focus-badge mt-1" style="{{ $badgeStyle }}">
                                        <i class="fa-solid fa-tag mr-1"></i> {{ $fokus }}
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted d-block font-w600" style="font-size: 11px;">Status Operasional:</small>
                                    @if($row->status == 1)
                                        <span class="badge badge-success light font-w700 mt-1" style="font-size: 11.5px; padding: 4px 10px;">
                                            <i class="fa-solid fa-circle-check mr-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-danger light font-w700 mt-1" style="font-size: 11.5px; padding: 4px 10px;">
                                            <i class="fa-solid fa-circle-xmark mr-1"></i> Non-Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- 2. Daftar Terapis Bertugas -->
                        <div class="card border-0 shadow-sm mb-0" style="border-radius: 10px; border: 1px solid #e2e8f0; background: #ffffff;">
                            <div class="card-header py-2.5 px-3 bg-white border-bottom d-flex justify-content-between align-items-center" style="border-bottom: 1.5px solid #edf2f7 !important;">
                                <strong class="text-primary font-w700" style="font-size: 13px; color: #1e40af !important;">
                                    <i class="fa-solid fa-user-doctor mr-1" style="color: #2563eb;"></i> Tenaga Terapis di UPT Ini
                                </strong>
                                <span class="badge badge-primary font-w700" style="font-size: 11px; background: #2563eb;">
                                    {{ $row->terapis->count() }} Terapis
                                </span>
                            </div>
                            <div class="card-body p-3">
                                @if($row->terapis->count() > 0)
                                    <div class="d-flex flex-column" style="gap: 10px; max-height: 240px; overflow-y: auto; padding-right: 2px;">
                                        @foreach($row->terapis as $terapis)
                                            <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                                <div>
                                                    <div class="font-w700 text-dark mb-1" style="font-size: 13.5px; color: #0f172a;">
                                                        {{ $terapis->nama }}
                                                    </div>
                                                    <div class="d-flex align-items-center text-muted" style="font-size: 12px;">
                                                        @if($terapis->no_hp)
                                                            <i class="fa-solid fa-phone mr-1.5 text-primary" style="font-size: 10.5px;"></i>
                                                            <span>Telp/WA: <strong class="text-dark font-w600">{{ $terapis->no_hp }}</strong></span>
                                                        @else
                                                            <i class="fa-solid fa-user-check mr-1.5 text-muted" style="font-size: 10.5px;"></i>
                                                            <span>Terapis Klinis</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-right pl-2">
                                                    <span class="badge badge-success light font-w600" style="font-size: 11px; padding: 4px 10px; border: 1px solid #bbf7d0;">
                                                        <i class="fa-solid fa-circle text-success mr-1" style="font-size: 7px; vertical-align: middle;"></i> Aktif
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-3 text-muted">
                                        <i class="fa-solid fa-user-slash mb-1 d-block text-muted" style="font-size: 24px; opacity: 0.5;"></i>
                                        <p class="mb-0 font-w500" style="font-size: 12px;">Belum ada terapis yang ditugaskan di UPT ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer py-2.5 px-4 d-flex justify-content-between align-items-center" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff; padding: 7px 16px;">
                            Tutup
                        </button>
                        <button type="button" class="btn btn-sm btn-primary font-w700" data-dismiss="modal" data-toggle="modal" data-target="#editModal{{ $row->id }}" style="font-size: 12.5px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none; color: #ffffff; padding: 8px 18px; box-shadow: 0 4px 12px rgba(37,99,235,0.25);">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Data UPT
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- MODAL FORM EDIT UPT -->
        <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Edit Omah Terapi-KU</h5>
                                <small class="ot-modal-subtitle">Kelola informasi lokasi, fokus layanan, dan penugasan terapis</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        <form action="{{ Route('omahterapiku.update', $row->id) }}" method="POST">
                            {{ csrf_field() }}

                            <div class="row">
                                <!-- 1. Nama UPT -->
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                        Nama UPT / Lokasi Pelayanan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" value="{{ $row->nama }}" required class="form-control ot-input-modern" placeholder="Contoh: UPT PPSAB Sidoarjo">
                                </div>

                                <!-- 2b. No. Telp / Kontak UPT -->
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                        No. Telp / Hotline UPT
                                    </label>
                                    <input type="text" name="no_telp" value="{{ $row->no_telp }}" class="form-control ot-input-modern" placeholder="Contoh: (031) 8921234 / 081234567890">
                                </div>
                            </div>

                            <!-- 2. Alamat Lengkap -->
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Alamat Lengkap Kantor / Lokasi
                                </label>
                                <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo..." style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">{{ $row->alamat }}</textarea>
                            </div>

                            <!-- 2c. Koordinat Lokasi & Interactive Map Picker Leaflet -->
                            <div class="form-group mb-3 p-3.5 rounded" style="background: #f8fafc; border: 1.5px solid #e2e8f0;">
                                <div class="d-flex align-items-center justify-content-between mb-2.5 flex-wrap" style="gap: 8px;">
                                    <label class="form-label font-w700 text-dark mb-0" style="font-size: 13px;">
                                        <i class="fa-solid fa-map-location-dot text-primary mr-1"></i> Titik Koordinat Peta (Latitude &amp; Longitude)
                                    </label>
                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                        <button type="button" class="btn btn-xs font-w600" id="btnGpsEdit_{{ $row->id }}" style="font-size: 11px; padding: 4px 10px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;" title="Deteksi posisi GPS saat ini">
                                            <i class="fa-solid fa-location-crosshairs mr-1"></i> Lokasi Saya
                                        </button>
                                        <button type="button" class="btn btn-xs font-w600" id="btnResetJatimEdit_{{ $row->id }}" style="font-size: 11px; padding: 4px 10px; border-radius: 6px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1;" title="Pusatkan peta ke Jawa Timur">
                                            <i class="fa-solid fa-arrows-rotate mr-1"></i> Jatim
                                        </button>
                                    </div>
                                </div>

                                <!-- 2 Kolom Input Lat & Lng -->
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2 mb-md-0">
                                        <label class="text-muted font-w600 mb-1 d-block" style="font-size: 11.5px;">Latitude (Garis Lintang):</label>
                                        <div class="input-group">
                                            <input type="text" name="latitude" id="latEdit_{{ $row->id }}" class="form-control ot-input-modern" placeholder="-7.4526000" style="font-size: 12.5px;" value="{{ $row->latitude }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted font-w600 mb-1 d-block" style="font-size: 11.5px;">Longitude (Garis Bujur):</label>
                                        <div class="input-group">
                                            <input type="text" name="longitude" id="lngEdit_{{ $row->id }}" class="form-control ot-input-modern" placeholder="112.7135000" style="font-size: 12.5px;" value="{{ $row->longitude }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Map Container dengan Spacing Nyaman -->
                                <div style="position: relative; margin-top: 6px;">
                                    <div id="mapPickerEdit_{{ $row->id }}" style="height: 230px; width: 100%; border-radius: 8px; border: 1.5px solid #cbd5e1; box-shadow: inset 0 1px 3px rgba(0,0,0,0.06); z-index: 1;"></div>
                                    
                                    <!-- Helper Info & Realtime Lat/Lng Display berjarak lega -->
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mt-2.5 pt-1 px-1" style="gap: 6px;">
                                        <small class="text-muted" style="font-size: 11.5px; line-height: 1.4;">
                                            <i class="fa-solid fa-circle-info text-primary mr-1"></i> Klik pada peta atau seret marker merah untuk memilih lokasi.
                                        </small>
                                        <small id="editCoordDisplay_{{ $row->id }}" class="font-w600 text-primary" style="font-size: 11.5px;"></small>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Fokus Layanan -->
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Fokus Layanan Utama
                                </label>
                                <input type="text" name="fokus_layanan" id="fokusEditInput{{ $row->id }}" value="{{ $row->fokus_layanan ?: $fokus }}" class="form-control ot-input-modern mb-2" placeholder="Contoh: Anak Berkebutuhan Khusus (ABK)">
                                
                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                    <button type="button" class="quick-tag-btn" onclick="$('#fokusEditInput{{ $row->id }}').val('Anak Berkebutuhan Khusus (ABK)')">
                                        <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> ABK
                                    </button>
                                    <button type="button" class="quick-tag-btn" onclick="$('#fokusEditInput{{ $row->id }}').val('Dewasa, Lansia, ODGJ, Pasca-Stroke')">
                                        <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Dewasa / ODGJ / Stroke
                                    </button>
                                    <button type="button" class="quick-tag-btn" onclick="$('#fokusEditInput{{ $row->id }}').val('Disabilitas Netra & Olahraga')">
                                        <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Netra & Olahraga
                                    </button>
                                </div>
                            </div>

                            <!-- 4. Pilih Terapis Bertugas -->
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-1.5 flex-wrap" style="gap: 6px;">
                                    <label class="form-label font-w600 text-dark mb-0" style="font-size: 13px;">
                                        Pilih Terapis Bertugas di UPT Ini:
                                    </label>
                                    <small class="text-muted" style="font-size: 11px;">Terapis di UPT lain terkunci</small>
                                </div>
                                <div class="p-2.5 rounded" style="max-height: 165px; overflow-y: auto; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px;">
                                    @if(isset($allTerapis) && count($allTerapis) > 0)
                                        @foreach($allTerapis as $terapisOpt)
                                            @php
                                                $isAssignedHere = ($terapisOpt->poli === $row->nama);
                                                $isAssignedOther = (!empty($terapisOpt->poli) && $terapisOpt->poli !== $row->nama);
                                            @endphp
                                            <div class="terapis-check-card mb-1.5 {{ $isAssignedOther ? 'disabled' : '' }}" title="{{ $isAssignedOther ? 'Terapis ini sudah bertugas di ' . $terapisOpt->poli : ($isAssignedHere ? 'Bertugas di UPT ini' : 'Terapis tersedia untuk ditugaskan') }}">
                                                <div class="custom-control custom-checkbox w-100">
                                                    <input type="checkbox" name="terapis_ids[]" value="{{ $terapisOpt->id }}" class="custom-control-input" id="tEdit_{{ $row->id }}_{{ $terapisOpt->id }}" {{ $isAssignedHere ? 'checked' : '' }} {{ $isAssignedOther ? 'disabled' : '' }}>
                                                    <label class="custom-control-label font-w600 {{ $isAssignedOther ? 'text-muted' : 'text-dark' }} d-flex justify-content-between align-items-center mb-0" for="tEdit_{{ $row->id }}_{{ $terapisOpt->id }}" style="{{ $isAssignedOther ? 'cursor: not-allowed;' : 'cursor: pointer;' }} font-size: 12.5px;">
                                                        <span>{{ $terapisOpt->nama }}</span>
                                                        @if($isAssignedOther)
                                                            <span class="badge badge-light font-w600 text-danger" style="font-size: 10.5px; border: 1px solid #fecaca; background: #fef2f2;">
                                                                <i class="fa-solid fa-lock mr-1"></i> Bertugas di {{ $terapisOpt->poli }}
                                                            </span>
                                                        @elseif($isAssignedHere)
                                                            <span class="badge badge-primary light font-w600" style="font-size: 10.5px;">
                                                                <i class="fa-solid fa-check mr-1"></i> UPT Ini
                                                            </span>
                                                        @else
                                                            <span class="badge badge-success light font-w600" style="font-size: 10.5px; border: 1px solid #bbf7d0;">
                                                                <i class="fa-solid fa-circle-check mr-1"></i> Tersedia
                                                            </span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <small class="text-muted d-block text-center py-2">Tidak ada data master terapis aktif.</small>
                                    @endif
                                </div>
                            </div>

                            <!-- 5. Status (Radio Button) -->
                            <div class="form-group mb-2">
                                <label class="form-label font-w600 text-dark mb-2 d-block" style="font-size: 13px;">
                                    Status Operasional:
                                </label>
                                <div class="d-flex align-items-center" style="gap: 24px; padding-left: 2px;">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="statusAktif_{{ $row->id }}" name="status" value="1" class="custom-control-input" {{ $row->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label font-w600 text-dark mb-0" for="statusAktif_{{ $row->id }}" style="cursor: pointer; font-size: 13px;">
                                            <i class="fa-solid fa-circle text-success mr-1" style="font-size: 9px; vertical-align: middle;"></i> Aktif
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="statusNon_{{ $row->id }}" name="status" value="0" class="custom-control-input" {{ $row->status == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label font-w600 text-dark mb-0" for="statusNon_{{ $row->id }}" style="cursor: pointer; font-size: 13px;">
                                            <i class="fa-solid fa-circle text-danger mr-1" style="font-size: 9px; vertical-align: middle;"></i> Non-Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top" style="margin: 0 -24px -24px -24px; padding: 14px 24px !important; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                                <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">
                                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif

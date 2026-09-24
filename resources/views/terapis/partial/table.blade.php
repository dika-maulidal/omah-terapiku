<!-- Tabel Data Terapis -->
<div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;">
    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 980px; width: 100%;">
        <thead>
            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; width: 50px; text-align: center;">#</th>
                <th style="padding: 12px 14px; min-width: 240px;">Nama Terapis & Keterangan</th>
                <th style="padding: 12px 14px; min-width: 210px;">NIP & Sertifikat STR</th>
                <th style="padding: 12px 14px; min-width: 150px;">No. HP (Login)</th>
                <th style="padding: 12px 14px; min-width: 160px;">Penempatan UPT</th>
                <th style="padding: 12px 14px; width: 100px; text-align: center;">Status</th>
                <th style="padding: 12px 14px; width: 160px; text-align: center; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
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
                                    {{$row->nama}}
                                </strong>
                                @if($row->alamat)
                                    <small class="text-muted d-block" style="font-size: 11.5px;">
                                        <i class="fa-solid fa-location-dot mr-1" style="font-size: 10px;"></i>{{$row->alamat}}
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td style="vertical-align: middle;">
                            <div class="d-flex flex-column" style="gap: 4px;">
                                <span class="badge font-w600" style="font-size: 11px; padding: 4px 8px; border-radius: 6px; background: #f8fafc; color: #334155; border: 1px solid #cbd5e1; width: fit-content;">
                                    <i class="fa-solid fa-id-card text-muted mr-1" style="font-size: 10px;"></i> NIP: {{$row->user->nip ?? ($row->nip ?: '-')}}
                                </span>
                                @if($row->no_str)
                                    <div class="d-flex align-items-center flex-wrap" style="gap: 4px;">
                                        <span class="badge font-w600" style="font-size: 11px; padding: 4px 8px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; width: fit-content;" title="Masa Berlaku: {{$row->masa_berlaku_str ?: 'Seumur Hidup'}}">
                                            <i class="fa-solid fa-certificate text-primary mr-1" style="font-size: 10px;"></i> STR: {{$row->no_str}}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size: 11px;">
                                        <i class="fa-solid fa-circle-exclamation text-amber-500 mr-1" style="color: #f59e0b;"></i> STR: <em class="text-muted">Belum ada</em>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td style="vertical-align: middle;">
                            <span style="color: #475569; font-size: 12.5px;">
                                <i class="fa-brands fa-whatsapp text-success mr-1"></i> {{$row->no_hp ?: '-'}}
                            </span>
                        </td>
                        <td style="vertical-align: middle;">
                            <span class="badge font-w600" style="font-size: 11.5px; padding: 4px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                <i class="fa-solid fa-hospital-user mr-1" style="font-size: 11px;"></i> {{$row->poli ?: '-'}}
                            </span>
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
                                <!-- Tombol Preview Berkas STR -->
                                <button type="button" data-toggle="modal" data-target="#strModal{{$row->id}}" class="btn btn-xs font-w600" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;" title="Detail & Dokumen STR">
                                    <i class="fa-solid fa-file-shield"></i>
                                </button>

                                <!-- Tombol Ganti Password -->
                                <button type="button" data-toggle="modal" data-target="#key{{$row->user_id}}" class="btn btn-xs font-w600" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;" title="Ganti Password">
                                    <i class="fa-solid fa-key"></i>
                                </button>

                                <!-- Tombol Edit -->
                                <button type="button" data-toggle="modal" data-target="#edit{{$row->id}}" class="btn btn-xs font-w600" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;" title="Edit Terapis">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>

                                <!-- Tombol Hapus / Nonaktifkan -->
                                <a href="#" class="btn btn-xs font-w600 delete" r-link="{{Route('dokter.delete',$row->id)}}"
                                   r-name="{{$row->nama}}" r-id="{{$row->id}}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" title="Hapus / Nonaktifkan Terapis">
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
                            <strong class="text-dark mb-1" style="font-size: 14px;">Tidak ada data terapis yang sesuai</strong>
                            <p class="mb-0 text-muted" style="font-size: 12.5px;">Coba ubah kata kunci pencarian atau filter lokasi untuk melihat data lainnya.</p>
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
        Menampilkan <strong class="text-dark">{{ $datas->firstItem() ?? 0 }}</strong> - <strong class="text-dark">{{ $datas->firstItem() ? ($datas->firstItem() + count($datas) - 1) : 0 }}</strong> dari <strong class="text-dark">{{ $datas->total() }}</strong> terapis
    </div>
    <div class="pagination-wrapper">
        {{ $datas->appends(request()->except('page'))->links() }}
    </div>
</div>

<!-- ============================================================= -->
<!-- MODAL PER TERAPIS DI DALAM PARTIAL -->
<!-- ============================================================= -->
@if(isset($datas) && count($datas) > 0)
    @foreach ($datas as $row)
        
        <!-- Modal Preview & Detail STR Terapis -->
        <div class="modal fade" id="strModal{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3" style="color: #16a34a; border-color: #bbf7d0; background: #f0fdf4;">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Sertifikat STR: {{$row->nama}}</h5>
                                <small class="ot-modal-subtitle">Surat Tanda Registrasi & Verifikasi Legalitas Praktik</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        
                        <!-- Header Kartu Ringkasan STR -->
                        <div class="row mb-3" style="row-gap: 12px;">
                            <div class="col-md-4">
                                <div class="p-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                    <small class="text-muted d-block mb-1" style="font-size: 11px;"><i class="fa-solid fa-id-card text-primary mr-1"></i> Nomor STR</small>
                                    <strong class="text-dark d-block" style="font-size: 13.5px;">{{ $row->no_str ?: 'Belum Dicatat' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                    <small class="text-muted d-block mb-1" style="font-size: 11px;"><i class="fa-solid fa-calendar-check text-primary mr-1"></i> Masa Berlaku</small>
                                    <strong class="text-dark d-block" style="font-size: 13.5px;">{{ $row->masa_berlaku_str ?: 'Seumur Hidup / Belum Diatur' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                    <small class="text-muted d-block mb-1" style="font-size: 11px;"><i class="fa-solid fa-hospital-user text-primary mr-1"></i> Penempatan UPT</small>
                                    <strong class="text-dark d-block" style="font-size: 13.5px;">{{ $row->poli ?: '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Area Dokumen Scan STR -->
                        <div class="p-3 text-center" style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 10px; min-height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            @if($row->file_str && file_exists(public_path('images/terapis/str/' . $row->file_str)))
                                @php
                                    $fileExt = strtolower(pathinfo($row->file_str, PATHINFO_EXTENSION));
                                    $fileUrl = asset('images/terapis/str/' . $row->file_str);
                                @endphp

                                @if(in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp']))
                                    <div class="mb-3 btn-open-preview-berkas" data-type="str" data-title="Sertifikat STR: {{ $row->nama }}" data-url="{{ $fileUrl }}" data-filename="{{ $row->file_str }}" data-patient="{{ $row->nama }}" style="max-height: 380px; overflow: hidden; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; padding: 6px; cursor: pointer;" title="Klik untuk Pratinjau Interaktif">
                                        <img src="{{ $fileUrl }}" alt="Scan Dokumen STR {{ $row->nama }}" class="img-fluid rounded" style="max-height: 340px; object-fit: contain;">
                                    </div>
                                @else
                                    <div class="mb-3 text-center py-4">
                                        <div class="mb-2" style="width: 60px; height: 60px; border-radius: 12px; background: #eff6ff; display: inline-flex; align-items: center; justify-content: center; color: #2563eb; font-size: 28px;">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </div>
                                        <h6 class="font-w700 text-dark mb-1" style="font-size: 14px;">Dokumen STR Format PDF</h6>
                                        <p class="text-muted mb-0" style="font-size: 12px;">File: {{ $row->file_str }}</p>
                                    </div>
                                @endif

                                <div class="d-flex align-items-center justify-content-center flex-wrap" style="gap: 10px;">
                                    <button type="button" class="btn btn-sm btn-primary font-w700 btn-open-preview-berkas" data-type="str" data-title="Sertifikat STR: {{ $row->nama }}" data-url="{{ $fileUrl }}" data-filename="{{ $row->file_str }}" data-patient="{{ $row->nama }}" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 20px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                        <i class="fa-solid fa-eye mr-1"></i> Lihat Dokumen STR
                                    </button>
                                    <a href="{{ $fileUrl }}" download="{{ $row->file_str }}" class="btn btn-sm btn-light font-w600" style="padding: 8px 16px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                                        <i class="fa-solid fa-download mr-1"></i> Unduh File
                                    </a>
                                </div>
                            @else
                                <div class="py-4">
                                    <div class="mb-2" style="width: 54px; height: 54px; border-radius: 50%; background: #fef2f2; display: inline-flex; align-items: center; justify-content: center; color: #ef4444; font-size: 22px;">
                                        <i class="fa-solid fa-file-circle-xmark"></i>
                                    </div>
                                    <h6 class="font-w700 text-dark mb-1" style="font-size: 14px;">Belum Ada Berkas Scan STR</h6>
                                    <p class="text-muted mb-3" style="font-size: 12px; max-width: 400px; margin: 0 auto;">Scan sertifikat fisik STR belum diunggah oleh admin maupun terapis bersangkutan.</p>
                                    <button type="button" class="btn btn-sm btn-outline-primary font-w600" data-dismiss="modal" data-toggle="modal" data-target="#edit{{$row->id}}" style="border-radius: 8px; font-size: 12px; padding: 6px 16px;">
                                        <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Unggah Scan STR Sekarang
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="modal-footer p-3 bg-light d-flex justify-content-end" style="border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 7px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px;">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ganti Password Login Terapis -->
        <div class="modal fade" id="key{{$row->user_id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3" style="color: #d97706; border-color: #fde68a; background: #fffbeb;">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Ganti Password Akun Terapis</h5>
                                <small class="ot-modal-subtitle">Perbarui kata sandi untuk: {{$row->nama}}</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        <form action="{{Route('dokter.gantipassword',$row->user_id)}}" method="POST">
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

        <!-- Modal Edit Terapis -->
        <div class="modal fade" id="edit{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ot-modal-content">
                    <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ot-modal-icon mr-3">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <h5 class="modal-title ot-modal-title">Edit Data Terapis</h5>
                                <small class="ot-modal-subtitle">Perbarui rincian identitas, STR, dan penempatan terapis</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        <form action="{{Route('dokter.update',$row->id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Nama Lengkap Terapis <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" value="{{$row->nama}}" required class="form-control ot-input-modern">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            NIP / Nomor Registrasi Pegawai
                                        </label>
                                        <input type="text" name="nip" value="{{$row->user->nip ?? ''}}" class="form-control ot-input-modern">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            Penempatan Omah Terapiku <span class="text-danger">*</span>
                                        </label>
                                        <select name="poli" class="form-control ot-input-modern" required>
                                            @if(isset($poli))
                                                @foreach ($poli as $item)
                                                    <option value="{{$item->nama}}" {{ $item->nama == $row->poli ? 'selected' : '' }}>{{$item->nama}}</option>
                                                @endforeach
                                            @endif
                                        </select>
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
                                            <input type="text" name="no_str" class="form-control ot-input-modern" value="{{$row->no_str}}" placeholder="Contoh: 12 04 5 2 1 19-1234567">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                                Masa Berlaku STR
                                            </label>
                                            <input type="text" name="masa_berlaku_str" class="form-control ot-input-modern" value="{{$row->masa_berlaku_str}}" placeholder="Contoh: Seumur Hidup / 31 Desember 2028">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <label class="form-label font-w600 text-dark mb-0" style="font-size: 12.5px;">
                                            Ganti / Upload Scan Dokumen STR
                                            <span class="text-muted font-w400" style="font-size: 11px;">(PDF, JPG, PNG &bull; Maks. 5MB)</span>
                                        </label>
                                        @if($row->file_str && file_exists(public_path('images/terapis/str/' . $row->file_str)))
                                            <a href="{{ asset('images/terapis/str/' . $row->file_str) }}" target="_blank" class="badge badge-primary font-w600" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; padding: 3px 8px; border-radius: 6px;">
                                                <i class="fa-solid fa-file-lines mr-1"></i> File Saat Ini: {{ Str::limit($row->file_str, 20) }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="ot-file-upload-box">
                                        <input type="file" name="file_str" class="ot-file-upload-input" id="file_str_edit_{{$row->id}}" accept=".pdf,.jpg,.jpeg,.png" onchange="var fn = this.files[0] ? this.files[0].name : '{{ $row->file_str ? 'Ganti file scan STR baru...' : 'Pilih file scan dokumen STR...' }}'; $(this).closest('.ot-file-upload-box').find('.file-label-text').text(fn); $(this).closest('.ot-file-upload-box').find('.file-label-icon').removeClass('fa-cloud-arrow-up text-primary').addClass('fa-file-circle-check text-success');">
                                        <span class="text-truncate mr-2" style="font-size: 13px; color: #475569; font-weight: 500;">
                                            <i class="fa-solid fa-cloud-arrow-up mr-1 text-primary file-label-icon"></i>
                                            <span class="file-label-text">{{ $row->file_str ? 'Ganti file scan STR baru...' : 'Pilih file scan dokumen STR...' }}</span>
                                        </span>
                                        <span class="ot-file-btn">
                                            <i class="fa-solid fa-folder-open"></i> Browse
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            No. HP / WhatsApp (Login) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="no_hp" required class="form-control ot-input-modern" value="{{$row->no_hp}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            Password Baru (Opsional)
                                        </label>
                                        <input type="password" name="password" class="form-control ot-input-modern" placeholder="Kosongkan jika tidak ingin diubah">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-group mb-4">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Alamat Domisili / Keterangan Spesialisasi
                                </label>
                                <textarea name="alamat" class="form-control" rows="2" style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">{{$row->alamat}}</textarea>
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


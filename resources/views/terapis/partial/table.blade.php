<!-- Tabel Data Terapis -->
<div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;">
    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 950px; width: 100%;">
        <thead>
            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; width: 50px; text-align: center;">#</th>
                <th style="padding: 12px 14px; min-width: 260px;">Nama Terapis & Keterangan</th>
                <th style="padding: 12px 14px; min-width: 170px;">NIP / Nomor Registrasi</th>
                <th style="padding: 12px 14px; min-width: 160px;">No. HP / WhatsApp (Login)</th>
                <th style="padding: 12px 14px; min-width: 180px;">Penempatan UPT</th>
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
                            <span class="badge font-w600" style="font-size: 11.5px; padding: 4px 8px; border-radius: 6px; background: #f8fafc; color: #334155; border: 1px solid #cbd5e1;">
                                <i class="fa-solid fa-id-card text-muted mr-1" style="font-size: 10px;"></i> {{$row->user->nip ?? ($row->nip ?: '-')}}
                            </span>
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
                                <small class="ot-modal-subtitle">Perbarui rincian identitas dan penempatan terapis</small>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left" style="background: #ffffff;">
                        <form action="{{Route('dokter.update',$row->id)}}" method="POST">
                            {{ csrf_field() }}
                            
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Nama Lengkap Terapis <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" value="{{$row->nama}}" required class="form-control ot-input-modern">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    NIP / Nomor Registrasi
                                </label>
                                <input type="text" name="nip" value="{{$row->user->nip ?? ''}}" class="form-control ot-input-modern">
                            </div>

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

                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    No. HP / WhatsApp (Login) <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="no_hp" required class="form-control ot-input-modern" value="{{$row->no_hp}}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Password Baru (Opsional)
                                </label>
                                <input type="password" name="password" class="form-control ot-input-modern" placeholder="Kosongkan jika tidak ingin mengubah password">
                                <small class="text-muted" style="font-size: 11px;">Isi hanya jika ingin memperbarui kata sandi akun terapis ini.</small>
                            </div>
                           
                            <div class="form-group mb-4">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Alamat Domisili / Keterangan Spesialisasi
                                </label>
                                <textarea name="alamat" class="form-control" rows="3" style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">{{$row->alamat}}</textarea>
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

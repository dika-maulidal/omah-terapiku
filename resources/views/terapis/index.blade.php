@extends('layout.apps')

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
                    <i class="fa-solid fa-user-plus mr-1"></i> + Tambah Terapis
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Terapis Baru -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); padding: 16px 20px;">
                <div>
                    <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                        <i class="fa-solid fa-user-doctor mr-2"></i> Tambah Data Terapis Baru
                    </h5>
                    <small class="text-white-50">Daftarkan terapis dan akun login penanganan pasien</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" style="background: #ffffff;">
                <form action="{{Route('dokter.store')}}" method="POST">
                    {{ csrf_field() }}
                    
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Nama Lengkap Terapis <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" required class="form-control" value="{{ old('nama') }}" placeholder="Contoh: dr. Ahmad Fauzi, Sp.KFR / Sdr. Budi Santoso, S.Tr.Kes" style="height: 42px; font-size: 13px; border-radius: 8px;">
                        @error('nama')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            NIP / Nomor Registrasi Terapis
                        </label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="Contoh: 198902152014021001" style="height: 42px; font-size: 13px; border-radius: 8px;">
                        @error('nip')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Penempatan Omah Terapiku <span class="text-danger">*</span>
                        </label>
                        <select name="poli" class="form-control" required style="height: 42px; font-size: 13px; border-radius: 8px;">
                            <option value="">-- Pilih Lokasi Omah Terapiku --</option>
                            @foreach ($poli as $item)
                                <option value="{{$item->nama}}" {{ old('poli') == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                            @endforeach
                        </select>
                        @error('poli')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            No. HP / WhatsApp (Login) <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="no_hp" required class="form-control" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" style="height: 42px; font-size: 13px; border-radius: 8px;">
                        <small class="text-muted" style="font-size: 11px;">Nomor ini digunakan juga sebagai identitas login terapis ke sistem.</small>
                        @error('no_hp')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Password Login <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password" required class="form-control" placeholder="Minimal 4 karakter" style="height: 42px; font-size: 13px; border-radius: 8px;">
                        @error('password')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Alamat Domisili / Keterangan Spesialisasi
                        </label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat tinggal atau keterangan spesialisasi terapis..." style="font-size: 13px; border-radius: 8px;">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 22px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
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
                            Total: <strong class="text-primary font-w700">{{ $datas->total() }}</strong> Terapis & Tenaga Medis
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            
                            <!-- Filter Penempatan Omah Terapi -->
                            <div class="ot-filter-wrapper" style="width: 180px;">
                                <i class="fa-solid fa-hospital-user"></i>
                                <select name="poli" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Penempatan Lokasi" style="width: 100%;">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($poli as $item)
                                        <option value="{{$item->nama}}" {{ request('poli') == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 145px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Status Akun" style="width: 100%;">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 190px; max-width: 230px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" name="keyword" value="{{request('keyword')}}" placeholder="Cari terapis, HP, NIP..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            @if(request('keyword') || request('poli') || request('status') !== null && request('status') !== '')
                                <a href="{{ Route('terapis') }}" class="btn btn-sm btn-light font-w600" style="height: 38px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 12px; transition: all 0.2s ease;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right mr-1" style="color: #64748b;"></i> Reset
                                </a>
                            @endif

                        </form>
                    </div>
                </div>

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
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2" style="width: 36px; height: 36px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                                                    <i class="fa-solid fa-user-doctor"></i>
                                                </div>
                                                <div>
                                                    <strong class="text-dark d-block" style="font-size: 13.5px; font-weight: 700;">
                                                        {{$row->nama}}
                                                    </strong>
                                                    @if($row->alamat)
                                                        <small class="text-muted d-block" style="font-size: 11.5px;">
                                                            <i class="fa-solid fa-location-dot mr-1" style="font-size: 10px;"></i>{{$row->alamat}}
                                                        </small>
                                                    @endif
                                                </div>
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
                                                <button type="button" data-toggle="modal" data-target="#edit{{$row->id}}" class="btn btn-xs font-w600" style="padding: 5px 9px; font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;" title="Edit Terapis">
                                                    <i class="fa-solid fa-pencil mr-1"></i> Edit
                                                </button>

                                                <!-- Tombol Hapus / Nonaktifkan -->
                                                <a href="#" class="btn btn-xs font-w600 delete" r-link="{{Route('dokter.delete',$row->id)}}"
                                                   r-name="{{$row->nama}}" r-id="{{$row->id}}" style="padding: 5px 8px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" title="Hapus / Nonaktifkan Terapis">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>

                                            <!-- Modal Ganti Password Login Terapis -->
                                            <div class="modal fade" id="key{{$row->user_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); padding: 16px 20px;">
                                                            <div>
                                                                <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                                                                    <i class="fa-solid fa-key mr-2"></i> Ganti Password Akun Terapis
                                                                </h5>
                                                                <small class="text-white-50">Perbarui kata sandi untuk: {{$row->nama}}</small>
                                                            </div>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
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
                                                                    <input type="password" name="password" required class="form-control" placeholder="Minimal 6 karakter" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                    @error('password')
                                                                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group mb-4">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        Konfirmasi Password Baru <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="password" name="password_konfirm" required class="form-control" placeholder="Ulangi password baru" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                    @error('password_konfirm')
                                                                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                                                    @enderror
                                                                </div>
                                                                
                                                                <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
                                                                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-warning font-w700 text-white" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important; border: none !important; padding: 9px 22px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);">
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
                                                    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); padding: 16px 20px;">
                                                            <div>
                                                                <h5 class="modal-title font-w700 text-white mb-0" style="font-size: 16px;">
                                                                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Data Terapis
                                                                </h5>
                                                                <small class="text-white-50">Perbarui rincian identitas dan penempatan terapis</small>
                                                            </div>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
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
                                                                    <input type="text" name="nama" value="{{$row->nama}}" required class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        NIP / Nomor Registrasi
                                                                    </label>
                                                                    <input type="text" name="nip" value="{{$row->user->nip ?? ''}}" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        Penempatan Omah Terapiku <span class="text-danger">*</span>
                                                                    </label>
                                                                    <select name="poli" class="form-control" required style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                        @foreach ($poli as $item)
                                                                            <option value="{{$item->nama}}" {{ $item->nama == $row->poli ? 'selected' : '' }}>{{$item->nama}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        No. HP / WhatsApp (Login) <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text" name="no_hp" required class="form-control" value="{{$row->no_hp}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        Password Baru (Opsional)
                                                                    </label>
                                                                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                                                    <small class="text-muted" style="font-size: 11px;">Isi hanya jika ingin memperbarui kata sandi akun terapis ini.</small>
                                                                </div>
                                                               
                                                                <div class="form-group mb-4">
                                                                    <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                                                        Alamat Domisili / Keterangan Spesialisasi
                                                                    </label>
                                                                    <textarea name="alamat" class="form-control" rows="3" style="font-size: 13px; border-radius: 8px;">{{$row->alamat}}</textarea>
                                                                </div>
                                                                
                                                                <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
                                                                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 22px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                                                        <i class="fa-solid fa-floppy-disk mr-1"></i> Update Data
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
                    <div>
                        {{ $datas->appends(request()->except('page'))->links() }}
                    </div>
                </div>

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
                title: 'Hapus / Nonaktifkan Terapis?',
                text: "Yakin ingin menghapus data terapis: " + name + " ini?",
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

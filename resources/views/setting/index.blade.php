@extends('layout.apps')

@section('style')
<style>
    /* Underline Tabs Navigation */
    .ot-underline-tabs {
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        gap: 24px;
        margin-bottom: 24px;
        padding-left: 0;
        list-style: none;
        flex-wrap: wrap;
    }
    .ot-underline-tabs .nav-item {
        margin-bottom: 0;
    }
    .ot-underline-tabs .nav-link {
        background: transparent !important;
        border: none !important;
        border-bottom: 2.5px solid transparent !important;
        margin-bottom: -2px;
        padding: 12px 6px 14px 6px;
        color: #64748b;
        font-size: 14.5px;
        font-weight: 600;
        transition: all 0.2s ease;
        border-radius: 0 !important;
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
        cursor: pointer;
        user-select: none;
    }
    .ot-underline-tabs .nav-link:hover {
        color: #1e40af;
    }
    .ot-underline-tabs .nav-link.active {
        color: #2563eb !important;
        font-weight: 700 !important;
        border-bottom: 2.5px solid #2563eb !important;
    }
    .ot-underline-tabs .nav-link i {
        font-size: 15px;
        color: #94a3b8;
        transition: color 0.2s ease;
    }
    .ot-underline-tabs .nav-link:hover i {
        color: #1e40af;
    }
    .ot-underline-tabs .nav-link.active i {
        color: #2563eb !important;
    }

    /* Password Input Toggle */
    .password-input-group {
        position: relative;
    }
    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        z-index: 10;
        padding: 4px 8px;
        font-size: 15px;
        transition: color 0.2s ease;
    }
    .password-toggle-btn:hover {
        color: #1e40af;
    }
    .password-toggle-btn:focus {
        outline: none;
    }

    /* Profile Detail Item */
    .profile-info-box {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 10px;
        padding: 14px 16px;
        height: 100%;
        transition: all 0.2s ease;
    }
    .profile-info-box:hover {
        border-color: #cbd5e1;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    /* File Upload Box (STR) */
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
</style>
@endsection

@section('content')

@php
    $isPasswordTab = $errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation') || session('tab') == 'password';
    $isUpdateTab = ($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('nip') || session('tab') == 'update') && !$isPasswordTab;
    $isMyProfileTab = !$isPasswordTab && !$isUpdateTab;
@endphp

<!-- Header Section (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
            <div class="d-flex align-items-center">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Pengaturan Akun</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item active text-muted">Pengaturan Akun</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                
                <!-- Underline Tabs Header (3 Tabs) -->
                <ul class="nav ot-underline-tabs" id="settingTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $isMyProfileTab ? 'active' : '' }}" id="my-profile-tab" data-toggle="tab" href="#tab-my-profile" role="tab" aria-controls="tab-my-profile" aria-selected="{{ $isMyProfileTab ? 'true' : 'false' }}">
                            <i class="fa-solid fa-circle-user mr-2"></i> My Profile
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $isUpdateTab ? 'active' : '' }}" id="update-profile-tab" data-toggle="tab" href="#tab-update-profile" role="tab" aria-controls="tab-update-profile" aria-selected="{{ $isUpdateTab ? 'true' : 'false' }}">
                            <i class="fa-solid fa-user-pen mr-2"></i> Update Profile
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $isPasswordTab ? 'active' : '' }}" id="password-tab" data-toggle="tab" href="#tab-password" role="tab" aria-controls="tab-password" aria-selected="{{ $isPasswordTab ? 'true' : 'false' }}">
                            <i class="fa-solid fa-key mr-2"></i> Password & Keamanan
                        </a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="settingTabContent">
                    
                    <!-- ========================================================= -->
                    <!-- TAB 1: MY PROFILE (RINGKASAN & DETAIL PROFIL) -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $isMyProfileTab ? 'show active' : '' }}" id="tab-my-profile" role="tabpanel" aria-labelledby="my-profile-tab">
                        
                        <!-- Profile Detail Information Grid Header -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-id-card mr-1"></i> Informasi Rincian Akun
                            </h6>
                        </div>
                        
                        <div class="row" style="row-gap: 14px;">
                            <div class="col-md-6 col-lg-4">
                                <div class="profile-info-box">
                                    <small class="text-muted d-block mb-1" style="font-size: 11.5px;"><i class="fa-solid fa-user mr-1 text-primary"></i> Nama Lengkap</small>
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->name }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="profile-info-box">
                                    <small class="text-muted d-block mb-1"><i class="fa-solid fa-id-badge mr-1 text-primary"></i> NIP / Identitas Pegawai</small>
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->nip ?: '-' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="profile-info-box">
                                    <small class="text-muted d-block mb-1"><i class="fa-brands fa-whatsapp mr-1 text-success"></i> No. HP / WhatsApp</small>
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->phone ?: '-' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="profile-info-box">
                                    <small class="text-muted d-block mb-1"><i class="fa-solid fa-envelope mr-1 text-primary"></i> Alamat Email</small>
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->email ?: '-' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="profile-info-box">
                                    <small class="text-muted d-block mb-1"><i class="fa-solid fa-shield-halved mr-1 text-primary"></i> Role Akses Sistem</small>
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->role_label() }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="profile-info-box">
                                    <small class="text-muted d-block mb-1"><i class="fa-solid fa-calendar-check mr-1 text-primary"></i> Terdaftar Sejak</small>
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Khusus Terapis: Kotak Informasi STR & Legalitas -->
                        @if($user->role == 3 || $user->role_display() == 'Dokter' || isset($terapis))
                            @php
                                $terapisObj = $terapis ?? ($user->terapis ?: \App\Models\Dokter::where('user_id', $user->id)->first());
                            @endphp
                            <div class="mt-4 p-3 p-md-4" style="background: #f8fafc; border: 1.5px solid #dbeafe; border-radius: 12px;">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="font-w700 mb-0" style="color: #1e40af; font-size: 14px;">
                                        <i class="fa-solid fa-certificate mr-2 text-primary"></i> Legalitas & Sertifikat STR Terapis
                                    </h6>
                                    <span class="badge" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11.5px; padding: 4px 10px; border-radius: 6px;">
                                        Tenaga Kesehatan Terdaftar
                                    </span>
                                </div>
                                <div class="row" style="row-gap: 16px;">
                                    <div class="col-md-4">
                                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; height: 100%; display: flex; flex-direction: column; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                                            <small class="text-muted d-block mb-1.5" style="font-size: 12px; font-weight: 500;">
                                                <i class="fa-solid fa-hashtag mr-1 text-primary"></i> Nomor STR
                                            </small>
                                            <strong class="text-dark font-w700 d-block" style="font-size: 14.5px; letter-spacing: 0.3px;">
                                                {{ $terapisObj->no_str ?? 'Belum Dicatat' }}
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; height: 100%; display: flex; flex-direction: column; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                                            <small class="text-muted d-block mb-1.5" style="font-size: 12px; font-weight: 500;">
                                                <i class="fa-solid fa-calendar-days mr-1 text-primary"></i> Masa Berlaku STR
                                            </small>
                                            <strong class="text-dark font-w700 d-block" style="font-size: 14.5px;">
                                                {{ $terapisObj->masa_berlaku_str ?? 'Seumur Hidup' }}
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; height: 100%; display: flex; flex-direction: column; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                                            <small class="text-muted d-block mb-1.5" style="font-size: 12px; font-weight: 500;">
                                                <i class="fa-solid fa-file-lines mr-1 text-primary"></i> Berkas Scan Dokumen
                                            </small>
                                            @if($terapisObj && $terapisObj->file_str && file_exists(public_path('images/terapis/str/' . $terapisObj->file_str)))
                                                <div class="mt-1">
                                                    <button type="button" class="btn btn-sm btn-primary font-w600 btn-open-preview-berkas" data-type="str" data-title="Sertifikat STR: {{ $user->name }}" data-url="{{ asset('images/terapis/str/' . $terapisObj->file_str) }}" data-filename="{{ $terapisObj->file_str }}" style="padding: 6px 14px; font-size: 12px; border-radius: 6px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);">
                                                        <i class="fa-solid fa-eye mr-1"></i> Lihat Dokumen STR
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted d-block mt-1" style="font-size: 12.5px;"><em>Belum diunggah</em></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tombol Aksi di Bagian Bawah -->
                        <div class="d-flex align-items-center flex-wrap mt-4 pt-3 border-top" style="border-color: #f1f5f9 !important; gap: 10px;">
                            <button type="button" class="btn btn-sm btn-primary font-w600 btn-switch-to-tab" data-target="#tab-update-profile" style="padding: 8px 18px; font-size: 13px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);">
                                <i class="fa-solid fa-pencil mr-1"></i> Edit Profil
                            </button>
                            <button type="button" class="btn btn-sm btn-light font-w600 btn-switch-to-tab" data-target="#tab-password" style="padding: 8px 18px; font-size: 13px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569;">
                                <i class="fa-solid fa-key mr-1"></i> Ganti Password
                            </button>
                        </div>

                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 2: UPDATE PROFILE -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $isUpdateTab ? 'show active' : '' }}" id="tab-update-profile" role="tabpanel" aria-labelledby="update-profile-tab">
                        <div class="mb-3">
                            <h5 class="font-w700 mb-1" style="color: #1e40af; font-size: 16px;">Update Informasi Profil</h5>
                            <p class="text-muted mb-0" style="font-size: 12.5px;">Perbarui data identitas diri, kontak, dan sertifikasi STR Anda.</p>
                        </div>

                        <form action="{{ Route('setting.profile') }}" method="POST" id="formUpdateProfil" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Nama Lengkap -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="name" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name', $user->name) }}" 
                                               required
                                               placeholder="Masukkan nama lengkap"
                                               style="height: 42px; font-size: 13px; border-radius: 8px;">
                                        @error('name')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- NIP / Username -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            NIP / Nomor Identitas Pegawai
                                        </label>
                                        <input type="text" 
                                               name="nip" 
                                               class="form-control @error('nip') is-invalid @enderror" 
                                               value="{{ old('nip', $user->nip) }}" 
                                               placeholder="Contoh: 198501012010012001"
                                               style="height: 42px; font-size: 13px; border-radius: 8px;">
                                        @error('nip')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nomor Telepon / WhatsApp -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            No. HP / WhatsApp
                                        </label>
                                        <input type="text" 
                                               name="phone" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               value="{{ old('phone', $user->phone) }}" 
                                               placeholder="Contoh: 081234567890"
                                               style="height: 42px; font-size: 13px; border-radius: 8px;">
                                        @error('phone')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            Alamat Email
                                        </label>
                                        <input type="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', $user->email) }}" 
                                               placeholder="alamat@email.com"
                                               style="height: 42px; font-size: 13px; border-radius: 8px;">
                                        @error('email')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Khusus Akun Terapis: Form Pembaruan STR -->
                            @if($user->role == 3 || $user->role_display() == 'Dokter' || isset($terapis))
                                @php
                                    $terapisObj = $terapis ?? ($user->terapis ?: \App\Models\Dokter::where('user_id', $user->id)->first());
                                @endphp
                                <div class="p-3 mb-3" style="background: #f8fafc; border: 1.5px solid #dbeafe; border-radius: 10px;">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <label class="form-label font-w700 mb-0" style="color: #1e40af; font-size: 13px;">
                                            <i class="fa-solid fa-certificate mr-1 text-primary"></i> Pembaruan Legalitas & Sertifikat STR Terapis
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
                                                <input type="text" name="no_str" class="form-control" value="{{ old('no_str', $terapisObj->no_str ?? '') }}" placeholder="Contoh: 12 04 5 2 1 19-1234567" style="height: 44px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                                                @error('no_str')
                                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">
                                                    Masa Berlaku STR
                                                </label>
                                                <input type="text" name="masa_berlaku_str" class="form-control" value="{{ old('masa_berlaku_str', $terapisObj->masa_berlaku_str ?? '') }}" placeholder="Contoh: Seumur Hidup / 31 Desember 2028" style="height: 44px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                                                @error('masa_berlaku_str')
                                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <label class="form-label font-w600 text-dark mb-0" style="font-size: 12.5px;">
                                                Ganti / Upload Scan Dokumen STR
                                                <span class="text-muted font-w400" style="font-size: 11px;">(PDF, JPG, PNG &bull; Maks. 5MB)</span>
                                            </label>
                                            @if($terapisObj && $terapisObj->file_str && file_exists(public_path('images/terapis/str/' . $terapisObj->file_str)))
                                                <a href="{{ asset('images/terapis/str/' . $terapisObj->file_str) }}" target="_blank" class="badge badge-primary font-w600" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; padding: 3px 8px; border-radius: 6px;">
                                                    <i class="fa-solid fa-file-lines mr-1"></i> File Saat Ini: {{ Str::limit($terapisObj->file_str, 20) }}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="ot-file-upload-box">
                                            <input type="file" name="file_str" class="ot-file-upload-input" id="file_str_setting" accept=".pdf,.jpg,.jpeg,.png" onchange="var fn = this.files[0] ? this.files[0].name : '{{ ($terapisObj && $terapisObj->file_str) ? 'Ganti file scan STR baru...' : 'Pilih file scan dokumen STR...' }}'; $(this).closest('.ot-file-upload-box').find('.file-label-text').text(fn); $(this).closest('.ot-file-upload-box').find('.file-label-icon').removeClass('fa-cloud-arrow-up text-primary').addClass('fa-file-circle-check text-success');">
                                            <span class="text-truncate mr-2" style="font-size: 13px; color: #475569; font-weight: 500;">
                                                <i class="fa-solid fa-cloud-arrow-up mr-1 text-primary file-label-icon"></i>
                                                <span class="file-label-text">{{ ($terapisObj && $terapisObj->file_str) ? 'Ganti file scan STR baru...' : 'Pilih file scan dokumen STR...' }}</span>
                                            </span>
                                            <span class="ot-file-btn">
                                                <i class="fa-solid fa-folder-open"></i> Browse
                                            </span>
                                        </div>
                                        @error('file_str')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-end align-items-center mt-3 pt-3 border-top">
                                <button type="submit" class="btn btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 22px; font-size: 13px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan Profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 3: PASSWORD & KEAMANAN -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $isPasswordTab ? 'show active' : '' }}" id="tab-password" role="tabpanel" aria-labelledby="password-tab">
                        <div class="mb-3">
                            <h5 class="font-w700 mb-1" style="color: #1e40af; font-size: 16px;">Ubah Kata Sandi Akun</h5>
                            <p class="text-muted mb-0" style="font-size: 12.5px;">Pastikan kata sandi baru Anda unik dan memiliki minimal 6 karakter.</p>
                        </div>

                        <form action="{{ Route('setting.password') }}" method="POST" id="formGantiPassword">
                            @csrf

                            <!-- 1. Password Saat Ini -->
                            <div class="form-group mb-3">
                                <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                    Password Saat Ini <span class="text-danger">*</span>
                                </label>
                                <div class="password-input-group">
                                    <input type="password" 
                                           name="current_password" 
                                           id="current_password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           placeholder="Masukkan password yang sedang digunakan saat ini"
                                           required 
                                           autocomplete="current-password"
                                           style="padding-right: 45px; border-radius: 8px; height: 42px; font-size: 13px;">
                                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('current_password', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted" style="font-size: 11.5px; margin-top: 4px;">
                                    Masukkan password saat ini untuk memverifikasi kepemilikan akun.
                                </small>
                            </div>

                            <div class="row">
                                <!-- 2. Password Baru -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            Password Baru <span class="text-danger">*</span>
                                        </label>
                                        <div class="password-input-group">
                                            <input type="password" 
                                                   name="password" 
                                                   id="new_password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Masukkan password baru (min 6 karakter)"
                                                   required 
                                                   minlength="6"
                                                   autocomplete="new-password"
                                                   style="padding-right: 45px; border-radius: 8px; height: 42px; font-size: 13px;">
                                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('new_password', this)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">
                                                <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <small class="form-text text-muted" style="font-size: 11.5px; margin-top: 4px;">
                                            Minimal 6 karakter kombinasi huruf & angka.
                                        </small>
                                    </div>
                                </div>

                                <!-- 3. Konfirmasi Password Baru -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                                            Ulangi Password Baru <span class="text-danger">*</span>
                                        </label>
                                        <div class="password-input-group">
                                            <input type="password" 
                                                   name="password_confirmation" 
                                                   id="password_confirmation" 
                                                   class="form-control" 
                                                   placeholder="Ketik ulang password baru Anda"
                                                   required 
                                                   minlength="6"
                                                   autocomplete="new-password"
                                                   style="padding-right: 45px; border-radius: 8px; height: 42px; font-size: 13px;">
                                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password_confirmation', this)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        <div id="password-match-feedback" class="font-w600 mt-1" style="display: none; font-size: 11.5px;"></div>
                                        <small class="form-text text-muted" style="font-size: 11.5px; margin-top: 4px;">
                                            Harus sama persis dengan Password Baru.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Keamanan -->
                            <div class="p-3 my-2" style="background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 8px;">
                                <div class="d-flex">
                                    <i class="fa-solid fa-triangle-exclamation mr-2 text-warning" style="font-size: 15px; margin-top: 2px;"></i>
                                    <div>
                                        <strong class="d-block text-dark font-w700" style="font-size: 12.5px;">Perhatian Keamanan</strong>
                                        <p class="mb-0 text-muted" style="font-size: 11.5px;">Setelah berhasil memperbarui password, gunakan password baru tersebut untuk sesi login berikutnya.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-3 pt-3 border-top">
                                <button type="submit" class="btn btn-warning font-w700 text-white" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important; border: none !important; padding: 8px 22px; font-size: 13px; border-radius: 8px; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);">
                                    <i class="fa-solid fa-lock mr-1"></i> Perbarui Password
                                </button>
                            </div>
                        </form>
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
    // Toggle Password Visibility Function
    function togglePasswordVisibility(inputId, btnElement) {
        const inputField = document.getElementById(inputId);
        const icon = btnElement.querySelector('i');
        
        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            icon.style.color = '#2563eb';
        } else {
            inputField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.style.color = '#94a3b8';
        }
    }

    $(document).ready(function() {
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

        // Fix modal scroll when preview modal is closed
        $('#modalPreviewBerkas').on('hidden.bs.modal', function () {
            if ($('.modal.show').length > 0) {
                $('body').addClass('modal-open');
            }
        });

        // Tab switching function
        function activateTab(targetHash) {
            if (!targetHash) return;
            var tabLink = $('.ot-underline-tabs .nav-link[href="' + targetHash + '"]');
            if (tabLink.length) {
                // Update tabs header
                $('.ot-underline-tabs .nav-link').removeClass('active').attr('aria-selected', 'false');
                tabLink.addClass('active').attr('aria-selected', 'true');
                
                // Update tab content panes
                $('#settingTabContent .tab-pane').removeClass('show active');
                $(targetHash).addClass('show active');
            }
        }

        // Handle click on underline tabs
        $('.ot-underline-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var targetHash = $(this).attr('href');
            activateTab(targetHash);
            if (history.pushState) {
                history.pushState(null, null, targetHash);
            } else {
                window.location.hash = targetHash;
            }
        });

        // Quick switch buttons inside My Profile tab
        $('.btn-switch-to-tab').on('click', function(e) {
            e.preventDefault();
            var targetHash = $(this).data('target');
            activateTab(targetHash);
            if (history.pushState) {
                history.pushState(null, null, targetHash);
            } else {
                window.location.hash = targetHash;
            }
        });

        // Activate tab on page load if hash exists
        if (window.location.hash) {
            activateTab(window.location.hash);
        }

        // Listen for browser back/forward or hash changes
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                activateTab(window.location.hash);
            }
        });

        // Real-time password confirmation matching check
        const newPasswordInput = $('#new_password');
        const confirmPasswordInput = $('#password_confirmation');
        const feedbackDiv = $('#password-match-feedback');

        function checkPasswordMatch() {
            const pass = newPasswordInput.val();
            const confirm = confirmPasswordInput.val();

            if (confirm.length === 0) {
                feedbackDiv.hide();
                confirmPasswordInput.removeClass('is-invalid is-valid');
                return;
            }

            feedbackDiv.show();
            if (pass === confirm) {
                feedbackDiv.html('<span class="text-success"><i class="fa-solid fa-circle-check mr-1"></i>Password konfirmasi cocok</span>');
                confirmPasswordInput.removeClass('is-invalid').addClass('is-valid');
            } else {
                feedbackDiv.html('<span class="text-danger"><i class="fa-solid fa-circle-xmark mr-1"></i>Password konfirmasi tidak cocok</span>');
                confirmPasswordInput.removeClass('is-valid').addClass('is-invalid');
            }
        }

        newPasswordInput.on('input', function() {
            if (confirmPasswordInput.val().length > 0) {
                checkPasswordMatch();
            }
        });

        confirmPasswordInput.on('input', checkPasswordMatch);
    });
</script>
@endsection

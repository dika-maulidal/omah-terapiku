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
            <div>
                <span class="badge font-w700" style="font-size: 12px; padding: 6px 14px; border-radius: 20px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-shield-halved mr-1"></i> {{ $user->role_display() }}
                </span>
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
                        
                        <!-- Profile Hero Banner -->
                        <div class="p-4 mb-4" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); border-radius: 12px; color: #ffffff;">
                            <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 16px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3" style="width: 72px; height: 72px; border-radius: 50%; background: #ffffff; padding: 3px; box-shadow: 0 4px 14px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <div style="width: 100%; height: 100%; border-radius: 50%; background: #eff6ff; color: #1e40af; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-w700 mb-1" style="font-size: 18px;">{{ $user->name }}</h4>
                                        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                            <span class="badge font-w700" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: rgba(255,255,255,0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.3);">
                                                <i class="fa-solid fa-shield-halved mr-1"></i> {{ $user->role_display() }}
                                            </span>
                                            <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                <i class="fa-solid fa-circle mr-1" style="font-size: 7px; color: #10b981;"></i> {{ $user->status_display() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                    <button type="button" class="btn btn-sm btn-light font-w700 btn-switch-to-tab" data-target="#tab-update-profile" style="padding: 8px 16px; font-size: 12.5px; border-radius: 8px; border: none; color: #1e40af;">
                                        <i class="fa-solid fa-pencil mr-1"></i> Edit Profil
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-light font-w700 btn-switch-to-tab" data-target="#tab-password" style="padding: 8px 16px; font-size: 12.5px; border-radius: 8px; border-color: rgba(255,255,255,0.4); color: #ffffff;">
                                        <i class="fa-solid fa-key mr-1"></i> Ganti Password
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Detail Information Grid -->
                        <h6 class="font-w700 mb-3" style="color: #1e40af; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa-solid fa-id-card mr-1"></i> Informasi Rincian Akun
                        </h6>
                        
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
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->role_display() }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="profile-info-box">
                                    <small class="text-muted d-block mb-1"><i class="fa-solid fa-calendar-check mr-1 text-primary"></i> Terdaftar Sejak</small>
                                    <strong class="text-dark d-block" style="font-size: 14px;">{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</strong>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 2: UPDATE PROFILE -->
                    <!-- ========================================================= -->
                    <div class="tab-pane fade {{ $isUpdateTab ? 'show active' : '' }}" id="tab-update-profile" role="tabpanel" aria-labelledby="update-profile-tab">
                        <div class="mb-3">
                            <h5 class="font-w700 mb-1" style="color: #1e40af; font-size: 16px;">Update Informasi Profil</h5>
                            <p class="text-muted mb-0" style="font-size: 12.5px;">Perbarui data identitas diri dan informasi kontak akun Anda.</p>
                        </div>

                        <form action="{{ Route('setting.profile') }}" method="POST" id="formUpdateProfil">
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

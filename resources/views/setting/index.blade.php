@extends('layout.apps')

@section('header')
<style>
    .setting-profile-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #edf2f9;
        box-shadow: 0 4px 20px rgba(46, 75, 130, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .setting-profile-header {
        background: linear-gradient(135deg, #2e4b82 0%, #1e355e 100%);
        padding: 30px 20px;
        text-align: center;
        color: #ffffff;
        position: relative;
    }
    .setting-avatar-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
        margin: 0 auto 15px auto;
        background: #ffffff;
        border-radius: 50%;
        padding: 4px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }
    .setting-avatar-wrapper img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    .setting-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #edf2f9;
        box-shadow: 0 4px 20px rgba(46, 75, 130, 0.06);
        margin-bottom: 25px;
    }
    .setting-card .card-header {
        background: #ffffff;
        border-bottom: 1px solid #edf2f9;
        padding: 18px 24px;
        border-radius: 16px 16px 0 0;
    }
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
        color: #8fa0bc;
        cursor: pointer;
        z-index: 10;
        padding: 4px 8px;
        font-size: 15px;
        transition: color 0.2s ease;
    }
    .password-toggle-btn:hover {
        color: var(--ot-navy);
    }
    .password-toggle-btn:focus {
        outline: none;
    }
    .form-control.is-invalid {
        border-color: #e53935 !important;
    }
    .security-note {
        background: #fff8e7;
        border-left: 4px solid #f5a623;
        border-radius: 8px;
        padding: 14px 18px;
        color: #7c5204;
        font-size: 13px;
    }
</style>
@endsection

@section('content')
<div class="row page-titles mx-0 mb-4">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4 class="font-w700" style="color: var(--ot-navy) !important;">
                <i class="fa-solid fa-gear mr-2" style="color: var(--ot-yellow);"></i>Pengaturan Akun
            </h4>
            <span class="text-muted fs-13">Kelola informasi profil dan ubah kata sandi akun Anda</span>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengaturan</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <!-- Kolom Kiri: Info Profil Ringkas -->
    <div class="col-xl-4 col-lg-5">
        <div class="setting-profile-card mb-4">
            <div class="setting-profile-header">
                <div class="setting-avatar-wrapper">
                    <img src="{{ asset('images/profile.png') }}" alt="Avatar User">
                </div>
                <h5 class="text-white font-w700 mb-1">{{ $user->name }}</h5>
                <p class="fs-12 text-white-50 mb-2">
                    @if(!empty($user->nip))
                        NIP: {{ $user->nip }}
                    @elseif(!empty($user->email))
                        {{ $user->email }}
                    @else
                        Akun Pengguna
                    @endif
                </p>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <span class="badge badge-warning text-white px-3 py-1 font-w600" style="background: var(--ot-yellow) !important; border-radius: 20px; font-size: 11px;">
                        <i class="fa-solid fa-shield-halved mr-1"></i>{{ $user->role_display() }}
                    </span>
                    <span class="badge badge-success px-3 py-1 font-w600" style="background: var(--ot-green) !important; border-radius: 20px; font-size: 11px;">
                        <i class="fa-solid fa-circle-check mr-1"></i>{{ $user->status_display() }}
                    </span>
                </div>
            </div>
            <div class="card-body p-4">
                <h6 class="font-w700 mb-3" style="color: var(--ot-navy);">Detail Akun</h6>
                <ul class="list-group list-group-flush fs-13">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="fa-solid fa-circle-user mr-2 text-primary"></i>Nama Lengkap</span>
                        <span class="font-w600 text-black">{{ $user->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="fa-solid fa-id-badge mr-2 text-primary"></i>NIP / ID</span>
                        <span class="font-w600 text-black">{{ $user->nip ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="fa-solid fa-phone mr-2 text-primary"></i>No. Telepon/WA</span>
                        <span class="font-w600 text-black">{{ $user->phone ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="fa-solid fa-envelope mr-2 text-primary"></i>Email</span>
                        <span class="font-w600 text-black">{{ $user->email ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><i class="fa-solid fa-clock mr-2 text-primary"></i>Terdaftar Sejak</span>
                        <span class="font-w600 text-black">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                    </li>
                </ul>

                <hr class="my-3" style="border-top: 1px dashed #e2e8f0;">

                <div class="security-note">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    <strong>Tips Keamanan:</strong> Gunakan password yang kuat dengan panjang minimal 6 karakter, kombinasikan huruf kapital, angka, dan simbol untuk keamanan maksimal.
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Form Ubah Password & Form Profil -->
    <div class="col-xl-8 col-lg-7">
        
        <!-- CARD 1: FORM UBAH PASSWORD -->
        <div class="setting-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title font-w700 mb-0" style="color: var(--ot-navy); font-size: 16px;">
                    <i class="fa-solid fa-key mr-2" style="color: var(--ot-yellow);"></i>Ganti Password
                </h5>
                <span class="badge badge-light text-muted font-w500 fs-12 px-2 py-1">Wajib Verifikasi</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ Route('setting.password') }}" method="POST" id="formGantiPassword">
                    @csrf

                    <!-- 1. Password Saat Ini -->
                    <div class="form-group mb-4">
                        <label class="text-black font-w600 fs-14 mb-1">
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
                                   style="padding-right: 45px; border-radius: 8px; height: 44px;">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('current_password', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block mt-1 font-w500 fs-12">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted fs-12 mt-1">
                            Masukkan password lama yang saat ini aktif untuk memverifikasi kepemilikan akun.
                        </small>
                    </div>

                    <div class="row">
                        <!-- 2. Password Baru (Input 1) -->
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="text-black font-w600 fs-14 mb-1">
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
                                           style="padding-right: 45px; border-radius: 8px; height: 44px;">
                                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('new_password', this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block mt-1 font-w500 fs-12">
                                        <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted fs-12 mt-1">
                                    Minimal 6 karakter.
                                </small>
                            </div>
                        </div>

                        <!-- 3. Konfirmasi Password Baru (Input 2) -->
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="text-black font-w600 fs-14 mb-1">
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
                                           style="padding-right: 45px; border-radius: 8px; height: 44px;">
                                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password_confirmation', this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <div id="password-match-feedback" class="fs-12 mt-1 font-w500" style="display: none;"></div>
                                <small class="form-text text-muted fs-12 mt-1">
                                    Harus sama persis dengan Password Baru.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center pt-2">
                        <button type="submit" class="btn btn-primary font-w600" style="padding: 10px 24px; border-radius: 8px; font-size: 13.5px;">
                            <i class="fa fa-lock mr-2"></i>Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CARD 2: FORM UPDATE PROFIL -->
        <div class="setting-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title font-w700 mb-0" style="color: var(--ot-navy); font-size: 16px;">
                    <i class="fa fa-user-edit mr-2" style="color: var(--ot-cyan);"></i>Informasi Profil
                </h5>
                <span class="badge badge-light text-muted font-w500 fs-12 px-2 py-1">Data Pengguna</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ Route('setting.profile') }}" method="POST" id="formUpdateProfil">
                    @csrf
                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="text-black font-w600 fs-14 mb-1">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       style="border-radius: 8px; height: 44px;">
                                @error('name')
                                    <div class="invalid-feedback d-block mt-1 font-w500 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- NIP / Username -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="text-black font-w600 fs-14 mb-1">NIP</label>
                                <input type="text" 
                                       name="nip" 
                                       class="form-control @error('nip') is-invalid @enderror" 
                                       value="{{ old('nip', $user->nip) }}" 
                                       placeholder="Nomor Induk Pegawai"
                                       style="border-radius: 8px; height: 44px;">
                                @error('nip')
                                    <div class="invalid-feedback d-block mt-1 font-w500 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="text-black font-w600 fs-14 mb-1">No. Telepon / WhatsApp</label>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $user->phone) }}" 
                                       placeholder="Contoh: 08123456789"
                                       style="border-radius: 8px; height: 44px;">
                                @error('phone')
                                    <div class="invalid-feedback d-block mt-1 font-w500 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="text-black font-w600 fs-14 mb-1">Email</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" 
                                       placeholder="alamat@email.com"
                                       style="border-radius: 8px; height: 44px;">
                                @error('email')
                                    <div class="invalid-feedback d-block mt-1 font-w500 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center pt-2">
                        <button type="submit" class="btn btn-outline-primary font-w600" style="padding: 10px 24px; border-radius: 8px; font-size: 13.5px;">
                            <i class="fa fa-save mr-2"></i>Simpan Perubahan Profil
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
    // Fungsi Toggle Password Visibility
    function togglePasswordVisibility(inputId, btnElement) {
        const inputField = document.getElementById(inputId);
        const icon = btnElement.querySelector('i');
        
        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            icon.style.color = 'var(--ot-navy)';
        } else {
            inputField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.style.color = '#8fa0bc';
        }
    }

    // Real-time password confirmation matching check
    $(document).ready(function() {
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
                feedbackDiv.html('<span class="text-success"><i class="fa fa-check-circle mr-1"></i>Password konfirmasi cocok</span>');
                confirmPasswordInput.removeClass('is-invalid').addClass('is-valid');
            } else {
                feedbackDiv.html('<span class="text-danger"><i class="fa fa-times-circle mr-1"></i>Password konfirmasi tidak cocok</span>');
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

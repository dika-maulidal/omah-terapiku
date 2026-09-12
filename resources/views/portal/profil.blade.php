@extends('portal.layout.apps')

@section('title', 'Profil Penerima Manfaat')

@section('style')
<style>
    .profile-info-table td {
        padding: 13px 20px;
        vertical-align: middle;
    }
    .profile-info-table tr:not(:last-child) {
        border-bottom: 1px solid #f1f5f9;
    }
    .profile-info-label {
        width: 38%;
        font-weight: 600;
        color: #64748b;
        font-size: 13px;
    }
    .profile-info-value {
        font-weight: 600;
        color: #1e293b;
        font-size: 13.5px;
    }
    .wilayah-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px 18px;
        transition: all 0.2s ease;
    }
    .wilayah-box:hover {
        border-color: #93c5fd;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.06);
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Header Banner (Unified White Card - DESIGN.md Section 1 & 3) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center">
                    <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                            Profil Penerima Manfaat
                        </h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                            Data identitas lengkap anak, wali, kontak, dan informasi wilayah domisili
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stat Summary Row (ot-stat-card standard) -->
    <div class="col-xl-3 col-sm-6">
        <div class="ot-stat-card ot-navy">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Total Sesi Terapi</p>
                    <h2 class="ot-stat-number">{{ $pasien->rekams->count() }} Sesi</h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span>Kunjungan Pelayanan Medis</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="ot-stat-card ot-cyan">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Usia Pasien</p>
                    <h2 class="ot-stat-number">
                        {{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInYears(\Carbon\Carbon::now()) . ' Tahun' : '-' }}
                    </h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-cake-candles"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span>{{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->diff(\Carbon\Carbon::now())->format('%y Thn %m Bln') : 'Data tanggal lahir' }}</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="ot-stat-card ot-green">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Disabilitas / Kondisi</p>
                    <h2 class="ot-stat-number" style="font-size: 18px; line-height: 1.25; margin-top: 4px;">
                        {{ $pasien->jenis_disabilitas ?: 'Tidak tercatat' }}
                    </h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-wheelchair"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span>Alat Bantu: {{ $pasien->alat_bantu ?: 'Tidak ada' }}</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="ot-stat-card ot-yellow">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Lokasi Pelayanan</p>
                    <h2 class="ot-stat-number" style="font-size: 18px; line-height: 1.25; margin-top: 4px;">
                        {{ $pasien->upt_lokasi ?: 'Omah Terapi-KU' }}
                    </h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-building-user"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span>Fasilitas Terdaftar</span>
            </div>
        </div>
    </div>

    <!-- Kolom Kiri: Identitas Pasien -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                    <i class="fa-solid fa-child mr-2" style="color: #2563eb;"></i> Identitas Anak / Penerima Manfaat
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 profile-info-table">
                        <tbody>
                            <tr>
                                <td class="profile-info-label">Nama Lengkap</td>
                                <td class="profile-info-value"><strong class="text-primary">{{ $pasien->nama }}</strong></td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Nomor Rekam Medis</td>
                                <td class="profile-info-value">
                                    <span class="font-w800 text-dark">{{ $pasien->no_rm }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">NIK Pasien</td>
                                <td class="profile-info-value">{{ $pasien->nik ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Tempat, Tanggal Lahir</td>
                                <td class="profile-info-value">
                                    {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}
                                    {{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Jenis Kelamin</td>
                                <td class="profile-info-value">
                                    @if($pasien->jk == 'L')
                                        <i class="fa-solid fa-mars mr-1" style="color: #2563eb;"></i> Laki-laki
                                    @elseif($pasien->jk == 'P')
                                        <i class="fa-solid fa-venus mr-1" style="color: #ec4899;"></i> Perempuan
                                    @else
                                        {{ $pasien->jk ?: '-' }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Agama</td>
                                <td class="profile-info-value">{{ $pasien->agama ?: '-' }}</td>
                            </tr>
                            @php
                                $latestKeluhan = $pasien->rekams->first()?->keluhan ?: ($pasien->assessments->first()?->kesimpulan ?: null);
                            @endphp
                            <tr>
                                <td class="profile-info-label">Anamnesa / Keluhan Utama</td>
                                <td class="profile-info-value">
                                    @if($latestKeluhan)
                                        <span class="text-dark">{{ $latestKeluhan }}</span>
                                    @else
                                        <span class="text-muted">Pemeriksaan & stimulasi terapi tumbuh kembang</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Data Wali & Administrasi -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                    <i class="fa-solid fa-user-group mr-2" style="color: #2563eb;"></i> Data Wali & Administrasi
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 profile-info-table">
                        <tbody>
                            <tr>
                                <td class="profile-info-label">Nama Orang Tua / Wali</td>
                                <td class="profile-info-value"><strong class="text-dark">{{ $pasien->nama_wali ?: '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Hubungan Wali</td>
                                <td class="profile-info-value">{{ $pasien->hubungan_wali ?: 'Orang Tua / Keluarga' }}</td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Kontak / WhatsApp</td>
                                <td class="profile-info-value">
                                    @if($pasien->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pasien->no_hp) }}" target="_blank" class="text-success font-w700 text-decoration-none">
                                            <i class="fa-brands fa-whatsapp mr-1"></i> {{ $pasien->no_hp }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Nomor BPJS / KIS</td>
                                <td class="profile-info-value">{{ $pasien->no_bpjs ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Alat Bantu Digunakan</td>
                                <td class="profile-info-value">{{ $pasien->alat_bantu ?: 'Tidak ada' }}</td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Kategori Desil Dinsos</td>
                                <td class="profile-info-value">{{ $pasien->desil ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="profile-info-label">Tanggal Terdaftar</td>
                                <td class="profile-info-value">
                                    {{ $pasien->created_at ? $pasien->created_at->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Penuh: Alamat Domisili & Wilayah (Jelas & Terbuka) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                    <i class="fa-solid fa-map-location-dot mr-2" style="color: #2563eb;"></i> Alamat Domisili & Wilayah Tempat Tinggal
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="p-3 mb-4 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;">
                    <div class="text-muted font-w600 mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.3px;">Alamat Lengkap (Jalan / RT / RW):</div>
                    <div class="text-dark font-w700" style="font-size: 14.5px; line-height: 1.5;">
                        <i class="fa-solid fa-house-user mr-1 text-primary"></i>
                        {{ $pasien->alamat_lengkap ?: 'Alamat belum tercatat lengkap di sistem' }}
                    </div>
                </div>

                <!-- 4 Box Rincian Wilayah Sesuai Hirarki -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="wilayah-box h-100">
                            <div class="text-muted font-w600" style="font-size: 11.5px;">Kelurahan / Desa</div>
                            <div class="font-w700 text-dark mt-1" style="font-size: 14px;">
                                {{ $pasien->kelurahan ?: '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="wilayah-box h-100">
                            <div class="text-muted font-w600" style="font-size: 11.5px;">Kecamatan</div>
                            <div class="font-w700 text-dark mt-1" style="font-size: 14px;">
                                {{ $pasien->kecamatan ?: '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="wilayah-box h-100">
                            <div class="text-muted font-w600" style="font-size: 11.5px;">Kabupaten / Kota</div>
                            <div class="font-w700 text-dark mt-1" style="font-size: 14px;">
                                {{ $pasien->kabupaten ?: '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="wilayah-box h-100">
                            <div class="text-muted font-w600" style="font-size: 11.5px;">Kode Pos</div>
                            <div class="font-w700 text-dark mt-1" style="font-size: 14px;">
                                {{ $pasien->kodepos ?: '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

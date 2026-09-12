@extends('portal.layout.apps')

@section('title', 'Beranda')

@section('style')
<style>
    .portal-nav-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 2px 10px rgba(46, 75, 130, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .portal-nav-card:hover {
        transform: translateY(-4px);
        border-color: #93c5fd;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.09);
    }
    .portal-nav-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        border: 1px solid transparent;
        margin-bottom: 14px;
        transition: transform 0.2s ease;
    }
    .portal-nav-card:hover .portal-nav-icon {
        transform: scale(1.08);
    }
    .portal-nav-title {
        font-size: 15.5px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .portal-nav-desc {
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 14px;
        flex-grow: 1;
    }
    .portal-nav-btn {
        border-radius: 7px;
        padding: 7px 14px;
        font-size: 12px;
        font-weight: 700;
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s;
    }
    .portal-nav-btn:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
@php
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date('w')];
    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][date('n') - 1];
    $tanggalFormatted = $hari . ', ' . date('j') . ' ' . $bulan . ' ' . date('Y');
@endphp

<div class="row">
    <!-- Header Banner (Unified White Card - DESIGN.md Section 1 & 3) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-auto mb-2 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                                <i class="fa-solid fa-hospital-user"></i>
                            </div>
                            <div>
                                <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 22px;">
                                    Beranda Portal Pasien & Keluarga
                                </h3>
                                <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                                    Selamat Datang, <strong class="font-w700" style="color: #2563eb;">{{ $pasien->nama }}</strong> &bull; Sistem Informasi Rekam Medis Omah Terapi-KU
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                        <div class="px-3 py-2 rounded d-flex align-items-center" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 13px; font-weight: 600; color: #334155; border-radius: 8px;">
                            <span class="text-muted mr-1.5">No. RM:</span>
                            <strong class="text-primary font-w800" style="font-size: 14.5px;">{{ $pasien->no_rm }}</strong>
                        </div>
                        <div class="px-3 py-2 rounded d-flex align-items-center" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12.5px; font-weight: 600; color: #334155; border-radius: 8px;">
                            <i class="fa fa-calendar mr-2" style="color: #2563eb;"></i> {{ $tanggalFormatted }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stat Cards (DESIGN.md ot-stat-card standard) -->
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
                <span>Riwayat Kunjungan Terapi</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="ot-stat-card ot-cyan">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Asesmen Klinis</p>
                    <h2 class="ot-stat-number">{{ $pasien->assessments->count() }} Kali</h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span>Pemeriksaan Terintegrasi</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="ot-stat-card ot-green">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">GMFM Terakhir</p>
                    <h2 class="ot-stat-number">
                        {{ ($latestAssessment && $latestAssessment->gmfm_total_persen !== null) ? $latestAssessment->gmfm_total_persen . '%' : '-' }}
                    </h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-child-reaching"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span>Gross Motor Function</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="ot-stat-card ot-yellow">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="ot-stat-title">Skala Nyeri (VAS)</p>
                    <h2 class="ot-stat-number">
                        {{ ($latestAssessment && $latestAssessment->nyeri_skor_total !== null) ? $latestAssessment->nyeri_skor_total . '/10' : '-' }}
                    </h2>
                </div>
                <div class="ot-stat-icon-wrap">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
            </div>
            <div class="ot-stat-footer">
                <span>Visual Analog Scale</span>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Cards Grid (No Badges) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                <div>
                    <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                        <i class="fa-solid fa-compass mr-2" style="color: #2563eb;"></i> Modul Navigasi Portal Pasien
                    </h4>
                    <p class="text-muted mb-0 mt-1" style="font-size: 12.5px;">Akses mandiri ke modul asesmen perkembangan, evaluasi fisik, dan rekam medis</p>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- 1. Denver II -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="portal-nav-card h-100">
                            <div class="portal-nav-icon" style="background: #eff6ff; color: #2563eb; border-color: #dbeafe;">
                                <i class="fa-solid fa-baby"></i>
                            </div>
                            <h5 class="portal-nav-title">Skala Perkembangan Denver II</h5>
                            <p class="portal-nav-desc">
                                Pantau milestone perkembangan personal sosial, motorik halus, bahasa, dan motorik kasar anak.
                            </p>
                            <a href="{{ route('portal.denver') }}" class="btn btn-sm btn-primary font-w700 portal-nav-btn">
                                <span>Buka Denver II</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 2. GMFM -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="portal-nav-card h-100">
                            <div class="portal-nav-icon" style="background: #e0f2fe; color: #0284c7; border-color: #bae6fd;">
                                <i class="fa-solid fa-child-reaching"></i>
                            </div>
                            <h5 class="portal-nav-title">Gross Motor (GMFM)</h5>
                            <p class="portal-nav-desc">
                                Evaluasi motorik kasar Dimensi A – E: berguling, duduk, merangkak, berdiri, hingga berjalan dan melompat.
                            </p>
                            <a href="{{ route('portal.gmfm') }}" class="btn btn-sm btn-primary font-w700 portal-nav-btn">
                                <span>Buka GMFM</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 3. Evaluasi Nyeri & Fisik -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="portal-nav-card h-100">
                            <div class="portal-nav-icon" style="background: #fee2e2; color: #dc2626; border-color: #fecaca;">
                                <i class="fa-solid fa-heart-pulse"></i>
                            </div>
                            <h5 class="portal-nav-title">Evaluasi Nyeri & Fisik</h5>
                            <p class="portal-nav-desc">
                                Cek intensitas nyeri VAS, lingkup gerak sendi (ROM), kekuatan otot (MMT), serta tes postur & keseimbangan.
                            </p>
                            <a href="{{ route('portal.nyeri') }}" class="btn btn-sm btn-primary font-w700 portal-nav-btn">
                                <span>Buka Evaluasi Fisik</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 4. Home Program -->
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <div class="portal-nav-card h-100">
                            <div class="portal-nav-icon" style="background: #dcfce7; color: #15803d; border-color: #bbf7d0;">
                                <i class="fa-solid fa-house-chimney-medical"></i>
                            </div>
                            <h5 class="portal-nav-title">Program Terapi Rumah</h5>
                            <p class="portal-nav-desc">
                                Panduan latihan dan anjuran stimulasi mandiri dari terapis untuk dipraktikkan orang tua secara mandiri di rumah.
                            </p>
                            <a href="{{ route('portal.home-program') }}" class="btn btn-sm btn-primary font-w700 portal-nav-btn">
                                <span>Buka Home Program</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 5. Riwayat Sesi Terapi -->
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <div class="portal-nav-card h-100">
                            <div class="portal-nav-icon" style="background: #f1f5f9; color: #334155; border-color: #e2e8f0;">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <h5 class="portal-nav-title">Riwayat Sesi Terapi</h5>
                            <p class="portal-nav-desc">
                                Rekapitulasi kronologis seluruh kunjungan terapi, diagnosis klinis, dan catatan tindakan terapis yang menangani.
                            </p>
                            <a href="{{ route('portal.riwayat') }}" class="btn btn-sm btn-primary font-w700 portal-nav-btn">
                                <span>Buka Riwayat Sesi</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 6. Dokumen & Cetak Laporan -->
                    <div class="col-lg-4 col-md-6">
                        <div class="portal-nav-card h-100">
                            <div class="portal-nav-icon" style="background: #e0e7ff; color: #3730a3; border-color: #c7d2fe;">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <h5 class="portal-nav-title">Dokumen & Cetak Laporan</h5>
                            <p class="portal-nav-desc">
                                Unduh atau cetak laporan hasil asesmen terpadu lengkap, resume medis, dan lampiran berkas rekam medis.
                            </p>
                            <a href="{{ route('portal.dokumen') }}" class="btn btn-sm btn-primary font-w700 portal-nav-btn">
                                <span>Buka Dokumen</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Identitas Ringkas & Sesi Terapi Terbaru (Two Column Section) -->
    <div class="col-lg-5 mb-4">
        <div class="card h-100 shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                <h5 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 15px;">
                    <i class="fa-solid fa-id-card-clip mr-2" style="color: #2563eb;"></i> Identitas Penerima Manfaat
                </h5>
                <a href="{{ route('portal.profil') }}" class="btn btn-xs btn-outline-primary font-w600" style="border-radius: 6px;">
                    Lihat Profil <i class="fa-solid fa-chevron-right ml-1"></i>
                </a>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                    <div class="rounded-circle mr-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: #eff6ff; border: 2px solid #bfdbfe; color: #2563eb; font-size: 20px;">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div>
                        <h5 class="font-w700 text-dark mb-0" style="font-size: 15.5px;">{{ $pasien->nama }}</h5>
                        <span class="fs-12 text-muted font-w600">No. RM: <strong class="text-primary">{{ $pasien->no_rm }}</strong></span>
                    </div>
                </div>

                <table class="table table-borderless table-sm mb-0" style="font-size: 13px;">
                    <tbody>
                        <tr>
                            <td class="text-muted py-1.5 pl-0" style="width: 40%;">Tempat, Tgl Lahir</td>
                            <td class="font-w600 text-dark py-1.5">: {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->isoFormat('D MMMM Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-1.5 pl-0">Jenis Kelamin</td>
                            <td class="font-w600 text-dark py-1.5">: {{ $pasien->jk == 'L' ? 'Laki-laki' : ($pasien->jk == 'P' ? 'Perempuan' : ($pasien->jk ?: '-')) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-1.5 pl-0">Nama Wali / Orang Tua</td>
                            <td class="font-w600 text-dark py-1.5">: {{ $pasien->nama_wali ?: '-' }} ({{ $pasien->hubungan_wali ?: 'Wali' }})</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-1.5 pl-0">Lokasi Layanan / UPT</td>
                            <td class="font-w600 text-dark py-1.5">: {{ $pasien->upt_lokasi ?: 'Omah Terapi-KU' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-1.5 pl-0">Jenis Disabilitas</td>
                            <td class="font-w600 text-dark py-1.5">: {{ $pasien->jenis_disabilitas ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Sesi Terapi Terbaru -->
    <div class="col-lg-7 mb-4">
        <div class="card h-100 shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                <h5 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 15px;">
                    <i class="fa-solid fa-clock-rotate-left mr-2" style="color: #2563eb;"></i> Kunjungan Terapi Terbaru
                </h5>
                <a href="{{ route('portal.riwayat') }}" class="btn btn-xs btn-outline-primary font-w600" style="border-radius: 6px;">
                    Semua Riwayat ({{ $pasien->rekams->count() }}) <i class="fa-solid fa-chevron-right ml-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size: 12.5px;">
                        <thead style="background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                            <tr>
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3">Keluhan / Anamnesa</th>
                                <th class="py-2.5 px-3">Terapis / Petugas</th>
                                <th class="py-2.5 px-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pasien->rekams->take(4) as $rekam)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-2.5 px-3 font-w600 text-dark text-nowrap">
                                        <i class="fa-regular fa-calendar mr-1 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($rekam->tgl_rekam)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2.5 px-3 text-dark">
                                        <div class="font-w600 text-truncate" style="max-width: 200px;" title="{{ $rekam->keluhan }}">
                                            {{ $rekam->keluhan ?: 'Pemeriksaan rutin' }}
                                        </div>
                                        @if($rekam->diagnosa)
                                            <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                {{ $rekam->diagnosa }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="py-2.5 px-3 text-muted text-nowrap">
                                        <i class="fa-solid fa-user-doctor mr-1 text-info"></i>
                                        {{ $rekam->dokter ? $rekam->dokter->nama : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-center text-nowrap">
                                        <span class="badge badge-success light font-w600" style="font-size: 11px; padding: 3px 8px; border-radius: 6px;">
                                            <i class="fa-solid fa-circle-check mr-1"></i> Selesai
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fa-regular fa-folder-open mb-2 d-block" style="font-size: 24px; opacity: 0.5;"></i>
                                        Belum ada riwayat sesi terapi yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

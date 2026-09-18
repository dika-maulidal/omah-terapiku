@extends('portal.layout.apps')

@section('title', 'Booking & Jadwal Terapi')

@section('style')
<style>
    .booking-stat-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding: 16px 20px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .booking-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(46, 75, 130, 0.08);
    }
    .booking-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .tracking-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: all 0.2s ease;
        overflow: hidden;
        margin-bottom: 18px;
    }
    .tracking-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 6px 22px rgba(46, 75, 130, 0.09);
    }
    .tracking-card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 20px;
    }

    /* Stepper Progress Tracking */
    .tracking-stepper {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        position: relative;
        padding: 10px 10px 0 10px;
    }
    .tracking-stepper::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 35px;
        right: 35px;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }
    .tracking-step-item {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }
    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #cbd5e1;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 6px;
        transition: all 0.2s ease;
    }
    .step-circle.active {
        background: #eff6ff;
        border-color: #2563eb;
        color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .step-circle.completed {
        background: #ecfdf5;
        border-color: #10b981;
        color: #059669;
    }
    .step-circle.rejected {
        background: #fef2f2;
        border-color: #ef4444;
        color: #dc2626;
    }
    .step-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        line-height: 1.3;
    }
    .step-desc {
        font-size: 10.5px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .form-control-booking {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
        padding: 9px 13px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control-booking:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .copy-badge-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        color: #2563eb;
        padding: 0 4px;
        font-size: 12px;
        transition: color 0.15s;
    }
    .copy-badge-btn:hover {
        color: #1d4ed8;
    }

    /* Filter pill buttons */
    .tracking-filter-btn {
        border-radius: 20px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .tracking-filter-btn:hover {
        border-color: #cbd5e1;
        color: #1e293b;
    }
    .tracking-filter-btn.active {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1e40af;
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.1);
    }

    /* Success Modal & Copy Cursor (Emerald Green Theme) */
    .ot-success-modal-box {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.22), 0 4px 18px rgba(16, 185, 129, 0.12);
        border: 1.5px solid #a7f3d0;
        overflow: hidden;
        text-align: left;
    }
    .ot-success-modal-header {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-bottom: 1.5px solid #a7f3d0;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ot-success-modal-icon {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        background: #ffffff;
        color: #059669;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #a7f3d0;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.15);
        flex-shrink: 0;
    }
    .ot-success-modal-title {
        font-size: 16px;
        font-weight: 800;
        color: #065f46;
        margin: 0 0 2px 0;
    }
    .ot-success-modal-subtitle {
        font-size: 12px;
        font-weight: 500;
        color: #047857;
    }
    .ot-modal-close-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    .ot-modal-close-btn:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
    }
    .ot-code-card {
        background: #f0fdf4;
        border: 1.5px dashed #10b981;
        border-radius: 12px;
        padding: 15px 16px;
        margin-bottom: 16px;
        transition: all 0.22s ease;
        text-align: left;
    }
    .copy-trigger-box,
    .btn-copy-action,
    .ot-code-number,
    .copy-badge-btn {
        cursor: copy !important;
        cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='%23059669' stroke='%23ffffff' stroke-width='1.5'%3E%3Cpath d='M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z'/%3E%3C/svg%3E") 4 4, copy !important;
    }
    .ot-code-card:hover {
        background: #ecfdf5;
        border-color: #059669;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.15);
        transform: translateY(-1px);
    }
    .btn-copy-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #ffffff;
        border: 1.5px solid #a7f3d0;
        color: #059669;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 11px;
        border-radius: 7px;
        box-shadow: 0 2px 4px rgba(5, 150, 105, 0.08);
        transition: all 0.18s ease;
    }
    .btn-copy-action:hover {
        background: #059669;
        color: #ffffff;
        border-color: #047857;
        box-shadow: 0 3px 8px rgba(5, 150, 105, 0.25);
        transform: translateY(-1px);
    }
    .btn-copy-action.copied {
        background: #ecfdf5 !important;
        color: #059669 !important;
        border-color: #a7f3d0 !important;
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Header Banner -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-auto mb-0">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div>
                                <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                                    Booking &amp; Tracking Sesi Terapi
                                </h3>
                                <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                                    Ajukan reservasi jadwal kunjungan terapi mandiri &amp; pantau konfirmasi terapis secara langsung di portal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    @php
        $totalBooking = $bookings->count();
        $menungguCount = $bookings->where('status', 'menunggu')->count();
        $disetujuiCount = $bookings->where('status', 'disetujui')->count();
        $selesaiCount = $bookings->where('status', 'selesai')->count();
    @endphp

    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="booking-stat-card d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted font-w600 mb-1" style="font-size: 12px;">Total Permohonan</p>
                <h3 class="font-w800 mb-0" style="color: #1e40af; font-size: 22px;">{{ $totalBooking }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Sesi</span></h3>
            </div>
            <div class="booking-stat-icon" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="booking-stat-card d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted font-w600 mb-1" style="font-size: 12px;">Menunggu Konfirmasi</p>
                <h3 class="font-w800 mb-0" style="color: #d97706; font-size: 22px;">{{ $menungguCount }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Sesi</span></h3>
            </div>
            <div class="booking-stat-icon" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a;">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="booking-stat-card d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted font-w600 mb-1" style="font-size: 12px;">Terkonfirmasi &amp; Jadwal</p>
                <h3 class="font-w800 mb-0" style="color: #2563eb; font-size: 22px;">{{ $disetujuiCount }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Sesi</span></h3>
            </div>
            <div class="booking-stat-icon" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="booking-stat-card d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted font-w600 mb-1" style="font-size: 12px;">Sesi Terlaksana</p>
                <h3 class="font-w800 mb-0" style="color: #059669; font-size: 22px;">{{ $selesaiCount }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Sesi</span></h3>
            </div>
            <div class="booking-stat-icon" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
    </div>

    <!-- 2 Column Layout: Form Left, Tracking Right -->
    <div class="col-xl-5 col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px;">
            <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                <h5 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 15.5px;">
                    <i class="fa-solid fa-calendar-plus text-primary mr-2"></i> Formulir Pengajuan Sesi Baru
                </h5>
            </div>
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('portal.booking.store') }}" method="POST">
                    {{ csrf_field() }}


                    <!-- Lokasi UPT Pelayanan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-hospital text-primary mr-1"></i> Lokasi Klinik / UPT Pelayanan <span class="text-danger">*</span>
                        </label>
                        <select name="upt_lokasi" class="form-control form-control-booking" required style="height: 42px;">
                            @if(isset($polis) && $polis->count() > 0)
                                @foreach($polis as $poli)
                                    <option value="{{ $poli->nama }}" {{ ($pasien->upt_lokasi == $poli->nama) ? 'selected' : '' }}>
                                        {{ $poli->nama }}
                                    </option>
                                @endforeach
                            @else
                                <option value="UPT RSBN Malang" selected>UPT RSBN Malang</option>
                                <option value="UPT PPSAB Sidoarjo">UPT PPSAB Sidoarjo</option>
                            @endif
                        </select>
                    </div>

                    <!-- Jenis Layanan Terapi -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-hand-holding-medical text-primary mr-1"></i> Jenis Layanan Terapi <span class="text-danger">*</span>
                        </label>
                        <select name="layanan_terapi" class="form-control form-control-booking" required style="height: 42px;">
                            <option value="">-- Pilih Layanan Terapi --</option>
                            <option value="Fisioterapi (Motorik Kasar)">Fisioterapi (Motorik Kasar &amp; Penguatan Otot)</option>
                            <option value="Terapi Wicara">Terapi Wicara (Komunikasi &amp; Oral Motor)</option>
                            <option value="Terapi Okupasi">Terapi Okupasi (Sensori &amp; Kemandirian ADL)</option>
                            <option value="Sensori Integrasi (SI)">Sensori Integrasi (SI)</option>
                            <option value="Layanan Terapi Terpadu">Layanan Terapi Terpadu (Kombinasi Asesmen &amp; Tindakan)</option>
                        </select>
                    </div>

                    <!-- Rencana Tanggal Kedatangan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-regular fa-calendar-check text-primary mr-1"></i> Rencana Tanggal Kedatangan <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tgl_rencana" class="form-control form-control-booking" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required style="height: 42px;">
                        <small class="text-muted mt-1 d-block" style="font-size: 11.5px;">
                            <i class="fa-solid fa-circle-info text-primary mr-1"></i> Pilih tanggal hari kerja pelayanan (Senin - Jumat)
                        </small>
                    </div>

                    <!-- Preferensi Jam Sesi -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-regular fa-clock text-primary mr-1"></i> Preferensi Jadwal Sesi Terapi <span class="text-danger">*</span> <small class="text-muted font-w400">(Rabu, 30-45 mnt)</small>
                        </label>
                        @php
                            $currJam = old('jam_sesi', 'Sesi 1 (08.00 - 08.45 WIB)');
                        @endphp
                        <select name="jam_sesi" class="form-control form-control-booking" required style="height: 42px;">
                            <option value="">--Pilih Slot Sesi Waktu--</option>
                            <option value="Sesi 1 (08.00 - 08.45 WIB)" {{ $currJam == 'Sesi 1 (08.00 - 08.45 WIB)' ? 'selected' : '' }}>Sesi 1 (08.00 - 08.45 WIB)</option>
                            <option value="Sesi 2 (08.45 - 09.30 WIB)" {{ $currJam == 'Sesi 2 (08.45 - 09.30 WIB)' ? 'selected' : '' }}>Sesi 2 (08.45 - 09.30 WIB)</option>
                            <option value="Sesi 3 (09.30 - 10.15 WIB)" {{ $currJam == 'Sesi 3 (09.30 - 10.15 WIB)' ? 'selected' : '' }}>Sesi 3 (09.30 - 10.15 WIB)</option>
                            <option value="Sesi 4 (10.15 - 11.00 WIB)" {{ $currJam == 'Sesi 4 (10.15 - 11.00 WIB)' ? 'selected' : '' }}>Sesi 4 (10.15 - 11.00 WIB)</option>
                            <option value="Sesi 5 (11.00 - 11.45 WIB)" {{ $currJam == 'Sesi 5 (11.00 - 11.45 WIB)' ? 'selected' : '' }}>Sesi 5 (11.00 - 11.45 WIB)</option>
                            <option value="Sesi 6 (11.45 - 12.30 WIB)" {{ $currJam == 'Sesi 6 (11.45 - 12.30 WIB)' ? 'selected' : '' }}>Sesi 6 (11.45 - 12.30 WIB)</option>
                            <option value="Sesi 7 (12.30 - 13.00 WIB)" {{ $currJam == 'Sesi 7 (12.30 - 13.00 WIB)' ? 'selected' : '' }}>Sesi 7 (12.30 - 13.00 WIB)</option>
                            <option value="Sesi Khusus / Fleksibel" {{ $currJam == 'Sesi Khusus / Fleksibel' ? 'selected' : '' }}>Sesi Khusus / Fleksibel</option>
                        </select>
                    </div>

                    <!-- Keluhan / Catatan Khusus -->
                    <div class="form-group mb-4">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-comment-medical text-primary mr-1"></i> Keluhan / Fokus Latihan untuk Terapis
                        </label>
                        <textarea name="keluhan_catatan" class="form-control form-control-booking" rows="3" placeholder="Contoh: Evaluasi kemajuan latihan berjalan di rumah, keluhan nyeri sendi lutut, atau kontrol terapi rutin mingguan." style="resize: vertical;"></textarea>
                    </div>

                    <!-- Ketentuan Info Box -->
                    <div class="rounded mb-3" style="background: #eff6ff; border: 1px dashed #bfdbfe; font-size: 12.5px; padding: 14px 18px; color: #1e40af; line-height: 1.5;">
                        Permohonan Anda akan ditinjau oleh petugas medis &amp; terapis. Harap hadir <strong>15 menit sebelum waktu sesi</strong> yang disetujui.
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block font-w700 shadow-sm" style="border-radius: 8px; padding: 10px 18px; font-size: 13.5px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                        <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim Permohonan Booking
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Live Tracking & Riwayat Permohonan -->
    <div class="col-xl-7 col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px;">
            <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center" style="border-bottom: 1px solid #f1f5f9; padding: 14px 20px; gap: 10px;">
                <div>
                    <h5 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 15.5px;">
                        <i class="fa-solid fa-timeline text-primary mr-2"></i> Live Tracking &amp; Riwayat Booking
                    </h5>
                </div>
                <!-- Filter Pills -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                    <button type="button" class="tracking-filter-btn active" onclick="filterBookings('all', this)">Semua ({{ $totalBooking }})</button>
                    <button type="button" class="tracking-filter-btn" onclick="filterBookings('menunggu', this)">Menunggu ({{ $menungguCount }})</button>
                    <button type="button" class="tracking-filter-btn" onclick="filterBookings('disetujui', this)">Terkonfirmasi ({{ $disetujuiCount }})</button>
                    <button type="button" class="tracking-filter-btn" onclick="filterBookings('selesai', this)">Selesai ({{ $selesaiCount }})</button>
                </div>
            </div>

            <div class="card-body p-3 p-md-4" style="background: #f8fafc; min-height: 480px;">
                @if($bookings && $bookings->count() > 0)
                    <div id="bookingListContainer">
                        @foreach($bookings as $booking)
                            <div class="tracking-card booking-item" data-status="{{ $booking->status }}">
                                <!-- Tracking Card Header -->
                                <div class="tracking-card-header d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 14px; border: 1px solid #bfdbfe;">
                                            <i class="fa-solid fa-receipt"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center" style="gap: 6px;">
                                                <span class="font-w800 font-monospace" style="color: #1e40af; font-size: 14px; letter-spacing: 0.3px;">
                                                    {{ $booking->kode_booking }}
                                                </span>
                                                <button type="button" class="copy-badge-btn" onclick="copyKodeBooking('{{ $booking->kode_booking }}')" title="Salin Kode Booking">
                                                    <i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted" style="font-size: 11px;">
                                                Diajukan: {{ $booking->created_at ? $booking->created_at->isoFormat('D MMMM Y, HH:mm') . ' WIB' : '-' }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="mt-2 mt-sm-0 d-flex align-items-center" style="gap: 8px;">
                                        {!! $booking->status_badge !!}
                                        <a href="{{ route('portal.booking.cetak', $booking->kode_booking) }}" target="_blank" class="btn btn-xs btn-outline-primary font-w700" style="border-radius: 6px; padding: 3px 8px; font-size: 11.5px; border-color: #bfdbfe; background: #ffffff;" title="Cetak Lembar Bukti Booking">
                                            <i class="fa-solid fa-print mr-1"></i> Cetak
                                        </a>
                                    </div>
                                </div>

                                <!-- Tracking Card Body -->
                                <div class="p-3 p-md-3.5 bg-white">
                                    <!-- Meta Information Row -->
                                    <div class="row mb-3" style="font-size: 12.5px;">
                                        <div class="col-sm-6 mb-2 mb-sm-0">
                                            <span class="text-muted d-block font-w600" style="font-size: 11px;">Layanan Terapi:</span>
                                            <strong class="text-dark">{{ $booking->layanan_terapi }}</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-muted d-block font-w600" style="font-size: 11px;">Rencana Tanggal &amp; Sesi:</span>
                                            <strong class="text-primary">
                                                <i class="fa-regular fa-calendar mr-1"></i> {{ $booking->tgl_rencana ? \Carbon\Carbon::parse($booking->tgl_rencana)->isoFormat('dddd, D MMMM Y') : '-' }}
                                            </strong>
                                            <div class="text-muted font-w500" style="font-size: 11.5px;">
                                                <i class="fa-regular fa-clock mr-1"></i> {{ $booking->jam_sesi ?: 'Sesi 1 (08.00 - 08.45 WIB)' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3-Stage Progress Stepper -->
                                    <div class="p-3 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <div class="tracking-stepper">
                                            <!-- Step 1: Diajukan -->
                                            <div class="tracking-step-item">
                                                <div class="step-circle completed">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                                <div class="step-label text-success">1. Pengajuan</div>
                                                <div class="step-desc">Terkirim</div>
                                            </div>

                                            <!-- Step 2: Konfirmasi / Penugasan Terapis -->
                                            <div class="tracking-step-item">
                                                @if($booking->status === 'disetujui' || $booking->status === 'selesai')
                                                    <div class="step-circle completed">
                                                        <i class="fa-solid fa-check"></i>
                                                    </div>
                                                    <div class="step-label text-success">2. Disetujui</div>
                                                    <div class="step-desc">Terapis Ditugaskan</div>
                                                @elseif($booking->status === 'ditolak')
                                                    <div class="step-circle rejected">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </div>
                                                    <div class="step-label text-danger">2. Ditolak</div>
                                                    <div class="step-desc">Periksa Catatan</div>
                                                @else
                                                    <div class="step-circle active">
                                                        <i class="fa-solid fa-spinner fa-spin"></i>
                                                    </div>
                                                    <div class="step-label text-warning">2. Verifikasi</div>
                                                    <div class="step-desc">Menunggu Petugas</div>
                                                @endif
                                            </div>

                                            <!-- Step 3: Pelaksanaan Sesi -->
                                            <div class="tracking-step-item">
                                                @if($booking->status === 'selesai')
                                                    <div class="step-circle completed">
                                                        <i class="fa-solid fa-check-double"></i>
                                                    </div>
                                                    <div class="step-label text-success">3. Selesai</div>
                                                    <div class="step-desc">Tindakan Selesai</div>
                                                @elseif($booking->status === 'disetujui')
                                                    <div class="step-circle active">
                                                        <i class="fa-solid fa-hourglass-half"></i>
                                                    </div>
                                                    <div class="step-label text-primary">3. Terjadwal</div>
                                                    <div class="step-desc">Siap Hadir</div>
                                                @elseif($booking->status === 'ditolak')
                                                    <div class="step-circle">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </div>
                                                    <div class="step-label text-muted">3. Selesai</div>
                                                    <div class="step-desc">-</div>
                                                @else
                                                    <div class="step-circle">
                                                        <i class="fa-solid fa-clock"></i>
                                                    </div>
                                                    <div class="step-label text-muted">3. Pelaksanaan</div>
                                                    <div class="step-desc">Menunggu Jadwal</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Details Callout Box -->
                                    @if($booking->status === 'disetujui')
                                        <div class="rounded mb-3" style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 12px; padding: 20px 22px; margin-top: 14px;">
                                            <div class="d-flex align-items-center mb-2.5" style="color: #065f46; font-weight: 800; font-size: 13.5px;">
                                                <i class="fa-solid fa-circle-check mr-2 text-success" style="font-size: 16px;"></i> Jadwal Sesi Terapi Telah Dikonfirmasi &amp; Terdaftar
                                            </div>
                                            <div class="row" style="font-size: 13px; color: #047857; line-height: 1.5;">
                                                <div class="col-sm-6 mb-2">
                                                    <span class="text-muted d-block font-w500" style="font-size: 12px;">Terapis Penanggung Jawab:</span>
                                                    <span class="font-w700 text-dark d-block">
                                                        <i class="fa-solid fa-user-doctor text-success mr-1"></i>
                                                        {{ $booking->dokter ? $booking->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}
                                                    </span>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <span class="text-muted d-block font-w500" style="font-size: 12px;">Waktu &amp; Lokasi:</span>
                                                    <span class="text-dark font-w600 d-block">
                                                        <i class="fa-regular fa-calendar-check mr-1 text-primary"></i>
                                                        {{ $booking->jam_sesi ?: 'Sesi 1 (08.00 - 08.45 WIB)' }} &bull; {{ $booking->upt_lokasi ?: 'UPT RSBN Malang' }}
                                                    </span>
                                                </div>
                                            </div>
                                            @if($booking->catatan_petugas)
                                                <div style="background: #ffffff; border: 1.5px solid #a7f3d0; border-radius: 10px; padding: 16px 20px; margin-top: 14px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);">
                                                    <div style="font-size: 13px; font-weight: 700; color: #047857; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                                                        <i class="fa-solid fa-clipboard-check text-success" style="font-size: 15px;"></i> Catatan Persetujuan Petugas:
                                                    </div>
                                                    <div style="font-size: 13px; color: #065f46; line-height: 1.65; font-weight: 500;">
                                                        {{ $booking->catatan_petugas }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($booking->status === 'ditolak')
                                        <div class="rounded mb-3" style="background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 12px; padding: 20px 22px; margin-top: 14px;">
                                            <div class="d-flex align-items-center mb-2" style="color: #dc2626; font-weight: 800; font-size: 13.5px;">
                                                <i class="fa-solid fa-circle-xmark mr-2 text-danger" style="font-size: 16px;"></i> Permohonan Jadwal Belum Dapat Disetujui
                                            </div>
                                            <div style="background: #ffffff; border: 1.5px solid #fecaca; border-radius: 10px; padding: 16px 20px; margin-top: 12px; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.08);">
                                                <div style="font-size: 13px; font-weight: 700; color: #b91c1c; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                                                    <i class="fa-solid fa-comment-slash text-danger" style="font-size: 15px;"></i> Alasan / Catatan Petugas:
                                                </div>
                                                <div style="font-size: 13px; color: #991b1b; line-height: 1.65; font-weight: 500;">
                                                    {{ $booking->catatan_petugas ?: 'Jadwal pada sesi tersebut sedang penuh atau terapis berhalangan, silakan pilih tanggal/sesi lainnya.' }}
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($booking->status === 'selesai')
                                        <div class="rounded mb-3" style="background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 12px; padding: 18px 22px; font-size: 13px; margin-top: 14px;">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
                                                <div>
                                                    <div style="color: #1e40af; font-weight: 700;">
                                                        <i class="fa-solid fa-clipboard-check mr-1.5 text-primary"></i> Sesi Terapi Telah Selesai Dilaksanakan
                                                    </div>
                                                    <small class="text-muted d-block mt-0.5" style="font-size: 12px;">
                                                        Terapis: {{ $booking->dokter ? $booking->dokter->nama : 'Terapis Medis' }} &bull; Catatan rekam medis SOAP telah diarsipkan.
                                                    </small>
                                                </div>
                                                <a href="{{ route('portal.riwayat') }}" class="btn btn-xs btn-primary font-w600" style="border-radius: 8px; padding: 6px 14px;">
                                                    Lihat Riwayat Sesi <i class="fa-solid fa-chevron-right ml-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="rounded mb-3" style="background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; padding: 18px 22px; font-size: 12.5px; color: #92400e; line-height: 1.5; margin-top: 14px;">
                                            <i class="fa-solid fa-hourglass-half mr-1.5 text-warning"></i>
                                            Permohonan sesi sedang berada dalam <strong>antrean verifikasi jadwal terapis</strong>. Mohon tunggu konfirmasi dari pihak klinik/UPT.
                                        </div>
                                    @endif

                                    <!-- Catatan Keluhan Pasien Jika Ada -->
                                    @if($booking->keluhan_catatan)
                                        <div class="text-muted mt-3 pt-3 border-top" style="font-size: 12.5px; border-color: #e2e8f0 !important; line-height: 1.6; background: #f8fafc; border-radius: 8px; padding: 12px 16px;">
                                            <span class="font-w700 text-dark d-block mb-0.5"><i class="fa-solid fa-notes-medical text-primary mr-1"></i> Catatan/Keluhan dari Pasien:</span>
                                            <span class="font-italic">"{{ $booking->keluhan_catatan }}"</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5 bg-white rounded" style="border: 1px dashed #cbd5e1; border-radius: 12px;">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #eff6ff; color: #2563eb; font-size: 28px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; border: 1px solid #bfdbfe;">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </div>
                        <h5 class="font-w700 text-dark mb-1" style="font-size: 16px;">Belum Ada Riwayat Booking Sesi</h5>
                        <p class="text-muted mb-3 mx-auto" style="font-size: 12.5px; max-width: 380px;">
                            Anda belum pernah mengajukan reservasi sesi terapi mandiri. Silakan isi formulir di sebelah kiri untuk mengajukan jadwal sesi terapi baru.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Success Booking Popup (Matches UPT & Sesi Modal Theme) -->
@if(Session::has('booking_success'))
    <div class="modal fade show" id="modalSuccessBooking" tabindex="-1" role="dialog" style="display: block; background: rgba(15, 23, 42, 0.55); backdrop-filter: blur(4px);">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 520px;">
            <div class="modal-content ot-success-modal-box">
                <!-- Modal Header -->
                <div class="ot-success-modal-header">
                    <div class="d-flex align-items-center" style="gap: 14px;">
                        <div class="ot-success-modal-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <h4 class="ot-success-modal-title">Permohonan Booking Terkirim!</h4>
                            <span class="ot-success-modal-subtitle">Reservasi jadwal sesi terapi telah tersimpan di sistem</span>
                        </div>
                    </div>
                    <button type="button" class="ot-modal-close-btn" onclick="document.getElementById('modalSuccessBooking').remove();" title="Tutup">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4" style="background: #ffffff;">
                    <!-- Code Card with Custom Copy Cursor -->
                    <div class="ot-code-card copy-trigger-box" onclick="copyKodeBooking('{{ Session::get('kode_booking') }}')" title="Klik untuk menyalin Kode Booking">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span style="font-size: 10.5px; font-weight: 700; color: #047857; text-transform: uppercase; letter-spacing: 0.4px;">KODE BOOKING RESMI</span>
                            <button type="button" class="btn-copy-action" id="btnCopyKodeBookingModal" onclick="event.stopPropagation(); copyKodeBooking('{{ Session::get('kode_booking') }}')">
                                <i class="fa-regular fa-copy mr-1"></i>
                                <span>Salin Kode</span>
                            </button>
                        </div>
                        <div class="p-2 px-3 rounded mb-2" style="background: #ffffff; border: 1px solid #d1fae5;">
                            <div class="ot-code-number" style="font-size: 20px; font-weight: 800; color: #065f46;">{{ Session::get('kode_booking') }}</div>
                        </div>
                        <div style="font-size: 11.5px; color: #065f46; background: rgba(16, 185, 129, 0.08); padding: 7px 10px; border-radius: 6px; border-left: 3px solid #10b981;">
                            <i class="fa-solid fa-circle-check mr-1 text-success"></i> Kode booking ini dapat digunakan untuk memantau status persetujuan sesi terapi Anda.
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                        <a href="{{ route('portal.booking.cetak', Session::get('kode_booking')) }}" target="_blank" class="btn font-w700" style="flex: 1; height: 42px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 8px; font-size: 13px; text-decoration: none; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff !important; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25); border: none;">
                            <i class="fa-solid fa-print"></i>
                            <span>Cetak Bukti (PDF)</span>
                        </a>
                        <button type="button" class="btn btn-light font-w600" onclick="document.getElementById('modalSuccessBooking').remove();" style="height: 42px; border-radius: 8px; padding: 0 20px; font-size: 13px; border: 1.5px solid #cbd5e1; color: #475569;">
                            Pantau Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('script')
<script>
    function copyKodeBooking(kode) {
        if (!kode) return;

        function showFeedback() {
            var btnModal = document.getElementById('btnCopyKodeBookingModal');
            if (btnModal) {
                btnModal.classList.add('copied');
                btnModal.innerHTML = '<i class="fa-solid fa-check mr-1"></i> Tersalin!';
                setTimeout(function() {
                    btnModal.classList.remove('copied');
                    btnModal.innerHTML = '<i class="fa-regular fa-copy mr-1"></i> Salin Kode';
                }, 2500);
            }
            if (typeof toastr !== 'undefined') {
                toastr.success('Kode Booking ' + kode + ' berhasil disalin ke clipboard!', 'Tersalin', {timeOut: 2500});
            }
        }

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(kode).then(showFeedback).catch(function() {
                fallbackCopy(kode);
                showFeedback();
            });
        } else {
            fallbackCopy(kode);
            showFeedback();
        }

        function fallbackCopy(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.opacity = "0";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
            } catch (err) {
                console.error('Fallback copy error', err);
            }
            document.body.removeChild(textArea);
        }
    }

    function filterBookings(status, btnElement) {
        // Toggle active button style
        document.querySelectorAll('.tracking-filter-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        if (btnElement) {
            btnElement.classList.add('active');
        }

        const items = document.querySelectorAll('.booking-item');
        items.forEach(function(item) {
            if (status === 'all') {
                item.style.display = 'block';
            } else {
                const itemStatus = item.getAttribute('data-status');
                if (itemStatus === status) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
    }
</script>
@endsection

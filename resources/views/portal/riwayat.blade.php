@extends('portal.layout.apps')

@section('title', 'Riwayat Sesi Terapi')

@section('style')
<style>
    .riwayat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
    }
    .riwayat-table th {
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #475569;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 12px 18px;
    }
    .riwayat-table td {
        padding: 13px 18px;
        vertical-align: middle;
    }
    .riwayat-table tr:hover {
        background: #f8fafc;
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
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                            Riwayat Sesi Terapi & Kunjungan
                        </h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                            Kronologis seluruh sesi kunjungan terapi, tindakan klinis, dan catatan terapis
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($rekams && $rekams->count() > 0)
        <div class="col-12 mb-4">
            <div class="card shadow-sm riwayat-card" style="border: 1px solid #e2e8f0; border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                        <i class="fa-solid fa-notes-medical text-primary mr-2"></i> Daftar Sesi Pelayanan Rekam Medis
                    </h4>
                    <span class="badge font-w700" style="font-size: 12px; padding: 5px 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                        Total {{ $rekams->count() }} Catatan
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover riwayat-table mb-0" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">No</th>
                                    <th style="width: 20%;">Tanggal & Waktu Sesi</th>
                                    <th style="width: 22%;">Terapis / Tenaga Medis</th>
                                    <th style="width: 18%;">Layanan / Lokasi</th>
                                    <th style="width: 23%;">Keluhan & Catatan</th>
                                    <th style="width: 12%; text-align: center;">Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekams as $index => $rekam)
                                    <tr>
                                        <td class="text-center font-w700 text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="font-w700 text-dark" style="font-size: 13.5px;">
                                                <i class="fa-regular fa-calendar-check text-primary mr-1"></i>
                                                {{ $rekam->tgl_rekam ? \Carbon\Carbon::parse($rekam->tgl_rekam)->isoFormat('D MMMM Y') : '-' }}
                                            </div>
                                            <div class="text-muted mt-0.5" style="font-size: 11.5px;">
                                                <i class="fa-regular fa-clock mr-1"></i> {{ $rekam->created_at ? $rekam->created_at->format('H:i') . ' WIB' : '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-w700 text-dark" style="font-size: 13px;">
                                                <i class="fa-solid fa-user-doctor text-primary mr-1"></i>
                                                {{ $rekam->dokter ? $rekam->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}
                                            </div>
                                            <div class="text-muted" style="font-size: 11.5px;">
                                                {{ $rekam->dokter && $rekam->dokter->spesialisasi ? $rekam->dokter->spesialisasi : 'Fisioterapis / Terapis' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge font-w600" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0;">
                                                <i class="fa-solid fa-location-dot text-primary mr-1"></i>
                                                {{ $rekam->poli ?: ($rekam->upt_lokasi ?: 'Klinik Omah Terapi-KU') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-dark font-w500" style="font-size: 12.5px; line-height: 1.5;">
                                                {{ $rekam->keluhan ?: 'Pemeriksaan rutin / sesi terapi terjadwal' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex" style="gap: 5px;">
                                                @if($rekam->assessment)
                                                    <a href="{{ route('rekam.assessment.print', $rekam->id) }}" target="_blank" class="btn btn-xs btn-primary font-w700" style="border-radius: 6px; padding: 4px 9px;" title="Cetak Hasil Asesmen">
                                                        <i class="fa-solid fa-file-waveform mr-1"></i> Asesmen
                                                    </a>
                                                @endif
                                                <a href="{{ route('rekam.soap.print', $rekam->id) }}" target="_blank" class="btn btn-xs btn-outline-primary font-w600" style="border-radius: 6px; padding: 4px 9px;" title="Cetak Catatan Sesi Terapi">
                                                    <i class="fa-solid fa-file-lines mr-1"></i> Catatan Sesi
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-12">
            <div class="card shadow-sm text-center p-5" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 72px; height: 72px; background: #eff6ff; color: #2563eb; font-size: 32px; border: 1px solid #bfdbfe; margin: 0 auto;">
                    <i class="fa-regular fa-calendar-xmark"></i>
                </div>
                <h4 class="text-dark font-w700 mb-1">Belum Ada Riwayat Sesi Terapi</h4>
                <p class="text-muted" style="max-width: 460px; margin: 0 auto; font-size: 13.5px;">
                    Penerima manfaat ini belum memiliki catatan kunjungan terapi yang tersimpan dalam sistem rekam medis.
                </p>
            </div>
        </div>
    @endif
</div>
@endsection

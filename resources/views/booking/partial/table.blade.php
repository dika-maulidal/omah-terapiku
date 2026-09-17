<!-- Tabel Data Antrean Permohonan Booking Sesi Terapi -->
<div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;">
    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 1100px; width: 100%;">
        <thead>
            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; width: 50px; text-align: center; vertical-align: middle;">#</th>
                <th style="padding: 12px 14px; width: 140px; vertical-align: middle;">Kode & Waktu</th>
                <th style="padding: 12px 14px; min-width: 230px; vertical-align: middle;">Nama Penerima Manfaat</th>
                <th style="padding: 12px 14px; min-width: 200px; vertical-align: middle;">Lokasi UPT & Layanan</th>
                <th style="padding: 12px 14px; min-width: 190px; vertical-align: middle;">Terapis & Jadwal Sesi</th>
                <th style="padding: 12px 14px; width: 150px; text-align: center; vertical-align: middle;">Status Booking</th>
                <th style="padding: 12px 14px; width: 130px; text-align: center; vertical-align: middle; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if(count($bookings) > 0)
                @foreach ($bookings as $key => $row)
                    <tr style="border-bottom: 1px solid #edf2f7; transition: background-color 0.15s ease;">
                        <td style="padding: 12px 14px; vertical-align: middle; text-align: center; color: #64748b; font-weight: 600;">
                            {{ $bookings->firstItem() + $key }}
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <span class="badge font-w800" style="font-size: 11.5px; padding: 4px 8px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 6px; display: inline-block;">
                                {{ $row->kode_booking }}
                            </span>
                            <div class="mt-1 font-w500" style="font-size: 11px; color: #64748b;">
                                <i class="fa-regular fa-clock mr-1" style="color: #94a3b8;"></i>{{ $row->created_at ? $row->created_at->isoFormat('D MMM Y, HH:mm') : '-' }}
                            </div>
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            @if($row->pasien)
                                <strong class="text-dark d-block font-w700" style="font-size: 13.5px;">
                                    <a href="{{ route('rekam.detail', $row->pasien_id) }}" style="color: #1e293b; text-decoration: none;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#1e293b'">
                                        {{ $row->pasien->nama }}
                                    </a>
                                </strong>
                                <div class="d-flex align-items-center flex-wrap mt-0.5" style="gap: 4px; font-size: 11px; color: #64748b;">
                                    <span class="badge font-w700" style="font-size: 10.5px; padding: 2px 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 4px;">
                                        No. RM: {{ $row->pasien->no_rm ?: '-' }}
                                    </span>
                                    @if($row->pasien->no_hp)
                                        @php
                                            $cleanHp = preg_replace('/[^0-9]/', '', $row->pasien->no_hp);
                                            if (str_starts_with($cleanHp, '0')) {
                                                $cleanHp = '62' . substr($cleanHp, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanHp }}" target="_blank" class="d-inline-flex align-items-center ml-1 font-w600 text-success text-decoration-none" style="font-size: 11px;" title="Hubungi Pasien / Wali">
                                            <i class="fa-brands fa-whatsapp mr-1"></i>{{ $row->pasien->no_hp }}
                                        </a>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif

                            @if($row->keluhan_catatan)
                                <div class="mt-1 font-w500 text-truncate" style="font-size: 11px; color: #475569; max-width: 250px;" title="{{ $row->keluhan_catatan }}">
                                    <i class="fa-regular fa-message mr-1 text-primary"></i>Catatan: {{ $row->keluhan_catatan }}
                                </div>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <strong style="color: #334155; font-size: 12.5px;">
                                <i class="fa-solid fa-hospital-user text-primary mr-1"></i>{{ $row->upt_lokasi ?: ($row->pasien ? $row->pasien->upt_lokasi : 'UPT Omah Terapi') }}
                            </strong>
                            <div class="mt-1">
                                <span class="badge font-w600" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 10.5px; border-radius: 4px; padding: 2px 6px;">
                                    <i class="fa-solid fa-hand-holding-medical mr-1"></i>{{ $row->layanan_terapi ?: 'Layanan Terapi' }}
                                </span>
                            </div>
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            @if($row->dokter)
                                <strong class="text-dark d-block font-w700" style="font-size: 12.5px;">
                                    <i class="fa-solid fa-user-doctor text-primary mr-1"></i>{{ $row->dokter->nama }}
                                </strong>
                            @else
                                <span class="badge badge-light text-muted font-w500 mb-1 d-inline-block" style="font-size: 10.5px; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    Belum Ditugaskan
                                </span>
                            @endif
                            <div class="mt-0.5 font-w600 text-dark" style="font-size: 11.5px;">
                                <i class="fa-regular fa-calendar-check mr-1 text-primary"></i>{{ $row->tgl_rencana ? \Carbon\Carbon::parse($row->tgl_rencana)->isoFormat('D MMMM Y') : '-' }}
                            </div>
                            <div class="text-muted font-w500" style="font-size: 11px;">
                                <i class="fa-regular fa-clock mr-1" style="color: #94a3b8;"></i>{{ $row->jam_sesi ?: 'Sesi 1 (08.00 - 08.45 WIB)' }}
                            </div>
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle; text-align: center;">
                            {!! $row->status_badge !!}
                            @if($row->status === 'ditolak' && $row->catatan_petugas)
                                <small class="d-block text-danger font-w500 mt-1" style="font-size: 10.5px; max-width: 140px; margin: 0 auto; line-height: 1.25;" title="{{ $row->catatan_petugas }}">
                                    {{ Str::limit($row->catatan_petugas, 35) }}
                                </small>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle; white-space: nowrap; position: sticky; right: 0; background: #ffffff; z-index: 1; box-shadow: -3px 0 8px rgba(0,0,0,0.04); text-align: center;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 4px;">
                                @if($row->status === 'menunggu')
                                    <!-- Tombol Setujui Booking (ACC) -->
                                    <button type="button" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center btn-approve-booking" 
                                        data-id="{{ $row->id }}" 
                                        data-nama="{{ $row->pasien ? $row->pasien->nama : '-' }}" 
                                        data-layanan="{{ $row->layanan_terapi }}" 
                                        data-tgl="{{ $row->tgl_rencana }}"
                                        data-jam="{{ $row->jam_sesi ?: 'Sesi 1 (08.00 - 08.45 WIB)' }}"
                                        data-upt="{{ $row->upt_lokasi ?: ($row->pasien ? $row->pasien->upt_lokasi : '') }}"
                                        title="Konfirmasi Jadwal & Buat Sesi Rekam" 
                                        style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #10b981; color: #ffffff; border: none;">
                                        <i class="fa-solid fa-check" style="font-size: 11px;"></i>
                                    </button>

                                    <!-- Tombol Tolak -->
                                    <button type="button" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center btn-reject-booking" 
                                        data-id="{{ $row->id }}" 
                                        data-nama="{{ $row->pasien ? $row->pasien->nama : '-' }}" 
                                        title="Tolak Permohonan Booking" 
                                        style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #ef4444; color: #ffffff; border: none;">
                                        <i class="fa-solid fa-xmark" style="font-size: 11px;"></i>
                                    </button>
                                @endif

                                @if($row->pasien_id)
                                    <!-- Tombol Buka Rekam Medis Pasien -->
                                    <a href="{{ route('rekam.detail', $row->pasien_id) }}" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #2563eb; color: #ffffff; border: none;" title="Buka Profil & Rekam Medis Pasien">
                                        <i class="fa-solid fa-folder-open" style="font-size: 11px;"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-calendar-xmark fs-24 mb-2 d-block" style="opacity: 0.5;"></i>
                        <p class="mb-0 fs-13 font-w500">Tidak ada data permohonan booking sesi terapi yang sesuai dengan filter.</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
    <div class="dataTables_info mb-2 mb-md-0" id="example_info" role="status"
    aria-live="polite" style="font-size: 12.5px; color: #64748b;">
        Menampilkan <strong class="text-dark">{{ $bookings->firstItem() ?: 0 }}</strong> sampai <strong class="text-dark">{{ $bookings->lastItem() ?: 0 }}</strong> dari <strong class="text-dark">{{ $bookings->total() }}</strong> permohonan booking
    </div>
    <div class="pagination-wrapper">
        {{ $bookings->appends(request()->except('page'))->links() }}
    </div>
</div>

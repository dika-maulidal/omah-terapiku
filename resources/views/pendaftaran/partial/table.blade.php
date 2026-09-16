<!-- Tabel Data Antrean Verifikasi Pendaftaran Penerima Manfaat Baru -->
<div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;">
    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 1100px; width: 100%;">
        <thead>
            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; width: 50px; text-align: center; vertical-align: middle;">#</th>
                <th style="padding: 12px 14px; width: 140px; vertical-align: middle;">Kode & Tanggal</th>
                <th style="padding: 12px 14px; min-width: 220px; vertical-align: middle;">Nama Penerima Manfaat</th>
                <th style="padding: 12px 14px; min-width: 180px; vertical-align: middle;">Orang Tua / Wali</th>
                <th style="padding: 12px 14px; min-width: 200px; vertical-align: middle;">Lokasi UPT & Layanan</th>
                <th style="padding: 12px 14px; width: 160px; text-align: center; vertical-align: middle;">Status Verifikasi</th>
                <th style="padding: 12px 14px; width: 130px; text-align: center; vertical-align: middle; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if(count($pendaftarans) > 0)
                @foreach ($pendaftarans as $key => $row)
                    <tr style="border-bottom: 1px solid #edf2f7; transition: background-color 0.15s ease;">
                        <td style="padding: 12px 14px; vertical-align: middle; text-align: center; color: #64748b; font-weight: 600;">
                            {{ $pendaftarans->firstItem() + $key }}
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <span class="badge font-w800" style="font-size: 11.5px; padding: 4px 8px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 6px; display: inline-block;">
                                {{ $row->kode_pendaftaran }}
                            </span>
                            <div class="mt-1 font-w500" style="font-size: 11px; color: #64748b;">
                                <i class="fa-regular fa-clock mr-1" style="color: #94a3b8;"></i>{{ $row->created_at ? $row->created_at->isoFormat('D MMM Y, HH:mm') : '-' }}
                            </div>
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <strong class="text-dark d-block font-w700" style="font-size: 13.5px;">
                                {{ $row->nama }}
                            </strong>
                            <div class="d-flex align-items-center flex-wrap mt-0.5" style="gap: 4px; font-size: 11px; color: #64748b;">
                                <span><i class="fa-solid fa-venus-mars mr-1 text-primary"></i>{{ $row->jk ?: '-' }}</span>
                                @if($row->nik)
                                    <span>&bull; <i class="fa-solid fa-id-badge mr-0.5 text-primary"></i>NIK: {{ $row->nik }}</span>
                                @endif
                            </div>
                            @if($row->tgl_lahir)
                                <div class="mt-0.5 font-w500" style="font-size: 11px; color: #64748b;">
                                    <i class="fa-regular fa-calendar mr-1" style="color: #94a3b8;"></i>{{ \Carbon\Carbon::parse($row->tgl_lahir)->isoFormat('D MMM Y') }} ({{ \Carbon\Carbon::parse($row->tgl_lahir)->age }} Thn)
                                </div>
                            @endif
                            @if($row->jenis_disabilitas && $row->jenis_disabilitas != 'Tidak Ada')
                                <div class="mt-1">
                                    <span class="badge badge-info light font-w600" style="font-size: 10px; padding: 2px 6px;">
                                        <i class="fa-solid fa-wheelchair mr-1"></i>{{ $row->jenis_disabilitas }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <div class="font-w700 text-dark" style="font-size: 12.5px;">{{ $row->nama_wali ?: '-' }}</div>
                            <small class="text-muted d-block font-w500" style="font-size: 11px;">Hubungan: {{ $row->hubungan_wali ?: 'Wali' }}</small>
                            @if($row->no_hp)
                                @php
                                    $cleanHp = preg_replace('/[^0-9]/', '', $row->no_hp);
                                    if (str_starts_with($cleanHp, '0')) {
                                        $cleanHp = '62' . substr($cleanHp, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $cleanHp }}" target="_blank" class="d-inline-flex align-items-center mt-1 font-w700 text-success text-decoration-none" style="font-size: 11.5px;" title="Hubungi via WhatsApp">
                                    <i class="fa-brands fa-whatsapp mr-1" style="font-size: 13px;"></i>{{ $row->no_hp }}
                                </a>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <strong style="color: #334155; font-size: 12.5px;">
                                <i class="fa-solid fa-hospital-user text-primary mr-1"></i>{{ $row->upt_lokasi ?: 'UPT Omah Terapi' }}
                            </strong>
                            <div class="mt-1">
                                <span class="badge font-w600" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 10.5px; border-radius: 4px; padding: 2px 6px;">
                                    <i class="fa-solid fa-hand-holding-medical mr-1"></i>{{ $row->layanan_terapi ?: 'Terapi Terpadu' }}
                                </span>
                            </div>
                            <div class="mt-1 font-w500" style="font-size: 11px; color: #64748b;">
                                <i class="fa-regular fa-calendar-check mr-1" style="color: #2563eb;"></i>{{ $row->tgl_rencana_kunjungan ? \Carbon\Carbon::parse($row->tgl_rencana_kunjungan)->isoFormat('D MMM Y') : '-' }}
                                <span class="d-block text-muted">{{ $row->jam_rencana_kunjungan ?: 'Sesi 1 (08.00 - 08.45 WIB)' }}</span>
                            </div>
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle; text-align: center;">
                            {!! $row->status_badge !!}
                            @if($row->status === 'disetujui')
                                @if($row->no_rm_diterbitkan)
                                    <div class="mt-1">
                                        <span class="badge font-w800" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 10.5px; padding: 2px 6px;">
                                            No. RM: {{ $row->no_rm_diterbitkan }}
                                        </span>
                                    </div>
                                @endif
                                @if($row->terapis)
                                    <small class="d-block text-success font-w700 mt-0.5" style="font-size: 11px;">
                                        <i class="fa-solid fa-user-doctor mr-0.5"></i> {{ $row->terapis->nama }}
                                    </small>
                                @endif
                                @if($row->catatan_petugas && $row->catatan_petugas !== 'Pendaftaran disetujui. Terapis dan jadwal sesi terapi pertama telah ditetapkan.')
                                    <small class="d-block text-muted font-w500 mt-0.5" style="font-size: 10.5px; max-width: 140px; margin: 0 auto; line-height: 1.25;" title="Catatan Persetujuan: {{ $row->catatan_petugas }}">
                                        <i class="fa-solid fa-comment-dots mr-0.5 text-success"></i> {{ Str::limit($row->catatan_petugas, 28) }}
                                    </small>
                                @endif
                            @elseif($row->status === 'ditolak' && $row->catatan_petugas)
                                <small class="d-block text-danger font-w500 mt-1" style="font-size: 10.5px; max-width: 140px; margin: 0 auto; line-height: 1.25;" title="Alasan Penolakan: {{ $row->catatan_petugas }}">
                                    <i class="fa-solid fa-circle-xmark mr-0.5"></i> {{ Str::limit($row->catatan_petugas, 35) }}
                                </small>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle; white-space: nowrap; position: sticky; right: 0; background: #ffffff; z-index: 1; box-shadow: -3px 0 8px rgba(0,0,0,0.04); text-align: center;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 4px;">
                                <!-- Tombol Detail / Preview -->
                                <button type="button" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center btn-detail-pendaftaran" data-id="{{ $row->id }}" title="Lihat Detail & Berkas Persyaratan" style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #2563eb; color: #ffffff; border: none;">
                                    <i class="fa-solid fa-eye" style="font-size: 11px;"></i>
                                </button>

                                @if($row->status === 'menunggu')
                                    <!-- Tombol Setujui (ACC) -->
                                    <button type="button" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center btn-approve-pendaftaran" 
                                        data-id="{{ $row->id }}" 
                                        data-nama="{{ $row->nama }}" 
                                        data-layanan="{{ $row->layanan_terapi }}" 
                                        data-tgl="{{ $row->tgl_rencana_kunjungan ?: date('Y-m-d') }}" 
                                        data-jam="{{ $row->jam_rencana_kunjungan ?: 'Sesi 1 (08.00 - 08.45 WIB)' }}"
                                        data-upt="{{ $row->upt_lokasi }}"
                                        title="Setujui, Pilih Terapis & Terbitkan No. RM" 
                                        style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #10b981; color: #ffffff; border: none;">
                                        <i class="fa-solid fa-check" style="font-size: 11px;"></i>
                                    </button>

                                    <!-- Tombol Tolak -->
                                    <button type="button" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center btn-reject-pendaftaran" data-id="{{ $row->id }}" data-nama="{{ $row->nama }}" title="Tolak Pendaftaran" style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #ef4444; color: #ffffff; border: none;">
                                        <i class="fa-solid fa-xmark" style="font-size: 11px;"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-user-clock fs-24 mb-2 d-block" style="opacity: 0.5;"></i>
                        <p class="mb-0 fs-13 font-w500">Tidak ada data pendaftaran penerima manfaat yang sesuai dengan filter.</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
    <div class="dataTables_info mb-2 mb-md-0" id="example_info" role="status"
    aria-live="polite" style="font-size: 12.5px; color: #64748b;">
        Menampilkan <strong class="text-dark">{{ $pendaftarans->firstItem() ?: 0 }}</strong> sampai <strong class="text-dark">{{ $pendaftarans->lastItem() ?: 0 }}</strong> dari <strong class="text-dark">{{ $pendaftarans->total() }}</strong> antrean pendaftaran
    </div>
    <div class="pagination-wrapper">
        {{ $pendaftarans->appends(request()->except('page'))->links() }}
    </div>
</div>

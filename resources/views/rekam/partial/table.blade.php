<!-- Tabel Data Rekam Medis -->
<div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;"> 
    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 1050px; width: 100%;">
        <thead>
            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; width: 45px; text-align: center;">#</th>
                <th style="padding: 12px 14px; width: 130px;">No. RM & Tanggal</th>
                <th style="padding: 12px 14px; min-width: 200px;">Nama Penerima Manfaat</th>
                <th style="padding: 12px 14px; min-width: 190px;">Omah Terapi & Terapis</th>
                <th style="padding: 12px 14px; min-width: 220px;">Keluhan (Anamnesa)</th>
                <th style="padding: 12px 14px; width: 120px; text-align: center;">Status</th>
                <th style="padding: 12px 14px; min-width: 130px; text-align: center; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if(count($rekams) > 0)
                @foreach ($rekams as $key => $row)
                    <tr style="transition: background-color 0.15s ease;">
                        <td style="padding: 12px 14px; vertical-align: middle; text-align: center; color: #64748b;">
                            {{ $rekams->firstItem() + $key }}
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <a href="{{Route('rekam.detail', $row->pasien_id)}}" class="font-w700" style="color: #2563eb; font-size: 13.5px; text-decoration: none;">
                                {{ $row->pasien && $row->pasien->no_rm ? $row->pasien->no_rm : ($row->no_rekam ?? '-') }}
                            </a>
                            <div class="mt-1" style="font-size: 11.5px; color: #64748b;">
                                <i class="fa-solid fa-calendar mr-1" style="color: #94a3b8;"></i>{{$row->tgl_rekam}}
                            </div>
                            @if($row->sesi_waktu)
                                <div class="mt-1">
                                    <span class="badge" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 10.5px; font-weight: 600; border-radius: 4px; padding: 2px 6px;">
                                        <i class="fa-solid fa-clock mr-1"></i> {{$row->sesi_waktu}}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <strong style="font-size: 13.5px;">
                                <a href="{{Route('rekam.detail', $row->pasien_id)}}" style="color: #1e293b; text-decoration: none;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#1e293b'">
                                    {{$row->pasien->nama ?? '-'}}
                                </a>
                            </strong>
                            @if ($row->pasien && $row->pasien->jenis_disabilitas && $row->pasien->jenis_disabilitas != 'Tidak Ada')
                                <div class="mt-1">
                                    <span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 500; border-radius: 4px; padding: 2px 6px;">
                                        <i class="fa-solid fa-wheelchair mr-1"></i>{{$row->pasien->jenis_disabilitas}}
                                    </span>
                                </div>
                            @endif
                            @if ($row->pasien && $row->pasien->nama_wali)
                                <div class="mt-1" style="font-size: 11.5px; color: #64748b;">
                                    <i class="fa-solid fa-user-group mr-1" style="color: #94a3b8;"></i>Wali: {{$row->pasien->nama_wali}}
                                </div>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle;">
                            <strong style="color: #334155; font-size: 13px;">{{$row->upt_lokasi ?: ($row->poli ?: 'Omah Terapi')}}</strong>
                            @if ($row->layanan_terapi)
                                <div class="mt-1">
                                    <span class="badge" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 600; border-radius: 4px; padding: 2px 6px;">
                                        {{$row->layanan_terapi}}
                                    </span>
                                </div>
                            @endif
                            <div class="mt-1" style="font-size: 11.5px; color: #64748b;">
                                <i class="fa-solid fa-user-doctor mr-1" style="color: #2563eb;"></i>{{$row->dokter->nama ?? '-'}}
                            </div>
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle; max-width: 260px;">
                            <span style="font-size: 12.5px; line-height: 1.45; color: #475569; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{$row->keluhan ?: '-'}}">
                                {{$row->keluhan ?: '-'}}
                            </span>
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle; text-align: center;">
                            {!! $row->status_display() !!}
                        </td>
                        <td style="padding: 12px 14px; vertical-align: middle; white-space: nowrap; position: sticky; right: 0; background: #ffffff; z-index: 1; box-shadow: -3px 0 8px rgba(0,0,0,0.04); text-align: center;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 4px;">
                                <a href="{{Route('rekam.detail', $row->pasien_id)}}" class="btn btn-xs btn-primary shadow-sm" style="border-radius: 6px; padding: 4px 8px; background: #2563eb; border: none;" title="Lihat Rekam Medis">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if (in_array(auth()->user()->role_display(), ['Admin', 'Dokter']))
                                    <a href="{{Route('rekam.assessment', $row->id)}}" class="btn btn-xs shadow-sm text-white" style="border-radius: 6px; padding: 4px 8px; background: #f59e0b; border: none;" title="Form Assessment Terapis">
                                        <i class="fa-solid fa-clipboard-list"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->role_display() == "Admin" && $row->status == 2)
                                    <a href="{{Route('rekam.edit', $row->id)}}" class="btn btn-xs shadow-sm text-white" style="border-radius: 6px; padding: 4px 8px; background: #0284c7; border: none;" title="Edit Data Rekam Medis">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-xs btn-danger shadow-sm delete" r-link="{{Route('rekam.delete', $row->id)}}"
                                       r-name="{{$row->pasien->nama ?? 'Rekam'}}" r-id="{{$row->id}}" style="border-radius: 6px; padding: 4px 8px;" title="Hapus Data">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-2" style="width: 54px; height: 54px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 22px;">
                                <i class="fa-solid fa-clipboard-question"></i>
                            </div>
                            <h6 class="font-w600 text-dark mb-1">Tidak ada data rekam medis</h6>
                            <p class="mb-0 text-muted" style="font-size: 12.5px;">Coba ubah kata kunci pencarian atau reset filter di atas.</p>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="d-flex align-items-center justify-content-between p-3 flex-wrap" style="border-top: 1px solid #edf2f7; gap: 10px;">
        <div class="dataTables_info" id="example_info" role="status" aria-live="polite" style="font-size: 12.5px; color: #64748b;">
            Menampilkan <strong class="text-dark">{{$rekams->firstItem() ?: 0}}</strong> sampai <strong class="text-dark">{{$rekams->lastItem() ?: 0}}</strong> dari <strong class="text-dark">{{$rekams->total()}}</strong> data rekam medis
        </div>
        <div class="pagination-wrapper">
            {{ $rekams->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>

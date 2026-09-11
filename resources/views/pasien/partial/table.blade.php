<!-- Tabel Data Penerima Manfaat -->
<div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;"> 
    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 1100px; width: 100%;">
        <thead>
            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; width: 65px; text-align: center; vertical-align: middle;">#</th>
                <th style="padding: 12px 14px; width: 115px; vertical-align: middle;">No. RM</th>
                <th style="padding: 12px 14px; min-width: 210px; vertical-align: middle;">Nama Penerima Manfaat</th>
                <th style="padding: 12px 14px; min-width: 140px; vertical-align: middle;">TTL</th>
                <th style="padding: 12px 14px; min-width: 180px; vertical-align: middle;">Alamat</th>
                <th style="padding: 12px 14px; width: 60px; text-align: center; vertical-align: middle;">JK</th>
                <th style="padding: 12px 14px; width: 110px; text-align: center; vertical-align: middle;">Desil</th>
                <th style="padding: 12px 14px; min-width: 115px; vertical-align: middle;">No. HP</th>
                <th style="padding: 12px 14px; width: 135px; text-align: center; vertical-align: middle;">Status</th>
                <th style="padding: 12px 14px; width: 120px; text-align: center; vertical-align: middle; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if(count($datas) > 0)
                @foreach ($datas as $key=>$row)
                    <tr style="border-bottom: 1px solid #edf2f7; transition: background 0.15s ease;">
                        <td style="vertical-align: middle; text-align: center; color: #64748b; font-weight: 600;">{{$datas->firstItem() + $key}}</td>
                        <td style="vertical-align: middle;">
                            <a href="{{Route('rekam.detail',$row->id)}}" class="badge badge-light font-w700" style="background: #eff6ff; color: #2563eb; font-size: 12px; padding: 6px 10px; border-radius: 6px; text-decoration: none; display: inline-block;">
                                {{$row->no_rm}}
                            </a>
                        </td>
                        <td style="vertical-align: middle;">
                            <a href="{{Route('rekam.detail',$row->id)}}" class="font-w700" style="font-size: 13.5px; color: #1e293b; text-decoration: none;">
                                {{$row->nama}}
                            </a>
                            @if ($row->jenis_disabilitas && $row->jenis_disabilitas != 'Tidak Ada')
                                <div><span class="badge badge-info light font-w600 mt-1" style="font-size: 10.5px; padding: 2px 6px;">{{$row->jenis_disabilitas}}</span></div>
                            @endif
                            @if ($row->nama_wali)
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa-solid fa-user-group mr-1" style="color: #94a3b8;"></i>Wali: {{$row->nama_wali}}</small>
                            @endif
                        </td>
                        <td style="vertical-align: middle; color: #334155;">{{$row->tmp_lahir}}, {{$row->tgl_lahir}}</td>
                        <td style="vertical-align: middle; color: #334155;">{{$row->alamat_lengkap}}</td>
                        <td style="vertical-align: middle; text-align: center;">
                            <span class="badge badge-light font-w600" style="font-size: 11px; background: #f1f5f9; color: #475569;">
                                {{$row->jk}}
                            </span>
                        </td>
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($row->desil)
                                @if (in_array($row->desil, ['Desil 1', 'Desil 2', 'Desil 3', 'Desil 4']))
                                    <span class="badge badge-success light font-w700" style="font-size: 11px; padding: 4px 8px;">
                                        <i class="fa-solid fa-check mr-1"></i>{{$row->desil}}
                                    </span>
                                @else
                                    <span class="badge badge-warning light font-w600" style="font-size: 11px; padding: 4px 8px;">
                                        {{$row->desil}}
                                    </span>
                                @endif
                            @else
                                <span class="text-muted fs-12">-</span>
                            @endif
                        </td>
                        <td style="vertical-align: middle; color: #334155;">{{$row->no_hp ?? '-'}}</td>
                        <td style="vertical-align: middle; text-align: center;">
                            {!! $row->statusPasien() !!}
                        </td>
                        <td style="white-space: nowrap; vertical-align: middle; position: sticky; right: 0; background: #ffffff; z-index: 1; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 4px;">
                                <a href="{{Route('rekam.detail',$row->id)}}" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #2563eb; color: #fff;" title="Lihat Rekam Medis">
                                    <i class="fa-solid fa-eye" style="font-size: 11px;"></i>
                                </a>
                                <a href="{{Route('penerima-manfaat.edit',$row->id)}}" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #0284c7; color: #fff;" title="Edit Data Pasien">
                                    <i class="fa-solid fa-pencil" style="font-size: 11px;"></i>
                                </a>
                                <a href="#" class="btn btn-xs shadow-sm d-inline-flex align-items-center justify-content-center delete" style="width: 28px; height: 28px; padding: 0; border-radius: 8px; background: #ef4444; color: #fff;" r-link="{{Route('penerima-manfaat.delete',$row->id)}}"
                                    r-name="{{$row->nama}}" r-id="{{$row->id}}" title="Hapus Data Pasien">
                                    <i class="fa-solid fa-trash" style="font-size: 11px;"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-users-slash fs-24 mb-2 d-block" style="opacity: 0.5;"></i>
                        <p class="mb-0 fs-13 font-w500">Tidak ada data penerima manfaat yang sesuai.</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
    <div class="dataTables_info mb-2 mb-md-0" id="example_info" role="status"
    aria-live="polite" style="font-size: 12.5px; color: #64748b;">
        Menampilkan <strong class="text-dark">{{$datas->firstItem() ?: 0}}</strong> sampai <strong class="text-dark">{{$datas->lastItem() ?: 0}}</strong> dari <strong class="text-dark">{{$datas->total()}}</strong> data penerima manfaat
    </div>
    <div class="pagination-wrapper">
        {{ $datas->appends(request()->except('page'))->links() }}
    </div>
</div>

@extends('layout.apps')
@section('content')

<!-- Page Header Banner (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-users-rectangle"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Data Penerima Manfaat</h3>
                    <p class="text-muted mb-0" style="font-size: 12.5px;">Kelola, cari, dan pantau seluruh data penerima manfaat Omah Terapi-KU</p>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <a href="{{Route('penerima-manfaat.add')}}" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; border-radius: 8px; font-size: 12.5px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-user-plus mr-1"></i> Penerima Manfaat Baru
                </a>
                <a href="{{Route('penerima-manfaat.export-csv', request()->all())}}" class="btn btn-sm btn-success font-w600" style="background: #10b981 !important; border: none !important; color: #ffffff !important; font-size: 12.5px; padding: 8px 16px; border-radius: 8px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);" title="Download data penerima manfaat ke CSV">
                    <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
                </a>
                <a href="https://cekbansos.kemensos.go.id/" target="_blank" rel="noopener noreferrer" class="btn btn-sm font-w600" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; font-size: 12.5px; padding: 7px 14px; border-radius: 8px;" title="Buka website resmi Kemensos untuk cek desil / bansos">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Cek Desil Kemensos
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <!-- Toolbar Filter & Search Sejajar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700">{{ $datas->total() }}</strong> Penerima Manfaat
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            <!-- 1. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 135px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Status Pelayanan" style="width: 100%;">
                                    <option value="">Semua Status</option>
                                    <option value="sudah_periksa" {{ request('status') == 'sudah_periksa' ? 'selected' : '' }}>Sudah Terapi</option>
                                    <option value="pasien_baru" {{ request('status') == 'pasien_baru' ? 'selected' : '' }}>Penerima Baru</option>
                                    <option value="pasien_lama" {{ request('status') == 'pasien_lama' ? 'selected' : '' }}>Penerima Lama</option>
                                </select>
                            </div>

                            <!-- 2. Filter Desil -->
                            <div class="ot-filter-wrapper" style="width: 130px;">
                                <i class="fa-solid fa-layer-group"></i>
                                <select name="desil" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Tingkat Desil" style="width: 100%;">
                                    <option value="">Semua Desil</option>
                                    <option value="prioritas" {{ request('desil') == 'prioritas' ? 'selected' : '' }}>Prioritas (1-5)</option>
                                    <option value="Desil 1" {{ request('desil') == 'Desil 1' ? 'selected' : '' }}>Desil 1</option>
                                    <option value="Desil 2" {{ request('desil') == 'Desil 2' ? 'selected' : '' }}>Desil 2</option>
                                    <option value="Desil 3" {{ request('desil') == 'Desil 3' ? 'selected' : '' }}>Desil 3</option>
                                    <option value="Desil 4" {{ request('desil') == 'Desil 4' ? 'selected' : '' }}>Desil 4</option>
                                    <option value="Desil 5" {{ request('desil') == 'Desil 5' ? 'selected' : '' }}>Desil 5</option>
                                    <option value="desil_6_10" {{ request('desil') == 'desil_6_10' ? 'selected' : '' }}>Desil 6-10</option>
                                    <option value="non_desil" {{ request('desil') == 'non_desil' ? 'selected' : '' }}>Non-Desil</option>
                                </select>
                            </div>

                            <!-- 3. Filter Jenis Kelamin -->
                            <div class="ot-filter-wrapper" style="width: 110px;">
                                <i class="fa-solid fa-venus-mars"></i>
                                <select name="jk" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Jenis Kelamin" style="width: 100%;">
                                    <option value="">Semua JK</option>
                                    <option value="Laki-laki" {{ request('jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ request('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- 4. Filter Disabilitas -->
                            <div class="ot-filter-wrapper" style="width: 135px;">
                                <i class="fa-solid fa-wheelchair"></i>
                                <select name="disabilitas" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Ragam Disabilitas" style="width: 100%;">
                                    <option value="">Semua Ragam</option>
                                    <option value="Fisik" {{ request('disabilitas') == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                    <option value="Intelektual" {{ request('disabilitas') == 'Intelektual' ? 'selected' : '' }}>Intelektual</option>
                                    <option value="Mental" {{ request('disabilitas') == 'Mental' ? 'selected' : '' }}>Mental</option>
                                    <option value="Sensorik" {{ request('disabilitas') == 'Sensorik' ? 'selected' : '' }}>Sensorik</option>
                                    <option value="Ganda" {{ request('disabilitas') == 'Ganda' ? 'selected' : '' }}>Ganda</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 175px; max-width: 210px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" name="keyword" value="{{request('keyword')}}" placeholder="Cari nama, RM..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            @if(request('keyword') || request('status') || request('desil') || request('jk') || request('disabilitas'))
                                <a href="{{ Route('penerima-manfaat') }}" class="btn btn-sm btn-light font-w600" style="height: 38px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 12px; transition: all 0.2s ease;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right mr-1" style="color: #64748b;"></i> Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Tabel Data Penerima Manfaat -->
                <div class="table-responsive card-table" style="border: 1px solid #edf2f7; border-radius: 10px; overflow-x: auto !important; width: 100%;"> 
                    <table class="table table-hover mb-0" style="font-size: 13px; min-width: 1100px; width: 100%;">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 12px 14px; width: 45px; text-align: center;">#</th>
                                <th style="padding: 12px 14px; width: 115px;">No. RM</th>
                                <th style="padding: 12px 14px; min-width: 210px;">Nama Penerima Manfaat</th>
                                <th style="padding: 12px 14px; min-width: 140px;">TTL</th>
                                <th style="padding: 12px 14px; min-width: 180px;">Alamat</th>
                                <th style="padding: 12px 14px; width: 60px; text-align: center;">JK</th>
                                <th style="padding: 12px 14px; width: 110px; text-align: center;">Desil</th>
                                <th style="padding: 12px 14px; min-width: 115px;">No. HP</th>
                                <th style="padding: 12px 14px; width: 135px; text-align: center;">Status</th>
                                <th style="padding: 12px 14px; width: 120px; text-align: center; position: sticky; right: 0; background: #f8fafc; z-index: 2; box-shadow: -3px 0 8px rgba(0,0,0,0.04);">Aksi</th>
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
                                             <div class="d-flex align-items-center">
                                                 <div class="mr-2" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; flex-shrink: 0;">
                                                     {{ strtoupper(substr($row->nama ?? 'P', 0, 2)) }}
                                                 </div>
                                                 <div>
                                                     <a href="{{Route('rekam.detail',$row->id)}}" class="font-w700" style="font-size: 13.5px; color: #1e293b; text-decoration: none;">
                                                         {{$row->nama}}
                                                     </a>
                                                     @if ($row->jenis_disabilitas && $row->jenis_disabilitas != 'Tidak Ada')
                                                         <div><span class="badge badge-info light font-w600 mt-1" style="font-size: 10.5px; padding: 2px 6px;">{{$row->jenis_disabilitas}}</span></div>
                                                     @endif
                                                     @if ($row->nama_wali)
                                                         <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa-solid fa-user-group mr-1" style="color: #94a3b8;"></i>Wali: {{$row->nama_wali}}</small>
                                                     @endif
                                                 </div>
                                             </div>
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
                                                @if (in_array($row->desil, ['Desil 1', 'Desil 2', 'Desil 3', 'Desil 4', 'Desil 5']))
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
                    aria-live="polite" style="font-size: 12.5px; color: #64748b;">Showing {{$datas->firstItem() ?: 0}} to {{$datas->perPage() * $datas->currentPage()}} of {{$datas->total()}} entries</div>
                    <div>
                        {{ $datas->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $(".delete").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');
            Swal.fire({
                title: 'Ingin Menghapus?',
                text: "Yakin ingin menghapus data penerima manfaat : " + name + " ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    window.location = link;
                }
            });
        });
    });
</script>
@endsection
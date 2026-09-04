@extends('layout.apps')
@section('content')

<!-- Header Section (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Data Rekam Medis</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{Route('dashboard')}}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item active text-muted">Rekam Medis</li>
                    </ol>
                </div>
            </div>

            <!-- Tombol Tambah & Export -->
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <a href="{{Route('rekam.add')}}" class="btn btn-sm btn-primary font-w600" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 16px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); font-size: 13px;">
                    <i class="fa-solid fa-circle-plus mr-1"></i> Input Sesi Terapi
                </a>
                <a href="{{Route('rekam.export-csv', ['keyword' => request('keyword'), 'status' => request('status', request('tab')), 'layanan' => request('layanan')])}}" class="btn btn-sm font-w600" style="border: 1px solid #a7f3d0; border-radius: 8px; background: #ecfdf5; color: #059669; padding: 8px 14px; font-size: 13px; transition: all 0.2s ease;" title="Download data rekam medis ke CSV">
                    <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Section -->
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <!-- Toolbar Filter & Search Sejajar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700">{{ $rekams->total() }}</strong> Sesi Rekam Medis
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            <!-- 1. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 140px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Status Pelayanan" style="width: 100%;">
                                    <option value="" {{ request('status') == '' && request('tab') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="1" {{ request('status') == '1' || request('tab') == '1' ? 'selected' : '' }}>Antrian</option>
                                    <option value="2" {{ request('status') == '2' || request('tab') == '2' ? 'selected' : '' }}>Pemeriksaan</option>
                                    <option value="3" {{ request('status') == '3' || request('tab') == '3' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="5" {{ request('status') == '5' || request('tab') == '5' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <!-- 2. Filter Layanan Terapi -->
                            <div class="ot-filter-wrapper" style="width: 155px;">
                                <i class="fa-solid fa-hand-holding-medical"></i>
                                <select name="layanan" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" title="Filter Layanan Terapi" style="width: 100%;">
                                    <option value="">Semua Layanan</option>
                                    <option value="Fisioterapi" {{ request('layanan') == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                                    <option value="Okupasi" {{ request('layanan') == 'Okupasi' ? 'selected' : '' }}>Terapi Okupasi / SI</option>
                                    <option value="Wicara" {{ request('layanan') == 'Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                                    <option value="Netra" {{ request('layanan') == 'Netra' ? 'selected' : '' }}>Terapi Netra</option>
                                </select>
                            </div>

                            <!-- 3. Filter Shows (Per Page Limit) -->
                            <div class="ot-filter-wrapper" style="width: 120px;" title="Tampilkan jumlah baris data per halaman">
                                <i class="fa-solid fa-list-ol"></i>
                                <select name="per_page" class="form-control form-control-sm ot-filter-select" onchange="this.form.submit()" style="width: 100%;">
                                    <option value="10" {{ request('per_page', 10) == '10' ? 'selected' : '' }}>Show 10</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>Show 25</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>Show 50</option>
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>Show 100</option>
                                    <option value="250" {{ request('per_page') == '250' ? 'selected' : '' }}>Show 250</option>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Show Semua</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 185px; max-width: 220px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" name="keyword" value="{{request('keyword')}}" placeholder="Cari no. RM, pasien..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            @if(request('keyword') || request('status') || request('tab') || request('layanan') || (request('per_page') && request('per_page') != '10'))
                                <a href="{{ Route('rekam') }}" class="btn btn-sm btn-light font-w600" style="height: 38px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 12px; transition: all 0.2s ease;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right mr-1" style="color: #64748b;"></i> Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

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
                                            @if($row->terapisPendamping)
                                                <div class="mt-0.5" style="font-size: 11px; color: #0284c7;">
                                                    <i class="fa-solid fa-hands-holding-child mr-1"></i>Pendamping: {{$row->terapisPendamping->nama}}
                                                </div>
                                            @endif
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
                                                <a href="{{Route('rekam.assessment', $row->id)}}" class="btn btn-xs shadow-sm text-white" style="border-radius: 6px; padding: 4px 8px; background: #f59e0b; border: none;" title="Form Assessment Terapis">
                                                    <i class="fa-solid fa-clipboard-list"></i>
                                                </a>
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
                        <div>
                            {{ $rekams->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $().ready( function () {
        $(".delete").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');

            Swal.fire({
                title: 'Ingin Menghapus?',
                text: "Yakin ingin menghapus data rekam medis: " + name + " ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus Data',
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

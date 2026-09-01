@extends('layout.apps')
@section('content')
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Data Rekam Medis</h2>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <!-- Tombol Aksi Kiri -->
                    <div class="col-md-6 col-12 mb-2 mb-md-0 d-flex align-items-center flex-wrap" style="gap: 6px;">
                        <a href="{{Route('rekam.add')}}" class="btn btn-sm btn-primary" style="font-size: 13px; padding: 7px 14px; font-weight: 600;">
                            <i class="fa fa-plus mr-1"></i> Rekam Medis Baru
                        </a>
                        <a href="{{Route('rekam.export-csv', ['keyword' => request('keyword'), 'status' => request('status', request('tab'))])}}" class="btn btn-sm btn-success" style="font-size: 13px; padding: 7px 14px; font-weight: 600;" title="Download data rekam medis ke CSV">
                            <i class="fa fa-file-excel-o mr-1"></i> Export CSV
                        </a>
                    </div>

                    <!-- Filter Status & Pencarian Kanan -->
                    <div class="col-md-6 col-12">
                        <form method="get" action="{{ url()->current() }}">
                            <div class="d-flex align-items-center justify-content-md-end flex-wrap" style="gap: 6px;">
                                <!-- Dropdown Filter Status -->
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()" style="max-width: 155px; height: 36px; font-size: 12.5px;">
                                    <option value="" {{ request('status') == '' && request('tab') == '' ? 'selected' : '' }}>-- Semua Status --</option>
                                    <option value="1" {{ request('status') == '1' || request('tab') == '1' ? 'selected' : '' }}>Antrian</option>
                                    <option value="2" {{ request('status') == '2' || request('tab') == '2' ? 'selected' : '' }}>Pemeriksaan</option>
                                    <option value="3" {{ request('status') == '3' || request('tab') == '3' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="5" {{ request('status') == '5' || request('tab') == '5' ? 'selected' : '' }}>Selesai</option>
                                </select>

                                <!-- Kolom Pencarian -->
                                <div class="input-group" style="max-width: 230px;">
                                    <input type="text" class="form-control form-control-sm gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari rekam / pasien..." autocomplete="off" style="height: 36px; font-size: 12.5px;">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary btn-sm no-border gp-search" style="height: 36px; padding: 0 12px;">
                                            <i class="ace-icon fa fa-search icon-on-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tombol Reset Filter -->
                                @if(request('keyword') || request('status') || request('tab'))
                                    <a href="{{ Route('rekam') }}" class="btn btn-sm btn-light" style="height: 36px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #e2e8f0;" title="Reset Filter">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive card-table"> 
                    <table class="table table-responsive-md" style="font-size: 13px;">
                        <thead>
                            <tr style="font-size: 12.5px;">
                                <th>#</th>
                                <th>No. RM & Tanggal</th>
                                <th>Nama Penerima Manfaat</th>
                                <th>Omah Terapiku & Terapis</th>
                                <th>Keluhan (Anamnesa)</th>
                                <th>Status</th>
                                <th style="min-width: 110px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($rekams) > 0)
                                @foreach ($rekams as $key => $row)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $rekams->firstItem() + $key }}</td>
                                        <td style="vertical-align: middle;">
                                            <a href="{{Route('rekam.detail', $row->pasien_id)}}" class="font-w600 text-primary">
                                                {{ $row->pasien && $row->pasien->no_rm ? $row->pasien->no_rm : ($row->no_rekam ?? '-') }}
                                            </a>
                                            <br><small class="text-muted"><i class="fa fa-calendar-o mr-1"></i>{{$row->tgl_rekam}}</small>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <strong style="font-size: 13.5px; color: #1e293b;">
                                                <a href="{{Route('rekam.detail', $row->pasien_id)}}" class="text-primary">{{$row->pasien->nama ?? '-'}}</a>
                                            </strong>
                                            @if ($row->pasien && $row->pasien->jenis_disabilitas && $row->pasien->jenis_disabilitas != 'Tidak Ada')
                                                <br><span class="badge badge-info light font-w500 mt-1" style="font-size: 11px;">{{$row->pasien->jenis_disabilitas}}</span>
                                            @endif
                                            @if ($row->pasien && $row->pasien->nama_wali)
                                                <br><small class="text-muted"><i class="fa fa-user-circle-o mr-1"></i>Wali: {{$row->pasien->nama_wali}}</small>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <strong style="color: #334155;">{{$row->poli}}</strong>
                                            @if ($row->layanan_terapi)
                                                <br><span class="badge badge-primary light font-w600 mt-1" style="font-size: 11px;">{{$row->layanan_terapi}}</span>
                                            @endif
                                            <br><small class="text-muted"><i class="fa fa-user-md mr-1"></i>{{$row->dokter->nama ?? '-'}}</small>
                                        </td>
                                        <td style="vertical-align: middle; max-width: 260px;">
                                            <span style="font-size: 12.5px; line-height: 1.4; color: #475569;">
                                                {{$row->keluhan ?: '-'}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {!! $row->status_display() !!}
                                        </td>
                                        <td style="white-space: nowrap; vertical-align: middle;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="{{Route('rekam.detail', $row->pasien_id)}}" class="btn btn-primary shadow btn-xs sharp mr-1" title="Lihat Rekam Medis">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{Route('rekam.assessment', $row->id)}}" class="btn btn-warning shadow btn-xs sharp mr-1" title="Form Assessment Terapis">
                                                    <i class="fa fa-clipboard"></i>
                                                </a>
                                                @if (auth()->user()->role_display() == "Admin" && $row->status == 2)
                                                    <a href="{{Route('rekam.edit', $row->id)}}" class="btn btn-info shadow btn-xs sharp mr-1" title="Edit Data Rekam Medis">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp delete" r-link="{{Route('rekam.delete', $row->id)}}"
                                                       r-name="{{$row->pasien->nama ?? 'Rekam'}}" r-id="{{$row->id}}" title="Hapus Data">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <p class="mb-0 fs-13">Tidak ada data rekam medis yang sesuai.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="dataTables_info" id="example_info" role="status" aria-live="polite" style="font-size: 12.5px;">
                        Showing {{$rekams->firstItem() ?? 0}} to {{$rekams->firstItem() ? ($rekams->firstItem() + count($rekams) - 1) : 0}} of {{$rekams->total()}} entries
                    </div>
                    {{ $rekams->appends(request()->except('page'))->links() }}
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
                text: "Yakin ingin menghapus data: " + name + " ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus!'
            }).then((result) => {
                if (result.value) {
                    window.location = link;
                }
            });
        });
    });
</script>
@endsection

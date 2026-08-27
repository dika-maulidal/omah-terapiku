@extends('layout.apps')
@section('content')
<div class="mr-auto mb-3">
    <h2 class="text-black font-w600">Data Rekam Medis</h2>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group col-lg-6" style="float: left">
                    <a href="{{Route('rekam.add')}}" class="btn btn-primary mr-2">+Rekam Medis Baru</a>
                    <a href="{{Route('rekam.export-csv', ['keyword' => request('keyword'), 'status' => request('status', request('tab'))])}}" class="btn btn-success" title="Download data rekam medis ke CSV">
                        <i class="fa fa-file-excel-o mr-1"></i> Export CSV
                    </a>
                </div>
                <div class="form-group col-lg-6" style="float: right">
                    <form method="get" action="{{ url()->current() }}">
                        <div class="row">
                            <div class="col-sm-5 mb-2 mb-sm-0 pr-sm-1">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="" {{ request('status') == '' && request('tab') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="1" {{ request('status') == '1' || request('tab') == '1' ? 'selected' : '' }}>Antrian</option>
                                    <option value="2" {{ request('status') == '2' || request('tab') == '2' ? 'selected' : '' }}>Pemeriksaan</option>
                                    <option value="3" {{ request('status') == '3' || request('tab') == '3' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="5" {{ request('status') == '5' || request('tab') == '5' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-sm-7 pl-sm-1">
                                <div class="input-group">
                                    <input type="text" class="form-control gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari..." autocomplete="off">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default no-border btn-sm gp-search">
                                            <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive card-table"> 
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Nama Penerima Manfaat</th>
                                <th>Omah Terapiku &<br>Terapis</th>
                                <th>Keluhan</th>
                                <th>Status Layanan</th>
                                <th>Status</th>
                                <th style="min-width: 100px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekams as $key => $row)
                                <tr>
                                    <td>{{ $rekams->firstItem() + $key }}</td>
                                    <td>{{$row->no_rekam}}<br/>{{$row->tgl_rekam}}</td>
                                    <td><a href="{{Route('rekam.detail', $row->pasien_id)}}">{{$row->pasien->nama ?? '-'}}</a></td>
                                    <td>
                                        Omah Terapiku: {{$row->poli}}
                                        <br><strong>{{$row->dokter->nama ?? '-'}}</strong>
                                    </td>
                                    <td>{{$row->keluhan}}</td>
                                    <td>Gratis, tidak dipungut biaya</td>
                                    <td>{!!$row->status_display()!!}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{Route('rekam.detail', $row->pasien_id)}}" class="btn btn-primary shadow btn-xs sharp mr-1" title="Lihat Rekam Medis">
                                                <i class="fa fa-user-md"></i>
                                            </a>
                                            @if (auth()->user()->role_display() == "Admin" && $row->status == 2)
                                                <a href="{{Route('rekam.edit', $row->id)}}" class="btn btn-info shadow btn-xs sharp mr-1" title="Edit Data">
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
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Tidak ada data rekam medis yang sesuai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="dataTables_info" id="example_info" role="status" aria-live="polite">
                        Showing {{$rekams->firstItem() ?? 0}} to {{$rekams->perPage() * $rekams->currentPage()}} of {{$rekams->total()}} entries
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

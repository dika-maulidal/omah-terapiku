@extends('layout.apps')
@section('content')
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Data Penerima Manfaat</h2>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <!-- Tombol Aksi Kiri -->
                    <div class="col-md-6 col-12 mb-2 mb-md-0 d-flex align-items-center flex-wrap" style="gap: 6px;">
                        <a href="{{Route('penerima-manfaat.add')}}" class="btn btn-sm btn-primary" style="font-size: 13px; padding: 7px 14px; font-weight: 600;">
                            <i class="fa fa-user-plus mr-1"></i> + Penerima Manfaat Baru
                        </a>
                        <a href="{{Route('penerima-manfaat.export-csv', ['keyword' => request('keyword'), 'status' => request('status')])}}" class="btn btn-sm btn-success" style="font-size: 13px; padding: 7px 14px; font-weight: 600;" title="Download data penerima manfaat ke CSV">
                            <i class="fa fa-file-excel-o mr-1"></i> Export CSV
                        </a>
                    </div>

                    <!-- Filter Status & Pencarian Kanan -->
                    <div class="col-md-6 col-12">
                        <form method="get" action="{{ url()->current() }}">
                            <div class="d-flex align-items-center justify-content-md-end" style="gap: 6px;">
                                <!-- Dropdown Filter Status -->
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()" style="max-width: 155px; height: 36px; font-size: 12.5px;">
                                    <option value="">-- Semua Status --</option>
                                    <option value="sudah_periksa" {{ request('status') == 'sudah_periksa' ? 'selected' : '' }}>Sudah Periksa</option>
                                    <option value="pasien_baru" {{ request('status') == 'pasien_baru' ? 'selected' : '' }}>Pasien Baru</option>
                                    <option value="pasien_lama" {{ request('status') == 'pasien_lama' ? 'selected' : '' }}>Pasien Lama</option>
                                </select>

                                <!-- Kolom Pencarian -->
                                <div class="input-group" style="max-width: 230px;">
                                    <input type="text" class="form-control form-control-sm gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari..." autocomplete="off" style="height: 36px; font-size: 12.5px;">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary btn-sm no-border gp-search" style="height: 36px; padding: 0 12px;">
                                            <i class="ace-icon fa fa-search icon-on-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tombol Reset Filter -->
                                @if(request('keyword') || request('status'))
                                    <a href="{{ Route('penerima-manfaat') }}" class="btn btn-sm btn-light" style="height: 36px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px;" title="Reset Filter">
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
                                <th>No. RM</th>
                                <th>Nama Penerima Manfaat</th>
                                <th>TTL</th>
                                <th>Alamat</th>
                                <th>JK</th>
                                <th>Desil</th>
                                <th>No. HP</th>
                                <th>Status</th>
                                <th style="min-width: 125px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($datas) > 0)
                                @foreach ($datas as $key=>$row)
                                    <tr>
                                        <td style="vertical-align: middle;">{{$datas->firstItem() + $key}}</td>
                                        <td style="vertical-align: middle;"><a href="{{Route('rekam.detail',$row->id)}}" class="font-w600 text-primary">{{$row->no_rm}}</a></td>
                                        <td style="vertical-align: middle;">
                                            <strong style="font-size: 13.5px; color: #1e293b;">{{$row->nama}}</strong>
                                            @if ($row->jenis_disabilitas && $row->jenis_disabilitas != 'Tidak Ada')
                                                <br><span class="badge badge-info light font-w500 mt-1" style="font-size: 11px;">{{$row->jenis_disabilitas}}</span>
                                            @endif
                                            @if ($row->nama_wali)
                                                <br><small class="text-muted"><i class="fa fa-user-circle-o mr-1"></i>Wali: {{$row->nama_wali}}</small>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">{{$row->tmp_lahir}}, {{$row->tgl_lahir}}</td>
                                        <td style="vertical-align: middle;">{{$row->alamat_lengkap}}</td>
                                        <td style="vertical-align: middle;">{{$row->jk}}</td>
                                        <td style="vertical-align: middle;">
                                            @if ($row->desil)
                                                <span class="badge badge-primary light font-w600" style="font-size: 11px;">{{$row->desil}}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">{{$row->no_hp}}</td>
                                        <td style="vertical-align: middle;">
                                            {!! $row->statusPasien() !!}
                                        </td>
                                        <td style="white-space: nowrap; vertical-align: middle;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="{{Route('rekam.detail',$row->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1" title="Lihat Rekam Medis">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{Route('penerima-manfaat.edit',$row->id)}}" class="btn btn-info shadow btn-xs sharp mr-1" title="Edit Data Pasien">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger shadow btn-xs sharp delete" r-link="{{Route('penerima-manfaat.delete',$row->id)}}"
                                                    r-name="{{$row->nama}}" r-id="{{$row->id}}" title="Hapus Data Pasien">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">
                                        <p class="mb-0 fs-13">Tidak ada data penerima manfaat yang sesuai.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        
                    </table>
                    <div class="dataTables_info" id="example_info" role="status"
                    aria-live="polite" style="font-size: 12.5px;">Showing {{$datas->firstItem() ?: 0}} to {{$datas->perPage() * $datas->currentPage()}} of {{$datas->total()}} entries</div>
                   {{ $datas->appends(request()->except('page'))->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
        $().ready( function () {
            $(".delete").click(function() {
                 var id = $(this).attr('r-id');
                 var name = $(this).attr('r-name');
                 var link = $(this).attr('r-link');
                 Swal.fire({
                  title: 'Ingin Menghapus?',
                  text: "Yakin ingin menghapus data  : "+name+" ini ?" ,
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, hapus !'
                }).then((result) => {
                  console.log(result);
                  if (result.value) {
                      window.location = link;
                  }
                });
            });
        } );
    </script>
@endsection
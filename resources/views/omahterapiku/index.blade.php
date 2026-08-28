@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Data Omah Terapiku</h2>
</div>

<!-- Modal Tambah Omah Terapiku -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                    <i class="fa fa-hospital-o text-primary mr-2"></i> Tambah Omah Terapiku Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{Route('omahterapiku.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Nama Omah Terapiku <span class="text-danger">*</span></label>
                        <input type="text" name="nama" required class="form-control" placeholder="Contoh: Omah Terapiku Surabaya" style="height: 40px; font-size: 13px;">
                        @error('nama')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Alamat Lokasi</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat jalan, gedung / UPT..." style="font-size: 13px;"></textarea>
                        @error('alamat')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" style="padding: 8px 16px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 20px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                            <i class="fa fa-save mr-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-body">
                <!-- Toolbar: Tombol Tambah & Pencarian -->
                <div class="row mb-3 align-items-center">
                    <!-- Tombol Tambah Kiri -->
                    <div class="col-md-6 col-12 mb-2 mb-md-0 d-flex align-items-center flex-wrap" style="gap: 6px;">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addOrderModal" style="font-size: 13px; padding: 7px 14px; font-weight: 600;">
                            <i class="fa fa-plus mr-1"></i> + Tambah Omah Terapiku
                        </a>
                    </div>

                    <!-- Pencarian Kanan -->
                    <div class="col-md-6 col-12">
                        <form method="get" action="{{ url()->current() }}">
                            <div class="d-flex align-items-center justify-content-md-end" style="gap: 6px;">
                                <div class="input-group" style="max-width: 280px;">
                                    <input type="text" class="form-control form-control-sm gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari nama / alamat..." autocomplete="off" style="height: 36px; font-size: 12.5px;">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary btn-sm no-border gp-search" style="height: 36px; padding: 0 12px;">
                                            <i class="ace-icon fa fa-search icon-on-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tombol Reset Filter -->
                                @if(request('keyword'))
                                    <a href="{{ Route('omahterapiku') }}" class="btn btn-sm btn-light" style="height: 36px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #e2e8f0;" title="Reset Filter">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Data Omah Terapiku -->
                <div class="table-responsive card-table"> 
                    <table class="table table-responsive-md" style="font-size: 13px;">
                        <thead>
                            <tr style="font-size: 12.5px;">
                                <th style="width: 6%;">#</th>
                                <th style="width: 35%;">Nama Omah Terapiku</th>
                                <th style="width: 35%;">Alamat Lokasi</th>
                                <th style="width: 12%; text-align: center;">Status</th>
                                <th style="min-width: 100px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($datas) > 0)
                                @foreach ($datas as $key => $row)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $datas->firstItem() + $key }}</td>
                                        <td style="vertical-align: middle;">
                                            <strong style="font-size: 13.5px; color: #1e293b;">
                                                <i class="fa fa-hospital-o text-primary mr-1"></i> {{$row->nama}}
                                            </strong>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span style="color: #475569; font-size: 12.5px;">{{$row->alamat ?: '-'}}</span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            @if($row->status == 1)
                                                <span class="badge badge-success light font-w600" style="font-size: 11px;">
                                                    <i class="fa fa-check-circle mr-1"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge badge-danger light font-w600" style="font-size: 11px;">
                                                    <i class="fa fa-times-circle mr-1"></i> Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td style="white-space: nowrap; vertical-align: middle;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#editPoli{{$row->id}}" class="btn btn-info shadow btn-xs sharp mr-1" title="Edit Omah Terapiku">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger shadow btn-xs sharp delete" r-link="{{Route('omahterapiku.delete',$row->id)}}"
                                                   r-name="{{$row->nama}}" r-id="{{$row->id}}" title="Hapus Omah Terapiku">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>

                                            <!-- Modal Edit Omah Terapiku -->
                                            <div class="modal fade" id="editPoli{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                                            <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                                                                <i class="fa fa-pencil-square-o text-primary mr-2"></i> Edit Omah Terapiku
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body p-4 text-left">
                                                            <form action="{{Route('omahterapiku.update',$row->id)}}" method="POST">
                                                                {{ csrf_field() }}
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Nama Omah Terapiku <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nama" value="{{$row->nama}}" required class="form-control" style="height: 40px; font-size: 13px;">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Alamat Lokasi</label>
                                                                    <textarea name="alamat" class="form-control" rows="3" style="font-size: 13px;">{{$row->alamat}}</textarea>
                                                                </div>
                                                                <div class="form-group mb-4">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Status Operasional</label>
                                                                    <select name="status" class="form-control" style="height: 40px; font-size: 13px;">
                                                                        <option value="1" {{ $row->status == 1 ? 'selected' : '' }}>Aktif</option>
                                                                        <option value="0" {{ $row->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="d-flex align-items-center justify-content-end" style="gap: 8px;">
                                                                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" style="padding: 8px 16px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 20px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                                                        <i class="fa fa-save mr-1"></i> Update Data
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <p class="mb-0 fs-13">Tidak ada data Omah Terapiku yang sesuai.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="dataTables_info" id="example_info" role="status" aria-live="polite" style="font-size: 12.5px;">
                        Showing {{$datas->firstItem() ?? 0}} to {{$datas->firstItem() ? ($datas->firstItem() + count($datas) - 1) : 0}} of {{$datas->total()}} entries
                    </div>
                    {{ $datas->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $().ready(function () {
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

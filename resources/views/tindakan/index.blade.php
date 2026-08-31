@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Data Tindakan Terapi</h2>
    <p class="text-muted mb-0">Kelola master data tindakan, jenis layanan terapi, dan tarif di Omah Terapiku</p>
</div>

<!-- Modal Tambah Tindakan Baru -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                    <i class="fa fa-stethoscope text-primary mr-2"></i> Tambah Tindakan Terapi Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{Route('tindakan.store')}}" method="POST">
                    {{ csrf_field() }}
                    
                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Kode Tindakan <span class="text-danger">*</span></label>
                        <input type="text" name="kode" required class="form-control" value="{{ old('kode') }}" placeholder="Contoh: TDK01, OKP01, WCR01" style="height: 40px; font-size: 13px;">
                        @error('kode')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Nama Tindakan Terapi <span class="text-danger">*</span></label>
                        <input type="text" name="nama" required class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Terapi Wicara Motorik Anak" style="height: 40px; font-size: 13px;">
                        @error('nama')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Tarif / Biaya Tindakan (Rp)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-w600" style="font-size: 12.5px; background: #f1f5f9; color: #475569;">Rp</span>
                            </div>
                            <input type="number" name="harga" value="{{ old('harga', 0) }}" min="0" class="form-control" placeholder="0 jika gratis / layanan Dinas Sosial" style="height: 40px; font-size: 13px;">
                        </div>
                        <small class="text-muted">Isi 0 jika merupakan layanan fasilitas gratis penerima manfaat.</small>
                        @error('harga')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Lokasi Omah Terapiku <span class="text-danger">*</span></label>
                        <select name="poli" class="form-control" required style="height: 40px; font-size: 13px;">
                            <option value="">-- Pilih Omah Terapiku --</option>
                            @foreach ($poli as $item)
                                <option value="{{$item->nama}}" {{ old('poli') == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                            @endforeach
                        </select>
                        @error('poli')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-end" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" style="padding: 8px 16px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 20px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                            <i class="fa fa-save mr-1"></i> Simpan Tindakan
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
                <!-- Toolbar: Tombol Tambah & Pencarian / Filter -->
                <div class="row mb-3 align-items-center">
                    <!-- Tombol Tambah Kiri -->
                    <div class="col-md-5 col-12 mb-2 mb-md-0 d-flex align-items-center flex-wrap" style="gap: 6px;">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addOrderModal" style="font-size: 13px; padding: 7px 14px; font-weight: 600;">
                            <i class="fa fa-plus mr-1"></i> Tambah Tindakan
                        </a>
                    </div>

                    <!-- Filter Omah Terapiku & Pencarian Kanan -->
                    <div class="col-md-7 col-12">
                        <form method="get" action="{{ url()->current() }}">
                            <div class="d-flex align-items-center justify-content-md-end flex-wrap" style="gap: 6px;">
                                <!-- Dropdown Filter Omah Terapiku -->
                                <select name="poli" class="form-control form-control-sm" onchange="this.form.submit()" style="max-width: 175px; height: 36px; font-size: 12.5px;">
                                    <option value="">-- Semua Lokasi --</option>
                                    @foreach ($poli as $item)
                                        <option value="{{$item->nama}}" {{ request('poli') == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                                    @endforeach
                                </select>

                                <!-- Input Pencarian -->
                                <div class="input-group" style="max-width: 240px;">
                                    <input type="text" class="form-control form-control-sm gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari kode / nama tindakan..." autocomplete="off" style="height: 36px; font-size: 12.5px;">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary btn-sm no-border gp-search" style="height: 36px; padding: 0 12px;">
                                            <i class="ace-icon fa fa-search icon-on-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tombol Reset Filter -->
                                @if(request('keyword') || request('poli'))
                                    <a href="{{ Route('tindakan') }}" class="btn btn-sm btn-light" style="height: 36px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #e2e8f0;" title="Reset Filter">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Data Tindakan -->
                <div class="table-responsive card-table">
                    <table class="table table-responsive-md" style="font-size: 13px;">
                        <thead>
                            <tr style="font-size: 12.5px;">
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Kode Tindakan</th>
                                <th style="width: 35%;">Nama Tindakan Terapi</th>
                                <th style="width: 18%;">Tarif / Biaya</th>
                                <th style="width: 17%;">Omah Terapiku</th>
                                <th style="min-width: 100px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($datas) > 0)
                                @foreach ($datas as $key => $row)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $datas->firstItem() + $key }}</td>
                                        <td style="vertical-align: middle;">
                                            <span class="badge badge-primary light font-w700" style="font-size: 11.5px; letter-spacing: 0.4px;">
                                                {{$row->kode}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <strong style="font-size: 13.5px; color: #1e293b;">
                                                <i class="fa fa-stethoscope text-primary mr-1"></i> {{$row->nama}}
                                            </strong>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if($row->harga > 0)
                                                <span class="font-w700" style="color: #2e7d32; font-size: 13px;">
                                                    Rp {{number_format($row->harga, 0, ',', '.')}}
                                                </span>
                                            @else
                                                <span class="badge badge-success light font-w600" style="font-size: 11px;">
                                                    <i class="fa fa-check-circle mr-1"></i> Gratis / Dinsos
                                                </span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span class="badge badge-light text-dark font-w600" style="font-size: 11.5px; border: 1px solid #e2e8f0; background: #fff;">
                                                <i class="fa fa-hospital-o text-primary mr-1"></i> {{$row->poli ?: '-'}}
                                            </span>
                                        </td>
                                        <td style="white-space: nowrap; vertical-align: middle;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#edit{{$row->id}}" class="btn btn-info shadow btn-xs sharp mr-1" title="Edit Tindakan">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger shadow btn-xs sharp delete" r-link="{{Route('tindakan.delete',$row->id)}}"
                                                   r-name="{{$row->nama}}" r-id="{{$row->id}}" title="Hapus Tindakan">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>

                                            <!-- Modal Edit Tindakan -->
                                            <div class="modal fade" id="edit{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                                            <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                                                                <i class="fa fa-pencil-square-o text-primary mr-2"></i> Edit Tindakan Terapi
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body p-4 text-left">
                                                            <form action="{{Route('master.tindakan.update',$row->id)}}" method="POST">
                                                                {{ csrf_field() }}
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Kode Tindakan <span class="text-danger">*</span></label>
                                                                    <input type="text" name="kode" value="{{$row->kode}}" required class="form-control" style="height: 40px; font-size: 13px;">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Nama Tindakan Terapi <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nama" value="{{$row->nama}}" required class="form-control" style="height: 40px; font-size: 13px;">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Tarif / Biaya (Rp)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text font-w600" style="font-size: 12.5px; background: #f1f5f9; color: #475569;">Rp</span>
                                                                        </div>
                                                                        <input type="number" name="harga" value="{{$row->harga}}" min="0" required class="form-control" style="height: 40px; font-size: 13px;">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-4">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Lokasi Omah Terapiku <span class="text-danger">*</span></label>
                                                                    <select name="poli" class="form-control" required style="height: 40px; font-size: 13px;">
                                                                        @foreach ($poli as $item)
                                                                            <option value="{{$item->nama}}" {{ $item->nama == $row->poli ? 'selected' : '' }}>{{$item->nama}}</option>
                                                                        @endforeach
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
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <p class="mb-0 fs-13">Tidak ada data tindakan yang sesuai.</p>
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
    $(document).ready(function () {
        $(".delete").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');

            Swal.fire({
                title: 'Ingin Menghapus?',
                text: "Yakin ingin menghapus tindakan: " + name + " ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
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

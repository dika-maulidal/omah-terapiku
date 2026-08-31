@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Data Petugas & Pengguna Sistem</h2>
    <p class="text-muted mb-0">Kelola akun Admin dan Petugas Pendaftaran untuk akses sistem Omah Terapiku</p>
</div>

<!-- Modal Tambah Petugas Baru -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                    <i class="fa fa-user-plus text-primary mr-2"></i> Tambah Petugas Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{Route('petugas.store')}}" method="POST">
                    {{ csrf_field() }}
                   
                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Nama Petugas / Pengguna <span class="text-danger">*</span></label>
                        <input type="text" name="name" required class="form-control" value="{{ old('name') }}" placeholder="Contoh: Siti Rahmawati" style="height: 40px; font-size: 13px;">
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">NIP / Username (Login)</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="Contoh: 198501012010012001 atau sitir" style="height: 40px; font-size: 13px;">
                        <small class="text-muted">Dapat digunakan sebagai identitas login masuk ke aplikasi.</small>
                        @error('nip')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">No. HP / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" style="height: 40px; font-size: 13px;">
                        @error('phone')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Password Login <span class="text-danger">*</span></label>
                        <input type="password" name="password" required class="form-control" placeholder="Minimal 4 karakter" style="height: 40px; font-size: 13px;">
                        @error('password')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-w600 text-black mb-1" style="font-size: 13px;">Role Akses <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" required style="height: 40px; font-size: 13px;">
                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin (Akses Penuh Master Data & Laporan)</option>
                            <option value="2" {{ old('role') == '2' || old('role') === null ? 'selected' : '' }}>Pendaftaran (Akses Penerima Manfaat & Pendaftaran Rekam)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-end" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" style="padding: 8px 16px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 20px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                            <i class="fa fa-save mr-1"></i> Simpan Petugas
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
                            <i class="fa fa-plus mr-1"></i> Tambah Petugas
                        </a>
                    </div>

                    <!-- Filter Role & Pencarian Kanan -->
                    <div class="col-md-7 col-12">
                        <form method="get" action="{{ url()->current() }}">
                            <div class="d-flex align-items-center justify-content-md-end flex-wrap" style="gap: 6px;">
                                <!-- Dropdown Filter Role -->
                                <select name="role" class="form-control form-control-sm" onchange="this.form.submit()" style="max-width: 165px; height: 36px; font-size: 12.5px;">
                                    <option value="">-- Semua Role --</option>
                                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Pendaftaran</option>
                                </select>

                                <!-- Input Pencarian -->
                                <div class="input-group" style="max-width: 240px;">
                                    <input type="text" class="form-control form-control-sm gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari nama, NIP, atau HP..." autocomplete="off" style="height: 36px; font-size: 12.5px;">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary btn-sm no-border gp-search" style="height: 36px; padding: 0 12px;">
                                            <i class="ace-icon fa fa-search icon-on-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tombol Reset Filter -->
                                @if(request('keyword') || request('role'))
                                    <a href="{{ Route('petugas') }}" class="btn btn-sm btn-light" style="height: 36px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid #e2e8f0;" title="Reset Filter">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Data Petugas -->
                <div class="table-responsive card-table">
                    <table class="table table-responsive-md" style="font-size: 13px;">
                        <thead>
                            <tr style="font-size: 12.5px;">
                                <th style="width: 5%;">#</th>
                                <th style="width: 28%;">Nama Petugas</th>
                                <th style="width: 18%;">NIP / Username</th>
                                <th style="width: 17%;">No. HP / WhatsApp</th>
                                <th style="width: 14%;">Role Akses</th>
                                <th style="width: 8%; text-align: center;">Status</th>
                                <th style="min-width: 100px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($datas) > 0)
                                @foreach ($datas as $key => $row)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $datas->firstItem() + $key }}</td>
                                        <td style="vertical-align: middle;">
                                            <div class="font-w700 text-black" style="font-size: 13.5px; color: #1e293b;">
                                                <i class="fa fa-user-circle-o text-primary mr-1"></i> {{$row->name}}
                                            </div>
                                            @if($row->email && !str_contains($row->email, '@omah-terapiku.local'))
                                                <small class="text-muted" style="font-size: 11.5px;">{{$row->email}}</small>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span class="badge badge-light text-dark font-w600" style="font-size: 11.5px; border: 1px solid #e2e8f0; background: #fff;">
                                                {{$row->nip ?: '-'}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span style="color: #475569; font-size: 12.5px;">{{$row->phone ?: '-'}}</span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if($row->role == 1)
                                                <span class="badge badge-primary light font-w600" style="font-size: 11.5px;">
                                                    <i class="fa fa-shield mr-1"></i> Admin
                                                </span>
                                            @elseif($row->role == 2)
                                                <span class="badge badge-info light font-w600" style="font-size: 11.5px;">
                                                    <i class="fa fa-user-edit mr-1"></i> Pendaftaran
                                                </span>
                                            @else
                                                <span class="badge badge-secondary light font-w600" style="font-size: 11.5px;">
                                                    {{$row->role_display()}}
                                                </span>
                                            @endif
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
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#key{{$row->id}}" 
                                                    class="btn btn-warning shadow btn-xs sharp mr-1" title="Ganti Password">
                                                    <i class="fa fa-key"></i>
                                                </a>

                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#edit{{$row->id}}" 
                                                    class="btn btn-info shadow btn-xs sharp mr-1" title="Edit Petugas">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                @if(auth()->id() != $row->id)
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp delete" r-link="{{Route('petugas.delete',$row->id)}}"
                                                       r-name="{{$row->name}}" r-id="{{$row->id}}" title="Hapus Petugas">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            <!-- Modal Ganti Password -->
                                            <div class="modal fade" id="key{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #fff8e7; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                                            <h5 class="modal-title font-w700" style="color: #b7791f !important; font-size: 16px;">
                                                                <i class="fa fa-key text-warning mr-2"></i> Ganti Password - {{$row->name}}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body p-4 text-left">
                                                            <form action="{{Route('gantipassword',$row->id)}}" method="POST">
                                                                {{ csrf_field() }}
                                                               
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Password Baru <span class="text-danger">*</span></label>
                                                                    <input type="password" name="password" required class="form-control" placeholder="Minimal 6 karakter" style="height: 40px; font-size: 13px;">
                                                                    @error('password')
                                                                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group mb-4">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                                                    <input type="password" name="password_konfirm" required class="form-control" placeholder="Ulangi password baru" style="height: 40px; font-size: 13px;">
                                                                    @error('password_konfirm')
                                                                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                                                    @enderror
                                                                </div>
                                                                
                                                                <div class="d-flex align-items-center justify-content-end" style="gap: 8px;">
                                                                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" style="padding: 8px 16px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-warning" style="padding: 8px 20px; font-size: 13px; font-weight: 600; border-radius: 6px; color: #fff;">
                                                                        <i class="fa fa-key mr-1"></i> Update Password
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit Petugas -->
                                            <div class="modal fade" id="edit{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                        <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                                            <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                                                                <i class="fa fa-pencil-square-o text-primary mr-2"></i> Edit Data Petugas
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body p-4 text-left">
                                                            <form action="{{Route('petugas.update',$row->id)}}" method="POST">
                                                                {{ csrf_field() }}
                                                               
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Nama Petugas / Pengguna <span class="text-danger">*</span></label>
                                                                    <input type="text" name="name" value="{{$row->name}}" required class="form-control" style="height: 40px; font-size: 13px;">
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">NIP / Username (Login)</label>
                                                                    <input type="text" name="nip" value="{{$row->nip}}" class="form-control" style="height: 40px; font-size: 13px;">
                                                                </div>
                                                                
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">No. HP / WhatsApp</label>
                                                                    <input type="text" name="phone" class="form-control" value="{{$row->phone}}" style="height: 40px; font-size: 13px;">
                                                                </div>
                                                               
                                                                <div class="form-group mb-3">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Role Akses <span class="text-danger">*</span></label>
                                                                    <select name="role" class="form-control" required style="height: 40px; font-size: 13px;">
                                                                        <option value="1" {{$row->role == 1 ? 'selected' : ''}}>Admin (Akses Penuh Master Data & Laporan)</option>
                                                                        <option value="2" {{$row->role == 2 ? 'selected' : ''}}>Pendaftaran (Akses Penerima Manfaat & Pendaftaran Rekam)</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group mb-4">
                                                                    <label class="font-w600 text-black mb-1" style="font-size: 13px;">Password Baru (Opsional)</label>
                                                                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password" style="height: 40px; font-size: 13px;">
                                                                    <small class="text-muted">Isi hanya jika ingin memperbarui kata sandi akun ini.</small>
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
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <p class="mb-0 fs-13">Tidak ada data petugas yang sesuai.</p>
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
                text: "Yakin ingin menghapus data petugas: " + name + " ?",
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


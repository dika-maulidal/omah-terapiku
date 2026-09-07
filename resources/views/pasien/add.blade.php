@extends('layout.apps')
@section('content')

<!-- Header Section (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Tambah Penerima Manfaat</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{Route('penerima-manfaat')}}" style="color: #2563eb;">Data Penerima Manfaat</a></li>
                        <li class="breadcrumb-item active text-muted">Tambah Baru</li>
                    </ol>
                </div>
            </div>
            <div>
                <a href="{{Route('penerima-manfaat')}}" class="btn btn-sm btn-light font-w600" style="border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; padding: 7px 14px;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                <div class="basic-form">
                    <form action="{{Route('penerima-manfaat.store')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <!-- BAGIAN 1: IDENTITAS UTAMA -->
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 15px;">
                                <i class="fa-solid fa-id-card mr-2" style="color: #2563eb;"></i> Identitas Penerima Manfaat
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">No. Rekam Medis</label>
                                <div class="d-flex align-items-center" style="height: 42px; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 0 12px;">
                                    <i class="fa-solid fa-id-card mr-2" style="color: #2563eb; font-size: 15px;"></i>
                                    <input type="text" class="font-w700" name="no_rm" readonly value="{{ $autoNoRm ?? 'OTK-' . date('y') . '-XXXXX' }}" style="background: transparent; border: none; outline: none; box-shadow: none; color: #1e40af; font-size: 13.5px; width: 100%; letter-spacing: 0.5px; padding: 0;">
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa-solid fa-wand-magic-sparkles mr-1" style="color: #2563eb;"></i>Nomor RM ter-generate otomatis (OTK-{{ date('y') }}-XXXXX)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" class="form-control" name="nik" maxlength="16" id="nik" placeholder="Masukkan 16 digit NIK jika ada" value="{{old('nik')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('nik')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Nama Penerima Manfaat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="nama" required placeholder="Nama lengkap penerima manfaat" value="{{old('nama')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('nama')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Tempat Lahir</label>
                                <input type="text" class="form-control" name="tmp_lahir" placeholder="Kota/Kabupaten kelahiran" value="{{old('tmp_lahir')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('tmp_lahir')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tgl_lahir" value="{{old('tgl_lahir')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('tgl_lahir')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark d-block" style="font-size: 13px; margin-bottom: 6px;">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center" style="gap: 20px; height: 42px;">
                                    <div class="form-check mb-0">
                                        <input type="radio" name="jk" id="jk_l" class="form-check-input" value="Laki-Laki" {{ old('jk') == 'Laki-Laki' ? 'checked' : '' }} required>
                                        <label class="form-check-label font-w500" for="jk_l" style="font-size: 13px; cursor: pointer;">Laki-Laki</label>     
                                    </div>
                                    <div class="form-check mb-0">
                                        <input type="radio" name="jk" id="jk_p" class="form-check-input" value="Perempuan" {{ old('jk') == 'Perempuan' ? 'checked' : '' }}>
                                        <label class="form-check-label font-w500" for="jk_p" style="font-size: 13px; cursor: pointer;">Perempuan</label>   
                                    </div>
                                </div>
                                @error('jk')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Status Pernikahan</label>
                                <select name="status_menikah" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                    <option value="">--Pilih Status Menikah--</option>
                                    <option value="Belum Menikah" {{ old('status_menikah') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="Menikah" {{ old('status_menikah') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="Duda" {{ old('status_menikah') == 'Duda' ? 'selected' : '' }}>Duda</option>
                                    <option value="Janda" {{ old('status_menikah') == 'Janda' ? 'selected' : '' }}>Janda</option>
                                </select>
                                @error('status_menikah')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Agama</label>
                                <select name="agama" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                    <option value="">--Pilih Agama--</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katholik" {{ old('agama') == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Pendidikan Terakhir</label>
                                <select name="pendidikan" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                    <option value="">--Pilih Pendidikan--</option>
                                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="Diploma" {{ old('pendidikan') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                                    <option value="Tidak Sekolah" {{ old('pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                </select>
                                @error('pendidikan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Pekerjaan</label>
                                <select name="pekerjaan" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                    <option value="">--Pilih Pekerjaan--</option>
                                    <option value="PNS" {{ old('pekerjaan') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="Wiraswasta" {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="TNI/Polri" {{ old('pekerjaan') == 'TNI/Polri' ? 'selected' : '' }}>TNI/Polri</option>
                                    <option value="Pelajar/Mahasiswa" {{ old('pekerjaan') == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                                    <option value="Petani" {{ old('pekerjaan') == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Guru/Pengajar" {{ old('pekerjaan') == 'Guru/Pengajar' ? 'selected' : '' }}>Guru/Pengajar</option>
                                    <option value="IRT" {{ old('pekerjaan') == 'IRT' ? 'selected' : '' }}>IRT</option>
                                    <option value="Lain-Lain" {{ old('pekerjaan') == 'Lain-Lain' ? 'selected' : '' }}>Lain-Lain</option>
                                </select>
                                @error('pekerjaan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 2: KONTAK & ALAMAT DOMISILI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 15px;">
                                <i class="fa-solid fa-location-dot mr-2" style="color: #2563eb;"></i> Kontak & Alamat Domisili
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">No. HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_hp" required placeholder="Contoh: 081234567890" value="{{old('no_hp')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('no_hp')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">No. BPJS / KIS</label>
                                <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" placeholder="Nomor kartu BPJS jika ada" value="{{old('no_bpjs')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('no_bpjs')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <!-- DROPDOWN WILAYAH BERJENJANG (SELECT2 SEARCHABLE & KE BAWAH) -->
                            <div class="col-12" id="wrapper_wilayah_api">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                        <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between" style="font-size: 13px; margin-bottom: 6px;">
                                            <span>Provinsi</span>
                                            <span id="loading_provinsi" class="text-primary fs-11 d-none"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                        </label>
                                        <select id="select_provinsi" class="form-control select2-wilayah" style="width: 100%;">
                                            <option value="">-- Memuat Provinsi... --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                        <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between" style="font-size: 13px; margin-bottom: 6px;">
                                            <span>Kabupaten / Kota</span>
                                            <span id="loading_kabupaten" class="text-primary fs-11 d-none"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                        </label>
                                        <select id="select_kabupaten" name="kabupaten" class="form-control select2-wilayah" style="width: 100%;" disabled>
                                            <option value="">-- Pilih Kabupaten / Kota --</option>
                                        </select>
                                        @error('kabupaten')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                        <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between" style="font-size: 13px; margin-bottom: 6px;">
                                            <span>Kecamatan</span>
                                            <span id="loading_kecamatan" class="text-primary fs-11 d-none"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                        </label>
                                        <select id="select_kecamatan" name="kecamatan" class="form-control select2-wilayah" style="width: 100%;" disabled>
                                            <option value="">-- Pilih Kab/Kota Dahulu --</option>
                                        </select>
                                        @error('kecamatan')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 col-sm-6 mb-3 col-wilayah">
                                        <label class="form-label font-w600 text-dark d-flex align-items-center justify-content-between" style="font-size: 13px; margin-bottom: 6px;">
                                            <span>Kelurahan / Desa</span>
                                            <span id="loading_kelurahan" class="text-primary fs-11 d-none"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memuat...</span>
                                        </label>
                                        <select id="select_kelurahan" name="kelurahan" class="form-control select2-wilayah" style="width: 100%;" disabled>
                                            <option value="">-- Pilih Kecamatan Dahulu --</option>
                                        </select>
                                        @error('kelurahan')
                                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Kode Pos</label>
                                <input type="number" maxlength="5" class="form-control" name="kodepos" placeholder="Contoh: 61219" value="{{old('kodepos')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('kodepos')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-9 col-sm-12 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Alamat jalan, RT/RW, Dusun, Blok, dll." style="font-size: 13px; border-radius: 8px;">{{old('alamat_lengkap')}}</textarea>
                                @error('alamat_lengkap')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 3: DATA SOSIAL, DISABILITAS, UPT & WALI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 15px;">
                                <i class="fa-solid fa-wheelchair mr-2" style="color: #2563eb;"></i> Data Sosial, Disabilitas, UPT & Wali
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Desil (DTKS / P3KE)</label>
                                <select name="desil" class="form-control" id="desil" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                    <option value="">--Pilih Tingkat Desil Sosial--</option>
                                    <option value="Desil 1" {{ old('desil') == 'Desil 1' ? 'selected' : '' }}>Desil 1 (Sangat Miskin / Ekstrem)</option>
                                    <option value="Desil 2" {{ old('desil') == 'Desil 2' ? 'selected' : '' }}>Desil 2 (Miskin)</option>
                                    <option value="Desil 3" {{ old('desil') == 'Desil 3' ? 'selected' : '' }}>Desil 3 (Hampir Miskin)</option>
                                    <option value="Desil 4" {{ old('desil') == 'Desil 4' ? 'selected' : '' }}>Desil 4 (Rentan Miskin)</option>
                                    <option value="Desil 5" {{ old('desil') == 'Desil 5' ? 'selected' : '' }}>Desil 5 (Menengah Bawah)</option>
                                    <option value="Desil 6" {{ old('desil') == 'Desil 6' ? 'selected' : '' }}>Desil 6</option>
                                    <option value="Desil 7" {{ old('desil') == 'Desil 7' ? 'selected' : '' }}>Desil 7</option>
                                    <option value="Desil 8" {{ old('desil') == 'Desil 8' ? 'selected' : '' }}>Desil 8</option>
                                    <option value="Desil 9" {{ old('desil') == 'Desil 9' ? 'selected' : '' }}>Desil 9</option>
                                    <option value="Desil 10" {{ old('desil') == 'Desil 10' ? 'selected' : '' }}>Desil 10</option>
                                    <option value="Non-Desil" {{ old('desil') == 'Non-Desil' ? 'selected' : '' }}>Non-Desil / Belum Terdata</option>
                                </select>
                                <div id="desilBadge" class="mt-2 d-none"></div>
                                @error('desil')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">UPT Lokasi Domisili</label>
                                <select name="upt_lokasi" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                    @php $currentUpt = old('upt_lokasi', session('selected_upt', 'UPT PPSAB Sidoarjo')); @endphp
                                    @if(isset($polis) && count($polis) > 0)
                                        @foreach($polis as $p)
                                            <option value="{{ $p->nama }}" {{ $currentUpt == $p->nama ? 'selected' : '' }}>{{ $p->nama }}</option>
                                        @endforeach
                                    @else
                                        <option value="UPT PPSAB Sidoarjo" {{ $currentUpt == 'UPT PPSAB Sidoarjo' ? 'selected' : '' }}>UPT PPSAB Sidoarjo</option>
                                        <option value="Balai RS PMKS Sidoarjo" {{ $currentUpt == 'Balai RS PMKS Sidoarjo' ? 'selected' : '' }}>Balai RS PMKS Sidoarjo</option>
                                        <option value="UPT RSBN Malang" {{ $currentUpt == 'UPT RSBN Malang' ? 'selected' : '' }}>UPT RSBN Malang</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Verifikasi DTKS</label>
                                <a href="https://cekbansos.kemensos.go.id/" target="_blank" rel="noopener noreferrer" 
                                   class="btn btn-block d-flex align-items-center justify-content-center font-w600" 
                                   style="height: 42px; font-size: 12.5px; border: 1px dashed #bfdbfe; color: #2563eb; background: #eff6ff; border-radius: 8px;"
                                   title="Buka portal Cek Bansos Kemensos RI">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Cek di Kemensos
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Nama Wali / Orang Tua</label>
                                <input type="text" class="form-control" name="nama_wali" placeholder="Nama lengkap wali / orang tua" value="{{old('nama_wali')}}" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                @error('nama_wali')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Hubungan dengan Pasien</label>
                                <select name="hubungan_wali" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px;">
                                    <option value="">--Pilih Hubungan--</option>
                                    <option value="Orang Tua Kandung" {{ old('hubungan_wali') == 'Orang Tua Kandung' ? 'selected' : '' }}>Orang Tua Kandung</option>
                                    <option value="Wali" {{ old('hubungan_wali') == 'Wali' ? 'selected' : '' }}>Wali</option>
                                    <option value="Pengasuh UPT" {{ old('hubungan_wali') == 'Pengasuh UPT' ? 'selected' : '' }}>Pengasuh UPT</option>
                                    <option value="Keluarga / Kerabat" {{ old('hubungan_wali') == 'Keluarga / Kerabat' ? 'selected' : '' }}>Keluarga / Kerabat</option>
                                    <option value="Lainnya" {{ old('hubungan_wali') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('hubungan_wali')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label font-w600 text-dark d-block" style="font-size: 13px; margin-bottom: 8px;">
                                    Ragam Disabilitas <small class="text-muted font-w400">(Dapat dipilih lebih dari satu)</small>
                                </label>
                                @php
                                    $oldDis = (array) old('jenis_disabilitas', []);
                                    $disOpts = ['Fisik', 'Intelektual', 'Mental', 'Sensorik Netra', 'Sensorik Rungu/Wicara', 'Ganda', 'Lainnya'];
                                @endphp
                                <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @foreach($disOpts as $disOpt)
                                        <label class="check-pill-card {{ in_array($disOpt, $oldDis) ? 'active' : '' }}" style="padding: 7px 16px; font-size: 12.5px; border-radius: 8px;">
                                            <input type="checkbox" name="jenis_disabilitas[]" value="{{ $disOpt }}" {{ in_array($disOpt, $oldDis) ? 'checked' : '' }}>
                                            <span>{{ $disOpt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrapper_disabilitas_lainnya" class="mt-2 {{ in_array('Lainnya', $oldDis) ? '' : 'd-none' }}" style="max-width: 480px;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-w600 text-primary" style="font-size: 12px;">Sebutkan Disabilitas Lainnya:</span>
                                        </div>
                                        <input type="text" class="form-control" name="jenis_disabilitas_lainnya" id="input_disabilitas_lainnya" placeholder="Tuliskan ragam disabilitas..." value="{{ old('jenis_disabilitas_lainnya') }}" style="height: 38px; font-size: 12.5px;">
                                    </div>
                                </div>
                                @error('jenis_disabilitas')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label font-w600 text-dark d-block" style="font-size: 13px; margin-bottom: 8px;">
                                    Alat Bantu Mobilitas <small class="text-muted font-w400">(Dapat dipilih lebih dari satu)</small>
                                </label>
                                @php
                                    $oldAb = (array) old('alat_bantu', ['Tidak Ada']);
                                    $abOpts = ['Tidak Ada', 'Kursi Roda', 'Tongkat Ketiak (Crutches)', 'Walker', 'Tripod / Quadripod', 'Alat Bantu Dengar', 'Kruk / Tongkat Penuntun', 'AFO / Splint', 'Lainnya'];
                                @endphp
                                <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @foreach($abOpts as $abOpt)
                                        <label class="check-pill-card {{ in_array($abOpt, $oldAb) ? 'active' : '' }}" style="padding: 7px 16px; font-size: 12.5px; border-radius: 8px;">
                                            <input type="checkbox" name="alat_bantu[]" value="{{ $abOpt }}" {{ in_array($abOpt, $oldAb) ? 'checked' : '' }}>
                                            <span>{{ $abOpt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrapper_alat_bantu_lainnya" class="mt-2 {{ in_array('Lainnya', $oldAb) ? '' : 'd-none' }}" style="max-width: 480px;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-w600 text-primary" style="font-size: 12px;">Sebutkan Alat Bantu Lainnya:</span>
                                        </div>
                                        <input type="text" class="form-control" name="alat_bantu_lainnya" id="input_alat_bantu_lainnya" placeholder="Tuliskan alat bantu..." value="{{ old('alat_bantu_lainnya') }}" style="height: 38px; font-size: 12.5px;">
                                    </div>
                                </div>
                                @error('alat_bantu')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 4: BERKAS & DOKUMEN PENDUKUNG -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 15px;">
                                <i class="fa-solid fa-folder-open mr-2" style="color: #2563eb;"></i> Berkas & Dokumen Pendukung (Opsional)
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">File Kartu Keluarga (KK)</label>
                                <input type="file" class="form-control-file p-2" name="file_kk" accept=".jpg,.jpeg,.png,.pdf" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; width: 100%;">
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa-solid fa-circle-info mr-1"></i>Format: JPG, JPEG, PNG, PDF (Maksimal 10MB)</small>
                                @error('file_kk')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Surat Resume / Riwayat Berobat Sebelumnya</label>
                                <input type="file" class="form-control-file p-2" name="file_resume" accept=".jpg,.jpeg,.png,.pdf" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; width: 100%;">
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa-solid fa-circle-info mr-1"></i>Format: JPG, JPEG, PNG, PDF (Maksimal 10MB)</small>
                                @error('file_resume')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- TOMBOL AKSI SIMPAN -->
                        <div class="d-flex align-items-center justify-content-between pt-3 mt-4" style="border-top: 1px solid #edf2f7;">
                            <a href="{{Route('penerima-manfaat')}}" class="btn btn-sm btn-light font-w600" style="padding: 8px 18px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 13px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.check-pill-card {
    display: inline-flex;
    align-items: center;
    padding: 7px 16px;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    user-select: none;
    margin-bottom: 0;
    position: relative;
}

.check-pill-card:hover {
    background: #f8fafc;
    border-color: #93c5fd;
    color: #1e40af;
}

/* Custom Styled Checkbox */
.check-pill-card input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 17px;
    height: 17px;
    border: 1.8px solid #94a3b8;
    border-radius: 4px;
    outline: none;
    cursor: pointer;
    margin: 0 9px 0 0;
    background-color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
    transition: all 0.15s ease;
    position: relative;
    flex-shrink: 0;
}

.check-pill-card:hover input[type="checkbox"] {
    border-color: #2563eb;
}

.check-pill-card input[type="checkbox"]:checked {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
}

/* Custom Crisp White Checkmark inside the Blue Box */
.check-pill-card input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    width: 5px;
    height: 9px;
    border: solid #ffffff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    top: 1px;
    left: 4.5px;
}

/* Active State */
.check-pill-card.active,
.check-pill-card:has(input:checked) {
    background: #eff6ff !important;
    border-color: #2563eb !important;
    color: #1e40af !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.14) !important;
}
</style>
@endsection

@section('script')
<script>
    function updateDesilBadge() {
        var val = $('#desil').val();
        var badge = $('#desilBadge');
        if (!val) {
            badge.addClass('d-none').html('');
            return;
        }
        badge.removeClass('d-none');
        if (['Desil 1', 'Desil 2', 'Desil 3', 'Desil 4', 'Desil 5'].indexOf(val) !== -1) {
            badge.html('<span class="badge badge-success font-w700 py-2 px-3 text-white" style="font-size: 12px; border-radius: 6px; display: inline-flex; align-items: center;"><i class="fa-solid fa-circle-check mr-1"></i> PRIORITAS PROGRAM (Desil 1-5)</span>');
        } else {
            badge.html('<span class="badge badge-warning font-w700 py-2 px-3 text-dark" style="font-size: 12px; border-radius: 6px; display: inline-flex; align-items: center;"><i class="fa-solid fa-circle-info mr-1"></i> NON-PRIORITAS</span>');
        }
    }

    function toggleLainnyaInputs() {
        var isDisLainnya = $('input[name="jenis_disabilitas[]"][value="Lainnya"]').is(':checked');
        if (isDisLainnya) {
            $('#wrapper_disabilitas_lainnya').removeClass('d-none');
        } else {
            $('#wrapper_disabilitas_lainnya').addClass('d-none');
        }

        var isAbLainnya = $('input[name="alat_bantu[]"][value="Lainnya"]').is(':checked');
        if (isAbLainnya) {
            $('#wrapper_alat_bantu_lainnya').removeClass('d-none');
        } else {
            $('#wrapper_alat_bantu_lainnya').addClass('d-none');
        }
    }

    // =========================================================================
    // INTEGRASI API WILAYAH.ID BERJENJANG DENGAN SELECT2 SEARCHABLE (MUNCUL KE BAWAH)
    // =========================================================================
    const WilayahManager = {
        proxyUrl: "{{ url('/api/wilayah') }}",
        directUrl: 'https://wilayah.id/api',
        savedKab: "{{ old('kabupaten') }}",
        savedKec: "{{ old('kecamatan') }}",
        savedKel: "{{ old('kelurahan') }}",

        async init() {
            this.initSelect2();
            this.bindEvents();
            await this.loadProvinces();
        },

        initSelect2() {
            $('.select2-wilayah').each(function() {
                const $this = $(this);
                $this.select2({
                    dropdownParent: $this.closest('.col-wilayah'),
                    width: '100%',
                    language: {
                        noResults: function() { return 'Tidak ada data ditemukan'; },
                        searching: function() { return 'Mencari...'; }
                    }
                });
            });
        },

        bindEvents() {
            const self = this;

            // Ganti Provinsi -> Muat Kabupaten
            $('#select_provinsi').on('change', function() {
                const provCode = $(this).find(':selected').data('code');
                if (provCode) {
                    self.loadRegencies(provCode);
                } else {
                    self.resetSelect('#select_kabupaten', '-- Pilih Kabupaten / Kota --', true);
                    self.resetSelect('#select_kecamatan', '-- Pilih Kab/Kota Dahulu --', true);
                    self.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);
                }
            });

            // Ganti Kabupaten -> Muat Kecamatan
            $('#select_kabupaten').on('change', function() {
                const regCode = $(this).find(':selected').data('code');
                if (regCode) {
                    self.loadDistricts(regCode);
                } else {
                    self.resetSelect('#select_kecamatan', '-- Pilih Kab/Kota Dahulu --', true);
                    self.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);
                }
            });

            // Ganti Kecamatan -> Muat Kelurahan
            $('#select_kecamatan').on('change', function() {
                const distCode = $(this).find(':selected').data('code');
                if (distCode) {
                    self.loadVillages(distCode);
                } else {
                    self.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);
                }
            });
        },

        resetSelect(selector, placeholder, disable = true) {
            const $el = $(selector);
            $el.html(`<option value="" data-code="">${placeholder}</option>`);
            $el.prop('disabled', disable).trigger('change.select2');
        },

        showLoading(level, isShow) {
            const $loader = $(`#loading_${level}`);
            if (isShow) {
                $loader.removeClass('d-none');
            } else {
                $loader.addClass('d-none');
            }
        },

        normalizeName(str) {
            if (!str) return '';
            return str.toLowerCase()
                .replace(/^(kabupaten|kab\.|kota|kecamatan|kec\.|kelurahan|kel\.|desa|ds\.)\s+/i, '')
                .trim();
        },

        async fetchJson(endpoint, directEndpoint) {
            try {
                const res = await fetch(`${this.proxyUrl}/${endpoint}`);
                if (res.ok) {
                    const json = await res.json();
                    if (json.data && json.data.length > 0) {
                        return json.data;
                    }
                }
            } catch (e) {
                console.warn(`Proxy fetch failed for ${endpoint}, trying direct...`, e);
            }

            // Fallback direct
            try {
                const resDirect = await fetch(`${this.directUrl}/${directEndpoint}`);
                if (resDirect.ok) {
                    const jsonDirect = await resDirect.json();
                    return jsonDirect.data || [];
                }
            } catch (err) {
                console.error(`Direct fetch failed for ${directEndpoint}:`, err);
            }
            return [];
        },

        async loadProvinces() {
            this.showLoading('provinsi', true);
            try {
                const provinces = await this.fetchJson('provinces', 'provinces.json');

                let html = '<option value="" data-code="">-- Pilih Provinsi --</option>';
                let defaultProvCode = '35'; // Default Jawa Timur

                provinces.forEach(p => {
                    html += `<option value="${p.name}" data-code="${p.code}">${p.name}</option>`;
                });
                $('#select_provinsi').html(html).prop('disabled', false);

                // Auto-select Provinsi (Default: Jawa Timur)
                let targetProvCode = defaultProvCode;
                $('#select_provinsi option').each(function() {
                    if ($(this).data('code') == targetProvCode) {
                        $(this).prop('selected', true);
                    }
                });
                $('#select_provinsi').trigger('change.select2');

                // Load Regencies for selected province
                await this.loadRegencies(targetProvCode, this.savedKab);

            } catch (err) {
                console.error('Gagal memuat provinsi dari Wilayah.id:', err);
                $('#select_provinsi').html('<option value="">Gagal memuat data API</option>').trigger('change.select2');
            } finally {
                this.showLoading('provinsi', false);
            }
        },

        async loadRegencies(provCode, preselectedKab = '') {
            this.showLoading('kabupaten', true);
            this.resetSelect('#select_kabupaten', 'Memuat Kabupaten/Kota...', true);
            this.resetSelect('#select_kecamatan', '-- Pilih Kab/Kota Dahulu --', true);
            this.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);

            try {
                const regencies = await this.fetchJson(`regencies/${provCode}`, `regencies/${provCode}.json`);

                let html = '<option value="" data-code="">-- Pilih Kabupaten / Kota --</option>';
                let matchedCode = '';
                const normalizedSavedKab = this.normalizeName(preselectedKab);

                regencies.forEach(r => {
                    const isSelected = normalizedSavedKab && (this.normalizeName(r.name) === normalizedSavedKab || r.name.toLowerCase() === preselectedKab.toLowerCase());
                    if (isSelected) {
                        matchedCode = r.code;
                    }
                    html += `<option value="${r.name}" data-code="${r.code}" ${isSelected ? 'selected' : ''}>${r.name}</option>`;
                });

                if (preselectedKab && !matchedCode) {
                    html += `<option value="${preselectedKab}" data-code="" selected>${preselectedKab} (Tersimpan)</option>`;
                }

                $('#select_kabupaten').html(html).prop('disabled', false).trigger('change.select2');

                if (matchedCode) {
                    await this.loadDistricts(matchedCode, this.savedKec);
                }

            } catch (err) {
                console.error('Gagal memuat regencies:', err);
                this.resetSelect('#select_kabupaten', 'Gagal memuat Kab/Kota', false);
            } finally {
                this.showLoading('kabupaten', false);
            }
        },

        async loadDistricts(regCode, preselectedKec = '') {
            this.showLoading('kecamatan', true);
            this.resetSelect('#select_kecamatan', 'Memuat Kecamatan...', true);
            this.resetSelect('#select_kelurahan', '-- Pilih Kecamatan Dahulu --', true);

            try {
                const districts = await this.fetchJson(`districts/${regCode}`, `districts/${regCode}.json`);

                let html = '<option value="" data-code="">-- Pilih Kecamatan --</option>';
                let matchedCode = '';
                const normalizedSavedKec = this.normalizeName(preselectedKec);

                districts.forEach(d => {
                    const isSelected = normalizedSavedKec && (this.normalizeName(d.name) === normalizedSavedKec || d.name.toLowerCase() === preselectedKec.toLowerCase());
                    if (isSelected) {
                        matchedCode = d.code;
                    }
                    html += `<option value="${d.name}" data-code="${d.code}" ${isSelected ? 'selected' : ''}>${d.name}</option>`;
                });

                if (preselectedKec && !matchedCode) {
                    html += `<option value="${preselectedKec}" data-code="" selected>${preselectedKec} (Tersimpan)</option>`;
                }

                $('#select_kecamatan').html(html).prop('disabled', false).trigger('change.select2');

                if (matchedCode) {
                    await this.loadVillages(matchedCode, this.savedKel);
                }

            } catch (err) {
                console.error('Gagal memuat districts:', err);
                this.resetSelect('#select_kecamatan', 'Gagal memuat Kecamatan', false);
            } finally {
                this.showLoading('kecamatan', false);
            }
        },

        async loadVillages(distCode, preselectedKel = '') {
            this.showLoading('kelurahan', true);
            this.resetSelect('#select_kelurahan', 'Memuat Kelurahan/Desa...', true);

            try {
                const villages = await this.fetchJson(`villages/${distCode}`, `villages/${distCode}.json`);

                let html = '<option value="" data-code="">-- Pilih Kelurahan / Desa --</option>';
                let matchedCode = '';
                const normalizedSavedKel = this.normalizeName(preselectedKel);

                villages.forEach(v => {
                    const isSelected = normalizedSavedKel && (this.normalizeName(v.name) === normalizedSavedKel || v.name.toLowerCase() === preselectedKel.toLowerCase());
                    if (isSelected) {
                        matchedCode = v.code;
                    }
                    html += `<option value="${v.name}" data-code="${v.code}" ${isSelected ? 'selected' : ''}>${v.name}</option>`;
                });

                if (preselectedKel && !matchedCode) {
                    html += `<option value="${preselectedKel}" data-code="" selected>${preselectedKel} (Tersimpan)</option>`;
                }

                $('#select_kelurahan').html(html).prop('disabled', false).trigger('change.select2');

            } catch (err) {
                console.error('Gagal memuat villages:', err);
                this.resetSelect('#select_kelurahan', 'Gagal memuat Kelurahan', false);
            } finally {
                this.showLoading('kelurahan', false);
            }
        }
    };

    $(document).ready(function() {
        $('#desil').on('change', updateDesilBadge);
        updateDesilBadge();

        toggleLainnyaInputs();

        $(document).on('change', '.check-pill-card input[type="checkbox"]', function() {
            if ($(this).is(':checked')) {
                $(this).closest('.check-pill-card').addClass('active');
            } else {
                $(this).closest('.check-pill-card').removeClass('active');
            }
            toggleLainnyaInputs();
        });

        // Initialize Wilayah API Dependent Dropdown
        WilayahManager.init();
    });
</script>
@endsection
@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Tambah Penerima Manfaat</h2>
    <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 4px; font-size: 12.5px;">
        <li class="breadcrumb-item"><a href="{{Route('penerima-manfaat')}}">Data Penerima Manfaat</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Baru</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-body p-4">
                <div class="basic-form">
                    <form action="{{Route('penerima-manfaat.store')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <!-- BAGIAN: IDENTITAS UTAMA -->
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-id-card text-primary mr-2"></i> Identitas Penerima Manfaat
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">No. Rekam Medis</label>
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center" style="height: 40px; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 0 12px;">
                                    <i class="fa fa-id-card-o mr-2" style="color: var(--ot-navy); font-size: 15px;"></i>
                                    <input type="text" class="font-w700" name="no_rm" readonly value="{{ $autoNoRm ?? 'OTK-' . date('y') . '-XXXXX' }}" style="background: transparent; border: none; outline: none; box-shadow: none; color: var(--ot-navy); font-size: 13.5px; width: 100%; letter-spacing: 0.5px; padding: 0;">
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa fa-magic mr-1"></i>Nomor RM ter-generate otomatis (OTK-{{ date('y') }}-XXXXX)</small>
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">NIK</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nik" maxlength="16" id="nik" placeholder="Masukkan 16 digit NIK jika ada" value="{{old('nik')}}" style="height: 40px; font-size: 13px;">
                                @error('nik')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Nama Penerima Manfaat <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" id="nama" required placeholder="Nama lengkap penerima manfaat" value="{{old('nama')}}" style="height: 40px; font-size: 13px;">
                                @error('nama')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Tempat Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="tmp_lahir" placeholder="Kota/Kabupaten kelahiran" value="{{old('tmp_lahir')}}" style="height: 40px; font-size: 13px;">
                                @error('tmp_lahir')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Tanggal Lahir</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="tgl_lahir" value="{{old('tgl_lahir')}}" style="height: 40px; font-size: 13px;">
                                @error('tgl_lahir')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="col-sm-4 d-flex align-items-center" style="gap: 20px;">
                                <div class="form-check mb-0">
                                    <input type="radio" name="jk" id="jk_l" class="form-check-input" value="Laki-Laki" {{ old('jk') == 'Laki-Laki' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="jk_l" style="font-size: 13px; cursor: pointer;">Laki-Laki</label>     
                                </div>
                                <div class="form-check mb-0">
                                    <input type="radio" name="jk" id="jk_p" class="form-check-input" value="Perempuan" {{ old('jk') == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jk_p" style="font-size: 13px; cursor: pointer;">Perempuan</label>   
                                </div>
                                @error('jk')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Status Menikah</label>
                            <div class="col-sm-4">
                                <select name="status_menikah" class="form-control" style="height: 40px; font-size: 13px;">
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
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Agama</label>
                            <div class="col-sm-2">
                                <select name="agama" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih--</option>
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

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Pendidikan</label>
                            <div class="col-sm-2">
                                <select name="pendidikan" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih--</option>
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

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Pekerjaan</label>
                            <div class="col-sm-2">
                                <select name="pekerjaan" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih--</option>
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

                        <!-- BAGIAN: KONTAK & ALAMAT DOMISILI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-map-marker text-primary mr-2"></i> Kontak & Alamat Domisili
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">No. HP <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="no_hp" required placeholder="Contoh: 081234567890" value="{{old('no_hp')}}" style="height: 40px; font-size: 13px;">
                                @error('no_hp')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">No. BPJS / KIS</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" placeholder="Nomor kartu BPJS jika ada" value="{{old('no_bpjs')}}" style="height: 40px; font-size: 13px;">
                                @error('no_bpjs')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Alamat Lengkap</label>
                            <div class="col-sm-10">
                                <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Alamat jalan, RT/RW, Dusun, dll." style="font-size: 13px;">{{old('alamat_lengkap')}}</textarea>
                                @error('alamat_lengkap')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kelurahan / Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kelurahan" placeholder="Nama kelurahan/desa" value="{{old('kelurahan')}}" style="height: 40px; font-size: 13px;">
                                @error('kelurahan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kecamatan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kecamatan" placeholder="Nama kecamatan" value="{{old('kecamatan')}}" style="height: 40px; font-size: 13px;">
                                @error('kecamatan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kabupaten / Kota</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kabupaten" placeholder="Nama kabupaten/kota" value="{{old('kabupaten')}}" style="height: 40px; font-size: 13px;">
                                @error('kabupaten')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kode Pos</label>
                            <div class="col-sm-4">
                                <input type="number" maxlength="5" class="form-control" name="kodepos" placeholder="Contoh: 60231" value="{{old('kodepos')}}" style="height: 40px; font-size: 13px;">
                                @error('kodepos')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN: DATA SOSIAL, DISABILITAS & WALI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-users text-primary mr-2"></i> Data Sosial, Disabilitas & Wali
                            </h5>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Desil (DTKS/P3KE)</label>
                            <div class="col-sm-4">
                                <select name="desil" class="form-control" id="desil" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Tingkat Desil Sosial--</option>
                                    <option value="Desil 1" {{ old('desil') == 'Desil 1' ? 'selected' : '' }}>Desil 1 (Sangat Miskin)</option>
                                    <option value="Desil 2" {{ old('desil') == 'Desil 2' ? 'selected' : '' }}>Desil 2 (Miskin)</option>
                                    <option value="Desil 3" {{ old('desil') == 'Desil 3' ? 'selected' : '' }}>Desil 3 (Hampir Miskin)</option>
                                    <option value="Desil 4" {{ old('desil') == 'Desil 4' ? 'selected' : '' }}>Desil 4 (Rentan Miskin)</option>
                                    <option value="Desil 5" {{ old('desil') == 'Desil 5' ? 'selected' : '' }}>Desil 5</option>
                                    <option value="Desil 6" {{ old('desil') == 'Desil 6' ? 'selected' : '' }}>Desil 6</option>
                                    <option value="Desil 7" {{ old('desil') == 'Desil 7' ? 'selected' : '' }}>Desil 7</option>
                                    <option value="Desil 8" {{ old('desil') == 'Desil 8' ? 'selected' : '' }}>Desil 8</option>
                                    <option value="Desil 9" {{ old('desil') == 'Desil 9' ? 'selected' : '' }}>Desil 9</option>
                                    <option value="Desil 10" {{ old('desil') == 'Desil 10' ? 'selected' : '' }}>Desil 10</option>
                                    <option value="Non-Desil" {{ old('desil') == 'Non-Desil' ? 'selected' : '' }}>Non-Desil / Belum Terdata</option>
                                </select>
                                @error('desil')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Verifikasi DTKS</label>
                            <div class="col-sm-4">
                                <a href="https://cekbansos.kemensos.go.id/" target="_blank" rel="noopener noreferrer" 
                                   class="btn btn-outline-primary btn-block d-flex align-items-center justify-content-center" 
                                   style="height: 40px; font-size: 12.5px; font-weight: 600; border-color: var(--ot-navy); color: var(--ot-navy); background: #f8fafc; border-style: dashed;"
                                   title="Buka portal Cek Bansos Kemensos RI">
                                    <i class="fa fa-external-link mr-2"></i> Cek Desil di Kemensos
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Nama Wali / Ortu</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_wali" placeholder="Nama lengkap wali / orang tua" value="{{old('nama_wali')}}" style="height: 40px; font-size: 13px;">
                                @error('nama_wali')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Hubungan dgn Pasien</label>
                            <div class="col-sm-4">
                                <select name="hubungan_wali" class="form-control" style="height: 40px; font-size: 13px;">
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
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Jenis Disabilitas</label>
                            <div class="col-sm-4">
                                <select name="jenis_disabilitas" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Jenis Disabilitas--</option>
                                    <option value="Tidak Ada" {{ old('jenis_disabilitas') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Fisik" {{ old('jenis_disabilitas') == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                    <option value="Intelektual" {{ old('jenis_disabilitas') == 'Intelektual' ? 'selected' : '' }}>Intelektual</option>
                                    <option value="Sensorik Netra" {{ old('jenis_disabilitas') == 'Sensorik Netra' ? 'selected' : '' }}>Sensorik Netra</option>
                                    <option value="Sensorik Rungu/Wicara" {{ old('jenis_disabilitas') == 'Sensorik Rungu/Wicara' ? 'selected' : '' }}>Sensorik Rungu/Wicara</option>
                                    <option value="Ganda" {{ old('jenis_disabilitas') == 'Ganda' ? 'selected' : '' }}>Ganda</option>
                                    <option value="Lainnya" {{ old('jenis_disabilitas') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis_disabilitas')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Alat Bantu Mobilitas</label>
                            <div class="col-sm-4">
                                <select name="alat_bantu" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Alat Bantu--</option>
                                    <option value="Tidak Ada" {{ old('alat_bantu') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Kursi Roda" {{ old('alat_bantu') == 'Kursi Roda' ? 'selected' : '' }}>Kursi Roda</option>
                                    <option value="Tongkat Ketiak (Crutches)" {{ old('alat_bantu') == 'Tongkat Ketiak (Crutches)' ? 'selected' : '' }}>Tongkat Ketiak (Crutches)</option>
                                    <option value="Walker" {{ old('alat_bantu') == 'Walker' ? 'selected' : '' }}>Walker</option>
                                    <option value="Alat Bantu Dengar" {{ old('alat_bantu') == 'Alat Bantu Dengar' ? 'selected' : '' }}>Alat Bantu Dengar</option>
                                    <option value="Kruk / Tongkat Penuntun" {{ old('alat_bantu') == 'Kruk / Tongkat Penuntun' ? 'selected' : '' }}>Kruk / Tongkat Penuntun</option>
                                    <option value="Lainnya" {{ old('alat_bantu') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('alat_bantu')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN: BERKAS & DOKUMEN PENDUKUNG -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-folder-open text-primary mr-2"></i> Berkas & Dokumen Pendukung (Opsional)
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">File Kartu Keluarga (KK)</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-file" name="file_kk" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa fa-info-circle mr-1"></i>Format: JPG, JPEG, PNG, PDF (Maksimal 10MB)</small>
                                @error('file_kk')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Surat Resume / Riwayat Berobat</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-file" name="file_resume" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa fa-info-circle mr-1"></i>Format: JPG, JPEG, PNG, PDF (Maksimal 10MB) - Berkas rekam medis atau surat keterangan rujukan/berobat sebelumnya jika ada</small>
                                @error('file_resume')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- TOMBOL AKSI SIMPAN -->
                        <div class="d-flex align-items-center justify-content-between pt-3 mt-4" style="border-top: 1px solid #edf2f7;">
                            <a href="{{Route('penerima-manfaat')}}" class="btn btn-sm btn-light" style="padding: 8px 18px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                                <i class="fa fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 24px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                <i class="fa fa-save mr-1"></i> Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Nomor RM di-generate secara otomatis oleh sistem dengan format OTK-[YY]-[5 DIGIT]
</script>
@endsection
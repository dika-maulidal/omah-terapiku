@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Edit Data Penerima Manfaat</h2>
    <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 4px; font-size: 12.5px;">
        <li class="breadcrumb-item"><a href="{{Route('penerima-manfaat')}}">Data Penerima Manfaat</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Data: {{ $data->nama }}</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-body p-4">
                <div class="basic-form">
                    <form action="{{Route('penerima-manfaat.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <!-- BAGIAN 1: IDENTITAS UTAMA -->
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-id-card text-primary mr-2"></i> 1. Identitas Penerima Manfaat
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">No. Rekam Medis</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light text-primary font-w600" style="height: 40px;"><i class="fa fa-id-card-o"></i></span>
                                    </div>
                                    <input type="text" class="form-control font-w600" name="no_rm" readonly required value="{{old('no_rm') ? old('no_rm') : $data->no_rm}}" style="background-color: #f8f9fa; color: #1e3d73; height: 40px; font-size: 13px;">
                                </div>
                                @error('no_rm')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">NIK</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nik" maxlength="16" placeholder="Masukkan 16 digit NIK" value="{{old('nik') ? old('nik') : $data->nik}}" style="height: 40px; font-size: 13px;">
                                @error('nik')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Nama Penerima Manfaat <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" required value="{{old('nama') ? old('nama') : $data->nama}}" style="height: 40px; font-size: 13px;">
                                @error('nama')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Tempat Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="tmp_lahir" value="{{old('tmp_lahir') ? old('tmp_lahir') : $data->tmp_lahir}}" style="height: 40px; font-size: 13px;">
                                @error('tmp_lahir')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Tanggal Lahir</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="tgl_lahir" value="{{old('tgl_lahir') ? old('tgl_lahir') : $data->tgl_lahir}}" style="height: 40px; font-size: 13px;">
                                @error('tgl_lahir')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="col-sm-4 d-flex align-items-center" style="gap: 20px;">
                                <div class="form-check mb-0">
                                    <input type="radio" name="jk" id="jk_l" class="form-check-input" value="Laki-Laki" {{ (old('jk') ? old('jk') : $data->jk) == "Laki-Laki" ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="jk_l" style="font-size: 13px; cursor: pointer;">Laki-Laki</label>     
                                </div>
                                <div class="form-check mb-0">
                                    <input type="radio" name="jk" id="jk_p" class="form-check-input" value="Perempuan" {{ (old('jk') ? old('jk') : $data->jk) == "Perempuan" ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jk_p" style="font-size: 13px; cursor: pointer;">Perempuan</label>   
                                </div>
                                @error('jk')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Status Menikah</label>
                            <div class="col-sm-4">
                                @php $currentNikah = old('status_menikah') ? old('status_menikah') : $data->status_menikah; @endphp
                                <select name="status_menikah" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Status Menikah--</option>
                                    <option value="Belum Menikah" {{$currentNikah == "Belum Menikah" ? 'selected' : ''}}>Belum Menikah</option>
                                    <option value="Menikah" {{$currentNikah == "Menikah" ? 'selected' : ''}}>Menikah</option>
                                    <option value="Duda" {{$currentNikah == "Duda" ? 'selected' : ''}}>Duda</option>
                                    <option value="Janda" {{$currentNikah == "Janda" ? 'selected' : ''}}>Janda</option>
                                </select>
                                @error('status_menikah')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Agama</label>
                            <div class="col-sm-2">
                                @php $currentAgama = old('agama') ? old('agama') : $data->agama; @endphp
                                <select name="agama" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih--</option>
                                    <option value="Islam" {{$currentAgama == "Islam" ? 'selected' : ''}}>Islam</option>
                                    <option value="Kristen" {{$currentAgama == "Kristen" ? 'selected' : ''}}>Kristen</option>
                                    <option value="Katholik" {{$currentAgama == "Katholik" ? 'selected' : ''}}>Katholik</option>
                                    <option value="Hindu" {{$currentAgama == "Hindu" ? 'selected' : ''}}>Hindu</option>
                                    <option value="Budha" {{$currentAgama == "Budha" ? 'selected' : ''}}>Budha</option>
                                    <option value="Konghucu" {{$currentAgama == "Konghucu" ? 'selected' : ''}}>Konghucu</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Pendidikan</label>
                            <div class="col-sm-2">
                                @php $currentPendidikan = old('pendidikan') ? old('pendidikan') : $data->pendidikan; @endphp
                                <select name="pendidikan" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih--</option>
                                    <option value="SD" {{$currentPendidikan == "SD" ? 'selected' : ''}}>SD</option>
                                    <option value="SMP" {{$currentPendidikan == "SMP" ? 'selected' : ''}}>SMP</option>
                                    <option value="SMA" {{$currentPendidikan == "SMA" ? 'selected' : ''}}>SMA</option>
                                    <option value="Diploma" {{$currentPendidikan == "Diploma" ? 'selected' : ''}}>Diploma</option>
                                    <option value="S1" {{$currentPendidikan == "S1" ? 'selected' : ''}}>S1</option>
                                    <option value="S2" {{$currentPendidikan == "S2" ? 'selected' : ''}}>S2</option>
                                    <option value="S3" {{$currentPendidikan == "S3" ? 'selected' : ''}}>S3</option>
                                    <option value="Tidak Sekolah" {{$currentPendidikan == "Tidak Sekolah" ? 'selected' : ''}}>Tidak Sekolah</option>
                                </select>
                                @error('pendidikan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Pekerjaan</label>
                            <div class="col-sm-2">
                                @php $currentPekerjaan = old('pekerjaan') ? old('pekerjaan') : $data->pekerjaan; @endphp
                                <select name="pekerjaan" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih--</option>
                                    <option value="PNS" {{$currentPekerjaan == "PNS" ? 'selected' : ''}}>PNS</option>
                                    <option value="Wiraswasta" {{$currentPekerjaan == "Wiraswasta" ? 'selected' : ''}}>Wiraswasta</option>
                                    <option value="TNI/Polri" {{$currentPekerjaan == "TNI/Polri" ? 'selected' : ''}}>TNI/Polri</option>
                                    <option value="Pelajar/Mahasiswa" {{$currentPekerjaan == "Pelajar/Mahasiswa" ? 'selected' : ''}}>Pelajar/Mahasiswa</option>
                                    <option value="Petani" {{$currentPekerjaan == "Petani" ? 'selected' : ''}}>Petani</option>
                                    <option value="Guru/Pengajar" {{$currentPekerjaan == "Guru/Pengajar" ? 'selected' : ''}}>Guru/Pengajar</option>
                                    <option value="IRT" {{$currentPekerjaan == "IRT" ? 'selected' : ''}}>IRT</option>
                                    <option value="Lain-Lain" {{$currentPekerjaan == "Lain-Lain" ? 'selected' : ''}}>Lain-Lain</option>
                                </select>
                                @error('pekerjaan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 2: KONTAK & ALAMAT DOMISILI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-map-marker text-primary mr-2"></i> 2. Kontak & Alamat Domisili
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">No. HP <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="no_hp" required placeholder="Contoh: 081234567890" value="{{old('no_hp') ? old('no_hp') : $data->no_hp}}" style="height: 40px; font-size: 13px;">
                                @error('no_hp')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">No. BPJS / KIS</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" placeholder="Nomor BPJS atau KTP jika ada" value="{{old('no_bpjs') ? old('no_bpjs') : $data->no_bpjs}}" style="height: 40px; font-size: 13px;">
                                @error('no_bpjs')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Alamat Lengkap</label>
                            <div class="col-sm-10">
                                <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Alamat jalan, RT/RW, Dusun, dll." style="font-size: 13px;">{{old('alamat_lengkap') ? old('alamat_lengkap') : $data->alamat_lengkap}}</textarea>
                                @error('alamat_lengkap')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kelurahan / Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kelurahan" value="{{old('kelurahan') ? old('kelurahan') : $data->kelurahan}}" style="height: 40px; font-size: 13px;">
                                @error('kelurahan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kecamatan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kecamatan" value="{{old('kecamatan') ? old('kecamatan') : $data->kecamatan}}" style="height: 40px; font-size: 13px;">
                                @error('kecamatan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kabupaten / Kota</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kabupaten" value="{{old('kabupaten') ? old('kabupaten') : $data->kabupaten}}" style="height: 40px; font-size: 13px;">
                                @error('kabupaten')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kode Pos</label>
                            <div class="col-sm-4">
                                <input type="number" maxlength="5" class="form-control" name="kodepos" value="{{old('kodepos') ? old('kodepos') : $data->kodepos}}" style="height: 40px; font-size: 13px;">
                                @error('kodepos')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 3: DATA SOSIAL, DISABILITAS & WALI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-users text-primary mr-2"></i> 3. Data Sosial, Disabilitas & Wali
                            </h5>
                        </div>

                        <div class="form-group row align-items-center">
                            @php $currentDesil = old('desil') ? old('desil') : $data->desil; @endphp
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Desil (DTKS/P3KE)</label>
                            <div class="col-sm-4">
                                <select name="desil" class="form-control" id="desil" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Tingkat Desil Sosial--</option>
                                    <option value="Desil 1" {{$currentDesil == "Desil 1" ? 'selected' : ''}}>Desil 1 (Sangat Miskin)</option>
                                    <option value="Desil 2" {{$currentDesil == "Desil 2" ? 'selected' : ''}}>Desil 2 (Miskin)</option>
                                    <option value="Desil 3" {{$currentDesil == "Desil 3" ? 'selected' : ''}}>Desil 3 (Hampir Miskin)</option>
                                    <option value="Desil 4" {{$currentDesil == "Desil 4" ? 'selected' : ''}}>Desil 4 (Rentan Miskin)</option>
                                    <option value="Desil 5" {{$currentDesil == "Desil 5" ? 'selected' : ''}}>Desil 5</option>
                                    <option value="Desil 6" {{$currentDesil == "Desil 6" ? 'selected' : ''}}>Desil 6</option>
                                    <option value="Desil 7" {{$currentDesil == "Desil 7" ? 'selected' : ''}}>Desil 7</option>
                                    <option value="Desil 8" {{$currentDesil == "Desil 8" ? 'selected' : ''}}>Desil 8</option>
                                    <option value="Desil 9" {{$currentDesil == "Desil 9" ? 'selected' : ''}}>Desil 9</option>
                                    <option value="Desil 10" {{$currentDesil == "Desil 10" ? 'selected' : ''}}>Desil 10</option>
                                    <option value="Non-Desil" {{$currentDesil == "Non-Desil" ? 'selected' : ''}}>Non-Desil / Belum Terdata</option>
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

                        @php
                            $currentNamaWali = old('nama_wali') !== null ? old('nama_wali') : $data->nama_wali;
                            $currentHubunganWali = old('hubungan_wali') !== null ? old('hubungan_wali') : $data->hubungan_wali;
                            $currentJenisDisabilitas = old('jenis_disabilitas') !== null ? old('jenis_disabilitas') : $data->jenis_disabilitas;
                            $currentAlatBantu = old('alat_bantu') !== null ? old('alat_bantu') : $data->alat_bantu;
                        @endphp

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Nama Wali / Ortu</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_wali" placeholder="Nama lengkap wali / orang tua" value="{{$currentNamaWali}}" style="height: 40px; font-size: 13px;">
                                @error('nama_wali')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Hubungan dgn Pasien</label>
                            <div class="col-sm-4">
                                <select name="hubungan_wali" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Hubungan--</option>
                                    <option value="Orang Tua Kandung" {{$currentHubunganWali == 'Orang Tua Kandung' ? 'selected' : ''}}>Orang Tua Kandung</option>
                                    <option value="Wali" {{$currentHubunganWali == 'Wali' ? 'selected' : ''}}>Wali</option>
                                    <option value="Pengasuh UPT" {{$currentHubunganWali == 'Pengasuh UPT' ? 'selected' : ''}}>Pengasuh UPT</option>
                                    <option value="Keluarga / Kerabat" {{$currentHubunganWali == 'Keluarga / Kerabat' ? 'selected' : ''}}>Keluarga / Kerabat</option>
                                    <option value="Lainnya" {{$currentHubunganWali == 'Lainnya' ? 'selected' : ''}}>Lainnya</option>
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
                                    <option value="Tidak Ada" {{$currentJenisDisabilitas == 'Tidak Ada' ? 'selected' : ''}}>Tidak Ada</option>
                                    <option value="Fisik" {{$currentJenisDisabilitas == 'Fisik' ? 'selected' : ''}}>Fisik</option>
                                    <option value="Intelektual" {{$currentJenisDisabilitas == 'Intelektual' ? 'selected' : ''}}>Intelektual</option>
                                    <option value="Sensorik Netra" {{$currentJenisDisabilitas == 'Sensorik Netra' ? 'selected' : ''}}>Sensorik Netra</option>
                                    <option value="Sensorik Rungu/Wicara" {{$currentJenisDisabilitas == 'Sensorik Rungu/Wicara' ? 'selected' : ''}}>Sensorik Rungu/Wicara</option>
                                    <option value="Ganda" {{$currentJenisDisabilitas == 'Ganda' ? 'selected' : ''}}>Ganda</option>
                                    <option value="Lainnya" {{$currentJenisDisabilitas == 'Lainnya' ? 'selected' : ''}}>Lainnya</option>
                                </select>
                                @error('jenis_disabilitas')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Alat Bantu Mobilitas</label>
                            <div class="col-sm-4">
                                <select name="alat_bantu" class="form-control" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Alat Bantu--</option>
                                    <option value="Tidak Ada" {{$currentAlatBantu == 'Tidak Ada' ? 'selected' : ''}}>Tidak Ada</option>
                                    <option value="Kursi Roda" {{$currentAlatBantu == 'Kursi Roda' ? 'selected' : ''}}>Kursi Roda</option>
                                    <option value="Tongkat Ketiak (Crutches)" {{$currentAlatBantu == 'Tongkat Ketiak (Crutches)' ? 'selected' : ''}}>Tongkat Ketiak (Crutches)</option>
                                    <option value="Walker" {{$currentAlatBantu == 'Walker' ? 'selected' : ''}}>Walker</option>
                                    <option value="Alat Bantu Dengar" {{$currentAlatBantu == 'Alat Bantu Dengar' ? 'selected' : ''}}>Alat Bantu Dengar</option>
                                    <option value="Kruk / Tongkat Penuntun" {{$currentAlatBantu == 'Kruk / Tongkat Penuntun' ? 'selected' : ''}}>Kruk / Tongkat Penuntun</option>
                                    <option value="Lainnya" {{$currentAlatBantu == 'Lainnya' ? 'selected' : ''}}>Lainnya</option>
                                </select>
                                @error('alat_bantu')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 4: BERKAS & DOKUMEN PENDUKUNG -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-folder-open text-primary mr-2"></i> 4. Berkas & Dokumen Pendukung (Opsional)
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
                                @if ($data->file_kk)
                                    <div class="mt-2">
                                        @if (Str::endsWith(strtolower($data->file_kk), ['.jpg', '.jpeg', '.png']))
                                            <a href="{{$data->getFileKk()}}" target="_blank">
                                                <img height="90px" class="img-thumbnail" src="{{$data->getFileKk()}}" alt="File KK" style="border-radius: 8px;">
                                            </a>
                                        @else
                                            <a href="{{$data->getFileKk()}}" target="_blank" class="btn btn-xs btn-info shadow-sm" style="font-size: 12px;">
                                                <i class="fa fa-file mr-1"></i> Lihat Berkas KK
                                            </a>
                                        @endif
                                        <small class="text-muted d-block mt-1" style="font-size: 11.5px;">Upload file baru jika ingin mengganti berkas KK</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Surat Resume / Riwayat Berobat</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-file" name="file_resume" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa fa-info-circle mr-1"></i>Format: JPG, JPEG, PNG, PDF (Maksimal 10MB) - Berkas rekam medis / resume berobat sebelumnya</small>
                                @error('file_resume')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                                @if ($data->file_resume)
                                    <div class="mt-2">
                                        @if (Str::endsWith(strtolower($data->file_resume), ['.jpg', '.jpeg', '.png']))
                                            <a href="{{$data->getFileResume()}}" target="_blank">
                                                <img height="90px" class="img-thumbnail" src="{{$data->getFileResume()}}" alt="Surat Resume" style="border-radius: 8px;">
                                            </a>
                                        @else
                                            <a href="{{$data->getFileResume()}}" target="_blank" class="btn btn-xs btn-info shadow-sm" style="font-size: 12px;">
                                                <i class="fa fa-file mr-1"></i> Lihat Berkas Resume
                                            </a>
                                        @endif
                                        <small class="text-muted d-block mt-1" style="font-size: 11.5px;">Upload file baru jika ingin mengganti berkas resume</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- TOMBOL AKSI UPDATE -->
                        <div class="d-flex align-items-center justify-content-between pt-3 mt-4" style="border-top: 1px solid #edf2f7;">
                            <a href="{{Route('penerima-manfaat')}}" class="btn btn-sm btn-light" style="padding: 8px 18px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                                <i class="fa fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 24px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                <i class="fa fa-save mr-1"></i> Update Data
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
@endsection
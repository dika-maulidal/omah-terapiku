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

                        <!-- BAGIAN: IDENTITAS UTAMA -->
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa-solid fa-id-card text-primary mr-2"></i> Identitas Penerima Manfaat
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">No. Rekam Medis</label>
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center" style="height: 40px; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 0 12px;">
                                    <i class="fa-solid fa-id-card mr-2" style="color: var(--ot-navy); font-size: 15px;"></i>
                                    <input type="text" class="font-w700" name="no_rm" readonly required value="{{old('no_rm') ? old('no_rm') : $data->no_rm}}" style="background: transparent; border: none; outline: none; box-shadow: none; color: var(--ot-navy); font-size: 13.5px; width: 100%; letter-spacing: 0.5px; padding: 0;">
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

                        <!-- BAGIAN: KONTAK & ALAMAT DOMISILI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa-solid fa-location-dot text-primary mr-2"></i> Kontak & Alamat Domisili
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
                                <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" placeholder="Nomor kartu BPJS jika ada" value="{{old('no_bpjs') ? old('no_bpjs') : $data->no_bpjs}}" style="height: 40px; font-size: 13px;">
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
                                <input type="text" class="form-control" name="kelurahan" placeholder="Nama kelurahan/desa" value="{{old('kelurahan') ? old('kelurahan') : $data->kelurahan}}" style="height: 40px; font-size: 13px;">
                                @error('kelurahan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kecamatan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kecamatan" placeholder="Nama kecamatan" value="{{old('kecamatan') ? old('kecamatan') : $data->kecamatan}}" style="height: 40px; font-size: 13px;">
                                @error('kecamatan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kabupaten / Kota</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kabupaten" placeholder="Nama kabupaten/kota" value="{{old('kabupaten') ? old('kabupaten') : $data->kabupaten}}" style="height: 40px; font-size: 13px;">
                                @error('kabupaten')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Kode Pos</label>
                            <div class="col-sm-4">
                                <input type="number" maxlength="5" class="form-control" name="kodepos" placeholder="Contoh: 60231" value="{{old('kodepos') ? old('kodepos') : $data->kodepos}}" style="height: 40px; font-size: 13px;">
                                @error('kodepos')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN: DATA SOSIAL, DISABILITAS, UPT & WALI -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa-solid fa-wheelchair text-primary mr-2"></i> Data Sosial, Disabilitas, UPT & Wali
                            </h5>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Desil (DTKS/P3KE)</label>
                            <div class="col-sm-4">
                                @php $currentDesil = old('desil') ? old('desil') : $data->desil; @endphp
                                <select name="desil" class="form-control" id="desil" style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Tingkat Desil Sosial--</option>
                                    <option value="Desil 1" {{$currentDesil == 'Desil 1' ? 'selected' : ''}}>Desil 1 (Sangat Miskin / Ekstrem)</option>
                                    <option value="Desil 2" {{$currentDesil == 'Desil 2' ? 'selected' : ''}}>Desil 2 (Miskin)</option>
                                    <option value="Desil 3" {{$currentDesil == 'Desil 3' ? 'selected' : ''}}>Desil 3 (Hampir Miskin)</option>
                                    <option value="Desil 4" {{$currentDesil == 'Desil 4' ? 'selected' : ''}}>Desil 4 (Rentan Miskin)</option>
                                    <option value="Desil 5" {{$currentDesil == 'Desil 5' ? 'selected' : ''}}>Desil 5 (Menengah Bawah)</option>
                                    <option value="Desil 6" {{$currentDesil == 'Desil 6' ? 'selected' : ''}}>Desil 6</option>
                                    <option value="Desil 7" {{$currentDesil == 'Desil 7' ? 'selected' : ''}}>Desil 7</option>
                                    <option value="Desil 8" {{$currentDesil == 'Desil 8' ? 'selected' : ''}}>Desil 8</option>
                                    <option value="Desil 9" {{$currentDesil == 'Desil 9' ? 'selected' : ''}}>Desil 9</option>
                                    <option value="Desil 10" {{$currentDesil == 'Desil 10' ? 'selected' : ''}}>Desil 10</option>
                                    <option value="Non-Desil" {{$currentDesil == 'Non-Desil' ? 'selected' : ''}}>Non-Desil / Belum Terdata</option>
                                </select>
                                <div id="desilBadge" class="mt-2 d-none"></div>
                                @error('desil')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">UPT Lokasi Domisili</label>
                            <div class="col-sm-4">
                                @php $currentUpt = old('upt_lokasi') ? old('upt_lokasi') : ($data->upt_lokasi ?: 'UPT PPSAB Sidoarjo'); @endphp
                                <select name="upt_lokasi" class="form-control" style="height: 40px; font-size: 13px;">
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
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Verifikasi DTKS</label>
                            <div class="col-sm-4">
                                <a href="https://cekbansos.kemensos.go.id/" target="_blank" rel="noopener noreferrer" 
                                   class="btn btn-outline-primary btn-block d-flex align-items-center justify-content-center" 
                                   style="height: 40px; font-size: 12.5px; font-weight: 600; border-color: var(--ot-navy); color: var(--ot-navy); background: #f8fafc; border-style: dashed;"
                                   title="Buka portal Cek Bansos Kemensos RI">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Cek Desil di Kemensos
                                </a>
                            </div>
                        </div>

                        @php
                            $currentNamaWali = old('nama_wali') ? old('nama_wali') : $data->nama_wali;
                            $currentHubunganWali = old('hubungan_wali') ? old('hubungan_wali') : $data->hubungan_wali;
                            
                            $rawDis = is_array(old('jenis_disabilitas')) ? old('jenis_disabilitas') : array_map('trim', explode(',', $data->jenis_disabilitas ?? ''));
                            $selectedDis = [];
                            $isDisLainnya = false;
                            $disLainnyaVal = old('jenis_disabilitas_lainnya', '');
                            foreach ($rawDis as $dItem) {
                                if (Str::startsWith($dItem, 'Lainnya')) {
                                    $selectedDis[] = 'Lainnya';
                                    $isDisLainnya = true;
                                    if (empty($disLainnyaVal) && preg_match('/Lainnya\s*\((.*?)\)/', $dItem, $matches)) {
                                        $disLainnyaVal = $matches[1];
                                    }
                                } else {
                                    $selectedDis[] = $dItem;
                                }
                            }

                            $rawAb = is_array(old('alat_bantu')) ? old('alat_bantu') : array_map('trim', explode(',', $data->alat_bantu ?? ''));
                            $selectedAb = [];
                            $isAbLainnya = false;
                            $abLainnyaVal = old('alat_bantu_lainnya', '');
                            foreach ($rawAb as $aItem) {
                                if (Str::startsWith($aItem, 'Lainnya')) {
                                    $selectedAb[] = 'Lainnya';
                                    $isAbLainnya = true;
                                    if (empty($abLainnyaVal) && preg_match('/Lainnya\s*\((.*?)\)/', $aItem, $matches)) {
                                        $abLainnyaVal = $matches[1];
                                    }
                                } else {
                                    $selectedAb[] = $aItem;
                                }
                            }
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
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Jenis Disabilitas <small class="text-muted d-block">(Bisa pilih > 1)</small></label>
                            <div class="col-sm-10">
                                @php
                                    $disOpts = ['Fisik', 'Intelektual', 'Mental', 'Sensorik Netra', 'Sensorik Rungu/Wicara', 'Ganda', 'Lainnya'];
                                @endphp
                                <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @foreach($disOpts as $disOpt)
                                        <label class="check-pill-card {{ in_array($disOpt, $selectedDis) ? 'active' : '' }}" style="padding: 6px 14px; font-size: 12.5px; border-radius: 6px;">
                                            <input type="checkbox" name="jenis_disabilitas[]" value="{{ $disOpt }}" {{ in_array($disOpt, $selectedDis) ? 'checked' : '' }}>
                                            <span>{{ $disOpt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrapper_disabilitas_lainnya" class="mt-2 {{ in_array('Lainnya', $selectedDis) || $isDisLainnya ? '' : 'd-none' }}" style="max-width: 480px;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-w600 text-primary" style="font-size: 12px;">Sebutkan Disabilitas Lainnya:</span>
                                        </div>
                                        <input type="text" class="form-control" name="jenis_disabilitas_lainnya" id="input_disabilitas_lainnya" placeholder="Tuliskan ragam disabilitas..." value="{{ $disLainnyaVal }}" style="height: 38px; font-size: 12.5px;">
                                    </div>
                                </div>
                                @error('jenis_disabilitas')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Alat Bantu Mobilitas <small class="text-muted d-block">(Bisa pilih > 1)</small></label>
                            <div class="col-sm-10">
                                @php
                                    $abOpts = ['Tidak Ada', 'Kursi Roda', 'Tongkat Ketiak (Crutches)', 'Walker', 'Tripod / Quadripod', 'Alat Bantu Dengar', 'Kruk / Tongkat Penuntun', 'AFO / Splint', 'Lainnya'];
                                @endphp
                                <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @foreach($abOpts as $abOpt)
                                        <label class="check-pill-card {{ in_array($abOpt, $selectedAb) ? 'active' : '' }}" style="padding: 6px 14px; font-size: 12.5px; border-radius: 6px;">
                                            <input type="checkbox" name="alat_bantu[]" value="{{ $abOpt }}" {{ in_array($abOpt, $selectedAb) ? 'checked' : '' }}>
                                            <span>{{ $abOpt }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="wrapper_alat_bantu_lainnya" class="mt-2 {{ in_array('Lainnya', $selectedAb) || $isAbLainnya ? '' : 'd-none' }}" style="max-width: 480px;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-w600 text-primary" style="font-size: 12px;">Sebutkan Alat Bantu Lainnya:</span>
                                        </div>
                                        <input type="text" class="form-control" name="alat_bantu_lainnya" id="input_alat_bantu_lainnya" placeholder="Tuliskan alat bantu..." value="{{ $abLainnyaVal }}" style="height: 38px; font-size: 12.5px;">
                                    </div>
                                </div>
                                @error('alat_bantu')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN: BERKAS & DOKUMEN PENDUKUNG -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa-solid fa-folder-open text-primary mr-2"></i> Berkas & Dokumen Pendukung (Opsional)
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">File Kartu Keluarga (KK)</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-file" name="file_kk" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa-solid fa-circle-info mr-1"></i>Format: JPG, JPEG, PNG, PDF (Maksimal 10MB)</small>
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
                                                <i class="fa-solid fa-file mr-1"></i> Lihat Berkas KK
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
                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;"><i class="fa-solid fa-circle-info mr-1"></i>Format: JPG, JPEG, PNG, PDF (Maksimal 10MB) - Berkas rekam medis / resume berobat sebelumnya</small>
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
                                                <i class="fa-solid fa-file mr-1"></i> Lihat Berkas Resume
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
                                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 24px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                <i class="fa-solid fa-floppy-disk mr-1"></i> Update Data
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
    padding: 6px 14px;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    font-size: 12.5px;
    font-weight: 500;
    color: #334155;
    transition: all 0.15s ease-in-out;
    user-select: none;
    margin-bottom: 0;
}

.check-pill-card:hover {
    background: #f8fafc;
    border-color: #38A5DB;
    color: #2D4B7A;
}

.check-pill-card input[type="checkbox"] {
    margin: 0 8px 0 0;
    width: 15px;
    height: 15px;
    cursor: pointer;
    accent-color: #2D4B7A;
    vertical-align: middle;
}

.check-pill-card.active,
.check-pill-card:has(input:checked) {
    background: #edf3fc !important;
    border-color: #2D4B7A !important;
    color: #2D4B7A !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 6px rgba(45, 75, 122, 0.12) !important;
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
    });
</script>
@endsection
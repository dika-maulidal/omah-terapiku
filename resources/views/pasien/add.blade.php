@extends('layout.apps')
@section('content')
<div class="form-head align-items-center d-flex mb-sm-4 mb-3">
    <div class="mr-auto">
        <h2 class="text-black font-w600">Tambah Pasien</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{Route('penerima-manfaat')}}">Data Penerima Manfaat</a></li>
            <li class="breadcrumb-item active"><a href="#">Tambah Data Penerima Manfaat</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{Route('penerima-manfaat.store')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                       
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Penerima Manfaat*</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama" 
                               id="nama" required value="{{old('nama')}}">
                                @error('nama')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nik" maxlength="16"
                                id="nik" placeholder="Masukkan 16 digit NIK" value="{{old('nik')}}">
                                @error('nik')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">No.RM*</label>
                            <div class="col-sm-2">
                                <select name="code" class="form-control" id="code">
                                    <option value="D">Dewasa</option>
                                    <option value="A">Anak</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"
                                 name="no_rm" required id="no_rm"
                                 value="{{old('no_rm')}}">
                                @error('no_rm')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="tmp_lahir"  value="{{old('tmp_lahir')}}">
                                @error('tmp_lahir')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="tgl_lahir"  value="{{old('tgl_lahir')}}">
                                @error('tgl_lahir')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Kelamin*</label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <input type="radio" name="jk" class="form-check-input" 
                                    value="Laki-Laki">
                                    <label class="form-check-label">Laki-Laki</label>     
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="jk" class="form-check-input"
                                    value="Perempuan">
                                    <label class="form-check-label">Perempuan</label>   
                                </div>
                                @error('jk')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Status Menikah</label>
                            <div class="col-sm-4">
                               
                                <select name="status_menikah" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Duda">Duda</option>
                                    <option value="Janda">Janda</option>
                                </select>
                                @error('status_menikah')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Agama</label>
                            <div class="col-sm-2">
                                <select name="agama" class="form-control">
                                    <option value=""></option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katholik">Katholik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                                @error('agama')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Pendidikan</label>
                            <div class="col-sm-2">
                                <select name="pendidikan" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="Tidak Sekolah">Tidak Sekolah</option>
                                </select>
                                @error('pendidikan')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label">Pekerjaan</label>
                            <div class="col-sm-2">
                                <select name="pekerjaan" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="PNS">PNS</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="TNI/Polri">TNI/Polri</option>
                                    <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Guru/Pengajar">Guru/Pengajar</option>
                                    <option value="IRT">IRT</option>
                                    <option value="Lain-Lain">Lain-Lain</option>
                                </select>
                                @error('pendidikan')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat Lengkap</label>
                            <div class="col-sm-10">
                            
                                <textarea name="alamat_lengkap" class="form-control" rows="4">{{old('alamat_lengkap')}}</textarea>
                                @error('alamat_lengkap')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kelurahan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kelurahan" value="{{old('kelurahan')}}">
                                @error('kelurahan')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Kecamatan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kecamatan"  value="{{old('kecamatan')}}">
                                @error('kecamatan')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kabupaten</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kabupaten" value="{{old('kabupaten')}}">
                                @error('kabupaten')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Kodepos</label>
                            <div class="col-sm-4">
                                <input type="number" maxlength="5" class="form-control" name="kodepos" value="{{old('kodepos')}}">
                                @error('kodepos')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">No HP*</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="no_hp" required value="{{old('no_hp')}}">
                                @error('no_hp')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-3 col-form-label">Kewarganegaraan</label>
                            <div class="col-sm-3">
                                <div class="form-check">
                                    <input type="radio" name="kewarganegaraan" class="form-check-input" 
                                    value="WNI" checked>
                                    <label class="form-check-label">WNI</label>     
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="kewarganegaraan" class="form-check-input"
                                    value="WNA">
                                    <label class="form-check-label">WNA</label>   
                                </div>
                                @error('kewarganegaraan')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Layanan</label>
                            <div class="col-sm-4">
                                <div class="alert alert-success mb-0" role="alert">
                                    Layanan terapi gratis dan tidak dipungut biaya.
                                </div>
                            </div>
                            <label class="col-sm-2 col-form-label" id="no_bpjs_label">No. BPJS / KTP</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="no_bpjs" name="no_bpjs" value="{{old('no_bpjs')}}">
                                @error('no_bpjs')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Desil (DTKS/P3KE)</label>
                            <div class="col-sm-4">
                                <select name="desil" class="form-control" id="desil">
                                    <option value="">--Pilih Desil--</option>
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
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Alergi</label>
                            <div class="col-sm-4">
                                <input type="text" name="alergi" class="form-control" placeholder="Riwayat alergi jika ada" value="{{old('alergi')}}">
                                @error('alergi')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">File Kartu Keluarga (KK)</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-file" name="file_kk" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG, PDF (Maks. 10MB)</small>
                                @error('file_kk')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Surat Resume / Riwayat Berobat</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-file" name="file_resume" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG, PDF (Maks. 10MB) - Berkas rekam medis / resume berobat sebelumnya jika ada</small>
                                @error('file_resume')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
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
     $(function () {
       

        $("#nama").change(function(){
           checkedChard();

        });

        $("#code").change(function(){
            checkedChard();
        });
     });

     function checkedChard(){
        var nama_full = $("#nama").val();
        var code = $("#code").val();
        if(nama_full!="" && code!=""){
            var firstChar = nama_full.charAt(0);
            var awalCode = code+firstChar;
            $("#no_rm").val(awalCode);
            $.get(
                "{{ route('getNoRM') }}",
                {
                    code: awalCode
                },
                function(data) {
                    $("#no_rm").val(data.data);
                }
            );
        }
     }
</script>
@endsection
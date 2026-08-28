@extends('layout.apps')
@section('content')

<!-- Header Section -->
<div class="mr-auto mb-3">
    <h2 class="font-w700 text-primary" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">Tambah Rekam Medis Baru</h2>
    <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 4px; font-size: 12.5px;">
        <li class="breadcrumb-item"><a href="{{Route('rekam')}}">Data Rekam Medis</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Rekam Medis</a></li>
    </ol>
</div>

<!-- Modal Pencarian Pasien -->
<div class="modal fade" id="modalPasien" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 1px solid #edf2f7; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-w700" style="color: var(--ot-navy) !important; font-size: 16px;">
                    <i class="fa fa-users text-primary mr-2"></i> Pilih Data Penerima Manfaat
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive card-table"> 
                    <table class="table table-bordered table-striped" style="width: 100%; font-size: 12.5px;" id="pasien-table">
                        <thead class="bg-light">
                            <tr style="color: #1e293b;">
                                <th style="width: 8%; text-align: center;">Pilih</th>
                                <th style="width: 18%;">No. RM</th>
                                <th style="width: 32%;">Nama Penerima Manfaat</th>
                                <th style="width: 14%;">Tgl Lahir</th>
                                <th style="width: 14%;">No. HP</th>
                                <th style="width: 14%;">No BPJS/KTP</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-body p-4">
                <div class="basic-form">
                    <form action="{{Route('rekam.store')}}" method="POST">
                        {{ csrf_field() }}
                        
                        <!-- BAGIAN 1: INFORMASI KUNJUNGAN & PENERIMA MANFAAT -->
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-calendar-check-o text-primary mr-2"></i> 1. Informasi Kunjungan & Penerima Manfaat
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Tanggal Periksa <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="date" name="tgl_rekam" class="form-control" value="{{old('tgl_rekam', date('Y-m-d'))}}" style="height: 40px; font-size: 13px;" required>
                                @error('tgl_rekam')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Penerima Manfaat <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="pasien_id" name="pasien_id" value="{{old('pasien_id')}}">
                                <div class="input-group">
                                    <input type="text" id="pasien_nama" class="form-control font-w600"
                                      data-toggle="modal" data-target="#modalPasien" value="{{old('pasien_nama') ? old('pasien_nama') : ''}}"
                                      name="pasien_nama" readonly style="background-color: #fff; cursor: pointer; height: 40px; font-size: 13px;" placeholder="Klik untuk mencari dan memilih penerima manfaat...">
                                    <div class="input-group-append" data-toggle="modal" data-target="#modalPasien">
                                        <button class="btn btn-primary" type="button" style="height: 40px; font-size: 13px; font-weight: 600; padding: 0 16px;"> 
                                            <i class="fa fa-search mr-1"></i> Cari Pasien
                                        </button>
                                    </div>
                                </div>
                                @error('pasien_id')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                                @error('pasien_nama')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Summary Card Ringkasan Pasien Otomatis -->
                        <div class="form-group row mb-2">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <div id="patientSummaryCard" class="card border-primary mb-3" style="display: none; background: #f8fbff; border: 1px solid #b8daff; border-left: 5px solid #2e4b82; box-shadow: 0 3px 10px rgba(46,75,130,0.08); border-radius: 8px;">
                                    <div class="card-body py-3 px-4">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <span class="badge badge-primary font-w600 mr-2 mb-1 py-1 px-2" style="font-size: 12.5px;" id="sumNoRm">No. RM: -</span>
                                                <span class="badge badge-success font-w600 mr-2 mb-1 py-1 px-2" style="font-size: 12.5px;" id="sumKategori">Kategori: -</span>
                                                <h5 class="mb-1 text-black font-w700" id="sumNama" style="font-size: 15.5px; color: #1e293b;">-</h5>
                                            </div>
                                            <button type="button" class="btn btn-xs btn-outline-primary shadow-sm" data-toggle="modal" data-target="#modalPasien" style="font-size: 11.5px; font-weight: 600; border-radius: 4px;">
                                                <i class="fa fa-refresh mr-1"></i> Ganti Pasien
                                            </button>
                                        </div>
                                        <div class="row pt-2" style="border-top: 1px dashed #cbd5e1;">
                                            <div class="col-md-4 col-sm-6 mb-2">
                                                <small class="text-muted d-block font-w600" style="font-size: 11.5px;"><i class="fa fa-user-circle text-primary mr-1"></i> Kontak / Wali Pasien:</small>
                                                <span class="text-black font-w600" style="font-size: 13px;" id="sumWali">-</span>
                                            </div>
                                            <div class="col-md-4 col-sm-6 mb-2">
                                                <small class="text-muted d-block font-w600" style="font-size: 11.5px;"><i class="fa fa-wheelchair text-primary mr-1"></i> Jenis Disabilitas:</small>
                                                <span class="badge badge-info light font-w600" style="font-size: 12px;" id="sumDisabilitas">-</span>
                                            </div>
                                            <div class="col-md-4 col-sm-6 mb-2">
                                                <small class="text-muted d-block font-w600" style="font-size: 11.5px;"><i class="fa fa-info-circle text-primary mr-1"></i> Alat Bantu / Desil:</small>
                                                <span class="text-black font-w500" style="font-size: 12.5px;" id="sumExtra">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alert info pendaftaran jika belum terdaftar -->
                        <div class="form-group row mb-4">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <div class="alert alert-light py-2 px-3 mb-0 d-flex align-items-center justify-content-between" style="border-radius: 8px; border: 1px dashed #cbd5e1; background-color: #f8fafc; font-size: 12.5px;">
                                    <span class="text-muted">
                                        <i class="fa fa-info-circle text-primary mr-1"></i> Penerima manfaat belum terdaftar di sistem?
                                    </span>
                                    <a href="{{Route('penerima-manfaat.add')}}" class="font-w700 text-primary" style="font-size: 12.5px;">
                                        <i class="fa fa-user-plus mr-1"></i> + Tambah Penerima Manfaat Baru
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN 2: LAYANAN TERAPI & PENUGASAN TERAPIS -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-stethoscope text-primary mr-2"></i> 2. Layanan Terapi & Penugasan Terapis
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Layanan Terapi <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="layanan_terapi" id="layanan_terapi" class="form-control" required style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Jenis Layanan Terapi yang Dituju--</option>
                                    <option value="Fisioterapi" {{ old('layanan_terapi') == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                                    <option value="Terapi Okupasi / Sensorik Integrasi" {{ old('layanan_terapi') == 'Terapi Okupasi / Sensorik Integrasi' ? 'selected' : '' }}>Terapi Okupasi / Sensorik Integrasi</option>
                                    <option value="Terapi Wicara" {{ old('layanan_terapi') == 'Terapi Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                                    <option value="Terapi Netra (Orientasi & Mobilitas)" {{ old('layanan_terapi') == 'Terapi Netra (Orientasi & Mobilitas)' ? 'selected' : '' }}>Terapi Netra (Orientasi & Mobilitas)</option>
                                </select>
                                @error('layanan_terapi')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Omah Terapiku <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="poli" id="poli" class="form-control" required style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Omah Terapiku--</option>
                                    @foreach ($poli as $item)
                                        @if (old('poli') == $item->nama)
                                            <option value="{{$item->nama}}" selected>{{$item->nama}}</option>
                                        @else 
                                            <option value="{{$item->nama}}">{{$item->nama}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('poli')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Terapis / Dokter <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="dokter_id" id="dokter_id" class="form-control" required style="height: 40px; font-size: 13px;">
                                    <option value="">--Pilih Terapis / Dokter--</option>
                                </select>
                                @error('dokter_id')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 3: ANAMNESA & KELUHAN -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="text-primary font-w700 mb-0" style="color: var(--ot-navy) !important; font-size: 15px;">
                                <i class="fa fa-commenting-o text-primary mr-2"></i> 3. Anamnesa & Keluhan Awal
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-w600" style="font-size: 13px;">Anamnesa / Keluhan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <textarea name="keluhan" required class="form-control" rows="4" placeholder="Tuliskan keluhan utama, kondisi fisik, atau hasil anamnesa awal pasien..." style="font-size: 13px;">{{old('keluhan')}}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- TOMBOL AKSI SIMPAN -->
                        <div class="d-flex align-items-center justify-content-between pt-3 mt-4" style="border-top: 1px solid #edf2f7;">
                            <a href="{{Route('rekam')}}" class="btn btn-sm btn-light" style="padding: 8px 18px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
                                <i class="fa fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 24px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                <i class="fa fa-save mr-1"></i> Simpan Rekam Medis
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
    $(function () {
        var table = $('#pasien-table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            select: false,
            pageLength: 5,
            lengthChange: false,
            ajax: "{{ route('penerima-manfaat.json') }}",
            columns: [
                {data: 'action', name: 'action'},
                {data: 'no_rm', name: 'no_rm'},
                {data: 'nama', name: 'nama'},
                {data: 'tgl_lahir', name: 'tgl_lahir'},
                {data: 'no_hp', name: 'no_hp'},
                {data: 'no_bpjs', name: 'no_bpjs'}
            ]
        });
    });

    $(document).ready(function() {
        $("#poli").change(function(e) {
            var poli = $("#poli").val();
            if (poli == '') {
                $("#dokter_id").html('<option value="">--Pilih Terapis / Dokter--</option>');
                return false;
            }
            $.get(
                "{{ route('getDokter') }}",
                {
                    poli: poli
                },
                function(data) {
                    var string = '<option value="">--Pilih Terapis / Dokter--</option>';
                    $.each(data.data, function(index, value) {
                        string = string + `<option value="` + value.id + `">` + value.nama + `</option>`;
                    });
                    $("#dokter_id").html(string);
                }
            );
        });
    });

    $(document).on("click", ".pilihPasien", function () {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var no = $(this).data('no');
        var nohp = $(this).data('nohp');
        var tgllahir = $(this).data('tgllahir');
        var kategori = $(this).data('kategori') || 'Dewasa';
        var namawali = $(this).data('namawali');
        var hubunganwali = $(this).data('hubunganwali');
        var disabilitas = $(this).data('disabilitas') || 'Tidak Ada';
        var alatbantu = $(this).data('alatbantu') || 'Tidak Ada';
        var desil = $(this).data('desil');

        $("#pasien_nama").val(nama);
        $("#pasien_id").val(id);

        // Update Summary Card
        $("#sumNoRm").text("RM# " + no);
        $("#sumKategori").text(kategori);
        if (kategori === 'Anak') {
            $("#sumKategori").removeClass('badge-secondary').addClass('badge-success');
        } else {
            $("#sumKategori").removeClass('badge-success').addClass('badge-secondary');
        }
        $("#sumNama").text(nama);

        var waliText = '';
        if (namawali) {
            waliText = namawali + (hubunganwali ? ' (' + hubunganwali + ')' : '') + (nohp ? ' - ' + nohp : '');
        } else {
            waliText = (nohp ? 'HP: ' + nohp : '-');
        }
        $("#sumWali").text(waliText);

        $("#sumDisabilitas").text(disabilitas);

        var extraText = (alatbantu !== 'Tidak Ada' && alatbantu ? alatbantu : 'Tanpa alat bantu');
        if (desil) {
            extraText += ' | ' + desil;
        }
        $("#sumExtra").text(extraText);

        $("#patientSummaryCard").slideDown();
        $("#modalPasien").modal('hide');
        
        toastr.success("Pasien " + nama + " (" + no + ") telah dipilih", "Sukses", {timeOut: 3000});
    });
</script>
@endsection
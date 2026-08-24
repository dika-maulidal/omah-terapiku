@extends('layout.apps')
@section('content')
<div class="form-head align-items-center d-flex mb-sm-4 mb-3">
    <div class="mr-auto">
        <h2 class="text-black font-w600">Rekam Medis Baru</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{Route('penerima-manfaat')}}">Rekam Medis</a></li>
            <li class="breadcrumb-item active"><a href="#">Tambah Pasien Periksa</a></li>
        </ol>
    </div>
</div>

<!-- Pencarian Pasien -->
<div class="modal fade" id="modalPasien">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Pasien</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive card-table"> 
                    <table class="display white-border table-responsive-sm"
                            style="width: 100%"
                        id="pasien-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. RM</th>
                                <th>Nama Penerima Manfaat</th>
                                <th>Tgl Lahir</th>
                                <th>No. HP</th>
                                <th>Status Layanan</th>
                                <th>No BPJS/KTP</th>
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
        <div class="card">
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{Route('rekam.update',$data->id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">No Periksa*</label>
                            <div class="col-sm-4">
                                <input type="text" name="no_rekam" class="form-control" readonly
                                value="{{$data->no_rekam}}">
                                @error('no_rekam')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Tanggal Periksa*</label>
                            <div class="col-sm-4">
                                <input type="date" name="tgl_rekam" class="form-control" 
                                value="{{$data->tgl_rekam}}">
                                @error('tgl_rekam')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Penerima Manfaat*</label>
                            <div class="col-sm-5">
                                <input type="hidden" class="form-control" id="pasien_id"
                                name="pasien_id" value="{{$data->pasien_id}}">
                                <div class="input-group transparent-append">
                                    <input type="text" id="pasien_nama" class="form-control"
                                      data-toggle="modal" data-target="#modalPasien" value="{{$data->pasien->nama ?? ''}}"
                                     name="pasien_nama" placeholder="Pilih Pasien..">
                                    <div class="input-group-append show-pass" data-toggle="modal" data-target="#modalPasien">
                                        <span class="input-group-text"> 
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalPasien"><i class="fa fa-search"></i></a>
                                        </span>
                                    </div>
                                </div>
                                @error('pasien_id')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Layanan</label>
                            <div class="col-sm-3">
                                <div class="alert alert-success mb-0" role="alert">
                                    Gratis, tidak dipungut biaya.
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <div class="alert alert-warning left-icon-big alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-help-circle-outline"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <p class="mb-0"><i>Jika nama penerima manfaat belum tersedia, silahkan lakukan tambah data dulu.</i>
                                                <a href="{{Route('penerima-manfaat.add')}}"> klik disini !!</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Anemnesa / <br>Keluhan*</label>
                            <div class="col-sm-10">
                                <textarea name="keluhan" required class="form-control"
                                rows="4">{{$data->keluhan}}</textarea>
                                @error('keluhan')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Omah Terapiku Tujuan*</label>
                            <div class="col-sm-4">
                                <select name="poli" id="poli" class="form-control" required>
                                    <option value="">--Pilih Omah Terapiku--</option>
                                    @foreach ($poli as $item)
                                        <option value="{{$item->nama}}" {{$data->poli == $item->nama ? 'selected' : ''}}>{{$item->nama}}</option>
                                    @endforeach
                                </select>
                                @error('poli')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label">Pilih Dokter*</label>
                            <div class="col-sm-4">
                                <select name="dokter_id" id="dokter_id" class="form-control" required>
                                    <option value="">--Pilih Dokter--</option>
                                    @if(isset($data->dokter))
                                        <option value="{{$data->dokter_id}}" selected>{{$data->dokter->nama}}</option>
                                    @endif
                                </select>
                                @error('dokter_id')
                                <div class="invalid-feedback animated fadeInUp"
                                style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                       
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">UPDATE</button>
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
                {data: 'cara_bayar', name: 'cara_bayar'},
                {data: 'no_bpjs', name: 'no_bpjs'}              
            ]
        });
    });

    $(document).ready(function() {
        function loadDokter(selectedDokterId = null) {
            var poli = $("#poli").val();
            if (!poli) {
                $("#dokter_id").html('<option value="">--Pilih Dokter--</option>');
                return;
            }

            $.get("{{ route('getDokter') }}", { poli: poli }, function(response) {
                var string = '<option value="">--Pilih Dokter--</option>';
                var listDokter = response.data ? response.data : response;

                $.each(listDokter, function(index, value) {
                    var isSelected = (selectedDokterId && selectedDokterId == value.id) ? 'selected' : '';
                    string += `<option value="${value.id}" ${isSelected}>${value.nama}</option>`;
                });

                $("#dokter_id").html(string);
            });
        }

        // Trigger saat Poli diubah
        $("#poli").on("change", function() {
            loadDokter();
        });

        // Trigger otomatis saat pertama kali dibuka untuk mengambil daftar dokter di poli tersebut
        var initialDokterId = "{{ $data->dokter_id }}";
        if ($("#poli").val() !== '') {
            loadDokter(initialDokterId);
        }
    });

    $(document).on("click", ".pilihPasien", function () {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var no = $(this).data('no');
        var metode = $(this).data('metode');
        $("#pasien_nama").val(nama);
        $("#pasien_id").val(id);
        $("#cara_bayar").val(metode).change();

        $("#modalPasien").modal('hide');
        toastr.success("Pasien " + nama + " telah dipilih", "Sukses", {timeOut: 3000});
    });
</script>
@endsection
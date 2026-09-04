@extends('layout.apps')

@section('style')
<style>
/* Patient Search Input Group - 100% Seamless Flat Connection, Zero Gap, Zero Curve */
.patient-search-input-group {
    display: flex !important;
    flex-direction: row !important;
    align-items: stretch !important;
    width: 100% !important;
    height: 44px !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    background: #ffffff !important;
    padding: 0 !important;
    margin: 0 !important;
    box-sizing: border-box !important;
    cursor: pointer !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
}
.patient-search-input-group:hover,
.patient-search-input-group:focus-within {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15) !important;
}
.patient-search-input-group .patient-search-input,
.patient-search-input-group input,
.patient-search-input-group input#pasien_nama {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    width: 100% !important;
    height: 100% !important;
    min-height: 100% !important;
    border: none !important;
    border-radius: 0 !important;
    background: transparent !important;
    background-color: transparent !important;
    box-shadow: none !important;
    outline: none !important;
    padding: 0 16px !important;
    margin: 0 !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #1e293b !important;
    cursor: pointer !important;
    transform: none !important;
    -webkit-appearance: none !important;
    appearance: none !important;
}
.patient-search-input-group .patient-search-input::placeholder,
.patient-search-input-group input::placeholder {
    color: #94a3b8 !important;
    font-weight: 400 !important;
}
.patient-search-input-group .patient-search-btn,
.patient-search-input-group button {
    flex-shrink: 0 !important;
    height: 100% !important;
    min-height: 100% !important;
    border: none !important;
    border-radius: 0 !important;
    margin: 0 !important;
    padding: 0 20px !important;
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
    background-color: #2563eb !important;
    color: #ffffff !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    white-space: nowrap !important;
    box-shadow: none !important;
    transform: none !important;
    outline: none !important;
    cursor: pointer !important;
    -webkit-appearance: none !important;
    appearance: none !important;
    transition: background 0.2s ease !important;
}
.patient-search-input-group .patient-search-btn:hover,
.patient-search-input-group button:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
    background-color: #1d4ed8 !important;
    color: #ffffff !important;
    transform: none !important;
    box-shadow: none !important;
}
.patient-search-input-group .patient-search-btn:active,
.patient-search-input-group button:active,
.patient-search-input-group .patient-search-btn:focus,
.patient-search-input-group button:focus {
    transform: none !important;
    box-shadow: none !important;
    outline: none !important;
}
.patient-search-input-group button::before,
.patient-search-input-group button::after {
    display: none !important;
    content: none !important;
}
#modalPasien .dataTables_wrapper .dataTables_filter input {
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 6px 12px !important;
    font-size: 12.5px !important;
    outline: none !important;
    transition: all 0.2s ease !important;
}
#modalPasien .dataTables_wrapper .dataTables_filter input:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
}
#modalPasien .table tbody tr {
    transition: background-color 0.15s ease;
}
#modalPasien .table tbody tr:hover {
    background-color: #f0f7ff !important;
}
</style>
@endsection

@section('content')

<!-- Header Section (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Edit Data Rekam Medis</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{Route('rekam')}}" style="color: #2563eb;">Data Rekam Medis</a></li>
                        <li class="breadcrumb-item active text-muted">Edit: {{ $data->pasien->nama ?? 'Rekam Medis' }} (RM# {{ $data->pasien->no_rm ?? '-' }})</li>
                    </ol>
                </div>
            </div>
            <div>
                <a href="{{Route('rekam')}}" class="btn btn-sm btn-light font-w600" style="border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; padding: 7px 14px;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pencarian Pasien Sesuai DESIGN.md -->
<div class="modal fade" id="modalPasien" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #dbeafe; box-shadow: 0 12px 36px rgba(30, 64, 175, 0.12); overflow: hidden;">
            
            <!-- Modal Header (Royal Blue Gradient & Soft Blue Accent) -->
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 42px; height: 42px; border-radius: 10px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 18px; border: 1px solid #bfdbfe; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1);">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" style="color: #1e40af !important; font-size: 16px;">
                            Pilih Data Penerima Manfaat
                        </h5>
                        <small class="text-muted font-w500" style="font-size: 11.5px;">Cari dan pilih penerima manfaat untuk sesi rekam medis terapi</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4" style="background: #ffffff;">
                <div class="alert alert-light mb-3 d-flex align-items-center justify-content-between flex-wrap py-2.5 px-3" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; font-size: 12px; gap: 8px;">
                    <div class="text-muted">
                        <i class="fa-solid fa-circle-info text-primary mr-1"></i> Gunakan kolom pencarian untuk mencari berdasarkan <strong>Nama, No. RM, NIK, atau No. HP</strong>.
                    </div>
                    <a href="{{Route('penerima-manfaat.add')}}" target="_blank" class="font-w700 text-primary" style="font-size: 12px; text-decoration: none;">
                        <i class="fa-solid fa-user-plus mr-1"></i> Tambah Penerima Manfaat Baru
                    </a>
                </div>

                <div class="table-responsive card-table" style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;"> 
                    <table class="table table-hover mb-0" style="width: 100%; font-size: 12.5px;" id="pasien-table">
                        <thead style="background: #eff6ff; border-bottom: 2px solid #bfdbfe;">
                            <tr style="color: #1e40af; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px;">
                                <th style="width: 8%; text-align: center; vertical-align: middle;">Pilih</th>
                                <th style="width: 18%; vertical-align: middle;">No. RM</th>
                                <th style="width: 32%; vertical-align: middle;">Nama Penerima Manfaat</th>
                                <th style="width: 14%; vertical-align: middle;">Tgl Lahir / Usia</th>
                                <th style="width: 14%; vertical-align: middle;">No. HP / Wali</th>
                                <th style="width: 14%; vertical-align: middle;">No BPJS / NIK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer px-4 py-2.5" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border-radius: 6px; padding: 6px 14px; border: 1px solid #cbd5e1; color: #475569;">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                <div class="basic-form">
                    <form action="{{Route('rekam.update', $data->id)}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="no_rekam" value="{{$data->no_rekam}}">
                        
                        <!-- BAGIAN: INFORMASI KUNJUNGAN & PENERIMA MANFAAT -->
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 15px;">
                                <i class="fa-solid fa-calendar-check mr-2" style="color: #2563eb;"></i> Informasi Kunjungan & Penerima Manfaat
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">No. Rekam Medis</label>
                                <div class="d-flex align-items-center" style="height: 44px; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 0 12px;">
                                    <i class="fa-solid fa-id-card mr-2" style="color: #2563eb; font-size: 15px;"></i>
                                    <input type="text" class="font-w700" readonly value="{{ $data->pasien->no_rm ?? $data->no_rekam }}" style="background: transparent; border: none; outline: none; box-shadow: none; color: #1e40af; font-size: 13.5px; width: 100%; letter-spacing: 0.5px; padding: 0;">
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Tanggal Periksa <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_rekam" class="form-control" value="{{old('tgl_rekam', $data->tgl_rekam)}}" style="height: 44px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;" required>
                                @error('tgl_rekam')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Penerima Manfaat <span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" id="pasien_id" name="pasien_id" value="{{$data->pasien_id}}">
                                
                                <!-- Seamless Unified Patient Search Input Group (100% Nyatu Tanpa Celah / Gap Melengkung) -->
                                <div class="patient-search-input-group" data-toggle="modal" data-target="#modalPasien">
                                    <input type="text" id="pasien_nama" class="patient-search-input font-w600"
                                      value="{{$data->pasien->nama ?? ''}}"
                                      name="pasien_nama" readonly placeholder="Klik untuk memilih penerima manfaat...">
                                    <button class="patient-search-btn font-w700" type="button"> 
                                        <i class="fa-solid fa-magnifying-glass mr-1"></i> Ganti Pasien
                                    </button>
                                </div>
                                @error('pasien_id')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <!-- Summary Card Ringkasan Pasien -->
                            @php
                                $pasien = $data->pasien;
                                $kategoriPasien = $pasien ? $pasien->kategori_usia : 'Dewasa';
                                $waliInfo = '-';
                                if ($pasien) {
                                    if ($pasien->nama_wali) {
                                        $waliInfo = $pasien->nama_wali . ($pasien->hubungan_wali ? ' (' . $pasien->hubungan_wali . ')' : '') . ($pasien->no_hp ? ' - ' . $pasien->no_hp : '');
                                    } else {
                                        $waliInfo = ($pasien->no_hp ? 'HP: ' . $pasien->no_hp : '-');
                                    }
                                }
                                $extraInfo = ($pasien && $pasien->alat_bantu && $pasien->alat_bantu !== 'Tidak Ada' ? $pasien->alat_bantu : 'Tanpa alat bantu');
                                if ($pasien && $pasien->desil) {
                                    $extraInfo .= ' | ' . $pasien->desil;
                                }
                            @endphp
                            <div class="col-12 mb-3">
                                <div id="patientSummaryCard" class="card mb-2" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 5px solid #16a34a; box-shadow: 0 3px 10px rgba(22, 163, 74, 0.08); border-radius: 8px;">
                                    <div class="card-body py-3 px-4">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                                                <span class="badge badge-primary font-w600 py-1 px-2" style="font-size: 12px; border-radius: 4px;" id="sumNoRm">RM# {{ $pasien->no_rm ?? '-' }}</span>
                                                <span class="badge badge-success font-w600 py-1 px-2" style="font-size: 12px; border-radius: 4px;" id="sumKategori">Kategori: {{ $kategoriPasien }}</span>
                                                <h5 class="mb-0 text-dark font-w700" id="sumNama" style="font-size: 15px;">{{ $pasien->nama ?? '-' }}</h5>
                                            </div>
                                            <button type="button" class="btn btn-xs btn-outline-primary font-w600" data-toggle="modal" data-target="#modalPasien" style="font-size: 11.5px; border-radius: 6px;">
                                                <i class="fa-solid fa-rotate mr-1"></i> Ganti Pasien
                                            </button>
                                        </div>
                                        <div class="row pt-2" style="border-top: 1px dashed #cbd5e1;">
                                            <div class="col-md-4 col-sm-6 mb-2">
                                                <small class="text-muted d-block font-w600" style="font-size: 11.5px;"><i class="fa-solid fa-user-group text-primary mr-1"></i> Kontak / Wali Pasien:</small>
                                                <span class="text-dark font-w600" style="font-size: 13px;" id="sumWali">{{ $waliInfo }}</span>
                                            </div>
                                            <div class="col-md-4 col-sm-6 mb-2">
                                                <small class="text-muted d-block font-w600" style="font-size: 11.5px;"><i class="fa-solid fa-wheelchair text-primary mr-1"></i> Jenis Disabilitas:</small>
                                                <span class="badge badge-info light font-w600" style="font-size: 11.5px;" id="sumDisabilitas">{{ $pasien->jenis_disabilitas ?: 'Umum' }}</span>
                                            </div>
                                            <div class="col-md-4 col-sm-6 mb-2">
                                                <small class="text-muted d-block font-w600" style="font-size: 11.5px;"><i class="fa-solid fa-circle-info text-primary mr-1"></i> Alat Bantu / Desil:</small>
                                                <span class="text-dark font-w500" style="font-size: 12.5px;" id="sumExtra">{{ $extraInfo }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN: LAYANAN TERAPI, JADWAL SESI & PENUGASAN TERAPIS -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 15px;">
                                <i class="fa-solid fa-stethoscope mr-2" style="color: #2563eb;"></i> Layanan Terapi, Jadwal Sesi & Penugasan Terapis
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Omah Terapi / Lokasi UPT <span class="text-danger">*</span></label>
                                <select name="poli" id="poli" class="form-control" required style="height: 44px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                                    <option value="">--Pilih Omah Terapiku--</option>
                                    @foreach ($poli as $item)
                                        <option value="{{$item->nama}}" {{ old('poli', $data->poli) == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                                    @endforeach
                                </select>
                                @error('poli')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            @php $currentTerapi = old('layanan_terapi', $data->layanan_terapi); @endphp
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Jenis Layanan Terapi <span class="text-danger">*</span></label>
                                <select name="layanan_terapi" id="layanan_terapi" class="form-control" required style="height: 44px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                                    <option value="">--Pilih Jenis Layanan Terapi--</option>
                                    <option value="Fisioterapi" {{ $currentTerapi == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                                    <option value="Terapi Okupasi / Sensorik Integrasi" {{ $currentTerapi == 'Terapi Okupasi / Sensorik Integrasi' ? 'selected' : '' }}>Terapi Okupasi / Sensorik Integrasi</option>
                                    <option value="Terapi Wicara" {{ $currentTerapi == 'Terapi Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                                    <option value="Terapi Netra (Orientasi & Mobilitas)" {{ $currentTerapi == 'Terapi Netra (Orientasi & Mobilitas)' ? 'selected' : '' }}>Terapi Netra (Orientasi & Mobilitas)</option>
                                </select>
                                @error('layanan_terapi')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Terapis Pemeriksa <span class="text-danger">*</span></label>
                                <select name="dokter_id" id="dokter_id" class="form-control" required style="height: 44px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                                    <option value="">--Pilih Terapis--</option>
                                    @if(isset($data->dokter))
                                        <option value="{{$data->dokter_id}}" selected>{{$data->dokter->nama}}</option>
                                    @endif
                                </select>
                                @error('dokter_id')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">
                                    Jadwal Sesi Terapi <small class="text-muted font-w400">(Rabu, 30-45 mnt)</small>
                                </label>
                                @php $currentSesi = old('sesi_waktu', $data->sesi_waktu); @endphp
                                <select name="sesi_waktu" class="form-control" style="height: 44px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                                    <option value="">--Pilih Slot Sesi Waktu--</option>
                                    <option value="Sesi 1 (08.00 - 08.45 WIB)" {{ $currentSesi == 'Sesi 1 (08.00 - 08.45 WIB)' ? 'selected' : '' }}>Sesi 1 (08.00 - 08.45 WIB)</option>
                                    <option value="Sesi 2 (08.45 - 09.30 WIB)" {{ $currentSesi == 'Sesi 2 (08.45 - 09.30 WIB)' ? 'selected' : '' }}>Sesi 2 (08.45 - 09.30 WIB)</option>
                                    <option value="Sesi 3 (09.30 - 10.15 WIB)" {{ $currentSesi == 'Sesi 3 (09.30 - 10.15 WIB)' ? 'selected' : '' }}>Sesi 3 (09.30 - 10.15 WIB)</option>
                                    <option value="Sesi 4 (10.15 - 11.00 WIB)" {{ $currentSesi == 'Sesi 4 (10.15 - 11.00 WIB)' ? 'selected' : '' }}>Sesi 4 (10.15 - 11.00 WIB)</option>
                                    <option value="Sesi 5 (11.00 - 11.45 WIB)" {{ $currentSesi == 'Sesi 5 (11.00 - 11.45 WIB)' ? 'selected' : '' }}>Sesi 5 (11.00 - 11.45 WIB)</option>
                                    <option value="Sesi 6 (11.45 - 12.30 WIB)" {{ $currentSesi == 'Sesi 6 (11.45 - 12.30 WIB)' ? 'selected' : '' }}>Sesi 6 (11.45 - 12.30 WIB)</option>
                                    <option value="Sesi 7 (12.30 - 13.00 WIB)" {{ $currentSesi == 'Sesi 7 (12.30 - 13.00 WIB)' ? 'selected' : '' }}>Sesi 7 (12.30 - 13.00 WIB)</option>
                                    <option value="Sesi Khusus / Fleksibel" {{ $currentSesi == 'Sesi Khusus / Fleksibel' ? 'selected' : '' }}>Sesi Khusus / Fleksibel</option>
                                </select>
                            </div>
                        </div>

                        <!-- BAGIAN: ANAMNESA & KELUHAN -->
                        <div class="d-flex align-items-center mb-3 mt-4 pb-2" style="border-bottom: 2px solid #edf2f7;">
                            <h5 class="font-w700 mb-0" style="color: #1e40af !important; font-size: 15px;">
                                <i class="fa-solid fa-comment-dots mr-2" style="color: #2563eb;"></i> Anamnesa & Keluhan
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label font-w600 text-dark" style="font-size: 13px; margin-bottom: 6px;">Anamnesa / Keluhan Utama <span class="text-danger">*</span></label>
                                <textarea name="keluhan" required class="form-control" rows="4" placeholder="Tuliskan keluhan utama, kondisi fisik, atau hasil anamnesa..." style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; line-height: 1.6;">{{old('keluhan', $data->keluhan)}}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- TOMBOL AKSI UPDATE -->
                        <div class="d-flex align-items-center justify-content-between pt-3 mt-4" style="border-top: 1px solid #edf2f7;">
                            <a href="{{Route('rekam')}}" class="btn btn-sm btn-light font-w600" style="padding: 8px 18px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569;">
                                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 13px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                <i class="fa-solid fa-floppy-disk mr-1"></i> Update Rekam Medis
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
        function loadDokter(selectedDokterId = null) {
            var poli = $("#poli").val();
            if (!poli) {
                $("#dokter_id").html('<option value="">--Pilih Terapis--</option>');
                return;
            }

            $.get("{{ route('getDokter') }}", { poli: poli }, function(response) {
                var stringUtama = '<option value="">--Pilih Terapis--</option>';
                var listDokter = response.data ? response.data : response;

                $.each(listDokter, function(index, value) {
                    var isSelectedUtama = (selectedDokterId && selectedDokterId == value.id) ? 'selected' : '';
                    stringUtama += `<option value="${value.id}" ${isSelectedUtama}>${value.nama}</option>`;
                });

                $("#dokter_id").html(stringUtama);
            });
        }

        $("#poli").on("change", function() {
            loadDokter();
        });

        var initialDokterId = "{{ $data->dokter_id }}";
        if ($("#poli").val() !== '') {
            loadDokter(initialDokterId);
        }
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
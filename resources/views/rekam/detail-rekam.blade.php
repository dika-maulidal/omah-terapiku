@extends('layout.apps')
@section('content')

@include('rekam.partial.modal-pemeriksaan')
{{-- MODAL TINDAKAN --}}
@include('rekam.partial.modal-tindakan')
{{-- MODAL Diagnosa --}}
@include('rekam.partial.modal-diagnosa')

<!-- Header Section -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap: 12px;">
    <div>
        <h2 class="font-w700 text-primary mb-1" style="color: var(--ot-navy) !important; font-weight: 700; font-size: 22px;">
            Detail Penerima Manfaat
        </h2>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin-top: 2px; font-size: 12.5px;">
            <li class="breadcrumb-item"><a href="{{Route('penerima-manfaat')}}">Data Penerima Manfaat</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $pasien->nama }}</a></li>
        </ol>
    </div>
    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
        <a href="{{Route('penerima-manfaat')}}" class="btn btn-sm btn-light" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 6px;">
            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Pendaftaran")
            <a href="{{Route('penerima-manfaat.edit', $pasien->id)}}" class="btn btn-sm btn-info text-white shadow-sm" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
                <i class="fa fa-pencil mr-1"></i> Edit Data
            </a>
        @endif
        <a href="{{Route('rekam.add')}}" class="btn btn-sm btn-primary shadow-sm" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
            <i class="fa fa-plus mr-1"></i> Tambah Rekam Medis
        </a>
    </div>
</div>

<input type="hidden" id="pasien_id" value="{{$pasien->id}}">
<input type="hidden" id="rekam_id" value="{{$rekamLatest ? $rekamLatest->id : '' }}">

<!-- Top Profile & Information Cards -->
<div class="row">
    <!-- Profil Utama Penerima Manfaat -->
    <div class="col-xl-5 col-lg-5 col-md-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header pb-0 border-0 d-flex justify-content-between align-items-center">
                <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 6px 12px; border-radius: 6px;">
                    <i class="fa fa-id-card-o mr-1"></i> RM# {{$pasien->no_rm}}
                </span>
                @if ($rekamLatest)
                    <div>{!! $rekamLatest->status_display() !!}</div>
                @else
                    {!! $pasien->statusPasien() !!}
                @endif
            </div>
            <div class="card-body pt-3">
                <div class="d-flex align-items-start mb-3">
                    <div class="avatar-box mr-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #2e4b82 0%, #4a6fa5 100%); color: #fff; font-weight: 700; font-size: 20px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(46, 75, 130, 0.25);">
                        {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-w700 mb-1" style="font-size: 17px; color: #1e293b;">{{$pasien->nama}}</h4>
                        <div class="text-muted font-w500" style="font-size: 12.5px;">
                            <span class="text-primary font-w600">NIK:</span> {{ $pasien->nik ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="pt-2" style="border-top: 1px solid #edf2f7;">
                    @php
                        $b_day = $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir) : null;
                        $now = \Carbon\Carbon::now();
                        $usia = $b_day ? $b_day->diffInYears($now) . ' Tahun' : '-';
                    @endphp

                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px dashed #edf2f7; font-size: 13px;">
                        <span class="text-muted"><i class="fa fa-calendar-o mr-2 text-primary"></i>TTL / Usia</span>
                        <span class="font-w600 text-right" style="color: #334155;">
                            {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ?: '-' }} 
                            <small class="text-muted font-w600">({{ $usia }})</small>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px dashed #edf2f7; font-size: 13px;">
                        <span class="text-muted"><i class="fa fa-venus-mars mr-2 text-primary"></i>Jenis Kelamin</span>
                        <span class="font-w600" style="color: #334155;">{{ $pasien->jk ?: '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px dashed #edf2f7; font-size: 13px;">
                        <span class="text-muted"><i class="fa fa-heart-o mr-2 text-primary"></i>Status Menikah</span>
                        <span class="font-w600" style="color: #334155;">{{ $pasien->status_menikah ?: '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px dashed #edf2f7; font-size: 13px;">
                        <span class="text-muted"><i class="fa fa-graduation-cap mr-2 text-primary"></i>Pendidikan & Pekerjaan</span>
                        <span class="font-w600 text-right" style="color: #334155;">
                            {{ $pasien->pendidikan ?: '-' }} / {{ $pasien->pekerjaan ?: '-' }}
                        </span>
                    </div>

                    <div class="py-2" style="font-size: 13px;">
                        <span class="text-muted d-block mb-1"><i class="fa fa-map-marker mr-2 text-primary"></i>Alamat Domisili</span>
                        <p class="font-w600 mb-0 pl-3" style="color: #334155; font-size: 12.5px; line-height: 1.5;">
                            {{ $pasien->alamat_lengkap ?: '-' }}
                            @if ($pasien->kelurahan || $pasien->kecamatan || $pasien->kabupaten)
                                <br><small class="text-muted">{{ ($pasien->kelurahan ? 'Kel. ' . $pasien->kelurahan . ', ' : '') . ($pasien->kecamatan ? 'Kec. ' . $pasien->kecamatan . ', ' : '') . ($pasien->kabupaten ?: '') }}</small>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Sosial, Wali, Disabilitas & Berkas -->
    <div class="col-xl-7 col-lg-7 col-md-12 mb-4">
        <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header pb-0 border-0">
                <h5 class="font-w700 mb-0" style="font-size: 16px; color: var(--ot-navy) !important;">
                    <i class="fa fa-info-circle mr-2 text-primary"></i> Data Sosial & Berkas Pendukung
                </h5>
            </div>
            <div class="card-body pt-3">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <span class="text-muted d-block mb-1" style="font-size: 11.5px; font-weight: 600; text-transform: uppercase;">
                                <i class="fa fa-phone mr-1 text-primary"></i> No. HP / Kontak
                            </span>
                            <div class="font-w600" style="font-size: 13.5px; color: #1e293b;">
                                @if ($pasien->no_hp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pasien->no_hp)) }}" target="_blank" class="text-success">
                                        <i class="fa fa-whatsapp mr-1"></i> {{$pasien->no_hp}}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <span class="text-muted d-block mb-1" style="font-size: 11.5px; font-weight: 600; text-transform: uppercase;">
                                <i class="fa fa-bar-chart mr-1 text-primary"></i> Desil (DTKS/P3KE)
                            </span>
                            <div>
                                @if ($pasien->desil)
                                    <span class="badge badge-primary font-w600" style="font-size: 12px; padding: 4px 10px;">{{$pasien->desil}}</span>
                                @else
                                    <span class="text-muted font-w600" style="font-size: 13px;">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <span class="text-muted d-block mb-1" style="font-size: 11.5px; font-weight: 600; text-transform: uppercase;">
                                <i class="fa fa-user-circle-o mr-1 text-primary"></i> Wali / Orang Tua
                            </span>
                            <div class="font-w600" style="font-size: 13px; color: #1e293b;">
                                {{ $pasien->nama_wali ?: '-' }}
                                @if ($pasien->hubungan_wali)
                                    <br><small class="text-muted font-w500">Hubungan: {{ $pasien->hubungan_wali }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <span class="text-muted d-block mb-1" style="font-size: 11.5px; font-weight: 600; text-transform: uppercase;">
                                <i class="fa fa-wheelchair mr-1 text-primary"></i> Disabilitas & Alat Bantu
                            </span>
                            <div class="font-w600" style="font-size: 13px; color: #1e293b;">
                                @if ($pasien->jenis_disabilitas && $pasien->jenis_disabilitas != 'Tidak Ada')
                                    <span class="badge badge-info light font-w600 mb-1" style="font-size: 11.5px;">{{$pasien->jenis_disabilitas}}</span>
                                @else
                                    <span class="text-muted font-w500">Non-Disabilitas</span>
                                @endif
                                @if ($pasien->alat_bantu && $pasien->alat_bantu != 'Tidak Ada')
                                    <br><small class="text-muted font-w500"><i class="fa fa-cube mr-1"></i>Alat: {{$pasien->alat_bantu}}</small>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <span class="text-muted d-block mb-1" style="font-size: 11.5px; font-weight: 600; text-transform: uppercase;">
                                <i class="fa fa-address-card-o mr-1 text-primary"></i> No. BPJS / KIS
                            </span>
                            <div class="font-w600" style="font-size: 13px; color: #1e293b;">
                                {{ $pasien->no_bpjs ?: '-' }}
                            </div>
                        </div>

                        <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <span class="text-muted d-block mb-1" style="font-size: 11.5px; font-weight: 600; text-transform: uppercase;">
                                <i class="fa fa-folder-open-o mr-1 text-primary"></i> Berkas Pendukung
                            </span>
                            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                @if ($pasien->file_kk != null)
                                    <a class="btn btn-xs btn-info text-white shadow-sm" href="{{$pasien->getFileKk()}}" target="_blank" style="border-radius: 4px; font-size: 11.5px; padding: 4px 9px;">
                                        <i class="fa fa-file-image-o mr-1"></i> Lihat KK
                                    </a>
                                @else
                                    <span class="badge badge-light text-muted" style="font-size: 11px;">KK: Belum Ada</span>
                                @endif

                                @if ($pasien->file_resume != null)
                                    <a class="btn btn-xs btn-primary text-white shadow-sm" href="{{$pasien->getFileResume()}}" target="_blank" style="border-radius: 4px; font-size: 11.5px; padding: 4px 9px;">
                                        <i class="fa fa-file-text-o mr-1"></i> Resume Berobat
                                    </a>
                                @else
                                    <span class="badge badge-light text-muted" style="font-size: 11px;">Resume: Belum Ada</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section: Riwayat Rekam Medis Penerima Manfaat -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            <div class="card-header pb-0 border-0 d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                <h4 class="font-w700 mb-0" style="font-size: 18px; color: var(--ot-navy) !important;">
                    <i class="fa fa-history mr-2 text-primary"></i> Riwayat Terapi & Rekam Medis
                </h4>
                
                @if ($rekamLatest)
                    @if ($rekamLatest->status==1)
                        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Pendaftaran")
                            <a href="{{Route('rekam.status',[$rekamLatest->id,2])}}" class="btn btn-sm btn-primary shadow-sm" style="font-size: 12.5px; padding: 7px 16px; border-radius: 6px;">
                                Lanjutkan Ke Dokter <i class="fa fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    @elseif ($rekamLatest->status==2)
                        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Dokter")
                            <a href="{{Route('rekam.status',[$rekamLatest->id,3])}}" class="btn btn-sm btn-primary shadow-sm" style="font-size: 12.5px; padding: 7px 16px; border-radius: 6px;">
                                Selesaikan Pemeriksaan & Perawatan <i class="fa fa-check ml-1"></i>
                            </a>
                        @endif
                    @elseif ($rekamLatest->status==4 || $rekamLatest->status==3)
                        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Dokter")
                            <a href="{{Route('rekam.status',[$rekamLatest->id,5])}}" class="btn btn-sm btn-success shadow-sm text-white" style="font-size: 12.5px; padding: 7px 16px; border-radius: 6px;">
                                Selesaikan Rekam Medis Ini <i class="fa fa-check-circle ml-1"></i>
                            </a>
                        @endif
                    @endif
                @endif
            </div>

            <div class="card-body pt-3">
                <!-- Medical Records Table -->
                <div class="table-responsive"> 
                    <table class="table table-bordered table-striped" style="border-collapse: collapse; font-size: 13px;">
                        <thead class="bg-light">
                            <tr style="font-size: 12.5px; color: #1e293b;">
                                <th style="width: 4%; vertical-align: middle; text-align: center;">No</th>
                                <th style="width: 14%; vertical-align: middle;">Tgl & Layanan</th>
                                <th style="width: 14%; vertical-align: middle;">Terapis / Dokter</th>
                                <th style="width: 15%; vertical-align: middle;">Anamnesa (S)</th>
                                <th style="width: 16%; vertical-align: middle;">Pemeriksaan (O)</th>
                                <th style="width: 16%; vertical-align: middle;">Diagnosa ICD-10 (A)</th>
                                <th style="width: 16%; vertical-align: middle;">Tindakan / Plan (P)</th>
                                <th style="min-width: 180px; vertical-align: middle; text-align: center;">Aksi SOAP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($rekams) > 0)
                                @foreach ($rekams as $key=>$row)
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center; font-weight: 600;">{{ $rekams->firstItem() + $key }}</td>
                                        <td style="vertical-align: top;">
                                            <strong class="text-primary">{{$row->tgl_rekam}}</strong>
                                            @if ($row->layanan_terapi)
                                                <br><span class="badge badge-primary light font-w600 mt-1" style="font-size: 11px;">{{$row->layanan_terapi}}</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: top;">
                                            <strong style="color: #1e293b;">{{$row->dokter->nama ?? '-'}}</strong>
                                            <br><small class="text-muted"><i class="fa fa-hospital-o mr-1"></i>{{$row->poli}}</small>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <span class="badge badge-warning text-dark font-w600 mb-1" style="font-size: 10.5px;">S (Subjektif)</span>
                                            <div style="font-size: 12.5px; line-height: 1.4;">{{$row->keluhan ?: '-'}}</div>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <span class="badge badge-info font-w600 mb-1" style="font-size: 10.5px;">O (Objektif)</span>
                                            <div style="font-size: 12.5px; line-height: 1.4;">{!! $row->pemeriksaan ?: '<span class="text-muted">-</span>' !!}</div>
                                            @if ($row->pemeriksaan_file != null)
                                                <div class="mt-1">
                                                    <a target="_blank" href="{{$row->getFilePemeriksaan()}}" class="btn btn-xs btn-outline-info" style="font-size: 11px; padding: 2px 7px;">
                                                        <i class="fa fa-image mr-1"></i> Foto Pemeriksaan
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="vertical-align: top;">
                                            <span class="badge badge-danger font-w600 mb-1" style="font-size: 10.5px;">A (Assessment)</span>
                                            @if ($row->diagnosa() && count($row->diagnosa()) > 0)
                                                <ul class="list-unstyled mb-0" style="font-size: 12px;">
                                                    @foreach ($row->diagnosa() as $item)
                                                        <li class="mb-1 pb-1" style="border-bottom: 1px dashed #e2e8f0;">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <strong class="text-danger">{{$item->diagnosis->code}}</strong>
                                                                @if ($row->status <= 2)
                                                                    <a href="{{Route('rekam.diagnosa.delete', $item->id)}}" class="text-danger ml-1" title="Hapus Diagnosa">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="text-muted" style="font-size: 11.5px;">{{$item->diagnosis->name_id}}</div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="text-muted" style="font-size: 12px;">-</div>
                                            @endif
                                        </td>
                                        <td style="vertical-align: top;">
                                            <span class="badge badge-success font-w600 mb-1" style="font-size: 10.5px;">P (Plan)</span>
                                            <div style="font-size: 12.5px; line-height: 1.4;">{!! $row->tindakan ?: '<span class="text-muted">-</span>' !!}</div>
                                            @if ($row->tindakan_file != null)
                                                <div class="mt-1">
                                                    <a target="_blank" href="{{$row->getFileTindakan()}}" class="btn btn-xs btn-outline-success" style="font-size: 11px; padding: 2px 7px;">
                                                        <i class="fa fa-image mr-1"></i> Foto Tindakan
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle; text-align: center; white-space: nowrap;">
                                            @if ($row->status != 5 && $row->status != 4)
                                                <div class="d-inline-flex align-items-center justify-content-center flex-wrap" style="gap: 4px;">
                                                    @if (auth()->user()->role_display() == "Dokter" || auth()->user()->role_display() == "Admin")
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addPemeriksaan"
                                                           data-id="{{$row->id}}" data-tanggal="{{$row->tgl_rekam}}"
                                                           data-pemeriksaan="{{$row->pemeriksaan}}"
                                                           class="btn btn-info btn-xs addPemeriksaan shadow-sm" style="font-size: 11px; font-weight: 600; border-radius: 4px; padding: 4px 7px;" title="Pemeriksaan Fisik (O)">
                                                            <i class="fa fa-stethoscope mr-1"></i> (O) Fisik
                                                        </a>

                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addDiagnosa"
                                                           data-id="{{$row->id}}" data-tanggal="{{$row->tgl_rekam}}"
                                                           data-tindakan="{{$row->tindakan}}"
                                                           class="btn btn-primary btn-xs addDiagnosa shadow-sm" style="font-size: 11px; font-weight: 600; border-radius: 4px; padding: 4px 7px;" title="Diagnosa ICD-10 (A)">
                                                            <i class="fa fa-heartbeat mr-1"></i> (A) ICD
                                                        </a>

                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addTindakan"
                                                           data-id="{{$row->id}}" data-tanggal="{{$row->tgl_rekam}}"
                                                           data-tindakan="{{$row->tindakan}}"
                                                           class="btn btn-success btn-xs addTindakan shadow-sm text-white" style="font-size: 11px; font-weight: 600; border-radius: 4px; padding: 4px 7px;" title="Tindakan & Terapi (P)">
                                                            <i class="fa fa-medkit mr-1"></i> (P) Plan
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="badge badge-success light font-w600" style="font-size: 11px;">
                                                    <i class="fa fa-check-circle mr-1"></i> Selesai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <p class="mb-0 fs-13">Belum ada riwayat rekam medis / terapi untuk penerima manfaat ini.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Info -->
                <div class="d-flex align-items-center justify-content-between flex-wrap mt-3" style="font-size: 12.5px;">
                    <div class="text-muted mb-2">
                        Menampilkan {{$rekams->firstItem() ?? 0}} - {{$rekams->lastItem() ?? 0}} dari {{$rekams->total()}} data rekam medis
                    </div>
                    <div>
                        {{ $rekams->appends(request()->except('page'))->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>
<script>
    $(function () {
        var table = $('#icd-table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            select: false,
            pageLength: 5,
            lengthChange: false,
            ajax: "{{ route('icd.data') }}",
            columns: [
                {data: 'action', name: 'action'},
                {data: 'code', name: 'code'},
                {data: 'name_id', name: 'name_id'}
            ]
        });
    });
    
    CKEDITOR.addCss('.cke_editable p { margin: 0 !important; }');
    CKEDITOR.replace('editor', {
        height: '220px',
        filebrowserUploadMethod: 'form',
        toolbarGroups: [
            { name: 'document', groups: [ 'mode', 'document' ] },		
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },			
        ]
    });

    CKEDITOR.replace('editor2', {
        height: '220px',
        filebrowserUploadMethod: 'form',
        toolbarGroups: [
            { name: 'document', groups: [ 'mode', 'document' ] },		
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },			
        ]
    });

    CKEDITOR.replace('editor3', {
        height: '220px',
        filebrowserUploadMethod: 'form',
        toolbarGroups: [
            { name: 'document', groups: [ 'mode', 'document' ] },		
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },			
        ]
    });
   
    $(document).on("click", ".addPemeriksaan", function () {
        var rekamId = $(this).data('id');
        var pemeriksaan = $(this).data('pemeriksaan');
        $(".modal-body #rekamId").val( rekamId );
        if(pemeriksaan == "--" || !pemeriksaan){
            pemeriksaan = '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">'+
                    '<tbody>'+
                        '<tr><td style="width:20%">TD</td><td style="width:2%">:</td><td>&nbsp;</td></tr>'+
                        '<tr><td>Temp</td><td>:</td><td>&nbsp;</td></tr>'+
                        '<tr><td>Resp</td><td>:</td><td>&nbsp;</td></tr>'+
                        '<tr><td>Nadi</td><td>:</td><td>&nbsp;</td></tr>'+
                        '<tr><td>BB</td><td>:</td><td>&nbsp;</td></tr>'+
                    '</tbody>'+
                '</table>'+
                '<p>&nbsp;</p>';
        }
        CKEDITOR.instances.editor.setData( pemeriksaan );
    });

    $(document).on("click", ".pilihIcd", function () {
        var diagnosa_id = $(this).data('id');
        var rekam_id = $("#rekam_id").val();
        var pasien_id = $("#pasien_id").val();
        var token = '{{csrf_token()}}';
        $("#addDiagnosa").modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });   
        $.ajax({
           type: 'POST',
           url: "{{ route('diagnosa.update') }}",
           data: {rekam_id: rekam_id, pasien_id: pasien_id, diagnosa: diagnosa_id, _token: token},
           success: function(data){
                location.reload();
           }
        });
    });

    $(document).on("click", ".addTindakan", function () {
        var rekamId = $(this).data('id');
        var tindakan = $(this).data('tindakan');
        $(".modal-body #rekamId").val( rekamId );
        CKEDITOR.instances.editor2.setData( tindakan );
    });

    $(document).on("click", ".addDiagnosa", function () {
        var rekamId = $(this).data('id');
        var diagnosa = $(this).data('diagnosa');
        $(".modal-body #rekamId").val( rekamId );
        CKEDITOR.instances.editor.setData( diagnosa );
    });

    $(document).on("click", ".addResep", function () {
        var rekamId = $(this).data('id');
        var resep = $(this).data('resep');
        $(".modal-body #rekamId").val( rekamId );
        CKEDITOR.instances.editor3.setData( resep );
    });
</script>
@endsection
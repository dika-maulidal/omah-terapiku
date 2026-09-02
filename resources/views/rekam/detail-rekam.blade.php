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
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Pendaftaran")
            <a href="{{Route('penerima-manfaat.edit', $pasien->id)}}" class="btn btn-sm btn-info text-white shadow-sm" style="padding: 7px 14px; font-size: 12.5px; font-weight: 600; border-radius: 6px;">
                <i class="fa-solid fa-pencil mr-1"></i> Edit Data
            </a>
        @endif
        <a href="{{Route('rekam.add')}}" class="btn btn-sm btn-primary shadow-sm font-w600" style="padding: 7px 16px; font-size: 12.5px; border-radius: 6px;">
            <i class="fa-solid fa-circle-plus mr-1"></i> Input Sesi Terapi Baru
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
                    <i class="fa-solid fa-id-card mr-1"></i> RM# {{$pasien->no_rm}}
                </span>
                @if ($rekamLatest)
                    <div>{!! $rekamLatest->status_display() !!}</div>
                @else
                    {!! $pasien->statusPasien() !!}
                @endif
            </div>
            <div class="card-body pt-3">
                <div class="d-flex align-items-start mb-3">
                    <div class="avatar-box mr-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #2D4B7A 0%, #38A5DB 100%); color: #fff; font-weight: 700; font-size: 20px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(45, 75, 122, 0.25);">
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
                        <span class="text-muted"><i class="fa-solid fa-calendar mr-2 text-primary"></i>TTL / Usia</span>
                        <span class="font-w600 text-right" style="color: #334155;">
                            {{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir ?: '-' }} 
                            <small class="text-muted font-w600">({{ $usia }})</small>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px dashed #edf2f7; font-size: 13px;">
                        <span class="text-muted"><i class="fa-solid fa-venus-mars mr-2 text-primary"></i>Jenis Kelamin</span>
                        <span class="font-w600" style="color: #334155;">{{ $pasien->jk ?: '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px dashed #edf2f7; font-size: 13px;">
                        <span class="text-muted"><i class="fa-solid fa-heart mr-2 text-primary"></i>Status Menikah</span>
                        <span class="font-w600" style="color: #334155;">{{ $pasien->status_menikah ?: '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px dashed #edf2f7; font-size: 13px;">
                        <span class="text-muted"><i class="fa-solid fa-graduation-cap mr-2 text-primary"></i>Pendidikan & Pekerjaan</span>
                        <span class="font-w600 text-right" style="color: #334155;">
                            {{ $pasien->pendidikan ?: '-' }} / {{ $pasien->pekerjaan ?: '-' }}
                        </span>
                    </div>

                    <div class="py-2" style="font-size: 13px;">
                        <span class="text-muted d-block mb-1"><i class="fa-solid fa-location-dot mr-2 text-primary"></i>Alamat Domisili</span>
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

<!-- Card Ringkasan Sesi Terapi & Jadwal Kunjungan Terkini -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card mb-0" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #2D4B7A 0%, #1e355b 100%); color: #fff; box-shadow: 0 4px 20px rgba(45,75,122,0.18);">
            <div class="card-body p-4">
                @php
                    $activeRekam = $rekamLatest ?: ($rekams->first() ?: null);
                @endphp

                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 15px;">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 10px; background: rgba(255,255,255,0.15); backdrop-filter: blur(4px); flex-shrink: 0;">
                            <i class="fa-solid fa-calendar-check" style="font-size: 22px; color: #6ee7b7;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                <h5 class="text-white font-w700 mb-0" style="font-size: 16px;">Sesi Terapi & Jadwal Kunjungan Terkini</h5>
                                @if($rekamLatest)
                                    <span class="badge badge-warning font-w600" style="font-size: 11px;">Sesi Aktif Dalam Penanganan</span>
                                @elseif($activeRekam)
                                    <span class="badge badge-success font-w600" style="font-size: 11px;">Sesi Terakhir Tercatat</span>
                                @else
                                    <span class="badge badge-light text-muted font-w600" style="font-size: 11px;">Belum Ada Sesi Terdaftar</span>
                                @endif
                            </div>
                            <p class="text-white-50 mb-0" style="font-size: 12.5px;">
                                Informasi tanggal periksa, slot jadwal sesi terapi berkala, unit Omah Terapiku, serta terapis penanggung jawab.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        @if($activeRekam && (auth()->user()->role_display() == "Admin" || auth()->user()->role_display() == "Pendaftaran"))
                            <a href="{{ Route('rekam.edit', $activeRekam->id) }}" class="btn btn-xs btn-light font-w600 shadow-sm" style="padding: 6px 14px; border-radius: 6px; font-size: 12px;">
                                <i class="fa-solid fa-pen-to-square mr-1 text-primary"></i> Edit Sesi Ini
                            </a>
                        @endif
                        <a href="{{ Route('rekam.add') }}" class="btn btn-xs btn-info font-w600 text-white shadow-sm" style="padding: 6px 14px; border-radius: 6px; font-size: 12px;">
                            <i class="fa-solid fa-plus-circle mr-1"></i> + Input Sesi Terapi Baru
                        </a>
                    </div>
                </div>

                @if($activeRekam)
                    <div class="row mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.15);">
                        <div class="col-xl-3 col-md-6 col-12 mb-2">
                            <div class="p-3 rounded h-100" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                                <small class="text-white-50 d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">
                                    <i class="fa-solid fa-calendar-day mr-1 text-warning"></i> Tanggal Periksa / Kunjungan
                                </small>
                                <span class="font-w700 text-white d-block" style="font-size: 14.5px;">
                                    {{ \Carbon\Carbon::parse($activeRekam->tgl_rekam)->translatedFormat('l, d F Y') }}
                                </span>
                                <small class="text-white-50 d-block mt-1" style="font-size: 11px;">
                                    No. Registrasi: <span class="text-white font-w600">{{ $activeRekam->no_rekam }}</span>
                                </small>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-12 mb-2">
                            <div class="p-3 rounded h-100" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                                <small class="text-white-50 d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">
                                    <i class="fa-solid fa-clock mr-1 text-info"></i> Slot Jadwal Sesi Terapi
                                </small>
                                <span class="font-w700 text-white d-block" style="font-size: 14.5px;">
                                    {{ $activeRekam->sesi_waktu ?: 'Sesi Reguler (Rabu)' }}
                                </span>
                                <small class="text-white-50 d-block mt-1" style="font-size: 11px;">
                                    Estimasi Durasi: 30 - 45 Menit / Sesi
                                </small>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-12 mb-2">
                            <div class="p-3 rounded h-100" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                                <small class="text-white-50 d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">
                                    <i class="fa-solid fa-hospital mr-1 text-success"></i> Omah Terapiku & Layanan
                                </small>
                                <span class="font-w700 text-white d-block" style="font-size: 14.5px;">
                                    {{ $activeRekam->upt_lokasi ?: ($activeRekam->poli ?: 'Omah Terapiku') }}
                                </span>
                                <small class="text-white-50 d-block mt-1" style="font-size: 11px;">
                                    Layanan: <span class="text-white font-w600">{{ $activeRekam->layanan_terapi ?: 'Fisioterapi' }}</span>
                                </small>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-12 mb-2">
                            <div class="p-3 rounded h-100" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                                <small class="text-white-50 d-block font-w600 mb-1" style="font-size: 11px; text-transform: uppercase;">
                                    <i class="fa-solid fa-user-doctor mr-1 text-danger"></i> Terapis Pemeriksa
                                </small>
                                <span class="font-w700 text-white d-block" style="font-size: 14.5px;">
                                    {{ $activeRekam->dokter->nama ?? 'Belum Ditugaskan' }}
                                </span>
                                <div class="mt-1">
                                    {!! $activeRekam->status_display() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-light mt-3 mb-0 text-dark d-flex align-items-center justify-content-between p-3" style="border-radius: 8px; font-size: 12.5px;">
                        <div>
                            <i class="fa-solid fa-circle-info text-primary mr-2"></i>
                            Penerima manfaat ini belum memiliki catatan sesi terapi. Silakan daftarkan sesi terapi baru untuk memulai perawatan.
                        </div>
                        <a href="{{ Route('rekam.add') }}" class="btn btn-sm btn-primary font-w600" style="font-size: 12px; padding: 5px 14px;">
                            <i class="fa-solid fa-plus mr-1"></i> Daftarkan Sesi Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section: Tab 1 (Asesmen) & Tab 2 (Log Sesi Terapi SOAP) -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.06);">
            
            <!-- Card Header with Navigation Tabs & Action -->
            <div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap" style="padding: 16px 20px; gap: 12px;">
                <ul class="nav nav-pills" id="pills-tab-rekam" role="tablist" style="gap: 8px;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active font-w700" id="tab-asesmen-link" data-toggle="pill" href="#tab-asesmen" role="tab" aria-controls="tab-asesmen" aria-selected="true" style="border-radius: 8px; font-size: 13px; padding: 8px 18px;">
                            <i class="fa-solid fa-clipboard-list mr-2"></i> Tab 1: Asesmen Baseline & Re-Evaluasi
                            <span class="badge badge-light text-primary ml-1" style="font-size: 11px;">{{ count($riwayatAssessment ?? []) }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link font-w700" id="tab-soap-link" data-toggle="pill" href="#tab-soap" role="tab" aria-controls="tab-soap" aria-selected="false" style="border-radius: 8px; font-size: 13px; padding: 8px 18px;">
                            <i class="fa-solid fa-stethoscope mr-2"></i> Tab 2: Log Sesi Terapi (SOAP Harian)
                            <span class="badge badge-light text-primary ml-1" style="font-size: 11px;">{{ $rekams->total() }}</span>
                        </a>
                    </li>
                </ul>

                @if ($rekamLatest)
                    @if ($rekamLatest->status==1)
                        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Pendaftaran")
                            <a href="{{Route('rekam.status',[$rekamLatest->id,2])}}" class="btn btn-sm btn-primary shadow-sm" style="font-size: 12.5px; padding: 7px 16px; border-radius: 6px;">
                                Lanjutkan Ke Dokter <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    @elseif ($rekamLatest->status==2)
                        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Dokter")
                            <a href="{{Route('rekam.status',[$rekamLatest->id,3])}}" class="btn btn-sm btn-primary shadow-sm" style="font-size: 12.5px; padding: 7px 16px; border-radius: 6px;">
                                Selesaikan Pemeriksaan & Perawatan <i class="fa-solid fa-check ml-1"></i>
                            </a>
                        @endif
                    @elseif ($rekamLatest->status==4 || $rekamLatest->status==3)
                        @if (auth()->user()->role_display()=="Admin" || auth()->user()->role_display()=="Dokter")
                            <a href="{{Route('rekam.status',[$rekamLatest->id,5])}}" class="btn btn-sm btn-success shadow-sm text-white" style="font-size: 12.5px; padding: 7px 16px; border-radius: 6px;">
                                Selesaikan Rekam Medis Ini <i class="fa-solid fa-circle-check ml-1"></i>
                            </a>
                        @endif
                    @endif
                @endif
            </div>

            <div class="card-body pt-3 pb-4">
                <div class="tab-content" id="pills-tabContent-rekam">

                    <!-- ========================================== -->
                    <!-- TAB 1: ASESMEN BASELINE & RE-EVALUASI -->
                    <!-- ========================================== -->
                    <div class="tab-pane fade show active" id="tab-asesmen" role="tabpanel" aria-labelledby="tab-asesmen-link">
                        
                        <!-- Ringkasan Klinis & Indikator Asesmen Terkini -->
                        <div class="p-3 mb-4 rounded" style="background: linear-gradient(135deg, #f0f7ff 0%, #edf3fc 100%); border: 1px solid #cce5ff;">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2" style="gap: 10px;">
                                <div>
                                    <h5 class="font-w700 text-primary mb-1" style="color: var(--ot-navy) !important; font-size: 15px;">
                                        <i class="fa-solid fa-chart-line mr-2"></i> Ringkasan Profil Klinis & Capaian Fungsional Terkini
                                    </h5>
                                    <p class="text-muted mb-0" style="font-size: 12px;">
                                        Monitoring perkembangan instrumen standar (GMFM-88, Skala Denver II, VAS Nyeri, ADL) dari asesmen baseline hingga re-evaluasi berkala.
                                    </p>
                                </div>
                                @if($rekamLatest && !$rekamLatest->assessment)
                                    <a href="{{ Route('rekam.assessment', $rekamLatest->id) }}" class="btn btn-sm btn-primary shadow-sm font-w600" style="font-size: 12px; padding: 6px 14px; border-radius: 6px;">
                                        <i class="fa-solid fa-clipboard-check mr-1"></i> Isi Asesmen Sesi Aktif Ini
                                    </a>
                                @elseif($rekamLatest && $rekamLatest->assessment)
                                    <a href="{{ Route('rekam.assessment', $rekamLatest->id) }}" class="btn btn-sm btn-outline-primary font-w600" style="font-size: 12px; padding: 6px 14px; border-radius: 6px;">
                                        <i class="fa-solid fa-pencil mr-1"></i> Edit Asesmen Sesi Ini
                                    </a>
                                @endif
                            </div>

                            @if(isset($latestAssessment) && $latestAssessment)
                                <div class="row mt-3">
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 rounded bg-white shadow-xs border">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Skor Total GMFM-88</small>
                                            <span class="font-w700 text-primary" style="font-size: 16px;">
                                                @if($latestAssessment->gmfm_total_persen !== null)
                                                    {{ number_format($latestAssessment->gmfm_total_persen, 1) }}%
                                                @elseif($latestAssessment->gmfm_total_score !== null)
                                                    {{ $latestAssessment->gmfm_total_score }} Poin
                                                @else
                                                    Belum dihitung
                                                @endif
                                            </span>
                                            <small class="text-muted d-block" style="font-size: 10px;">
                                                {{ $latestAssessment->gmfm_total_score !== null ? 'Skor: ' . $latestAssessment->gmfm_total_score . ' Poin' : 'Dimensi Motorik Kasar' }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 rounded bg-white shadow-xs border">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Skala Denver II (DDST)</small>
                                            @php
                                                $dKes = $latestAssessment->denver_kesimpulan;
                                                $dClr = ($dKes == 'Normal (Sesuai Usia)') ? 'text-success' : (($dKes == 'Suspect (Meragukan)') ? 'text-warning' : ($dKes ? 'text-danger' : 'text-muted'));
                                            @endphp
                                            <span class="font-w700 {{ $dClr }}" style="font-size: 13.5px;">
                                                {{ $dKes ?: 'Belum Dinilai' }}
                                            </span>
                                            <small class="text-muted d-block" style="font-size: 10px;">
                                                @if($latestAssessment->denver_pass_count !== null || $latestAssessment->denver_fail_count !== null)
                                                    {{ $latestAssessment->denver_pass_count ?? 0 }} Lulus &bull; {{ $latestAssessment->denver_fail_count ?? 0 }} Gagal
                                                @else
                                                    4 Sektor Perkembangan
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 rounded bg-white shadow-xs border">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Intensitas Nyeri (VAS / NRS)</small>
                                            <span class="font-w700 {{ (($latestAssessment->nyeri_skor_total ?? 0) > 4) ? 'text-danger' : 'text-info' }}" style="font-size: 15px;">
                                                @if($latestAssessment->nyeri_skor_total !== null && $latestAssessment->nyeri_skor_total !== '')
                                                    {{ $latestAssessment->nyeri_skor_total }} / 10
                                                @elseif($latestAssessment->nyeri_saat_istirahat !== null)
                                                    Istirahat: {{ $latestAssessment->nyeri_saat_istirahat }}/10
                                                @else
                                                    -
                                                @endif
                                            </span>
                                            <small class="text-muted d-block text-truncate" style="font-size: 10px;" title="{{ $latestAssessment->nyeri_lokasi_keluhan }}">
                                                {{ $latestAssessment->nyeri_lokasi_keluhan ?: 'Tidak ada keluhan nyeri' }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="p-2 rounded bg-white shadow-xs border">
                                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Tanggal & Terapis Asesmen</small>
                                            <span class="font-w700 text-dark" style="font-size: 13px;">
                                                {{ $latestAssessment->tgl_assessment ? \Carbon\Carbon::parse($latestAssessment->tgl_assessment)->format('d/m/Y') : '-' }}
                                            </span>
                                            <small class="text-muted d-block text-truncate" style="font-size: 10px;">{{ $latestAssessment->dokter->nama ?? 'Terapis Klinis' }}</small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fa fa-info-circle text-primary mb-2" style="font-size: 24px;"></i>
                                    <p class="mb-0 text-muted font-w500" style="font-size: 12.5px;">
                                        Penerima manfaat ini belum memiliki data asesmen klinis komprehensif. Silakan klik tombol <strong>"Isi Asesmen Sesi Aktif Ini"</strong> untuk melakukan asesmen baseline 15 modul klinis.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Tabel Riwayat Asesmen Lengkap -->
                        <h6 class="font-w700 text-dark mb-2" style="font-size: 14px;">
                            <i class="fa fa-list-alt text-primary mr-1"></i> Riwayat Lembar Asesmen (Baseline & Re-Evaluasi)
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="border-collapse: collapse; font-size: 12.5px;">
                                <thead class="bg-light">
                                    <tr style="color: #1e293b;">
                                        <th style="width: 4%; text-align: center; vertical-align: middle;">No</th>
                                        <th style="width: 13%; vertical-align: middle;">Tgl Asesmen</th>
                                        <th style="width: 14%; vertical-align: middle;">Terapis Penguji</th>
                                        <th style="width: 12%; vertical-align: middle;">Jenis Asesmen</th>
                                        <th style="width: 14%; vertical-align: middle;">Skor GMFM-88</th>
                                        <th style="width: 14%; vertical-align: middle;">Skala Denver II</th>
                                        <th style="width: 15%; vertical-align: middle;">Kesimpulan & Rencana</th>
                                        <th style="width: 14%; text-align: center; vertical-align: middle;">Aksi Asesmen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($riwayatAssessment) && count($riwayatAssessment) > 0)
                                        @foreach($riwayatAssessment as $aIdx => $aRow)
                                            <tr>
                                                <td class="text-center font-w600" style="vertical-align: middle;">{{ $aIdx + 1 }}</td>
                                                <td style="vertical-align: top;">
                                                    <strong class="text-primary">{{ $aRow->tgl_assessment ? \Carbon\Carbon::parse($aRow->tgl_assessment)->format('d/m/Y') : '-' }}</strong>
                                                    <br><small class="text-muted">REG# {{ $aRow->rekam ? $aRow->rekam->no_rekam : '-' }}</small>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <strong style="color: #1e293b;">{{ $aRow->dokter->nama ?? '-' }}</strong>
                                                    <br><small class="text-muted">{{ $aRow->rekam->poli ?? 'Omah Terapiku' }}</small>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    @if($aIdx == (count($riwayatAssessment) - 1))
                                                        <span class="badge badge-primary font-w600" style="font-size: 10.5px;">Baseline Awal</span>
                                                    @else
                                                        <span class="badge badge-info font-w600" style="font-size: 10.5px;">Re-Evaluasi Ke-{{ count($riwayatAssessment) - $aIdx - 1 }}</span>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: top;">
                                                    @if($aRow->gmfm_total_persen !== null)
                                                        <div class="font-w700 text-primary">{{ number_format($aRow->gmfm_total_persen, 1) }}%</div>
                                                        <small class="text-muted">Total: {{ $aRow->gmfm_total_score }} poin</small>
                                                    @elseif($aRow->gmfm_total_score !== null)
                                                        <div class="font-w700 text-primary">{{ $aRow->gmfm_total_score }} poin</div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: top;">
                                                    @if($aRow->denver_kesimpulan)
                                                        <span class="badge {{ ($aRow->denver_kesimpulan == 'Normal (Sesuai Usia)') ? 'badge-success' : (($aRow->denver_kesimpulan == 'Suspect (Meragukan)') ? 'badge-warning' : 'badge-danger') }} font-w600" style="font-size: 10.5px;">
                                                            {{ $aRow->denver_kesimpulan }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div class="text-truncate" style="max-width: 180px;" title="{{ $aRow->kesimpulan }}">
                                                        {{ $aRow->kesimpulan ?: '-' }}
                                                    </div>
                                                    @if($aRow->rencana_terapi)
                                                        <small class="text-muted d-block text-truncate" style="max-width: 180px;" title="{{ $aRow->rencana_terapi }}">
                                                            Plan: {{ $aRow->rencana_terapi }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    <div class="btn-group" role="group" style="gap: 3px;">
                                                        <a href="{{ Route('rekam.assessment.show', $aRow->rekam_id) }}" class="btn btn-xs btn-primary shadow-xs font-w600" style="padding: 4px 8px; border-radius: 4px;" title="Lihat Lembar Asesmen">
                                                            <i class="fa fa-eye"></i> Detail
                                                        </a>
                                                        <a href="{{ Route('rekam.assessment.print', $aRow->rekam_id) }}" target="_blank" class="btn btn-xs btn-outline-info font-w600" style="padding: 4px 8px; border-radius: 4px;" title="Cetak Format Lembar Asesmen">
                                                            <i class="fa fa-print"></i> Cetak
                                                        </a>
                                                        @if (auth()->user()->role_display() == "Dokter" || auth()->user()->role_display() == "Admin")
                                                            <a href="{{ Route('rekam.assessment', $aRow->rekam_id) }}" class="btn btn-xs btn-outline-warning font-w600" style="padding: 4px 8px; border-radius: 4px;" title="Edit Form Asesmen">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                <i class="fa fa-folder-open-o mr-1"></i> Belum ada rekaman asesmen klinis untuk penerima manfaat ini.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- TAB 2: LOG SESI TERAPI (SOAP HARIAN) -->
                    <!-- ========================================== -->
                    <div class="tab-pane fade" id="tab-soap" role="tabpanel" aria-labelledby="tab-soap-link">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap: 10px;">
                            <h6 class="font-w700 text-dark mb-0" style="font-size: 14px;">
                                <i class="fa fa-history text-primary mr-1"></i> Log Catatan SOAP Sesi Terapi Harian (Rabu Rutin)
                            </h6>
                            <a href="{{ Route('rekam.add') }}" class="btn btn-xs btn-primary font-w600 shadow-sm" style="padding: 5px 12px; border-radius: 6px;">
                                <i class="fa fa-plus-circle mr-1"></i> Input Sesi Baru
                            </a>
                        </div>

                        <!-- Medical Records Clean Table -->
                        <div class="table-responsive"> 
                            <table class="table table-bordered table-striped" style="border-collapse: collapse; font-size: 12.5px;">
                                <thead class="bg-light">
                                    <tr style="color: #1e293b;">
                                        <th style="width: 4%; vertical-align: middle; text-align: center;">No</th>
                                        <th style="width: 14%; vertical-align: middle;">Tgl & Sesi Terapi</th>
                                        <th style="width: 16%; vertical-align: middle;">Layanan & UPT</th>
                                        <th style="width: 15%; vertical-align: middle;">Terapis</th>
                                        <th style="width: 15%; vertical-align: middle;">Keluhan (S)</th>
                                        <th style="width: 15%; vertical-align: middle;">Assessment (A)</th>
                                        <th style="width: 10%; vertical-align: middle; text-align: center;">Status Sesi</th>
                                        <th style="width: 11%; vertical-align: middle; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($rekams) > 0)
                                        @foreach ($rekams as $key=>$row)
                                            <tr>
                                                <td style="vertical-align: middle; text-align: center; font-weight: 600;">{{ $rekams->firstItem() + $key }}</td>
                                                <td style="vertical-align: top;">
                                                    <strong class="text-primary">{{ $row->tgl_rekam }}</strong>
                                                    @if($row->sesi_waktu)
                                                        <br><span class="badge badge-outline-primary mt-1 font-w600" style="font-size: 10.5px;">
                                                            <i class="fa fa-clock-o mr-1"></i> {{ $row->sesi_waktu }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div class="font-w600" style="color: #1e293b;">{{ $row->layanan_terapi ?: 'Terapi Terpadu' }}</div>
                                                    <small class="text-muted"><i class="fa fa-map-marker text-danger mr-1"></i>{{ $row->upt_lokasi ?: ($row->poli ?: 'Omah Terapi') }}</small>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div class="font-w600" style="color: #1e293b;">{{ $row->dokter->nama ?? '-' }}</div>
                                                    @if($row->terapisPendamping)
                                                        <small class="text-muted d-block"><i class="fa fa-user-plus text-info mr-1"></i>{{ $row->terapisPendamping->nama }}</small>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div class="text-truncate" style="max-width: 160px;" title="{{ $row->keluhan }}">
                                                        {{ $row->keluhan ?: '-' }}
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    @if ($row->diagnosa)
                                                        <div class="font-w600 text-dark mb-1" style="font-size: 12px; line-height: 1.4;">
                                                            {{ Str::limit(strip_tags($row->diagnosa), 90) }}
                                                        </div>
                                                    @elseif ($row->diagnosa() && count($row->diagnosa()) > 0)
                                                        @foreach ($row->diagnosa() as $item)
                                                            <div class="mb-1">
                                                                <span class="badge badge-light text-dark font-w600" style="font-size: 10.5px; border: 1px solid #cbd5e1;">{{ $item->diagnosa }}</span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted font-italic">-</span>
                                                    @endif
                                                    
                                                    @if($row->assessment)
                                                        <div class="mt-1">
                                                            <a href="{{ Route('rekam.assessment.show', $row->id) }}" class="badge badge-primary font-w600" style="font-size: 10px;">
                                                                <i class="fa fa-check-circle mr-1"></i> Asesmen 15 Modul Ada
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    {!! $row->status_display() !!}
                                                </td>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    <!-- Single Clean Utility Button for SOAP Details -->
                                                    <button type="button" class="btn btn-xs btn-primary shadow-sm font-w600 btn-open-soap-modal"
                                                            data-id="{{ $row->id }}"
                                                            data-norekam="{{ $row->no_rekam }}"
                                                            data-tanggal="{{ $row->tgl_rekam }}"
                                                            data-sesiwaktu="{{ $row->sesi_waktu ?? '-' }}"
                                                            data-layanan="{{ $row->layanan_terapi ?? 'Terapi Terpadu' }}"
                                                            data-upt="{{ $row->upt_lokasi ?: ($row->poli ?: 'Omah Terapi') }}"
                                                            data-terapis="{{ $row->dokter->nama ?? '-' }}"
                                                            data-pendamping="{{ $row->terapisPendamping->nama ?? '-' }}"
                                                            data-status="{{ $row->status }}"
                                                            data-keluhan="{{ htmlspecialchars($row->keluhan ?? '', ENT_QUOTES) }}"
                                                            data-pemeriksaan="{{ htmlspecialchars($row->pemeriksaan ?? '', ENT_QUOTES) }}"
                                                            data-diagnosa="{{ htmlspecialchars($row->diagnosa ?? '', ENT_QUOTES) }}"
                                                            data-tindakan="{{ htmlspecialchars($row->tindakan ?? '', ENT_QUOTES) }}"
                                                            data-filepemeriksaan="{{ $row->getFilePemeriksaan() }}"
                                                            data-filetindakan="{{ $row->getFileTindakan() }}"
                                                            data-hasassessment="{{ $row->assessment ? '1' : '0' }}"
                                                            data-urlassessment="{{ Route('rekam.assessment', $row->id) }}"
                                                            data-urlassessmentshow="{{ Route('rekam.assessment.show', $row->id) }}"
                                                            data-urlassessmentprint="{{ Route('rekam.assessment.print', $row->id) }}"
                                                            style="padding: 5px 10px; border-radius: 6px; font-size: 11.5px; white-space: nowrap;">
                                                        <i class="fa fa-folder-open-o mr-1"></i> Detail Sesi
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                <p class="mb-0 fs-13">Belum ada riwayat sesi terapi (SOAP) untuk penerima manfaat ini.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination & Info -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap mt-3" style="font-size: 12.5px;">
                            <div class="text-muted mb-2">
                                Menampilkan {{$rekams->firstItem() ?? 0}} - {{$rekams->lastItem() ?? 0}} dari {{$rekams->total()}} data sesi terapi
                            </div>
                            <div>
                                {{ $rekams->appends(request()->except('page'))->links() }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL DETAIL CATATAN SESI TERAPI (SOAP COMPREHENSIVE MODAL) -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalDetailSOAP" tabindex="-1" role="dialog" aria-labelledby="modalDetailSOAPLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #2e4b82 0%, #1e355b 100%); padding: 14px 20px;">
                <div>
                    <h5 class="modal-title font-w700 text-white mb-0" id="modalDetailSOAPLabel" style="font-size: 16px;">
                        <i class="fa fa-folder-open-o mr-2"></i> Detail Catatan Sesi Terapi (SOAP)
                    </h5>
                    <small class="text-white-50" id="modalSoapSubTitle">Rekam Medis Sesi Terapi</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.85;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #f8fafc; max-height: 75vh; overflow-y: auto;">
                
                <!-- Sesi Meta Info Cards -->
                <div class="row mb-3">
                    <div class="col-md-4 col-sm-6 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Tanggal & Waktu Sesi</small>
                            <span class="font-w700 text-dark" id="modalSoapTanggal" style="font-size: 13px;">-</span>
                            <small class="d-block text-primary font-w600" id="modalSoapWaktu">-</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Layanan & Lokasi UPT</small>
                            <span class="font-w700 text-dark" id="modalSoapLayanan" style="font-size: 13px;">-</span>
                            <small class="d-block text-muted text-truncate" id="modalSoapUpt">-</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="p-2 px-3 rounded bg-white border">
                            <small class="text-muted d-block font-w600" style="font-size: 11px;">Terapis Penanggung Jawab</small>
                            <span class="font-w700 text-dark" id="modalSoapTerapis" style="font-size: 13px;">-</span>
                            <small class="d-block text-muted" id="modalSoapTerapisRole"><i class="fa fa-user-md text-primary mr-1"></i> Terapis Pemeriksa</small>
                        </div>
                    </div>
                </div>

                <!-- Section S: Subjektif -->
                <div class="card mb-3 border-0 shadow-xs" style="border-radius: 8px;">
                    <div class="card-header py-2 px-3 border-bottom d-flex align-items-center" style="background: #fff8e6;">
                        <span class="badge badge-warning text-dark font-w700 mr-2" style="font-size: 11px;">S</span>
                        <strong class="text-dark" style="font-size: 13px;">Subjektif (Keluhan & Anamnesa Sesi Ini)</strong>
                    </div>
                    <div class="card-body p-3">
                        <div id="modalSoapKeluhan" style="font-size: 13px; line-height: 1.5; color: #1e293b;">-</div>
                    </div>
                </div>

                <!-- Section O: Objektif -->
                <div class="card mb-3 border-0 shadow-xs" style="border-radius: 8px;">
                    <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center" style="background: #eef6ff;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-info font-w700 mr-2" style="font-size: 11px;">O</span>
                            <strong class="text-dark" style="font-size: 13px;">Objektif (Pemeriksaan Fisik & Tanda Vital)</strong>
                        </div>
                        <div id="modalSoapFilePemeriksaanContainer"></div>
                    </div>
                    <div class="card-body p-3">
                        <div id="modalSoapPemeriksaan" style="font-size: 13px; line-height: 1.5; color: #1e293b;">-</div>
                    </div>
                </div>

                <!-- Section A: Assessment & Diagnosa Terapi -->
                <div class="card mb-3 border-0 shadow-xs" style="border-radius: 8px;">
                    <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center" style="background: #fdf2f2;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-danger font-w700 mr-2" style="font-size: 11px;">A</span>
                            <strong class="text-dark" style="font-size: 13px;">Assessment (Catatan Asesmen & Diagnosa Terapi)</strong>
                        </div>
                        <div id="modalSoapAssessmentBtnContainer"></div>
                    </div>
                    <div class="card-body p-3">
                        <div id="modalSoapAssessmentText" style="font-size: 13px; line-height: 1.5; color: #1e293b;">
                            <span class="text-muted font-italic">Belum ada catatan assessment terapi.</span>
                        </div>
                    </div>
                </div>

                <!-- Section P: Plan & Intervensi Terapi -->
                <div class="card mb-0 border-0 shadow-xs" style="border-radius: 8px;">
                    <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center" style="background: #eafaf1;">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-success font-w700 mr-2" style="font-size: 11px;">P</span>
                            <strong class="text-dark" style="font-size: 13px;">Plan (Rencana Tindakan & Intervensi Terapi)</strong>
                        </div>
                        <div id="modalSoapFileTindakanContainer"></div>
                    </div>
                    <div class="card-body p-3">
                        <div id="modalSoapTindakan" style="font-size: 13px; line-height: 1.5; color: #1e293b;">-</div>
                    </div>
                </div>

            </div>

            <div class="modal-footer d-flex justify-content-between align-items-center bg-white border-top py-2 px-3">
                <div class="d-flex align-items-center flex-wrap" id="modalSoapActionButtons" style="gap: 6px;">
                    <!-- Dynamically populated buttons for Edit (O), (A), (P) if status <= 2 -->
                </div>
                <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 14px;">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Include Modal Partial untuk Input & Edit (O), (A), (P) -->
@include('rekam.partial.modal-pemeriksaan')
@include('rekam.partial.modal-diagnosa')
@include('rekam.partial.modal-tindakan')

@endsection

@section('script')
<script>
    // Handler Klik Edit (O) Fisik
    $(document).on("click", ".addPemeriksaan", function () {
        var rekamId = $(this).data('id');
        var pemeriksaan = $(this).data('pemeriksaan') || '';
        $("#modalPemeriksaanRekamId").val(rekamId);
        
        // Strip HTML if necessary for raw textarea or keep text
        var tempDiv = document.createElement("div");
        tempDiv.innerHTML = pemeriksaan;
        var cleanText = tempDiv.textContent || tempDiv.innerText || "";
        if (cleanText.trim() === 'Belum ada catatan pemeriksaan objektif.') {
            cleanText = '';
        }
        $("#modalPemeriksaanTextarea").val(cleanText || pemeriksaan);
    });

    // Handler Insert Vital Signs Template
    $(document).on("click", "#btnInsertVitalSignTemplate", function () {
        var tpl = "TD: 110/70 mmHg\nHR / Nadi: 80 x/mnt\nRR: 20 x/mnt\nSuhu: 36.5 °C\nBB / TB: - kg / - cm\nSpO2: 98%\nStatus: Compos Mentis, Kooperatif\n";
        var txt = $("#modalPemeriksaanTextarea");
        var curVal = txt.val();
        if (curVal.trim().length > 0) {
            txt.val(curVal + "\n\n" + tpl);
        } else {
            txt.val(tpl);
        }
    });

    // Handler Klik Edit (A) Assessment
    $(document).on("click", ".addDiagnosa", function () {
        var rekamId = $(this).data('id');
        var diagnosa = $(this).data('diagnosa') || '';
        $("#modalAssessmentRekamId").val(rekamId);
        
        var tempDiv = document.createElement("div");
        tempDiv.innerHTML = diagnosa;
        var cleanText = tempDiv.textContent || tempDiv.innerText || "";
        $("#modalAssessmentTextarea").val(cleanText || diagnosa);

        var urlForm = "{{ url('/rekam') }}/" + rekamId + "/assessment";
        $("#modalAssessmentGoToForm").attr("href", urlForm);
    });

    // Handler Klik Preset Assessment Chips
    $(document).on("click", ".btn-chip-assessment", function () {
        var text = $(this).data('text');
        var txt = $("#modalAssessmentTextarea");
        var curVal = txt.val().trim();
        if (curVal.length > 0) {
            if (curVal.indexOf(text) === -1) {
                txt.val(curVal + "\n• " + text);
            }
        } else {
            txt.val("• " + text);
        }
        toastr.info("Ditambahkan: " + text, "Assessment Preset", {timeOut: 2000});
    });

    // Handler Klik Edit (P) Tindakan
    $(document).on("click", ".addTindakan", function () {
        var rekamId = $(this).data('id');
        var tindakan = $(this).data('tindakan') || '';
        var layanan = ($(this).data('layanan') || '').toLowerCase();
        
        $("#modalTindakanRekamId").val(rekamId);

        var tempDiv = document.createElement("div");
        tempDiv.innerHTML = tindakan;
        var cleanText = tempDiv.textContent || tempDiv.innerText || "";
        if (cleanText.trim() === 'Belum ada catatan tindakan / rencana intervensi.') {
            cleanText = '';
        }
        $("#modalTindakanTextarea").val(cleanText || tindakan);

        // Auto filter discipline if available
        if (layanan.indexOf('fisio') !== -1) {
            $('.btn-filter-tindakan[data-target-discipline="fisioterapi"]').trigger('click');
        } else if (layanan.indexOf('okupasi') !== -1) {
            $('.btn-filter-tindakan[data-target-discipline="okupasi"]').trigger('click');
        } else if (layanan.indexOf('wicara') !== -1) {
            $('.btn-filter-tindakan[data-target-discipline="wicara"]').trigger('click');
        } else if (layanan.indexOf('netra') !== -1) {
            $('.btn-filter-tindakan[data-target-discipline="netra"]').trigger('click');
        } else {
            $('.btn-filter-tindakan[data-target-discipline="all"]').trigger('click');
        }
    });

    // Handler Filter Kategori Tindakan
    $(document).on("click", ".btn-filter-tindakan", function () {
        var disc = $(this).data('target-discipline');
        if (disc === 'all') {
            $(".tdk-chip-item").show();
        } else {
            $(".tdk-chip-item").hide();
            $(".tdk-disc-" + disc).show();
        }
    });

    // Handler Klik Preset Tindakan Chips
    $(document).on("click", ".btn-chip-tindakan", function () {
        var name = $(this).data('name');
        var txt = $("#modalTindakanTextarea");
        var curVal = txt.val().trim();
        if (curVal.length > 0) {
            if (curVal.indexOf(name) === -1) {
                txt.val(curVal + "\n- " + name);
            }
        } else {
            txt.val("- " + name);
        }
        toastr.success("Tindakan ditambahkan: " + name, "Plan / Tindakan", {timeOut: 2000});
    });

    // Handler for Single Utility Button - Detail Catatan Sesi (SOAP) Modal
    $(document).on("click", ".btn-open-soap-modal", function () {
        var btn = $(this);
        var id = btn.data('id');
        var norekam = btn.data('norekam');
        var tanggal = btn.data('tanggal');
        var sesiwaktu = btn.data('sesiwaktu');
        var layanan = btn.data('layanan');
        var upt = btn.data('upt');
        var terapis = btn.data('terapis');
        var pendamping = btn.data('pendamping');
        var status = parseInt(btn.data('status'));
        var keluhan = btn.data('keluhan') || '-';
        var pemeriksaan = btn.data('pemeriksaan') || '<span class="text-muted font-italic">Belum ada catatan pemeriksaan objektif.</span>';
        var diagnosa = btn.data('diagnosa') || '';
        var tindakan = btn.data('tindakan') || '<span class="text-muted font-italic">Belum ada catatan tindakan / rencana intervensi.</span>';
        var filepemeriksaan = btn.data('filepemeriksaan');
        var filetindakan = btn.data('filetindakan');
        var hasassessment = btn.data('hasassessment') === 1 || btn.data('hasassessment') === '1';
        var urlassessment = btn.data('urlassessment');
        var urlassessmentshow = btn.data('urlassessmentshow');
        var urlassessmentprint = btn.data('urlassessmentprint');

        // Populate Modal Fields
        $("#modalSoapSubTitle").text(norekam + " — " + layanan);
        $("#modalSoapTanggal").text(tanggal);
        $("#modalSoapWaktu").html('<i class="fa fa-clock-o mr-1"></i> ' + (sesiwaktu !== '-' ? sesiwaktu : 'Sesi Reguler (08.00 - 13.00)'));
        $("#modalSoapLayanan").text(layanan);
        $("#modalSoapUpt").html('<i class="fa fa-map-marker text-danger mr-1"></i> ' + upt);
        $("#modalSoapTerapis").text(terapis);

        // S: Subjektif
        $("#modalSoapKeluhan").html($('<div>').html(keluhan).text().replace(/\n/g, '<br>') || '-');

        // O: Objektif
        $("#modalSoapPemeriksaan").html(pemeriksaan);
        if (filepemeriksaan) {
            $("#modalSoapFilePemeriksaanContainer").html('<a href="' + filepemeriksaan + '" target="_blank" class="btn btn-xs btn-outline-info font-w600"><i class="fa fa-image mr-1"></i> Foto Pemeriksaan</a>');
        } else {
            $("#modalSoapFilePemeriksaanContainer").empty();
        }

        // A: Assessment
        var assessmentContent = '';
        if (diagnosa && diagnosa.trim().length > 0) {
            assessmentContent += '<div class="font-w600 mb-2">' + $('<div>').html(diagnosa).text().replace(/\n/g, '<br>') + '</div>';
        }
        if (hasassessment) {
            assessmentContent += '<div class="mt-2 pt-2 border-top"><span class="badge badge-success font-w600 mr-2"><i class="fa fa-check-circle mr-1"></i> Lembar Asesmen 15 Modul Terisi</span></div>';
            $("#modalSoapAssessmentBtnContainer").html(
                '<div class="btn-group">' +
                    '<a href="' + urlassessmentshow + '" class="btn btn-xs btn-primary font-w600"><i class="fa fa-eye mr-1"></i> Lembar Asesmen</a>' +
                    '<a href="' + urlassessmentprint + '" target="_blank" class="btn btn-xs btn-outline-info font-w600"><i class="fa fa-print mr-1"></i> Cetak</a>' +
                '</div>'
            );
        } else {
            if (!diagnosa) {
                assessmentContent = '<span class="text-muted font-italic">Belum ada catatan assessment klinis terapi.</span>';
            }
            @if(auth()->user()->role_display() == "Dokter" || auth()->user()->role_display() == "Admin")
                $("#modalSoapAssessmentBtnContainer").html('<a href="' + urlassessment + '" class="btn btn-xs btn-outline-danger font-w600"><i class="fa fa-plus mr-1"></i> Isi Lembar Asesmen</a>');
            @else
                $("#modalSoapAssessmentBtnContainer").empty();
            @endif
        }
        $("#modalSoapAssessmentText").html(assessmentContent);

        // P: Plan
        $("#modalSoapTindakan").html($('<div>').html(tindakan).text().replace(/\n/g, '<br>') || tindakan);
        if (filetindakan) {
            $("#modalSoapFileTindakanContainer").html('<a href="' + filetindakan + '" target="_blank" class="btn btn-xs btn-outline-success font-w600"><i class="fa fa-image mr-1"></i> Foto Tindakan</a>');
        } else {
            $("#modalSoapFileTindakanContainer").empty();
        }

        // Action Buttons inside Modal Footer
        var actionHtml = '';
        @if (auth()->user()->role_display() == "Dokter" || auth()->user()->role_display() == "Admin")
            if (status <= 2) {
                actionHtml += '<a href="javascript:void(0)" data-toggle="modal" data-target="#addPemeriksaan" data-id="' + id + '" data-tanggal="' + tanggal + '" data-pemeriksaan="' + (btn.data('pemeriksaan') || '') + '" class="btn btn-xs btn-info addPemeriksaan font-w600 mr-1" data-dismiss="modal"><i class="fa fa-stethoscope mr-1"></i> Edit (O) Fisik</a>';
                actionHtml += '<a href="javascript:void(0)" data-toggle="modal" data-target="#addDiagnosa" data-id="' + id + '" data-tanggal="' + tanggal + '" data-diagnosa="' + (btn.data('diagnosa') || '') + '" class="btn btn-xs btn-danger addDiagnosa font-w600 mr-1" data-dismiss="modal"><i class="fa fa-clipboard mr-1"></i> Edit (A) Assessment</a>';
                actionHtml += '<a href="javascript:void(0)" data-toggle="modal" data-target="#addTindakan" data-id="' + id + '" data-tanggal="' + tanggal + '" data-layanan="' + layanan + '" data-tindakan="' + (btn.data('tindakan') || '') + '" class="btn btn-xs btn-success addTindakan font-w600 mr-1" data-dismiss="modal"><i class="fa fa-medkit mr-1"></i> Edit (P) Tindakan</a>';
            }
        @endif

        $("#modalSoapActionButtons").html(actionHtml);

        // Open Modal
        $("#modalDetailSOAP").modal("show");
    });
</script>
@endsection
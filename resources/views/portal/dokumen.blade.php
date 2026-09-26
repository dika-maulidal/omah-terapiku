@extends('portal.layout.apps')

@section('title', 'Dokumen & Cetak Laporan')

@section('style')
<style>
    .doc-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .doc-item {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }
    .doc-item:hover {
        background: #fafcff;
    }
    .doc-item:last-child {
        border-bottom: none;
    }
    .file-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        transition: all 0.2s ease;
    }
    .file-box:hover {
        background: #ffffff;
        border-color: #bfdbfe;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Header Banner (Unified White Card - DESIGN.md Section 1 & 3) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 14px;">
                    <!-- Title & Icon -->
                    <div class="d-flex align-items-center">
                        <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                            <i class="fa-solid fa-print"></i>
                        </div>
                        <div>
                            <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                                Dokumen & Cetak Laporan Terpadu
                            </h3>
                            <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                                Unduh dan cetak berkas laporan medis per sesi terapi, lembar asesmen 15 modul, catatan SOAP, dan berkas rujukan
                            </p>
                        </div>
                    </div>

                    <!-- Meta Badges -->
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <span class="badge font-w700 d-inline-flex align-items-center" style="font-size: 12px; padding: 6px 14px; border-radius: 8px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; gap: 6px;">
                            <i class="fa-solid fa-calendar-check" style="font-size: 13px;"></i>
                            <span>{{ ($rekams ?? $pasien->rekams) ? ($rekams ?? $pasien->rekams)->count() : 0 }} Sesi Terapi</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. Cetak Laporan Terapi & Asesmen Terpadu (Left/Main Column) -->
    <div class="col-lg-8 col-12 mb-4">
        <div class="card shadow-sm h-100 doc-card" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;">
            <!-- Card Header -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap" style="border-bottom: 1px solid #f1f5f9; padding: 18px 22px;">
                <h4 class="card-title font-w700 mb-0 d-flex align-items-center" style="color: var(--ot-navy, #1e40af); font-size: 16.5px;">
                    <i class="fa-solid fa-print text-primary mr-2"></i>
                    <span>Cetak Laporan Terapi & Asesmen Terpadu</span>
                </h4>
            </div>

            <!-- Card Body / List of Session Items -->
            <div class="card-body p-3 p-md-4">
                @php
                    $allRekams = $rekams ?? $pasien->rekams;
                @endphp
                @if($allRekams && $allRekams->count() > 0)
                    <div class="d-flex flex-column" style="gap: 16px;">
                        @foreach($allRekams as $rekam)
                            @php
                                $asm = $rekam->assessment;
                            @endphp
                            <div class="p-3 p-md-4 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                <!-- Item Header: Date, Service, Location -->
                                <div class="d-flex justify-content-between align-items-center flex-wrap pb-2.5 mb-2.5" style="border-bottom: 1px solid #f1f5f9; gap: 10px;">
                                    <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                                        <!-- Date Pill with Spacious Gap -->
                                        <span class="d-inline-flex align-items-center font-w700" style="gap: 8px; padding: 5px 12px; font-size: 12px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 6px;">
                                            <i class="fa-regular fa-calendar-check" style="font-size: 13px;"></i>
                                            <span>{{ $rekam->tgl_rekam ? \Carbon\Carbon::parse($rekam->tgl_rekam)->isoFormat('D MMMM Y') : 'Sesi Terapi' }}</span>
                                        </span>
                                        <!-- Service Name -->
                                        <span class="font-w700 text-dark d-inline-flex align-items-center" style="font-size: 13.5px; gap: 6px;">
                                            <i class="fa-solid fa-hand-holding-medical text-primary"></i>
                                            <span>{{ $rekam->layanan_terapi ?: 'Layanan Terapi Terpadu' }}</span>
                                        </span>
                                    </div>
                                    
                                    @if($rekam->poli || $rekam->upt_lokasi)
                                        <span class="badge font-w700 d-inline-flex align-items-center" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; gap: 6px;">
                                            <i class="fa-solid fa-hospital text-primary" style="font-size: 12px;"></i>
                                            <span>{{ $rekam->poli ?: $rekam->upt_lokasi }}</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Middle Info: Terapis & Diagnosa -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center flex-wrap" style="gap: 16px; font-size: 12.5px;">
                                        <div class="text-muted font-w600 d-inline-flex align-items-center" style="gap: 7px;">
                                            <i class="fa-solid fa-user-doctor text-primary"></i>
                                            <span>Terapis: <strong class="text-dark">{{ $rekam->dokter ? $rekam->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}</strong></span>
                                        </div>
                                        @if($rekam->diagnosa)
                                            <div class="text-muted font-w600 d-inline-flex align-items-center" style="gap: 7px;">
                                                <i class="fa-solid fa-stethoscope text-primary"></i>
                                                <span>Diagnosa: <strong class="text-dark">{{ $rekam->diagnosa }}</strong></span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons: Langsung di bawah Terapis & Diagnosa (Hanya menampilkan dokumen yang ADA) -->
                                @php
                                    $hasSoap = !empty($rekam->pemeriksaan) || !empty($rekam->tindakan) || !empty($rekam->diagnosa) || ($rekam->status >= 2) || !empty($asm);
                                    $hasHp = !empty($rekam->latihan_rumahan) || ($asm && (!empty($asm->rencana_latihan_terapi) || !empty($asm->rencana_dosis_frekuensi)));
                                    $filePem = $rekam->getFilePemeriksaan();
                                    $fileTind = $rekam->getFileTindakan();
                                    $photoCount = ($filePem ? 1 : 0) + ($fileTind ? 1 : 0);
                                    $hasAnyAction = $photoCount > 0 || $asm || $hasSoap || $hasHp;
                                @endphp
                                <div class="pt-2.5 d-flex align-items-center flex-wrap" style="border-top: 1px dashed #e2e8f0; gap: 10px;">
                                    @if($photoCount > 0)
                                        <button type="button" class="btn btn-sm font-w700 btn-open-foto-sesi d-inline-flex align-items-center" 
                                                data-pem-url="{{ $filePem ?: '' }}" 
                                                data-pem-file="{{ $rekam->pemeriksaan_file ?: '' }}" 
                                                data-tind-url="{{ $fileTind ?: '' }}" 
                                                data-tind-file="{{ $rekam->tindakan_file ?: '' }}" 
                                                data-tanggal="{{ $rekam->tgl_rekam ? \Carbon\Carbon::parse($rekam->tgl_rekam)->isoFormat('D MMMM Y') : 'Sesi Terapi' }}"
                                                style="background: #fdf2f8; color: #be185d; border: 1.5px solid #fbcfe8; border-radius: 8px; padding: 7px 15px; font-size: 12.5px; gap: 8px; transition: all 0.2s ease;" 
                                                title="Lihat Dokumentasi Foto Sesi Terapi">
                                            <i class="fa-solid fa-camera" style="color: #db2777; font-size: 13px;"></i>
                                            <span>Foto Sesi{{ $photoCount > 1 ? ' (2)' : '' }}</span>
                                        </button>
                                    @endif

                                    @if($asm)
                                        <a href="{{ route('portal.assessment.print', $rekam->id) }}" target="_blank" 
                                           class="btn btn-sm btn-primary font-w700 shadow-sm d-inline-flex align-items-center" 
                                           style="border-radius: 8px; padding: 7px 15px; font-size: 12.5px; gap: 8px;" 
                                           title="Cetak Lembar Asesmen Klinis Lengkap (15 Modul)">
                                            <i class="fa-solid fa-file-pdf" style="font-size: 13px;"></i>
                                            <span>Asesmen (15 Modul)</span>
                                        </a>
                                    @endif

                                    @if($hasSoap)
                                        <a href="{{ route('portal.soap.print', $rekam->id) }}" target="_blank" 
                                           class="btn btn-sm font-w700 d-inline-flex align-items-center" 
                                           style="background: #eff6ff; color: #1e40af; border: 1.5px solid #bfdbfe; border-radius: 8px; padding: 7px 15px; font-size: 12.5px; gap: 8px; transition: all 0.2s ease;" 
                                           title="Cetak Catatan Sesi Terapi (SOAP)">
                                            <i class="fa-solid fa-file-lines text-primary" style="font-size: 13px;"></i>
                                            <span>Catatan Sesi (SOAP)</span>
                                        </a>
                                    @endif

                                    @if($hasHp)
                                        <a href="{{ route('portal.home-program.print', $rekam->id) }}" target="_blank" 
                                           class="btn btn-sm font-w700 d-inline-flex align-items-center" 
                                           style="background: #ecfdf5; color: #059669; border: 1.5px solid #a7f3d0; border-radius: 8px; padding: 7px 15px; font-size: 12.5px; gap: 8px; transition: all 0.2s ease;" 
                                           title="Cetak Panduan Latihan Mandiri di Rumah (Home Program)">
                                            <i class="fa-solid fa-house-chimney text-success" style="font-size: 13px;"></i>
                                            <span>Home Program</span>
                                        </a>
                                    @endif

                                    @if(!$hasAnyAction)
                                        <span class="badge font-w600 d-inline-flex align-items-center" style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; font-size: 11.5px; padding: 6px 12px; border-radius: 6px; gap: 6px;">
                                            <i class="fa-regular fa-clock"></i>
                                            <span>Menunggu Pelayanan (Dokumen belum tersedia)</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 60px; height: 60px; background: #eff6ff; color: #2563eb; font-size: 26px; border: 1px solid #bfdbfe;">
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                        <h5 class="font-w700 text-dark mb-1" style="font-size: 16px;">Belum Ada Sesi Terapi</h5>
                        <p class="text-muted mb-0" style="font-size: 13px; max-width: 380px; margin: 0 auto; line-height: 1.5;">
                            Laporan catatan sesi terapi dan asesmen klinis resmi akan tersedia otomatis setelah kunjungan terapi direkam.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. Berkas Dokumen Pasien (Right Column) -->
    <div class="col-lg-4 col-12 mb-4">
        <div class="card shadow-sm h-100 doc-card" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;">
            <!-- Card Header -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f5f9; padding: 18px 22px;">
                <h4 class="card-title font-w700 mb-0 d-flex align-items-center" style="color: var(--ot-navy, #1e40af); font-size: 16.5px;">
                    <i class="fa-solid fa-folder-open text-primary mr-2"></i>
                    <span>Berkas Pasien</span>
                </h4>
                <span class="badge font-w600" style="font-size: 11.5px; padding: 4px 8px; border-radius: 6px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;">
                    Identitas & Rujukan
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3 p-md-4">
                <!-- Berkas Kartu Keluarga (KK) -->
                <div class="file-box mb-3" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 12px;">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background: #eff6ff; color: #2563eb; font-size: 18px; border: 1px solid #bfdbfe; border-radius: 10px;">
                                <i class="fa-solid fa-people-roof"></i>
                            </div>
                            <div>
                                <h6 class="font-w700 text-dark mb-0.5" style="font-size: 13.5px;">Kartu Keluarga (KK)</h6>
                                <span class="text-muted font-w500" style="font-size: 11.5px;">Identitas kependudukan keluarga</span>
                            </div>
                        </div>
                        <div>
                            @if($pasien->file_kk)
                                <button type="button" class="btn btn-sm font-w700 btn-open-preview-berkas d-inline-flex align-items-center" 
                                    data-type="kk" 
                                    data-title="Kartu Keluarga (KK)" 
                                    data-url="{{ $pasien->getFileKk() }}" 
                                    data-filename="{{ $pasien->file_kk }}"
                                    style="border-radius: 6px; padding: 6px 14px; font-size: 12px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; gap: 6px;">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </button>
                            @else
                                <span class="badge font-w600" style="font-size: 11px; padding: 5px 9px; border-radius: 6px; background: #f8fafc; color: #94a3b8; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Belum Ada
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Berkas Resume Medis / Rujukan -->
                <div class="file-box mb-3" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 12px;">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background: #ecfdf5; color: #10b981; font-size: 18px; border: 1px solid #a7f3d0; border-radius: 10px;">
                                <i class="fa-solid fa-file-medical"></i>
                            </div>
                            <div>
                                <h6 class="font-w700 text-dark mb-0.5" style="font-size: 13.5px;">Resume / Rujukan Medis</h6>
                                <span class="text-muted font-w500" style="font-size: 11.5px;">Surat rujukan dokter spesialis</span>
                            </div>
                        </div>
                        <div>
                            @if($pasien->file_resume)
                                <button type="button" class="btn btn-sm font-w700 btn-open-preview-berkas d-inline-flex align-items-center" 
                                    data-type="resume" 
                                    data-title="Resume Berobat / Rujukan Medis" 
                                    data-url="{{ $pasien->getFileResume() }}" 
                                    data-filename="{{ $pasien->file_resume }}"
                                    style="border-radius: 6px; padding: 6px 14px; font-size: 12px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; gap: 6px;">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </button>
                            @else
                                <span class="badge font-w600" style="font-size: 11px; padding: 5px 9px; border-radius: 6px; background: #f8fafc; color: #94a3b8; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Belum Ada
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="p-3 rounded" style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px;">
                    <div style="color: #1e40af; font-size: 12px; font-weight: 500; line-height: 1.5;">
                        Dokumen PDF resmi dapat digunakan saat rujukan ke fasilitas kesehatan atau saat evaluasi berkala di Dinas Sosial.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL POPUP PREVIEW BERKAS DOKUMEN PASIEN (INTERAKTIF)   -->
<!-- ======================================================== -->
<div class="modal fade" id="modalPreviewBerkas" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1065;">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 880px; z-index: 1066;" role="document">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #bfdbfe; box-shadow: 0 16px 45px rgba(15, 23, 42, 0.25); overflow: hidden;">
            
            <!-- Modal Header (Sesuai DESIGN.md - Clean Medical Royal Blue & Ocean Navy) -->
            <div class="modal-header d-flex justify-content-between align-items-center py-3 px-4" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: #ffffff; color: #2563eb; font-size: 19px; flex-shrink: 0; border: 1.5px solid #bfdbfe; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12);">
                        <i id="previewDocIcon" class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" id="previewDocTitle" style="color: #1e40af !important; font-size: 16px; line-height: 1.2;">Preview Berkas</h5>
                    </div>
                </div>

                <!-- Controls & Actions Toolbar -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <!-- Zoom & Rotate Controls (for images) -->
                    <div class="btn-group btn-group-sm" id="previewZoomControls" style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 3px; box-shadow: 0 2px 6px rgba(0,0,0,0.04); display: inline-flex; align-items: center; gap: 2px;">
                        <button type="button" class="btn btn-xs" id="btnPreviewZoomOut" title="Perkecil (-)" style="border: none; background: transparent; color: #1e40af; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.15s;" onmouseover="this.style.background='#eff6ff'; this.style.color='#2563eb';" onmouseout="this.style.background='transparent'; this.style.color='#1e40af';">
                            <i class="fa-solid fa-magnifying-glass-minus"></i>
                        </button>
                        <button type="button" class="btn btn-xs font-w700" id="btnPreviewZoomReset" title="Reset Ukuran (100%)" style="border: 1px solid #bfdbfe; background: #eff6ff; color: #1e40af; padding: 3px 8px; font-size: 11px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; min-width: 46px; transition: all 0.15s;" onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#93c5fd';" onmouseout="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe';">
                            100%
                        </button>
                        <button type="button" class="btn btn-xs" id="btnPreviewZoomIn" title="Perbesar (+)" style="border: none; background: transparent; color: #1e40af; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.15s;" onmouseover="this.style.background='#eff6ff'; this.style.color='#2563eb';" onmouseout="this.style.background='transparent'; this.style.color='#1e40af';">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                        <div style="width: 1px; height: 18px; background: #e2e8f0; margin: 0 2px;"></div>
                        <button type="button" class="btn btn-xs font-w600" id="btnPreviewRotate" title="Putar Gambar (90°)" style="border: 1px solid #bfdbfe; background: #eff6ff; color: #2563eb; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.15s;" onmouseover="this.style.background='#2563eb'; this.style.color='#ffffff'; this.style.borderColor='#2563eb';" onmouseout="this.style.background='#eff6ff'; this.style.color='#2563eb'; this.style.borderColor='#bfdbfe';">
                            <i class="fa-solid fa-rotate-right"></i>
                        </button>
                    </div>

                    <!-- Open in New Tab -->
                    <a href="#" target="_blank" id="btnPreviewNewTab" class="btn btn-xs font-w600 shadow-sm d-inline-flex align-items-center" title="Buka di Tab Baru" style="border-radius: 8px; padding: 6px 12px; font-size: 12px; background: #ffffff; color: #334155; border: 1.5px solid #cbd5e1; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1';">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1 text-primary"></i> Buka Tab
                    </a>

                    <!-- Download Button -->
                    <a href="#" download id="btnPreviewDownload" class="btn btn-xs font-w700 text-white shadow-sm d-inline-flex align-items-center" title="Download Berkas" style="border-radius: 8px; padding: 6px 14px; font-size: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);">
                        <i class="fa-solid fa-download mr-1"></i> Unduh
                    </a>

                    <!-- Vertical Separator Before Close Button -->
                    <div style="width: 1.5px; height: 26px; background: #cbd5e1; margin: 0 4px;"></div>

                    <!-- Separated Distinct Close Button -->
                    <button type="button" class="btn btn-xs font-w600 d-inline-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close" title="Tutup Preview" style="width: 34px; height: 34px; border-radius: 8px; border: 1.5px solid #cbd5e1; background: #ffffff; color: #64748b; padding: 0; margin: 0 !important; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'; this.style.color='#dc2626'; this.style.borderColor='#fca5a5';" onmouseout="this.style.background='#ffffff'; this.style.color='#64748b'; this.style.borderColor='#cbd5e1';">
                        <i class="fa-solid fa-xmark" style="font-size: 15px;"></i>
                    </button>
                </div>
            </div>

            <!-- Sub-Header Bar: Tab Toggle untuk Foto Pemeriksaan & Tindakan (Hanya jika sesi memiliki 2 foto) -->
            <div id="modalPhotoTabs" class="d-none px-4 py-3 align-items-center justify-content-between flex-wrap" style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; gap: 14px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04); position: relative; z-index: 5;">
                <div class="d-flex align-items-center font-w600" style="font-size: 12.5px; color: #475569; gap: 8px;">
                    <i class="fa-solid fa-images text-primary" style="font-size: 14px;"></i>
                    <span>Pilih Foto Dokumentasi Terapi:</span>
                </div>
                <div class="d-flex align-items-center flex-wrap" id="photoTabsGroup" style="gap: 10px;">
                    <button type="button" class="btn btn-sm font-w700 d-inline-flex align-items-center" id="btnSwitchPemeriksaan" style="padding: 7px 16px; font-size: 12px; border-radius: 8px; gap: 8px; transition: all 0.2s ease;">
                        <i class="fa-solid fa-stethoscope" style="font-size: 12.5px;"></i>
                        <span>Foto Pemeriksaan</span>
                    </button>
                    <button type="button" class="btn btn-sm font-w700 d-inline-flex align-items-center" id="btnSwitchTindakan" style="padding: 7px 16px; font-size: 12px; border-radius: 8px; gap: 8px; transition: all 0.2s ease;">
                        <i class="fa-solid fa-hand-holding-medical" style="font-size: 12.5px;"></i>
                        <span>Foto Tindakan</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body (Viewer Canvas) -->
            <div class="modal-body p-0" style="background: #0f172a; min-height: 480px; max-height: 72vh; overflow: auto; position: relative; display: flex; align-items: center; justify-content: center;">
                
                <!-- Loading Indicator Overlay for PDF & Image Rendering -->
                <div id="previewLoadingIndicator" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: #0f172a; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #ffffff; gap: 14px;">
                    <div class="spinner-border text-primary" role="status" style="width: 2.8rem; height: 2.8rem; border-width: 3px;">
                        <span class="sr-only">Memuat...</span>
                    </div>
                    <div style="font-size: 13px; font-weight: 600; color: #cbd5e1; letter-spacing: 0.3px;">
                        <i class="fa-solid fa-circle-notch fa-spin text-primary mr-1"></i> <span id="previewLoadingText">Memuat dokumen...</span>
                    </div>
                </div>

                <!-- Image View Surface -->
                <div id="previewImageWrapper" style="width: 100%; height: 100%; min-height: 480px; display: flex; align-items: center; justify-content: center; overflow: auto; padding: 36px 24px; user-select: none; cursor: grab;">
                    <img id="previewImageElement" src="" alt="Berkas Preview" style="max-width: 100%; max-height: 62vh; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.6); transition: transform 0.2s ease-out; transform-origin: center center;" />
                </div>

                <!-- PDF / Iframe View Surface -->
                <div id="previewPdfWrapper" style="width: 100%; height: 68vh; display: none; position: relative; width: 100%;">
                    <iframe id="previewPdfElement" src="" style="width: 100%; height: 100%; border: none; background: #ffffff;"></iframe>
                </div>
            </div>

            <!-- Modal Footer Information Strip -->
            <div class="modal-footer py-2.5 px-4 d-flex justify-content-between align-items-center" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                <div class="d-flex align-items-center text-muted" style="font-size: 12px; gap: 15px;">
                    <div>
                        <i class="fa-solid fa-file-circle-check text-success mr-1"></i>
                        <span id="previewDocFileName" class="font-w600 text-dark">-</span>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="badge badge-light border text-muted font-w600" style="font-size: 11px; padding: 4px 8px; border-radius: 5px;">
                            <i class="fa-solid fa-shield-halved text-primary mr-1"></i> Dokumen Rekam Medis Rahasia
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap: 8px;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 6px 18px; font-size: 12.5px; color: #475569;">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Interactive Document / Berkas Previewer Handler
    var currentZoom = 1;
    var currentRotation = 0;
    var currentPhotoData = null;

    function updateImageTransform() {
        $('#previewImageElement').css('transform', 'scale(' + currentZoom + ') rotate(' + currentRotation + 'deg)');
        $('#btnPreviewZoomReset').text(Math.round(currentZoom * 100) + '%');
    }

    function loadPreviewImage(url, filename, title, iconClass) {
        currentZoom = 1;
        currentRotation = 0;
        updateImageTransform();

        $('#previewDocTitle').text(title);
        $('#previewDocFileName').text(filename || 'foto-sesi');
        $('#btnPreviewNewTab').attr('href', url);
        $('#btnPreviewDownload').attr('href', url).attr('download', filename || 'foto-sesi');
        if (iconClass) {
            $('#previewDocIcon').attr('class', iconClass);
        }

        $('#previewZoomControls').show();
        $('#previewPdfWrapper').hide();
        $('#previewImageWrapper').show();
        $('#previewLoadingText').text('Memuat foto dokumentasi...');
        $('#previewLoadingIndicator').show();

        $('#previewImageElement').off('load').on('load', function() {
            $('#previewLoadingIndicator').fadeOut(200);
        });
        $('#previewImageElement').attr('src', url);

        setTimeout(function() {
            $('#previewLoadingIndicator').fadeOut(200);
        }, 1200);
    }

    // Handler untuk Berkas Dokumen Pasien (KK / Resume Medis)
    $(document).on('click', '.btn-open-preview-berkas', function(e) {
        e.preventDefault();
        var btn = $(this);
        var docType = btn.data('type');
        var docTitle = btn.data('title') || 'Berkas Dokumen';
        var docUrl = btn.data('url');
        var docFileName = btn.data('filename') || 'dokumen';

        $('#modalPhotoTabs').addClass('d-none').removeClass('d-flex');

        var isPdf = docUrl && (docUrl.toLowerCase().indexOf('.pdf') !== -1 || docFileName.toLowerCase().indexOf('.pdf') !== -1);

        if (isPdf) {
            currentZoom = 1;
            currentRotation = 0;
            updateImageTransform();

            $('#previewDocTitle').text(docTitle);
            $('#previewDocFileName').text(docFileName);
            $('#btnPreviewNewTab').attr('href', docUrl);
            $('#btnPreviewDownload').attr('href', docUrl).attr('download', docFileName);
            $('#previewDocIcon').attr('class', docType === 'kk' ? 'fa-solid fa-people-roof' : 'fa-solid fa-file-medical');

            $('#previewLoadingText').text('Memuat dokumen PDF...');
            $('#previewZoomControls').hide();
            $('#previewImageWrapper').hide();
            $('#previewPdfWrapper').show();
            $('#previewLoadingIndicator').show();

            $('#previewPdfElement').off('load').on('load', function() {
                $('#previewLoadingIndicator').fadeOut(200);
            });
            $('#previewPdfElement').attr('src', docUrl);

            setTimeout(function() {
                $('#previewLoadingIndicator').fadeOut(200);
            }, 1500);
        } else {
            loadPreviewImage(docUrl, docFileName, docTitle, docType === 'kk' ? 'fa-solid fa-people-roof' : 'fa-solid fa-file-medical');
        }

        $('#modalPreviewBerkas').modal('show');
    });

    // Handler untuk Satu Tombol Foto Sesi Terpadu
    $(document).on('click', '.btn-open-foto-sesi', function(e) {
        e.preventDefault();
        var btn = $(this);
        var pemUrl = btn.data('pem-url');
        var pemFile = btn.data('pem-file');
        var tindUrl = btn.data('tind-url');
        var tindFile = btn.data('tind-file');
        var tanggal = btn.data('tanggal') || 'Sesi Terapi';

        currentPhotoData = {
            pemUrl: pemUrl,
            pemFile: pemFile,
            tindUrl: tindUrl,
            tindFile: tindFile,
            tanggal: tanggal
        };

        if (pemUrl && tindUrl) {
            // Sesi memiliki kedua foto -> tampilkan switcher tab
            $('#modalPhotoTabs').removeClass('d-none').addClass('d-flex');
            setActivePhotoTab('pemeriksaan');
        } else if (pemUrl) {
            // Hanya ada foto pemeriksaan
            $('#modalPhotoTabs').addClass('d-none').removeClass('d-flex');
            loadPreviewImage(pemUrl, pemFile, 'Foto Pemeriksaan Fisik (' + tanggal + ')', 'fa-solid fa-camera text-primary');
        } else if (tindUrl) {
            // Hanya ada foto tindakan
            $('#modalPhotoTabs').addClass('d-none').removeClass('d-flex');
            loadPreviewImage(tindUrl, tindFile, 'Foto Tindakan Terapi (' + tanggal + ')', 'fa-solid fa-camera text-primary');
        }

        $('#modalPreviewBerkas').modal('show');
    });

    function setActivePhotoTab(tab) {
        if (!currentPhotoData) return;

        if (tab === 'pemeriksaan') {
            $('#btnSwitchPemeriksaan').removeClass('btn-light text-dark').addClass('btn-primary shadow-sm').css({
                'background': '#2563eb',
                'color': '#ffffff',
                'border': '1.5px solid #2563eb',
                'box-shadow': '0 2px 8px rgba(37, 99, 235, 0.25)'
            });
            $('#btnSwitchTindakan').removeClass('btn-primary shadow-sm').addClass('btn-light text-dark').css({
                'background': '#ffffff',
                'color': '#475569',
                'border': '1.5px solid #cbd5e1',
                'box-shadow': 'none'
            });
            loadPreviewImage(currentPhotoData.pemUrl, currentPhotoData.pemFile, 'Foto Pemeriksaan Fisik (' + currentPhotoData.tanggal + ')', 'fa-solid fa-stethoscope text-primary');
        } else {
            $('#btnSwitchTindakan').removeClass('btn-light text-dark').addClass('btn-primary shadow-sm').css({
                'background': '#2563eb',
                'color': '#ffffff',
                'border': '1.5px solid #2563eb',
                'box-shadow': '0 2px 8px rgba(37, 99, 235, 0.25)'
            });
            $('#btnSwitchPemeriksaan').removeClass('btn-primary shadow-sm').addClass('btn-light text-dark').css({
                'background': '#ffffff',
                'color': '#475569',
                'border': '1.5px solid #cbd5e1',
                'box-shadow': 'none'
            });
            loadPreviewImage(currentPhotoData.tindUrl, currentPhotoData.tindFile, 'Foto Tindakan Terapi (' + currentPhotoData.tanggal + ')', 'fa-solid fa-hand-holding-medical text-primary');
        }
    }

    $('#btnSwitchPemeriksaan').on('click', function() {
        setActivePhotoTab('pemeriksaan');
    });

    $('#btnSwitchTindakan').on('click', function() {
        setActivePhotoTab('tindakan');
    });

    // Zoom Controls
    $('#btnPreviewZoomIn').on('click', function() {
        if (currentZoom < 4) {
            currentZoom = Math.min(4, Math.round((currentZoom + 0.25) * 100) / 100);
            updateImageTransform();
        }
    });

    $('#btnPreviewZoomOut').on('click', function() {
        if (currentZoom > 0.4) {
            currentZoom = Math.max(0.4, Math.round((currentZoom - 0.25) * 100) / 100);
            updateImageTransform();
        }
    });

    $('#btnPreviewZoomReset').on('click', function() {
        currentZoom = 1;
        currentRotation = 0;
        updateImageTransform();
    });

    $('#btnPreviewRotate').on('click', function() {
        currentRotation = (currentRotation + 90) % 360;
        updateImageTransform();
    });

    // Mouse Wheel Zoom on image canvas
    $('#previewImageWrapper').on('wheel', function(e) {
        e.preventDefault();
        if (e.originalEvent.deltaY < 0) {
            if (currentZoom < 4) {
                currentZoom = Math.min(4, Math.round((currentZoom + 0.15) * 100) / 100);
                updateImageTransform();
            }
        } else {
            if (currentZoom > 0.4) {
                currentZoom = Math.max(0.4, Math.round((currentZoom - 0.15) * 100) / 100);
                updateImageTransform();
            }
        }
    });

    // Double click to reset zoom
    $('#previewImageWrapper').on('dblclick', function(e) {
        currentZoom = 1;
        currentRotation = 0;
        updateImageTransform();
    });
</script>
@endsection

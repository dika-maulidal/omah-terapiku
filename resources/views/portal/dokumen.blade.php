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
                <div class="d-flex align-items-center">
                    <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                            Dokumen & Cetak Laporan Asesmen
                        </h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                            Unduh dan cetak berkas laporan medis, ringkasan asesmen, dan dokumen pendukung
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. Cetak Laporan Terapi & Asesmen Terpadu (Catatan Sesi, Asesmen 15 Modul, Home Program) -->
    <div class="col-lg-7 col-md-12 mb-4">
        <div class="card shadow-sm h-100 doc-card" style="border: 1px solid #e2e8f0; border-radius: 12px;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                <div>
                    <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                        <i class="fa-solid fa-print text-primary mr-2"></i> Cetak Laporan Terapi & Asesmen Terpadu
                    </h4>
                    <p class="text-muted mb-0 mt-0.5" style="font-size: 12px;">
                        Pilihan cetak berkas lengkap: Lembar Asesmen Klinis, Catatan Sesi Terapi, dan Panduan Home Program
                    </p>
                </div>
                <span class="badge font-w700" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                    {{ $pasien->assessments ? $pasien->assessments->count() : 0 }} Asesmen
                </span>
            </div>
            <div class="card-body p-0">
                @if($pasien->assessments && $pasien->assessments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($pasien->assessments as $asm)
                            <div class="doc-item d-flex justify-content-between align-items-center flex-wrap" style="gap: 14px;">
                                <div style="flex: 1; min-width: 240px;">
                                    <h6 class="font-w700 text-dark mb-1" style="font-size: 14.5px;">
                                        <i class="fa-solid fa-file-waveform text-primary mr-1.5"></i>
                                        Laporan Asesmen Klinis Terpadu (15 Modul)
                                    </h6>
                                    <div class="text-muted mb-1.5" style="font-size: 12.5px;">
                                        <i class="fa-regular fa-calendar-check mr-1 text-primary"></i> Sesi: <strong>{{ $asm->tgl_assessment ? \Carbon\Carbon::parse($asm->tgl_assessment)->isoFormat('D MMMM Y') : '-' }}</strong> &bull; 
                                        <i class="fa-solid fa-user-doctor mr-1 text-primary"></i> {{ $asm->dokter ? $asm->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}
                                    </div>
                                    <div class="d-flex align-items-center flex-wrap" style="gap: 5px;">
                                        @if($asm->gmfm_total_persen !== null)
                                            <span class="badge font-w700" style="font-size: 11px; padding: 3px 8px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                                GMFM: {{ $asm->gmfm_total_persen }}%
                                            </span>
                                        @endif
                                        @if($asm->denver_kesimpulan)
                                            <span class="badge font-w700" style="font-size: 11px; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                Denver: {{ $asm->denver_kesimpulan }}
                                            </span>
                                        @endif
                                        @if($asm->nyeri_skor_total !== null)
                                            <span class="badge font-w700" style="font-size: 11px; padding: 3px 8px; border-radius: 6px; background: #fffbeb; color: #d97706; border: 1px solid #fde68a;">
                                                VAS: {{ $asm->nyeri_skor_total }}/10
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                                    @if($asm->rekam_id)
                                        <a href="{{ route('rekam.assessment.print', $asm->rekam_id) }}" target="_blank" class="btn btn-sm btn-primary font-w700 shadow-sm" style="border-radius: 6px; padding: 6px 12px; font-size: 12px;" title="Cetak Lembar Asesmen Lengkap">
                                            <i class="fa-solid fa-file-pdf mr-1"></i> Asesmen
                                        </a>
                                        <a href="{{ route('rekam.soap.print', $asm->rekam_id) }}" target="_blank" class="btn btn-sm btn-outline-primary font-w700" style="border-radius: 6px; padding: 6px 12px; font-size: 12px;" title="Cetak Catatan Sesi Terapi">
                                            <i class="fa-solid fa-file-lines mr-1"></i> Catatan Sesi
                                        </a>
                                        <a href="{{ route('rekam.home-program.print', $asm->rekam_id) }}" target="_blank" class="btn btn-sm btn-outline-success font-w700" style="border-radius: 6px; padding: 6px 12px; font-size: 12px;" title="Cetak Panduan Home Program">
                                            <i class="fa-solid fa-house-chimney mr-1"></i> Home Program
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 56px; height: 56px; background: #eff6ff; color: #2563eb; font-size: 24px; border: 1px solid #bfdbfe;">
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                        <h5 class="font-w700 text-dark mb-1">Belum Ada Laporan Asesmen</h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">Laporan asesmen klinis dan catatan sesi terapi akan muncul setelah sesi pemeriksaan dicatat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. Berkas Dokumen Pasien (Dengan Popup Modal Interaktif) -->
    <div class="col-lg-5 col-md-12 mb-4">
        <div class="card shadow-sm h-100 doc-card" style="border: 1px solid #e2e8f0; border-radius: 12px;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                <h4 class="card-title font-w700 mb-0" style="color: var(--ot-navy, #1e40af); font-size: 16px;">
                    <i class="fa-solid fa-folder-open text-primary mr-2"></i> Berkas Dokumen Pasien
                </h4>
                <span class="badge badge-light border text-muted font-w600" style="font-size: 11px;">
                    Identitas & Rujukan
                </span>
            </div>
            <div class="card-body p-4">
                <!-- Berkas Kartu Keluarga (KK) -->
                <div class="file-box mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded p-2.5 mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                                <i class="fa-solid fa-people-roof"></i>
                            </div>
                            <div>
                                <h6 class="font-w700 text-dark mb-0.5" style="font-size: 14px;">Kartu Keluarga (KK)</h6>
                                <span class="text-muted" style="font-size: 12px;">Identitas kependudukan & domisili keluarga</span>
                            </div>
                        </div>
                        <div>
                            @if($pasien->file_kk)
                                <button type="button" class="btn btn-sm btn-outline-primary font-w700 btn-open-preview-berkas" 
                                    data-type="kk" 
                                    data-title="Kartu Keluarga (KK)" 
                                    data-url="{{ $pasien->getFileKk() }}" 
                                    data-filename="{{ $pasien->file_kk }}"
                                    style="border-radius: 6px; padding: 6px 14px; font-size: 12.5px;">
                                    <i class="fa-solid fa-eye mr-1.5"></i> Lihat
                                </button>
                            @else
                                <span class="badge font-w600" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Belum Ada
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Berkas Resume Medis / Rujukan -->
                <div class="file-box mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded p-2.5 mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ecfdf5; color: #10b981; font-size: 20px; border: 1px solid #a7f3d0; border-radius: 10px;">
                                <i class="fa-solid fa-file-medical"></i>
                            </div>
                            <div>
                                <h6 class="font-w700 text-dark mb-0.5" style="font-size: 14px;">Resume Medis / Rujukan</h6>
                                <span class="text-muted" style="font-size: 12px;">Surat rujukan dokter spesialis / riwayat berobat</span>
                            </div>
                        </div>
                        <div>
                            @if($pasien->file_resume)
                                <button type="button" class="btn btn-sm btn-outline-success font-w700 btn-open-preview-berkas" 
                                    data-type="resume" 
                                    data-title="Resume Berobat / Rujukan Medis" 
                                    data-url="{{ $pasien->getFileResume() }}" 
                                    data-filename="{{ $pasien->file_resume }}"
                                    style="border-radius: 6px; padding: 6px 14px; font-size: 12.5px;">
                                    <i class="fa-solid fa-eye mr-1.5"></i> Lihat
                                </button>
                            @else
                                <span class="badge font-w600" style="font-size: 11.5px; padding: 5px 10px; border-radius: 6px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Belum Ada
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="p-3 rounded" style="background: #eff6ff; border: 1px solid #bfdbfe; font-size: 12.5px; border-radius: 10px;">
                    <div class="d-flex align-items-start">
                        <i class="fa-solid fa-circle-info text-primary mr-2 mt-1" style="font-size: 15px;"></i>
                        <span style="color: #1e40af; line-height: 1.5;">
                            Dokumen PDF yang diunduh dapat digunakan saat rujukan ke fasilitas kesehatan atau saat pelaporan evaluasi berkala di Dinas Sosial.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL POPUP PREVIEW BERKAS DOKUMEN PASIEN (INTERAKTIF)   -->
<!-- ======================================================== -->
<div class="modal fade" id="modalPreviewBerkas" tabindex="-1" role="dialog" aria-hidden="true" style="backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 880px;" role="document">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 12px 40px rgba(15, 23, 42, 0.28); overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-header d-flex justify-content-between align-items-center py-3 px-4" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color: #ffffff;">
                <div class="d-flex align-items-center">
                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 10px; background: rgba(255, 255, 255, 0.16); color: #ffffff; font-size: 18px; flex-shrink: 0; backdrop-filter: blur(4px);">
                        <i id="previewDocIcon" class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 text-white mb-0" id="previewDocTitle" style="font-size: 16px;">Preview Berkas</h5>
                        <small class="text-white-50" style="font-size: 11.5px;">
                            <span id="previewDocPatient">{{ $pasien->nama }}</span> &bull; No. RM: {{ $pasien->no_rm }} &bull; NIK: {{ $pasien->nik ?: '-' }}
                        </small>
                    </div>
                </div>

                <!-- Controls & Actions -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <!-- Zoom Controls (for images) -->
                    <div class="btn-group btn-group-sm" id="previewZoomControls" style="background: rgba(255, 255, 255, 0.16); border-radius: 6px; padding: 2px;">
                        <button type="button" class="btn btn-xs text-white" id="btnPreviewZoomOut" title="Perkecil (-)" style="border: none; padding: 4px 8px;">
                            <i class="fa-solid fa-magnifying-glass-minus"></i>
                        </button>
                        <button type="button" class="btn btn-xs text-white font-w600" id="btnPreviewZoomReset" title="Reset Ukuran (100%)" style="border: none; padding: 4px 8px; font-size: 11px;">
                            100%
                        </button>
                        <button type="button" class="btn btn-xs text-white" id="btnPreviewZoomIn" title="Perbesar (+)" style="border: none; padding: 4px 8px;">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                        <button type="button" class="btn btn-xs text-white" id="btnPreviewRotate" title="Putar Gambar (90°)" style="border: none; padding: 4px 8px;">
                            <i class="fa-solid fa-rotate-right"></i>
                        </button>
                    </div>

                    <!-- Open in New Tab -->
                    <a href="#" target="_blank" id="btnPreviewNewTab" class="btn btn-xs btn-light font-w600 shadow-sm" title="Buka di Tab Baru" style="border-radius: 6px; padding: 5px 10px; font-size: 11.5px;">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka Tab
                    </a>

                    <!-- Download Button -->
                    <a href="#" download id="btnPreviewDownload" class="btn btn-xs btn-success font-w600 text-white shadow-sm" title="Download Berkas" style="border-radius: 6px; padding: 5px 12px; font-size: 11.5px; background: #10b981 !important; border: none !important;">
                        <i class="fa-solid fa-download mr-1"></i> Unduh
                    </a>

                    <!-- Close Button -->
                    <button type="button" class="close text-white ml-2" data-dismiss="modal" aria-label="Close" style="opacity: 0.9; text-shadow: none; font-size: 24px; line-height: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body (Viewer Canvas) -->
            <div class="modal-body p-0" style="background: #0f172a; min-height: 480px; max-height: 72vh; overflow: auto; position: relative; display: flex; align-items: center; justify-content: center;">
                
                <!-- Image View Surface -->
                <div id="previewImageWrapper" style="width: 100%; height: 100%; min-height: 480px; display: flex; align-items: center; justify-content: center; overflow: auto; padding: 24px; user-select: none;">
                    <img id="previewImageElement" src="" alt="Berkas Preview" style="max-width: 100%; max-height: 65vh; object-fit: contain; border-radius: 6px; box-shadow: 0 10px 30px rgba(0,0,0,0.6); transition: transform 0.2s ease-out; transform-origin: center center;" />
                </div>

                <!-- PDF / Iframe View Surface -->
                <div id="previewPdfWrapper" style="width: 100%; height: 68vh; display: none;">
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
                        <i class="fa-solid fa-shield-halved text-primary mr-1"></i> Dokumen Rekam Medis Rahasia
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap: 8px;">
                    <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 5px 16px; font-size: 12px;">
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

    function updateImageTransform() {
        $('#previewImageElement').css('transform', 'scale(' + currentZoom + ') rotate(' + currentRotation + 'deg)');
        $('#btnPreviewZoomReset').text(Math.round(currentZoom * 100) + '%');
    }

    $(document).on('click', '.btn-open-preview-berkas', function(e) {
        e.preventDefault();
        var btn = $(this);
        var docType = btn.data('type');
        var docTitle = btn.data('title') || 'Berkas Dokumen';
        var docUrl = btn.data('url');
        var docFileName = btn.data('filename') || 'dokumen';

        currentZoom = 1;
        currentRotation = 0;
        updateImageTransform();

        $('#previewDocTitle').text(docTitle);
        $('#previewDocFileName').text(docFileName);
        $('#btnPreviewNewTab').attr('href', docUrl);
        $('#btnPreviewDownload').attr('href', docUrl).attr('download', docFileName);

        if (docType === 'kk') {
            $('#previewDocIcon').attr('class', 'fa-solid fa-people-roof');
        } else {
            $('#previewDocIcon').attr('class', 'fa-solid fa-file-medical');
        }

        var isPdf = docUrl && (docUrl.toLowerCase().indexOf('.pdf') !== -1 || docFileName.toLowerCase().indexOf('.pdf') !== -1);

        if (isPdf) {
            $('#previewZoomControls').hide();
            $('#previewImageWrapper').hide();
            $('#previewPdfWrapper').show();
            $('#previewPdfElement').attr('src', docUrl);
        } else {
            $('#previewZoomControls').show();
            $('#previewPdfWrapper').hide();
            $('#previewImageWrapper').show();
            $('#previewImageElement').attr('src', docUrl);
        }

        $('#modalPreviewBerkas').modal('show');
    });

    // Zoom Controls
    $('#btnPreviewZoomIn').on('click', function() {
        if (currentZoom < 3) {
            currentZoom = Math.min(3, currentZoom + 0.25);
            updateImageTransform();
        }
    });

    $('#btnPreviewZoomOut').on('click', function() {
        if (currentZoom > 0.5) {
            currentZoom = Math.max(0.5, currentZoom - 0.25);
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
</script>
@endsection

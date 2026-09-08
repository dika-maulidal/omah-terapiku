<!-- Modal Edit / Tambah Catatan Assessment (A) Terapi & ICD-10 -->
<div class="modal fade" id="addDiagnosa" tabindex="-1" role="dialog" aria-labelledby="addDiagnosaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 960px; width: 95%; max-height: 92vh; margin: 1.75rem auto;">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #bfdbfe; box-shadow: 0 16px 40px rgba(30, 64, 175, 0.16); max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <!-- Modal Header (Royal Blue Gradient & Soft Blue Accent sesuai DESIGN.md) -->
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 44px; height: 44px; border-radius: 12px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 20px; border: 1.5px solid #bfdbfe; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12); flex-shrink: 0;">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" id="addDiagnosaLabel" style="color: #1e40af !important; font-size: 17px; letter-spacing: -0.2px;">
                            Assessment (A) — Catatan Asesmen & Diagnosa ICD-10
                        </h5>
                        <small class="text-muted font-w500" style="font-size: 12px;">Catatan kesimpulan klinis, klasifikasi diagnosa ICD-10, dan evaluasi capaian sesi</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body Scrollable -->
            <div class="modal-body p-4" style="background: #ffffff; overflow-y: auto; max-height: calc(90vh - 130px); position: relative;">
                <form action="{{Route('diagnosa.update')}}" method="POST" id="formAssessmentDiagnosa">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalAssessmentRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalAssessmentPasienId" name="pasien_id" value="{{$pasien->id}}">
                    
                    <!-- Shortcut Ke Lembar Asesmen 15 Modul -->
                    <div class="p-3 mb-3 d-flex align-items-center justify-content-between flex-wrap rounded" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1.5px solid #bfdbfe; border-radius: 10px !important; gap: 10px;">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 8px; background: #ffffff; color: #2563eb; font-size: 16px; border: 1px solid #bfdbfe; flex-shrink: 0;">
                                <i class="fa-solid fa-file-medical"></i>
                            </div>
                            <div>
                                <strong class="d-block" style="color: #1e40af; font-size: 13.5px; font-weight: 700;">
                                    Lembar Asesmen Komprehensif (15 Modul Klinis)
                                </strong>
                                <small class="text-muted font-w500" style="font-size: 11.5px;">GMFM-88, Denver II, ROM & MMT, Body Chart Nyeri, Wicara, ADL Barthel Index, dsb.</small>
                            </div>
                        </div>
                        <a href="javascript:void(0)" id="modalAssessmentGoToForm" class="btn btn-sm btn-primary font-w700" style="font-size: 12.5px; padding: 8px 16px; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1.5"></i> Buka Form Asesmen 15 Modul
                        </a>
                    </div>

                    <!-- Pilihan Cepat Kode ICD-10 Standar -->
                    @php
                        $icdList = \App\Models\Icd::orderBy('code', 'asc')->get();
                    @endphp
                    @if($icdList->count() > 0)
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-2" style="gap: 8px;">
                                <label class="font-w700 mb-0" style="font-size: 13px; color: #1e40af;">
                                    <i class="fa-solid fa-book-medical mr-1.5" style="color: #2563eb;"></i> Klasifikasi Diagnosa ICD-10 Standar:
                                    <small class="text-muted font-w400" style="font-size: 11.5px;">(Klik untuk menambahkan kode & nama diagnosa ke teks)</small>
                                </label>
                                <div class="position-relative" style="min-width: 260px;">
                                    <input type="text" id="searchIcdModal" class="form-control form-control-sm" placeholder="Cari kode atau nama diagnosa..." style="height: 34px; font-size: 12px; border-radius: 8px; border: 1.5px solid #bfdbfe; padding-left: 32px; background: #f8fafc;">
                                    <i class="fa-solid fa-magnifying-glass position-absolute" style="left: 11px; top: 11px; color: #2563eb; font-size: 12px;"></i>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-wrap p-3 rounded" id="icdChipsContainer" style="background: #f8fafc; border: 1.5px solid #dbeafe; border-radius: 10px; gap: 8px; max-height: 190px; overflow-y: auto;">
                                @foreach($icdList as $icdItem)
                                    <button type="button" 
                                            class="btn btn-sm btn-chip-assessment icd-chip-btn font-w600" 
                                            data-text="[{{ $icdItem->code }}] {{ $icdItem->name_id }}" 
                                            style="font-size: 12px; padding: 6px 12px; border-radius: 8px; background: #ffffff; border: 1.5px solid #bfdbfe; color: #1e40af; box-shadow: 0 1px 4px rgba(37, 99, 235, 0.06); display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-plus" style="color: #2563eb !important; font-size: 11px;"></i>
                                        <span style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; padding: 1.5px 6px; border-radius: 5px; font-weight: 700; font-size: 11.5px;">{{ $icdItem->code }}</span>
                                        <span style="color: #334155; font-weight: 600;">{{ $icdItem->name_id }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Input Catatan Assessment -->
                    <div class="form-group mb-4">
                        <label class="font-w700 mb-1 d-flex align-items-center justify-content-between" style="font-size: 13px; color: #1e293b;">
                            <span>
                                <i class="fa-solid fa-file-pen mr-1.5" style="color: #2563eb;"></i> Catatan Assessment Terapi, Diagnosa & Kode ICD-10 <span class="text-danger">*</span>
                            </span>
                            <small class="text-muted font-w400" style="font-size: 11.5px;">Dapat diisi kombinasi kode ICD-10 dan narasi evaluasi terapis</small>
                        </label>
                        <textarea name="diagnosa" id="modalAssessmentTextarea" required class="form-control" rows="5" 
                                  placeholder="Klik opsi diagnosa ICD-10 di atas atau tuliskan catatan evaluasi terapi, kesimpulan asesmen, serta target fungsional..." 
                                  style="font-size: 13.5px; line-height: 1.6; border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 12px 14px; min-height: 130px;"></textarea>
                        @error('diagnosa')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <!-- Sticky Footer Form Action -->
                    <div class="modal-sticky-footer mt-4 d-flex align-items-center justify-content-between" style="position: sticky; bottom: -24px; margin-left: -24px; margin-right: -24px; margin-bottom: -24px; padding: 14px 24px; background: #f8fafc; border-top: 1.5px solid #e2e8f0; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px; box-shadow: 0 -4px 15px rgba(0,0,0,0.04); z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 20px; font-size: 13px; border: 1.5px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 26px; font-size: 13px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Assessment (A)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .icd-chip-btn {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border-color: #bfdbfe !important;
        background: #ffffff !important;
    }
    .icd-chip-btn:hover {
        background: #eff6ff !important;
        border-color: #2563eb !important;
        color: #1e40af !important;
        transform: translateY(-1.5px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.16) !important;
    }
    .icd-chip-btn:hover i {
        color: #1d4ed8 !important;
    }
    .icd-chip-btn:active {
        transform: scale(0.98);
    }
    #modalAssessmentTextarea:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        outline: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.getElementById("searchIcdModal");
        if (searchInput) {
            searchInput.addEventListener("input", function() {
                var query = this.value.toLowerCase().trim();
                var chips = document.querySelectorAll(".icd-chip-btn");
                chips.forEach(function(chip) {
                    var text = chip.textContent.toLowerCase();
                    if (!query || text.indexOf(query) > -1) {
                        chip.style.display = "inline-flex";
                    } else {
                        chip.style.display = "none";
                    }
                });
            });
        }
    });
</script>

<!-- Modal Edit / Tambah Catatan Plan & Intervensi Tindakan (P) Terapi -->
<div class="modal fade" id="addTindakan" tabindex="-1" role="dialog" aria-labelledby="addTindakanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 960px; width: 95%; max-height: 92vh; margin: 1.75rem auto;">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #bfdbfe; box-shadow: 0 16px 40px rgba(30, 64, 175, 0.16); max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <!-- Modal Header (Royal Blue Gradient & Soft Blue Accent sesuai DESIGN.md) -->
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 44px; height: 44px; border-radius: 12px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 20px; border: 1.5px solid #bfdbfe; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12); flex-shrink: 0;">
                        <i class="fa-solid fa-hand-holding-medical"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" id="addTindakanLabel" style="color: #1e40af !important; font-size: 17px; letter-spacing: -0.2px;">
                            Plan (P) — Rencana Tindakan & Intervensi Terapi
                        </h5>
                        <small class="text-muted font-w500" style="font-size: 12px;">Tindakan terapi fisik, okupasi, wicara, latihan fungsional, dan rekomendasi home program</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body Scrollable -->
            <div class="modal-body p-4" style="background: #ffffff; overflow-y: auto; max-height: calc(90vh - 130px); position: relative;">
                <form action="{{Route('tindakan.update')}}" method="POST" enctype="multipart/form-data" id="formPlanTindakan">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalTindakanRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalTindakanPasienId" name="pasien_id" value="{{$pasien->id}}">

                    <!-- Filter Kategori Layanan Tindakan & Search Box -->
                    <div class="mb-3 d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                            <label class="font-w700 mb-0" style="font-size: 13px; color: #1e40af;">
                                <i class="fa-solid fa-list-check mr-1.5" style="color: #2563eb;"></i> Kategori Disiplin:
                            </label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons" style="gap: 5px;">
                                <label class="btn btn-xs py-1 px-3 font-w600 btn-filter-tindakan active" data-target-discipline="all" style="border-radius: 6px; font-size: 11.5px; border: 1.5px solid #2563eb; background: #2563eb; color: #ffffff; cursor: pointer;">
                                    <input type="radio" name="filterDiscipline" checked> Semua
                                </label>
                                <label class="btn btn-xs py-1 px-3 font-w600 btn-filter-tindakan" data-target-discipline="fisioterapi" style="border-radius: 6px; font-size: 11.5px; border: 1.5px solid #bfdbfe; background: #ffffff; color: #1e40af; cursor: pointer;">
                                    <input type="radio" name="filterDiscipline"> Fisioterapi
                                </label>
                                <label class="btn btn-xs py-1 px-3 font-w600 btn-filter-tindakan" data-target-discipline="okupasi" style="border-radius: 6px; font-size: 11.5px; border: 1.5px solid #bfdbfe; background: #ffffff; color: #1e40af; cursor: pointer;">
                                    <input type="radio" name="filterDiscipline"> Okupasi
                                </label>
                                <label class="btn btn-xs py-1 px-3 font-w600 btn-filter-tindakan" data-target-discipline="wicara" style="border-radius: 6px; font-size: 11.5px; border: 1.5px solid #bfdbfe; background: #ffffff; color: #1e40af; cursor: pointer;">
                                    <input type="radio" name="filterDiscipline"> Wicara
                                </label>
                                <label class="btn btn-xs py-1 px-3 font-w600 btn-filter-tindakan" data-target-discipline="netra" style="border-radius: 6px; font-size: 11.5px; border: 1.5px solid #bfdbfe; background: #ffffff; color: #1e40af; cursor: pointer;">
                                    <input type="radio" name="filterDiscipline"> Netra
                                </label>
                            </div>
                        </div>
                        <div class="position-relative" style="min-width: 260px;">
                            <input type="text" id="searchTindakanModal" class="form-control form-control-sm" placeholder="Cari tindakan terapi..." style="height: 34px; font-size: 12px; border-radius: 8px; border: 1.5px solid #bfdbfe; padding-left: 32px; background: #f8fafc;">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="left: 11px; top: 11px; color: #2563eb; font-size: 12px;"></i>
                        </div>
                    </div>

                    <!-- Action Chips Container -->
                    <div class="p-3 mb-3 rounded border" style="background: #f8fafc; border: 1.5px solid #dbeafe; border-radius: 10px; max-height: 170px; overflow-y: auto;">
                        <div class="d-flex flex-wrap" id="tindakanChipsContainer" style="gap: 8px;">
                            @if(isset($masterTindakan) && count($masterTindakan) > 0)
                                @foreach($masterTindakan as $tdk)
                                    @php
                                        $discClass = 'umum';
                                        $poliLower = strtolower($tdk->poli ?? '');
                                        if (str_contains($poliLower, 'fisio')) {
                                            $discClass = 'fisioterapi';
                                        } elseif (str_contains($poliLower, 'okupasi') || str_contains($poliLower, 'sensori')) {
                                            $discClass = 'okupasi';
                                        } elseif (str_contains($poliLower, 'wicara')) {
                                            $discClass = 'wicara';
                                        } elseif (str_contains($poliLower, 'netra')) {
                                            $discClass = 'netra';
                                        }
                                    @endphp
                                    <button type="button" class="btn btn-sm btn-chip-tindakan tdk-chip-item tdk-disc-{{ $discClass }} font-w600" 
                                            data-discipline="{{ $discClass }}"
                                            data-name="{{ $tdk->nama }}" 
                                            data-code="{{ $tdk->kode }}"
                                            style="font-size: 12px; padding: 6px 12px; border-radius: 8px; background: #ffffff; border: 1.5px solid #bfdbfe; color: #1e40af; box-shadow: 0 1px 3px rgba(37,99,235,0.06); display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-plus" style="color: #2563eb !important; font-size: 11px;"></i>
                                        <span>{{ $tdk->nama }}</span>
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Textarea Catatan Tindakan / Plan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 mb-1" style="font-size: 13px; color: #1e293b;">
                            <i class="fa-solid fa-hand-holding-medical mr-1.5" style="color: #2563eb;"></i> Rincian Intervensi / Rencana Tindakan Terapi <span class="text-danger">*</span>
                        </label>
                        <textarea name="tindakan" id="modalTindakanTextarea" required class="form-control" rows="4" 
                                  placeholder="Klik opsi tindakan di atas atau tuliskan detail intervensi, modalitas, manipulasi, latihan fungsional..." 
                                  style="font-size: 13.5px; line-height: 1.6; border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 12px 14px;"></textarea>
                        @error('tindakan')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Textarea Program Latihan Rumahan & Edukasi Keluarga (Home Program) -->
                    <div class="form-group mb-3">
                        <label class="font-w700 mb-1 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #1e293b;">
                            <span>
                                <i class="fa-solid fa-house-user text-success mr-1.5"></i> Program Latihan Rumahan & Edukasi Keluarga (Home Program)
                            </span>
                            <span class="badge font-w600" style="font-size: 11px; background: #ecfdf5; color: #166534; border: 1px solid #bbf7d0; padding: 3px 8px; border-radius: 6px;">Latihan Mandiri / Keluarga</span>
                        </label>
                        <textarea name="latihan_rumahan" id="modalLatihanRumahanTextarea" class="form-control" rows="3" 
                                  placeholder="Tuliskan instruksi latihan mandiri di rumah untuk keluarga/wali, seperti: posisi berbaring/duduk yang benar, latihan peregangan 2x sehari (10 repetisi), stimulasi bicara interaktif, aktivitas motorik harian..." 
                                  style="font-size: 13.5px; line-height: 1.6; border-radius: 10px; border: 1.5px solid #bbf7d0; background: #fafffc; padding: 12px 14px;"></textarea>
                        <small class="text-muted d-block mt-1" style="font-size: 11.5px;">
                            <i class="fa-solid fa-circle-info text-info mr-1"></i> Panduan tugas dan latihan yang dapat dipraktikkan orang tua / wali penerima manfaat di rumah untuk percepatan hasil terapi.
                        </small>
                        @error('latihan_rumahan')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto Dokumentasi Tindakan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 mb-1" style="font-size: 13px; color: #1e293b;">
                            <i class="fa-solid fa-camera mr-1.5" style="color: #2563eb;"></i> Upload Foto Dokumentasi Tindakan / Latihan (Opsional)
                        </label>
                        <input type="file" name="file" class="form-control-file" accept=".jpg,.jpeg,.png" style="font-size: 12.5px;">
                        <small class="text-muted d-block mt-1" style="font-size: 11px;">Format: JPG, JPEG, PNG (Maks 5MB)</small>
                        @error('file')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <!-- Sticky Footer Action Bar -->
                    <div class="modal-sticky-footer mt-4 d-flex align-items-center justify-content-between" style="position: sticky; bottom: -24px; margin-left: -24px; margin-right: -24px; margin-bottom: -24px; padding: 14px 24px; background: #f8fafc; border-top: 1.5px solid #e2e8f0; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px; box-shadow: 0 -4px 15px rgba(0,0,0,0.04); z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 20px; font-size: 13px; border: 1.5px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 26px; font-size: 13px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Plan & Tindakan (P)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .tdk-chip-item {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff !important;
        border-color: #bfdbfe !important;
    }
    .tdk-chip-item:hover {
        background: #eff6ff !important;
        border-color: #2563eb !important;
        color: #1e40af !important;
        transform: translateY(-1.5px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.16) !important;
    }
    .tdk-chip-item:hover i {
        color: #1d4ed8 !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var searchTindakan = document.getElementById("searchTindakanModal");
        if (searchTindakan) {
            searchTindakan.addEventListener("input", function() {
                var query = this.value.toLowerCase().trim();
                var activeDisc = document.querySelector(".btn-filter-tindakan.active")?.getAttribute("data-target-discipline") || "all";
                var chips = document.querySelectorAll(".tdk-chip-item");
                chips.forEach(function(chip) {
                    var disc = chip.getAttribute("data-discipline");
                    var text = chip.textContent.toLowerCase();
                    var matchDisc = (activeDisc === 'all' || disc === activeDisc);
                    var matchQuery = (!query || text.indexOf(query) > -1);
                    if (matchDisc && matchQuery) {
                        chip.style.display = "inline-flex";
                    } else {
                        chip.style.display = "none";
                    }
                });
            });
        }
    });
</script>
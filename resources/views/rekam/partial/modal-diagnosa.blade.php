<!-- Modal Edit / Tambah Catatan Assessment (A) Terapi & ICD-10 -->
<div class="modal fade" id="addDiagnosa" tabindex="-1" role="dialog" aria-labelledby="addDiagnosaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 90vh;">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25); max-height: 88vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <!-- Modal Header dengan Kontras Navy Solid -->
            <div class="modal-header" style="background: #2D4B7A !important; color: #ffffff !important; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 14px 20px; border-bottom: none;">
                <div>
                    <h5 class="modal-title font-w700 mb-0" id="addDiagnosaLabel" style="font-size: 16.5px; color: #ffffff !important; letter-spacing: 0.3px;">
                        <i class="fa-solid fa-clipboard-check mr-2 text-warning"></i> Assessment (A) / Diagnosa Terapi & ICD-10
                    </h5>
                    <small class="d-block mt-1" style="color: #e2e8f0 !important; font-size: 12px;">Catatan kesimpulan klinis, klasifikasi diagnosa ICD-10, dan evaluasi capaian sesi</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff !important; opacity: 1 !important; text-shadow: none; font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body Scrollable -->
            <div class="modal-body p-4" style="background: #f8fafc; overflow-y: auto; max-height: calc(88vh - 130px); position: relative;">
                <form action="{{Route('diagnosa.update')}}" method="POST" id="formAssessmentDiagnosa">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalAssessmentRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalAssessmentPasienId" name="pasien_id" value="{{$pasien->id}}">
                    
                    <!-- Shortcut Ke Lembar Asesmen 15 Modul -->
                    <div class="p-3 mb-3 d-flex align-items-center justify-content-between flex-wrap rounded bg-white" style="border: 1px solid #cbd5e1; gap: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
                        <div>
                            <strong class="text-dark d-block" style="font-size: 13px;">
                                <i class="fa-solid fa-file-medical text-primary mr-1"></i> Lembar Asesmen Komprehensif (15 Modul Klinis)
                            </strong>
                            <small class="text-muted">GMFM-88, Denver II, ROM & MMT, Body Chart Nyeri, Wicara, ADL, dsb.</small>
                        </div>
                        <a href="javascript:void(0)" id="modalAssessmentGoToForm" class="btn btn-sm btn-outline-primary font-w700" style="font-size: 12px; padding: 6px 14px; border-radius: 6px;">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka Form Asesmen 15 Modul
                        </a>
                    </div>

                    <!-- Pilihan Cepat Kode ICD-10 -->
                    @php
                        $icdList = \App\Models\Icd::orderBy('code', 'asc')->get();
                    @endphp
                    @if($icdList->count() > 0)
                        <div class="mb-3">
                            <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">
                                <i class="fa-solid fa-book-medical text-primary mr-1"></i> Klasifikasi Diagnosa ICD-10 Standar:
                                <small class="text-muted font-w400">(Klik untuk menambahkan kode & nama diagnosa ke teks)</small>
                            </label>
                            <div class="d-flex flex-wrap p-2 bg-white rounded border" style="gap: 6px; max-height: 110px; overflow-y: auto;">
                                @foreach($icdList as $icdItem)
                                    <button type="button" class="btn btn-xs btn-outline-primary btn-chip-assessment font-w600" 
                                            data-text="[{{ $icdItem->code }}] {{ $icdItem->name_id }}" 
                                            style="font-size: 11.5px; padding: 4px 9px; border-radius: 6px;">
                                        <i class="fa-solid fa-plus mr-1"></i> <strong>{{ $icdItem->code }}</strong> - {{ $icdItem->name_id }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Preset Badges Diagnosa Terapi & Kondisi Fungsional -->
                    <div class="mb-3">
                        <label class="font-w700 text-dark mb-1 d-block" style="font-size: 12.5px;">
                            <i class="fa-solid fa-tags text-danger mr-1"></i> Rekomendasi Preset Diagnosa / Kondisi Fungsional Terapi:
                            <small class="text-muted font-w400">(Klik untuk menambahkan langsung ke teks)</small>
                        </label>
                        <div class="d-flex flex-wrap p-2 bg-white rounded border" style="gap: 6px; max-height: 100px; overflow-y: auto;">
                            @php
                                $presetAssessments = [
                                    'GMFCS Level I (Mandiri Jalan Tanpa Hambatan)',
                                    'GMFCS Level II (Hambatan Jarak Jauh & Medan Sulit)',
                                    'GMFCS Level III (Berjalan Dengan Alat Bantu Walker/Kruk)',
                                    'GMFCS Level IV (Mobilitas Mandiri Terbatas / Kursi Roda)',
                                    'GMFCS Level V (Ketergantungan Penuh / Head Control Kurang)',
                                    'Global Developmental Delay (GDD)',
                                    'Spastisitas Otot Ekstremitas Bawah',
                                    'Kelemahan Otot Trunk & Hipotonia Postural',
                                    'Gangguan Keseimbangan & Pola Jalan (Gait Abnormality)',
                                    'Delayed Speech & Language Development (Keterlambatan Bicara)',
                                    'Gangguan Artikulasi & Kejelasan Wicara',
                                    'Sensory Processing Disorder (SPD) / Defisit Integrasi Sensori',
                                    'Hambatan Visual / Low Vision (Perlu Latihan Orientasi Mobilitas)',
                                    'Ketergantungan Aktivitas Keseharian (ADL Barthel Index Rendah)',
                                    'Kemajuan Signifikan Motorik Kasar & Keseimbangan'
                                ];
                            @endphp
                            @foreach($presetAssessments as $preset)
                                <button type="button" class="btn btn-xs btn-outline-secondary btn-chip-assessment font-w600" 
                                        data-text="{{ $preset }}" 
                                        style="font-size: 11px; padding: 4px 8px; border-radius: 6px; background: #ffffff;">
                                    + {{ $preset }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Input Catatan Assessment -->
                    <div class="form-group mb-4">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            Catatan Assessment Terapi, Diagnosa & Kode ICD-10 <span class="text-danger">*</span>
                        </label>
                        <textarea name="diagnosa" id="modalAssessmentTextarea" required class="form-control" rows="4" 
                                  placeholder="Tuliskan catatan evaluasi terapi, kode ICD-10, atau assessment perkembangan fungsional..." 
                                  style="font-size: 13px; line-height: 1.5; border-radius: 8px;"></textarea>
                        @error('diagnosa')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <!-- Sticky Footer Form Action (Selalu Terlihat & Tidak Akan Ketutup) -->
                    <div class="modal-sticky-footer mt-4 d-flex align-items-center justify-content-between" style="position: sticky; bottom: -24px; margin-left: -24px; margin-right: -24px; margin-bottom: -24px; padding: 14px 24px; background: #ffffff; border-top: 1px solid #e2e8f0; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; box-shadow: 0 -4px 15px rgba(0,0,0,0.06); z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 13px; border: 1.5px solid #cbd5e1; border-radius: 6px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700 shadow-sm" style="padding: 8px 24px; font-size: 13px; border-radius: 6px;">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Assessment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

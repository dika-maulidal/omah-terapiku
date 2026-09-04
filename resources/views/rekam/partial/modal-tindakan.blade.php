<!-- Modal Edit / Tambah Catatan Plan & Intervensi Tindakan (P) Terapi -->
<div class="modal fade" id="addTindakan" tabindex="-1" role="dialog" aria-labelledby="addTindakanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 90vh;">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #dbeafe; box-shadow: 0 12px 36px rgba(30, 64, 175, 0.12); max-height: 88vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <!-- Modal Header (Royal Blue Gradient & Soft Blue Accent sesuai DESIGN.md) -->
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 42px; height: 42px; border-radius: 10px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 18px; border: 1px solid #bfdbfe; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1); flex-shrink: 0;">
                        <i class="fa-solid fa-hand-holding-medical"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" id="addTindakanLabel" style="color: #1e40af !important; font-size: 16px;">
                            Plan (P) — Rencana Tindakan & Intervensi Terapi
                        </h5>
                        <small class="text-muted font-w500" style="font-size: 11.5px;">Tindakan terapi fisik, okupasi, wicara, latihan fungsional, dan rekomendasi home program</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body Scrollable -->
            <div class="modal-body p-4" style="background: #ffffff; overflow-y: auto; max-height: calc(88vh - 130px); position: relative;">
                <form action="{{Route('tindakan.update')}}" method="POST" enctype="multipart/form-data" id="formPlanTindakan">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalTindakanRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalTindakanPasienId" name="pasien_id" value="{{$pasien->id}}">

                    <!-- Filter Kategori Layanan Tindakan -->
                    <div class="mb-2 d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                        <label class="font-w700 text-dark mb-0" style="font-size: 12.5px;">
                            <i class="fa-solid fa-list-check text-primary mr-1"></i> Pilih Opsi Tindakan dari Master Data:
                        </label>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons" style="gap: 4px;">
                            <label class="btn btn-xs btn-outline-primary active py-1 px-2.5 font-w600 btn-filter-tindakan" data-target-discipline="all" style="border-radius: 6px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline" checked> Semua
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2.5 font-w600 btn-filter-tindakan" data-target-discipline="fisioterapi" style="border-radius: 6px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Fisioterapi
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2.5 font-w600 btn-filter-tindakan" data-target-discipline="okupasi" style="border-radius: 6px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Okupasi
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2.5 font-w600 btn-filter-tindakan" data-target-discipline="wicara" style="border-radius: 6px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Wicara
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2.5 font-w600 btn-filter-tindakan" data-target-discipline="netra" style="border-radius: 6px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Netra
                            </label>
                        </div>
                    </div>

                    <!-- Action Chips Container -->
                    <div class="p-2.5 mb-3 rounded border" style="background: #f8fafc; border: 1px solid #e2e8f0; max-height: 140px; overflow-y: auto;">
                        <div class="d-flex flex-wrap" id="tindakanChipsContainer" style="gap: 6px;">
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
                                    <button type="button" class="btn btn-xs btn-outline-secondary btn-chip-tindakan tdk-chip-item tdk-disc-{{ $discClass }} font-w600" 
                                            data-discipline="{{ $discClass }}"
                                            data-name="{{ $tdk->nama }}" 
                                            data-code="{{ $tdk->kode }}"
                                            style="font-size: 11px; padding: 4px 9px; border-radius: 6px; background: #ffffff;">
                                        + {{ $tdk->nama }}
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Textarea Catatan Tindakan / Plan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            Rincian Intervensi / Rencana Tindakan Terapi <span class="text-danger">*</span>
                        </label>
                        <textarea name="tindakan" id="modalTindakanTextarea" required class="form-control" rows="4" 
                                  placeholder="Klik opsi tindakan di atas atau tuliskan detail intervensi, durasi, repetisi, dan home program untuk penerima manfaat..." 
                                  style="font-size: 13px; line-height: 1.6; border-radius: 8px; border: 1.5px solid #cbd5e1;"></textarea>
                        @error('tindakan')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto Dokumentasi Tindakan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-camera text-primary mr-1"></i> Upload Foto Dokumentasi Tindakan / Latihan (Opsional)
                        </label>
                        <input type="file" name="file" class="form-control-file" accept=".jpg,.jpeg,.png" style="font-size: 12.5px;">
                        <small class="text-muted d-block mt-1" style="font-size: 11px;">Format: JPG, JPEG, PNG (Maks 5MB)</small>
                        @error('file')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <!-- Sticky Footer Action Bar -->
                    <div class="modal-sticky-footer mt-4 d-flex align-items-center justify-content-between" style="position: sticky; bottom: -24px; margin-left: -24px; margin-right: -24px; margin-bottom: -24px; padding: 12px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px; box-shadow: 0 -4px 15px rgba(0,0,0,0.04); z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 7px 18px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; color: #475569;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 24px; font-size: 13px; border-radius: 6px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Plan & Tindakan (P)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
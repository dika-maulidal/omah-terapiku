<!-- Modal Edit / Tambah Catatan Plan & Intervensi Tindakan (P) Terapi -->
<div class="modal fade" id="addTindakan" tabindex="-1" role="dialog" aria-labelledby="addTindakanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 90vh;">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25); max-height: 88vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <div class="modal-header" style="background: #2D4B7A !important; color: #ffffff !important; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 14px 20px; border-bottom: none;">
                <div>
                    <h5 class="modal-title font-w700 mb-0" id="addTindakanLabel" style="font-size: 16.5px; color: #ffffff !important; letter-spacing: 0.3px;">
                        <i class="fa-solid fa-hand-holding-medical mr-2 text-warning"></i> Plan (P) / Rencana Tindakan & Intervensi Terapi
                    </h5>
                    <small class="d-block mt-1" style="color: #e2e8f0 !important; font-size: 12px;">Tindakan terapi fisik, okupasi, wicara, latihan fungsional, dan rekomendasi home program</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff !important; opacity: 1 !important; text-shadow: none; font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #f8fafc; overflow-y: auto; max-height: calc(88vh - 130px); position: relative;">
                <form action="{{Route('tindakan.update')}}" method="POST" enctype="multipart/form-data" id="formPlanTindakan">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalTindakanRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalTindakanPasienId" name="pasien_id" value="{{$pasien->id}}">

                    <!-- Filter Kategori Layanan Tindakan -->
                    <div class="mb-2 d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                        <label class="font-w700 text-dark mb-0" style="font-size: 12.5px;">
                            <i class="fa-solid fa-list-check text-success mr-1"></i> Pilih Opsi Tindakan dari Master Data:
                        </label>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons" style="gap: 4px;">
                            <label class="btn btn-xs btn-outline-primary active py-1 px-2 font-w600 btn-filter-tindakan" data-target-discipline="all" style="border-radius: 4px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline" checked> Semua
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2 font-w600 btn-filter-tindakan" data-target-discipline="fisioterapi" style="border-radius: 4px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Fisioterapi
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2 font-w600 btn-filter-tindakan" data-target-discipline="okupasi" style="border-radius: 4px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Okupasi
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2 font-w600 btn-filter-tindakan" data-target-discipline="wicara" style="border-radius: 4px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Wicara
                            </label>
                            <label class="btn btn-xs btn-outline-primary py-1 px-2 font-w600 btn-filter-tindakan" data-target-discipline="netra" style="border-radius: 4px; font-size: 11px;">
                                <input type="radio" name="filterDiscipline"> Netra
                            </label>
                        </div>
                    </div>

                    <!-- Action Chips Container -->
                    <div class="p-2 mb-3 rounded border bg-white" style="max-height: 140px; overflow-y: auto;">
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
                                    <button type="button" class="btn btn-xs btn-outline-secondary btn-chip-tindakan font-w600" 
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
                                  style="font-size: 13px; line-height: 1.5; border-radius: 8px;"></textarea>
                        @error('tindakan')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto Dokumentasi Tindakan -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-camera text-primary mr-1"></i> Upload Foto Dokumentasi Tindakan / Latihan (Opsional)
                        </label>
                        <input type="file" name="file" class="form-control-file" accept=".jpg,.jpeg,.png">
                        <small class="text-muted d-block mt-1" style="font-size: 11px;">Format: JPG, JPEG, PNG (Maks 5MB)</small>
                        @error('file')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <!-- Sticky Footer Action Bar -->
                    <div class="modal-sticky-footer mt-4 d-flex align-items-center justify-content-between" style="position: sticky; bottom: -24px; margin-left: -24px; margin-right: -24px; margin-bottom: -24px; padding: 14px 24px; background: #ffffff; border-top: 1px solid #e2e8f0; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; box-shadow: 0 -4px 15px rgba(0,0,0,0.06); z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 13px; border: 1.5px solid #cbd5e1; border-radius: 6px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-success font-w700 text-white shadow-sm" style="padding: 8px 24px; font-size: 13px; border-radius: 6px;">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Plan & Tindakan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit / Tambah Catatan Objektif (O) Pemeriksaan Fisik -->
<div class="modal fade" id="addPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="addPemeriksaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 90vh;">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #dbeafe; box-shadow: 0 12px 36px rgba(30, 64, 175, 0.12); max-height: 88vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <!-- Modal Header (Royal Blue Gradient & Soft Blue Accent sesuai DESIGN.md) -->
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 42px; height: 42px; border-radius: 10px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 18px; border: 1px solid #bfdbfe; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1); flex-shrink: 0;">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" id="addPemeriksaanLabel" style="color: #1e40af !important; font-size: 16px;">
                            Objektif (O) — Pemeriksaan Fisik & Vital Sign
                        </h5>
                        <small class="text-muted font-w500" style="font-size: 11.5px;">Catatan pemeriksaan fisik langsung, tanda-tanda vital, inspeksi, dan palpasi klinis</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body Scrollable -->
            <div class="modal-body p-4" style="background: #ffffff; overflow-y: auto; max-height: calc(88vh - 130px); position: relative;">
                <form action="{{Route('pemeriksaan.update')}}" method="POST" enctype="multipart/form-data" id="formObjektifPemeriksaan">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalPemeriksaanRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalPemeriksaanPasienId" name="pasien_id" value="{{$pasien->id}}">

                    <!-- Template Preset Button -->
                    <div class="alert alert-light mb-3 d-flex align-items-center justify-content-between flex-wrap py-2.5 px-3" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; font-size: 12px; gap: 8px;">
                        <div class="text-muted font-w600">
                            <i class="fa-solid fa-heart-pulse text-primary mr-1"></i> Template & Parameter Pemeriksaan Cepat:
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-primary font-w700" id="btnInsertVitalSignTemplate" style="border-radius: 6px; font-size: 11.5px; padding: 4px 12px;">
                            <i class="fa-solid fa-plus-circle mr-1"></i> Masukkan Template Tanda Vital
                        </button>
                    </div>

                    <!-- Textarea Pemeriksaan Fisik -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 13px;">
                            Temuan Pemeriksaan Fisik & Tanda Vital <span class="text-danger">*</span>
                        </label>
                        <textarea name="pemeriksaan" id="modalPemeriksaanTextarea" required class="form-control" rows="5" 
                                  placeholder="Tuliskan hasil observasi fisik, tanda vital (TD, Nadi, Suhu, RR), tonus otot, postur tubuh, atau temuan objektif lainnya..." 
                                  style="font-size: 13px; line-height: 1.6; border-radius: 8px; border: 1.5px solid #cbd5e1;"></textarea>
                        @error('pemeriksaan')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto Pemeriksaan Fisik -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-camera text-primary mr-1"></i> Upload Foto Kondisi Fisik / Pemeriksaan (Opsional)
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
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Pemeriksaan (O)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
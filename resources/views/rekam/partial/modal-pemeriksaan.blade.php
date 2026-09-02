<!-- Modal Edit / Tambah Catatan Objektif (O) Pemeriksaan Fisik -->
<div class="modal fade" id="addPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="addPemeriksaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 90vh;">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25); max-height: 88vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <div class="modal-header" style="background: #2D4B7A !important; color: #ffffff !important; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 14px 20px; border-bottom: none;">
                <div>
                    <h5 class="modal-title font-w700 mb-0" id="addPemeriksaanLabel" style="font-size: 16.5px; color: #ffffff !important; letter-spacing: 0.3px;">
                        <i class="fa-solid fa-stethoscope mr-2 text-warning"></i> Objektif (O) / Pemeriksaan Fisik & Vital Sign
                    </h5>
                    <small class="d-block mt-1" style="color: #e2e8f0 !important; font-size: 12px;">Catatan pemeriksaan fisik langsung, tanda-tanda vital, inspeksi, dan palpasi klinis</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff !important; opacity: 1 !important; text-shadow: none; font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #f8fafc; overflow-y: auto; max-height: calc(88vh - 130px); position: relative;">
                <form action="{{Route('pemeriksaan.update')}}" method="POST" enctype="multipart/form-data" id="formObjektifPemeriksaan">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalPemeriksaanRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalPemeriksaanPasienId" name="pasien_id" value="{{$pasien->id}}">

                    <!-- Template Preset Button -->
                    <div class="mb-2 d-flex align-items-center justify-content-between flex-wrap" style="gap: 6px;">
                        <label class="font-w700 text-dark mb-0" style="font-size: 12.5px;">
                            <i class="fa-solid fa-heart-pulse text-info mr-1"></i> Template & Parameter Cepat:
                        </label>
                        <button type="button" class="btn btn-xs btn-outline-info font-w600" id="btnInsertVitalSignTemplate" style="border-radius: 4px; font-size: 11.5px; padding: 4px 10px;">
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
                                  style="font-size: 13px; line-height: 1.5; border-radius: 8px;"></textarea>
                        @error('pemeriksaan')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto Pemeriksaan Fisik -->
                    <div class="form-group mb-3">
                        <label class="font-w700 text-dark mb-1" style="font-size: 12.5px;">
                            <i class="fa-solid fa-camera text-primary mr-1"></i> Upload Foto Kondisi Fisik / Pemeriksaan (Opsional)
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
                        <button type="submit" class="btn btn-sm btn-info font-w700 text-white shadow-sm" style="padding: 8px 24px; font-size: 13px; border-radius: 6px;">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Pemeriksaan (O)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
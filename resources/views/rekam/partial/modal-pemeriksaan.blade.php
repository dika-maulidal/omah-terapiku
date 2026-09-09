<!-- Modal Edit / Tambah Catatan Objektif (O) Pemeriksaan Fisik -->
<div class="modal fade" id="addPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="addPemeriksaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 960px; width: 95%; max-height: 92vh; margin: 1.75rem auto;">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #bfdbfe; box-shadow: 0 16px 40px rgba(30, 64, 175, 0.16); max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
            
            <!-- Modal Header (Royal Blue Gradient & Soft Blue Accent sesuai DESIGN.md) -->
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%); border-bottom: 1.5px solid #bfdbfe;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 44px; height: 44px; border-radius: 12px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 20px; border: 1.5px solid #bfdbfe; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12); flex-shrink: 0;">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-w700 mb-0" id="addPemeriksaanLabel" style="color: #1e40af !important; font-size: 17px; letter-spacing: -0.2px;">
                            Objektif (O) - Pemeriksaan Fisik & Vital Sign
                        </h5>
                        <small class="text-muted font-w500" style="font-size: 12px;">Catatan pemeriksaan fisik langsung, tanda-tanda vital, inspeksi, dan palpasi klinis</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body Scrollable -->
            <div class="modal-body p-4" style="background: #ffffff; overflow-y: auto; max-height: calc(90vh - 130px); position: relative;">
                <form action="{{Route('pemeriksaan.update')}}" method="POST" enctype="multipart/form-data" id="formObjektifPemeriksaan">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalPemeriksaanRekamId" name="rekam_id" value="0">
                    <input type="hidden" id="modalPemeriksaanPasienId" name="pasien_id" value="{{$pasien->id}}">

                    <!-- Template Preset Button -->
                    <div class="alert mb-3 d-flex align-items-center justify-content-between flex-wrap py-2.5 px-3" style="background: #f8fafc; border: 1.5px dashed #bfdbfe; border-radius: 10px; font-size: 12.5px; gap: 8px;">
                        <div class="font-w600" style="color: #1e40af;">
                            <i class="fa-solid fa-heart-pulse text-primary mr-1.5"></i> Template & Parameter Pemeriksaan Cepat:
                        </div>
                        <button type="button" class="btn btn-xs font-w700" id="btnInsertVitalSignTemplate" style="border-radius: 8px; font-size: 12px; padding: 6px 14px; background: #eff6ff; color: #1e40af; border: 1.5px solid #bfdbfe; box-shadow: 0 1px 3px rgba(37,99,235,0.08); cursor: pointer;">
                            <i class="fa-solid fa-circle-plus mr-1" style="color: #2563eb;"></i> Masukkan Template Tanda Vital
                        </button>
                    </div>

                    <!-- Textarea Pemeriksaan Fisik -->
                    <div class="form-group mb-3">
                        <label class="font-w700 mb-1" style="font-size: 13px; color: #1e293b;">
                            Temuan Pemeriksaan Fisik & Tanda Vital <span class="text-danger">*</span>
                        </label>
                        <textarea name="pemeriksaan" id="modalPemeriksaanTextarea" required class="form-control" rows="5" 
                                  placeholder="Tuliskan hasil observasi fisik, tanda vital (TD, Nadi, Suhu, RR), tonus otot, postur tubuh, atau temuan objektif lainnya..." 
                                  style="font-size: 13.5px; line-height: 1.6; border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 12px 14px; min-height: 130px;"></textarea>
                        @error('pemeriksaan')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto Pemeriksaan Fisik -->
                    <div class="form-group mb-3">
                        <label class="font-w700 mb-1" style="font-size: 13px; color: #1e293b;">
                            <i class="fa-solid fa-camera mr-1.5" style="color: #2563eb;"></i> Upload Foto Kondisi Fisik / Pemeriksaan (Opsional)
                        </label>
                        <input type="file" name="file" class="form-control-file" accept=".jpg,.jpeg,.png" style="font-size: 12.5px;">
                        <small class="text-muted d-block mt-1" style="font-size: 11px;">Format: JPG, JPEG, PNG (Maks 5MB)</small>
                        @error('file')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>
                    
                    <!-- Sticky Footer Form Action -->
                    <div class="modal-sticky-footer mt-4 d-flex align-items-center justify-content-between" style="position: sticky; bottom: -24px; margin-left: -24px; margin-right: -24px; margin-bottom: -24px; padding: 14px 24px; background: #f8fafc; border-top: 1.5px solid #e2e8f0; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px; box-shadow: 0 -4px 15px rgba(0,0,0,0.04); z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 20px; font-size: 13px; border: 1.5px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 26px; font-size: 13px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Objektif (O)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
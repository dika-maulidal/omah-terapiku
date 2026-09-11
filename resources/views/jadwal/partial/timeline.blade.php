<!-- Mini Alert Info Waktu Terapi -->
<div class="alert alert-light d-flex align-items-center justify-content-between flex-wrap mb-4 py-2.5 px-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb; border-radius: 8px; font-size: 12px; gap: 8px;">
    <div class="d-flex align-items-center">
        <i class="fa-solid fa-circle-info text-primary mr-2" style="font-size: 14px;"></i>
        <span class="text-dark font-w500">
            Jadwal pelayanan terapi beroperasi setiap hari <strong>Rabu</strong> dalam 7 slot sesi waktu (30–45 menit per sesi).
        </span>
    </div>
    <span class="badge font-w700" style="font-size: 11.5px; padding: 4px 10px; border-radius: 6px; background: #ffffff; color: #1e40af; border: 1px solid #bfdbfe;">
        Total: {{ $stats['total'] }} Pasien
    </span>
</div>

<div class="row">
    @foreach($masterSlots as $slotName => $meta)
        @php
            $pasienDiSlot = $jadwalPerSlot[$slotName] ?? [];
            $hasPasien = count($pasienDiSlot) > 0;
        @endphp

        <div class="col-xl-6 col-12 mb-4">
            <div class="slot-session-card h-100 p-3" style="{{ $hasPasien ? 'border-top: 3.5px solid #2563eb; background: #ffffff;' : 'background: #fafbfc;' }}">
                
                <!-- Header Slot Sesi -->
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3" style="border-bottom: 1px solid #edf2f7;">
                    <div class="d-flex align-items-center">
                        <span class="badge font-w700 mr-2 py-1 px-2" style="font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                            <i class="fa-solid {{ $meta['icon'] }} mr-1"></i> {{ explode(' (', $slotName)[0] }}
                        </span>
                        <strong class="text-dark" style="font-size: 13.5px;">{{ $meta['jam'] }}</strong>
                    </div>
                    <span class="badge {{ $hasPasien ? 'font-w700' : 'font-w600 text-muted' }}" style="font-size: 11.5px; padding: 4px 10px; border-radius: 20px; {{ $hasPasien ? 'background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;' : 'background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;' }}">
                        {{ count($pasienDiSlot) }} Penerima Manfaat
                    </span>
                </div>

                <!-- Pasien List di Slot Ini -->
                @if($hasPasien)
                    <div class="d-flex flex-column" style="gap: 10px;">
                        @foreach($pasienDiSlot as $pRecord)
                            @php
                                $p = $pRecord->pasien;
                                $layanan = $pRecord->layanan_terapi ?: 'Fisioterapi';
                                
                                // Color badge border
                                $borderClr = '#2563eb';
                                $layananBadge = 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;';
                                if (str_contains($layanan, 'Okupasi')) {
                                    $borderClr = '#d97706';
                                    $layananBadge = 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;';
                                } elseif (str_contains($layanan, 'Wicara')) {
                                    $borderClr = '#059669';
                                    $layananBadge = 'background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;';
                                } elseif (str_contains($layanan, 'Netra')) {
                                    $borderClr = '#7c3aed';
                                    $layananBadge = 'background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;';
                                }
                            @endphp

                            <div class="patient-session-item p-3" style="border-left-color: {{ $borderClr }};">
                                <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 8px;">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; background: #eff6ff; color: {{ $borderClr }}; font-weight: 700; font-size: 14px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                                            {{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ Route('rekam.detail', $pRecord->pasien_id) }}" class="font-w700 text-dark mb-0 d-block" style="font-size: 13.5px; transition: color 0.15s ease;">
                                                {{ $p->nama ?? 'Pasien Tidak Ditemukan' }}
                                            </a>
                                            <div class="d-flex align-items-center flex-wrap mt-1" style="gap: 6px; font-size: 11px;">
                                                <span class="badge font-w600" style="font-size: 10.5px; padding: 2px 6px; border-radius: 4px; background: #f8fafc; color: #334155; border: 1px solid #cbd5e1;">
                                                    RM# {{ $p->no_rm ?? '-' }}
                                                </span>
                                                <span class="badge font-w600" style="font-size: 10.5px; padding: 2px 8px; border-radius: 4px; {{ $layananBadge }}">
                                                    {{ $layanan }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        @if($pRecord->status == 1)
                                            <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">
                                                <i class="fa-solid fa-clock mr-1"></i> Antrean
                                            </span>
                                        @elseif($pRecord->status == 2)
                                            <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                                <i class="fa-solid fa-stethoscope mr-1"></i> Sedang Terapi
                                            </span>
                                        @else
                                            <span class="badge font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                <i class="fa-solid fa-circle-check mr-1"></i> Selesai
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-2 pt-2" style="border-top: 1px dashed #cbd5e1; font-size: 12px;">
                                    <div class="col-sm-6 mb-1">
                                        <span class="text-muted"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Terapis:</span>
                                        <strong class="text-dark">{{ $pRecord->dokter->nama ?? '-' }}</strong>
                                    </div>
                                    <div class="col-sm-6 mb-1">
                                        <span class="text-muted"><i class="fa-solid fa-hospital-user text-primary mr-1"></i> UPT:</span>
                                        <span class="text-dark font-w500">{{ $pRecord->upt_lokasi ?: ($pRecord->poli ?: 'Omah Terapiku') }}</span>
                                    </div>
                                    @if($pRecord->keluhan)
                                        <div class="col-12 mt-1">
                                            <span class="text-muted"><i class="fa-solid fa-comment-dots text-warning mr-1"></i> Keluhan:</span>
                                            <span class="text-dark font-italic">{{ Str::limit($pRecord->keluhan, 70) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end align-items-center mt-2 pt-2" style="border-top: 1px solid #edf2f7; gap: 6px;">
                                    @if($pRecord->assessment)
                                        <a href="{{ Route('rekam.assessment.show', $pRecord->id) }}" class="btn btn-xs font-w600" style="font-size: 11px; padding: 4px 9px; border-radius: 6px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                                            <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                                        </a>
                                    @endif
                                    <a href="{{ Route('rekam.detail', $pRecord->pasien_id) }}" class="btn btn-xs font-w600" style="font-size: 11px; padding: 4px 10px; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                                        <i class="fa-solid fa-folder-open mr-1"></i> Detail Sesi
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted" style="border: 1px dashed #cbd5e1; border-radius: 8px; background: #ffffff;">
                        <i class="fa-solid fa-calendar-xmark text-muted mb-1" style="font-size: 20px; opacity: 0.4;"></i>
                        <p class="mb-0 text-muted" style="font-size: 12px;">Slot waktu kosong &bull; Belum ada penerima manfaat</p>
                        <a href="{{ Route('rekam.add', array_filter(['tanggal' => $tanggal, 'sesi' => $slotName, 'upt' => ($uptFilter != 'all' && $uptFilter) ? $uptFilter : null, 'layanan' => ($layananFilter != 'all' && $layananFilter) ? $layananFilter : null, 'dokter_id' => ($dokterFilter != 'all' && $dokterFilter) ? $dokterFilter : null])) }}" class="btn btn-xs btn-primary font-w600 mt-2" style="font-size: 11.5px; border-radius: 6px; padding: 4px 12px; text-decoration: none;">
                            <i class="fa-solid fa-plus mr-1"></i> + Jadwalkan di Slot Ini
                        </a>
                    </div>
                @endif

            </div>
        </div>
    @endforeach
</div>

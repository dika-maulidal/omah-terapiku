<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Rekam;
use App\Models\RekamAssessment;
use Illuminate\Http\Request;

class RekamAssessmentController extends Controller
{
    private function ensureClinicalRole()
    {
        if (!in_array(auth()->user()->role_display(), ['Admin', 'Dokter', 'Pendaftaran'])) {
            abort(403, 'Akses tidak diizinkan.');
        }
    }

    public function form($rekamId)
    {
        $this->ensureClinicalRole();

        $rekam = Rekam::with(['pasien', 'dokter'])->findOrFail($rekamId);
        $pasien = $rekam->pasien;

        $assessment = RekamAssessment::firstOrNew([
            'rekam_id' => $rekamId
        ], [
            'pasien_id' => $pasien->id,
            'dokter_id' => $rekam->dokter_id,
            'tgl_assessment' => $rekam->tgl_rekam ?: date('Y-m-d'),
            'jenis_assessment' => 'General'
        ]);

        // Riwayat assessment pasien sebelumnya untuk komparasi
        $riwayatAssessment = RekamAssessment::where('pasien_id', $pasien->id)
            ->where('rekam_id', '!=', $rekamId)
            ->latest('tgl_assessment')
            ->get();

        return view('rekam.assessment.form', compact('rekam', 'pasien', 'assessment', 'riwayatAssessment'));
    }

    public function store(Request $request, $rekamId)
    {
        $this->ensureClinicalRole();

        $rekam = Rekam::findOrFail($rekamId);
        $pasien = $rekam->pasien;

        $user = auth()->user();
        $dokterId = $rekam->dokter_id;
        if ($user->role_display() == 'Dokter') {
            $dokter = Dokter::where('user_id', $user->id)->first();
            if ($dokter) {
                $dokterId = $dokter->id;
            }
        }

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokterId,
            'jenis_assessment' => $request->jenis_assessment ?: 'General',
            'tgl_assessment' => $request->tgl_assessment ?: ($rekam->tgl_rekam ?: date('Y-m-d')),

            // 1. Motorik
            'motorik_mengangkat_kepala' => $request->motorik_mengangkat_kepala,
            'motorik_posisi_tengkurap' => $request->motorik_posisi_tengkurap,
            'motorik_posisi_duduk' => $request->motorik_posisi_duduk,
            'motorik_merangkak' => $request->motorik_merangkak,
            'motorik_berlutut' => $request->motorik_berlutut,
            'motorik_berjalan' => $request->motorik_berjalan,
            'motorik_catatan' => $request->motorik_catatan,

            // 2. ADL
            'adl_kontak_mata' => $request->adl_kontak_mata,
            'adl_duduk_tenang' => $request->adl_duduk_tenang,
            'adl_gerakan_berulang' => $request->adl_gerakan_berulang,
            'adl_respon_nama' => $request->adl_respon_nama,
            'adl_makan' => $request->adl_makan,
            'adl_mandi' => $request->adl_mandi,
            'adl_berpakaian' => $request->adl_berpakaian,
            'adl_bak' => $request->adl_bak,
            'adl_bab' => $request->adl_bab,
            'adl_catatan' => $request->adl_catatan,

            // 3. Wicara
            'wicara_komunikasi' => $request->wicara_komunikasi,
            'wicara_organ' => $request->wicara_organ,
            'wicara_organ_keterangan' => $request->wicara_organ_keterangan,
            'wicara_makan_menelan' => $request->wicara_makan_menelan,
            'wicara_makan_menelan_keterangan' => $request->wicara_makan_menelan_keterangan,
            'wicara_catatan' => $request->wicara_catatan,

            // 4. Status Penglihatan / Netra
            'penglihatan_klasifikasi' => $request->penglihatan_klasifikasi,
            'penglihatan_onset' => $request->penglihatan_onset,
            'penglihatan_sisi' => $request->penglihatan_sisi,
            'penglihatan_usia_onset' => $request->penglihatan_usia_onset,
            'penglihatan_durasi' => $request->penglihatan_durasi,
            'penglihatan_etiologi' => $request->penglihatan_etiologi,
            'penglihatan_progresif' => $request->penglihatan_progresif,
            'penglihatan_terakhir_periksa' => $request->penglihatan_terakhir_periksa,
            'penglihatan_visus_od' => $request->penglihatan_visus_od,
            'penglihatan_visus_os' => $request->penglihatan_visus_os,
            'penglihatan_persepsi_cahaya' => $request->penglihatan_persepsi_cahaya,
            'penglihatan_preferensi_sisi' => $request->penglihatan_preferensi_sisi,
            'penglihatan_alat_bantu' => $request->penglihatan_alat_bantu ?: [],
            'penglihatan_teknik_tongkat' => $request->penglihatan_teknik_tongkat,
            // 5. Intensitas Nyeri & Body Chart
            'nyeri_skor_total' => $request->nyeri_skor_total !== null && $request->nyeri_skor_total !== '' ? (int)$request->nyeri_skor_total : null,
            'nyeri_saat_istirahat' => $request->nyeri_saat_istirahat !== null && $request->nyeri_saat_istirahat !== '' ? (int)$request->nyeri_saat_istirahat : null,
            'nyeri_saat_aktivitas' => $request->nyeri_saat_aktivitas !== null && $request->nyeri_saat_aktivitas !== '' ? (int)$request->nyeri_saat_aktivitas : null,
            'nyeri_sifat' => $request->nyeri_sifat ?: [],
            'nyeri_sifat_lainnya' => $request->nyeri_sifat_lainnya,
            'nyeri_lokasi_keluhan' => $request->nyeri_lokasi_keluhan,
            'nyeri_body_chart' => $request->nyeri_body_chart,
            'nyeri_catatan' => $request->nyeri_catatan,

            // 6. Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT)
            'rom_mmt_data' => $request->rom_mmt ?: [],
            'rom_catatan' => $request->rom_catatan,

            // 7. Pemeriksaan Neurologis
            'neuro_sensasi' => $request->neuro_sensasi,
            'neuro_sensasi_area' => $request->neuro_sensasi_area,
            'neuro_refleks_bisep_d' => $request->neuro_refleks_bisep_d,
            'neuro_refleks_bisep_s' => $request->neuro_refleks_bisep_s,
            'neuro_refleks_trisep_d' => $request->neuro_refleks_trisep_d,
            'neuro_refleks_trisep_s' => $request->neuro_refleks_trisep_s,
            'neuro_refleks_patela_d' => $request->neuro_refleks_patela_d,
            'neuro_refleks_patela_s' => $request->neuro_refleks_patela_s,
            'neuro_refleks_achilles_d' => $request->neuro_refleks_achilles_d,
            'neuro_refleks_achilles_s' => $request->neuro_refleks_achilles_s,
            'neuro_koordinasi' => $request->neuro_koordinasi ?: [],
            'neuro_koordinasi_lainnya' => $request->neuro_koordinasi_lainnya,
            'neuro_tonus_otot' => $request->neuro_tonus_otot,
            'neuro_catatan' => $request->neuro_catatan,

            // 8. Pemeriksaan Postur & Keseimbangan
            'postur_temuan' => $request->postur_temuan ?: [],
            'postur_tangan_tongkat' => $request->postur_tangan_tongkat,
            'keseimbangan_bbs_skor' => $request->keseimbangan_bbs_skor !== null && $request->keseimbangan_bbs_skor !== '' ? (int)$request->keseimbangan_bbs_skor : null,
            'keseimbangan_tug_detik' => $request->keseimbangan_tug_detik,
            'keseimbangan_romberg' => $request->keseimbangan_romberg,
            'keseimbangan_ols_kanan' => $request->keseimbangan_ols_kanan,
            'keseimbangan_ols_kiri' => $request->keseimbangan_ols_kiri,
            'keseimbangan_dual_task_tug' => $request->keseimbangan_dual_task_tug,
            'keseimbangan_fesi_skor' => $request->keseimbangan_fesi_skor !== null && $request->keseimbangan_fesi_skor !== '' ? (int)$request->keseimbangan_fesi_skor : null,
            'postur_keseimbangan_catatan' => $request->postur_keseimbangan_catatan,

            // 9. Pemeriksaan Gaya Berjalan (Gait)
            'gait_karakteristik' => $request->gait_karakteristik ?: [],
            'gait_deteksi_lantai' => $request->gait_deteksi_lantai,
            'gait_10mwt_kecepatan_nyaman' => $request->gait_10mwt_kecepatan_nyaman,
            'gait_10mwt_kecepatan_cepat' => $request->gait_10mwt_kecepatan_cepat,
            'gait_10mwt_jumlah_langkah' => $request->gait_10mwt_jumlah_langkah,
            'gait_catatan' => $request->gait_catatan,

            // 10. Kesimpulan & Rekomendasi
            'kesimpulan' => $request->kesimpulan,
            'rencana_terapi' => $request->rencana_terapi,

            // 11. Custom / Additional dynamic data (step-by-step)
            'custom_data' => $request->custom_data ? (is_array($request->custom_data) ? $request->custom_data : json_decode($request->custom_data, true)) : null,
        ];

        RekamAssessment::updateOrCreate(
            ['rekam_id' => $rekamId],
            $data
        );

        if ($request->has('action') && $request->action === 'save_and_print') {
            return redirect()->route('rekam.assessment.print', $rekamId);
        }

        return redirect()->route('rekam.detail', $pasien->id)
            ->with('sukses', 'Form Assessment Terapis berhasil disimpan.');
    }

    public function show($rekamId)
    {
        $rekam = Rekam::with(['pasien', 'dokter', 'assessment'])->findOrFail($rekamId);
        $pasien = $rekam->pasien;
        $assessment = $rekam->assessment;

        if (!$assessment) {
            return redirect()->route('rekam.assessment', $rekamId)
                ->with('warning', 'Assessment belum diisi, silakan isi form assessment.');
        }

        return view('rekam.assessment.show', compact('rekam', 'pasien', 'assessment'));
    }

    public function print($rekamId)
    {
        $rekam = Rekam::with(['pasien', 'dokter', 'assessment'])->findOrFail($rekamId);
        $pasien = $rekam->pasien;
        $assessment = $rekam->assessment;

        if (!$assessment) {
            return redirect()->route('rekam.assessment', $rekamId)
                ->with('warning', 'Form assessment belum diisi.');
        }

        return view('rekam.assessment.print', compact('rekam', 'pasien', 'assessment'));
    }
}

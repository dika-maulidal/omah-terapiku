<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah format tabel menjadi DYNAMIC untuk melepaskan batasan row size 8126 bytes
        DB::statement('ALTER TABLE rekam_assessment ROW_FORMAT=DYNAMIC');

        // 2. Ubah seluruh kolom VARCHAR dari migrasi sebelumnya menjadi TEXT agar disimpan off-page oleh InnoDB
        $columnsToText = [
            'motorik_mengangkat_kepala', 'motorik_posisi_tengkurap', 'motorik_posisi_duduk',
            'motorik_merangkak', 'motorik_berlutut', 'motorik_berjalan',
            'adl_kontak_mata', 'adl_duduk_tenang', 'adl_gerakan_berulang',
            'adl_respon_nama', 'adl_makan', 'adl_mandi', 'adl_berpakaian', 'adl_bak', 'adl_bab',
            'wicara_komunikasi', 'wicara_organ', 'wicara_makan_menelan',
            'penglihatan_klasifikasi', 'penglihatan_onset', 'penglihatan_sisi',
            'penglihatan_usia_onset', 'penglihatan_durasi', 'penglihatan_progresif',
            'penglihatan_visus_od', 'penglihatan_visus_os',
            'penglihatan_persepsi_cahaya', 'penglihatan_preferensi_sisi', 'penglihatan_teknik_tongkat',
            'neuro_sensasi', 'neuro_refleks_bisep_d', 'neuro_refleks_bisep_s',
            'neuro_refleks_trisep_d', 'neuro_refleks_trisep_s', 'neuro_refleks_patela_d',
            'neuro_refleks_patela_s', 'neuro_refleks_achilles_d', 'neuro_refleks_achilles_s',
            'neuro_tonus_otot',
            'postur_tangan_tongkat', 'keseimbangan_tug_detik', 'keseimbangan_romberg',
            'keseimbangan_ols_kanan', 'keseimbangan_ols_kiri', 'keseimbangan_dual_task_tug',
            'gait_deteksi_lantai', 'gait_10mwt_kecepatan_nyaman', 'gait_10mwt_kecepatan_cepat', 'gait_10mwt_jumlah_langkah',
            'sensoris_taktil_raba_halus', 'sensoris_taktil_pinprick', 'sensoris_taktil_suhu',
            'sensoris_posisi_sendi', 'sensoris_vibrasi', 'sensoris_kinesthesia_jari',
            'vestibular_hit', 'vestibular_dix_hallpike', 'vestibular_keluhan_pusing',
            'psikososial_faktor_psikologis', 'psikososial_dukungan_sosial',
            'rencana_dosis_frekuensi', 'rencana_dosis_durasi', 'rencana_dosis_total_sesi', 'rencana_dosis_reassessment',
        ];

        foreach ($columnsToText as $col) {
            if (Schema::hasColumn('rekam_assessment', $col)) {
                DB::statement("ALTER TABLE rekam_assessment MODIFY `{$col}` TEXT NULL");
            }
        }

        // 3. Tambahkan kolom GMFM Dimensi A
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->json('gmfm_dimensi_a_scores')->nullable()->after('adl_bab');
            $table->integer('gmfm_dimensi_a_total')->nullable()->after('gmfm_dimensi_a_scores');
            $table->decimal('gmfm_dimensi_a_persen', 5, 2)->nullable()->after('gmfm_dimensi_a_total');
            $table->text('gmfm_dimensi_a_catatan')->nullable()->after('gmfm_dimensi_a_persen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'gmfm_dimensi_a_scores',
                'gmfm_dimensi_a_total',
                'gmfm_dimensi_a_persen',
                'gmfm_dimensi_a_catatan',
            ]);
        });
    }
};

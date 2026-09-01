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
        // Pastikan table menggunakan ROW_FORMAT=DYNAMIC untuk menghindari batas row size 8126 bytes
        DB::statement('ALTER TABLE rekam_assessment ROW_FORMAT=DYNAMIC');

        Schema::table('rekam_assessment', function (Blueprint $table) {
            // Sensasi Taktil
            $table->text('sensoris_taktil_raba_halus')->nullable()->after('gait_catatan');
            $table->text('sensoris_taktil_pinprick')->nullable()->after('sensoris_taktil_raba_halus');
            $table->text('sensoris_taktil_suhu')->nullable()->after('sensoris_taktil_pinprick');
            
            // Propriosepsi & Kinesthesia
            $table->text('sensoris_posisi_sendi')->nullable()->after('sensoris_taktil_suhu');
            $table->text('sensoris_vibrasi')->nullable()->after('sensoris_posisi_sendi');
            $table->text('sensoris_kinesthesia_jari')->nullable()->after('sensoris_vibrasi');
            
            // Skrining Vestibular Dasar
            $table->text('vestibular_hit')->nullable()->after('sensoris_kinesthesia_jari');
            $table->text('vestibular_dix_hallpike')->nullable()->after('vestibular_hit');
            $table->text('vestibular_keluhan_pusing')->nullable()->after('vestibular_dix_hallpike');
            
            // Lokasi & Deskripsi Defisit Sensoris & Catatan
            $table->text('sensoris_defisit_lokasi')->nullable()->after('vestibular_keluhan_pusing');
            $table->text('sensoris_catatan')->nullable()->after('sensoris_defisit_lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'sensoris_taktil_raba_halus',
                'sensoris_taktil_pinprick',
                'sensoris_taktil_suhu',
                'sensoris_posisi_sendi',
                'sensoris_vibrasi',
                'sensoris_kinesthesia_jari',
                'vestibular_hit',
                'vestibular_dix_hallpike',
                'vestibular_keluhan_pusing',
                'sensoris_defisit_lokasi',
                'sensoris_catatan',
            ]);
        });
    }
};

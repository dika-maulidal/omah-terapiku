<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            // Sensasi Taktil
            $table->string('sensoris_taktil_raba_halus', 50)->nullable()->after('gait_catatan');
            $table->string('sensoris_taktil_pinprick', 50)->nullable()->after('sensoris_taktil_raba_halus');
            $table->string('sensoris_taktil_suhu', 50)->nullable()->after('sensoris_taktil_pinprick');
            
            // Propriosepsi & Kinesthesia
            $table->string('sensoris_posisi_sendi', 50)->nullable()->after('sensoris_taktil_suhu');
            $table->string('sensoris_vibrasi', 50)->nullable()->after('sensoris_posisi_sendi');
            $table->string('sensoris_kinesthesia_jari', 50)->nullable()->after('sensoris_vibrasi');
            
            // Skrining Vestibular Dasar
            $table->string('vestibular_hit', 50)->nullable()->after('sensoris_kinesthesia_jari');
            $table->string('vestibular_dix_hallpike', 50)->nullable()->after('vestibular_hit');
            $table->string('vestibular_keluhan_pusing', 50)->nullable()->after('vestibular_dix_hallpike');
            
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

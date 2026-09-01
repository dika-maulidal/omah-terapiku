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
            // Pemeriksaan Gaya Berjalan (Gait)
            $table->json('gait_karakteristik')->nullable()->after('postur_keseimbangan_catatan');
            $table->string('gait_deteksi_lantai', 50)->nullable()->after('gait_karakteristik');
            $table->string('gait_10mwt_kecepatan_nyaman', 50)->nullable()->after('gait_deteksi_lantai');
            $table->string('gait_10mwt_kecepatan_cepat', 50)->nullable()->after('gait_10mwt_kecepatan_nyaman');
            $table->string('gait_10mwt_jumlah_langkah', 50)->nullable()->after('gait_10mwt_kecepatan_cepat');
            $table->text('gait_catatan')->nullable()->after('gait_10mwt_jumlah_langkah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'gait_karakteristik',
                'gait_deteksi_lantai',
                'gait_10mwt_kecepatan_nyaman',
                'gait_10mwt_kecepatan_cepat',
                'gait_10mwt_jumlah_langkah',
                'gait_catatan',
            ]);
        });
    }
};

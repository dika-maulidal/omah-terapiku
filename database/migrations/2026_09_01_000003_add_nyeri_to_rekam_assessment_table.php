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
            // Bagian Intensitas Nyeri & Body Chart
            $table->integer('nyeri_skor_total')->nullable()->after('penglihatan_catatan');
            $table->integer('nyeri_saat_istirahat')->nullable()->after('nyeri_skor_total');
            $table->integer('nyeri_saat_aktivitas')->nullable()->after('nyeri_saat_istirahat');
            $table->json('nyeri_sifat')->nullable()->after('nyeri_saat_aktivitas');
            $table->text('nyeri_sifat_lainnya')->nullable()->after('nyeri_sifat');
            $table->text('nyeri_lokasi_keluhan')->nullable()->after('nyeri_sifat_lainnya');
            $table->longText('nyeri_body_chart')->nullable()->after('nyeri_lokasi_keluhan');
            $table->text('nyeri_catatan')->nullable()->after('nyeri_body_chart');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'nyeri_skor_total',
                'nyeri_saat_istirahat',
                'nyeri_saat_aktivitas',
                'nyeri_sifat',
                'nyeri_sifat_lainnya',
                'nyeri_lokasi_keluhan',
                'nyeri_body_chart',
                'nyeri_catatan',
            ]);
        });
    }
};

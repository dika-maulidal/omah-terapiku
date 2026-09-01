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
            // Temuan Postur (Palpasi & Observasi)
            $table->json('postur_temuan')->nullable()->after('neuro_catatan');
            $table->string('postur_tangan_tongkat', 100)->nullable()->after('postur_temuan');

            // Instrumen Keseimbangan
            $table->integer('keseimbangan_bbs_skor')->nullable()->after('postur_tangan_tongkat');
            $table->string('keseimbangan_tug_detik', 50)->nullable()->after('keseimbangan_bbs_skor');
            $table->string('keseimbangan_romberg', 50)->nullable()->after('keseimbangan_tug_detik');
            $table->string('keseimbangan_ols_kanan', 50)->nullable()->after('keseimbangan_romberg');
            $table->string('keseimbangan_ols_kiri', 50)->nullable()->after('keseimbangan_ols_kanan');
            $table->string('keseimbangan_dual_task_tug', 50)->nullable()->after('keseimbangan_ols_kiri');
            $table->integer('keseimbangan_fesi_skor')->nullable()->after('keseimbangan_dual_task_tug');

            // Catatan Keseimbangan & Strategi Kompensasi
            $table->text('postur_keseimbangan_catatan')->nullable()->after('keseimbangan_fesi_skor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'postur_temuan',
                'postur_tangan_tongkat',
                'keseimbangan_bbs_skor',
                'keseimbangan_tug_detik',
                'keseimbangan_romberg',
                'keseimbangan_ols_kanan',
                'keseimbangan_ols_kiri',
                'keseimbangan_dual_task_tug',
                'keseimbangan_fesi_skor',
                'postur_keseimbangan_catatan',
            ]);
        });
    }
};

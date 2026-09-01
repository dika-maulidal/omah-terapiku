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
            // Status Penglihatan / Netra (Sesuai Assesment.md)
            $table->string('penglihatan_klasifikasi', 100)->nullable()->after('wicara_catatan');
            $table->string('penglihatan_onset', 100)->nullable()->after('penglihatan_klasifikasi');
            $table->string('penglihatan_sisi', 100)->nullable()->after('penglihatan_onset');
            $table->string('penglihatan_usia_onset', 50)->nullable()->after('penglihatan_sisi');
            $table->string('penglihatan_durasi', 50)->nullable()->after('penglihatan_usia_onset');
            $table->text('penglihatan_etiologi')->nullable()->after('penglihatan_durasi');
            $table->string('penglihatan_progresif', 50)->nullable()->after('penglihatan_etiologi');
            $table->text('penglihatan_terakhir_periksa')->nullable()->after('penglihatan_progresif');
            $table->string('penglihatan_visus_od', 100)->nullable()->after('penglihatan_terakhir_periksa');
            $table->string('penglihatan_visus_os', 100)->nullable()->after('penglihatan_visus_od');
            $table->string('penglihatan_persepsi_cahaya', 50)->nullable()->after('penglihatan_visus_os');
            $table->string('penglihatan_preferensi_sisi', 50)->nullable()->after('penglihatan_persepsi_cahaya');
            $table->json('penglihatan_alat_bantu')->nullable()->after('penglihatan_preferensi_sisi');
            $table->string('penglihatan_teknik_tongkat', 100)->nullable()->after('penglihatan_alat_bantu');
            $table->text('penglihatan_alat_bantu_lainnya')->nullable()->after('penglihatan_teknik_tongkat');
            $table->text('penglihatan_catatan')->nullable()->after('penglihatan_alat_bantu_lainnya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'penglihatan_klasifikasi',
                'penglihatan_onset',
                'penglihatan_sisi',
                'penglihatan_usia_onset',
                'penglihatan_durasi',
                'penglihatan_etiologi',
                'penglihatan_progresif',
                'penglihatan_terakhir_periksa',
                'penglihatan_visus_od',
                'penglihatan_visus_os',
                'penglihatan_persepsi_cahaya',
                'penglihatan_preferensi_sisi',
                'penglihatan_alat_bantu',
                'penglihatan_teknik_tongkat',
                'penglihatan_alat_bantu_lainnya',
                'penglihatan_catatan',
            ]);
        });
    }
};

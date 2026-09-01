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
            $table->text('psikososial_pekerjaan_hobi')->nullable()->after('sensoris_catatan');
            $table->text('psikososial_faktor_psikologis')->nullable()->after('psikososial_pekerjaan_hobi');
            $table->text('psikososial_dukungan_sosial')->nullable()->after('psikososial_faktor_psikologis');
            $table->text('psikososial_harapan_pasien')->nullable()->after('psikososial_dukungan_sosial');
            $table->text('psikososial_catatan')->nullable()->after('psikososial_harapan_pasien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'psikososial_pekerjaan_hobi',
                'psikososial_faktor_psikologis',
                'psikososial_dukungan_sosial',
                'psikososial_harapan_pasien',
                'psikososial_catatan',
            ]);
        });
    }
};

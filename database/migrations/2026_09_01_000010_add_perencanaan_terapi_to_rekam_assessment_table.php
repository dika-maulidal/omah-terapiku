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
            $table->json('rencana_modalitas_fisik')->nullable()->after('psikososial_catatan');
            $table->text('rencana_modalitas_lainnya')->nullable()->after('rencana_modalitas_fisik');
            
            $table->json('rencana_manual_terapi')->nullable()->after('rencana_modalitas_lainnya');
            $table->text('rencana_manual_lainnya')->nullable()->after('rencana_manual_terapi');
            
            $table->json('rencana_latihan_terapi')->nullable()->after('rencana_manual_lainnya');
            $table->text('rencana_latihan_lainnya')->nullable()->after('rencana_latihan_terapi');
            
            $table->json('rencana_edukasi_konseling')->nullable()->after('rencana_latihan_lainnya');
            
            $table->text('rencana_dosis_frekuensi')->nullable()->after('rencana_edukasi_konseling');
            $table->text('rencana_dosis_durasi')->nullable()->after('rencana_dosis_frekuensi');
            $table->text('rencana_dosis_total_sesi')->nullable()->after('rencana_dosis_durasi');
            $table->text('rencana_dosis_reassessment')->nullable()->after('rencana_dosis_total_sesi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'rencana_modalitas_fisik',
                'rencana_modalitas_lainnya',
                'rencana_manual_terapi',
                'rencana_manual_lainnya',
                'rencana_latihan_terapi',
                'rencana_latihan_lainnya',
                'rencana_edukasi_konseling',
                'rencana_dosis_frekuensi',
                'rencana_dosis_durasi',
                'rencana_dosis_total_sesi',
                'rencana_dosis_reassessment',
            ]);
        });
    }
};

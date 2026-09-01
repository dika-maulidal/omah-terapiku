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
            // Pemeriksaan Neurologis
            $table->string('neuro_sensasi')->nullable()->after('rom_catatan');
            $table->text('neuro_sensasi_area')->nullable()->after('neuro_sensasi');
            
            // Refleks Tendon (D = Dexter / Kanan, S = Sinister / Kiri)
            $table->string('neuro_refleks_bisep_d', 50)->nullable()->after('neuro_sensasi_area');
            $table->string('neuro_refleks_bisep_s', 50)->nullable()->after('neuro_refleks_bisep_d');
            $table->string('neuro_refleks_trisep_d', 50)->nullable()->after('neuro_refleks_bisep_s');
            $table->string('neuro_refleks_trisep_s', 50)->nullable()->after('neuro_refleks_trisep_d');
            $table->string('neuro_refleks_patela_d', 50)->nullable()->after('neuro_refleks_trisep_s');
            $table->string('neuro_refleks_patela_s', 50)->nullable()->after('neuro_refleks_patela_d');
            $table->string('neuro_refleks_achilles_d', 50)->nullable()->after('neuro_refleks_patela_s');
            $table->string('neuro_refleks_achilles_s', 50)->nullable()->after('neuro_refleks_achilles_d');
            
            // Tes Koordinasi & Tonus Otot
            $table->json('neuro_koordinasi')->nullable()->after('neuro_refleks_achilles_s');
            $table->text('neuro_koordinasi_lainnya')->nullable()->after('neuro_koordinasi');
            $table->string('neuro_tonus_otot', 100)->nullable()->after('neuro_koordinasi_lainnya');
            $table->text('neuro_catatan')->nullable()->after('neuro_tonus_otot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'neuro_sensasi',
                'neuro_sensasi_area',
                'neuro_refleks_bisep_d',
                'neuro_refleks_bisep_s',
                'neuro_refleks_trisep_d',
                'neuro_refleks_trisep_s',
                'neuro_refleks_patela_d',
                'neuro_refleks_patela_s',
                'neuro_refleks_achilles_d',
                'neuro_refleks_achilles_s',
                'neuro_koordinasi',
                'neuro_koordinasi_lainnya',
                'neuro_tonus_otot',
                'neuro_catatan',
            ]);
        });
    }
};

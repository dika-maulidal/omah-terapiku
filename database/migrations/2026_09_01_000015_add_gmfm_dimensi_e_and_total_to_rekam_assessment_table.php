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
            $table->json('gmfm_dimensi_e_scores')->nullable()->after('gmfm_dimensi_d_catatan');
            $table->integer('gmfm_dimensi_e_total')->nullable()->after('gmfm_dimensi_e_scores');
            $table->decimal('gmfm_dimensi_e_persen', 5, 2)->nullable()->after('gmfm_dimensi_e_total');
            $table->text('gmfm_dimensi_e_catatan')->nullable()->after('gmfm_dimensi_e_persen');
            $table->integer('gmfm_total_score')->nullable()->after('gmfm_dimensi_e_catatan');
            $table->decimal('gmfm_total_persen', 5, 2)->nullable()->after('gmfm_total_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'gmfm_dimensi_e_scores',
                'gmfm_dimensi_e_total',
                'gmfm_dimensi_e_persen',
                'gmfm_dimensi_e_catatan',
                'gmfm_total_score',
                'gmfm_total_persen',
            ]);
        });
    }
};

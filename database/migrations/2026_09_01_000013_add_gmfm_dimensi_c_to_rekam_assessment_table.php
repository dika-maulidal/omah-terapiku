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
            $table->json('gmfm_dimensi_c_scores')->nullable()->after('gmfm_dimensi_b_catatan');
            $table->integer('gmfm_dimensi_c_total')->nullable()->after('gmfm_dimensi_c_scores');
            $table->decimal('gmfm_dimensi_c_persen', 5, 2)->nullable()->after('gmfm_dimensi_c_total');
            $table->text('gmfm_dimensi_c_catatan')->nullable()->after('gmfm_dimensi_c_persen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'gmfm_dimensi_c_scores',
                'gmfm_dimensi_c_total',
                'gmfm_dimensi_c_persen',
                'gmfm_dimensi_c_catatan',
            ]);
        });
    }
};

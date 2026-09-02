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
            if (!Schema::hasColumn('rekam_assessment', 'rencana_edukasi_lainnya')) {
                $table->text('rencana_edukasi_lainnya')->nullable()->after('rencana_edukasi_konseling');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            if (Schema::hasColumn('rekam_assessment', 'rencana_edukasi_lainnya')) {
                $table->dropColumn('rencana_edukasi_lainnya');
            }
        });
    }
};

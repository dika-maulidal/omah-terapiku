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
            // Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT)
            $table->json('rom_mmt_data')->nullable()->after('nyeri_catatan');
            $table->text('rom_catatan')->nullable()->after('rom_mmt_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'rom_mmt_data',
                'rom_catatan',
            ]);
        });
    }
};

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
        Schema::table('pendaftaran_pasien', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran_pasien', 'status_menikah')) {
                $table->string('status_menikah', 50)->nullable()->after('jk');
            }
            if (!Schema::hasColumn('pendaftaran_pasien', 'kewarganegaraan')) {
                $table->string('kewarganegaraan', 20)->default('WNI')->after('alat_bantu');
            }
            if (!Schema::hasColumn('pendaftaran_pasien', 'cara_bayar')) {
                $table->string('cara_bayar', 100)->default('Gratis')->after('no_hp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pasien', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran_pasien', 'status_menikah')) {
                $table->dropColumn('status_menikah');
            }
            if (Schema::hasColumn('pendaftaran_pasien', 'kewarganegaraan')) {
                $table->dropColumn('kewarganegaraan');
            }
            if (Schema::hasColumn('pendaftaran_pasien', 'cara_bayar')) {
                $table->dropColumn('cara_bayar');
            }
        });
    }
};

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
        Schema::table('pasien', function (Blueprint $table) {
            if (!Schema::hasColumn('pasien', 'nama_wali')) {
                $table->string('nama_wali')->nullable()->after('pekerjaan');
            }
            if (!Schema::hasColumn('pasien', 'hubungan_wali')) {
                $table->string('hubungan_wali', 100)->nullable()->after('nama_wali');
            }
            if (!Schema::hasColumn('pasien', 'jenis_disabilitas')) {
                $table->string('jenis_disabilitas', 100)->nullable()->after('hubungan_wali');
            }
            if (!Schema::hasColumn('pasien', 'alat_bantu')) {
                $table->string('alat_bantu', 100)->nullable()->after('jenis_disabilitas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            if (Schema::hasColumn('pasien', 'nama_wali')) {
                $table->dropColumn('nama_wali');
            }
            if (Schema::hasColumn('pasien', 'hubungan_wali')) {
                $table->dropColumn('hubungan_wali');
            }
            if (Schema::hasColumn('pasien', 'jenis_disabilitas')) {
                $table->dropColumn('jenis_disabilitas');
            }
            if (Schema::hasColumn('pasien', 'alat_bantu')) {
                $table->dropColumn('alat_bantu');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            if (!Schema::hasColumn('pasien', 'nik')) {
                $table->string('nik', 20)->nullable()->after('nama');
            }
            if (!Schema::hasColumn('pasien', 'file_kk')) {
                $table->string('file_kk')->nullable()->after('alergi');
            }
            if (!Schema::hasColumn('pasien', 'file_resume')) {
                $table->string('file_resume')->nullable()->after('file_kk');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            if (Schema::hasColumn('pasien', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('pasien', 'file_kk')) {
                $table->dropColumn('file_kk');
            }
            if (Schema::hasColumn('pasien', 'file_resume')) {
                $table->dropColumn('file_resume');
            }
        });
    }
};

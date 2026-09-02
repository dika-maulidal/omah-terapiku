<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTerapisPendampingAndSesiToRekamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekam', function (Blueprint $table) {
            if (!Schema::hasColumn('rekam', 'terapis_pendamping_id')) {
                $table->unsignedBigInteger('terapis_pendamping_id')->nullable()->after('dokter_id');
            }
            if (!Schema::hasColumn('rekam', 'sesi_waktu')) {
                $table->string('sesi_waktu', 50)->nullable()->after('layanan_terapi');
            }
            if (!Schema::hasColumn('rekam', 'upt_lokasi')) {
                $table->string('upt_lokasi', 100)->nullable()->after('poli');
            }
        });

        Schema::table('pasien', function (Blueprint $table) {
            if (!Schema::hasColumn('pasien', 'upt_lokasi')) {
                $table->string('upt_lokasi', 100)->nullable()->after('alamat_lengkap');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekam', function (Blueprint $table) {
            if (Schema::hasColumn('rekam', 'terapis_pendamping_id')) {
                $table->dropColumn('terapis_pendamping_id');
            }
            if (Schema::hasColumn('rekam', 'sesi_waktu')) {
                $table->dropColumn('sesi_waktu');
            }
            if (Schema::hasColumn('rekam', 'upt_lokasi')) {
                $table->dropColumn('upt_lokasi');
            }
        });

        Schema::table('pasien', function (Blueprint $table) {
            if (Schema::hasColumn('pasien', 'upt_lokasi')) {
                $table->dropColumn('upt_lokasi');
            }
        });
    }
}

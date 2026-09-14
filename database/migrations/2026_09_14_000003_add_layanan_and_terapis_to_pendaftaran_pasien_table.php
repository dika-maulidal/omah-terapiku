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
            $table->string('layanan_terapi', 191)->nullable()->after('upt_lokasi');
            $table->unsignedBigInteger('poli_id')->nullable()->after('layanan_terapi');
            $table->date('tgl_rencana_kunjungan')->nullable()->after('poli_id');
            $table->string('jam_rencana_kunjungan', 100)->nullable()->after('tgl_rencana_kunjungan');
            $table->unsignedBigInteger('terapis_id')->nullable()->after('no_rm_diterbitkan');
            $table->date('tgl_sesi_disetujui')->nullable()->after('terapis_id');
            $table->string('jam_sesi_disetujui', 100)->nullable()->after('tgl_sesi_disetujui');
            $table->unsignedBigInteger('rekam_id')->nullable()->after('jam_sesi_disetujui');

            $table->foreign('terapis_id')->references('id')->on('terapis')->onDelete('set null');
            $table->foreign('rekam_id')->references('id')->on('rekam')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pasien', function (Blueprint $table) {
            $table->dropForeign(['terapis_id']);
            $table->dropForeign(['rekam_id']);
            $table->dropColumn([
                'layanan_terapi',
                'poli_id',
                'tgl_rencana_kunjungan',
                'jam_rencana_kunjungan',
                'terapis_id',
                'tgl_sesi_disetujui',
                'jam_sesi_disetujui',
                'rekam_id',
            ]);
        });
    }
};

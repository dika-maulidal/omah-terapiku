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
        Schema::create('pendaftaran_pasien', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pendaftaran', 50)->unique();
            $table->string('nama', 191);
            $table->string('nik', 50)->nullable();
            $table->string('tmp_lahir', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('jk', 20)->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('kodepos', 20)->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('desil', 50)->nullable();
            $table->string('nama_wali', 191)->nullable();
            $table->string('hubungan_wali', 100)->nullable();
            $table->string('no_hp', 50);
            $table->text('jenis_disabilitas')->nullable();
            $table->text('alat_bantu')->nullable();
            $table->text('keluhan_utama')->nullable();
            $table->string('upt_lokasi', 191)->nullable();
            $table->string('file_kk', 191)->nullable();
            $table->string('file_resume', 191)->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_petugas')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->unsignedBigInteger('pasien_id')->nullable();
            $table->string('no_rm_diterbitkan', 50)->nullable();
            $table->timestamps();

            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pasien');
    }
};

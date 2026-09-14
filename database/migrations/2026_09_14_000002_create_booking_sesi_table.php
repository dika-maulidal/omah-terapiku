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
        Schema::create('booking_sesi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 50)->unique();
            $table->unsignedBigInteger('pasien_id');
            $table->string('layanan_terapi', 100);
            $table->date('tgl_rencana');
            $table->text('keluhan_catatan')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('catatan_petugas')->nullable();
            $table->unsignedBigInteger('dokter_id')->nullable();
            $table->string('jam_sesi', 50)->nullable();
            $table->string('upt_lokasi', 191)->nullable();
            $table->unsignedBigInteger('rekam_id')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
            $table->foreign('dokter_id')->references('id')->on('terapis')->onDelete('set null');
            $table->foreign('rekam_id')->references('id')->on('rekam')->onDelete('set null');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_sesi');
    }
};

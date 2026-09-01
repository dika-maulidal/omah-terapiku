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
        Schema::create('rekam_assessment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_id')->constrained('rekam')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->unsignedBigInteger('dokter_id')->nullable();
            $table->string('jenis_assessment', 50)->default('General'); // General, Fisioterapi, Wicara, Netra, dll
            $table->date('tgl_assessment')->nullable();

            // 1. Kemampuan Motorik (Sesuai Assesment.md)
            $table->string('motorik_mengangkat_kepala', 100)->nullable();
            $table->string('motorik_posisi_tengkurap', 100)->nullable();
            $table->string('motorik_posisi_duduk', 100)->nullable();
            $table->string('motorik_merangkak', 100)->nullable();
            $table->string('motorik_berlutut', 100)->nullable();
            $table->string('motorik_berjalan', 100)->nullable();
            $table->text('motorik_catatan')->nullable();

            // 2. Kemampuan Aktivitas Sehari-hari / ADL (Sesuai Assesment.md)
            $table->string('adl_kontak_mata', 100)->nullable();
            $table->string('adl_duduk_tenang', 100)->nullable();
            $table->string('adl_gerakan_berulang', 100)->nullable();
            $table->string('adl_respon_nama', 100)->nullable();
            $table->string('adl_makan', 100)->nullable();
            $table->string('adl_mandi', 100)->nullable();
            $table->string('adl_berpakaian', 100)->nullable();
            $table->string('adl_bak', 100)->nullable();
            $table->string('adl_bab', 100)->nullable();
            $table->text('adl_catatan')->nullable();

            // 3. Kemampuan Wicara (Sesuai Assesment.md)
            $table->string('wicara_komunikasi', 100)->nullable();
            $table->string('wicara_organ', 100)->nullable();
            $table->text('wicara_organ_keterangan')->nullable();
            $table->string('wicara_makan_menelan', 100)->nullable();
            $table->text('wicara_makan_menelan_keterangan')->nullable();
            $table->text('wicara_catatan')->nullable();

            // 4. Evaluasi & Rencana Terapi Lanjutan
            $table->text('kesimpulan')->nullable();
            $table->text('rencana_terapi')->nullable();

            // 5. Payload Tambahan untuk step-by-step per jenis penyakit di masa depan
            $table->json('custom_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_assessment');
    }
};

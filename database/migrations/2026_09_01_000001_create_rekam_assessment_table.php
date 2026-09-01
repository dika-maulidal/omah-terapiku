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
            $table->text('motorik_mengangkat_kepala')->nullable();
            $table->text('motorik_posisi_tengkurap')->nullable();
            $table->text('motorik_posisi_duduk')->nullable();
            $table->text('motorik_merangkak')->nullable();
            $table->text('motorik_berlutut')->nullable();
            $table->text('motorik_berjalan')->nullable();
            $table->text('motorik_catatan')->nullable();

            // 2. Kemampuan Aktivitas Sehari-hari / ADL (Sesuai Assesment.md)
            $table->text('adl_kontak_mata')->nullable();
            $table->text('adl_duduk_tenang')->nullable();
            $table->text('adl_gerakan_berulang')->nullable();
            $table->text('adl_respon_nama')->nullable();
            $table->text('adl_makan')->nullable();
            $table->text('adl_mandi')->nullable();
            $table->text('adl_berpakaian')->nullable();
            $table->text('adl_bak')->nullable();
            $table->text('adl_bab')->nullable();
            $table->text('adl_catatan')->nullable();

            // 3. Kemampuan Wicara (Sesuai Assesment.md)
            $table->text('wicara_komunikasi')->nullable();
            $table->text('wicara_organ')->nullable();
            $table->text('wicara_organ_keterangan')->nullable();
            $table->text('wicara_makan_menelan')->nullable();
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

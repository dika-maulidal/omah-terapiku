<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE rekam MODIFY biaya_pemeriksaan INT NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE rekam MODIFY biaya_tindakan INT NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE rekam MODIFY biaya_obat INT NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE rekam MODIFY total_biaya INT NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE rekam MODIFY cara_bayar VARCHAR(191) NULL DEFAULT 'Gratis'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};

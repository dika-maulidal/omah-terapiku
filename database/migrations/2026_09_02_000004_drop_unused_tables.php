<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUnusedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop unneeded tables from old clinic system
        Schema::dropIfExists('pengeluaran_obat');
        Schema::dropIfExists('obat');
        Schema::dropIfExists('rekam_gigi');
        Schema::dropIfExists('kondisi_gigi');
        Schema::dropIfExists('gmfm_evaluasi');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No need to recreate unused legacy tables
    }
}

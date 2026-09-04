<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilesToRekamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekam', function (Blueprint $table) {
            if (!Schema::hasColumn('rekam', 'pemeriksaan_file')) {
                $table->string('pemeriksaan_file')->nullable()->after('pemeriksaan');
            }
            if (!Schema::hasColumn('rekam', 'tindakan_file')) {
                $table->string('tindakan_file')->nullable()->after('tindakan');
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
            if (Schema::hasColumn('rekam', 'pemeriksaan_file')) {
                $table->dropColumn('pemeriksaan_file');
            }
            if (Schema::hasColumn('rekam', 'tindakan_file')) {
                $table->dropColumn('tindakan_file');
            }
        });
    }
}

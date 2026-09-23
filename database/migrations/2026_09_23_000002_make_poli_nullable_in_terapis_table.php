<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakePoliNullableInTerapisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = Schema::hasTable('terapis') ? 'terapis' : 'dokter';

        if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'poli')) {
            DB::statement("ALTER TABLE `{$tableName}` MODIFY `poli` VARCHAR(255) NULL DEFAULT NULL");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = Schema::hasTable('terapis') ? 'terapis' : 'dokter';

        if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'poli')) {
            DB::statement("ALTER TABLE `{$tableName}` MODIFY `poli` VARCHAR(255) NOT NULL");
        }
    }
}

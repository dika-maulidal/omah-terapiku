<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStrToTerapisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = Schema::hasTable('terapis') ? 'terapis' : 'dokter';

        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'no_str')) {
                    $table->string('no_str', 100)->nullable()->after('poli');
                }
                if (!Schema::hasColumn($tableName, 'masa_berlaku_str')) {
                    $table->string('masa_berlaku_str', 100)->nullable()->after('no_str');
                }
                if (!Schema::hasColumn($tableName, 'file_str')) {
                    $table->string('file_str', 255)->nullable()->after('masa_berlaku_str');
                }
            });
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

        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'file_str')) {
                    $table->dropColumn('file_str');
                }
                if (Schema::hasColumn($tableName, 'masa_berlaku_str')) {
                    $table->dropColumn('masa_berlaku_str');
                }
                if (Schema::hasColumn($tableName, 'no_str')) {
                    $table->dropColumn('no_str');
                }
            });
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddNoTelpToOmahterapikuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = Schema::hasTable('omahterapiku') ? 'omahterapiku' : 'poli';
        
        if (!Schema::hasColumn($tableName, 'no_telp')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('no_telp', 50)->nullable()->after('alamat');
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
        $tableName = Schema::hasTable('omahterapiku') ? 'omahterapiku' : 'poli';
        if (Schema::hasColumn($tableName, 'no_telp')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('no_telp');
            });
        }
    }
}

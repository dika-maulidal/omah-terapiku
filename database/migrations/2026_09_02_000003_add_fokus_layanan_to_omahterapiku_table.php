<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFokusLayananToOmahterapikuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = Schema::hasTable('omahterapiku') ? 'omahterapiku' : 'poli';
        
        if (!Schema::hasColumn($tableName, 'fokus_layanan')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->text('fokus_layanan')->nullable()->after('alamat');
            });
        }

        // Set default fokus layanan based on CONTEXT.md
        DB::table($tableName)->where('nama', 'LIKE', '%PPSAB%')->update([
            'fokus_layanan' => 'Anak Berkebutuhan Khusus (ABK)'
        ]);
        DB::table($tableName)->where('nama', 'LIKE', '%PMKS%')->update([
            'fokus_layanan' => 'Dewasa, Lansia, ODGJ, Pasca-Stroke'
        ]);
        DB::table($tableName)->where('nama', 'LIKE', '%RSBN%')->update([
            'fokus_layanan' => 'Disabilitas Netra & Olahraga'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = Schema::hasTable('omahterapiku') ? 'omahterapiku' : 'poli';
        if (Schema::hasColumn($tableName, 'fokus_layanan')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('fokus_layanan');
            });
        }
    }
}

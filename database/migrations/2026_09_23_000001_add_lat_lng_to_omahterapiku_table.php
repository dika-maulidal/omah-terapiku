<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddLatLngToOmahterapikuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = Schema::hasTable('omahterapiku') ? 'omahterapiku' : 'poli';

        if (!Schema::hasColumn($tableName, 'latitude')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('latitude', 50)->nullable()->after('no_telp');
            });
        }

        if (!Schema::hasColumn($tableName, 'longitude')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('longitude', 50)->nullable()->after('latitude');
            });
        }

        // Backfill default coordinates for existing 3 UPTs if null
        $defaultCoords = [
            'UPT PPSAB Sidoarjo' => ['lat' => '-7.4526', 'lng' => '112.7135'],
            'Balai PRS PMKS Sidoarjo' => ['lat' => '-7.4530', 'lng' => '112.7160'],
            'UPT RSBN Malang' => ['lat' => '-8.0080', 'lng' => '112.6320'],
        ];

        foreach ($defaultCoords as $nama => $coords) {
            DB::table($tableName)
                ->where('nama', 'LIKE', "%{$nama}%")
                ->where(function ($query) {
                    $query->whereNull('latitude')->orWhereNull('longitude');
                })
                ->update([
                    'latitude' => $coords['lat'],
                    'longitude' => $coords['lng'],
                ]);
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

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (Schema::hasColumn($tableName, 'longitude')) {
                $table->dropColumn('longitude');
            }
            if (Schema::hasColumn($tableName, 'latitude')) {
                $table->dropColumn('latitude');
            }
        });
    }
}

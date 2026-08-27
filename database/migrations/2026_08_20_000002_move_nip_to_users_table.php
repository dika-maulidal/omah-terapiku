<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MoveNipToUsersTable extends Migration
{
    public function up()
    {
        $tableName = Schema::hasTable('terapis') ? 'terapis' : (Schema::hasTable('dokter') ? 'dokter' : null);

        if ($tableName && Schema::hasColumn($tableName, 'nip')) {
            $dokters = DB::table($tableName)->whereNotNull('nip')->get();
            foreach ($dokters as $dokter) {
                if (!empty($dokter->user_id) && !empty($dokter->nip)) {
                    $user = DB::table('users')->where('id', $dokter->user_id)->first();
                    if ($user && empty($user->nip)) {
                        $exists = DB::table('users')->where('nip', $dokter->nip)->exists();
                        if (!$exists) {
                            DB::table('users')->where('id', $dokter->user_id)->update(['nip' => $dokter->nip]);
                        }
                    }
                }
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'nip')) {
                    $table->dropColumn('nip');
                }
            });
        }
    }

    public function down()
    {
        $tableName = Schema::hasTable('terapis') ? 'terapis' : (Schema::hasTable('dokter') ? 'dokter' : null);

        if ($tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'nip')) {
                    $table->string('nip')->nullable()->after('id');
                }
            });

            $users = DB::table('users')->whereNotNull('nip')->get();
            foreach ($users as $user) {
                DB::table($tableName)->where('user_id', $user->id)->update(['nip' => $user->nip]);
            }
        }
    }
}

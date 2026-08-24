<?php

use App\Models\Dokter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveNipToUsersTable extends Migration
{
    public function up()
    {
        Dokter::with('user')->whereNotNull('nip')->get()->each(function ($dokter) {
            if ($dokter->user && !$dokter->user->nip && !\App\User::where('nip', $dokter->nip)->exists()) {
                $dokter->user->update(['nip' => $dokter->nip]);
            }
        });

        Schema::table('dokter', function (Blueprint $table) {
            $table->dropColumn('nip');
        });
    }

    public function down()
    {
        Schema::table('dokter', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('id');
        });

        Dokter::with('user')->get()->each(function ($dokter) {
            if ($dokter->user) {
                $dokter->forceFill(['nip' => $dokter->user->nip])->save();
            }
        });
    }
}

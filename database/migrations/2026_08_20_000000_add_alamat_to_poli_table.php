<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlamatToPoliTable extends Migration
{
    public function up()
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('nama');
        });
    }

    public function down()
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->dropColumn('alamat');
        });
    }
}
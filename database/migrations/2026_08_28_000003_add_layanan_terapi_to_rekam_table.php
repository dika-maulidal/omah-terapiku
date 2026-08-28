<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rekam', function (Blueprint $table) {
            if (!Schema::hasColumn('rekam', 'layanan_terapi')) {
                $table->string('layanan_terapi', 100)->nullable()->after('poli');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam', function (Blueprint $table) {
            if (Schema::hasColumn('rekam', 'layanan_terapi')) {
                $table->dropColumn('layanan_terapi');
            }
        });
    }
};

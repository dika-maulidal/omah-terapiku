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
            if (!Schema::hasColumn('rekam', 'latihan_rumahan')) {
                $table->text('latihan_rumahan')->nullable()->after('tindakan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam', function (Blueprint $table) {
            if (Schema::hasColumn('rekam', 'latihan_rumahan')) {
                $table->dropColumn('latihan_rumahan');
            }
        });
    }
};

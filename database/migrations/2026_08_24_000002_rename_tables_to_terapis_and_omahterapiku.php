<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dokter') && !Schema::hasTable('terapis')) {
            Schema::rename('dokter', 'terapis');
        }

        if (Schema::hasTable('poli') && !Schema::hasTable('omahterapiku')) {
            Schema::rename('poli', 'omahterapiku');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('terapis') && !Schema::hasTable('dokter')) {
            Schema::rename('terapis', 'dokter');
        }

        if (Schema::hasTable('omahterapiku') && !Schema::hasTable('poli')) {
            Schema::rename('omahterapiku', 'poli');
        }
    }
};

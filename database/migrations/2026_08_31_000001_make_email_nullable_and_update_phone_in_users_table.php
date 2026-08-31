<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `users` MODIFY `email` VARCHAR(255) NULL");
        DB::statement("ALTER TABLE `users` MODIFY `phone` VARCHAR(30) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `users` MODIFY `phone` VARCHAR(13) NOT NULL");
    }
};

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
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->json('denver_data')->nullable()->after('gmfm_total_persen');
            $table->integer('denver_pass_count')->nullable()->after('denver_data');
            $table->integer('denver_fail_count')->nullable()->after('denver_pass_count');
            $table->integer('denver_refusal_count')->nullable()->after('denver_fail_count');
            $table->integer('denver_no_count')->nullable()->after('denver_refusal_count');
            $table->text('denver_kesimpulan')->nullable()->after('denver_no_count');
            $table->text('denver_catatan')->nullable()->after('denver_kesimpulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_assessment', function (Blueprint $table) {
            $table->dropColumn([
                'denver_data',
                'denver_pass_count',
                'denver_fail_count',
                'denver_refusal_count',
                'denver_no_count',
                'denver_kesimpulan',
                'denver_catatan',
            ]);
        });
    }
};

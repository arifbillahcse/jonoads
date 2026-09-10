<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_study_stats', function (Blueprint $table) {
            // Marks the standout result. On a featured case study this drives
            // both the section heading and the before/after chart.
            $table->boolean('is_headline')->default(false)->after('label');
        });
    }

    public function down(): void
    {
        Schema::table('case_study_stats', function (Blueprint $table) {
            $table->dropColumn('is_headline');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // "Jono vs. the average agency" bar charts.
        Schema::create('comparison_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('baseline_label')->default('Avg agency');
            $table->decimal('baseline_value', 12, 2);
            $table->string('jono_label')->default('Jono');
            $table->decimal('jono_value', 12, 2);
            $table->string('suffix')->default('');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // The checklist printed under those charts.
        Schema::create('comparison_checks', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comparison_checks');
        Schema::dropIfExists('comparison_metrics');
    }
};

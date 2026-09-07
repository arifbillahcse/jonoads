<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->text('detail')->nullable();     // longer narrative for the featured block
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // The animated result figures on each card.
        Schema::create('case_study_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_study_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->decimal('value', 12, 2);
            $table->string('prefix')->default('');
            $table->string('suffix')->default('');
            $table->unsignedTinyInteger('decimals')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_study_stats');
        Schema::dropIfExists('case_studies');
    }
};

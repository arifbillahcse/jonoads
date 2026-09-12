<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The three ROAS Engine stages: Review, Operate, Improve.
        Schema::create('roas_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('number');  // drives the arc position in the diagram
            $table->string('title');
            $table->text('summary');                // homepage step copy
            $table->text('detail')->nullable();     // engine page breakdown copy
            $table->text('icon_svg')->nullable();   // inline SVG, rendered unescaped
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('roas_step_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roas_step_id')->constrained()->cascadeOnDelete();
            $table->string('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roas_step_features');
        Schema::dropIfExists('roas_steps');
    }
};

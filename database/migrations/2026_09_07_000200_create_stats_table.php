<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Every animated counter on the site. `group` says which strip it belongs to.
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index();
            $table->string('label');
            $table->decimal('value', 12, 2)->nullable();
            $table->string('prefix')->default('');
            $table->string('suffix')->default('');
            $table->unsignedTinyInteger('decimals')->default(0);
            // Slogan-style figures such as "24/7" that must not count up.
            $table->boolean('is_static')->default(false);
            $table->string('static_value')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};

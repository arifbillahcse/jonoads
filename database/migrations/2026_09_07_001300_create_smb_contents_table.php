<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Single-row content for the SMB landing page.
        Schema::create('smb_contents', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow');
            $table->string('headline');
            $table->text('intro');
            $table->string('industries_heading');
            $table->string('approach_heading');
            $table->string('cta_heading');
            $table->text('cta_body');
            $table->timestamps();
        });

        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('note');              // the demand pattern shown under each name
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industries');
        Schema::dropIfExists('smb_contents');
    }
};

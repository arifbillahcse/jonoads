<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_studies', function (Blueprint $table) {
            // The YouTube link as the editor pastes it — the watch page, the
            // share link, whatever. Only the video id is ever read back out.
            $table->string('video_url')->nullable()->after('detail');
        });
    }

    public function down(): void
    {
        Schema::table('case_studies', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }
};

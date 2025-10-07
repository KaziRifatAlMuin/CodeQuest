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
        Schema::create('problemtags', function (Blueprint $table) {
            $table->id('problemtag_id');
            $table->unsignedBigInteger('problem_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('problem_id')->references('problem_id')->on('problems')->onDelete('cascade');
            $table->foreign('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
            $table->unique(['problem_id', 'tag_id']); // prevent duplicate entries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problemtags');
    }
};

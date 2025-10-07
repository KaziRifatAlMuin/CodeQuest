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
        Schema::create('problems', function (Blueprint $table) {
            $table->id('problem_id');
            $table->string('title');
            $table->text('problem_link');
            $table->integer('rating')->default(0);
            $table->integer('solved_count')->default(0);
            $table->integer('stars')->default(0)->comment('number of users who starred this problem');
            $table->float('popularity')->default(0)->comment('popularity = problem stars / maximum stars in one problem');
            $table->timestamps();
            $table->primary('problem_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problems');
    }
};

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
        Schema::create('userproblems', function (Blueprint $table) {
            $table->id('userproblem_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('problem_id');
            $table->string('status')->default('unsolved')->comment('possible values: unsolved, trying, solved');
            $table->boolean('is_starred')->default(false);
            $table->timestamp('solved_at')->nullable();
            $table->string('submission_link')->nullable();
            $table->string('notes')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('problem_id')->references('problem_id')->on('problems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userproblems');
    }
};

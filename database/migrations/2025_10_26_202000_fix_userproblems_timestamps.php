<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixUserproblemsTimestamps extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('userproblems')) {
            return;
        }

        // Add timestamps only if they don't already exist
        if (!Schema::hasColumn('userproblems', 'created_at') || !Schema::hasColumn('userproblems', 'updated_at')) {
            Schema::table('userproblems', function (Blueprint $table) {
                if (!Schema::hasColumn('userproblems', 'created_at')) {
                    $table->timestamp('created_at')->nullable()->after('notes');
                }
                if (!Schema::hasColumn('userproblems', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable()->after('created_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('userproblems')) {
            return;
        }

        Schema::table('userproblems', function (Blueprint $table) {
            if (Schema::hasColumn('userproblems', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
            if (Schema::hasColumn('userproblems', 'created_at')) {
                $table->dropColumn('created_at');
            }
        });
    }
}

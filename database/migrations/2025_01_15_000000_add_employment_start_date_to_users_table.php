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
        // Only add employment_start_date if it doesn't already exist
        if (!Schema::hasColumn('users', 'employment_start_date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('employment_start_date')->nullable()->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop if it exists
        if (Schema::hasColumn('users', 'employment_start_date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('employment_start_date');
            });
        }
    }
};

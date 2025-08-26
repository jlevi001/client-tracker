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
        Schema::table('users', function (Blueprint $table) {
            // Add wage_type field and change existing wage columns
            $table->enum('wage_type', ['hourly', 'salary'])->nullable()->after('email_verified_at');
            $table->decimal('wage_rate', 10, 2)->nullable()->after('wage_type');
            
            // Drop the old separate columns
            $table->dropColumn(['hourly_wage', 'annual_salary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore the old columns
            $table->decimal('hourly_wage', 8, 2)->nullable()->after('email_verified_at');
            $table->decimal('annual_salary', 10, 2)->nullable()->after('hourly_wage');
            
            // Drop the new columns
            $table->dropColumn(['wage_type', 'wage_rate']);
        });
    }
};
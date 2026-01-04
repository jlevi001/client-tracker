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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            
            // Account identification
            $table->string('account_number', 10)->unique()->index();
            $table->string('company_name')->index();
            $table->string('trading_name')->nullable(); // DBA name
            
            // Contact information
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            
            // Primary address
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 10)->nullable(); // Abbreviated state/province
            $table->string('zip_code', 20)->nullable(); // Postal code
            $table->string('country', 50)->default('United States');
            
            // Billing address (if different from primary)
            $table->boolean('billing_address_same')->default(true);
            $table->string('billing_address_line_1')->nullable();
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state', 10)->nullable();
            $table->string('billing_zip_code', 20)->nullable();
            $table->string('billing_country', 50)->nullable();
            
            // Financial settings
            $table->enum('payment_terms', ['net15', 'net30', 'net45', 'net60', 'due_on_receipt'])->default('net30');
            $table->string('tax_id')->nullable();
            
            // Status and notes
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            
            // Audit fields
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Additional indexes
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

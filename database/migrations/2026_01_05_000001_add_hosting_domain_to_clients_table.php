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
        Schema::table('clients', function (Blueprint $table) {
            // Check if columns don't exist before adding (prevents duplicate column errors)
            if (!Schema::hasColumn('clients', 'hosting_provider')) {
                $table->string('hosting_provider', 100)->nullable();
            }
            if (!Schema::hasColumn('clients', 'hosting_managed_by')) {
                $table->enum('hosting_managed_by', ['lingo', 'client'])->nullable();
            }
            if (!Schema::hasColumn('clients', 'domain_registrar')) {
                $table->string('domain_registrar', 100)->nullable();
            }
            if (!Schema::hasColumn('clients', 'domain_registrar_other')) {
                $table->string('domain_registrar_other', 100)->nullable();
            }
            if (!Schema::hasColumn('clients', 'dns_managed_elsewhere')) {
                $table->boolean('dns_managed_elsewhere')->default(false);
            }
            if (!Schema::hasColumn('clients', 'dns_provider')) {
                $table->string('dns_provider', 100)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'hosting_provider',
                'hosting_managed_by',
                'domain_registrar',
                'domain_registrar_other',
                'dns_managed_elsewhere',
                'dns_provider',
            ]);
        });
    }
};

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
            // Hosting Information
            $table->string('hosting_provider', 100)->nullable()->after('default_hourly_rate');
            $table->enum('hosting_managed_by', ['lingo', 'client'])->nullable()->after('hosting_provider');
            
            // Domain Information
            $table->string('domain_registrar', 100)->nullable()->after('hosting_managed_by');
            $table->string('domain_registrar_other', 100)->nullable()->after('domain_registrar');
            $table->boolean('dns_managed_elsewhere')->default(false)->after('domain_registrar_other');
            $table->string('dns_provider', 100)->nullable()->after('dns_managed_elsewhere');
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

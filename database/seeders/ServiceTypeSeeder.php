<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceTypes = [
            [
                'name' => 'Consultation',
                'description' => 'General consultation and advisory services',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Computer Repair',
                'description' => 'Hardware and software repair services',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Regular maintenance and upkeep services',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Network Management',
                'description' => 'Network setup, configuration, and management',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Web Development',
                'description' => 'Website design and development services',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SEO',
                'description' => 'Search Engine Optimization services',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ADs',
                'description' => 'Advertising and marketing campaigns',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Social Media',
                'description' => 'Social media management and marketing',
                'is_billable' => true,
                'is_active' => true,
                'display_order' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('service_types')->insert($serviceTypes);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('property_status')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $types = [
            ['status' => 'Pending'],
            ['status' => 'For Sale'],
            ['status' => 'Sold'],
            ['status' => 'For Rent'],
            ['status' => 'Rented'],
            ['status' => 'Inactive'],
        ];

        DB::table('property_status')->insert($types);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('property_types')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $types = [
            ['type' => 'Apartment'],
            ['type' => 'House'],
            ['type' => 'Land'],
            ['type' => 'Office'],
            ['type' => 'Villa'],
            ['type' => 'Other']
        ];

        DB::table('property_types')->insert($types);
    }
}

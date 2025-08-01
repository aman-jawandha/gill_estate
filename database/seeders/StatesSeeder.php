<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('states')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $states = [
            ['name' => 'Alberta', 'code' => 'AB'],
            ['name' => 'British Columbia', 'code' => 'BC'],
            ['name' => 'Manitoba', 'code' => 'MB'],
            ['name' => 'New Brunswick', 'code' => 'NB'],
            ['name' => 'Newfoundland and Labrador', 'code' => 'NL'],
            ['name' => 'Nova Scotia', 'code' => 'NS'],
            ['name' => 'Ontario', 'code' => 'ON'],
            ['name' => 'Prince Edward Island', 'code' => 'PE'],
            ['name' => 'Quebec', 'code' => 'QC'],
            ['name' => 'Saskatchewan', 'code' => 'SK'],
            ['name' => 'Northwest Territories', 'code' => 'NT'],
            ['name' => 'Nunavut', 'code' => 'NU'],
            ['name' => 'Yukon', 'code' => 'YT'],
        ];

        DB::table('states')->insert($states);
    }
}

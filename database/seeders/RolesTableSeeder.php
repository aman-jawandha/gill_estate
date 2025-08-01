<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Role::insert([
            ['name' => 'admin',  'guard_name' => 'web'],
            ['name' => 'seller', 'guard_name' => 'web'],
            ['name' => 'buyer',  'guard_name' => 'web'],
        ]);
    }
}

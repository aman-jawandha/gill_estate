<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            ['name' => 'roles-list','guard_name' => 'web'],
            ['name' => 'create-role','guard_name' => 'web'],
            ['name' => 'edit-role','guard_name' => 'web'],
            ['name' => 'staff-list','guard_name' => 'web'],
            ['name' => 'create-staff','guard_name' => 'web'],
            ['name' => 'edit-staff','guard_name' => 'web'],
            ['name' => 'delete-staff','guard_name' => 'web'],
            ['name' => 'buyers-list','guard_name' => 'web'],
            ['name' => 'delete-buyer','guard_name' => 'web'],
            ['name' => 'sellers-list','guard_name' => 'web'],
            ['name' => 'delete-seller','guard_name' => 'web'],
            ['name' => 'properties-list','guard_name' => 'web'],
            ['name' => 'create-property','guard_name' => 'web'],
            ['name' => 'edit-property','guard_name' => 'web'],
            ['name' => 'delete-property','guard_name' => 'web'],
            ['name' => 'view-property','guard_name' => 'web'],
            ['name' => 'add-property-media','guard_name' => 'web'],
            ['name' => 'delete-property-media','guard_name' => 'web'],
            ['name' => 'faqs-list','guard_name' => 'web'],
            ['name' => 'create-faq','guard_name' => 'web'],
            ['name' => 'edit-faq','guard_name' => 'web'],
            ['name' => 'delete-faq','guard_name' => 'web'],
            ['name' => 'contact-us-list','guard_name' => 'web'],
            ['name' => 'delete-contact-msg','guard_name' => 'web'],
            ['name' => 'queries-list','guard_name' => 'web'],
            ['name' => 'delete-query','guard_name' => 'web'],
            ['name' => 'buyers-requirements-list','guard_name' => 'web'],
            ['name' => 'delete-requirement','guard_name' => 'web'],
            ['name' => 'sellers-properties','guard_name' => 'web'],
            ['name' => 'reject-property','guard_name' => 'web'],
        ];

        Permission::insert($permissions);
    }
}

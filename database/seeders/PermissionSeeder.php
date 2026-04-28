<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CRUD
        $permissions = [

            // site settings
            'create_site_settings',
            'read_site_settings',
            'update_site_settings',
            'delete_site_settings',

            // posts
            'create_post',
            'read_post',
            'update_post',
            'delete_post',

            // category
            'create_category',
            'read_category',
            'updated_category',
            'delete_category',

            // pages
            'create_page',
            'read_page',
            'update_page',
            'delete_page',

            // users
            'create_user',
            'read_user',
            'update_user',
            'delete_user',

            // general settings
            'create_general_settings',
            'read_general_settings',
            'update_general_settings',
            'delete_general_settings',

            // additional appearance settings
            'create_appearance_settings',
            'read_appearance_settings',
            'update_appearance_settings',
            'delete_appearance_settings',
        ];

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $adminRole->givePermissionTo($perm);
        }
    }
}

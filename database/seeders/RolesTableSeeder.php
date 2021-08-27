<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $super_admin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);


        $manage_product = Permission::create(['name' => 'manage products']);
        $manage_pin = Permission::create(['name' => 'manage pins']);
        $resend_link = Permission::create(['name' => 'resend download link']);

        $add_user = Permission::create(['name' => 'add user']);
        $view_user = Permission::create(['name' => 'view user']);


        $super_admin->syncPermissions([$manage_product, $manage_pin, $resend_link, $add_user, $view_user]);
        $admin->syncPermissions([$manage_product, $manage_pin, $resend_link, $view_user]);
        $editor->syncPermissions([$manage_product, $resend_link]);
    }
}

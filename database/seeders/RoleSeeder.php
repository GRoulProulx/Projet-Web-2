<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'view-cellar']);
        Permission::create(['name' => 'create-cellar']);
        Permission::create(['name' => 'edit-cellar']);

        Permission::create(['name' => 'view-bottle']);
        Permission::create(['name' => 'create-bottle']);
        Permission::create(['name' => 'edit-bottle']);
        Permission::create(['name' => 'delete-bottle']);

        Permission::create(['name' => 'delete-cellar']);

        // Création des rôles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        $admin->givePermissionTo([
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
            'view-bottle',
            'create-bottle',
            'edit-bottle',
            'delete-bottle',
            'view-cellar',
            'create-cellar',
            'edit-cellar',
            'delete-cellar',
        ]);


        $user->givePermissionTo([
            'create-user',
            'view-bottle',
            'create-bottle',
            'edit-bottle',
            'view-cellar',
            'create-cellar',
            'edit-cellar',
        ]);
    }
}

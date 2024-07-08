<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions untuk menu 'role' dan 'code'
        $permissions = [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any'
        ];

        $menus = ['role', 'code', 'user'];

        foreach ($menus as $menu) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => "{$permission}_{$menu}"]);
            }
        }

        // Buat roles
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $adminRole = Role::create(['name' => 'admin']);

        // Berikan semua permissions ke super_admin
        $superAdminRole->givePermissionTo(Permission::all());

        // Berikan permissions ke admin hanya untuk menu 'code'
        $adminPermissions = Permission::where('name', 'LIKE', '%_code')->get();
        $adminRole->givePermissionTo($adminPermissions);
    }
}

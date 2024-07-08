<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            [
                'name'=>'DPMS',
                'email'=>'dpms@example.com'
            ],
            [
                'name'=>'DPMU',
                'email'=>'dpmu@example.com'
            ],
            [
                'name'=>'DPMR',
                'email'=>'dpmr@example.com'
            ],
            [
                'name'=>'DPMT',
                'email'=>'dpmt@example.com'
            ],
            [
                'name'=>'DPMP',
                'email'=>'dpmp@example.com'
            ],
            [
                'name'=>'DPMA',
                'email'=>'dpma@example.com'
            ],
            [
                'name'=>'DPMG',
                'email'=>'dpmg@example.com'
            ],
            [
                'name'=>'DPME',
                'email'=>'dpme@example.com'
            ],
            [
                'name'=>'DPMK',
                'email'=>'dpmk@example.com'
            ],
        ];

        foreach ($users as $user) {
            $user=User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
            ]);
            // $roles='admin';
            // if ($user['name']=='DPMS') {
            //     $roles='super_admin';
            // }
            // $user->roles()->attach(Role::where('name', $roles)->first());


            if ($user['name']=='DPMS') {
                $user->assignRole('super_admin');
                
                // Berikan permissions langsung ke pengguna
                $permissions = \Spatie\Permission\Models\Permission::all();
                foreach ($permissions as $permission) {
                    $user->givePermissionTo($permission);
                }
            }else{
                $user->assignRole('admin');
                
                // Berikan permissions langsung ke pengguna hanya untuk menu 'code'
                $adminPermissions = \Spatie\Permission\Models\Permission::where('name', 'LIKE', 'code_%')->get();
                foreach ($adminPermissions as $permission) {
                    $user->givePermissionTo($permission);
                }
            }

        }
    }
}

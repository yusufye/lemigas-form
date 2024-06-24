<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Code;
use App\Models\User;
use App\Models\PublicForm;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = User::all()->pluck('id');
        foreach ($users as $user) {

            Code::factory()->count(10)->create(['created_by' => $user])->each(function ($code) {
                // Seed one public form for each code
                $public_form = PublicForm::factory()->create(['code_id' => $code->id]);
                $code->publicForm()->save($public_form);
            });
        }
    }
}

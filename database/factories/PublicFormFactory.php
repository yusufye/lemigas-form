<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PublicFormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kepentingan_1'=>fake()->numberBetween(1,4),
            'kepentingan_2'=>fake()->numberBetween(1,4),
            'kepentingan_3'=>fake()->numberBetween(1,4),
            'kepentingan_4'=>fake()->numberBetween(1,4),
            'kepentingan_5'=>fake()->numberBetween(1,4),
            'kepentingan_6'=>fake()->numberBetween(1,4),
            'kepentingan_7'=>fake()->numberBetween(1,4),
            'kepentingan_8'=>fake()->numberBetween(1,4),
            'kepentingan_9'=>fake()->numberBetween(1,4),
            'kepuasan_1'=>fake()->numberBetween(1,4),
            'kepuasan_2'=>fake()->numberBetween(1,4),
            'kepuasan_3'=>fake()->numberBetween(1,4),
            'kepuasan_4'=>fake()->numberBetween(1,4),
            'kepuasan_5'=>fake()->numberBetween(1,4),
            'kepuasan_6'=>fake()->numberBetween(1,4),
            'kepuasan_7'=>fake()->numberBetween(1,4),
            'kepuasan_8'=>fake()->numberBetween(1,4),
            'kepuasan_9'=>fake()->numberBetween(1,4),
            'korupsi_1'=>fake()->numberBetween(1,4),
            'korupsi_2'=>fake()->numberBetween(1,4),
            'korupsi_3'=>fake()->numberBetween(1,4),
            'korupsi_4'=>fake()->numberBetween(1,4),
            'korupsi_5'=>fake()->numberBetween(1,4),
            'korupsi_6'=>fake()->numberBetween(1,4),
            'korupsi_7'=>fake()->numberBetween(1,4),
            'korupsi_8'=>fake()->numberBetween(1,4),
            'korupsi_9'=>fake()->numberBetween(1,4),
            'company_name'=>fake()->company(),
            'company_address'=>fake()->address(),
            'company_phone'=>fake()->phoneNumber(),
            'remark'=>fake()->sentence(3),
            'submitted_at'=>$this->faker->dateTimeBetween('-30 days', '+120 days')
        ];
    }
}

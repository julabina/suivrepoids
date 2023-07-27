<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeightInfo>
 */
class WeightInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'weight' => rand(76, 130),
            'bmi' => rand(24, 34),
            'bfp' => rand(24, 34),
            'record_date' => now(),
        ];
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Goal;
use App\Models\User;
use App\Models\WeightInfo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $mainUser = User::factory()->create([
            'name' => 'Boby',
            'email' => 'test@test.fr',
            'size' => 183,
            'is_man' => true,
        ]);
        Goal::factory()->create([
            'user_id' => $mainUser->id,
            'current' => true,
        ]);
        Goal::factory()->create([
            'user_id' => $mainUser->id,
            'success' => rand(0, 1),
        ]);
        WeightInfo::factory()->create([
            'user_id' => $mainUser->id,
            'record_date' => fake()->dateTimeBetween(),
        ]);

        // other

        User::factory(10)->create([
            'size' => 180,
            'is_man' => rand(0, 1),
        ])->each(function ($user) {
            Goal::factory(rand(0, 1))->create([
                'user_id' => $user->id,
                'current' => true,
            ]);
            Goal::factory(rand(0, 15))->create([
                'user_id' => $user->id,
                'success' => rand(0, 1),
            ]);
            WeightInfo::factory(rand(1, 20))->create([
                'user_id' => $user->id,
                'record_date' => fake()->dateTimeBetween(),
            ]);
        });
    }
}

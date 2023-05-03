<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'number' => fake()->unique()->numberBetween(1,99),
            'birthdate' => fake()
                            ->dateTimeBetween((Carbon::now()->subYears(50)), (Carbon::now()->subYears(14)))
                            ->format('Y-m-d'),
        ];
    }
}

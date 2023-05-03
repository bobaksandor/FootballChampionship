<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teamName = fake()->unique()->city();
        $shortName = strtoupper(substr(str_shuffle($teamName), 0, 4));
        $shortName = fake()->unique()->regexify('[A-Z]{4}');
        return [
            'name' => $teamName . fake()->randomElement([' FC', ' United', ' City', ' Athletic', ' Rovers']),
            // 'shortname' => strtoupper(substr($teamName, 0,4)),
            'shortname' => $shortName,
            'image' => "placeholder",
        ];
    }
}

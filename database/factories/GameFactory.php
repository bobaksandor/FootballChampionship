<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */



class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dates_before = collect();
        $dates_after = collect();
        $days_back = 60;
        $days_forward = 60;
        $num_dates = 20;

        for ($i = 0; $i < $num_dates; $i++) {
            $date = fake()->dateTimeBetween("-{$days_back} days", 'now');
            $dates_before->push($date);
        }

        for ($i = 0; $i < $num_dates; $i++) {
            $date = fake()->dateTimeBetween('now', "+{$days_forward} days");
            $dates_after->push($date);
        }

        $date = $dates_before->concat($dates_after)->random();

        return [
            'start' => $date,
            'finished' => Carbon::now()->diffInHours($date) >= 3 && $date < now()
        ];
    }
}

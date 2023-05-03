<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::all();
        

        for($i = 0; $i < 20; $i++){
            do {
                $homeTeamId = $teams->random()->id;
                $awayTeamId = $teams->random()->id;
            } while ($homeTeamId === $awayTeamId);
            Game::factory()->create([
                'home_team_id' => $homeTeamId,
                'away_team_id' => $awayTeamId
            ]);
        }
    }
}

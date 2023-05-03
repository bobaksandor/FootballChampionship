<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games  = Game::all();
        foreach($games as $game){
            $players = ($game->homeTeam->players)->concat($game->awayTeam->players);
            for($i=0; $i<8; $i++){
                Event::factory()->create([
                    'game_id' => $game->id,
                    'player_id' => $players->random()->id,
                ]);
            }
        }
        
    }
}

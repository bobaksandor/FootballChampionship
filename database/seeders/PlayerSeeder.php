<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::all();
        foreach($teams as $team){
            for($i=0; $i<6; $i++){
                Player::factory()->create([
                    'team_id' => $team->id
                ]);
            }
        }
    }
}

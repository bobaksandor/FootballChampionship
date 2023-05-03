<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use App\Models\Game;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => "admin@szerveroldali.hu",
            'password' => password_hash('adminpwd', PASSWORD_DEFAULT),
            'is_admin' => true,
            ]);
        
        for($i = 1; $i<20; $i++){
            User::factory()->create([
            'email' => "user{$i}@szerveroldali.hu",
            ]);
        }

        $this->call(TeamSeeder::class);
        $this->call(PlayerSeeder::class);
        $this->call(GameSeeder::class);
        Game::factory()->create([
            'home_team_id' => 1,
            'away_team_id' => 2,
            'start' => now(),
            'finished' => false

        ]);
        Game::factory()->create([
            'home_team_id' => 4,
            'away_team_id' => 6,
            'start' => now(),
            'finished' => false

        ]);
        Game::factory()->create([
            'home_team_id' => 9,
            'away_team_id' => 3,
            'start' => now(),
            'finished' => false

        ]);
        $this->call(EventSeeder::class);

        $teams = Team::all();
        $users = User::all();

        foreach($users as $user){
            $userTeams = $teams->random(rand(0, 3));
            $user->teams()->attach($userTeams);
        }

        
    }
}

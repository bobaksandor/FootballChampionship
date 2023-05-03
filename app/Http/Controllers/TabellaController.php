<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class TabellaController extends Controller
{

    public function makeResults(){
        $results = collect();
        $games = Game::all();
        $players = Player::all();
        foreach($games as $game){
            $homeScore = 0;
            $awayScore = 0;
            if($game->start < now()){
                foreach($game->events as $event){
                    if($event->type == 'gól' && $players->firstWhere('id', $event->player_id)->team->id == $game->homeTeam->id){
                        $homeScore ++;
                    }
                    if($event->type == 'öngól' && $players->firstWhere('id', $event->player_id)->team->id == $game->homeTeam->id){
                        $awayScore ++;
                    }
                    if($event->type == 'gól' && $players->firstWhere('id', $event->player_id)->team->id == $game->awayTeam->id){
                        $awayScore ++;
                    }
                    if($event->type == 'öngól' && $players->firstWhere('id', $event->player_id)->team->id == $game->awayTeam->id){
                        $homeScore ++;
                    }
                }
                $results->push(['game_id' => $game->id, 'homeTeam' => $game->homeTeam->name , 'homeScore' => $homeScore, 'awayScore' =>$awayScore, 'awayTeam' => $game->awayTeam->name ]);
            }
        }
        return $results;
    }
    
    public function index(){
        $games = Game::all()->filter(function($game){
            return $game->finished;
        });
        
        $results = $this->makeResults();
        $teams = Team::all();
        
        $table = collect();

        $standings = collect();
        foreach($teams as $team){
            $scored = 0;
            $conceded = 0;
            $points = 0;
            foreach($results as $result){
                if($team->name == $result['homeTeam']){
                    if($result['homeScore'] > $result['awayScore']){
                        $points += 3;
                    }else if($result['homeScore'] == $result['awayScore']){
                        $points ++;
                    }
                    $scored += $result['homeScore'];
                    $conceded += $result['awayScore'];
                }
                if($team->name == $result['awayTeam']){
                    if($result['homeScore'] < $result['awayScore']){
                        $points += 3;
                    }else if($result['homeScore'] == $result['awayScore']){
                        $points ++;
                    }
                    $scored += $result['awayScore'];
                    $conceded += $result['homeScore'];
                }
            }
            $standings->push(['name' => $team->name, 'scored' => $scored, 'conceded' => $conceded, 'diff' => $scored-$conceded, 'points' => $points]);
        }
        

        return view('tabella', ['standings' => $standings->sortByDesc('points')]);
    }
}

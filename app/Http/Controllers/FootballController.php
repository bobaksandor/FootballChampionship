<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class FootballController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }
    
    
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
                $results->push(['game_id' => $game->id, 'homeScore' => $homeScore, 'awayScore' =>$awayScore]);
            }
        }
        return $results;
    }


    public function index()
    {
        // Code to retrieve all matches and display them
        $games = Game::all();
        $players = Player::all();
        $live = $games->filter(function ($game) {
            // return $game->start < now() && $game->finished == false;
            return Carbon::now()->diffInHours($game->start) <= 3 && $game->start < now() && $game->finished==false;
        });
        
        $results = $this->makeResults();
        $allGames = Game::with('events')->orderBy('start')->paginate(10);
        
        $results = collect();
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
                $results->push(['game_id' => $game->id, 'homeScore' => $homeScore, 'awayScore' =>$awayScore]);
            }
        }
        // $not_live_paginated = new LengthAwarePaginator($not_live->values(), $not_live->count(), 10);
        return view('games.index', ['live' => $live->sortBy('start'), 'games' => $allGames, 'results' => $results]);
    }

    public function show(Game $game)
    {
        // Code to retrieve a specific match by ID and display it
        $results = $this->makeResults();
        $players = Player::all();
        return view('games.show', ['game' => $game, 'results' => $results, 'players' =>$players]);
    }

    public function store(Request $request){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $validated = $request -> validate(
            [
                'start' => ['required', 'after_or_equal:now'],
                'homeTeam' => 'required|different:awayTeam',
                'awayTeam' => 'required|different:homeTeam',
            ],
            
        );
        
        

        $game = Game::factory()->create([
            'start' => $validated['start'],
            'finished' => 0,
            'home_team_id' => $validated['homeTeam'],
            'away_team_id' => $validated['awayTeam']
        ]);

        return to_route('games.index');

    }

    public function create(){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $teams = Team::all();
        return view('games.create', ['teams' => $teams]);
    }

    public function openEdit(Game $game){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $teams = Team::all();
        
        return view('games.update', ['game' =>$game, 'teams' => $teams]);
    }


    public function update(Request $request, $id)
    {
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }   
        if($request->input('which') == 'lezar'){
            $game = Game::findOrFail($id);
            $game->finished = 1;
            $game->save();
            return to_route('games.index');
        }
        if($request->input('which') == 'frissit'){
            $validated = $request -> validate(
                [
                    'start' => ['required', 'date'],
                    'homeTeam' => 'required|different:awayTeam',
                    'awayTeam' => 'required|different:homeTeam',
                ],
                
            );
            $game = Game::findOrFail($id);
            $game->start = $validated['start'];
            $game->home_team_id = $validated['homeTeam'];
            $game->away_team_id = $validated['awayTeam'];
            if(Carbon::now()->diffInHours($game->start) >= 3 && $game->start < now()){
                $game->finished = 1;
            }
            $game->save();
            $game->events()->delete();  
            
            $players = ($game->homeTeam->players)->concat($game->awayTeam->players);
            for($i=0; $i<8; $i++){
                Event::factory()->create([
                    'game_id' => $game->id,
                    'player_id' => $players->random()->id,
                ]);
            }
            
            
    
            return redirect()->route('games.show', $id);
            
        }

        
    }

    public function destroy(Game $game){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $game->delete();
        return redirect()->back();
    }
}

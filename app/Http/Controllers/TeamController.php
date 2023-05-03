<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    //
    public function index(){
        $teams = Team::all();
        return view('teams.index', ['teams' => $teams->sortBy('name')]);
    }

    public function show(Team $team){
        $games = $team->games()->sortBy('start');
        $players = $team->players->sortBy('name');
        $events = Event::all();
        $fc = new FootballController;
        $results = $fc->makeResults();

        // $playerEvents = collect();

        // foreach ($players as $player) {
        //     $eventsHelp = $events->where('player_id', '=', $player->id);

        //     foreach ($eventsHelp as $event) {
        //         $playerEvents->push([$player->id, $event->type]);
        //     }
        // }



        return view('teams.show', ['team' => $team, 'players' => $players, 'games' => $games, 'results' => $results, 'events' => $events]);
    }

    public function create(){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        return view('teams.create');
    }

    public function store(Request $request){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $validated = $request -> validate(
            [
                'name' => 'required|unique:teams|max:75',
                'shortname' => 'required|unique:teams|max:4'
            ]
        );
        if ($request -> hasFile('image')){
            $file = $request -> file('image');
            $fname = $file -> hashName();
            Storage::disk('public') -> put('images/' . $fname, $file -> get());
            $validated['image'] = $fname;
        }

        $team = Team::create($validated);

        for($i=0; $i<6; $i++){
            Player::factory()->create([
                'team_id' => $team->id
            ]);
        }

        return to_route('teams.index');
    }

    public function openEdit(Team $team){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        
        
        return view('teams.update', ['team' => $team]);
    }

    public function update(Request $request, $id){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $validated = $request -> validate(
            [
                'name' => 'sometimes|required|unique:teams,name,' . $id . '|max:75',
                'shortname' => 'required|unique:teams,shortname,' . $id . '|max:4'
            ]
        );
        if ($request -> hasFile('image')){
            $file = $request -> file('image');
            $fname = $file -> hashName();
            Storage::disk('public') -> put('images/' . $fname, $file -> get());
            $validated['image'] = $fname;
        }

        $team = Team::findOrFail($id);
        $team->name = $validated['name'];
        $team->shortname = $validated['shortname'];
        if(isset($validated['image'])){
            $team->image = $validated['image'];
        }
        $team->save();

        return redirect()->route('teams.show', $id);

    }

    public function playerCreator(Team $team){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        return view('players.create', ['team' =>$team]);
    }
}

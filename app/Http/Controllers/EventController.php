<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    //
    public function destroy(Event $event){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $event->delete();
        return redirect()->back();
    }

    public function store(Request $request){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $validated = $request -> validate(
            [
                'minute' => 'required|integer|digits_between:1,3|max:150',
                'type' => [
                    'required',
                    Rule::in(['gól', 'öngól', 'piros lap', 'sárga lap'])
                ],
                'player' => 'required|integer|exists:players,id',
                'passGame' => 'required|integer|exists:games,id'
            ],
            [
                'minute.required' => 'Adja meg, hogy hanyadik perc.',
            ]
        );
        

        $event = Event::factory()->create([
            'type' => $validated['type'],
            'minute' => $validated['minute'],
            'player_id' => $validated['player'],
            'game_id' => $validated['passGame']
        ]);

        return redirect()->route('games.show', $validated['passGame']);

    }
}

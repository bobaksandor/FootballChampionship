<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function store(Request $request){
        if(auth()->user() == null || !auth()->user()->is_admin){
            abort(403);
        }
        $validated = $request -> validate(
            [
                'name' => [
                    'required',
                    'regex:/^[a-zA-ZáÁéÉíÍóÓöÖőŐúÚüÜűŰ\s]+$/u',
                    'max:100',
                ],                
                'number' => 'required|integer|between:1,99',
                'birthdate' => [
                    'required',
                    'date_format:Y-m-d',
                    'before_or_equal:2010-01-01',
                    'after_or_equal:1973-01-01',
                ],
                'team_id' => 'required|numeric'

            ]
        );
        

        $player = Player::factory()->create([
            'name' => $validated['name'],
            'number' => $validated['number'],
            'birthdate' => $validated['birthdate'],
            'team_id' => $validated['team_id'],
        ]);

        return redirect()->route('teams.show', $validated['team_id']);
    }
}

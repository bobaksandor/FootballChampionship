<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function players(){
        return $this -> hasMany(Player::class);
    }

    public function users(){
        return $this -> belongsToMany(User::class) -> withTimestamps();
    }

    public function games(){
        $home =  $this -> hasMany(Game::class, 'home_team_id')->get();
        $away =  $this -> hasMany(Game::class, 'away_team_id')->get();

        return $home->concat($away);
    }

    protected $fillable = [
        'name',
        'shortname',
        'image',
    ];
}

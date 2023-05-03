<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FootballController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TabellaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//GAMES
Route::get('/', [FootballController::class, 'welcome']); 
// Route::get('/games', [FootballController::class, 'index'])->name('games.index');
Route::get('/games/create', [FootballController::class, 'create'])->name('games.create');

Route::get('games/update/{game}', [FootballController::class, 'openEdit'])->name('games.openEdit');

//RESOURCES
Route::resource('games', FootballController::class);
Route::resource('events', EventController::class);
Route::resource('teams', TeamController::class);
Route::resource('players', PlayerController::class);
Route::resource('tables', TabellaController::class);

//TEAMS
Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
Route::get('teams/update/{team}', [TeamController::class, 'openEdit'])->name('teams.openEdit');
Route::get('teams/{team}/player/create', [TeamController::class, 'playerCreator'])->name('teams.playerCreator');

//TABELLA


Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

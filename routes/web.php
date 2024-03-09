<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\ImageEvenementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('accueil');
});

Route::get('/games', function () {
    return view('games');
});


// route pour game index
Route::get('/games', [GameController::class, 'index'])->name('game.index');
Route::post('/game', [GameController::class, 'store'])->name('game.store');
Route::post('/game/commencer', [GameController::class, 'commencer'])->name('game.commencer');
Route::post('/game/mitemps', [GameController::class, 'mitemps'])->name('game.mitemps');
Route::post('/game/pause', [GameController::class, 'pause'])->name('game.pause');
Route::post('/game/fin', [GameController::class, 'fin'])->name('game.fin');
Route::get('/game/go', [GameController::class, 'go'])->name('game.go');

//but receveur et but visiteur
Route::post('game/but_receveur', [GameController::class, 'but_receveur'])->name('game.but_receveur');
Route::post('game/but_visiteur', [GameController::class, 'but_visiteur'])->name('game.but_visiteur');

// route pour une game
Route::get('/game', function () {
    return view('game');
});

// route pour evenement 
Route::post('/evenement', [EvenementController::class, 'store'])->name('evenement.store');

// route pour imageEvenement
Route::post('/imageEvenement', [ImageEvenementController::class, 'store'])->name('imageEvenement.store');
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Evenement;
use App\Models\ImageEvenement;

class GameController extends Controller
{
    //

    public function index()
    {
        // Récupération de tous les games
        $games = Game::all();

        // Retourne la vue game.blade en lui passant les games récupérés
        return view('games', compact('games'));
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'receveur' => 'required|string',
            'visiteur' => 'required|string',
            'couleur_receveur' => 'required|string',
            'couleur_visiteur' => 'required|string',
            'duree' => 'required|numeric|min:25|max:45',
            'AC' => 'required|string',
            'AA1' => 'nullable|string',
            'AA2' => 'nullable|string',
            'A4' => 'nullable|string',
            
        ]);

        $validatedData['date'] = date('Y-m-d');
        $validatedData['timeline'] = 'ini';

        // Création d'un nouveau game
        Game::create($validatedData);

        // Redirection a la page game.blade en recuperant les données de la base de données
        return redirect('/games')->with('success', 'match créé avec succès');
    }

    public function go(Request $request)
    {
        $game = Game::find($request->id);
        $evenements = Evenement::where('game_id', $request->id)->get();

        //get all the ImageEvenement where game_id = $request->id
        $images = ImageEvenement::where('game_id', $request->id)->get();

        return view('game', compact('game', 'evenements', 'images'));
    }
    

    public function commencer(Request $request)
    {
        $game = Game::find($request->id);
        $date = date('Y-m-d H:i:s');
        $game->debut_chrono = $date;
        $game->timeline = '1';
        $game->save();
        // revenir a la page du match
        return redirect('/game/go?id='.$request->id);
    }

    public function mitemps(Request $request)
    {
        $game = Game::find($request->id);
        $date = date('Y-m-d H:i:s');
        $game->mitemps_chrono = $date;

        // but_receveur_mi_temps and but_visiteur_mi_temps
        $game->but_receveur_mi_temps = $game->but_receveur;
        $game->but_visiteur_mi_temps = $game->but_visiteur;

        $game->timeline = '2';

        $game->save();
        // revenir a la page du match
        return redirect('/game/go?id='.$request->id);
    }

    public function pause(Request $request)
    {
        $game = Game::find($request->id);
        $game->timeline = '0';
        $game->save();
        // revenir a la page du match
        return redirect('/game/go?id='.$request->id);
    }

    // fin du match
    public function fin(Request $request)
    {
        $game = Game::find($request->id);
        $game->timeline = 'fin';
        $game->save();
        // revenir a la page du match
        return redirect('/game/go?id='.$request->id);
    }

    public function but_receveur(Request $request)
    {
        $game = Game::find($request->id);
        // get the current game but_receveur and add 1
        $but_receveur = $game->but_receveur;
        $but_receveur++;
        $game->but_receveur = $but_receveur;
        $game->save();
        // revenir a la page du match
        return redirect('/game/go?id='.$request->id);
    }

    public function but_visiteur(Request $request)
    {
        $game = Game::find($request->id);
        // get the current game but_visiteur and add 1
        $but_visiteur = $game->but_visiteur;
        $but_visiteur++;
        $game->but_visiteur = $but_visiteur;
        $game->save();
        // revenir a la page du match
        return redirect('/game/go?id='.$request->id);
    }
}

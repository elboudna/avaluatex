<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evenement;

class EvenementController extends Controller
{
    //

    public function store(Request $request)
    {
        // dd($request->all());
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'arbitre' => 'required|string',
            'point' => 'required|string',
            'equipe' => 'nullable|string',
            'joueur' => 'nullable|numeric',
            'minute' => 'required|string',
            'evenement' => 'required|string',
            'sanction' => 'nullable|string',
            'commentaires' => 'nullable|string',
            'game_id' => 'required|numeric',
        ]);

        $validatedData['icone'] = '1';


        // Création d'un nouveau evenement
        Evenement::create($validatedData);

        // Redirection a la page game.blade en recuperant les données de la base de données
        return redirect('/game/go?id='.$request->game_id)->with('success', 'evenement créé avec succès');
    }
}

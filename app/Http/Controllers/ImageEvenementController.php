<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageEvenement;
use App\Models\Evenement;

class ImageEvenementController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'position_x' => 'required|numeric',
            'position_y' => 'required|numeric',
            'image_url' => 'required|string',
            'evenement_id' => 'required|numeric',
            'numero_evenement' => 'required|numeric',
            'game_id' => 'required|numeric',
        ]);

        // Création d'une nouvelle imageEvenement
        ImageEvenement::create($validatedData);

        // update the icon of the evenement
        $evenement = Evenement::find($request->evenement_id);
        $evenement->icone = '0';
        $evenement->save();

        // Redirection a la page game.blade en recuperant les données de la base de données
        return redirect('/game/go?id='.$request->game_id)->with('success', 'imageEvenement créé avec succès');
    }


}


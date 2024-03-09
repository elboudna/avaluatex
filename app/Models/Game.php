<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'receveur',
        'but_receveur',
        'but_receveur_mi_temps',
        'couleur_receveur',
        'visiteur',
        'but_visiteur',
        'but_visiteur_mi_temps',
        'couleur_visiteur',
        'duree',
        'AC',
        'AA1',
        'AA2',
        'A4',
        'date',
        'debut_chrono',
        'mitemps_chrono',
        'timeline',
    ];
}

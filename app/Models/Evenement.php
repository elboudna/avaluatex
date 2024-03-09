<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'minute',
        'arbitre',
        'point',
        'evenement',
        'joueur',
        'equipe',
        'sanction',
        'commentaires',
        'icone'
    ];
}

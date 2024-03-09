<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageEvenement extends Model
{
    use HasFactory;

    // name table image_evenement

    protected $fillable = [
        'position_x',
        'position_y',
        'image_url',
        'evenement_id',
        'numero_evenement',
        'game_id'
    ];
}

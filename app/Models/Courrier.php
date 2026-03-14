<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courrier extends Model
{
    protected $fillable = [
        'reference',
        'objet',
        'type',
        'date_envoi',
        'date_reception',
        'statut',
        'user_id',
        'image'
    ];
}
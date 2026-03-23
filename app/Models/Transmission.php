<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transmission';

    protected $fillable = [
        'date_transmission',
        'commentaire',
        'courrier_id',
        'expediteur_id',
        'destinataire_id',
    ];

    public function courrier()
    {
        return $this->belongsTo(Courrier::class, 'courrier_id', 'id_courrier');
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }
}
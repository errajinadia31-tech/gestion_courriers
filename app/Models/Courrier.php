<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Courrier extends Model
{
    protected $primaryKey = 'id_courrier'; 

    public $incrementing = true; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'reference', 'objet', 'type', 'date','statut', 'type_document',
        'expediteur', 'destinataire_externe', 'mode_envoi', 'file', 'user_id'
    ];

    public function getRouteKeyName()
    {
        return 'id_courrier'; 
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transmissions()
{
    return $this->hasMany(Transmission::class, 'courrier_id', 'id_courrier');
}
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_archive';

    protected $fillable = [
        'date_archivage',
        'emplacement',
        'courrier_id',
        'user_id',
    ];

    // العلاقة مع Courrier
   public function user()
{
    return $this->belongsTo(User::class);
}

public function courrier()
{
    return $this->belongsTo(Courrier::class, 'courrier_id', 'id_courrier');
}

 
}
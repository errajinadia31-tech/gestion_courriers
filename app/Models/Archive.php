<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_archive';

    protected $fillable = [
        'courrier_id',
        'archived_by',
        'date_archivage',
        'emplacement'
    ];

    public function courrier()
    {
        return $this->belongsTo(Courrier::class, 'courrier_id', 'id_courrier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UtilisateurModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'utilisateurs'; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

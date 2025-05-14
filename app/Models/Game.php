<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'nom',
        'usuari',
        'data',
        'hora',
        'puntuació',
        'clics',
    ];

    // RELACIÓN: este juego pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'usuari');
    }
}

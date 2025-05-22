<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascotas extends Model
{
    use HasFactory;

    protected $table = 'mascotas';
    protected $fillable = [
        'nombre',
        'raza',
        'edad',
        'peso',
        'color',
        'foto',
        'user_id',
    ]


     public function user()
    {
        return $this->belongsTo(User::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joc extends Model
{
    use HasFactory;

    protected $table = 'jocs';

    protected $fillable = [
        'nom',
        'descripcio',
        'genere',
        'any_llancament',
        'desenvolupador',
    ];
}

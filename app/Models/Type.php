<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Définit la relation entre le modèle Type et Bottle
    // Un Type peut avoir plusieurs bouteilles
    public function bottles()
    {
        return $this->hasMany(Bottle::class);
    }
}

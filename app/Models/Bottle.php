<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'price',
        'type',
        'format',
        'country',
        'code_saq',
        'url',
    ];

    // Définit la relation entre le modèle Bottle et Type
    // Une bouteille appartient à un Type
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    use HasFactory;
    protected $casts = [
        'price' => 'float',
    ]; 
    
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

    //Définit la relation avec le modèle CellarBottle
    //Une bouteille peut appartenir à plusieurs cellarBottles
    public function cellarBottles()
    {
        return $this->hasMany(CellarBottle::class, 'bottle_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CellarBottle extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_date',
        'storage_until',
        'notes',
        'price',
        'quantity',
        'vintage',
        'bottle_id',
        'cellar_id',
    ];

    //Définit la relation entre le modèle CellarBottle et le modèle Bottle
    // Un CellarBottle appartient à un Bottle
    public function bottle()
    {
        return $this->belongsTo(Bottle::class);
    }

    //Définit la relation entre le modèle CellarBottle et le modèle Cellar
    //Un CellarBottle peut appatenir à plusieurs Cellar
    public function cellars()
    {
        return $this->belongsTo(Cellar::class, 'cellar_id');
    }
}
 
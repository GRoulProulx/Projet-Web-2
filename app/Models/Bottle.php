<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Bottle extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [''];

    public function toSearchableArray() {

        $searchArray = [
            'name' => $this->name,
            'type' => $this->type,
            'format' => $this->format,
            'country' => $this->country,
            'is_custom' => $this->is_custom,
        ];
        return $searchArray;
    }

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
        'user_id',
        'is_custom'
    ];

    //Définit la relation avec le modèle CellarBottle
    //Une bouteille peut appartenir à plusieurs cellarBottles
    public function cellarBottles()
    {
        return $this->hasMany(CellarBottle::class, 'bottle_id');
    }

      public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cellar extends Model
{ 
    use HasFactory;

    protected $fillable = [
        'name', 
        'user_id',
    ];

    // Définit la relation entre le modèle Cellar et le modèle User
    // Un Cellar appartient à un User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Définit la relation entre le modèle Cellar et le modèle CellarBottle
    // Un Cellar peut avoir plusieurs CellarBottle
    public function cellarBottles(): BelongsToMany
    {
        return $this->belongsToMany(CellarBottle::class, 'cellar_bottles_has_cellars');
    }

}

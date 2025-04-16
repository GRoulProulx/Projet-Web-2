<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellar extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_date',
        'storage_until',
        'notes',
        'price',
        'quantity',
        'vintage',
        'user_id'
    ];

    // Définit la relation entre le modèle Cellar et le modèle User
    // Un Cellar appartient à un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}

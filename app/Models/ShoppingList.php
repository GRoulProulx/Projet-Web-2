<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;
    protected $table = 'shopping_list';

    protected $fillable = [
        'user_id',
        'bottle_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bottle() {
        return $this->belongsTo(Bottle::class);
    }
}


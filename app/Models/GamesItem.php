<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamesItem extends Model
{
    use HasFactory;

    protected $table = 'games_item';

    protected $fillable = [
        'code',
        'title',
        'game_code',
        'ag_code',
        'price',
        'isActive',
        'from'
    ];

    // N to 1 (games_item -> games)
    public function game()
    {
        return $this->belongsTo(Games::class, 'code', 'game_code', 'category');
        
    }
    public function redeem()
    {
        return $this->hasMany(GamesVoucher::class, 'game_code', 'code');
    }
}

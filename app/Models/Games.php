<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'title',
        'img',
        'code',
        'category_code'
    ];

    // N to 1 (games -> category)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_code', 'category_code', 'category');
    }

    // 1 to N (games -> games_item)
    public function games_item()
    {
        return $this->hasMany(GamesItem::class, 'game_code', 'code');
    }

    // 1 to N (games -> fields)
    public function fields()
    {
        return $this->hasMany(Fields::class, 'game_code', 'code');
    }
}

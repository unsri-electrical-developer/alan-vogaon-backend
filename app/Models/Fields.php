<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    use HasFactory;

    protected $table = 'fields';

    protected $fillable = [
        'game_code',
        'name',
        'type',
    ];

    // N to 1 (fields -> games)
    public function game()
    {
        return $this->belongsTo(Games::class, 'code', 'game_code');
    }
}

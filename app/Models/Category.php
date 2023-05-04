<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'category_name',
        'category_code'
    ];

    // 1 to N (category -> games)
    public function games()
    {
        return $this->hasMany(Games::class, 'category_code', 'category_code');
    }
}

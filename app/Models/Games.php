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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_code', 'category_code', 'category');
    }
}

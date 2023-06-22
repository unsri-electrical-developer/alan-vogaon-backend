<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamesVoucher extends Model
{
    use HasFactory;

    protected $table = 'games_item_voucher';

    protected $fillable = [
        'detail_product_code',
        'redeem_code',
        'code',
        'game_code',
        'status',
        'game_item_code'
    ];

   public function game()
    {
        return $this->belongsTo(Games::class, 'code', 'game_code');
        
    }

     public function games_item()
    {
        return $this->belongsTo(GamesItem::class, 'code', 'game_item_code');
        
    }


}

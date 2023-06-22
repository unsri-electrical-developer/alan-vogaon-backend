<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamesVoucher extends Model
{
    use HasFactory;

    protected $table = 'games_item_voucher';

    protected $fillable = [
        'redeem_code',
        'game_code',
        'voucher_status',
        'item_code'
    ];

   public function game()
    {
        return $this->belongsTo(Games::class, 'code', 'game_code');
        
    }

     public function games_item()
    {
        return $this->belongsTo(GamesItem::class, 'code', 'item_code');
        
    }


}

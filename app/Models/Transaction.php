<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'transaction_code',
        'users_code',
        'email',
        'status',
        'total_amount',
        'subtotal',
        'fee',
        'voucher_discount',
        'voucher_code',
        'payment_method',
        'transaction_url',
        'from',
        'no_reference',
        'game_transaction_number',
        'game_transaction_status',
        'game_transaction_message',
        'type'
    ];
}

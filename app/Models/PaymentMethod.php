<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_method';

    protected $fillable = [
        'pm_code',
        'pm_title',
        'pm_logo',
        'from',
        'status',
        'min_order',
        'fee',
        'position'
    ];
}

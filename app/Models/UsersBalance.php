<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersBalance extends Model
{
  use HasFactory;
  
  protected $table = 'users_balance';
  
  protected $fillable = [
    'users_balance_code',
    'users_code',
    'users_balance',
    'created_at',
    'updated_at'
  ];
}

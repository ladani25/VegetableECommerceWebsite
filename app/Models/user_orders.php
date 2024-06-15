<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_orders extends Model
{
    use HasFactory;
    public $table = "user_orders";
    public $primartyKey = "o_id";

    public $fillable = [
        'order_id', 'p_id', 'u_id', 'discount', 'u_quantity'
      
    ];
}

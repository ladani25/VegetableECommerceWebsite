<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_orders extends Model
{
    use HasFactory;
    public $table = "userorders";

    public $timestamps = false;
    public $primartyKey = "o_id";

    public $fillable = [
        'order_id', 'p_id', 'u_id', 'discount', 'u_qty'
      
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'p_id');
    }
}

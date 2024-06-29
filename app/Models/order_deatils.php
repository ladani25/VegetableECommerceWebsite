<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\order;

class order_deatils extends Model
{
    use HasFactory;

    protected $table = "order_details";

    protected $fillable = [
        'order_id', 'total_amount', 'sub_total', 'discount', 
        'payment_type', 'payment_status', 'order_date', 'u_id'
    ];

    
}
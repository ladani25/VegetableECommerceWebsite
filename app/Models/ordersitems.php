<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordersitems extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = [
        'order_id',
        'total_amount',
        'sub_total',
        'discount',
        'payment_type',
        'payment_status',
        'order_date',
        'u_id'
    ];
    
}

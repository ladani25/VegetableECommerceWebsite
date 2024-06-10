<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// class order_deatils extends Model
// {
//     use HasFactory;
//     protected  $table = "order_details";
//     protected $fillable = ['id','order_id','totalal_amout' , 'sub totale' , 'discount' , 'payment type' , 'payment stutes' , 'order_date' , 'u_id'];


// }


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'sub_total', 'quantity', 'coupon', 
        'total_amount', 'status', 'payment_method', 'payment_status'
    ];
}

class order_deatils extends Model
{
    use HasFactory;

    protected $table = "order_details";

    protected $fillable = [
        'order_id', 'total_amount', 'sub_total', 'discount', 
        'payment_type', 'payment_status', 'order_date', 'u_id'
    ];
}
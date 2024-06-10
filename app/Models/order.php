<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory; 
    protected  $table = "order";
    protected $fillable = ['order_id', 'qty', 'amount', 'u_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'u_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'p_id');
    }
    

}
   



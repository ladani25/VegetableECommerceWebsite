<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory; 
    protected  $table = "order";
    protected $fillable = ['id', 'qty', 'amount', 'u_id'];
}
   



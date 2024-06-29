<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "carts";
    protected $primaryKey = "id";
    protected $attributes = [
        'quantity' => 1,
    ];
    protected $fillable = ['u_id', 'p_id'];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'u_id');
    }

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'p_id'); // Assuming 'p_id' is the foreign key
    }

    public function products()
{
    return $this->hasMany(Product::class , 'p_id');
}
}

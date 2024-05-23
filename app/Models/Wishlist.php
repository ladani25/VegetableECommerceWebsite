<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = "wishlists";
    protected $primaryKey = 'w_id';
    protected $fillable = ['u_id', 'p_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'u_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'p_id'); // Assuming 'p_id' is the foreign key in the wishlist table
    }
}

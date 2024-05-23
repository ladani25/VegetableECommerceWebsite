<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = "p_id";

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function category()
{
    return $this->belongsTo(Category::class,'c_id','c_id');
}

// public function wishlists()
// {
//     return $this->hasMany(Wishlist::class);
// }

public function wishlists()
{
    return $this->hasMany(Wishlist::class, 'p_id'); // Assuming 'p_id' is the foreign key in the wishlist table
}

public function cart()
{
    return $this->hasMany(Cart::class,'p_id');
}
}

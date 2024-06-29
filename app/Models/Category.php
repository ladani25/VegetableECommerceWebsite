<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categeroy';
    protected $primaryKey = "c_id";
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function products()
{
    return $this->hasMany(Product::class , 'c_id');
}



public function login()
{
    $totalCategories = Category::count();
    return view('admin.dashboard', compact('totalCategories'));
}


}

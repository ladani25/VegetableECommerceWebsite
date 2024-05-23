<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'category_id', 'p_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function products()
    {
        return $this->belongsTo(product::class);
    }
}

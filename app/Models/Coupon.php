<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public $table = 'coupons';

    protected $fillable = [
        'coupon_code',
        'type',
        'amount',
    ];

    public static function findByCode($code){
        return self::where('coupon_code',$code)->first();
    }
    public function discount($total)
    {
        if ($this->type == 'percent') {
            return $total * ($this->amount / 100);
        } elseif ($this->type == 'flate') {
            return $this->amount;
        } else {
            return 0;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percent',
        'limit',
        'used',
        'start_date',
        'end_date',
        'fixed_price',
    ];

    public static function getCouponInfo($name){
        $coupon = self::where('name', $name)->first();
        if($coupon){
            if($coupon->limit == 0){
                return $coupon;
            }else{
                $orders_count = Order::where('coupon_id', $coupon->id)->get()->count();
                if($coupon->limit > $orders_count){
                    return $coupon;
                }else{
                    return 0;
                }
            }
        }else{
            return 0;
        }
    }
}

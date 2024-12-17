<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'product_id',
        'is_over',
        'is_over_count',
        'isActive',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}

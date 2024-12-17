<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity_id',
        'size_id',
        'price'
    ];

    public function quantity(){
        return $this->hasOne(Quantity::class, 'id', 'quantity_id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function size(){
        return $this->hasOne(Size::class, 'id', 'size_id');
    }

}

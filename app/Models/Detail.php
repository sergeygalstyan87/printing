<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity_id',
        'type_id',
        'order',
        'quantity_order',
        'price'
    ];

    public function quantity(){
        return $this->hasOne(Quantity::class, 'id', 'quantity_id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function type(){
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

}

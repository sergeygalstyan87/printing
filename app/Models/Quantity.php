<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    use HasFactory;

    protected $fillable = ['number'];

    public function product_shipping(){
        return $this->belongsToMany(Product::class, 'product_quantity_shipping', 'quantity_id', 'product_id')->withPivot('price');
    }

}

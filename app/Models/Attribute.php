<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name','is_crude', 'notes', 'description', 'help_text','is_apparel', 'is_multiple', 'attribute_properties'];

    protected $casts = [
        'attribute_properties' => 'array'
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_id', 'product_id');
    }

}

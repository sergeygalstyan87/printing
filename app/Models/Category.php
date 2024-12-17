<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'parent',
        'design_price'
    ];

    public function products(){
        return $this->hasMany(Product::class, 'category_id', 'id')->orderBy('products.order','ASC');
    }

    public function subproducts(){
        return $this->hasMany(Product::class, 'subcategory_id', 'id')
            ->where('stock', 1)
            ->orderBy('order', 'ASC');
    }

    public function parents(){
        return $this->belongsTo(Category::class, 'parent');
    }

    public function childs(){
        return $this->hasMany(Category::class, 'parent', 'id');
    }

    public function menu_products(){
        return $this->belongsToMany(Product::class, 'category_products', 'category_id', 'product_id')->orderBy('products.order','ASC');
    }

    public function sliders()
    {
        return $this->hasMany(Slider::class, 'page_category_id');
    }

}

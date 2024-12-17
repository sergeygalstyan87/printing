<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_title',
        'product_id',
        'type',
        'qty',
        'quantity_id',
        'amount',
        'original_amount',
        'attrs',
        'delivery_id',
        'raw_attrs'
    ];

    protected $casts = [
        'attrs' => 'array',
        'raw_attrs' => 'array',
    ];

    public function sets()
    {
        return $this->hasMany(Set::class);
    }

    public function product()
    {
        return  $this->belongsTo(Product::class);
    }
    public function quantity()
    {
        return  $this->belongsTo(Quantity::class);
    }
    public function delivery()
    {
        return  $this->belongsTo(Delivery::class);
    }

    public function basket()
    {
        return $this->belongsToMany(Basket::class, 'basket_projects');
    }
}

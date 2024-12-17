<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    public $full_paper_info;

    protected $fillable = [
        'name',
        'attribute_id',
        'price_keys',
        'price',
        'full_paper',
        'related_attributes',
        'size_id',
        'both_sides',
        'type_details',
        'img',
        'uploadedFileTypeIds',
        'color_hex'
    ];

    protected $casts = [
        'type_details' => 'array',
        'uploadedFileTypeIds' => 'array',
    ];

    public function attribute(){
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_attributes', 'type_id', 'order_id');
    }

    public function productImagesByType()
    {
        return $this->hasMany(ProductImagesByType::class);
    }

    public function getFullPaperInfo(){
        if(!empty($this->price_keys)){
            return json_decode($this->price_keys,true);
        }else{
             return [];
        }
    }

    public function hasRelatedAttrs(){
        $result = [];
        if(!empty($this->related_attributes)){
            $result = json_decode($this->related_attributes,true);
        }
        return $result;
    }

}

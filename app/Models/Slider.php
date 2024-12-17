<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'title_color',
        'big_title',
        'big_title_color',
        'description',
        'description_color',
        'button_color',
        'button_text',
        'button_text_color',
        'button_url',
        'mobile_image',
        'tablet_image',
        'page_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'page_category_id');
    }
}

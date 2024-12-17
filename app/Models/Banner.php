<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
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
        'button_text',
        'button_text_color',
        'button_url',
        'mobile_image',
        'tablet_image',
    ];
}

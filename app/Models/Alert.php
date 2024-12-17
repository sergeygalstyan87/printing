<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_color',
        'background_color',
        'background_color_end',
        'secondary_text',
        'secondary_text_link',
        'is_bold',
    ];
}

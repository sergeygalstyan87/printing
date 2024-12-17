<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketProject extends Model
{
    use HasFactory;

    protected $table = 'basket_projects';

    protected $fillable = [
        'project_id',
        'basket_id',
    ];

    public $timestamps = true;
}

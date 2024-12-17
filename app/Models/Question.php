<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'product_id',
        'is_answered',
        'answer',
        'order_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

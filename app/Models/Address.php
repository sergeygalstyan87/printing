<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
        'address',
        'unit',
        'city',
        'state',
        'zip',
        'default'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

}

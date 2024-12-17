<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFileType extends Model
{
    use HasFactory;

    protected $fillable = [
      'title'
    ];

    public function productImagesByType()
    {
        return $this->hasMany(ProductImagesByType::class, 'uploaded_file_types_id');
    }
}

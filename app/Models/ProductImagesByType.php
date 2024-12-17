<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImagesByType extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type_id',
        'uploaded_file_types_id',
        'image',
        'width',
        'height',
        'top',
        'left',
    ];

    protected static function booted()
    {
        static::deleting(function ($productImage) {
            if ($productImage->image && Storage::disk('product_images_by_type')->exists($productImage->image)) {
                Storage::disk('product_images_by_type')->delete($productImage->image);
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function uploadedFileType()
    {
        return $this->belongsTo(UploadedFileType::class, 'uploaded_file_types_id', 'id');
    }
}

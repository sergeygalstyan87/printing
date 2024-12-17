<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'set_title',
        'uploaded_files',
        'project_id'
    ];

    protected $casts = [
        'uploaded_files' => 'array'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

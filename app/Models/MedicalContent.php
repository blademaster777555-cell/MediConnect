<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalContent extends Model
{
    use HasFactory;

    protected $table = 'medical_content';

    protected $fillable = [
        'title',
        'category',
        'content',
        'author_id',
        'published_date',
        'image',
    ];

    protected $casts = [
        'published_date' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}

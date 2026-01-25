<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    // Cho phép nhập tên, mô tả và hình ảnh
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    // Một chuyên khoa thì có nhiều Bác sĩ
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}

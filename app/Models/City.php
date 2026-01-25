<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // "Giấy phép" cho phép nhập dữ liệu vào cột 'name'
    protected $fillable = [
        'name',
    ];

    // Khai báo mối quan hệ: Một thành phố có nhiều User
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

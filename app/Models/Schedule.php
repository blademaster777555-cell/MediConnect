<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',      // ID của bác sĩ
        'available_date', // Ngày
        'start_time',     // Giờ bắt đầu
        'end_time',       // Giờ kết thúc
        'status',         // Trạng thái (active/inactive)
    ];

    // Một lịch rảnh thì thuộc về một Bác sĩ cụ thể
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
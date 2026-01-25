<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'appointment_id',
        'user_id',
        'doctor_id',
        'rating',
        'comment',
    ];

    // Quan hệ với Appointment (lịch hẹn liên quan)
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Quan hệ với User (người đánh giá)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Doctor (người được đánh giá)
    public function doctorProfile()
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_id');
    }
}
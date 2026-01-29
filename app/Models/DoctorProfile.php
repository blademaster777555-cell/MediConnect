<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    use HasFactory;

    // Khai báo tên bảng chính xác (khớp với migration bạn đã sửa)
    protected $table = 'doctor_profiles'; 

    protected $fillable = [
        'user_id', 
        'specialization_id', 
        'city_id', 
        'bio', 
        'phone', 
        'license_number', 
        'consultation_fee',
        'is_approved',
        'certificate',
        'rejection_reason'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'certificate' => 'array',
    ];

    // Quan hệ với User (1 DoctorProfile thuộc về 1 User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Chuyên khoa
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    
    // Quan hệ với Thành phố (nếu có)
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Quan hệ với Lịch hẹn (Doctor có nhiều Appointment)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id'); // 'doctor_id' là khóa ngoại trong bảng appointments
    }
    
    // Quan hệ với Lịch rảnh
    public function availabilities()
    {
        return $this->hasMany(DoctorAvailability::class, 'doctor_id');
    }

    public function feedbacks()
    {
        // Sử dụng hasManyThrough để đi xuyên qua bảng Appointments lấy Feedback
        return $this->hasManyThrough(
            Feedback::class,      // Model đích (Feedback)
            Appointment::class,   // Model trung gian (Lịch hẹn)
            'doctor_id',          // Khóa ngoại trên bảng appointments
            'appointment_id',     // Khóa ngoại trên bảng feedbacks
            'id',                 // Khóa chính của doctor_profiles
            'id'                  // Khóa chính của appointments
        );
    }

    // 2. Nếu trong View bạn dùng từ 'reviews' thay vì 'feedbacks'
    // Thì thêm hàm này để nó trỏ về hàm feedbacks ở trên
    public function reviews()
    {
        return $this->feedbacks();
    }
}
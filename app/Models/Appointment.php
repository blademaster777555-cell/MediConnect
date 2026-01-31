<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Tên bảng (nếu cần thiết, mặc định Laravel tự hiểu là appointments)
    protected $table = 'appointments';

    // DANH SÁCH CÁC CỘT ĐƯỢC PHÉP LƯU (Quan trọng!)
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'date',
        'time',
        'status',
        'patient_note',
        'fee',
        'payment_status',
        'cancellation_reason',
    ];

    // --- CÁC MỐI QUAN HỆ (RELATIONSHIPS) ---

    // 1. Lịch hẹn thuộc về 1 Bác sĩ
    public function doctorProfile()
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_id');
    }

    // 2. Lịch hẹn thuộc về 1 Bệnh nhân
    public function patientProfile()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
    
    // Helper lấy tên bệnh nhân cho tiện
    public function getPatientNameAttribute()
    {
        return $this->patientProfile && $this->patientProfile->user 
            ? $this->patientProfile->user->name 
            : 'Unknown Patient';
    }

    // 3. Lịch hẹn có 1 Đánh giá
    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
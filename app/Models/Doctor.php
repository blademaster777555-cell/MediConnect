<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;
use App\Models\DoctorAvailability;

class Doctor extends Model
{
    protected $fillable = ['user_id', 'full_name', 'specialization_id', 'city_id', 'qualification', 'phone', 'bio'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function schedules() {
        return $this->hasMany(Schedule::class);
    }
    
    public function specialization() {
        return $this->belongsTo(Specialization::class);
    }

    public function availabilities()
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

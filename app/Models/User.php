<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_DOCTOR = 'doctor';
    const ROLE_PATIENT = 'patient';

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'status', 'image', 'phone', 'address', 'city_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function doctorProfile() {
        return $this->hasOne(DoctorProfile::class);
    }

    public function patientProfile() {
        return $this->hasOne(PatientProfile::class);
    }

    // Helper to get role-specific profile
    public function getProfileAttribute()
    {
        if ($this->role === self::ROLE_DOCTOR) {
            return $this->doctorProfile;
        }
        if ($this->role === self::ROLE_PATIENT) {
            return $this->patientProfile;
        }
        return null;
    }



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'status' => 'string',
        ];
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

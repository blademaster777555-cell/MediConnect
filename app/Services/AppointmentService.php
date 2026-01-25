<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentService
{
    /**
     * Create a new appointment and ensure patient profile existence.
     */
    public function createForUser(User $user, array $data)
    {
        // Ensure patient profile exists
        $patientProfile = $user->patientProfile ?: PatientProfile::create(['user_id' => $user->id]);

        // Get Doctor Fee
        $doctor = \App\Models\DoctorProfile::findOrFail($data['doctor_id']);
        $fee = $doctor->consultation_fee ?? 0;

        return Appointment::create([
            'patient_id' => $patientProfile->id,
            'doctor_id' => $data['doctor_id'],
            'date' => $data['date'],
            'time' => $data['time'],
            'patient_note' => $data['patient_note'] ?? null,
            'status' => 'pending',
            'fee' => $fee,
            'payment_status' => 'paid', // Simulate immediate payment
        ]);
    }

    /**
     * Get upcoming appointments for a patient.
     */
    public function getUpcomingForPatient(PatientProfile $profile, $limit = 5)
    {
        return $profile->appointments()
            ->where('date', '>=', Carbon::now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['doctorProfile.user', 'doctorProfile.specialization'])
            ->orderBy('date')
            ->orderBy('time')
            ->limit($limit)
            ->get();
    }

    /**
     * Cancel an appointment.
     * @param bool $refund If true, money is returned. If false, money is forfeited (patient cancel).
     */
    public function cancel(Appointment $appointment, bool $refund = false)
    {
        $paymentStatus = $refund ? 'refunded' : 'forfeited';
        
        // If appointment was already unpaid or something, keep logic simple:
        // For now assume all valid bookings are 'paid'.
        
        $appointment->update([
            'status' => 'cancelled',
            'payment_status' => $paymentStatus
        ]);
        
        return $appointment;
    }
}

<?php

namespace App\Services;

use App\Models\User;
use App\Models\Appointment;
use App\Models\PatientProfile;
use App\Models\DoctorProfile;
use Illuminate\Support\Collection;

class DashboardService
{
    /**
     * Get statistics and appointments based on user role.
     */
    public function getDashboardData(User $user): array
    {
        $data = [
            'stats' => $this->getStats($user),
            'upcomingAppointments' => collect(),
            'recentAppointments' => collect(),
        ];

        if ($user->role === User::ROLE_PATIENT) {
            $profile = $user->patientProfile ?: PatientProfile::create(['user_id' => $user->id]);
            $data['upcomingAppointments'] = $this->getUpcomingAppointments($profile);
            $data['recentAppointments'] = $this->getRecentAppointments($profile);
        } elseif ($user->role === User::ROLE_DOCTOR && $user->doctorProfile) {
            $data['upcomingAppointments'] = $this->getUpcomingAppointments($user->doctorProfile);
            $data['recentAppointments'] = $this->getRecentAppointments($user->doctorProfile);
        }

        return $data;
    }

    private function getStats(User $user): array
    {
        $query = match(true) {
            $user->role === User::ROLE_ADMIN => Appointment::query(),
            $user->role === User::ROLE_DOCTOR && $user->doctorProfile => $user->doctorProfile->appointments(),
            $user->role === User::ROLE_PATIENT && $user->patientProfile => $user->patientProfile->appointments(),
            default => null,
        };

        if (!$query) {
            return $this->emptyStats();
        }

        return [
            'total_appointments' => (clone $query)->count(),
            'confirmed_appointments' => (clone $query)->where('status', 'confirmed')->count(),
            'pending_appointments' => (clone $query)->where('status', 'pending')->count(),
            'completed_appointments' => (clone $query)->where('status', 'completed')->count(),
            'cancelled_appointments' => (clone $query)->where('status', 'cancelled')->count(),
        ];
    }

    private function getUpcomingAppointments($profile): Collection
    {
        return $profile->appointments()
            ->where('date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with($profile instanceof PatientProfile ? ['doctorProfile.user', 'doctorProfile.specialization'] : ['patientProfile.user'])
            ->orderBy('date')
            ->limit(3)
            ->get();
    }

    private function getRecentAppointments($profile): Collection
    {
        return $profile->appointments()
            ->where(function($q) {
                $q->where('date', '<', now()->toDateString())
                  ->orWhereIn('status', ['completed', 'cancelled']);
            })
            ->with($profile instanceof PatientProfile ? ['doctorProfile.user'] : ['patientProfile.user'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->limit(5)
            ->get();
    }

    private function emptyStats(): array
    {
        return [
            'total_appointments' => 0,
            'confirmed_appointments' => 0,
            'pending_appointments' => 0,
            'completed_appointments' => 0,
            'cancelled_appointments' => 0,
        ];
    }
}

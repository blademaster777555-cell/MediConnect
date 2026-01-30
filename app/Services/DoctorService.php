<?php

namespace App\Services;

use App\Models\DoctorProfile;
use App\Models\City;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Builder;

class DoctorService
{
    /**
     * Search doctors with filters and eager loading.
     */
    public function search(array $filters = [])
    {
        $query = DoctorProfile::query()
            ->with(['user.city', 'specialization'])
            // Join users to allow filtering by city_id on user model
            ->join('users', 'doctor_profiles.user_id', '=', 'users.id')
            ->where('doctor_profiles.is_approved', true)
            ->select('doctor_profiles.*');

        if (!empty($filters['city_id'])) {
            $query->where('users.city_id', $filters['city_id']);
        }

        if (!empty($filters['specialization_id'])) {
            $query->where('doctor_profiles.specialization_id', $filters['specialization_id']);
        }

        if (!empty($filters['near_me_city_id'])) {
            $query->where('users.city_id', $filters['near_me_city_id']);
        }

        return $query->get();
    }

    /**
     * Get lookup data for search filters.
     */
    public function getSearchLookupData(): array
    {
        return [
            'cities' => City::orderBy('name')->get(),
            'specializations' => Specialization::orderBy('name')->get(),
        ];
    }

    /**
     * Update doctor profile and user info
     */
    public function updateProfile(\App\Models\User $user, array $data): void
    {
        // Update User info
        $userData = ['name' => $data['name']];
        
        // Handle avatar upload
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('avatars', 'public');
            $userData['image'] = $path; // Save relative path e.g avatars/filename.jpg
        }

        $user->update($userData);

        // Update Doctor Profile
        $updateData = [
            'phone' => $data['phone'],
            'specialization_id' => $data['specialization_id'],
            'city_id' => $data['city_id'],
            'bio' => $data['bio'] ?? null,
            'license_number' => $data['license_number'] ?? null,
            'consultation_fee' => $data['consultation_fee'] ?? null,
        ];

        // Handle certificate upload
        if (isset($data['certificate']) && $data['certificate'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['certificate']->store('certificates', 'public');
            $updateData['certificate'] = $path;
        }

        $user->doctorProfile->update($updateData);
    }
}

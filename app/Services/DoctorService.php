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
            ->with(['user.city', 'city', 'specialization'])
            // Join users to allow filtering by city_id on user model
            ->join('users', 'doctor_profiles.user_id', '=', 'users.id')
            ->where('doctor_profiles.is_approved', true)
            ->select('doctor_profiles.*');

        if (!empty($filters['city_id'])) {
            $query->where('doctor_profiles.city_id', $filters['city_id']);
        }

        if (!empty($filters['specialization_id'])) {
            $query->where('doctor_profiles.specialization_id', $filters['specialization_id']);
        }

        if (!empty($filters['near_me_city_id'])) {
            $query->where('doctor_profiles.city_id', $filters['near_me_city_id']);
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
        // Handle certificate upload (support multiple)
        if (isset($data['certificate'])) {
            $certs = is_array($data['certificate']) ? $data['certificate'] : [$data['certificate']];
            $newCerts = [];

            foreach ($certs as $cert) {
                if ($cert instanceof \Illuminate\Http\UploadedFile) {
                    $path = $cert->store('certificates', 'public');
                    $newCerts[] = ['path' => $path, 'status' => 'pending'];
                }
            }

            if (!empty($newCerts)) {
                // Get existing certificates
                $existingCerts = $user->doctorProfile->certificate ?? [];
                
                // Decode if string (legacy compatibility)
                if (is_string($existingCerts)) {
                    $existingCerts = json_decode($existingCerts, true) ?? [];
                }
                
                // Ensure array
                if (!is_array($existingCerts)) {
                    $existingCerts = $existingCerts ? [$existingCerts] : [];
                }

                // Normalize existing legacy strings to objects if needed
                $normalizedExisting = [];
                foreach ($existingCerts as $cert) {
                    if (is_string($cert)) {
                        $normalizedExisting[] = ['path' => $cert, 'status' => 'approved']; // Assume legacy are approved or pending? Safe to say pending if unsure, but user said "approved ones show approved".
                    } else {
                        $normalizedExisting[] = $cert;
                    }
                }
                
                // Merge new paths with existing ones
                $updateData['certificate'] = array_merge($normalizedExisting, $newCerts);
                
                // Reset approval status when certificate updates
                $updateData['is_approved'] = false;
            }
        }

        // Always reset approval status on any update
        $updateData['is_approved'] = false;
        $updateData['rejection_reason'] = null;

        $user->doctorProfile->update($updateData);
    }
}

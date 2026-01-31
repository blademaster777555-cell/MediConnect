<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfileUpdated;
use App\Models\User;

class DoctorController extends Controller
{
    /**
     * Helper to safely get doctor profile
     */
    private function getDoctorProfile()
    {
        $user = Auth::user();
        if (!$user->doctorProfile) {
            return $user->doctorProfile()->create([
                'specialization_id' => null,
                'city_id' => $user->city_id, // Inherit from user
                'phone' => $user->phone ?? '',
                'bio' => __('Bio not updated'),
            ]);
        }
        return $user->doctorProfile;
    }

    /**
     * Doctor dashboard
     */
    public function dashboard()
    {
        $doctor = $this->getDoctorProfile();
        
        $stats = [
            'total_appointments' => Appointment::where('doctor_id', $doctor->id)->count(),
            'pending_appointments' => Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
            'completed_appointments' => Appointment::where('doctor_id', $doctor->id)->where('status', 'completed')->count(),
            'today_appointments' => Appointment::where('doctor_id', $doctor->id)->where('date', date('Y-m-d'))->count(),
        ];

        $upcoming = Appointment::where('doctor_id', $doctor->id)
            ->where('date', '>=', date('Y-m-d'))
            ->whereIn('status', ['confirmed', 'pending'])
            ->with('patientProfile.user')
            ->orderBy('date')
            ->orderBy('time')
            ->limit(5)
            ->get();

        return view('doctor.dashboard', compact('stats', 'upcoming'));
    }

    /**
     * Manage doctor's availability schedule
     */
    /**
     * Manage doctor's availability schedule
     */
    public function schedule()
    {
        $doctor = $this->getDoctorProfile();
        
        // Generate next 7 days
        $days = [];
        $startDate = \Carbon\Carbon::tomorrow();
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $days[$date->format('Y-m-d')] = $date->isoFormat('dddd (DD/MM)');
        }

        // Generate Time Slots (07:00 - 21:00, 30 mins interval)
        $timeSlots = [];
        $start = \Carbon\Carbon::createFromTime(7, 0);
        $end = \Carbon\Carbon::createFromTime(21, 0);

        while ($start <= $end) {
            $val = $start->format('H:i');
            // Format labels based on locale
            if (app()->getLocale() == 'en') {
                $label = $start->format('h:i A'); // 07:00 AM
            } else {
                $label = $start->format('H:i'); // 07:00 (VN prefer 24h or SA/CH but 24h is cleaner for lists)
            }
            $timeSlots[$val] = $label;
            $start->addMinutes(30);
        }

        // Get availabilities for these dates
        $availabilities = DoctorAvailability::where('doctor_id', $doctor->id)
            ->whereIn('date', array_keys($days))
            ->get();
        
        return view('doctor.schedule', compact('availabilities', 'days', 'timeSlots'));
    }

    /**
     * Store doctor's availability schedule
     */
    public function storeSchedule(Request $request)
    {
        $doctor = $this->getDoctorProfile();

        $validated = $request->validate([
            'schedule' => 'required|array',
            'schedule.*.date' => 'required|date',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i',
            'schedule.*.is_available' => 'required|in:0,1',
        ]);

        $data = $request->input('schedule');
        
        // Manual validation for time range
        foreach ($data as $date => $row) {
            if ($row['start_time'] >= $row['end_time']) {
                return redirect()->back()->withErrors(['error' => __('End time must be after start time') . " ($date)"])->withInput();
            }
        }

        foreach ($validated['schedule'] as $date => $data) {
            DoctorAvailability::updateOrCreate(
                [
                    'doctor_id' => $doctor->id,
                    'date' => $data['date']
                ],
                [
                    'day_of_week' => \Carbon\Carbon::parse($data['date'])->format('D'), // Derived for backward compatibility
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'is_available' => $data['is_available']
                ]
            );
        }

        return redirect()->route('doctor.schedule')
            ->with('success', __('Weekly schedule has been updated successfully.'));
    }

    /**
     * View doctor's appointments
     */
    public function appointments()
    {
        $doctor = $this->getDoctorProfile();
        
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patientProfile.user'])
            ->latest()
            ->paginate(15);

        return view('doctor.appointments', compact('appointments'));
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, $id)
    {
        $doctor = $this->getDoctorProfile();
        
        $appointment = Appointment::where('doctor_id', $doctor->id)
            ->findOrFail($id);

        $rules = [
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ];

        if ($request->status == 'cancelled') {
            $rules['cancellation_reason'] = 'required|string|max:500';
        }

        $request->validate($rules);

        $updateData = ['status' => $request->status];
        
        if ($request->status == 'cancelled') {
            $updateData['cancellation_reason'] = $request->cancellation_reason;
            $updateData['payment_status'] = 'refunded';
        }

        if ($request->has('patient_note')) {
            $updateData['patient_note'] = $request->patient_note;
        }

        $appointment->update($updateData);

        // Notify Patient
        if ($appointment->patientProfile && $appointment->patientProfile->user) {
            $appointment->patientProfile->user->notify(new \App\Notifications\AppointmentNotification($appointment, 'status_update'));
        }

        return redirect()->back()->with('success', __('Appointment status updated successfully.'));
    }

    /**
     * View profile
     */
    protected $doctorService;

    public function __construct(\App\Services\DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * View profile
     */
    public function profile()
    {
        $doctor = $this->getDoctorProfile();
        $cities = \App\Models\City::orderBy('name')->get();
        $specializations = \App\Models\Specialization::orderBy('name')->get();

        return view('doctor.profile', compact('doctor', 'cities', 'specializations'));
    }

    /**
     * Update profile
     */
    public function updateProfile(\App\Http\Requests\Doctor\UpdateDoctorProfileRequest $request)
    {
        $this->getDoctorProfile(); // Ensure exists
        $this->doctorService->updateProfile(Auth::user(), $request->validated());

        // Notify Admins
        $admins = User::where('role', User::ROLE_ADMIN)->get();
        Notification::send($admins, new ProfileUpdated(Auth::user()));

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete certificate image
     */
    public function deleteCertificate(Request $request)
    {
        $doctor = $this->getDoctorProfile();
        $imagePath = $request->input('image');

        if (!$imagePath) {
             return redirect()->back()->withErrors(['error', __('Image not found to delete.')]);
        }

        $certs = $doctor->certificate ?? [];
        if (!is_array($certs)) {
             $certs = $certs ? [$certs] : [];
        }

        $normalizedInput = str_replace('\\', '/', $imagePath);
        $newCerts = [];
        $found = false;

        foreach ($certs as $cert) {
            $certPath = is_array($cert) ? ($cert['path'] ?? '') : $cert;
            $normalizedCert = str_replace('\\', '/', $certPath);
            
            // Delete only the first occurrence
            if (!$found && $normalizedCert === $normalizedInput) {
                $found = true;
                continue; 
            }
            
            $newCerts[] = $cert;
        }

        if ($found) {
            // If certificates remain, keep the current approval status.
            // If no certificates remain, force unapprove.
            $shouldKeepApproval = count($newCerts) > 0 && $doctor->is_approved;

            $doctor->update([
                'certificate' => array_values($newCerts),
                'is_approved' => $shouldKeepApproval ? true : false,
                'rejection_reason' => null
            ]);
            
            // Optional: Delete physical file
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()->with('success', __('Certificate deleted successfully.'));
        }

        return redirect()->back()->with('error', __('Certificate not found in your profile.'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\Appointment;
use App\Models\City; // Nhớ import City để dùng trong form thêm user
use App\Models\Specialization; // Import Specialization
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // 1. TRANG DASHBOARD (Thống kê)
    public function dashboard()
    {
        $stats = [
            'doctors' => User::where('role', User::ROLE_DOCTOR)->count(),
            'patients' => User::where('role', User::ROLE_PATIENT)->count(),
            'total_users' => User::count(),
            'appointments' => Appointment::where('status', 'cancelled')->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'confirmed_appointments' => Appointment::where('status', 'confirmed')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'today_appointments' => Appointment::whereDate('date', date('Y-m-d'))->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // 2. DANH SÁCH USER (Quản lý người dùng)
    // 2. DANH SÁCH USER (Quản lý người dùng)
    public function index()
    {
        // Show all users except Admin
        $users = User::where('role', '!=', User::ROLE_ADMIN)->latest()->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function doctors()
    {
        $users = User::where('role', User::ROLE_DOCTOR)->with('doctorProfile')->latest()->paginate(10);
        return view('admin.user.doctors', compact('users'));
    }

    public function patients()
    {
        $users = User::where('role', User::ROLE_PATIENT)->with('patientProfile')->latest()->paginate(10);
        return view('admin.user.patients', compact('users'));
    }

    public function approveDoctor($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== User::ROLE_DOCTOR) {
            return redirect()->back()->with('error', __('This account is not a doctor!'));
        }

        if ($user->doctorProfile) {
            $user->doctorProfile->update([
                'is_approved' => true,
                'rejection_reason' => null
            ]);
            
            // Notify Doctor
            $user->notify(new \App\Notifications\SystemNotification(
                __('Your doctor profile has been approved. You can now start using the platform.'),
                route('doctor.profile'),
                'profile_approved'
            ));

            return redirect()->back()->with('success', __('Doctor account approved') . ' ' . $user->name);
        }

        return redirect()->back()->with('error', __('This doctor has not updated their profile, cannot receive approval!'));
    }

    public function rejectDoctor(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== User::ROLE_DOCTOR) {
            return redirect()->back()->with('error', __('This account is not a doctor!'));
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        if ($user->doctorProfile) {
            // Update certificates: Mark all non-approved (pending) certificates as rejected
            $certs = $user->doctorProfile->certificate ?? [];
            if (is_string($certs)) {
                 $decoded = json_decode($certs, true);
                 $certs = is_array($decoded) ? $decoded : [$certs];
            } 
            if (!is_array($certs)) {
                 $certs = $certs ? [$certs] : [];
            }
    
            $updatedCerts = [];
            foreach ($certs as $cert) {
                // Normalize
                if (is_string($cert)) {
                    $cert = ['path' => $cert, 'status' => 'pending'];
                }
                
                // If already approved, keep it approved. Otherwise mark as rejected.
                if (($cert['status'] ?? 'pending') !== 'approved') {
                    $cert['status'] = 'rejected';
                }
                $updatedCerts[] = $cert;
            }

            $user->doctorProfile->update([
                'certificate' => $updatedCerts,
                'is_approved' => false,
                'rejection_reason' => $request->reason
            ]);

            // Notify Doctor
            $user->notify(new \App\Notifications\SystemNotification(
                __('Your doctor profile has been rejected. Reason: :reason', ['reason' => $request->reason]),
                route('doctor.profile'),
                'profile_rejected'
            ));

            return redirect()->back()->with('success', __('Doctor profile rejected. Reason sent.'));
        }

        return redirect()->back()->with('error', __('Profile not found!'));
    }

    public function approveCertificates(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== User::ROLE_DOCTOR) {
            return redirect()->back()->with('error', __('This account is not a doctor!'));
        }

        $request->validate([
            'selected_certificates' => 'required|array',
        ]);

        if ($user->doctorProfile) {
            $currentCerts = $user->doctorProfile->certificate ?? [];
            if (is_string($currentCerts)) {
                $currentCerts = json_decode($currentCerts, true) ?? [];
            }
            if (!is_array($currentCerts)) {
                $currentCerts = [$currentCerts];
            }

            // Normalize
            $normalizedCerts = [];
            foreach ($currentCerts as $cert) {
                if (is_string($cert)) {
                    $normalizedCerts[] = ['path' => $cert, 'status' => 'pending'];
                } else {
                    $normalizedCerts[] = $cert;
                }
            }

            $selectedPaths = $request->selected_certificates;
            $updatedCerts = [];
            $approvedCount = 0;

            foreach ($normalizedCerts as $cert) {
                // If this cert is in the selected list, mark it approved
                if (in_array($cert['path'], $selectedPaths)) {
                    $cert['status'] = 'approved';
                }
                
                // Count how many are approved total
                if (($cert['status'] ?? 'pending') === 'approved') {
                    $approvedCount++;
                }

                $updatedCerts[] = $cert;
            }

            // If at least one cert is approved, we can approve the profile?
            // Or only if ALL are approved?
            // User requirement: "Approve Selected". Likely means "If I approve *these*, accept the profile."
            
            $user->doctorProfile->update([
                'certificate' => $updatedCerts,
                'is_approved' => ($approvedCount > 0), // Approve profile if at least one cert is approved
                'rejection_reason' => null
            ]);

            return redirect()->back()->with('success', __('Selected certificates approved.'));
        }

        return redirect()->back()->with('error', __('Profile not found!'));
    }

    public function rejectCertificates(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== User::ROLE_DOCTOR) {
            return redirect()->back()->with('error', __('This account is not a doctor!'));
        }

        $request->validate([
            'selected_certificates' => 'required|array',
            'reason' => 'required|string',
        ]);

        if ($user->doctorProfile) {
            $currentCerts = $user->doctorProfile->certificate ?? [];
            if (is_string($currentCerts)) {
                $currentCerts = json_decode($currentCerts, true) ?? [];
            }
            if (!is_array($currentCerts)) {
                $currentCerts = [$currentCerts];
            }

            // Normalize
            $normalizedCerts = [];
            foreach ($currentCerts as $cert) {
                if (is_string($cert)) {
                    $normalizedCerts[] = ['path' => $cert, 'status' => 'pending'];
                } else {
                    $normalizedCerts[] = $cert;
                }
            }

            $selectedPaths = $request->selected_certificates;
            $updatedCerts = [];

            foreach ($normalizedCerts as $cert) {
                // If this cert is in the selected list, mark it rejected
                if (in_array($cert['path'], $selectedPaths)) {
                    $cert['status'] = 'rejected';
                }
                $updatedCerts[] = $cert;
            }

            $user->doctorProfile->update([
                'certificate' => $updatedCerts,
                // Do NOT unapprove the profile here? Or should we?
                // If all certs are rejected, maybe. But for now, just mark certs as rejected.
                // 'is_approved' => false, 
                // 'rejection_reason' => $request->reason // Keep global reason? Or per cert? This updates global.
            ]);

            return redirect()->back()->with('success', __('Selected certificates have been rejected.'));
        }

        return redirect()->back()->with('error', __('Profile not found!'));
    }

    // Manage Doctor Schedule (Admin)
    public function doctorSchedule($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== User::ROLE_DOCTOR) {
            return redirect()->back()->with('error', 'User is not a doctor');
        }

        $doctor = $user->doctorProfile;
        if (!$doctor) {
             $doctor = $user->doctorProfile()->create([
                'specialization_id' => null,
                'city_id' => $user->city_id,
                'phone' => $user->phone ?? '',
                'bio' => __('Bio not updated'),
            ]);
        }

        // Generate next 7 days
        $days = [];
        $startDate = \Carbon\Carbon::today();
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $days[$date->format('Y-m-d')] = $date->isoFormat('dddd (DD/MM)');
        }

        // Generate Time Slots
        $timeSlots = [];
        $start = \Carbon\Carbon::createFromTime(7, 0);
        $end = \Carbon\Carbon::createFromTime(21, 0);

        while ($start <= $end) {
            $val = $start->format('H:i');
            $label = $start->format('H:i'); 
            $timeSlots[$val] = $label;
            $start->addMinutes(30);
        }

        $availabilities = \App\Models\DoctorAvailability::where('doctor_id', $doctor->id)
            ->whereIn('date', array_keys($days))
            ->get();
        
        return view('admin.doctors.schedule', compact('doctor', 'user', 'availabilities', 'days', 'timeSlots'));
    }

    public function updateDoctorSchedule(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $doctor = $user->doctorProfile;

        $request->validate([
            'schedule' => 'required|array',
            'schedule.*.date' => 'required|date',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i',
            'schedule.*.is_available' => 'required|in:0,1',
        ]);

        $data = $request->input('schedule');
        
        foreach ($data as $date => $row) {
            if ($row['start_time'] >= $row['end_time']) {
                return redirect()->back()->withErrors(['error' => __('End time must be after start time') . " ($date)"])->withInput();
            }
        }

        foreach ($data as $date => $row) {
            \App\Models\DoctorAvailability::updateOrCreate(
                [
                    'doctor_id' => $doctor->id,
                    'date' => $row['date']
                ],
                [
                    'day_of_week' => \Carbon\Carbon::parse($row['date'])->format('D'),
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time'],
                    'is_available' => $row['is_available']
                ]
            );
        }

        return redirect()->back()->with('success', __('Work schedule updated successfully!'));
    }

    // 3. FORM THÊM USER MỚI
    public function create()
    {
        $cities = City::all(); // Lấy list thành phố để chọn
        $specializations = Specialization::all(); // Lấy list chuyên khoa
        return view('admin.user.create', compact('cities', 'specializations'));
    }

    // 4. LƯU USER MỚI VÀO DB
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:'.User::ROLE_ADMIN.','.User::ROLE_DOCTOR.','.User::ROLE_PATIENT,
            'specialization_id' => 'required_if:role,'.User::ROLE_DOCTOR,
            'city_id' => 'nullable', // Used in profile
            'phone' => 'nullable',
        ]);

        // Tạo user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa pass
            'role' => $request->role,
            'status' => User::STATUS_ACTIVE,
        ]);

        // Handle Profile Creation based on Role
        if ($request->role === User::ROLE_DOCTOR) {
            $user->doctorProfile()->create([
                'specialization_id' => $request->specialization_id,
                'city_id' => $request->city_id,
                'phone' => $request->phone,
                'bio' => __('Info not updated'),
                'full_name' => $request->name,
            ]);
        } elseif ($request->role === User::ROLE_PATIENT) {
            $user->patientProfile()->create([
                'phone' => $request->phone,
                // 'city_id' => $request->city_id, // Patient might not have city_id based on schema, checking...
                'address' => $request->address ?? __('Not updated'),
                'full_name' => $request->name,
            ]);
        }

        return redirect()->route('users.index')->with('success', __('User added successfully!'));
    }

    // 5. HIỂN THỊ CHI TIẾT USER (READ-ONLY)
    public function show($id)
    {
        $user = User::findOrFail($id);
        $cities = City::all();
        $specializations = Specialization::all();
        return view('admin.user.show', compact('user', 'cities', 'specializations'));
    }

    // 6. FORM CHỈNH SỬA USER (Original 5)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $cities = City::all();
        $specializations = Specialization::all();
        return view('admin.user.edit', compact('user', 'cities', 'specializations'));
    }

    // 6. CẬP NHẬT USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:'.User::ROLE_ADMIN.','.User::ROLE_DOCTOR.','.User::ROLE_PATIENT,
            'specialization_id' => 'required_if:role,'.User::ROLE_DOCTOR,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'city_id' => $request->city_id, // Save city to users table
        ];

        // Handle Avatar Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('avatars', 'public');
            $userData['image'] = $path;
        }

        // Cập nhật user basic info
        $user->update($userData);

        // Handle Profile Updates
        if ($request->role === User::ROLE_DOCTOR) {
            $user->doctorProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization_id' => $request->specialization_id,
                    'phone' => $request->phone,
                    'full_name' => $request->name,
                ]
            );
            // Ensure no patient profile exists? Or keep it?
            // For now, let's assume we don't aggressively delete the other profile to avoid data loss on accidental role switch
        } elseif ($request->role === User::ROLE_PATIENT) {
            $user->patientProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $request->phone,
                    'address' => $request->address ?? $user->patientProfile->address ?? '',
                    'full_name' => $request->name,
                ]
            );
        }

        return redirect()->route('users.index')->with('success', __('User updated successfully!'));
    }

    // 7. XÓA USER
    // 7. XÓA USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cleanup related data based on role
        if ($user->role === User::ROLE_DOCTOR) {
            if ($user->doctorProfile) {
                // Delete appointments where this doctor is assigned
                $appointments = \App\Models\Appointment::where('doctor_id', $user->doctorProfile->id)->get();
                foreach ($appointments as $appointment) {
                    // Delete feedbacks related to this appointment
                    \App\Models\Feedback::where('appointment_id', $appointment->id)->delete();
                    
                    // Delete medical records related to this appointment (if any)
                    \App\Models\MedicalRecord::where('appointment_id', $appointment->id)->delete();
                    
                    // Delete the appointment
                    $appointment->delete();
                }
                

                
                // Delete Doctor Profile
                $user->doctorProfile->delete();
            }
        } elseif ($user->role === User::ROLE_PATIENT) {
            if ($user->patientProfile) {
                 // Delete appointments where this patient is assigned
                 $appointments = \App\Models\Appointment::where('patient_id', $user->id)->get();
                 foreach ($appointments as $appointment) {
                     // Delete feedbacks related to this appointment
                     \App\Models\Feedback::where('appointment_id', $appointment->id)->delete();
                     
                     // Delete medical records related to this appointment
                     \App\Models\MedicalRecord::where('appointment_id', $appointment->id)->delete();
 
                     // Delete the appointment
                     $appointment->delete();
                 }
                $user->patientProfile->delete();
            }
        }

        // Final User Delete
        $user->delete();

        return redirect()->back()->with('success', __('User deleted successfully!'));
    }

    // 8. QUẢN LÝ LỊCH HẸN (Admin)
    public function appointments()
    {
        $appointments = Appointment::with(['patientProfile.user', 'doctorProfile.user', 'doctorProfile.specialization'])
                        ->latest()
                        ->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    // 9. FORM CHỈNH SỬA LỊCH HẸN (Admin)
    public function editAppointment($id)
    {
        $appointment = Appointment::with(['patientProfile.user', 'doctorProfile.user', 'doctorProfile.specialization'])->findOrFail($id);
        $doctors = DoctorProfile::with(['user', 'specialization'])->get();
        // Fix: Use correct role constant and eager load profile
        $patients = \App\Models\PatientProfile::with('user')->get();

        return view('admin.appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    // 10. CẬP NHẬT LỊCH HẸN (Admin)
    public function updateAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'patient_note' => 'nullable|string|max:1000',
        ]);

        // Find PatientProfile from User ID
        $user = User::with('patientProfile')->findOrFail($request->user_id);
        $patientProfile = $user->patientProfile;
        
        if (!$patientProfile) {
             // Fallback: create empty profile if missing? or error.
             // For now assume profile exists or auto-create in a robust system.
             // Let's try to get ID or fail.
             return redirect()->back()->with('error', __('This user does not have a patient profile!'));
        }

        // Kiểm tra trùng lịch
        $exists = Appointment::where('doctor_id', $request->doctor_id)
                    ->where('date', $request->date)
                    ->where('time', $request->time)
                    ->where('status', '!=', 'cancelled')
                    ->where('id', '!=', $id)
                    ->exists();

        if ($exists) {
            return redirect()->back()->with('error', __('This time slot is already booked!'));
        }

        $appointment->update([
            'patient_id' => $patientProfile->id, // Use patient_id, not user_id
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
            'patient_note' => $request->patient_note,
        ]);

        // Admin Cancel -> Refund logic
        if ($request->status == 'cancelled') {
            $appointment->update(['payment_status' => 'refunded']);
        }

        return redirect()->route('admin.appointments')->with('success', __('Appointment updated successfully!'));
    }

    // 11. XÓA LỊCH HẸN (Admin)
    public function destroyAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments')->with('success', __('Appointment deleted successfully!'));
    }
}
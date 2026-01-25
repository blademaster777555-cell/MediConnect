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
            'appointments' => Appointment::count(),
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
            return redirect()->back()->with('error', __('Tài khoản này không phải là bác sĩ!'));
        }

        if ($user->doctorProfile) {
            $user->doctorProfile->update(['is_approved' => true]);
            return redirect()->back()->with('success', __('Đã duyệt tài khoản bác sĩ') . ' ' . $user->name);
        }

        return redirect()->back()->with('error', __('Bác sĩ này chưa cập nhật hồ sơ, không thể duyệt!'));
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
                'bio' => 'Chưa cập nhật tiểu sử',
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
                return redirect()->back()->withErrors(['error' => __('Giờ kết thúc phải sau giờ bắt đầu') . " ($date)"])->withInput();
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

        return redirect()->back()->with('success', __('Cập nhật lịch làm việc thành công!'));
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
                'bio' => 'Chưa cập nhật thông tin',
                'full_name' => $request->name,
            ]);
        } elseif ($request->role === User::ROLE_PATIENT) {
            $user->patientProfile()->create([
                'phone' => $request->phone,
                // 'city_id' => $request->city_id, // Patient might not have city_id based on schema, checking...
                'address' => $request->address ?? 'Chưa cập nhật',
                'full_name' => $request->name,
            ]);
        }

        return redirect()->route('users.index')->with('success', __('Thêm người dùng thành công!'));
    }

    // 5. FORM CHỈNH SỬA USER
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

        return redirect()->route('users.index')->with('success', __('Cập nhật người dùng thành công!'));
    }

    // 7. XÓA USER
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index')->with('success', __('Đã xóa người dùng!'));
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
             return redirect()->back()->with('error', __('Người dùng này chưa có hồ sơ bệnh nhân!'));
        }

        // Kiểm tra trùng lịch
        $exists = Appointment::where('doctor_id', $request->doctor_id)
                    ->where('date', $request->date)
                    ->where('time', $request->time)
                    ->where('status', '!=', 'cancelled')
                    ->where('id', '!=', $id)
                    ->exists();

        if ($exists) {
            return redirect()->back()->with('error', __('Khung giờ này đã có người đặt!'));
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

        return redirect()->route('admin.appointments')->with('success', __('Cập nhật lịch hẹn thành công!'));
    }

    // 11. XÓA LỊCH HẸN (Admin)
    public function destroyAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments')->with('success', __('Xóa lịch hẹn thành công!'));
    }
}
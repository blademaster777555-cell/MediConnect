<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\PatientProfile; 
use App\Models\DoctorProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorAvailability;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Patient books an appointment
     */
    public function store(\App\Http\Requests\Appointment\StoreAppointmentRequest $request)
    {
        $appointment = $this->appointmentService->createForUser(Auth::user(), $request->validated());

        // Notify Admins
        $admins = \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN)->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\NewAppointmentCreated($appointment));
        }

        return redirect()->route('dashboard')->with('success', 'Đặt lịch thành công!');
    }

    /**
     * Patient cancels their appointment
     */
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();

        // Security check: Only the patient or admin can cancel
        if ($user->role !== \App\Models\User::ROLE_ADMIN && 
           (!$user->patientProfile || $appointment->patient_id !== $user->patientProfile->id)) {
            return redirect()->back()->with('error', 'Bạn không có quyền hủy lịch hẹn này!');
        }

        if (in_array(strtolower($appointment->status), ['completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Không thể hủy lịch hẹn đã hoàn thành hoặc đã hủy!');
        }

        // Patient cancel -> Forfeit fee (no refund)
        $this->appointmentService->cancel($appointment, false);

        return redirect()->back()->with('success', 'Đã hủy lịch hẹn thành công!');
    }

    /**
     * Admin views all appointments
     */
    public function index()
    {
        $appointments = Appointment::with(['patientProfile.user', 'doctorProfile.user', 'doctorProfile.specialization'])
            ->latest()
            ->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Admin form for creating new appointment
     */
    public function create()
    {
        $doctors = DoctorProfile::with(['user', 'specialization'])->get();
        $patients = PatientProfile::with('user')->get();

        return view('admin.appointments.create', compact('doctors', 'patients'));
    }

    /**
     * Admin stores new appointment
     */
    public function storeAdmin(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patient_profiles,id',
            'doctor_id' => 'required|exists:doctor_profiles,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'patient_note' => 'nullable|string|max:1000',
        ]);

        // Expert addition: Check for duplicates
        $exists = Appointment::where('doctor_id', $data['doctor_id'])
            ->where('date', $data['date'])
            ->where('time', $data['time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Khung giờ này đã có người đặt!');
        }

        Appointment::create(array_merge($data, ['status' => 'confirmed']));

        return redirect()->route('admin.appointments')->with('success', 'Tạo lịch hẹn thành công!');
    }

    public function edit($id)
    {
        $appointment = Appointment::with(['patientProfile.user', 'doctorProfile.user'])->findOrFail($id);
        $doctors = DoctorProfile::with(['user', 'specialization'])->get();
        $patients = PatientProfile::with('user')->get();

        return view('admin.appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = $request->validate([
            'patient_id' => 'required|exists:patient_profiles,id',
            'doctor_id' => 'required|exists:doctor_profiles,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'patient_note' => 'nullable|string|max:1000',
        ]);

        $appointment->update($data);

        return redirect()->route('admin.appointments')->with('success', 'Cập nhật lịch hẹn thành công!');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments')->with('success', 'Đã xóa lịch hẹn!');
    }

    /**
     * Patient views their own appointments
     */
    public function myAppointments(Request $request)
    {
        $user = Auth::user();
        $patient = $user->patientProfile ?: PatientProfile::create(['user_id' => $user->id]);

        $query = Appointment::with(['doctorProfile.user', 'doctorProfile.specialization'])
            ->where('patient_id', $patient->id);

        if ($request->get('filter') == 'upcoming') {
            $query->where('date', '>=', date('Y-m-d'))
                  ->whereIn('status', ['pending', 'confirmed']);
        } elseif ($request->get('filter') == 'history') {
             $query->where(function($q) {
                $q->where('date', '<', date('Y-m-d'))
                  ->orWhereIn('status', ['completed', 'cancelled']);
             });
        }

        $appointments = $query->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(15);

        return view('appointments.my_appointments', compact('appointments'));
    }
}
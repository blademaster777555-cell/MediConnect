<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    /**
     * Show form for creating medical record (Doctor only)
     */
    public function create(Appointment $appointment)
    {
        // Ensure the user is the doctor of the appointment
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        // Check if medical record already exists
        if ($appointment->medicalRecord) {
            return redirect()->back()->with('info', 'Medical record already exists for this appointment.');
        }

        return view('medical-records.create', compact('appointment'));
    }

    /**
     * Store medical record
     */
    public function store(Request $request)
    {
        $appointment = Appointment::findOrFail($request->appointment_id);

        // Ensure the user is the doctor
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:medical_records',
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'doctor_notes' => 'nullable|string',
        ]);

        MedicalRecord::create($validated);

        return redirect()->route('doctor.appointments')
            ->with('success', 'Medical record created successfully.');
    }

    /**
     * View medical record (Patient can view their own, Doctor can view theirs)
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $appointment = $medicalRecord->appointment;
        $user = Auth::user();

        // Check authorization
        if ($user->role === 'patient') {
            if ($appointment->patient_id !== $user->patient->id) {
                abort(403);
            }
        } elseif ($user->role === 'doctor') {
            if ($appointment->doctor_id !== $user->doctor->id) {
                abort(403);
            }
        } elseif ($user->role !== 'admin') {
            abort(403);
        }

        return view('medical-records.show', compact('medicalRecord', 'appointment'));
    }

    /**
     * Show form for editing medical record (Doctor only)
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        return view('medical-records.edit', compact('medicalRecord'));
    }

    /**
     * Update medical record
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'doctor_notes' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('doctor.appointments')
            ->with('success', 'Medical record updated successfully.');
    }

    /**
     * List all medical records (Admin/Doctor)
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'doctor') {
            $records = MedicalRecord::whereHas('appointment', function($q) {
                $q->where('doctor_id', Auth::user()->doctor->id);
            })->with('appointment')->paginate(20);
        } else {
            $records = MedicalRecord::with('appointment')->paginate(20);
        }

        return view('medical-records.index', compact('records'));
    }

    /**
     * Delete medical record (Doctor/Admin)
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->appointment->doctor_id !== Auth::user()->doctor->id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $medicalRecord->delete();

        return redirect()->back()
            ->with('success', 'Medical record deleted successfully.');
    }
}

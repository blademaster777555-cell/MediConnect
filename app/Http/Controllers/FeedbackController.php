<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Show the form for creating feedback for an appointment
     */
    public function create(Appointment $appointment)
    {
        // Ensure the user is the patient of the appointment
        if ($appointment->patient_id !== Auth::user()->patientProfile->id) {
            abort(403);
        }

        // Check if feedback already exists for this appointment
        if ($appointment->feedback) {
            return redirect()->back()->with('info', 'You have already submitted feedback for this appointment.');
        }

        // Check appointment is completed
        // Comparison is case-sensitive, ensure status is consistent
        if (strtolower($appointment->status) !== 'completed') {
            return redirect()->back()->with('error', 'You can only submit feedback for completed appointments.');
        }

        return view('feedback.create', compact('appointment'));
    }

    /**
     * Store feedback
     */
    public function store(Request $request)
    {
        $appointment = Appointment::findOrFail($request->appointment_id);

        // Ensure the user is the patient
        if ($appointment->patient_id !== Auth::user()->patientProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if feedback already exists
        if ($appointment->feedback) {
            return redirect()->back()->with('error', 'Feedback already exists for this appointment.');
        }

        $validated['user_id'] = Auth::id();
        $validated['doctor_id'] = $appointment->doctor_id;
        Feedback::create($validated);

        return redirect()->route('my.appointments')
            ->with('success', 'Thank you for your feedback!');
    }

    /**
     * Show all feedbacks (Admin view)
     */
    public function index()
    {
        $feedbacks = Feedback::with(['appointment', 'appointment.patientProfile', 'appointment.doctorProfile'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show feedback details
     */
    public function show(Feedback $feedback)
    {
        $feedback->load(['appointment', 'appointment.patientProfile', 'appointment.doctorProfile']);
        return view('admin.feedbacks.show', compact('feedback'));
    }

    /**
     * Delete feedback (Admin only)
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')
            ->with('success', 'Feedback deleted successfully.');
    }
}

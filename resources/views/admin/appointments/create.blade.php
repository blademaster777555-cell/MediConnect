@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Create New Appointment</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Patient</label>
                    <select name="patient_id" class="form-select" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }} ({{ $patient->phone }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Doctor</label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->user->name }} - {{ $doctor->specialization->name ?? 'General' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="appointment_date" class="form-control" required min="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Time</label>
                    <input type="time" name="appointment_time" class="form-control" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Symptoms / Notes</label>
                    <textarea name="symptoms" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-calendar-check"></i> Create Appointment
            </button>
            <a href="{{ route('admin.appointments') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
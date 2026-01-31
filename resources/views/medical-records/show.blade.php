@extends('layouts.modern')

@section('title', __('Medical Record') . ' - MediConnect')

@section('content')
<div class="container my-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold text-primary">
            <i class="bi bi-file-medical me-2"></i>{{ __('Medical Record Details') }}
        </h1>
        <a href="{{ route('my.appointments', ['filter' => 'history']) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ __('Back to History') }}
        </a>
    </div>

    <div class="row">
        <!-- Patient & Doctor Info -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Appointment Info') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">{{ __('Date & Time') }}</small>
                        <span class="fs-5 fw-bold">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</span>
                        <span class="badge bg-light text-primary border ms-2">{{ $appointment->time }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">{{ __('Doctor') }}</small>
                        <div class="d-flex align-items-center mt-1">
                             <img src="{{ $appointment->doctorProfile->user->image ? asset('storage/' . $appointment->doctorProfile->user->image) : 'https://ui-avatars.com/api/?name='.urlencode($appointment->doctorProfile->user->name) }}" class="rounded-circle me-2" width="40" height="40">
                             <div>
                                 <div class="fw-bold">{{ $appointment->doctorProfile->user->name }}</div>
                                 <small class="text-secondary">{{ $appointment->doctorProfile->specialization->name }}</small>
                             </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">{{ __('Patient') }}</small>
                        <div class="fw-bold">{{ $appointment->patientProfile->user->name }}</div>
                    </div>

                    <hr>
                    
                    <div>
                         <small class="text-muted d-block">{{ __('Patient Note') }}</small>
                         <p class="mb-0 text-muted fst-italic">
                             {{ $appointment->patient_note ?: __('No valid note provided') }}
                         </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Details -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-clipboard-pulse me-2"></i>{{ __('Diagnosis') }}</h5>
                </div>
                <div class="card-body">
                    <p class="fs-5">{{ $medicalRecord->diagnosis }}</p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-prescription2 me-2"></i>{{ __('Prescription') }}</h5>
                </div>
                <div class="card-body">
                    @if($medicalRecord->prescription)
                        <div class="p-3 bg-light rounded border">
                            {!! nl2br(e($medicalRecord->prescription)) !!}
                        </div>
                    @else
                        <span class="text-muted fst-italic">{{ __('No prescription provided') }}</span>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>{{ __('Doctor Notes') }}</h5>
                </div>
                <div class="card-body">
                    @if($medicalRecord->doctor_notes)
                        <p>{{ $medicalRecord->doctor_notes }}</p>
                    @else
                         <span class="text-muted fst-italic">{{ __('No additional notes') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

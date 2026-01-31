@extends('layouts.modern')

@section('title', 'Appointment History - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-6 fw-bold text-primary mb-3">
                <i class="bi bi-calendar-check me-3"></i>{{ __('My Appointments') }}
            </h1>
            <p class="text-muted">{{ __('Track and manage your medical appointments') }}</p>
        </div>
        <div class="col-md-4 text-md-end align-self-center">
            @if(isset($appointments) && $appointments->count() > 0)
                <a href="{{ route('doctors.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i>{{ __('Book Appointment') }}
                </a>
            @endif
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request('filter') != 'history' ? 'active fw-bold' : '' }}" href="{{ route('my.appointments', ['filter' => 'upcoming']) }}">
                <i class="bi bi-calendar-event me-2"></i>{{ __('Upcoming') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('filter') == 'history' ? 'active fw-bold' : '' }}" href="{{ route('my.appointments', ['filter' => 'history']) }}">
                <i class="bi bi-clock-history me-2"></i>{{ __('History') }}
            </a>
        </li>
    </ul>

    @if(session('success'))
        <div class="alert alert-success card-shadow border-0 border-start border-success border-4 mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card card-shadow">
        <div class="card-body p-0">
            @if(isset($appointments) && $appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="py-3 ps-4">{{ __('Time') }}</th>
                            <th class="py-3">{{ __('Doctor & Specialty') }}</th>
                            <th class="py-3">{{ __('Your Note') }}</th>
                            <th class="py-3 text-center">{{ __('Fee') }}</th>
                            <th class="py-3 text-center">{{ __('Payment') }}</th>
                            <th class="py-3 text-center">{{ __('Status') }}</th>
                            <th class="py-3 text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($appt->date)->format('d/m/Y') }}</div>
                                <div class="small text-primary fw-bold">{{ $appt->time }}</div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $appt->doctorProfile->user->name ?? 'N/A' }}</div>
                                <span class="badge bg-info text-dark">{{ $appt->doctorProfile->specialization->name ?? __('General') }}</span>
                            </td>
                            <td class="text-muted small">
                                {{ Str::limit($appt->patient_note, 50) ?: __('No note') }}
                            </td>
                            <td class="text-center fw-bold text-success">
                                {{ number_format($appt->fee, 2, '.', ',') }} USD
                            </td>
                            <td class="text-center">
                                @if($appt->payment_status == 'paid')
                                    <span class="badge bg-success">{{ __('Paid') }}</span>
                                @elseif($appt->payment_status == 'refunded')
                                    <span class="badge bg-primary">{{ __('Refunded') }}</span>
                                @elseif($appt->payment_status == 'forfeited')
                                    <span class="badge bg-danger">{{ __('Fee Forfeited') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('Pending Payment') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <x-appointment-status-badge :status="$appt->status" />
                                @if($appt->status == 'cancelled' && $appt->cancellation_reason)
                                    <div class="small text-danger mt-1 fst-italic">
                                        {{ $appt->cancellation_reason }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($appt->status == 'completed' || $appt->status == 'Completed')
                                    <div class="d-flex flex-column gap-2">
                                        @if($appt->medicalRecord)
                                            <a href="{{ route('medical-records.show', $appt->medicalRecord->id) }}" class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-file-medical-fill"></i> {{ __('Medical Record') }}
                                            </a>
                                        @endif
                                        
                                        @if($appt->feedback)
                                            <span class="badge bg-secondary py-2"><i class="bi bi-star-fill"></i> {{ __('Rated') }}</span>
                                        @else
                                            <a href="{{ route('feedback.create', $appt->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-star"></i> {{ __('Rate Service') }}
                                            </a>
                                        @endif
                                    </div>
                                @elseif(in_array($appt->status, ['pending', 'confirmed']))
                                    <form action="{{ route('appointment.cancel', $appt->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirmAction(event, '{{ __('Are you sure you want to cancel this appointment?') }}')">
                                            <i class="bi bi-x-circle"></i> {{ __('Cancel') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">
                        @if(request('filter') == 'history')
                            {{ __('No appointment history found.') }}
                        @else
                            {{ __('You have no upcoming appointments.') }}
                        @endif
                    </h5>
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>{{ __('Book Appointment Now') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
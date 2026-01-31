@extends('layouts.modern')

@section('title', __('Doctor Dashboard') . ' - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold text-primary mb-3">
                <i class="bi bi-speedometer2 me-3"></i>{{ __('Doctor Dashboard') }}
            </h1>
            <p class="text-muted">{{ __('Welcome') }}, {{ Auth::user()->name }}! {{ __('Manage your work') }}.</p>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar -->
        @include('partials.doctor-sidebar')

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Stats -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card card-shadow text-center h-100">
                        <div class="card-body">
                            <div class="display-4 text-primary mb-2">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <h4 class="fw-bold">{{ $stats['today_appointments'] }}</h4>
                            <p class="text-muted mb-0">{{ __('Today\'s Appointments') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card card-shadow text-center h-100">
                        <div class="card-body">
                            <div class="display-4 text-warning mb-2">
                                <i class="bi bi-clock"></i>
                            </div>
                            <h4 class="fw-bold">{{ $stats['pending_appointments'] }}</h4>
                            <p class="text-muted mb-0">{{ __('Pending Confirmation') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card card-shadow text-center h-100">
                        <div class="card-body">
                            <div class="display-4 text-success mb-2">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h4 class="fw-bold">{{ $stats['completed_appointments'] }}</h4>
                            <p class="text-muted mb-0">{{ __('Completed') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card card-shadow text-center h-100">
                        <div class="card-body">
                            <div class="display-4 text-danger mb-2">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <h4 class="fw-bold">{{ $stats['total_appointments'] }}</h4>
                            <p class="text-muted mb-0">{{ __('Cancelled') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="card card-shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>{{ __('Upcoming Appointments') }}</h5>
                </div>
                <div class="card-body">
                    @if($upcoming->count() > 0)
                        @foreach($upcoming as $appt)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <div class="fw-bold">{{ $appt->patientProfile->user->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($appt->date)->format('d/m/Y') }} - {{ $appt->time }}</small>
                            </div>
                            <span class="badge {{ $appt->status == 'confirmed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $appt->status == 'confirmed' ? __('Confirmed') : __('Pending') }}
                            </span>
                        </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('doctor.appointments') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>{{ __('View All') }}
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">{{ __('No upcoming appointments') }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
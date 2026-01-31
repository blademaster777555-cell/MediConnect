@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold mb-0">{{ __('System Overview') }}</h2>
        <span class="text-muted">{{ now()->translatedFormat('l, d/m/Y') }}</span>
    </div>

    <!-- User Statistics -->
    <h5 class="text-uppercase text-secondary fw-bold mb-3 fs-6 ls-1">{{ __('User Statistics') }}</h5>
    <div class="row g-4 mb-5">
        <!-- Doctors -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-2">{{ __('Doctors') }}</h6>
                        <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['doctors'] }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-user-md fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patients -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-2">{{ __('Patients') }}</h6>
                        <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['patients'] }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-user-injured fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-secondary">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-2">{{ __('Total Users') }}</h6>
                        <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-users fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Statistics -->
    <h5 class="text-uppercase text-secondary fw-bold mb-3 fs-6 ls-1">{{ __('Appointment Statistics') }}</h5>
    <div class="row g-4 mb-5">
        <!-- Confirmed -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-2">{{ __('Confirmed') }}</h6>
                        <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['confirmed_appointments'] }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-2">{{ __('Pending') }}</h6>
                        <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['pending_appointments'] }}</h2>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-clock fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-2">{{ __('Cancelled') }}</h6>
                        <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['appointments'] }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-ban fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <h4 class="mb-3 text-secondary border-bottom pb-2">{{ __('Quick Actions') }}</h4>
    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('admin.appointments') }}" class="card border-0 shadow-sm text-decoration-none h-100 hover-shadow transition">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-primary text-white p-3 rounded py-3 me-3">
                        <i class="fas fa-calendar-check fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">{{ __('Manage Appointments') }}</h5>
                        <p class="text-muted small mb-0">{{ __('View and manage patient appointments') }}</p>
                    </div>
                    <i class="fas fa-arrow-right ms-auto text-muted"></i>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('specializations.index') }}" class="card border-0 shadow-sm text-decoration-none h-100 hover-shadow transition">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-warning text-dark p-3 rounded py-3 me-3">
                        <i class="fas fa-stethoscope fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">{{ __('Manage Specializations') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Add and edit medical specializations') }}</p>
                    </div>
                    <i class="fas fa-arrow-right ms-auto text-muted"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition {
        transition: all .2s ease-in-out;
    }
</style>
@endsection
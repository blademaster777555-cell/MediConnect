@extends('layouts.admin')

@section('title', __('Appointment Management - Admin'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar-check me-2"></i>{{ __('Appointment Management') }}
            </h1>
            <p class="text-muted">{{ __('Manage all appointments in the system') }}</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ __('Total Appointments') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $appointments->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{ __('Confirmed') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('status', 'confirmed')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{ __('Pending Confirmation') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{ __('Today') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('date', date('Y-m-d'))->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Appointment List') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Patient') }}</th>
                            <th>{{ __('Doctor') }}</th>
                            <th>{{ __('Date Time') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Source') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>
                                <strong>{{ $appointment->patientProfile->user->name ?? 'Unknown' }}</strong><br>
                                <small class="text-muted">{{ $appointment->patientProfile->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <strong>{{ $appointment->doctorProfile->user->name ?? 'Unknown' }}</strong><br>
                                <small class="text-muted">{{ $appointment->doctorProfile->specialization->name ?? __('General') }}</small>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}<br>
                                <small class="text-muted">{{ $appointment->time }}</small>
                            </td>
                            <td>
                                @if($appointment->status == 'confirmed')
                                    <span class="badge bg-success">{{ __('Confirmed') }}</span>
                                @elseif($appointment->status == 'pending')
                                    <span class="badge bg-warning text-dark">{{ __('Pending Confirmation') }}</span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-info text-dark">{{ __('Completed') }}</span>
                                @else
                                    <span class="badge bg-danger mb-1">{{ __('Cancelled') }}</span>
                                    @if($appointment->cancellation_reason)
                                        <div class="small text-danger mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            {{ $appointment->cancellation_reason }}
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($appointment->booking_type == 'admin')
                                    <span class="badge bg-primary">{{ __('Admin') }}</span>
                                    @if($appointment->creator)
                                        <br><small class="text-muted">{{ $appointment->creator->name }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-light text-dark border">{{ __('Patient') }}</span>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
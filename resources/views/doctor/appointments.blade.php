@extends('layouts.modern')

@section('title', 'Appointment Management - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold text-primary mb-3">
                <i class="bi bi-calendar-event me-3"></i>{{ __('Appointment Management') }}
            </h1>
            <p class="text-muted">{{ __('View and update the status of patient appointments') }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar -->
        @include('partials.doctor-sidebar')

        <!-- Main Content -->
        <div class="col-lg-9">
            @if(session('success'))
                <div class="alert alert-success card-shadow border-0 border-start border-success border-4 mb-4">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card card-shadow">
                <div class="card-body p-0">
                    @if($appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="py-3 ps-4">{{ __('Time') }}</th>
                                    <th class="py-3">{{ __('Patient') }}</th>
                                    <th class="py-3">{{ __('Note') }}</th>
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
                                        <div class="fw-bold">{{ $appt->patientProfile->user->name ?? 'N/A' }}</div>
                                        <div class="small text-muted">{{ $appt->patientProfile->user->phone ?? __('No phone number') }}</div>
                                    </td>
                                    <td class="text-muted small">
                                        {{ Str::limit($appt->patient_note, 50) ?: __('No note') }}
                                    </td>
                                    <td class="text-center">
                                        @if($appt->status == 'pending')
                                            <span class="badge bg-warning text-dark border border-warning">{{ __('Pending') }}</span>
                                        @elseif($appt->status == 'confirmed')
                                            <span class="badge bg-success border border-success">{{ __('Confirmed') }}</span>
                                        @elseif($appt->status == 'cancelled')
                                            <span class="badge bg-danger border border-danger">{{ __('Cancelled') }}</span>
                                        @elseif($appt->status == 'completed')
                                            <span class="badge bg-primary border border-primary">{{ __('Completed') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $appt->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if($appt->status == 'pending')
                                                <form action="{{ route('doctor.appointment.status', $appt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="{{ __('Confirm') }}">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="{{ __('Cancel') }}"
                                                        data-bs-toggle="modal" data-bs-target="#cancelModal"
                                                        onclick="setCancelUrl('{{ route('doctor.appointment.status', $appt->id) }}')">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            @elseif($appt->status == 'confirmed')
                                                <form action="{{ route('doctor.appointment.status', $appt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="{{ __('Mark as Completed') }}">
                                                        <i class="bi bi-check2-all"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="{{ __('Cancel') }}"
                                                        data-bs-toggle="modal" data-bs-target="#cancelModal"
                                                        onclick="setCancelUrl('{{ route('doctor.appointment.status', $appt->id) }}')">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted mb-3">{{ __('No appointments found.') }}</h5>
                            <p class="text-muted">{{ __('Patients will book appointments with you here.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="cancelForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Confirm Cancellation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to cancel this appointment?') }}</p>
                    <input type="hidden" name="status" value="cancelled">
                    <div class="mb-3">
                        <label for="cancellation_reason" class="form-label">{{ __('Cancellation Reason') }} <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" required placeholder="{{ __('Enter cancellation reason...') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Cancel Appointment') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setCancelUrl(url) {
        document.getElementById('cancelForm').action = url;
    }
</script>
@endsection
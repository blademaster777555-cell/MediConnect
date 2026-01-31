@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ __('Feedback Details') }} #{{ $feedback->id }}</h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Rating Content') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h1 class="display-4 fw-bold text-warning">
                            {{ $feedback->rating }} <span class="fs-4 text-muted">/ 5</span>
                        </h1>
                        <div class="text-warning fs-4">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $feedback->rating)
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Comment:') }}</label>
                        <div class="p-3 bg-light rounded border">
                            {{ $feedback->comment ?? __('No comment') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">{{ __('Submitted at:') }} {{ $feedback->created_at->format('d/m/Y H:i') }}</small>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirmAction(event, '{{ __('Are you sure you want to delete this feedback?') }}')">
                                <i class="bi bi-trash me-2"></i>{{ __('Delete Feedback') }}
                            </button>
                        </form>
                        <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-secondary ms-2">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Related Information') }}</h6>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">{{ __('Patient') }}</h6>
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ $feedback->appointment->patientProfile->user->name }}" class="rounded-circle me-3" width="50">
                        <div>
                            <div>{{ $feedback->appointment->patientProfile->user->name }}</div>
                            <small class="text-muted">{{ $feedback->appointment->patientProfile->user->email }}</small>
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-bold">{{ __('Doctor') }}</h6>
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ $feedback->appointment->doctorProfile->user->name }}" class="rounded-circle me-3" width="50">
                        <div>
                            <div>{{ $feedback->appointment->doctorProfile->user->name }}</div>
                            <small class="text-muted">{{ $feedback->appointment->doctorProfile->specialization->name }}</small>
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-bold">{{ __('Appointment') }}</h6>
                    <p class="mb-1"><strong>ID:</strong> #{{ $feedback->appointment_id }}</p>
                    <p class="mb-1"><strong>{{ __('Date:') }}</strong> {{ \Carbon\Carbon::parse($feedback->appointment->date)->format('d/m/Y') }}</p>
                    <p class="mb-0"><strong>{{ __('Time:') }}</strong> {{ $feedback->appointment->time }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

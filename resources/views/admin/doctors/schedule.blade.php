@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-calendar-week me-2"></i>{{ __('Weekly Schedule Management: :name', ['name' => $user->name]) }}
        </h5>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-sm btn-light text-primary">
            <i class="bi bi-arrow-left me-1"></i> {{ __('Back to List') }}
        </a>
    </div>
    <div class="card-body">


        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 25%;">{{ __('Day') }}</th>
                        <th style="width: 40%;">{{ __('Time') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $date => $label)
                        @php
                            $availability = $availabilities->firstWhere('date', $date);
                        @endphp
                        <tr>
                            <td class="bg-light">
                                <span class="fw-bold text-dark">{{ $label }}</span>
                            </td>
                            <td>
                                @if($availability)
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-2 text-primary"></i>
                                        <span class="fs-5 fw-bold font-monospace">
                                            {{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">
                                        <i class="bi bi-dash-circle me-1"></i>{{ __('Not updated') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($availability)
                                    @if($availability->is_available)
                                        <span class="badge bg-success py-2 px-3">
                                            <i class="bi bi-check-circle me-1"></i>{{ __('Open') }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger py-2 px-3">
                                            <i class="bi bi-x-circle me-1"></i>{{ __('Closed (Off)') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary py-2 px-3">{{ __('N/A') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

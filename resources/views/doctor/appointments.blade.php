@extends('layouts.modern')

@section('title', 'Quản lý lịch hẹn - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold text-primary mb-3">
                <i class="bi bi-calendar-event me-3"></i>{{ __('Quản lý lịch hẹn') }}
            </h1>
            <p class="text-muted">{{ __('Xem và cập nhật trạng thái các lịch hẹn của bệnh nhân') }}</p>
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
                                    <th class="py-3 ps-4">{{ __('Thời gian') }}</th>
                                    <th class="py-3">{{ __('Bệnh nhân') }}</th>
                                    <th class="py-3">{{ __('Ghi chú') }}</th>
                                    <th class="py-3 text-center">{{ __('Trạng thái') }}</th>
                                    <th class="py-3 text-center">{{ __('Thao tác') }}</th>
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
                                        <div class="small text-muted">{{ $appt->patientProfile->user->phone ?? __('Chưa cập nhật SĐT') }}</div>
                                    </td>
                                    <td class="text-muted small">
                                        {{ Str::limit($appt->patient_note, 50) ?: __('Không có ghi chú') }}
                                    </td>
                                    <td class="text-center">
                                        @if($appt->status == 'pending')
                                            <span class="badge bg-warning text-dark border border-warning">{{ __('Chờ xác nhận') }}</span>
                                        @elseif($appt->status == 'confirmed')
                                            <span class="badge bg-success border border-success">{{ __('Đã đặt lịch') }}</span>
                                        @elseif($appt->status == 'cancelled')
                                            <span class="badge bg-danger border border-danger">{{ __('Đã hủy') }}</span>
                                        @elseif($appt->status == 'completed')
                                            <span class="badge bg-primary border border-primary">{{ __('Hoàn thành') }}</span>
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
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="{{ __('Xác nhận lịch hẹn') }}">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('doctor.appointment.status', $appt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Hủy lịch hẹn') }}">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @elseif($appt->status == 'confirmed')
                                                <form action="{{ route('doctor.appointment.status', $appt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="{{ __('Đánh dấu hoàn thành') }}">
                                                        <i class="bi bi-check2-all"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('doctor.appointment.status', $appt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Hủy lịch hẹn') }}">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
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
                            <h5 class="text-muted mb-3">{{ __('Chưa có lịch hẹn nào.') }}</h5>
                            <p class="text-muted">{{ __('Các bệnh nhân sẽ đặt lịch với bạn ở đây.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
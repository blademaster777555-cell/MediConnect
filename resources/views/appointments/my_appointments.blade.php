@extends('layouts.modern')

@section('title', 'Lịch sử khám bệnh - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold text-primary mb-3">
                <i class="bi bi-calendar-check me-3"></i>
                @if(request('filter') == 'upcoming')
                    {{ __('Lịch hẹn sắp tới') }}
                @elseif(request('filter') == 'history')
                    {{ __('Lịch sử khám bệnh') }}
                @else
                    {{ __('Lịch sử khám bệnh của tôi') }}
                @endif
            </h1>
            <p class="text-muted">{{ __('Theo dõi và quản lý các lịch hẹn khám bệnh') }}</p>
        </div>
    </div>

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
                            <th class="py-3 ps-4">{{ __('Thời gian') }}</th>
                            <th class="py-3">{{ __('Bác sĩ & Chuyên khoa') }}</th>
                            <th class="py-3">{{ __('Ghi chú của bạn') }}</th>
                            <th class="py-3 text-center">{{ __('Phí khám') }}</th>
                            <th class="py-3 text-center">{{ __('Thanh toán') }}</th>
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
                                <div class="fw-bold">{{ $appt->doctorProfile->user->name ?? 'N/A' }}</div>
                                <span class="badge bg-info text-dark">{{ $appt->doctorProfile->specialization->name ?? __('Tổng quát') }}</span>
                            </td>
                            <td class="text-muted small">
                                {{ Str::limit($appt->patient_note, 50) ?: __('Không có ghi chú') }}
                            </td>
                            <td class="text-center fw-bold text-success">
                                {{ number_format($appt->fee, 2, '.', ',') }} USD
                            </td>
                            <td class="text-center">
                                @if($appt->payment_status == 'paid')
                                    <span class="badge bg-success">{{ __('Đã thanh toán') }}</span>
                                @elseif($appt->payment_status == 'refunded')
                                    <span class="badge bg-primary">{{ __('Đã hoàn tiền') }}</span>
                                @elseif($appt->payment_status == 'forfeited')
                                    <span class="badge bg-danger">{{ __('Mất phí hủy') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('Chờ TT') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <x-appointment-status-badge :status="$appt->status" />
                            </td>
                            <td class="text-center">
                                @if($appt->status == 'completed' || $appt->status == 'Completed')
                                    @if($appt->feedback)
                                        <span class="badge bg-secondary"><i class="bi bi-star-fill"></i> {{ __('Đã đánh giá') }}</span>
                                    @else
                                        <a href="{{ route('feedback.create', $appt->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-star"></i> {{ __('Đánh giá') }}
                                        </a>
                                    @endif
                                @elseif(in_array($appt->status, ['pending', 'confirmed']))
                                    <form action="{{ route('appointment.cancel', $appt->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('{{ __('Bạn có chắc muốn hủy lịch hẹn này?') }}')">
                                            <i class="bi bi-x-circle"></i> {{ __('Hủy lịch') }}
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
                    <h5 class="text-muted mb-3">{{ __('Bạn chưa có lịch hẹn khám nào.') }}</h5>
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>{{ __('Đặt lịch khám ngay') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
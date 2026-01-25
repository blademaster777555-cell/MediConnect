@extends('layouts.modern')

@section('title', 'Dashboard - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold text-primary mb-3">
                <i class="bi bi-house-door me-3"></i>{{ __('Dashboard') }}
            </h1>
            <p class="text-muted">{{ __('Chào mừng, :name! Quản lý lịch hẹn và thông tin sức khỏe.', ['name' => Auth::user()->name]) }}</p>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-shadow text-center h-100">
                <div class="card-body">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h4 class="fw-bold">{{ $stats['total_appointments'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Tổng lịch hẹn') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-shadow text-center h-100">
                <div class="card-body">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="fw-bold">{{ $stats['confirmed_appointments'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Đã xác nhận') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-shadow text-center h-100">
                <div class="card-body">
                    <div class="display-4 text-info mb-2">
                        <i class="bi bi-check2-all"></i>
                    </div>
                    <h4 class="fw-bold">{{ $stats['completed_appointments'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Đã hoàn thành') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-shadow text-center h-100">
                <div class="card-body">
                    <div class="display-4 text-danger mb-2">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <h4 class="fw-bold">{{ $stats['cancelled_appointments'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Đã hủy') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->role === 'patient')
    <div class="row">
        <!-- Lịch hẹn sắp tới -->
        <div class="col-lg-6 mb-4">
            <div class="card card-shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-event me-2"></i>{{ __('Lịch hẹn sắp tới') }}
                    </h5>
                </div>
                <div class="card-body">
                    @if($upcomingAppointments->count() > 0)
                        @foreach($upcomingAppointments as $appointment)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div>
                                <div class="fw-bold">{{ $appointment->doctorProfile->user->name ?? 'BS. ' . ($appointment->doctorProfile->id ?? 'Unknown') }}</div>
                                <div class="text-muted small">
                                    <i class="bi bi-heart-pulse me-1"></i>{{ $appointment->doctorProfile->specialization->name ?? __('Đa khoa') }}
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($appointment->date)->format('m/d/Y') }} - {{ $appointment->time }}
                                </div>
                            </div>
                            <x-appointment-status-badge :status="$appointment->status" />
                        </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('my.appointments', ['filter' => 'upcoming']) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>{{ __('Xem tất cả') }}
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted fs-1 mb-3 d-block"></i>
                            <p class="text-muted">{{ __('Không có lịch hẹn sắp tới.') }}</p>
                            <a href="{{ route('doctors.index') }}" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i>{{ __('Đặt lịch ngay') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lịch sử đặt lịch -->
        <div class="col-lg-6 mb-4">
            <div class="card card-shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>{{ __('Lịch sử đặt lịch') }}
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentAppointments->count() > 0)
                        @foreach($recentAppointments as $appointment)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <div class="fw-bold small">{{ $appointment->doctorProfile->user->name ?? 'BS. ' . ($appointment->doctorProfile->id ?? 'Unknown') }}</div>
                                <div class="text-muted small">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('m/d/Y') }}
                                </div>
                            </div>
                            <x-appointment-status-badge :status="$appointment->status" />
                        </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('my.appointments', ['filter' => 'history']) }}" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-eye me-1"></i>{{ __('Xem tất cả') }}
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-journal-x text-muted fs-1 mb-3 d-block"></i>
                            <p class="text-muted">{{ __('Bạn chưa có lịch sử đặt lịch nào.') }}</p>
                            <a href="{{ route('doctors.index') }}" class="btn btn-info">
                                <i class="bi bi-search me-1"></i>{{ __('Bắt đầu đặt lịch') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card card-shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @if(Auth::user()->role === 'admin')
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-person-check fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Duyệt tài khoản Bác sĩ') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.appointments') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-calendar-check fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Quản lý tất cả Lịch hẹn') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('medical-content.index', ['category' => 'news']) }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-newspaper fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Quản lý Tin tức Y tế') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('medical-content.index', ['category' => 'disease']) }}" class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-heart-pulse fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Quản lý Bệnh phổ biến & Phòng ngừa') }}</span>
                                </a>
                            </div>
                        @elseif(Auth::user()->role === 'doctor')
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('doctor.schedule') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-calendar-week fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Lịch làm việc') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('doctor.appointments') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-calendar-check fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Quản lý lịch hẹn') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-person fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Cập nhật hồ sơ') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('news') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-newspaper fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Tin tức Y tế') }}</span>
                                </a>
                            </div>
                        @else
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('doctors.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-search fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Tìm Bác sĩ') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('my.appointments') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-calendar-check fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Lịch hẹn của tôi') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-person fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Cập nhật hồ sơ') }}</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('news') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="bi bi-newspaper fs-2 mb-2"></i>
                                    <span class="fw-bold">{{ __('Tin tức Y tế') }}</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

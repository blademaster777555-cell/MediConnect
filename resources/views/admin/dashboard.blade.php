@extends('layouts.admin')

@section('content')
<h2 class="mb-4">{{ __('Tổng quan hệ thống') }}</h2>

<!-- Thống kê người dùng -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Bác sĩ') }}</h5>
                <p class="card-text fs-2">{{ $stats['doctors'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Bệnh nhân') }}</h5>
                <p class="card-text fs-2">{{ $stats['patients'] }}</p>
            </div>
        </div>
    </div>
    <!-- Counselor widget removed -->
    <div class="col-md-3">
        <div class="card text-white bg-secondary mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Tổng người dùng') }}</h5>
                <p class="card-text fs-2">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê lịch hẹn -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Tổng lịch hẹn') }}</h5>
                <p class="card-text fs-2">{{ $stats['appointments'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Chờ xác nhận') }}</h5>
                <p class="card-text fs-2">{{ $stats['pending_appointments'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Đã xác nhận') }}</h5>
                <p class="card-text fs-2">{{ $stats['confirmed_appointments'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Hôm nay') }}</h5>
                <p class="card-text fs-2">{{ $stats['today_appointments'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Quick Actions') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus"></i> {{ __('Thêm người dùng') }}
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.appointments') }}" class="btn btn-success btn-block">
                            <i class="fas fa-calendar-check"></i> {{ __('Quản lý lịch hẹn') }}
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('users.index') }}" class="btn btn-info btn-block">
                            <i class="fas fa-users"></i> {{ __('Danh sách người dùng') }}
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('specializations.index') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-stethoscope"></i> {{ __('Quản lý chuyên khoa') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('title', __('Quản lý lịch hẹn - Admin'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar-check me-2"></i>{{ __('Quản lý lịch hẹn') }}
            </h1>
            <p class="text-muted">{{ __('Quản lý tất cả lịch hẹn trong hệ thống') }}</p>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ __('Tổng lịch hẹn') }}</div>
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
                                {{ __('Đã xác nhận') }}</div>
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
                                {{ __('Chờ xác nhận') }}</div>
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
                                {{ __('Hôm nay') }}</div>
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

    <!-- Danh sách lịch hẹn -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Danh sách lịch hẹn') }}</h6>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>{{ __('Thêm lịch hẹn') }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Bệnh nhân') }}</th>
                            <th>{{ __('Bác sĩ') }}</th>
                            <th>{{ __('Ngày giờ') }}</th>
                            <th>{{ __('Trạng thái') }}</th>
                            <th>{{ __('Nguồn') }}</th>
                            <th>{{ __('Thao tác') }}</th>
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
                                <small class="text-muted">{{ $appointment->doctorProfile->specialization->name ?? 'Đa khoa' }}</small>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}<br>
                                <small class="text-muted">{{ $appointment->time }}</small>
                            </td>
                            <td>
                                @if($appointment->status == 'confirmed')
                                    <span class="badge bg-success">{{ __('Đã xác nhận') }}</span>
                                @elseif($appointment->status == 'pending')
                                    <span class="badge bg-warning text-dark">{{ __('Chờ xác nhận') }}</span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-info text-dark">{{ __('Đã hoàn thành') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ __('Đã hủy') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($appointment->booking_type == 'admin')
                                    <span class="badge bg-primary">{{ __('Admin') }}</span>
                                    @if($appointment->creator)
                                        <br><small class="text-muted">{{ $appointment->creator->name }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-light text-dark border">{{ __('Bệnh nhân') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-sm btn-info text-white" title="{{ __('Chỉnh sửa') }}">
                                    <i class="fas fa-edit me-1"></i> {{ __('Sửa') }}
                                </a>
                                <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Bạn có chắc muốn xóa?') }}')" title="{{ __('Xóa') }}">
                                        <i class="fas fa-trash me-1"></i> {{ __('Xóa') }}
                                    </button>
                                </form>
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
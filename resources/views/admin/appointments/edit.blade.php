@extends('layouts.admin')

@section('title', 'Chỉnh sửa lịch hẹn - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit me-2"></i>Edit Appointment
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.appointments') }}">Lịch hẹn</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Appointment Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">Patient <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">-- Chọn bệnh nhân --</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ ($appointment->patientProfile && $appointment->patientProfile->user_id == $patient->id) ? 'selected' : '' }}>
                                                {{ $patient->name }} ({{ $patient->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="doctor_id">Doctor <span class="text-danger">*</span></label>
                                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                                        <option value="">-- Chọn bác sĩ --</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->user->name }} - {{ $doctor->specialization->name ?? 'Đa khoa' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" class="form-control" value="{{ $appointment->date }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time">Time <span class="text-danger">*</span></label>
                                    <input type="time" name="time" id="time" class="form-control" value="{{ $appointment->time }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="patient_note">Patient Note</label>
                            <textarea name="patient_note" id="patient_note" class="form-control" rows="3" placeholder="Mô tả triệu chứng, lý do khám...">{{ $appointment->patient_note }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Appointment
                            </button>
                            <a href="{{ route('admin.appointments') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Return
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Thông tin bổ sung -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Addtional Info</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Appointment ID:</strong> #{{ $appointment->id }}
                    </div>
                    <div class="mb-3">
                        <strong>Create Date:</strong><br>
                        {{ \Carbon\Carbon::parse($appointment->created_at)->format('d/m/Y H:i') }}
                    </div>
                    <div class="mb-3">
                        <strong>Last Update:</strong><br>
                        {{ \Carbon\Carbon::parse($appointment->updated_at)->format('d/m/Y H:i') }}
                    </div>
                    <div class="mb-3">
                        <strong>Booking Source:</strong>
                        @if($appointment->booking_type == 'admin')
                            <span class="badge badge-primary">Admin tạo</span>
                        @else
                            <span class="badge badge-light">Bệnh nhân tự đặt</span>
                        @endif
                    </div>
                    @if($appointment->created_by)
                        <div class="mb-3">
                            <strong>Creator:</strong><br>
                            {{ \App\Models\User::find($appointment->created_by)->name ?? 'N/A' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
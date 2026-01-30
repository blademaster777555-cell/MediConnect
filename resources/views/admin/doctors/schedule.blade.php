@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-calendar-week me-2"></i>{{ __('Quản lý lịch làm việc tuần: :name', ['name' => $user->name]) }}
        </h5>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-sm btn-light text-primary">
            <i class="bi bi-arrow-left me-1"></i> {{ __('Quay lại danh sách') }}
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20%;">{{ __('Ngày') }}</th>
                        <th>{{ __('Giờ bắt đầu') }}</th>
                        <th>{{ __('Giờ kết thúc') }}</th>
                        <th>{{ __('Trạng thái') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="{{ route('admin.doctors.schedule.update', $user->id) }}" method="POST">
                        @csrf
                        @foreach($days as $date => $label)
                            @php
                                $availability = $availabilities->firstWhere('date', $date);
                            @endphp
                            <tr>
                                <td>
                                    <input type="hidden" name="schedule[{{ $date }}][date]" value="{{ $date }}">
                                    <span class="fw-bold text-primary">{{ $label }}</span>
                                </td>
                                <td>
                                    <select name="schedule[{{ $date }}][start_time]" class="form-select">
                                        @foreach($timeSlots as $val => $label)
                                            <option value="{{ $val }}" 
                                                {{ ($availability && \Carbon\Carbon::parse($availability->start_time)->format('H:i') == $val) || (!$availability && $val == '09:00') ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="schedule[{{ $date }}][end_time]" class="form-select">
                                        @foreach($timeSlots as $val => $label)
                                            <option value="{{ $val }}" 
                                                {{ ($availability && \Carbon\Carbon::parse($availability->end_time)->format('H:i') == $val) || (!$availability && $val == '17:00') ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="schedule[{{ $date }}][is_available]" class="form-select {{ $availability && !$availability->is_available ? 'text-danger fw-bold bg-light' : 'text-success fw-bold' }}">
                                        <option value="1" class="text-success" {{ $availability && $availability->is_available ? 'selected' : '' }}>{{ __('Có thể đặt') }}</option>
                                        <option value="0" class="text-danger" {{ $availability && !$availability->is_available ? 'selected' : '' }}>{{ __('Nghỉ') }}</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-2"></i>{{ __('Lưu Lịch Làm Việc') }}
                                </button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

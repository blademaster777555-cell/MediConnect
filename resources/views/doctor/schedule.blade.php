@extends('layouts.modern')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        @include('partials.doctor-sidebar')

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card card-shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Quản lý lịch làm việc tuần') }}</h5>
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Ngày') }}</th>
                                    <th>{{ __('Giờ bắt đầu') }}</th>
                                    <th>{{ __('Giờ kết thúc') }}</th>
                                    <th>{{ __('Trạng thái') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="{{ route('doctor.schedule.store') }}" method="POST">
                                    @csrf
                                    @foreach($days as $date => $label)
                                        @php
                                            $availability = $availabilities->firstWhere('date', $date);
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="hidden" name="schedule[{{ $date }}][date]" value="{{ $date }}">
                                                <strong>{{ $label }}</strong>
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
                                                <select name="schedule[{{ $date }}][is_available]" class="form-select">
                                                    <option value="1" {{ $availability && $availability->is_available ? 'selected' : '' }}>{{ __('Có thể đặt') }}</option>
                                                    <option value="0" {{ $availability && !$availability->is_available ? 'selected' : '' }}>{{ __('Nghỉ') }}</option>
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
        </div>
    </div>
</div>
@endsection

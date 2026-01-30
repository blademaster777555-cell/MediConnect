@extends('layouts.modern')

@section('title', __('Hồ sơ Bác sĩ') . ' - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <!-- Sidebar -->
        @include('partials.doctor-sidebar')

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card card-shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>{{ __('Cập nhật hồ sơ') }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">{{ __('Họ và tên') }}</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label fw-bold">{{ __('Hình đại diện') }}</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                         alt="Avatar" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">{{ __('Số điện thoại') }}</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', $doctor->phone) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="specialization_id" class="form-label fw-bold">{{ __('Chuyên khoa') }}</label>
                                <select class="form-select" id="specialization_id" name="specialization_id" required>
                                    <option value="">{{ __('-- Chọn chuyên khoa --') }}</option>
                                    @foreach($specializations as $spec)
                                        <option value="{{ $spec->id }}" 
                                            {{ (old('specialization_id', $doctor->specialization_id) == $spec->id) ? 'selected' : '' }}>
                                            {{ $spec->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label fw-bold">{{ __('Thành phố / Tỉnh') }}</label>
                                <select class="form-select" id="city_id" name="city_id" required>
                                    <option value="">{{ __('-- Chọn thành phố --') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" 
                                            {{ (old('city_id', $doctor->city_id) == $city->id) ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="license_number" class="form-label fw-bold">{{ __('Số chứng chỉ hành nghề') }}</label>
                                <input type="text" class="form-control" id="license_number" name="license_number" 
                                       value="{{ old('license_number', $doctor->license_number) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="consultation_fee" class="form-label fw-bold">{{ __('Phí khám (USD)') }}</label>
                                <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" 
                                       value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="certificate" class="form-label fw-bold">{{ __('Bằng cấp/Chứng chỉ') }}</label>
                            <input type="file" class="form-control" id="certificate" name="certificate" accept="image/*">
                            @if($doctor->certificate)
                                <div class="mt-2">
                                    <p class="mb-1 text-muted small">{{ __('Đã tải lên:') }}</p>
                                    <a href="{{ asset('storage/' . $doctor->certificate) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-file-earmark-image me-1"></i>{{ __('Xem bằng cấp') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">{{ __('Giới thiệu bản thân') }}</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', $doctor->bio) }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-save me-2"></i>{{ __('Lưu thay đổi') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

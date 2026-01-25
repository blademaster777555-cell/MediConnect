@extends('layouts.modern')

@section('title', 'Tìm Bác sĩ - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">
                <i class="bi bi-search me-3"></i>{{ __('Tìm kiếm Bác sĩ') }}
            </h1>
            <p class="lead text-muted">{{ __('Kết nối với các chuyên gia y tế hàng đầu ngay hôm nay') }}</p>
        </div>
    </div>

    <div class="card card-shadow mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-funnel-fill me-2"></i>{{ __('Bộ lọc tìm kiếm') }}
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('doctors.index') }}" method="GET" class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold text-secondary">
                        <i class="bi bi-geo-alt me-1"></i>{{ __('Thành phố') }}
                    </label>
                    <select name="city_id" class="form-select">
                        <option value="">{{ __('-- Tất cả thành phố --') }}</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold text-secondary">
                        <i class="bi bi-heart-pulse me-1"></i>{{ __('Chuyên khoa') }}
                    </label>
                    <select name="specialization_id" class="form-select">
                        <option value="">{{ __('-- Tất cả chuyên khoa --') }}</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}" {{ request('specialization_id') == $spec->id ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 col-md-12 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary flex-grow-1 fw-bold">
                        <i class="bi bi-search me-2"></i> {{ __('Tìm Bác sĩ') }}
                    </button>
                    @if(Auth::check() && isset($userCityId))
                        <a href="{{ route('doctors.index', ['near_me' => 1]) }}" class="btn btn-outline-success fw-bold">
                            <i class="bi bi-geo-alt-fill"></i> {{ __('Gần tôi') }}
                        </a>
                    @endif
                </div>
            </form>

            @if(request('city_id') || request('specialization_id') || request('near_me'))
                <div class="mt-3 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            {{ __('Đang lọc:') }}
                            @if(request('city_id'))
                                {{ __('Thành phố') }}: <strong>{{ $cities->where('id', request('city_id'))->first()->name ?? 'N/A' }}</strong>
                            @elseif(request('near_me') && isset($userCityId))
                                {{ __('Khu vực của bạn:') }} <strong>{{ $cities->where('id', $userCityId)->first()->name ?? 'N/A' }}</strong>
                            @endif
                            
                            @if((request('city_id') || request('near_me')) && request('specialization_id')) | @endif
                            
                            @if(request('specialization_id'))
                                {{ __('Chuyên khoa') }}: <strong>{{ $specializations->where('id', request('specialization_id'))->first()->name ?? 'N/A' }}</strong>
                            @endif
                        </small>
                        <a href="{{ route('doctors.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>{{ __('Xóa bộ lọc') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        @if($doctors->count() > 0)
            <div class="col-12 mb-4">
                <div class="alert alert-info border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-4 me-3 text-info"></i>
                        <div>
                            <strong>{{ __('Tìm thấy') }} {{ $doctors->count() }} {{ __('bác sĩ') }}</strong>
                            @if(request('city_id') || request('specialization_id'))
                                {{ __('phù hợp với tiêu chí tìm kiếm của bạn') }}
                            @else
                                {{ __('trong hệ thống MediConnect') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @foreach($doctors as $doctor)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <img src="{{ $doctor->user->image ? asset('storage/' . $doctor->user->image) : 'https://ui-avatars.com/api/?name='.urlencode($doctor->user->name).'&background=random' }}" 
                                 class="rounded-circle mb-3 shadow-sm mx-auto" 
                                 style="width: 110px; height: 110px; object-fit: cover;">
                            
                            <h5 class="card-title fw-bold mb-1">{{ $doctor->user->name }}</h5>
                            
                            <div class="mb-3">
                                <span class="badge bg-primary-subtle text-primary">
                                    {{ $doctor->specialization->name ?? __('Đa khoa') }}
                                </span>
                            </div>
                            
                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt-fill text-danger"></i> 
                                {{ $doctor->city->name ?? __('Chưa cập nhật') }}
                            </p>
                            
                            <p class="card-text text-secondary small mb-4">
                                {{ Str::limit($doctor->bio, 80) }}
                            </p>
    
                            <div class="mt-auto w-100">
                                @auth
                                    <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-outline-primary rounded-pill px-4 w-100 fw-bold">
                                        {{ __('Đặt lịch ngay') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill px-4 w-100 fw-bold">
                                        {{ __('Đăng nhập để đặt lịch') }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <div class="alert alert-light border shadow-sm">
                        <i class="bi bi-info-circle text-warning fs-4 mb-2 d-block"></i>
                        <h5 class="fw-bold">{{ __('Không tìm thấy bác sĩ phù hợp') }}</h5>
                        <p class="text-muted">{{ __('Vui lòng thử thay đổi điều kiện tìm kiếm.') }}</p>
                        <a href="{{ route('doctors.index') }}" class="btn btn-link">{{ __('Xem tất cả bác sĩ') }}</a>
                    </div>
                </div>
            @endif
    </div>
</div>
@endsection
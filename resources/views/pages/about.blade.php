@extends('layouts.modern')

@section('title', 'Giới thiệu - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold text-primary mb-3">
                <i class="bi bi-heart-pulse me-3"></i>{{ __('Về MediConnect') }}
            </h1>
            <p class="lead text-muted mb-4">{{ __('Kết nối bệnh nhân và bác sĩ - Nhanh chóng, Tiện lợi, Tin cậy.') }}</p>
            <p class="mb-4">
                {{ __('MediConnect ra đời với sứ mệnh xóa bỏ rào cản trong việc tiếp cận dịch vụ y tế. Chúng tôi hiểu rằng việc xếp hàng chờ đợi tại bệnh viện là một nỗi ám ảnh, vì vậy MediConnect cung cấp giải pháp đặt lịch khám trực tuyến, giúp bạn chủ động thời gian và lựa chọn bác sĩ phù hợp nhất.') }}
            </p>
            <div class="row g-3">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <span class="fw-bold">{{ __('Đặt lịch 24/7') }}</span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <span class="fw-bold">{{ __('Bác sĩ uy tín') }}</span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <span class="fw-bold">{{ __('Hồ sơ bảo mật') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="https://via.placeholder.com/600x400?text=About+MediConnect" alt="About Us" class="img-fluid rounded card-shadow">
        </div>
    </div>



    <div class="row mt-5">
        <div class="col-12">
            <div class="card card-shadow">
                <div class="card-body text-center py-5">
                    <h3 class="fw-bold text-primary mb-3">{{ __('Sẵn sàng trải nghiệm MediConnect?') }}</h3>
                    <p class="text-muted mb-4">{{ __('Đặt lịch khám với bác sĩ ngay hôm nay để có sức khỏe tốt nhất.') }}</p>
                    @if(!Auth::check() || Auth::user()->role !== 'doctor')
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-search me-2"></i>{{ __('Tìm Bác sĩ ngay') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
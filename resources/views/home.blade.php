@extends('layouts.modern')

@section('title', 'Trang chủ - MediConnect')

@section('content')
<div class="hero-section">
    <div class="container text-center">
        @auth
            <h1 class="display-4 fw-bold">{{ __('Xin chào') }}, {{ Auth::user()->name }}! 👋</h1>
            <p class="lead">{{ __('Chúc bạn một ngày nhiều sức khỏe và niềm vui.') }}</p>
                @if(Auth::check() && !in_array(Auth::user()->role, ['doctor', 'admin']))
                    <a href="{{ route('doctors.index') }}" class="btn btn-light btn-lg">{{ __('Tìm Bác sĩ') }}</a>
                @endif
        @else
            <h1 class="display-4 fw-bold">MediConnect</h1>
            <p class="lead">{{ __('Nền tảng chăm sóc sức khỏe toàn diện cho gia đình bạn.') }}</p>
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg text-primary fw-bold me-2">{{ __('Đăng nhập') }}</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg fw-bold">{{ __('Đăng ký') }}</a>
            </div>
        @endauth
    </div>
</div>

<div class="container my-5">
    @if(!Auth::check() || !in_array(Auth::user()->role, ['doctor', 'admin']))
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-5 text-primary">
                <i class="bi bi-person-badge-fill me-2"></i>{{ __('Đội ngũ Bác sĩ Xuất sắc') }}
            </h2>
        </div>
    </div>

    <div class="row mb-5">
        @if(isset($featured_doctors) && $featured_doctors->count() > 0)
            @foreach($featured_doctors->take(4) as $doctor)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-shadow text-center py-3">
                        <div class="card-body">
                            <img src="{{ $doctor->user->image ? asset('storage/' . $doctor->user->image) : 'https://ui-avatars.com/api/?name='.urlencode($doctor->user->name).'&background=random' }}"
                                 class="rounded-circle mb-3 shadow-sm"
                                 style="width: 80px; height: 80px; object-fit: cover;">

                            <h6 class="fw-bold">{{ $doctor->user->name }}</h6>
                            <span class="badge bg-info text-dark mb-2">{{ $doctor->specialization->name ?? __('Khoa') }}</span>
                            <br>
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-primary rounded-pill mt-2 px-4">
                                {{ __('Đặt lịch') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($featured_doctors->count() > 4)
                <div id="extra-doctors" class="row g-0 pt-0 mt-0" style="display: none;">
                    @foreach($featured_doctors->skip(4) as $doctor)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 card-shadow text-center py-3">
                                <div class="card-body">
                                    <img src="{{ $doctor->user->image ? asset('storage/' . $doctor->user->image) : 'https://ui-avatars.com/api/?name='.urlencode($doctor->user->name).'&background=random' }}"
                                         class="rounded-circle mb-3 shadow-sm"
                                         style="width: 80px; height: 80px; object-fit: cover;">
        
                                    <h6 class="fw-bold">{{ $doctor->user->name }}</h6>
                                    <span class="badge bg-info text-dark mb-2">{{ $doctor->specialization->name ?? __('Khoa') }}</span>
                                    <br>
                                    <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-primary rounded-pill mt-2 px-4">
                                        {{ __('Đặt lịch') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="col-12 text-center mt-3">
                    <button id="toggle-doctors-btn" class="btn btn-outline-primary rounded-pill px-5">
                        {{ __('Xem thêm') }} <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            @endif
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-person-x fs-1 text-muted mb-3"></i>
                    <p class="text-muted fs-5">{{ __('Chưa có dữ liệu bác sĩ.') }}</p>
                </div>
    @endif
            </div>
        @endif
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-doctors-btn');
        const extraDoctors = document.getElementById('extra-doctors');
        
        if(toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                if (extraDoctors.style.display === 'none') {
                    extraDoctors.style.display = 'flex'; // Use flex because row is flex
                    extraDoctors.classList.add('row'); // Ensure row class behavior
                    this.innerHTML = '{{ __("Thu gọn") }} <i class="bi bi-chevron-up"></i>';
                } else {
                    extraDoctors.style.display = 'none';
                    this.innerHTML = '{{ __("Xem thêm") }} <i class="bi bi-chevron-down"></i>';
                }
            });
        }
    });
</script>
@endpush

    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-5 text-danger">
                <i class="bi bi-shield-plus me-2"></i>{{ __('Bệnh phổ biến & Phòng ngừa') }}
            </h2>
        </div>
    </div>
    <div class="row mb-5">
        @if(isset($diseases) && $diseases->count() > 0)
            @foreach($diseases as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 card-shadow">
                    <img src="{{ $post->image ?? 'https://via.placeholder.com/400x200' }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($post->summary, 80) }}</p>
                        <a href="{{ route('posts.detail', $post->id) }}" class="btn btn-outline-danger btn-sm">{{ __('Đọc tiếp') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x fs-1 text-muted mb-3"></i>
                    <p class="text-muted fs-5">{{ __('Đang cập nhật dữ liệu bệnh học...') }}</p>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <h3 class="mb-4 text-success">
                <i class="bi bi-newspaper me-2"></i>{{ __('Tin tức Y tế') }}
            </h3>
            <div class="row">
                @if(isset($news))
                    @foreach($news as $post)
                    <div class="col-12 mb-3">
                        <div class="card card-shadow">
                            <div class="row g-0">
                                <div class="col-4">
                                    <img src="{{ $post->image ?? 'https://via.placeholder.com/100' }}" class="img-fluid rounded-start h-100" style="object-fit: cover;">
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $post->title }}</h6>
                                        <p class="card-text small text-muted">{{ Str::limit($post->summary, 60) }}</p>
                                        <a href="{{ route('posts.detail', $post->id) }}" class="btn btn-sm btn-outline-success">{{ __('Đọc thêm') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <h3 class="mb-4 text-info">
                <i class="bi bi-lightbulb me-2"></i>{{ __('Phát minh mới') }}
            </h3>
            @if(isset($inventions))
                @foreach($inventions as $post)
                <div class="card mb-3 card-shadow">
                    <div class="row g-0">
                        <div class="col-4">
                            <img src="{{ $post->image ?? 'https://via.placeholder.com/100' }}" class="img-fluid rounded-start h-100" style="object-fit: cover;">
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">{{ $post->title }}</h6>
                                <p class="card-text small text-muted">{{ Str::limit($post->summary, 60) }}</p>
                                <a href="{{ route('posts.detail', $post->id) }}" class="btn btn-sm btn-outline-info">{{ __('Xem chi tiết') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
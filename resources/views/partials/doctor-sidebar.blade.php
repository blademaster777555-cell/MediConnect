<div class="col-lg-3 mb-4">
    <div class="card card-shadow h-100">
        <div class="card-body p-0">
            <div class="list-group list-group-flush rounded-3">
                <a href="{{ route('doctor.dashboard') }}" class="list-group-item list-group-item-action py-3 border-0 {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>{{ __('Dashboard') }}
                </a>
                <a href="{{ route('doctor.appointments') }}" class="list-group-item list-group-item-action py-3 border-0 {{ request()->routeIs('doctor.appointments') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check me-2"></i>{{ __('Quản lý lịch hẹn') }}
                </a>
                <a href="{{ route('doctor.schedule') }}" class="list-group-item list-group-item-action py-3 border-0 {{ request()->routeIs('doctor.schedule') ? 'active' : '' }}">
                    <i class="bi bi-clock me-2"></i>{{ __('Lịch làm việc') }}
                </a>
                <a href="{{ route('doctor.profile') }}" class="list-group-item list-group-item-action py-3 border-0 {{ request()->routeIs('doctor.profile') ? 'active' : '' }}">
                    <i class="bi bi-person me-2"></i>{{ __('Hồ sơ cá nhân') }}
                </a>
            </div>
        </div>
    </div>
</div>

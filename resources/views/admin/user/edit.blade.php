@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ __('Chỉnh sửa người dùng') }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Họ và tên') }}</label>
                    <input type="text" name="name" class="form-control" required value="{{ $user->name }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Hình đại diện') }}</label>
                    <div class="d-flex align-items-center gap-2">
                         <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" width="40" height="40" class="rounded-circle" style="object-fit: cover;">
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Email đăng nhập') }}</label>
                    <input type="email" name="email" class="form-control" required value="{{ $user->email }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Số điện thoại') }}</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->profile?->phone }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Thành phố') }}</label>
                    <select name="city_id" class="form-select">
                        <option value="">-- Chọn thành phố --</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ ($user->city_id == $city->id) ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-danger">{{ __('Vai trò') }}</label>
                    <select name="role" class="form-select" id="roleSelect">
                        <option value="{{ \App\Models\User::ROLE_PATIENT }}" {{ $user->role === \App\Models\User::ROLE_PATIENT ? 'selected' : '' }}>{{ __('Bệnh nhân') }}</option>
                        <option value="{{ \App\Models\User::ROLE_DOCTOR }}" {{ $user->role === \App\Models\User::ROLE_DOCTOR ? 'selected' : '' }}>{{ __('Bác sĩ') }}</option>
                        <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ $user->role === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>{{ __('Admin (Quản trị viên)') }}</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3" id="specializationDiv" style="display: {{ $user->role === \App\Models\User::ROLE_DOCTOR ? 'block' : 'none' }};">
                    <label class="form-label">{{ __('Chuyên khoa') }}</label>
                    <select name="specialization_id" class="form-select">
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}" {{ ($user->doctorProfile?->specialization_id ?? '') == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ __('Cập nhật') }}
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
        </form>
    </div>
</div>

<script>
document.getElementById('roleSelect').addEventListener('change', function() {
    var specializationDiv = document.getElementById('specializationDiv');
    
    if (this.value === '{{ \App\Models\User::ROLE_DOCTOR }}') {
        specializationDiv.style.display = 'block';
    } else {
        specializationDiv.style.display = 'none';
    }
});
</script>
@endsection
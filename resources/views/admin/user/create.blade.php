@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ __('Thêm người dùng mới') }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Họ và tên') }}</label>
                    <input type="text" name="name" class="form-control" required placeholder="{{ __('VD: BS. Nguyễn Văn A') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Email đăng nhập') }}</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Mật khẩu') }}</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Số điện thoại') }}</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Thành phố') }}</label>
                    <select name="city_id" class="form-select">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-danger">{{ __('Vai trò') }}</label>
                    <select name="role" class="form-select" id="roleSelect">
                        <option value="{{ \App\Models\User::ROLE_PATIENT }}">{{ __('Bệnh nhân') }}</option>
                        <option value="{{ \App\Models\User::ROLE_DOCTOR }}">{{ __('Bác sĩ') }}</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3" id="specializationDiv" style="display: none;">
                    <label class="form-label">{{ __('Chuyên khoa') }}</label>
                    <select name="specialization_id" class="form-select">
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ __('Lưu tài khoản') }}
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
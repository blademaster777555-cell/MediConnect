@extends('layouts.modern')

@section('title', __('Update Profile') . ' - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">
                <i class="bi bi-person-circle me-3"></i>{{ __('Update Profile') }}
            </h1>
            <p class="lead text-muted">{{ __('Manage your personal information and account security') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Thông tin cá nhân -->
            <div class="card card-shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-fill me-2"></i>{{ __('Personal Information') }}
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="card card-shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock-fill me-2"></i>{{ __('Change Password') }}
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>


        </div>
    </div>
</div>
@endsection

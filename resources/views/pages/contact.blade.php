@extends('layouts.modern')

@section('title', 'Contact - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">
                <i class="bi bi-envelope me-3"></i>{{ __('Contact Us') }}
            </h1>
            <p class="lead text-muted">{{ __('We are always ready to support you 24/7') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card card-shadow text-center h-100">
                <div class="card-body py-5">
                    <div class="display-4 text-primary mb-3">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="fw-bold">{{ __('Address') }}</h5>
                    <p class="text-muted">123 ABC Street, District 1<br>HCMC, Vietnam</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-shadow text-center h-100">
                <div class="card-body py-5">
                    <div class="display-4 text-success mb-3">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5 class="fw-bold">{{ __('Phone') }}</h5>
                    <p class="text-muted">(028) 1234 5678<br>Hotline: 1900 XXX XXX</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-shadow text-center h-100">
                <div class="card-body py-5">
                    <div class="display-4 text-info mb-3">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h5 class="fw-bold">{{ __('Email') }}</h5>
                    <p class="text-muted">contact@mediconnect.vn<br>support@mediconnect.vn</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-6 mb-4">
            <div class="card card-shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-send me-2"></i>{{ __('Send Message') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">{{ __('Full Name') }}</label>
                                <input type="text" name="name" class="form-control" required placeholder="{{ __('Enter your full name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control" required placeholder="email@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Phone Number') }}</label>
                            <input type="text" name="phone" class="form-control" placeholder="0123 456 789">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Message Content') }}</label>
                            <textarea name="message" class="form-control" rows="5" required placeholder="{{ __('Describe your problem or question...') }}"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-send me-2"></i>{{ __('Send Message') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-clock me-2"></i>{{ __('Working Hours') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span class="fw-bold">{{ __('Mon - Fri') }}</span>
                                <span class="text-primary">08:00 - 18:00</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span class="fw-bold">{{ __('Saturday') }}</span>
                                <span class="text-primary">08:00 - 12:00</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span class="fw-bold">{{ __('Sunday') }}</span>
                                <span class="text-danger">{{ __('Closed') }}</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span class="fw-bold">{{ __('Holidays') }}</span>
                                <span class="text-danger">{{ __('Closed') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="fw-bold text-primary mb-2">
                            <i class="bi bi-headset me-2"></i>{{ __('Emergency Support') }}
                        </h6>
                        <p class="small text-muted mb-1">Hotline: <strong>1900 XXX XXX</strong></p>
                        <p class="small text-muted">{{ __('24/7 support for emergency cases') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
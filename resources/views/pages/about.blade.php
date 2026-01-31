@extends('layouts.modern')

@section('title', 'About Us - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold text-primary mb-3">
                <i class="bi bi-heart-pulse me-3"></i>{{ __('About MediConnect') }}
            </h1>
            <p class="lead text-muted mb-4">{{ __('Connecting patients and doctors - Fast, Convenient, Reliable.') }}</p>
            <p class="mb-4">
                {{ __('MediConnect was born with the mission to remove barriers in accessing medical services. We understand that waiting at hospitals is a nightmare, so MediConnect provides an online booking solution, helping you take initiative in time and choose the most suitable doctor.') }}
            </p>
            <div class="row g-3">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <span class="fw-bold">{{ __('24/7 Booking') }}</span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <span class="fw-bold">{{ __('Reputable Doctors') }}</span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <span class="fw-bold">{{ __('Secure Records') }}</span>
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
                    <h3 class="fw-bold text-primary mb-3">{{ __('Ready to experience MediConnect?') }}</h3>
                    <p class="text-muted mb-4">{{ __('Book an appointment with a doctor today for your best health.') }}</p>
                    @if(!Auth::check() || Auth::user()->role !== 'doctor')
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-search me-2"></i>{{ __('Find A Doctor Now') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
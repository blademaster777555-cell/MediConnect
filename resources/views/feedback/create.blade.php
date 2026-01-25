@extends('layouts.modern')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-star-fill me-2"></i>{{ __('Đánh giá & Phản hồi') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6>{{ __('Thông tin lịch hẹn') }}</h6>
                        <p class="mb-1"><strong>{{ __('Bác sĩ') }}:</strong> {{ $appointment->doctorProfile->user->name }} - {{ $appointment->doctorProfile->specialization->name }}</p>
                        <p class="mb-1"><strong>{{ __('Ngày khám') }}:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} - {{ $appointment->time }}</p>
                    </div>

                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('Đánh giá trải nghiệm của bạn') }} <span class="text-danger">*</span></label>
                            <div class="rating-css">
                                <div class="star-icon">
                                    <input type="radio" value="5" name="rating" id="rating5">
                                    <label for="rating5" class="bi bi-star-fill"></label>
                                    <input type="radio" value="4" name="rating" id="rating4">
                                    <label for="rating4" class="bi bi-star-fill"></label>
                                    <input type="radio" value="3" name="rating" id="rating3">
                                    <label for="rating3" class="bi bi-star-fill"></label>
                                    <input type="radio" value="2" name="rating" id="rating2">
                                    <label for="rating2" class="bi bi-star-fill"></label>
                                    <input type="radio" value="1" name="rating" id="rating1">
                                    <label for="rating1" class="bi bi-star-fill"></label>
                                </div>
                            </div>
                            <style>
                                .rating-css div { color: #ffe400; font-size: 30px; font-family: sans-serif; font-weight: 800; text-align: center; text-transform: uppercase; padding: 20px 0; transition: all 0.5s; background-color: #f9f9f9; border-radius: 10px; border: 1px solid #eee; display: flex; justify-content: center; flex-direction: row-reverse; }
                                .rating-css input { display: none; }
                                .rating-css input + label { font-size: 40px; text-shadow: 1px 1px 0 #8f8420; cursor: pointer; transition: all 0.2s; margin: 0 5px; }
                                .rating-css input + label:hover, .rating-css input + label:hover ~ label { color: #orange; }
                                .rating-css input:checked + label:hover, .rating-css input:checked + label:hover ~ label, .rating-css input:checked ~ label + label:hover, .rating-css input:checked ~ label + label:hover ~ label, .rating-css label:hover ~ input:checked ~ label { color: #orange; }
                                .rating-css input:checked ~ label { color: #ffe400; }
                                /* Fix reverse order for CSS only star rating */
                                .star-icon input:checked ~ label { color: #ffc107; }
                                .star-icon label { color: #ddd; }
                            </style>
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">{{ __('Nhận xét chi tiết') }}</label>
                            <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="{{ __('Chia sẻ thêm về trải nghiệm của bạn (tùy chọn)...') }}"></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('my.appointments') }}" class="btn btn-secondary me-md-2">{{ __('Hủy bỏ') }}</a>
                            <button type="submit" class="btn btn-primary px-4">{{ __('Gửi đánh giá') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

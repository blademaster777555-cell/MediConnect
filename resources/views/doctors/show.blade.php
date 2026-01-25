@extends('layouts.modern')

@section('title', 'BS. ' . $doctor->user->name . ' - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card card-shadow text-center p-4">
                <img src="{{ $doctor->user->image ? asset('storage/' . $doctor->user->image) : 'https://ui-avatars.com/api/?name='.urlencode($doctor->user->name) }}"
                        class="rounded-circle mx-auto mb-3 shadow-sm" width="150" style="object-fit: cover;">
                <h4 class="fw-bold">{{ $doctor->user->name }}</h4>
                <p class="text-primary fw-bold mb-2">{{ $doctor->specialization->name ?? __('Chưa cập nhật chuyên khoa') }}</p>
                <p class="text-muted small mb-3">{{ $doctor->bio }}</p>
                <div class="mb-3">
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-cash-coin me-1"></i> {{ __('Phí khám') }}: {{ number_format($doctor->consultation_fee, 2, '.', ',') }} USD
                    </span>
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <span class="badge bg-info">
                        <i class="bi bi-geo-alt-fill me-1"></i>{{ $doctor->city->name ?? __('Chưa cập nhật') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>{{ __('Đặt lịch khám') }}</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('appointment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        @auth
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('Chọn Ngày') }}</label>
                                    <input type="text" name="date" id="appointment-date" class="form-control bg-white" required placeholder="{{ __('Chọn ngày khám') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('Chọn Giờ') }}</label>
                                    <select name="time" id="appointment-time" class="form-select" required>
                                        <option value="">{{ __('-- Vui lòng chọn ngày trước --') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Triệu chứng / Ghi chú') }}</label>
                                <textarea name="patient_note" class="form-control" rows="3" placeholder="{{ __('Mô tả triệu chứng hoặc ghi chú...') }}"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                <i class="bi bi-check-circle me-2"></i>{{ __('Xác nhận đặt lịch') }}
                            </button>
                        @else
                            <div class="text-center py-4 bg-light rounded border border-secondary border-dashed">
                                <i class="bi bi-shield-lock fs-1 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted mb-3">{{ __('Vui lòng đăng nhập để xem lịch khám và đặt lịch') }}</h5>
                                <a href="{{ route('login') }}" class="btn btn-primary fw-bold px-4">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Đăng nhập') }}
                                </a>
                            </div>
                        @endauth
                    </form>
                </div>
            </div>
                </div>
            </div>

            <div class="card card-shadow mt-4">
                <div class="card-header bg-white fw-bold">
                    {{ __('Đánh giá từ bệnh nhân') }} ({{ $doctor->feedbacks->count() }})
                </div>
                <div class="card-body">
                    @foreach($doctor->feedbacks as $feedback)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $feedback->user->name }}</strong>
                                <span class="text-warning">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                            </div>
                            <p class="text-muted mb-0">{{ $feedback->comment }}</p>
                            <small class="text-secondary">{{ $feedback->created_at->format('d/m/Y') }}</small>
                        </div>
                    @endforeach

                    @if($doctor->feedbacks->count() == 0)
                        <p class="text-center text-muted">{{ __('Chưa có đánh giá nào.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timeSelect = document.getElementById('appointment-time');
        const doctorId = {{ $doctor->id }};
        const currentLocale = '{{ app()->getLocale() }}';

        flatpickr("#appointment-date", {
            dateFormat: "Y-m-d",
            minDate: new Date().fp_incr(1), // Tomorrow
            locale: currentLocale === 'vi' ? 'vn' : 'default', // Vietnamese or English default
            onChange: function(selectedDates, dateStr, instance) {
                if (!dateStr) return;
                fetchAvailability(dateStr);
            }
        });

        function fetchAvailability(date) {
            // Reset time select
            timeSelect.innerHTML = '<option value="">Đang tải...</option>';
            timeSelect.disabled = true;

            fetch(`{{ route('api.doctor-availability') }}?doctor_id=${doctorId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    timeSelect.innerHTML = '<option value="">-- {{ __("Chọn khung giờ") }} --</option>';
                    
                    if (!data.available) {
                        const option = document.createElement('option');
                        option.text = data.message || '{{ __("Bác sĩ không làm việc ngày này") }}';
                        timeSelect.add(option);
                        timeSelect.disabled = true;
                        return;
                    }

                    if (data.slots.length === 0) {
                        const option = document.createElement('option');
                        option.text = '{{ __("Hết lịch hẹn trong ngày") }}';
                        timeSelect.add(option);
                        timeSelect.disabled = true;
                        return;
                    }

                    timeSelect.disabled = false;
                    data.slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot.time;
                        option.text = slot.display + (slot.is_booked ? ' ({{ __("Đã đặt") }})' : '');
                        if (slot.is_booked) {
                            option.disabled = true;
                            option.classList.add('text-muted');
                        }
                        timeSelect.add(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    timeSelect.innerHTML = '<option value="">{{ __("Lỗi tải dữ liệu") }}</option>';
                });
        }
    });
</script>
@endpush
@endsection
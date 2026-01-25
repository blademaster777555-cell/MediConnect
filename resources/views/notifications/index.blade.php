@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.modern')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('Thông báo') }}</h2>
        @if($notifications->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-check-all"></i> {{ __('Đánh dấu tất cả đã đọc') }}
                </button>
            </form>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($notifications->isEmpty())
                <div class="text-center p-5 text-muted">
                    <i class="bi bi-bell-slash fs-1 d-block mb-3"></i>
                    {{ __('Bạn không có thông báo nào.') }}
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                        <li class="list-group-item d-flex justify-content-between align-items-start {{ $notification->read_at ? '' : 'bg-light' }}">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                    @if(isset($notification->data['type']) && $notification->data['type'] == 'new_doctor')
                                        <i class="bi bi-person-plus-fill text-primary me-2"></i>
                                    @elseif(isset($notification->data['type']) && $notification->data['type'] == 'new_appointment')
                                        <i class="bi bi-calendar-plus-fill text-success me-2"></i>
                                    @else
                                        <i class="bi bi-info-circle-fill text-info me-2"></i>
                                    @endif
                                    @php
                                        $message = $notification->data['message'] ?? __('Thông báo hệ thống');
                                        if (isset($notification->data['type'])) {
                                            if ($notification->data['type'] == 'new_appointment') {
                                                $message = Str::replace('Lịch hẹn mới', __('Lịch hẹn mới'), $message);
                                            } elseif ($notification->data['type'] == 'new_doctor') {
                                                $message = Str::replace('Bác sĩ mới đăng ký', __('Bác sĩ mới đăng ký'), $message);
                                            }
                                        }
                                    @endphp
                                    {{ $message }}
                                </div>
                                <span class="text-muted small">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                
                                @if(isset($notification->data['link']))
                                    <div class="mt-1">
                                        <a href="{{ $notification->data['link'] }}" class="btn btn-sm btn-link text-decoration-none p-0">
                                            {{ __('Xem chi tiết') }} <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm text-primary" title="{{ __('Đánh dấu đã đọc') }}">
                                        <i class="bi bi-circle-fill small"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="ms-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger" title="{{ __('Xóa') }}">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card-footer">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection

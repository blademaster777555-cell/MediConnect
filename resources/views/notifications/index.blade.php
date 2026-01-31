@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.modern')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('Thông báo') }}</h2>
        @if($notifications->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-check-all"></i> {{ __('Mark all as read') }}
                </button>
            </form>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($notifications->isEmpty())
                <div class="text-center p-5 text-muted">
                    <i class="bi bi-bell-slash fs-1 d-block mb-3"></i>
                    {{ __('You do not have any new notification.') }}
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                        <li class="list-group-item d-flex justify-content-between align-items-start {{ $notification->read_at ? '' : 'bg-light' }}">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                    @php
                                        $type = $notification->data['type'] ?? 'info';
                                        $message = $notification->data['message'] ?? __('System Report');
                                    @endphp

                                    @if($type == 'new_booking' || $type == 'new_appointment')
                                        <i class="bi bi-calendar-plus-fill text-primary me-2"></i>
                                    @elseif($type == 'status_update')
                                        <i class="bi bi-info-circle-fill text-info me-2"></i>
                                    @elseif($type == 'profile_approved')
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    @elseif($type == 'profile_rejected')
                                        <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                    @elseif($type == 'new_doctor')
                                        <i class="bi bi-person-plus-fill text-primary me-2"></i>
                                    @else
                                        <i class="bi bi-bell-fill text-secondary me-2"></i>
                                    @endif
                                    
                                    {{ $message }}
                                </div>
                                <span class="text-muted small">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                
                                @if(isset($notification->data['link']) && $notification->data['link'] != '#')
                                    <div class="mt-2">
                                        <a href="{{ $notification->data['link'] }}" class="btn btn-sm btn-outline-primary py-0 px-2">
                                            {{ __('Xem chi tiết') }} <i class="bi bi-arrow-right ms-1"></i>
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

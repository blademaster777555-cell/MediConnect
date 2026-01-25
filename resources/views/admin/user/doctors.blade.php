@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ __('Quản lý Bác sĩ') }}</h2>
    <a href="{{ route('users.create') }}?role=doctor" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> {{ __('Thêm Bác sĩ') }}
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('Tên') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Chuyên khoa') }}</th>
                    <th>{{ __('Thành phố') }}</th>
                    <th>{{ __('Trạng thái') }}</th>
                    <th>{{ __('Bằng cấp') }}</th>
                    <th>{{ __('Hành động') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->doctorProfile->phone ?? '---' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-info text-dark d-block p-2 fw-normal text-wrap" style="min-width: 100px;">
                            {{ $user->doctorProfile->specialization->name ?? '---' }}
                        </span>
                    </td>
                    <td>
                        {{ $user->doctorProfile->city->name ?? '---' }}
                    </td>
                    <td>
                        @if($user->doctorProfile && $user->doctorProfile->is_approved)
                            <span class="badge bg-success">{{ __('Đã duyệt') }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ __('Chờ duyệt') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($user->doctorProfile && $user->doctorProfile->certificate)
                            <a href="{{ asset('storage/' . $user->doctorProfile->certificate) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-file-earmark-image"></i> {{ __('Xem') }}
                            </a>
                        @else
                            <span class="text-muted small">{{ __('Chưa có') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            @if($user->doctorProfile && !$user->doctorProfile->is_approved)
                                <form action="{{ route('admin.doctors.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success d-flex align-items-center gap-1" onclick="return confirm('{{ __('Duyệt bác sĩ này?') }}');">
                                        <i class="bi bi-check-lg"></i> {{ __('Duyệt') }}
                                    </button>
                                </form>
                            @endif
                            
                            
                            <a href="{{ route('admin.doctors.schedule', $user->id) }}" class="btn btn-sm btn-info text-white shadow-sm" title="{{ __('Quản lý lịch làm việc') }}" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                <i class="bi bi-calendar-week"></i>
                            </a>

                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('Bạn chắc chắn muốn xóa?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection

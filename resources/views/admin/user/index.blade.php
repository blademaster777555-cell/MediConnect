@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ __('Quản lý Người dùng') }}</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> {{ __('Thêm mới') }}
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('Tên') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Vai trò') }}</th>
                    <th>{{ __('Thành phố') }}</th>
                    <th>{{ __('Hành động') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === \App\Models\User::ROLE_ADMIN) <span class="badge bg-danger">{{ __('Admin') }}</span>
                        @elseif($user->role === \App\Models\User::ROLE_DOCTOR) <span class="badge bg-primary">{{ __('Bác sĩ') }}</span>
                        @else <span class="badge bg-secondary">{{ __('Bệnh nhân') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($user->role === \App\Models\User::ROLE_DOCTOR && $user->doctorProfile && $user->doctorProfile->city)
                            {{ $user->doctorProfile->city->name }}
                        @else
                            ---
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('Bạn chắc chắn muốn xóa?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('Xóa') }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
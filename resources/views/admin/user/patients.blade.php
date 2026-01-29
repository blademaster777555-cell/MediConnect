@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ __('Quản lý Bệnh nhân') }}</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('Tên') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Số điện thoại') }}</th>
                    <th>{{ __('Ngày tham gia') }}</th>
                    <th>{{ __('Hành động') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $user->name }}</div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->patientProfile->phone ?? '---' }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i> {{ __('Xem') }}
                            </a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete(event, this);">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> {{ __('Xóa') }}
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

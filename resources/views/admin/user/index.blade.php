@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ __('User Management') }}</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> {{ __('Add New') }}
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('City') }}</th>
                    <th>{{ __('Actions') }}</th>
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
                        @elseif($user->role === \App\Models\User::ROLE_DOCTOR) <span class="badge bg-primary">{{ __('Doctor') }}</span>
                        @else <span class="badge bg-secondary">{{ __('Patient') }}</span>
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
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirmAction(event, '{{ __('Are you sure you want to delete?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
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
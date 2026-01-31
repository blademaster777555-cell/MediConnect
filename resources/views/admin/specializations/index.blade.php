@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> {{ __('Add Specialization') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('specializations.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Specialization Name') }}</label>
                        <input type="text" name="name" class="form-control" required
                               placeholder="{{ __('Ex: Internal Medicine') }}">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description (Optional)') }}</label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="{{ __('Description of this specialization...') }}"></textarea>
                        @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus"></i> {{ __('Add Specialization') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list"></i> {{ __('Specialization List') }}</h5>
            </div>
            <div class="card-body">
                @if($specializations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>{{ __('Specialization Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($specializations as $specialization)
                            <tr>
                                <td>{{ $specialization->id }}</td>
                                <td>
                                    <strong>{{ $specialization->name }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($specialization->description, 50) ?: __('No description') }}
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ route('specializations.edit', $specialization->id) }}"
                                       class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil"></i> {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('specializations.destroy', $specialization->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirmAction(event, '{{ __('Delete this specialization?') }}');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-info-circle fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">{{ __('No specializations found') }}</h5>
                    <p class="text-muted">{{ __('Please add the first specialization on the left') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
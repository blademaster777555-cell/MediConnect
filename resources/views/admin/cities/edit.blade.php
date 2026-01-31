@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> {{ __('Edit City') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cities.update', $city->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('City Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{ old('name', $city->name) }}" required
                               placeholder="{{ __('Ex: Can Tho') }}">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check"></i> {{ __('Update') }}
                        </button>
                        <a href="{{ route('cities.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> {{ __('Back') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
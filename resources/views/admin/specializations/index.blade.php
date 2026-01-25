@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> {{ __('Thêm Chuyên Khoa') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('specializations.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Tên chuyên khoa') }}</label>
                        <input type="text" name="name" class="form-control" required
                               placeholder="{{ __('VD: Nội khoa') }}">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Mô tả (tùy chọn)') }}</label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="{{ __('Mô tả về chuyên khoa này...') }}"></textarea>
                        @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus"></i> {{ __('Thêm chuyên khoa') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list"></i> {{ __('Danh sách Chuyên Khoa') }}</h5>
            </div>
            <div class="card-body">
                @if($specializations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>{{ __('Tên chuyên khoa') }}</th>
                                <th>{{ __('Mô tả') }}</th>
                                <th>{{ __('Hành động') }}</th>
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
                                        {{ Str::limit($specialization->description, 50) ?: __('Chưa có mô tả') }}
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ route('specializations.edit', $specialization->id) }}"
                                       class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil"></i> {{ __('Sửa') }}
                                    </a>
                                    <form action="{{ route('specializations.destroy', $specialization->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('{{ __('Xóa chuyên khoa này?') }}');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> {{ __('Xóa') }}
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
                    <h5 class="text-muted">{{ __('Chưa có chuyên khoa nào') }}</h5>
                    <p class="text-muted">{{ __('Hãy thêm chuyên khoa đầu tiên ở bên trái') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
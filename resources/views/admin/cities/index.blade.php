@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">{{ __('Thêm Thành Phố') }}</div>
            <div class="card-body">
                <form action="{{ route('cities.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>{{ __('Tên thành phố') }}</label>
                        <input type="text" name="name" class="form-control" required placeholder="{{ __('VD: Cần Thơ') }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('Lưu lại') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">{{ __('Danh sách Thành phố') }}</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Tên') }}</th>
                            <th>{{ __('Hành động') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cities as $city)
                        <tr>
                            <td>{{ $city->id }}</td>
                            <td>{{ $city->name }}</td>
                            <td>
                                <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i> {{ __('Sửa') }}
                                </a>
                                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Xóa thành phố này?') }}');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> {{ __('Xóa') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
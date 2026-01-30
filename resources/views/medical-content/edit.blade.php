@extends('layouts.admin')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa bài viết</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('medical-content.update', $medicalContent->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label font-weight-bold">Tiêu đề bài viết</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $medicalContent->title) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label font-weight-bold">Danh mục</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">-- Chọn danh mục --</option>
                            <option value="news" {{ old('category', $medicalContent->category) == 'news' ? 'selected' : '' }}>Tin tức Y tế</option>
                            <option value="disease" {{ old('category', $medicalContent->category) == 'disease' ? 'selected' : '' }}>Bệnh học & Phòng ngừa</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="published_date" class="form-label font-weight-bold">Ngày đăng</label>
                        <input type="date" class="form-control" id="published_date" name="published_date" value="{{ old('published_date', \Carbon\Carbon::parse($medicalContent->published_date)->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label font-weight-bold">Hình ảnh minh họa (URL)</label>
                    <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $medicalContent->image) }}" placeholder="Nhập đường dẫn hình ảnh...">
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label font-weight-bold">Nội dung bài viết</label>
                    <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content', $medicalContent->content) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('medical-content.index') }}" class="btn btn-secondary me-2">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

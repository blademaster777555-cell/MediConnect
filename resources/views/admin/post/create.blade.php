@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">Viết bài mới</div>
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label>Tiêu đề bài viết</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Loại bài viết</label>
                    <select name="type" class="form-select">
                        <option value="disease">Bệnh học & Phòng ngừa</option>
                        <option value="news">Tin tức Y tế</option>
                        <option value="invention">Phát minh Y học</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Link Ảnh (URL)</label>
                    <input type="text" name="image" class="form-control" placeholder="https://...">
                </div>
            </div>

            <div class="mb-3">
                <label>Tóm tắt ngắn (Hiện ở trang chủ)</label>
                <textarea name="summary" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>Nội dung chi tiết</label>
                <textarea name="content" class="form-control" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Đăng bài</button>
        </form>
    </div>
</div>
@endsection
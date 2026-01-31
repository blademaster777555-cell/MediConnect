@extends('layouts.admin')

@section('title', __('Quản lý Tin tức và Bệnh học'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Quản lý Tin tức & Bệnh học') }}</h1>
        <a href="{{ route('medical-content.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> {{ __('Thêm bài viết mới') }}
        </a>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Lọc theo danh mục') }}</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('medical-content.index') }}" class="btn btn-outline-secondary {{ !request('category') ? 'active' : '' }}">{{ __('Tất cả') }}</a>
            <a href="{{ route('medical-content.index', ['category' => 'news']) }}" class="btn btn-outline-warning {{ request('category') == 'news' ? 'active' : '' }}">{{ __('Tin tức Y tế') }}</a>
            <a href="{{ route('medical-content.index', ['category' => 'disease']) }}" class="btn btn-outline-danger {{ request('category') == 'disease' ? 'active' : '' }}">{{ __('Bệnh phổ biến & Phòng ngừa') }}</a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Danh sách bài viết') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Tiêu đề') }}</th>
                            <th>{{ __('Danh mục') }}</th>
                            <th>{{ __('Tác giả') }}</th>
                            <th>{{ __('Ngày đăng') }}</th>
                            <th>{{ __('Hành động') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                        <tr>
                            <td>{{ $content->id }}</td>
                            <td>{{ Str::limit($content->title, 50) }}</td>
                            <td>
                                @if($content->category == 'news')
                                    <span class="badge bg-warning text-dark">{{ __('Tin tức') }}</span>
                                @elseif($content->category == 'disease')
                                    <span class="badge bg-danger">{{ __('Bệnh học') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $content->category }}</span>
                                @endif
                            </td>
                            <td>{{ $content->author->name ?? 'Admin' }}</td>
                            <td>{{ \Carbon\Carbon::parse($content->published_date)->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('medical-content.edit', $content->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('medical-content.destroy', $content->id) }}" method="POST" onsubmit="return confirmDelete(event, this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('Chưa có bài viết nào.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $contents->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

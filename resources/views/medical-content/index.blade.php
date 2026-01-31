@extends('layouts.admin')

@section('title', __('News & Pathology Management'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('News & Pathology Management') }}</h1>
        <a href="{{ route('medical-content.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> {{ __('Add New Post') }}
        </a>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="{{ route('medical-content.index') }}" class="btn btn-outline-secondary {{ !request('category') ? 'active' : '' }}">{{ __('All') }}</a>
            <a href="{{ route('medical-content.index', ['category' => 'news']) }}" class="btn btn-outline-warning {{ request('category') == 'news' ? 'active' : '' }}">{{ __('Medical News') }}</a>
            <a href="{{ route('medical-content.index', ['category' => 'disease']) }}" class="btn btn-outline-danger {{ request('category') == 'disease' ? 'active' : '' }}">{{ __('Common Diseases & Prevention') }}</a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Post List') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Author') }}</th>
                            <th>{{ __('Published Date') }}</th>
                            <th>{{ __('Actions') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                        <tr>
                            <td>{{ $content->id }}</td>
                            <td>{{ Str::limit($content->title, 50) }}</td>
                            <td>
                                @if($content->category == 'news')
                                    <span class="badge bg-warning text-dark">{{ __('News') }}</span>
                                @elseif($content->category == 'disease')
                                    <span class="badge bg-danger">{{ __('Pathology') }}</span>
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
                            <td colspan="6" class="text-center">{{ __('No posts found.') }}</td>
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

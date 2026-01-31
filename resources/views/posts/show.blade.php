@extends('layouts.modern')

@section('title', $post->title . ' - MediConnect')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news') }}">{{ __('Medical News') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="blog-post">
                <h1 class="display-5 fw-bold mb-3 text-primary">{{ $post->title }}</h1>
                
                <div class="d-flex align-items-center mb-4 text-muted">
                    <div class="me-4">
                        <i class="bi bi-person-circle me-2"></i>
                        {{ $post->author->name ?? 'Admin' }}
                    </div>
                    <div class="me-4">
                        <i class="bi bi-calendar3 me-2"></i>
                        {{ \Carbon\Carbon::parse($post->published_date)->format('d/m/Y') }}
                    </div>
                    <div>
                        <i class="bi bi-folder2-open me-2"></i>
                        @if($post->category == 'news')
                            {{ __('News') }}
                        @elseif($post->category == 'disease')
                            {{ __('Disease Info') }}
                        @else
                            {{ $post->category }}
                        @endif
                    </div>
                </div>

                @if($post->image)
                    <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset($post->image) }}" class="img-fluid rounded mb-4 w-100 shadow-sm" alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
                @endif

                <div class="blog-post-content fs-5" style="line-height: 1.8; text-align: justify;">
                    {!! $post->content !!}
                </div>
            </article>

            <hr class="my-5">

            <!-- Author Bio (Optional/Placeholder) -->
            <!-- Comments Section (Optional/Placeholder) -->
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card card-shadow mb-4 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary">{{ __('Related Posts') }}</h5>
                </div>
                <div class="card-body">
                    @if(isset($related) && $related->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($related as $item)
                            <li class="mb-3">
                                <a href="{{ route('posts.detail', $item->id) }}" class="d-flex text-decoration-none text-dark">
                                    <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset($item->image ?? 'https://via.placeholder.com/80') }}" class="rounded me-3" width="80" height="60" style="object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1 small fw-bold">{{ Str::limit($item->title, 50) }}</h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->published_date)->format('d/m/Y') }}</small>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small">{{ __('No related posts available.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

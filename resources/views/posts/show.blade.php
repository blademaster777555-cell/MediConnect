@extends('layouts.modern')

@section('title', $post->title . ' - MediConnect')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Trang chủ') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news') }}">{{ __('Tin tức Y tế') }}</a></li>
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
                            {{ __('Tin tức') }}
                        @elseif($post->category == 'disease')
                            {{ __('Bệnh học') }}
                        @else
                            {{ $post->category }}
                        @endif
                    </div>
                </div>

                @if($post->image)
                    <img src="{{ $post->image }}" class="img-fluid rounded mb-4 w-100 shadow-sm" alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
                @endif

                <div class="blog-post-content fs-5" style="line-height: 1.8; text-align: justify;">
                    {!! nl2br(e($post->content)) !!}
                    {{-- Note: If content is WYSIWYG HTML, remove e() and nl2br() and just use {!! $post->content !!} --}}
                    {{-- Assuming simple text for now based on typical seeder, but if it's rich text, user might need to adjust. 
                       However, safely escaping is default. If the user edits via a rich text editor later, we should switch.
                       Let's check if 'content' field typically has HTML tags. The seeder usually puts plain text. 
                       I'll use {!! $post->content !!} but assume it might be raw html. 
                       Wait, to be safe against XSS if it's user input, but here it's Admin content. 
                       Admin content is usually trusted. 
                       Let's stick to safe display if unsure, but usually "Medical Content" implies formatted text.
                       I will check one content from DB if possible, but I can't.
                       I'll use {!! $post->content !!} assuming trusted admin input for rich text formatting.
                    --}}
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
                    <h5 class="mb-0 fw-bold text-secondary">{{ __('Bài viết liên quan') }}</h5>
                </div>
                <div class="card-body">
                    @if(isset($related) && $related->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($related as $item)
                            <li class="mb-3">
                                <a href="{{ route('posts.detail', $item->id) }}" class="d-flex text-decoration-none text-dark">
                                    <img src="{{ $item->image ?? 'https://via.placeholder.com/80' }}" class="rounded me-3" width="80" height="60" style="object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1 small fw-bold">{{ Str::limit($item->title, 50) }}</h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->published_date)->format('d/m/Y') }}</small>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small">{{ __('Không có bài viết liên quan.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

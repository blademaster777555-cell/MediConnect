@extends('layouts.modern')

@section('title', 'Medical News - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">
                <i class="bi bi-newspaper me-3"></i>{{ __('Medical News') }}
            </h1>
            <p class="lead text-muted">{{ __('Stay updated with the latest health and medical news') }}</p>
        </div>
    </div>

    <div class="row">
        @foreach($news as $article)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 card-shadow">
                <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset($article->image ?? 'https://via.placeholder.com/400x250') }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold">{{ $article->title }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($article->published_date)->format('d/m/Y') }}
                        </small>
                        <a href="{{ route('posts.detail', $article->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Read More') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
<x-app-layout>
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-3">{{ $post->title }}</h1>
                <p class="text-muted border-bottom pb-3">
                    <i class="bi bi-calendar3"></i> {{ $post->created_at->format('d/m/Y') }} 
                    | <i class="bi bi-tag"></i> {{ ucfirst($post->type) }}
                </p>

                @if($post->image)
                    <img src="{{ $post->image }}" class="w-100 rounded mb-4 shadow-sm" style="max-height: 400px; object-fit: cover;">
                @endif

                <div class="content fs-5 lh-lg text-justify">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">Bài viết liên quan</div>
                    <div class="list-group list-group-flush">
                        @foreach($related as $item)
                        <a href="{{ route('posts.detail', $item->slug) }}" class="list-group-item list-group-item-action py-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->image }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 text-dark small fw-bold">{{ Str::limit($item->title, 40) }}</h6>
                                    <small class="text-muted">{{ $item->created_at->format('d/m') }}</small>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
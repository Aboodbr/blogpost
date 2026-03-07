@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Latest Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Create Post
    </a>
</div>

<form method="GET" action="{{ route('posts.index') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search posts..." value="{{ request('search') }}">
        <button class="btn btn-outline-secondary bg-white text-dark" type="submit">
            <i class="bi bi-search"></i> Search
        </button>
    </div>
</form>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
    @forelse ($posts as $post)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                @if($post->image_url)
                    <img src="{{ $post->image_url }}" class="card-img-top object-fit-cover" alt="{{ $post->title }}" style="height: 200px;">
                @else
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-image fs-1 opacity-50"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-truncate">{{ $post->title }}</h5>
                    <p class="card-text text-muted small mb-2">
                        <i class="bi bi-person"></i> {{ $post->user->name ?? 'Unknown Author' }} |
                        <i class="bi bi-calendar3"></i> {{ $post->created_at->format('M d, Y') }}
                    </p>
                    <p class="card-text mb-4">{{ Str::limit($post->description, 100) }}</p>
                    
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary btn-sm rounded-pill px-3">Read More</a>
                        <span class="text-muted small">
                            <i class="bi bi-chat-dots"></i> {{ $post->comments_count }} Comments
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
            <h4 class="text-muted">No posts found</h4>
            @if(request('search'))
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary mt-3">Clear Search</a>
            @endif
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center">
    {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
</div>

@endsection
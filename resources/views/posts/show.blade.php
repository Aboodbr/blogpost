@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Posts
            </a>

            <div>
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-primary btn-sm me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete(this)">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <article class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            @if($post->image_url)
                <img src="{{ $post->image_url }}" class="card-img-top object-fit-cover w-100" alt="{{ $post->title }}" style="max-height: 400px;">
            @endif

            <div class="card-body p-5">
                <h1 class="card-title fw-bold mb-3">{{ $post->title }}</h1>

                <div class="d-flex align-items-center mb-4 text-muted border-bottom pb-3">
                    <div class="me-3">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <strong>{{ $post->user->name ?? 'Unknown Author' }}</strong>
                    </div>
                    <div>
                        <i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('F d, Y') }}
                        <span class="mx-2">&bull;</span>
                        <i class="bi bi-clock me-1"></i> {{ max(1, ceil(str_word_count($post->description) / 200)) }} min read
                    </div>
                </div>

                <div class="card-text fs-5" style="line-height: 1.8;">
                    {!! nl2br(e($post->description)) !!}
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-chat-dots me-2"></i> Comments ({{ $post->comments->count() }})
                </h4>

                <!-- Add Comment Form -->
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-5 bg-light p-4 rounded-3">
                    @csrf
                    <h5 class="mb-3">Leave a comment</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Comment <span class="text-danger">*</span></label>
                            <textarea name="content" rows="4" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4">Post Comment</button>
                        </div>
                    </div>
                </form>

                <!-- Comments List -->
                <div class="comments-list">
                    @forelse($post->comments->sortByDesc('created_at') as $comment)
                        <div class="d-flex mb-4 {{ !$loop->last ? 'border-bottom pb-4' : '' }}">
                            <div class="flex-shrink-0">
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold mb-1">{{ $comment->name }}
                                    @if($post->user_id == $comment->user_id && $comment->user_id)
                                        <span class="badge bg-primary ms-1" style="font-size: 0.7em;">Author</span>
                                    @endif
                                </h6>
                                <p class="text-muted small mb-2">{{ $comment->created_at->diffForHumans() }}</p>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-square text-secondary fs-2 mb-2 d-block opacity-50"></i>
                            <p>No comments yet. Be the first to share your thoughts!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(button) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endsection
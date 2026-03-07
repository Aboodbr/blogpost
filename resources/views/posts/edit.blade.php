@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h4 class="mb-0 fw-bold">Edit Post</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $post->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Post Image</label>

                        @if($post->image_url)
                            <div class="mb-3">
                                <p class="mb-1 text-muted small">Current Image:</p>
                                <img src="{{ $post->image_url }}" alt="Current post image" class="img-thumbnail rounded-3" style="max-height: 150px;">
                            </div>
                        @endif

                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Upload a new image to replace the current one. Supported: JPG, PNG, WEBP. Max: 2MB.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Post Creator</label>
                        <select name="post_creator" class="form-select @error('post_creator') is-invalid @enderror">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('post_creator', $post->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('post_creator') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
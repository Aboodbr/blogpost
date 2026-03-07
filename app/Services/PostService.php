<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostService
{
    /**
     * Store a new post.
     */
    public function storePost(array $data, ?UploadedFile $image = null): Post
    {
        if ($image) {
            $data['image'] = $image->store('posts', 'public');
        }

        return Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
            'image' => $data['image'] ?? null,
        ]);
    }

    /**
     * Update an existing post.
     */
    public function updatePost(Post $post, array $data, ?UploadedFile $image = null): Post
    {
        if ($image) {
            // Delete old image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $image->store('posts', 'public');
        }

        $post->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
            'image' => $data['image'] ?? $post->image,
        ]);

        return $post;
    }

    /**
     * Delete a post.
     */
    public function deletePost(Post $post): bool
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        return $post->delete();
    }
}

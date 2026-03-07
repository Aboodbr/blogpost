<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        $post->comments()->create([
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'user_id' => auth()->id() ?? null,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }
}

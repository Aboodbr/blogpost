<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $query = Post::with(['user'])->withCount('comments');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $posts = $query->latest()->paginate(10);
        
        return view('posts.index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user']);
        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', ['users' => $users]);
    }

    public function store(StorePostRequest $request)
    {
        $this->postService->storePost($request->validated(), $request->file('image'));
        return to_route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit', ['users' => $users, 'post' => $post]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->postService->updatePost($post, $request->validated(), $request->file('image'));
        return to_route('posts.show', $post->id)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->postService->deletePost($post);
        return to_route('posts.index')->with('success', 'Post deleted successfully.');
    }
}

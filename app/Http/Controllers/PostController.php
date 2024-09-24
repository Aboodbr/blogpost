<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index()
    {
        $postsFromDB=Post::all();
        
        return view('posts.index',['posts'=>$postsFromDB]);
    }
    public function show(Post $post)
    {
        // (name model name required parameter in route)
        return view('posts.show',['post'=>$post]);
    }
    public function create()
    {
        $users = User::all();
        return view('posts.create' ,['users'=>$users]);
    }
    public function store()
    {
        request()->validate([
            'title'=>['required','min:3'],
            'description'=>['required','min:6'],
            'post_creator'=>['required', 'exists:users,id']
        ]);
        $data=request()->all();
        $title=request()->title;
        $description=request()->description;
        $post_creator=request()->post_creator;
        Post::create([
            'title'=>$title,
            'description'=>$description,
            'user_id'=>$post_creator
        ]);
        return to_route('posts.index');
    }
    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit',['users'=>$users, 'post'=>$post]);
    }
    public function update($postId)
    {
        //1- get the user data

        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;

//        dd($title, $description, $postCreator);

        //2- update the submitted data in database
            //select or find the post
            //update the post data
        $singlePostFromDB = Post::find($postId);
        $singlePostFromDB->update([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator,
        ]);

//        dd($singlePostFromDB);

        //3- redirection to posts.show

        return to_route('posts.show', $postId);
    }    public function destroy(Post $post)
    {
        
        $post->delete();
        return to_route('posts.index',['post'=>$post]);   
    }

}

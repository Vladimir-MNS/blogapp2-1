<?php

namespace App\Http\Controllers;

use App\Mail\CreatePost;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $posts = Post::paginate(3);
        //$posts = Post::where('isPublished', true)->get();
        return view('pages.posts', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!Auth::check()) {
            return redirect('createpost')->withErrors('You have to be logged in');
        }
        $request->validate([
            'title' => 'required|string|min:5|max:255',
            'body' => 'required|string|min:10|max:5000'
        ]);

        $user = Auth::user();

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $user->id
        ]);


        $mailData = $post->only('title', 'body');
        Mail::to($user->email)->send(new CreatePost($mailData));
        return redirect('createpost')->with('status', 'Post successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        $post->comments = Comment::where('post_id',$id)->paginate(2);        
        return view('pages.post', compact('post'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createPost()
    {
        return view('pages.createpost');
    }
}

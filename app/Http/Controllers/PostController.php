<?php

namespace App\Http\Controllers;

use App\Models\Post; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'caption' => 'required', 
            'content' => 'required',
            'postpic' => ['required', 'image'], 
        ]);

        $user = AUth::user();
        $post = new Post();
        $imagePath = request('postpic')->store('uploads', 'public'); 

        $post->user_id = $user->id;
        $post->caption = request('caption');
        $post->content = request('content');
        $post->image = $imagePath;
        $saved = $post->save();

        if($saved){
            return redirect('/profile');
        }
        else{
            echo "<script>alert('Cannot save this post.')</script>";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($postId)
    {
        $post = Post::where('id', $postId)->first();
        $user = Auth::user();

        return view ('post.show', [
            'post' => $post,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {  
        return view ('post.edit',  compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId)
    {
        $request->validate([
            'caption' => 'required',
            'content' => 'required',
            'postpic' => ['required', 'image']
        ]);

        $post = Post::find($postId);
        if(!empty($post)){
            $post->caption = request('caption');
            $post->content = request('content');
            $imagePath = request('postpic')->store('uploads', 'public'); 
            $post->image = $imagePath;
            $updated  = $post->update();
            if($updated){
                return redirect('/profile')->with('success', 'Post has been updated successfully!');
            } 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        $post = Post::where('id', $postId)->first();
        $post->delete();

        return redirect('/profile');
    }
}

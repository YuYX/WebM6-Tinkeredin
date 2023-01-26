<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Post; 
use Illuminate\Http\Request;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
            'url'     => 'nullable',
            'content' => 'required',
            // 'postpic' => [File::image()->smallerThan(2*1024)],
            // 'postpics' => [File::image()->smallerThan(2*1024)],
            'postpic' => 'nullable', ['file', '200'],
            'postpics'=> 'nullable', ['file','200'],
        ]);

        $user = AUth::user();
        $post = new Post(); 
        
        // post_max_size and upload_max_filesize
        // post_max_size = 2M, 
        // upload_max_filesize = 8M,
        // dd(phpinfo());

        if($request->hasfile('postpic')){
            // $imagePath = request('postpic')->store('uploads', 'public');  
            // $imagePath = request('postpic')->store('images', 'public'); 

            // $imagefile = $request->file('postpic');
            // $imageName = time().$imagefile->getClientOriginalName();
            // $imagePath = 'images/' . $imageName;
            // Storage::disk('s3')->put($imagePath, file_get_contents($imagefile)); 

            $imagePath = $request->file('postpic')->store('images', 's3'); 
            Storage::disk('s3')->setVisibility($imagePath, 'public');

            $post->image = $imagePath;  
        }
         
        if($request->hasfile('postpics')){
            foreach($request->file('postpics') as $postpics_image){ 
                // $postpics_name = $postpics_image->store('uploads', 'public');  
                // $postpics_name = $postpics_image->store('images', 'public');  

                // $imagefile = $postpics_image;
                // $imageName = time().$imagefile->getClientOriginalName();
                // $postpics_name = 'images/' . $imageName;
                // Storage::disk('s3')->put($postpics_name, file_get_contents($imagefile)); 

                $postpics_name = $postpics_image->store('images', 's3'); 
                Storage::disk('s3')->setVisibility($postpics_name, 'public');

                $postpics_data[] = $postpics_name; 
            }
            
            $post->images = json_encode($postpics_data);  
        } 

        $post->user_id = $user->id;
        $post->caption = request('caption');
        $post->content = request('content');

        if($request->filled('url')) {
            $post->url = request('url');
        }
         
        // $post->image = $imagePath;
        
        $saved = $post->save();

        if($saved){
            return redirect('/profile');
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
            'url'     => 'nullable',
            'content' => 'required',
            // 'postpic' => [File::image()->smallerThan(2*1024)],
            // 'postpics' => [File::image()->smallerThan(2*1024)],
            'postpic' => 'nullable',  ['file', '200'],
            'postpics'=> 'nullable',  ['file', '200'],
        ]);

        $post = Post::find($postId);
        if(!empty($post)){
            $post->caption = request('caption');
            $post->content = request('content');

            if($request->hasfile('postpic')){
                // $imagePath = request('postpic')->store('uploads', 'public'); 
                // $imagePath = request('postpic')->store('images', 'public');  
                
                // $imagefile = $request->file('postpic');
                // $imageName = time().$imagefile->getClientOriginalName();
                // $imagePath = 'images/' . $imageName;
                // Storage::disk('s3')->put($imagePath, file_get_contents($imagefile)); 

                $imagePath = $request->file('postpic')->store('images', 's3'); 
                Storage::disk('s3')->setVisibility($imagePath, 'public');

                $post->image = $imagePath; 
            }
            
            if($request->hasfile('postpics')){
                foreach($request->file('postpics') as $postpics_image){ 
                    // $postpics_name = $postpics_image->store('uploads', 'public'); 
                    // $postpics_name = $postpics_image->store('images', 'public'); 
                    
                    // $imagefile = $postpics_image;
                    // $imageName = time().$imagefile->getClientOriginalName();
                    // $postpics_name = 'images/' . $imageName;
                    // Storage::disk('s3')->put($postpics_name, file_get_contents($imagefile)); 

                    $postpics_name = $postpics_image->store('images', 's3'); 
                    Storage::disk('s3')->setVisibility($postpics_name, 'public');
                    
                    $postpics_data[] = $postpics_name;
                }
                
                $post->images = json_encode($postpics_data);  
            } 

            if($request->filled('url')) {
                $post->url = request('url');
            }
// ;
            // $post->image = $imagePath;  
            $updated  = $post->update();
            if($updated){
                return redirect('/profile');  
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

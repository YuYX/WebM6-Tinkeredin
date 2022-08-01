<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Post;
use Illuminate\Console\View\Components\Alert;

class ProfileController extends Controller
{
    public function edit()
    { 
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('editProfile', [ 
            'profile' => $profile,
        ]);
    }

    public function postEdit($id)
    {
       $data = request()->validate([
           'description' => 'required',
           'profilepic' => 'image',
           'backpic' => 'image',
       ]);
       // Load the existing profile
       $user = Auth::user();
     
       // Find the corresponding profile with the $id,
       // Create a new profile if its empty
       $profile = Profile::find($id);
       if(empty($profile)){
           $profile = new Profile();
           $profile->user_id = $user->id;
       }

       $profile->description = request('description');

       // Save the new profile pic... if there is one in the request()!
       if (request()->has('profilepic')) {
           $imagePath = request('profilepic')->store('uploads', 'public');
           $profile->image = $imagePath;
       }

       if (request()->has('backpic')) {
            $backImagePath = request('backpic')->store('uploads', 'public');
            $profile->back_image = $backImagePath;
        }

       // Now, save it all into the database
       $updated = $profile->save();
       if ($updated) { 
           return redirect('/profile');
       }
    }

    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $numPosts = Post::where('user_id',$user->id)->count();
        return view('profile', [
            'user' => Auth::user(),
            'profile' => $profile,
            'posts' => $posts,
            'numPosts' => $numPosts,
        ]);
    }
    /*public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $post = Post::where('user_id', 
        $user->id)->orderBy('created_at', 'desc')->get();
        $numPosts = Post::where('user_id',$user->id)->count();
        return view('profile', [
            'user' => Auth::user(),
            'profile' => $profile,
            'posts' => $post,
            'numPosts' => $numPosts,
        ]);
    }*/

    public function create()
    {
        return view('createProfile');
    } 
    
    public function postCreate()
    {
        $data = request()->validate([
            'description' => 'required',
            'profilepic' => ['required', 'image'],
            'backpic' => ['required', 'image'],
        ]);

        $imagePath = request('profilepic')->store('uploads', 'public');
        $backImagePath = request('backpic')->store('uploads', 'public');

        $user = Auth::user();
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->description = request('description');
        $profile->image = $imagePath;
        $profile->back_image = $backImagePath;
        $saved = $profile->save();

        if($saved){
            return redirect('/profile');
        }
    } 
}

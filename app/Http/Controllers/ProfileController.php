<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Post; 
use App\Models\Relation;
use App\Models\User;
use Illuminate\Console\View\Components\Alert;

class ProfileController extends Controller
{
    //--------------------------------------------------------------------------
    public function edit()
    { 
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('editProfile', [ 
            'profile' => $profile,
        ]);
    }
    //--------------------------------------------------------------------------
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
    //--------------------------------------------------------------------------
    public function index()
    {
        $user = Auth::user(); 
        $profile = Profile::where('user_id', $user->id)->first();   

        $posts = Post::leftJoin('profiles', 'posts.user_id', '=', 'profiles.user_id')   
                        ->leftJoin('users', 'posts.user_id', '=', 'users.id')
                        ->select('profiles.image as profile_image', 
                                 'profiles.back_image as profile_back', 
                                 'posts.*', 'users.name as user_name')
                        ->whereIn('posts.user_id', function($query) use ($user){
                        $query->select('following_id')
                                ->from('relations')
                                ->where([ ['follower_id', $user->id],
                                          ['status', '=', 'Following']
                                        ] );
                        })
                        ->orWhere('posts.user_id', $user->id)  
                        ->orderBy('posts.created_at', 'desc')
                        ->get();

        // $numFollowings = Relation::where('following_id', $user->id)->count();
        // $numFollowers  = Relation::where('follower_id', $user->id)->count();

        $relations_4_following = Relation::where('relations.follower_id', $user->id)
                                    ->where('relations.status', '=', 'Following')
                                    ->select('relations.following_id')->get();
        $users_i_follow  = User::whereIn('users.id', $relations_4_following)->get(); 
        
        $relations_4_request_sent = Relation::where('relations.follower_id', $user->id)
                                    ->where('relations.status', '=', 'Pending')
                                    ->select('relations.following_id')->get();
        $users_request_sent  = User::whereIn('users.id', $relations_4_request_sent)->get();

        $relations_4_followed = Relation::where('relations.following_id', $user->id)
                                    ->where('relations.status', '=', 'Following')
                                    ->select('relations.follower_id')->get();
        $users_follow_me = User:: whereIn('users.id', $relations_4_followed)->get();

        $relations_4_request_received = Relation::where('relations.following_id', $user->id)
                                    ->where('relations.status', '=', 'Pending')
                                    ->select('relations.follower_id')->get();
        $users_request_received = User:: whereIn('users.id', $relations_4_request_received)->get();
        
        $numPosts = Post::where('user_id',$user->id)->count();
        return view('profile', [
            'user' => Auth::user(),
            'profile' => $profile,
            'posts' => $posts,
            'numPosts' => $numPosts,
            // 'numFollowings' => $numFollowings,
            // 'numFollowers' => $numFollowers,
            'users_i_follow' => $users_i_follow,
            'users_follow_me' => $users_follow_me,
            'users_request_sent' => $users_request_sent,
            'users_request_received' => $users_request_received,
        ]);
    }
    //--------------------------------------------------------------------------
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
    //--------------------------------------------------------------------------
    public function create()
    {
        return view('createProfile');
    } 
    //--------------------------------------------------------------------------
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

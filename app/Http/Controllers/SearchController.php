<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Post;
use App\Models\Profile;
use App\Models\Relation;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function request_sent(Request $request){
        $user = AUth::user(); 

        $relation_all_i_follow = Relation::where('follower_id', $user->id) 
                    ->where('status', '=', 'Pending')
                    ->get();
         
        $search_relation_list = array();
        foreach($relation_all_i_follow as $relation_item ){
            $search_relation_list[] = $relation_item->following_id;
        } 

        $users_request_sent = User::whereIn('users.id', $search_relation_list)
                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')  
                    ->select('users.*', 'profiles.image', 'profiles.description') 
                    ->get();     
                  
        return view('friend', 
                    ['users_search' => $users_request_sent,
                     'login_user' => $user,  
                     'user_type' => 'request_sent',
                    ]);
    }
    //-------------------------------------------------------------------------------------------
    public function request_received(Request $request){
        $user = AUth::user(); 

        $relation_all_follow_me = Relation::where('following_id', $user->id) 
                    ->where('status','=', 'Pending')
                    ->get();
         
        $search_relation_list = array();
        foreach($relation_all_follow_me as $relation_item ){
            $search_relation_list[] = $relation_item->follower_id;
        } 

        $users_request_received = User::whereIn('users.id', $search_relation_list)
                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')  
                    ->select('users.*', 'profiles.image', 'profiles.description') 
                    ->get();     
                  
        return view('friend', 
                    ['users_search' => $users_request_received,
                     'login_user' => $user,  
                     'user_type' => 'request_received',
                    ]);
    }
    //-------------------------------------------------------------------------------------------
    public function search_follower(Request $request){ 
        $user = AUth::user(); 

        $relation_all_follow_me = Relation::where('following_id', $user->id) 
                    ->where('status','Following')
                    ->get();
         
        $search_relation_list = array();
        foreach($relation_all_follow_me as $relation_item ){
            $search_relation_list[] = $relation_item->follower_id;
        } 

        $users_follow_me = User::whereIn('users.id', $search_relation_list)
                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')  
                    ->select('users.*', 'profiles.image', 'profiles.description') 
                    ->get();     
                  
        return view('friend', 
                    ['users_search' => $users_follow_me,
                     'login_user' => $user,  
                     'user_type' => 'users_following_me',
                    ]);
    }
    //-------------------------------------------------------------------------------------------
    public function search_following(Request $request){ 
        $user = AUth::user(); 

        $relation_all_i_follow = Relation::where('follower_id', $user->id) 
                    ->where('status','Following')
                    ->get();
         
        $search_relation_list = array();
        foreach($relation_all_i_follow as $relation_item ){
            $search_relation_list[] = $relation_item->following_id;
        } 

        $users_i_follow = User::whereIn('users.id', $search_relation_list)
                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')  
                    ->select('users.*', 'profiles.image', 'profiles.description') 
                    ->get();     
                  
        return view('friend', 
                    ['users_search' => $users_i_follow,
                     'login_user' => $user,  
                     'user_type' => 'users_i_following',
                    ]);
    }
    //-------------------------------------------------------------------------------------------
    public function search(Request $request){     
        $data = request()->validate([
            'user-search'   => 'required',  
        ]);

        $user = AUth::user();
        $search = $request->input('user-search');    

        $users = User::leftJoin('profiles', 'profiles.user_id', '=', 'users.id')  
                    ->select('users.*', 'profiles.image', 'profiles.description',  )
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")    
                    ->get();      
       
        $search_user_list = array();
        foreach($users as $user_item ){
            $search_user_list[] = $user_item->id;
        }
        $relations = Relation::whereIn('relations.follower_id' , $search_user_list)
                    ->orWhereIn('relations.following_id', $search_user_list)
                    ->get();

        $numResult = $users->count();
        // $numResult = $relations->count();  
        
        // return view('search', compact('users'));
        return view('search', ['users' => $users, 
                               'relations'=>$relations,
                               'search_keyword' => $search,
                               'numResult' => $numResult,
                               'login_user' => $user
                              ]);
    }  
    //-------------------------------------------------------------------------------------------
    public function follow(Request $request)  
    {   
        $relation_search = Relation::where('relations.follower_id', '=', $request->follower_id)
                                ->where('relations.following_id', '=', $request->following_id )
                                ->first(); 
                                     
        if($relation_search != null)     
        { 
            $saved = $relation_search->update(['status'=>$request->status]);
        }      
        else
        {
            $relation = new Relation(); 

            $relation->follower_id = $request->follower_id;
            $relation->following_id = $request->following_id; 
            $relation->status = $request->status; 
            $saved = $relation->save();
        }     

        if($saved){ 
            return back();
        }  
    }
    //-------------------------------------------------------------------------------------------
}

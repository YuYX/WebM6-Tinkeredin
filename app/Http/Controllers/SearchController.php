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
}

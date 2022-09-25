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

        $user = AUth::user();
        $search = $request->input('user-search');   
        // $users = User::query()
        //             ->where('name', 'LIKE', "%{$search}%")
        //             ->orWhere('email', 'LIKE', "%{$search}%") 
        //             ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id') 
        //             ->leftJoin('relations', 'relations.following_id', '=', 'users.id')  
        //             ->get();     

        $users = User::leftJoin('profiles', 'profiles.user_id', '=', 'users.id') 
                    ->leftJoin('relations', 'follower_id', '=', 'users.id')   
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")    
                    ->get();     

        $numResult = 0;
        foreach($users as $user_item)
        {
            if($user_item->following_id == null or $user_item->following_id == $user->id)
            {
                $numResult++;
            }
        }

        // $numResult = $users->count();
        
        // return view('search', compact('users'));
        return view('search', ['users' => $users, 
                               'search_keyword' => $search,
                               'numResult' => $numResult,
                               'login_user' => $user
                              ]);
    } 
}

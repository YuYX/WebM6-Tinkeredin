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
                    // ->leftJoin('relations', 'follower_id', '=', 'users.id')   
                    ->select('users.*', 'profiles.image', 'profiles.description', 
                            //  'relations.follower_id', 'relations.following_id', 'relations.status'
                            )
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")    
                    ->get();     
 

        // $numResult = 0;
        // foreach($users as $user_item)
        // {
        //     if($user_item->following_id == null or $user_item->following_id == $user->id)
        //     {
        //         $numResult++;
        //     }
        // }

       
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

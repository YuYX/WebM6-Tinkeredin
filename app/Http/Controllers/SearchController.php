<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Post;
use App\Models\Profile;
use App\Models\Relation;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request){   

        $search = $request->input('user-search');   
        $users = User::query()
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->join('profiles', 'users.id', '=', 'profiles.user_id')  
                    ->leftJoin('relations', 'users.id', '=', 'relations.following_id')
                    ->get();    
        $numResult = $users->count();
        
        // return view('search', compact('users'));
        return view('search', ['users' => $users, 
                               'search_keyword' => $search,
                               'numResult' => $numResult
                              ]);
    }
}

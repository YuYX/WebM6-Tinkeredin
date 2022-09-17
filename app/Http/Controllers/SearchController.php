<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request){   

        $search = $request->input('user-search');   
        $users = User::query()
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->get();        
        return view('search', compact('users'));
    }
}

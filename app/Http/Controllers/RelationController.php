<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;

use App\Models\Relation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;  

class RelationController extends Controller
{ 
    public function index(Request $request) //Form Submit
    {
        $data = request()->validate([
            'follower_id'   => 'required', 
            'following_id'  => 'required',  
            'status'        => 'nullable',
            // 'block'         => 'nullable',
        ]);
 
        $relation = new Relation();
        $relation->follower_id  = request('follower_id');
        $relation->following_id  = request('following_id');

        $relation->status = $request->filled('status') ? request('status') : "Pending"; 
        // $relation->block = $request->filled('block') ? request('block') : "false"; 

        $saved = $relation->save();

        if($saved){
            return redirect('/search');
        } 
    }  

    public function follow(Request $request)  
    {   
        $relation_search = Relation::where('relations.follower_id', '=', $request->follower_id)
                                     ->where('relations.following_id', '=', $request->following_id )->first(); 
                                     
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
}

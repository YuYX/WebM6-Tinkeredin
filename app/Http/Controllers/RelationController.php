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

    public function follow(Request $request, $follow_array)  
    {
        $relation = new Relation(); 

        $decodedArray = json_decode($follow_array);

        $relation->follower_id = $decodedArray['follower_id'];
        $relation->following_id = $decodedArray['following_id']; 
        $relation->status = $decodedArray['status']; 
        
        $saved = $relation->save();

        if($saved){
            return redirect('/search');
        } 
    }
}

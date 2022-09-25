<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;

use App\Models\Relation;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
 
use Symfony\Component\Console\Input\Input as InputInput;

class RelationController extends Controller
{ 
    public function index(Request $request) //Form Submit
    {
        $data = request()->validate([
            'follower_id'   => 'required', 
            'following_id'  => 'required',  
            'status'        => 'nullable',
            'block'         => 'nullable',
        ]);
 
        $relation = new Relation();
        $relation->follower_id  = request('follower_id');
        $relation->following_id  = request('following_id');

        $relation->status = $request->filled('status') ? request('status') : "Pending"; 
        $relation->block = $request->filled('block') ? request('block') : "false"; 

        $saved = $relation->save();

        if($saved){
            return redirect('/search');
        } 
    } 

    public function follow_request(Request $request)  
    {
        $relation = new Relation();
        $relation->follower_id = $request->Input('follower_id');
        $relation->following_id = $request->Input('following_id');

        $relation->status = $request->has('status') ? $request->Input('status') : "Pending";
        $relation->block = $request->has('block') ? $request->Input('block') : "false"; 
        
        $saved = $relation->save();

        if($saved){
            return redirect('/search');
        } 
    }
}

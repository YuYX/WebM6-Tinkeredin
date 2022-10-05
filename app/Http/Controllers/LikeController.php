<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Like;

class LikeController extends Controller
{
    public function update(Request $request){
        $data = request()->validate([
                    'like_post_id' => 'nullable',
                    'like_user_id' => 'nullable',
                    'like' => 'nullable',
                ]);

        $like_post_id = request('like_post_id');
        $like_user_id = request('like_user_id');
        $like = request('like');
        $existed_like = Like::where('like_post_id', $like_post_id)
                    ->where('like_user_id', $like_user_id)->first();
        if($existed_like != null){
            if($existed_like->like == $like){ //Actually this is to cancel current 'like' status.
                $like = "none";
            }
            $saved = $existed_like->update(['like'=>$like]);
        }else {
            $new_like = new Like();
            $new_like->like_post_id = $like_post_id;
            $new_like->like_user_id = $like_user_id;
            $new_like->like = $like;
            $saved = $new_like->save();
        } 

        if($saved){ 
             return back();  
        }
    }
}

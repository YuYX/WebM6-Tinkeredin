<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Support\Facades\View;
 
use App\Models\Post;  
use App\Models\Like; 

class LikeController extends Controller
{
    public function refresh(Request $request){
       
        $data = request()->validate([
            'like_post_id' => 'nullable',
            'like_user_id' => 'nullable',
            'like' => 'nullable',
        ]);

        $like_post_id = request('like_post_id');
        $like_user_id = request('like_user_id');
        $like = request('like');

        $updated_like = Like::where('like_post_id', $like_post_id)
                        ->where('like_user_id', $like_user_id)->first();
        if($updated_like != null){
            if($updated_like->like == $like){ //Actually this is to cancel current 'like' status.
                $like = "none";
            }
            $saved = $updated_like->update(['like'=>$like]);
        }else {
            $updated_like = new Like();
            $updated_like->like_post_id = $like_post_id;
            $updated_like->like_user_id = $like_user_id;
            $updated_like->like = $like;
            $saved = $updated_like->save();
        } 

        $post = Post::where('posts.id',$like_post_id)->first();
         
        $likes_4_posts = Like::where('like_post_id', $like_post_id)
                            ->leftJoin('users','likes.like_user_id', '=', 'users.id')
                            ->select('likes.*', 'users.name as like_user_name')
                            ->get();  
                   
        if($saved){
            return( [
                'user_id' => $like_user_id, 
                'post_id' => $like_post_id, 
                'likes_on_post' =>$likes_4_posts,
            ]);
        }else{
            return "Failed to updated.";
        }
    }

    public function update(Request $request){
        $data = request()->validate([
                    'like_post_id' => 'nullable',
                    'like_user_id' => 'nullable',
                    'like' => 'nullable',
                ]); 

        $like_post_id = request('like_post_id');
        $like_user_id = request('like_user_id');
        $like = request('like');  

        $updated_like = Like::where('like_post_id', $like_post_id)
                        ->where('like_user_id', $like_user_id)->first();
        if($updated_like != null){
            if($updated_like->like == $like){ //Actually this is to cancel current 'like' status.
                $like = "none";
            }
            $saved = $updated_like->update(['like'=>$like]);
        }else {
            $updated_like = new Like();
            $updated_like->like_post_id = $like_post_id;
            $updated_like->like_user_id = $like_user_id;
            $updated_like->like = $like;
            $saved = $updated_like->save();
        } 

        if($saved){  
            return back(); 
        }
    }
}

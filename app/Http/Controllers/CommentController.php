<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 

use App\Models\Comment; 
use App\Models\User;
use App\Models\Profile;

class CommentController extends Controller
{
    // public function store($comment_post_id, $comment_user_id){
    public function store(Request $request){
        $data = request()->validate([ 
            'input-comment-post-id' => 'required',
            'input-comment-user-id' => 'required',
            'input-comment' => 'required',
        ]);
 
        $comment_post_id = request('input-comment-post-id'); 
        $comment_user_id = request('input-comment-user-id'); 
        $comment = request('input-comment'); 

        $new_comment = new Comment();
        $new_comment->comment_post_id = $comment_post_id;
        $new_comment->comment_user_id = $comment_user_id;
        $new_comment->comment = $comment;

        $save = $new_comment->save();
        if($save){ 
            $user = User::where('id', $comment_user_id)->first();
            $profile = Profile::where('user_id', $comment_user_id)->first(); 

            $new_comments = Comment::where('comment_post_id', $comment_post_id)->get();

            return ([
                'comment_user_name' => $user->name,
                'comment_user_profile_image' => $profile->image,
                'comment_total' => $new_comments->count(),
                'comment' => $comment,
            ]);
        }
    }

    public function show($comment_post_id){  

        $comments_4_posts = Comment::whereIn('comment_post_id', $comment_post_id)
        ->leftJoin('users', 'comments.comment_user_id', '=', 'users.id')
        ->leftJoin('profiles', 'comments.comment_user_id', '=', 'profiles.user_id')
        ->select('comments.*', 'users.name as comment_user_name', 'profiles.image as profile_image')
        ->get();

        return([
            'comment_post_id' => $comment_post_id,
            'comments_on_post' => $comments_4_posts,
        ]);
    }

    public function destroy($comment_id){
        $comment = Comment::where('id', $comment_id)->first();
        $comment->delete();
    }
}

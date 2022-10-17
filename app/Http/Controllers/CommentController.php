<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 

use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request){
        $data = request()->validate([
            'comment_post_id' => 'required',
            'comment_user_id' => 'required',
            'comment' => 'required',
        ]);

        $comment_post_id = request('comment_post_id');
        $comment_user_id = request('comment_user_id');
        $comment = request('comment');

        $new_comment = new Comment();
        $new_comment->comment_post_id = $comment_post_id;
        $new_comment->comment_user_id = $comment_user_id;
        $new_comment->comment = $comment;

        $save = $new_comment->save();
        if($save){
            return ([
                'comment_post_id' => $comment_post_id,
                'comment_user_id' => $comment_user_id,
                'comment' => $comment,
            ]);
        }
    }

    public function show($comment_post_id){ 
        $comments = Comment::where('comment_post_id', $comment_post_id)
                    ->get();

        return([
            'comment_post_id' => $comment_post_id,
            'comments' => $comments,
        ]);
    }

    public function destroy($comment_id){
        $comment = Comment::where('id', $comment_id)->first();
        $comment->delete();
    }
}

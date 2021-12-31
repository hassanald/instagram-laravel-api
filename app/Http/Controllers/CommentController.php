<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{


    public function store(Request $request , $id)
    {
        $validation = $request->validate([
            'comment_text' => 'required|string|max:100'
        ]);

        $post = Post::find($id);

        if (!$post){

            return response()->json(['message' => 'There is no post with id: '.$id]);
        }else{

            $comment = $post->comments()->create([
                'user_id' => Auth::user()->id,
                'comment_text' => $request->comment_text
            ]);

            return response()->json(['data' => $comment]);
        }
    }


    public function show($id)
    {
        $post = Post::find($id);

        if (!$post){

            return response()->json(['message' => 'There is no post with id: '.$id]);
        }else{

            $comments = $post->comments;
            if ($comments->isEmpty()){

                return response()->json(['message' => 'This post has no comments']);
            }else {

                return response()->json(['data' => $comments]);
            }
        }
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment){

            return response()->json(['message' => 'There is no comment with id: '.$id]);
        }else{

            $comment->delete();

            return response()->json(['message' => 'The comment has been deleted']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{

    public function likePost($id){

        $post = Post::find($id);
        $authUser = Auth::user();
        if (!$post){

            return response()->json(['message' => 'There is no post with id: '.$id]);
        } else {
            if (DB::table('likes')->where('user_id' , '=' , $authUser->id)
                ->where('likeable_type' , '=' , 'App\Models\Post')
                ->where('likeable_id' , '=' , $id)->exists()){

                return response()->json(['message' => 'The post was liked before']);
            } else {

                $like = $post->likes()->create([
                    'user_id' => $authUser->id
                ]);
                return response()->json(['message' => 'Liked' , 'data' => $like]);
            }
        }
    }

    public function unLikePost($id){

        $post = Post::find($id);
        $authUser = Auth::user();
        if (!$post){

            return response()->json(['message' => 'There is no post with id: '.$id]);
        } else {
            if (DB::table('likes')->where('user_id' , '=' , $authUser->id)
                ->where('likeable_type' , '=' , 'App\Models\Post')
                ->where('likeable_id' , '=' , $id)->exists()){

                $like = $post->likes()->where('user_id' , '=' , $authUser->id)->first();
                $like->delete();

                return response()->json(['message' => 'Unliked' , 'data' => $like]);
            } else {

                return response()->json(['message' => 'You didnt like this post']);
            }
        }
    }

    public function mostPostLiked(){

        $postLikes = DB::table('likes')
            ->select('likeable_id' , DB::raw('count(likeable_id) as likes'))
            ->where('likeable_type' , '=' , 'App\Models\Post')
            ->groupBy('likeable_id')
            ->orderBy('likes' , 'DESC')->get();

        return response()->json(['data' => $postLikes]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function searchWithName($name){

        $users = User::where('name' , 'LIKE' , '%'.$name.'%')->get();
        if ($users->isEmpty()){

            return response()->json(['message' => 'There is no user with name: '.$name]);
        }else{

            return response()->json(['data' => $users]);
        }
    }

    public function usersPost($name){

        $user = User::where('name' , 'LIKE' , '%'.$name.'%')->first();
        if(!$user){

            return response()->json(['message' => 'There is no user with name: '.$name]);

        }else {
            $posts = $user->posts;
            if ($posts->isEmpty()){

                return response()->json(['messsage' => 'There is no post for user with name: '.$name]);
            }else{

                return response()->json(['data' => $posts]);
            }
        }
    }

    public function followMethod($id){

        $user = User::find($id);
        $authUser = Auth::user();
        $authUserFollowings = DB::table('following')->select('following_id as followings')
            ->where('follower_id' , '=' , $authUser->id)
            ->groupBy('following_id')->get();

        if (!$user){

            return response()->json(['message' => 'There is no user with id: '.$id]);
        }else{
            if($authUserFollowings->contains('followings' , '=' , $id)){

                return response()->json(['message' => 'Currently the user is in your following list']);
            }elseif($authUser->id == $id) {

                return response()->json(['message' => 'You cant follow yourself!']);
            }else{

                $authUser->followings()->attach($user);
                return response()->json(['message' => 'Followed']);
            }

        }
    }

    public function UnfollowMethod($id){

        $user = User::find($id);
        $authUser = Auth::user();
        $authUserFollowings = DB::table('following')->select('following_id as followings')
            ->where('follower_id' , '=' , $authUser->id)
            ->groupBy('following_id')->get();

        if (!$user){

            return response()->json(['message' => 'There is no user with id: '.$id]);
        }else{
            if ($authUserFollowings->contains('followings' , '=' , $id)){

                $authUser->followings()->detach($user);
                return response()->json(['message' => 'Unfollowed']);
            }elseif ($authUser->id == $id){

                return response()->json(['message' => 'You cant unfollow yourself!']);
            }else{

                return response()->json(['message' => 'The user is not in your following list']);
            }
        }
    }

    public function userFollowings($id){

        $user = User::find($id);

        if (!$user){

            return response()->json(['message' => 'There is no user with id: '.$id]);
        }else{

            $userFollowings = $user->followings()->orderBy('following_id')->get();
            if ($userFollowings->isEmpty()){

                return response()->json(['message' => 'The user does not have any following']);
            }else {
                return response()->json(['data' => $userFollowings]);
            }
        }
    }

    public function userFollowers($id){

        $user = User::find($id);

        if (!$user){

            return response()->json(['message' => 'There is no user with id: '.$id]);
        }else {

            $userFollowers = $user->follower()->orderBy('follower_id')->get();
            if ($userFollowers->isEmpty()) {

                return response()->json(['message' => 'The user does not have any follower']);
            } else {

                return response()->json(['data' => $userFollowers]);
            }
        }
    }
}

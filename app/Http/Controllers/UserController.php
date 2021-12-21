<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
